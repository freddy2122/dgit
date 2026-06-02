<?php

namespace App\Services;

use App\Models\LicenseSummary;
use App\Models\PermitApplication;
use App\Models\User;
use App\Support\ExamResultPresenter;
use App\Support\VerificationCode;
use Carbon\Carbon;

class PermitStatusSearchService
{
    /**
     * @param  array{verification_code?: string, nie?: string, birth_day?: int, birth_month?: int, birth_year?: int}  $input
     * @return array{
     *     found: bool,
     *     search_mode: string,
     *     user: ?User,
     *     application: ?PermitApplication,
     *     account_inactive: bool
     * }
     */
    public function resolve(array $input): array
    {
        $searchMode = 'code';
        $user = null;
        $application = null;

        $code = VerificationCode::normalize($input['verification_code'] ?? '');
        $nie = $this->normalizeNie($input['nie'] ?? '');
        $birthDate = $this->parseBirthDate($input);

        if ($code !== '') {
            $user = User::query()->where('verification_code', $code)->first();
        }

        if (! $user && $nie !== '' && $birthDate) {
            $searchMode = 'identity';
            $user = $this->findUserByIdentity($nie, $birthDate);
        }

        if (! $user && $nie !== '' && $birthDate) {
            $searchMode = 'identity';
            $application = PermitApplication::query()
                ->where(function ($q) use ($nie) {
                    $q->where('nie', $nie)
                        ->orWhere('nie', strtoupper($nie));
                })
                ->whereDate('birth_date', $birthDate)
                ->with('user')
                ->first();
            $user = $application?->user;
        }

        if ($user) {
            PortalUserDataProvisioner::ensureProfile($user->fresh());
            $user->refresh();

            $application = PermitApplication::query()
                ->where('user_id', $user->id)
                ->latest('id')
                ->with('user')
                ->first();

            if (! $application && $user->nie && $user->birth_date) {
                $application = PermitApplication::query()
                    ->where(function ($q) use ($user) {
                        $n = $this->normalizeNie($user->nie);
                        $q->where('nie', $n)->orWhere('nie', strtoupper($n));
                    })
                    ->whereDate('birth_date', $user->birth_date)
                    ->with('user')
                    ->first();
            }
        }

        $accountInactive = $user && ! ($user->is_active ?? false);

        return [
            'found' => $application !== null || $user !== null,
            'search_mode' => $searchMode,
            'user' => $user,
            'application' => $application,
            'account_inactive' => $accountInactive,
        ];
    }

    /**
     * @return array<string, mixed>
     */
    public function toPayload(array $resolved): array
    {
        $application = $resolved['application'];
        $user = $resolved['user'] ?? $application?->user;

        if (! $resolved['found'] || ! $user) {
            return [
                'found' => false,
                'search_mode' => $resolved['search_mode'],
            ];
        }

        $user->loadMissing(['licenseSummary', 'vehicles']);
        $license = $user->licenseSummary;
        $statusRaw = $application?->status
            ?? $license?->application_status
            ?? 'en_attente';

        $reference = $application?->reference_code
            ?? $user->dossier_number
            ?? ('REN-'.now()->format('Y').'-'.str_pad((string) $user->id, 6, '0', STR_PAD_LEFT));

        $tramiteService = app(PermitTramiteService::class);
        $tramiteType = $application?->tramite_type;
        $typeLabel = $tramiteType ? $tramiteService->typeLabel($tramiteType) : null;
        $exam = (new ExamResultPresenter($application, $user, $license))->toArray();
        $heldCategories = $license
            ? $license->heldCategoryCodesForDisplay()
            : [];
        $requestedCategory = $application?->displayRequestedCategory($license);

        return [
            'found' => true,
            'search_mode' => $resolved['search_mode'],
            'reference' => $reference,
            'status' => permit_status_label($statusRaw),
            'status_raw' => $statusRaw,
            'tramite_type' => $typeLabel,
            'exam_score' => $application?->exam_score,
            'min_pass_score' => $application?->min_pass_score ?? $tramiteService->minPassScore(),
            'exam_passed' => $application ? $application->examPassed() : true,
            'exam' => $exam,
            'application_id' => $application?->id,
            'nie' => $application?->nie ?? strtoupper((string) $user->nie),
            'filed_on' => $application?->submitted_at?->format('d/m/Y') ?? $application?->created_at?->format('d/m/Y') ?? $user->created_at?->format('d/m/Y'),
            'holder' => trim(collect([$user->first_name, $user->last_name])->filter()->join(' ')) ?: $user->name,
            'verification_code' => $user->verification_code,
            'dossier_number' => $user->dossier_number,
            'account_inactive' => $resolved['account_inactive'],
            'points' => $license?->points ?? 0,
            'max_points' => LicenseSummary::MAX_POINTS,
            'category' => $license?->category,
            'held_categories' => $heldCategories,
            'held_categories_label' => $heldCategories !== []
                ? implode(' · ', $heldCategories)
                : ($license?->displayCategoryLabel() ?: null),
            'requested_category' => $requestedCategory,
            'tramite_type_raw' => $tramiteType,
            'valid_until' => $license?->valid_until?->format('d/m/Y'),
            'vehicles_count' => $user->vehicles->count(),
            'user_id' => $user->id,
        ];
    }

    private function findUserByIdentity(string $nie, Carbon $birthDate): ?User
    {
        $variants = array_unique([
            $nie,
            strtoupper($nie),
            strtolower($nie),
        ]);

        return User::query()
            ->whereIn('nie', $variants)
            ->whereDate('birth_date', $birthDate)
            ->first();
    }

    /**
     * @param  array<string, mixed>  $input
     */
    private function parseBirthDate(array $input): ?Carbon
    {
        if (empty($input['birth_year'])) {
            return null;
        }

        try {
            return Carbon::createFromDate(
                (int) $input['birth_year'],
                (int) ($input['birth_month'] ?? 1),
                (int) ($input['birth_day'] ?? 1),
                config('app.timezone')
            )->startOfDay();
        } catch (\Throwable) {
            return null;
        }
    }

    private function normalizeNie(?string $nie): string
    {
        return strtoupper(preg_replace('/\s+/', '', (string) $nie) ?? '');
    }
}
