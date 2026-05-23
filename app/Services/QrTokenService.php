<?php

namespace App\Services;

use App\Models\LicenseSummary;
use App\Models\QrToken;
use App\Models\User;
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class QrTokenService
{
    public function ttlSeconds(): int
    {
        return max(60, (int) config('dgt_qr.ttl_seconds', 180));
    }

    /**
     * Génère un QR dynamique : invalide les tokens actifs, crée un nouveau jeton signé.
     *
     * @return array{
     *     plain_token: string,
     *     payload: string,
     *     expires_at: string,
     *     expires_in: int,
     *     qr_svg: string,
     *     verify_url: string
     * }
     */
    public function generate(User $user): array
    {
        QrToken::query()
            ->where('user_id', $user->id)
            ->where('expires_at', '>', now())
            ->where('used', false)
            ->delete();

        $plain = $this->makePlainToken();
        $expiresAt = now()->addSeconds($this->ttlSeconds());
        $verifyUrl = portal_route('documents.verify', ['qr' => $plain]);

        QrToken::create([
            'user_id' => $user->id,
            'token' => $this->hashToken($plain),
            'expires_at' => $expiresAt,
            'used' => false,
        ]);

        // URL (pas du JSON) : au scan, le téléphone ouvre la page de vérification miDGT.
        $svg = (string) QrCode::format('svg')
            ->size(280)
            ->margin(1)
            ->errorCorrection('M')
            ->generate($verifyUrl);

        return [
            'plain_token' => $plain,
            'payload' => $verifyUrl,
            'expires_at' => $expiresAt->toIso8601String(),
            'expires_in' => $expiresAt->diffInSeconds(now()),
            'qr_svg' => $svg,
            'verify_url' => $verifyUrl,
        ];
    }

    /**
     * Vérifie un token QR (saisie manuelle ou scan).
     *
     * @return array{found: bool, message?: string, holder?: string, nie?: string, dossier_number?: string, license_valid_until?: string, points?: int, license_status?: string, license_status_label?: string, verified_at?: string}|null
     */
    public function verify(string $input): ?array
    {
        $plain = $this->extractPlainToken($input);

        if ($plain === '') {
            return null;
        }

        $record = $this->findActiveTokenRecord($plain);

        if (! $record) {
            $stale = QrToken::query()->where('token', $this->hashToken($plain))->first();
            if ($stale?->used && config('dgt_qr.single_use', false)) {
                return ['found' => false, 'message' => __('verify.qr_used')];
            }
            if ($stale?->expires_at?->isPast()) {
                return ['found' => false, 'message' => __('verify.qr_expired')];
            }

            return ['found' => false, 'message' => __('verify.qr_not_found')];
        }

        if (config('dgt_qr.single_use', false)) {
            $record->forceFill([
                'used' => true,
                'used_at' => now(),
            ])->save();
        }

        return $this->verificationPayloadForUser($record->user, qrVerified: true, qrPlainForPhoto: $plain);
    }

    /**
     * @return array<string, mixed>
     */
    public function verificationPayloadForUser(User $user, bool $qrVerified = false, ?string $qrPlainForPhoto = null): array
    {
        $license = $user->licenseSummary;
        $status = $this->licenseStatus($license);
        $photoUrl = null;

        if ($qrPlainForPhoto !== null && $qrPlainForPhoto !== ''
            && app(UserDocumentService::class)->cardPhotoPath($user)) {
            $photoUrl = portal_route('documents.verify.photo', ['qr' => $qrPlainForPhoto]);
        }

        return [
            'found' => true,
            'holder' => trim(collect([$user->first_name, $user->last_name])->filter()->join(' ')) ?: $user->name,
            'nie' => $user->nie,
            'dossier_number' => $user->dossier_number,
            'verification_code' => $user->verification_code,
            'license_valid_until' => $license?->valid_until?->format('d/m/Y'),
            'license_issued_at' => $license?->issued_at?->format('d/m/Y'),
            'points' => $license?->points,
            'max_points' => LicenseSummary::MAX_POINTS,
            'categories' => $license?->displayCategoryLabel() ?: $license?->category,
            'category' => $license?->category,
            'administrative_status' => $license?->application_status
                ? permit_status_label($license->application_status)
                : null,
            'license_status' => $status['code'],
            'license_status_label' => $status['label'],
            'verified_at' => now()->format('d/m/Y H:i'),
            'photo_url' => $photoUrl,
            'qr_verified' => $qrVerified,
        ];
    }

    public function findActiveTokenRecord(string $plain): ?QrToken
    {
        $plain = strtoupper(trim($plain));

        if ($plain === '') {
            return null;
        }

        $record = QrToken::query()
            ->with(['user.licenseSummary'])
            ->where('token', $this->hashToken($plain))
            ->first();

        if (! $record) {
            return null;
        }

        if ($record->expires_at->isPast()) {
            return null;
        }

        if ($record->used && config('dgt_qr.single_use', false)) {
            return null;
        }

        return $record;
    }

    public function extractPlainToken(string $input): string
    {
        $input = trim($input);

        if ($input === '') {
            return '';
        }

        if (str_starts_with($input, '{')) {
            $data = json_decode($input, true);
            if (is_array($data) && ! empty($data['t'])) {
                return strtoupper((string) $data['t']);
            }
        }

        if (preg_match('/[?&]qr=([^&\s]+)/i', $input, $m)) {
            return strtoupper(urldecode($m[1]));
        }

        if (preg_match('/TOKEN-[A-Z0-9]+/i', $input, $m)) {
            return strtoupper($m[0]);
        }

        return strtoupper($input);
    }

    /** @return array{code: string, label: string} */
    public function licenseStatus(?LicenseSummary $license): array
    {
        if (! $license) {
            return ['code' => 'unknown', 'label' => __('verify.qr_status_unknown')];
        }

        $status = strtolower((string) ($license->application_status ?? ''));

        if (in_array($status, ['refuse', 'rechazado', 'suspendido', 'suspended'], true)) {
            return ['code' => 'suspended', 'label' => __('verify.qr_status_suspended')];
        }

        if ($license->valid_until && $license->valid_until->isPast()) {
            return ['code' => 'expired', 'label' => __('verify.qr_status_expired')];
        }

        return ['code' => 'valid', 'label' => __('verify.qr_status_valid')];
    }

    private function makePlainToken(): string
    {
        $prefix = (string) config('dgt_qr.token_prefix', 'TOKEN');

        return $prefix.'-'.strtoupper(Str::random(12));
    }

    private function hashToken(string $plain): string
    {
        return hash('sha256', strtoupper($plain));
    }
}
