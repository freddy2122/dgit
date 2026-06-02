<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Collection;

class LicenseSummary extends Model
{
    public const MAX_POINTS = 12;

    /** @return list<string> */
    public static function categoryCodes(): array
    {
        return config('dgt_license_categories.codes', [
            'AM', 'A1', 'A2', 'A', 'B', 'C1', 'C', 'D1', 'D', 'BE', 'C1E', 'CE', 'D1E', 'DE',
        ]);
    }

    protected $fillable = [
        'user_id',
        'points',
        'category',
        'issued_at',
        'authority_code',
        'categories_data',
        'valid_until',
        'application_status',
    ];

    protected $casts = [
        'valid_until' => 'date',
        'issued_at' => 'date',
        'categories_data' => 'array',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /** Permis visible côté client (carte rose, QR, etc.) — pas les données démo « en_attente ». */
    public function isPublishedForClient(): bool
    {
        if (! $this->hasPublishedStatus()) {
            return false;
        }

        if ($this->valid_until === null) {
            return false;
        }

        if ($this->activeCategoryRows()->isNotEmpty()) {
            return true;
        }

        return filled($this->category);
    }

    public function hasPublishedStatus(): bool
    {
        $status = $this->application_status ?? 'en_attente';

        return in_array($status, ['valide', 'expedido', 'permiso_provisional'], true);
    }

    /** Libellé champ 9 sur la carte — uniquement les catégories cochées par l’admin en BDD. */
    public function displayCategoryLabel(): string
    {
        $order = array_flip(self::categoryCodes());

        return $this->activeCategoryRows()
            ->sortBy(fn ($row) => $order[$row['code']] ?? 999)
            ->pluck('code')
            ->implode('  ');
    }

    /** @return Collection<int, string> */
    public function activeCategoryCodes(): Collection
    {
        return $this->activeCategoryRows()->pluck('code');
    }

    /** @return list<string> */
    public function heldCategoryCodesForDisplay(): array
    {
        $active = $this->activeCategoryCodes()->values()->all();
        if ($active !== []) {
            return $active;
        }

        if ($this->hasPublishedStatus() && filled($this->category)) {
            $code = strtoupper(preg_replace('/[^A-Z0-9]/', '', (string) $this->category));

            return $code !== '' ? [$code] : [];
        }

        return [];
    }

    /** @return Collection<int, array{code: string, valid_from: ?string, valid_until: ?string, codes: ?string, active: bool}> */
    public function activeCategoryRows(): Collection
    {
        return $this->categoryRows()->filter(fn ($row) => $row['active'] ?? false);
    }

    /** @return Collection<int, array{code: string, valid_from: ?string, valid_until: ?string, codes: ?string, active: bool}> */
    public function categoryRows(): Collection
    {
        return collect($this->categories_data ?? [])
            ->map(fn ($row) => [
                'code' => strtoupper((string) ($row['code'] ?? '')),
                'valid_from' => $row['valid_from'] ?? null,
                'valid_until' => $row['valid_until'] ?? null,
                'codes' => $row['codes'] ?? null,
                'active' => (bool) ($row['active'] ?? false),
            ])
            ->filter(fn ($row) => $row['code'] !== '');
    }
}
