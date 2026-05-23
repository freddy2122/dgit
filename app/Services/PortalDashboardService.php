<?php

namespace App\Services;

use App\Models\LicenseSummary;
use App\Models\PermitApplication;
use App\Models\User;
use Illuminate\Support\Collection;

class PortalDashboardService
{
    public function ensureProvisioned(User $user): void
    {
        PortalUserDataProvisioner::ensureProfile($user);
        PortalUserDataProvisioner::ensureEmptyLicense($user);

        if (config('portal.demo_data', false) && $user->nie && $user->birth_date) {
            PortalUserDataProvisioner::provision($user);
            $user->refresh();
        }
    }

    public function licenseIsPublishedForClient(?LicenseSummary $license): bool
    {
        return $license?->isPublishedForClient() ?? false;
    }

    /** @return array{label: string, status: string, badgeClass: string} */
    public function procedureStatus(?PermitApplication $application, ?string $licenseStatus): array
    {
        $status = $application?->status ?? $licenseStatus ?? 'en_attente';

        return match ($status) {
            'valide', 'validado', 'expedie', 'expedido' => [
                'label' => __('portal.dashboard.status_finished'),
                'status' => __('portal.dashboard.status_finished'),
                'badgeClass' => 'bg-emerald-100 text-emerald-800',
            ],
            'refuse', 'rechazado' => [
                'label' => __('portal.dashboard.status_rejected'),
                'status' => __('portal.dashboard.status_rejected'),
                'badgeClass' => 'bg-red-100 text-red-800',
            ],
            default => [
                'label' => __('portal.dashboard.status_in_progress'),
                'status' => __('portal.dashboard.status_in_progress'),
                'badgeClass' => 'bg-sky-100 text-sky-800',
            ],
        };
    }

    /** @return Collection<int, array{label: string, status: string, badgeClass: string, url: ?string}> */
    public function proceduresForUser(User $user): Collection
    {
        $applications = PermitApplication::query()
            ->where('user_id', $user->id)
            ->latest('updated_at')
            ->get();

        if ($applications->isEmpty()) {
            $license = $user->licenseSummary;
            if ($license && $license->application_status && $license->application_status !== 'en_attente') {
                $row = $this->procedureStatus(null, $license->application_status);

                return collect([[
                    'label' => __('portal.dashboard.procedure_permit'),
                    'status' => $row['status'],
                    'badgeClass' => $row['badgeClass'],
                    'url' => null,
                ]]);
            }

            return collect();
        }

        $service = app(PermitTramiteService::class);

        return $applications->map(function (PermitApplication $app) use ($service) {
            $row = $this->procedureStatus($app, null);
            $type = $app->tramite_type ?? 'obtencion';

            return [
                'label' => $service->typeLabel($type).' — '.$app->reference_code,
                'status' => $row['status'],
                'badgeClass' => $row['badgeClass'],
                'url' => portal_route('portal.tramite.show', ['application' => $app->id]),
            ];
        });
    }

    public function resolveApplication(User $user): ?PermitApplication
    {
        $application = PermitApplication::query()
            ->where('user_id', $user->id)
            ->latest('id')
            ->first();

        if ($application || ! $user->nie || ! $user->birth_date) {
            return $application;
        }

        $nie = strtoupper(preg_replace('/\s+/', '', (string) $user->nie));

        return PermitApplication::query()
            ->where('nie', $nie)
            ->whereDate('birth_date', $user->birth_date)
            ->first();
    }

    public function maxPoints(): int
    {
        return LicenseSummary::MAX_POINTS;
    }
}
