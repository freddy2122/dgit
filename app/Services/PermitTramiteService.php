<?php

namespace App\Services;

use App\Models\LicenseSummary;
use App\Models\PermitApplication;
use App\Models\PortalPayment;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class PermitTramiteService
{
    public function __construct(private PortalNotificationService $notifications)
    {
    }

    public function typeForPath(?string $path): ?string
    {
        if ($path === null || $path === '') {
            return null;
        }

        $normalized = sede_normalize_path($path);
        $map = config('dgt_tramites.paths', []);

        return is_string($map[$normalized] ?? null) ? $map[$normalized] : null;
    }

    /** @return array<string, mixed>|null */
    public function typeConfig(string $type): ?array
    {
        $cfg = config('dgt_tramites.types.'.$type);

        return is_array($cfg) ? $cfg : null;
    }

    public function typeLabel(string $type): string
    {
        $cfg = $this->typeConfig($type);
        $key = portal_locale() === 'fr' ? 'label_fr' : 'label_es';

        return (string) ($cfg[$key] ?? $type);
    }

    public function requiresExam(string $type): bool
    {
        if (config('gestoria.exam_prevalidated', true)) {
            return false;
        }

        return (bool) ($this->typeConfig($type)['requires_exam'] ?? false);
    }

    public function requiresMedical(string $type): bool
    {
        return (bool) ($this->typeConfig($type)['requires_medical'] ?? false);
    }

    public function minPassScore(): int
    {
        return (int) config('dgt_tramites.min_pass_score', 70);
    }

    /**
     * Ouvre un dossier (gestoría) : examen déjà validé, paiement WhatsApp, pas de révision examen.
     */
    public function submit(
        User $user,
        string $tramiteType,
        ?string $sedePath = null,
        ?UploadedFile $medicalCertificate = null,
        ?int $openedByUserId = null,
    ): PermitApplication {
        if ($this->requiresMedical($tramiteType) && ! $medicalCertificate) {
            throw ValidationException::withMessages([
                'medical_certificate' => __('tramite.medical_required'),
            ]);
        }

        PortalUserDataProvisioner::ensureProfile($user->fresh());
        PortalUserDataProvisioner::ensureEmptyLicense($user);
        $user->refresh();

        $typeCfg = $this->typeConfig($tramiteType) ?? $this->typeConfig('obtencion');
        $nie = strtoupper(preg_replace('/\s+/', '', (string) $user->nie) ?? '00000000X');
        $birthDate = $user->birth_date ?? now()->subYears(25);
        $medicalPath = $medicalCertificate?->store('dgt_medical', 'local');

        $payload = [
            'tramite_type' => $tramiteType,
            'reference_code' => $this->newReference($tramiteType),
            'status' => 'en_attente_paiement_whatsapp',
            'exam_score' => null,
            'min_pass_score' => $this->minPassScore(),
            'score_improvement_paid' => true,
            'submitted_at' => now(),
            'completed_at' => null,
            'medical_certificate_path' => $medicalPath,
            'opened_by' => $openedByUserId ?? auth()->id(),
            'notes' => $sedePath ? 'Sede: '.$sedePath : 'Gestoría',
        ];

        $application = PermitApplication::query()->where('user_id', $user->id)->first();

        if ($application) {
            $application->update($payload);
        } else {
            $application = PermitApplication::query()->create(array_merge($payload, [
                'user_id' => $user->id,
                'nie' => $nie,
                'birth_date' => $birthDate,
            ]));
        }

        $this->syncPayments($user, $application, $typeCfg);
        $this->touchLicenseStatus($user, 'en_attente_paiement_whatsapp');

        $this->notifications->notify($user, 'tramite.notif_started_title', 'tramite.notif_started_body', [
            'ref' => $application->reference_code,
            'type' => $this->typeLabel($tramiteType),
        ]);

        return $application->fresh();
    }

    public function confirmPayment(PortalPayment $payment): PortalPayment
    {
        $payment->update(['status' => 'paid']);
        $application = $payment->permitApplication;

        if ($application) {
            $this->refreshApplicationAfterPayments($application);
        }

        return $payment->fresh();
    }

    public function advanceStatus(PermitApplication $application, string $newStatus): PermitApplication
    {
        $allowed = [
            'en_tramitacion' => ['en_attente_paiement_whatsapp'],
            'permiso_provisional' => ['en_tramitacion'],
            'en_fabricacion' => ['permiso_provisional'],
            'expedido' => ['en_fabricacion'],
            'valide' => ['expedido', 'permiso_provisional', 'en_tramitacion'],
            'refuse' => ['en_attente_paiement_whatsapp', 'en_tramitacion', 'permiso_provisional'],
        ];

        if (! in_array($application->status, $allowed[$newStatus] ?? [], true)) {
            throw ValidationException::withMessages([
                'status' => __('tramite.invalid_status_transition'),
            ]);
        }

        $user = $application->user;
        $updates = ['status' => $newStatus];

        if ($newStatus === 'valide') {
            $updates['completed_at'] = now();
            $updates['validated_at'] = now();
            $updates['validated_by'] = auth()->id();

            $license = $user->licenseSummary;
            if ($license) {
                $licenseUpdates = ['application_status' => 'valide'];
                if ($application->tramite_type === 'renovacion') {
                    $licenseUpdates['valid_until'] = now()->addYears(10)->startOfDay();
                }
                $license->update($licenseUpdates);
            }

            $this->notifications->notify($user, 'tramite.notif_valid_title', 'tramite.notif_valid_body', [
                'ref' => $application->reference_code,
            ]);
        } elseif ($newStatus === 'permiso_provisional') {
            $this->touchLicenseStatus($user, 'permiso_provisional');
            $this->notifications->notify($user, 'tramite.notif_provisional_title', 'tramite.notif_provisional_body', [
                'ref' => $application->reference_code,
            ]);
        } elseif ($newStatus === 'expedido') {
            $this->touchLicenseStatus($user, 'expedido');
            $this->notifications->notify($user, 'tramite.notif_shipped_title', 'tramite.notif_shipped_body', [
                'ref' => $application->reference_code,
            ]);
        } elseif ($newStatus === 'en_fabricacion') {
            $this->touchLicenseStatus($user, 'en_fabricacion');
        } else {
            $this->touchLicenseStatus($user, $newStatus);
        }

        $application->update($updates);

        return $application->fresh();
    }

    /** @deprecated Client ne paie plus en ligne — utiliser confirmPayment côté admin. */
    public function payScoreImprovement(PermitApplication $application): PermitApplication
    {
        throw ValidationException::withMessages([
            'payment' => __('tramite.payment_whatsapp_only'),
        ]);
    }

    /** @deprecated Client ne paie plus en ligne — utiliser confirmPayment côté admin. */
    public function payTramiteFee(PermitApplication $application): PermitApplication
    {
        throw ValidationException::withMessages([
            'payment' => __('tramite.payment_whatsapp_only'),
        ]);
    }

    protected function refreshApplicationAfterPayments(PermitApplication $application): void
    {
        $hasPending = PortalPayment::query()
            ->where('permit_application_id', $application->id)
            ->whereIn('status', ['pending', 'awaiting_whatsapp'])
            ->exists();

        if (! $hasPending && $application->status === 'en_attente_paiement_whatsapp') {
            $application->update(['status' => 'en_tramitacion']);
            $this->touchLicenseStatus($application->user, 'en_tramitacion');
            $this->notifications->notify($application->user, 'tramite.notif_payments_ok_title', 'tramite.notif_payments_ok_body', [
                'ref' => $application->reference_code,
            ]);
        }
    }

    /** @param  array<string, mixed>  $typeCfg */
    private function syncPayments(User $user, PermitApplication $application, array $typeCfg): void
    {
        PortalPayment::query()
            ->where('permit_application_id', $application->id)
            ->whereIn('status', ['pending', 'awaiting_whatsapp'])
            ->delete();

        PortalPayment::query()->create([
            'user_id' => $user->id,
            'permit_application_id' => $application->id,
            'payment_kind' => 'tramite_fee',
            'label' => __('tramite.payment_fee_label', ['type' => $this->typeLabel($application->tramite_type)]),
            'amount' => (float) ($typeCfg['fee'] ?? 28.50),
            'due_date' => now()->addDays(14),
            'status' => 'awaiting_whatsapp',
            'reference' => 'TAS-'.strtoupper(Str::random(6)),
        ]);
    }

    private function touchLicenseStatus(User $user, string $status): void
    {
        $license = PortalUserDataProvisioner::ensureEmptyLicense($user);
        $license->update(['application_status' => $status]);
    }

    private function newReference(string $type): string
    {
        $prefix = match ($type) {
            'renovacion' => 'REN',
            'duplicado' => 'DUP',
            'canje' => 'CAN',
            'direccion' => 'DIR',
            'internacional' => 'INT',
            default => 'OBT',
        };

        return $prefix.'-'.now()->format('Y').'-'.strtoupper(Str::random(6));
    }
}
