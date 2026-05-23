<?php

namespace App\Http\Controllers;

use App\Services\PortalDashboardService;
use App\Services\QrTokenService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LicenceQrController extends Controller
{
    public function __construct(
        private PortalDashboardService $portal,
        private QrTokenService $qrTokens,
    ) {
        $this->middleware('auth');
    }

    public function show(): View
    {
        $user = auth()->user();
        $this->portal->ensureProvisioned($user);

        return view('licence.qr', [
            'user' => $user,
            'license' => $user->licenseSummary,
            'ttlSeconds' => $this->qrTokens->ttlSeconds(),
            'refreshBefore' => (int) config('dgt_qr.refresh_before_seconds', 15),
        ]);
    }

    public function generate(Request $request): JsonResponse
    {
        $user = auth()->user();
        $this->portal->ensureProvisioned($user);

        $license = $user->licenseSummary;

        if (! $license || ! $license->isPublishedForClient()) {
            return response()->json([
                'error' => __('portal.qr.no_license'),
            ], 422);
        }

        return response()->json($this->qrTokens->generate($user));
    }
}
