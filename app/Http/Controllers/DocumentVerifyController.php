<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\QrTokenService;
use App\Services\UserDocumentService;
use App\Support\VerificationCode;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class DocumentVerifyController extends Controller
{
    public function __construct(private QrTokenService $qrTokens)
    {
    }

    public function show(Request $request): View
    {
        $qr = $request->query('qr');
        $autoVerify = is_string($qr) && $qr !== '';

        return view('documents.verify', [
            'authCode' => auth()->user()?->verification_code,
            'prefillQr' => $qr,
            'autoVerifyQr' => $autoVerify,
        ]);
    }

    /** Photo titulaire pour les agents (jeton QR encore valide). */
    public function photo(Request $request, UserDocumentService $documents): BinaryFileResponse|Response
    {
        $plain = $this->qrTokens->extractPlainToken((string) $request->query('qr', ''));
        abort_unless($plain !== '', 404);

        $record = $this->qrTokens->findActiveTokenRecord($plain);
        abort_unless($record, 403);

        $path = $documents->cardPhotoPath($record->user);
        abort_unless($path, 404);

        return response()->file($documents->absolutePath($path));
    }

    public function verify(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'verification_code' => ['nullable', 'string', 'max:500'],
            'qr_token' => ['nullable', 'string', 'max:500'],
        ]);

        $qrInput = trim((string) ($validated['qr_token'] ?? $validated['verification_code'] ?? ''));

        if ($qrInput !== '' && $this->looksLikeQrToken($qrInput)) {
            $result = $this->qrTokens->verify($qrInput);

            if ($result !== null) {
                return response()->json($result);
            }
        }

        if ($qrInput === '') {
            return response()->json([
                'found' => false,
                'message' => __('verify.code_required'),
            ], 422);
        }

        $code = VerificationCode::normalize($qrInput);
        $user = User::query()
            ->with('licenseSummary')
            ->where('verification_code', $code)
            ->first();

        if (! $user) {
            return response()->json([
                'found' => false,
                'message' => __('verify.not_found'),
            ]);
        }

        return response()->json($this->qrTokens->verificationPayloadForUser($user, qrVerified: false));
    }

    private function looksLikeQrToken(string $input): bool
    {
        if (str_starts_with(trim($input), '{')) {
            return true;
        }

        if (preg_match('/TOKEN-[A-Z0-9]+/i', $input)) {
            return true;
        }

        if (str_contains($input, 'midgt_license') || str_contains($input, '"t"')) {
            return true;
        }

        if (str_contains($input, '?qr=') || str_contains($input, '/documents/verify')) {
            return true;
        }

        return str_starts_with(trim($input), 'http');
    }
}
