<?php

namespace App\Services;

use App\Models\LicensePointEvent;
use App\Models\LicenseSummary;
use App\Models\User;

class AdminLicenseService
{
    public function ensureLicenseRecord(User $user): LicenseSummary
    {
        return LicenseSummary::query()->firstOrCreate(
            ['user_id' => $user->id],
            [
                'points' => 0,
                'category' => '',
                'issued_at' => null,
                'authority_code' => '',
                'categories_data' => [],
                'valid_until' => null,
                'application_status' => 'en_attente',
            ]
        );
    }

    /**
     * @param  array{
     *     points?: int|null,
     *     category?: string|null,
     *     valid_until?: string|null,
     *     issued_at?: string|null,
     *     authority_code?: string|null,
     *     application_status?: string|null,
     *     categories?: list<string>|null
     * }  $data
     */
    public function updateLicense(User $user, array $data): LicenseSummary
    {
        $license = $this->ensureLicenseRecord($user);

        $updates = [];
        if (array_key_exists('points', $data) && $data['points'] !== null) {
            $updates['points'] = max(0, min(LicenseSummary::MAX_POINTS, (int) $data['points']));
        }
        if (array_key_exists('category', $data)) {
            $updates['category'] = $data['category'] !== null && $data['category'] !== '' ? $data['category'] : '';
        }
        if (array_key_exists('valid_until', $data)) {
            $updates['valid_until'] = $data['valid_until'] ?: null;
        }
        if (array_key_exists('issued_at', $data)) {
            $updates['issued_at'] = $data['issued_at'] ?: null;
        }
        if (array_key_exists('authority_code', $data)) {
            $updates['authority_code'] = $data['authority_code'] !== null && $data['authority_code'] !== ''
                ? $data['authority_code']
                : '';
        }
        if (array_key_exists('application_status', $data) && $data['application_status']) {
            $updates['application_status'] = $data['application_status'];
        }

        if (array_key_exists('categories', $data)) {
            $active = collect($data['categories'] ?? [])
                ->map(fn ($c) => strtoupper(trim((string) $c)))
                ->filter()
                ->unique()
                ->values()
                ->all();
            $updates['categories_data'] = $this->buildCategoriesData(
                $active,
                $updates['issued_at'] ?? $license->issued_at?->format('Y-m-d'),
                $updates['valid_until'] ?? $license->valid_until?->format('Y-m-d'),
            );
            if (! array_key_exists('category', $updates) && $active !== []) {
                $updates['category'] = $this->inferMainCategory($active);
            } elseif (! array_key_exists('category', $updates) && $active === []) {
                $updates['category'] = '';
            }
        }

        if ($updates !== []) {
            $license->update($updates);
        }

        return $license->fresh();
    }

    /** Ne conserve que les catégories cochées par l’admin (affichées sur la carte). */
    /** @param  list<string>  $activeCodes */
    private function buildCategoriesData(array $activeCodes, ?string $issuedAt, ?string $validUntil): array
    {
        $issued = $issuedAt ? \Illuminate\Support\Carbon::parse($issuedAt)->format('d-m-Y') : null;
        $expiry = $validUntil ? \Illuminate\Support\Carbon::parse($validUntil)->format('d-m-Y') : null;
        $order = array_flip(LicenseSummary::categoryCodes());

        return collect($activeCodes)
            ->sortBy(fn (string $code) => $order[$code] ?? 999)
            ->values()
            ->map(fn (string $code) => [
                'code' => $code,
                'valid_from' => $issued,
                'valid_until' => $expiry,
                'codes' => null,
                'active' => true,
            ])
            ->all();
    }

    /** @param  list<string>  $activeCodes */
    private function inferMainCategory(array $activeCodes): string
    {
        foreach (['DE', 'D1E', 'CE', 'C1E', 'BE', 'D', 'D1', 'C', 'C1', 'B', 'A', 'A2', 'A1', 'AM'] as $priority) {
            if (in_array($priority, $activeCodes, true)) {
                return $priority;
            }
        }

        return $activeCodes[0] ?? '';
    }

    public function adjustPoints(User $user, int $delta, string $reason, ?int $adminId = null): LicenseSummary
    {
        $license = $this->ensureLicenseRecord($user);
        $newBalance = max(0, min(LicenseSummary::MAX_POINTS, $license->points + $delta));
        $license->update(['points' => $newBalance]);

        LicensePointEvent::query()->create([
            'user_id' => $user->id,
            'created_by' => $adminId ?? auth()->id(),
            'delta' => $delta,
            'balance_after' => $newBalance,
            'reason' => $reason,
            'occurred_at' => now(),
        ]);

        return $license->fresh();
    }
}
