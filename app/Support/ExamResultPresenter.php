<?php

namespace App\Support;

use App\Models\LicenseSummary;
use App\Models\PermitApplication;
use App\Models\User;
use Carbon\Carbon;

class ExamResultPresenter
{
    public function __construct(
        private ?PermitApplication $application,
        private ?User $user = null,
        private ?LicenseSummary $license = null,
    ) {
        $this->user ??= $application?->user;
        $this->license ??= $this->user?->licenseSummary;
    }

    public function visible(): bool
    {
        if (! $this->application) {
            return false;
        }

        if ($this->application->exam_score !== null) {
            return true;
        }

        return $this->application->examPrevalidated();
    }

    public function passed(): bool
    {
        return $this->application?->examPassed() ?? false;
    }

    public function score(): ?int
    {
        return $this->application?->exam_score;
    }

    public function errorsCount(): int
    {
        if ($this->application?->exam_errors !== null) {
            return (int) $this->application->exam_errors;
        }

        $score = $this->score();
        if ($score !== null) {
            return max(0, min(30, 30 - (int) round($score * 0.27)));
        }

        return $this->passed() ? 3 : 8;
    }

    public function heldAt(): ?Carbon
    {
        return $this->application?->submitted_at
            ?? $this->application?->created_at;
    }

    public function holderDisplayName(): string
    {
        $user = $this->user;
        if (! $user) {
            return '—';
        }

        $last = mb_strtoupper(trim((string) ($user->last_name ?: '')));
        $first = mb_strtoupper(trim((string) ($user->first_name ?: '')));

        if ($last !== '' && $first !== '') {
            return $last.', '.$first;
        }

        return mb_strtoupper(trim((string) ($user->name ?: __('status.holder_default'))));
    }

    public function nie(): string
    {
        $nie = $this->application?->nie ?? $this->user?->nie;

        return strtoupper(preg_replace('/\s+/', '', (string) $nie) ?: '—');
    }

    public function licenseClass(): string
    {
        $requested = $this->application?->requested_category;
        if (is_string($requested) && $requested !== '') {
            return strtoupper(preg_replace('/[^A-Z0-9]/', '', $requested)) ?: 'B';
        }

        $category = $this->license?->category;

        if (is_string($category) && $category !== '') {
            return strtoupper(preg_replace('/[^A-Z0-9]/', '', $category)) ?: 'B';
        }

        return 'B';
    }

    public function validationPercent(): int
    {
        $manual = $this->application?->tramitacion_percent;
        if ($manual !== null) {
            return max(0, min(100, (int) $manual));
        }

        return $this->validationPercentFromStatus();
    }

    public function statusDefaultValidationPercent(): int
    {
        return $this->validationPercentFromStatus();
    }

    private function validationPercentFromStatus(): int
    {
        $status = $this->application?->status ?? 'en_attente';

        return match ($status) {
            'en_attente_paiement_whatsapp' => 25,
            'en_tramitacion' => 50,
            'permiso_provisional' => 70,
            'en_fabricacion' => 80,
            'expedido' => 90,
            'valide', 'validado' => 100,
            'refuse', 'rechazado' => 0,
            default => 40,
        };
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        $visible = $this->visible();
        $passed = $this->passed();
        $heldAt = $this->heldAt();

        return [
            'show' => $visible,
            'passed' => $passed,
            'score' => $this->score(),
            'errors' => $this->errorsCount(),
            'date' => $heldAt?->format('d/m/Y'),
            'holder' => $this->holderDisplayName(),
            'nie' => $this->nie(),
            'license_class' => $this->licenseClass(),
            'validation_percent' => $this->validationPercent(),
            'prevalidated' => $this->application?->examPrevalidated() && $this->score() === null,
        ];
    }
}
