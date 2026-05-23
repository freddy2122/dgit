<?php

namespace App\Services;

use App\Models\LicenseSummary;
use App\Models\PermitApplication;
use App\Models\PortalAppointment;
use App\Models\PortalNotification;
use App\Models\PortalPayment;
use App\Models\User;
use App\Support\VerificationCode;
use Illuminate\Support\Str;

class PortalUserDataProvisioner
{
    /** Profil minimal : code de suivi + n° dossier (sans données fictives). */
    public static function ensureProfile(User $user): void
    {
        if (! $user->dossier_number) {
            $user->update([
                'dossier_number' => 'DOS-'.now()->format('Y').'-'.str_pad((string) $user->id, 6, '0', STR_PAD_LEFT),
            ]);
        }

        if (! $user->verification_code) {
            $user->update(['verification_code' => VerificationCode::generate()]);
        }
    }

    public static function ensureEmptyLicense(User $user): LicenseSummary
    {
        self::ensureProfile($user);

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

    /** Données démo complètes (uniquement si PORTAL_DEMO_DATA=true). */
    public static function provision(User $user): void
    {
        if (! config('portal.demo_data', false)) {
            self::ensureProfile($user);
            self::ensureEmptyLicense($user);

            return;
        }

        if (! $user->nie || ! $user->birth_date) {
            return;
        }

        self::ensureProfile($user);

        $nie = strtoupper(preg_replace('/\s+/', '', (string) $user->nie) ?? '');
        $issuedAt = now()->subYears(6)->startOfDay();
        $validUntil = now()->addYears(4)->startOfDay();
        $categoriesData = self::defaultCategories($issuedAt, $validUntil);

        LicenseSummary::query()->updateOrCreate(
            ['user_id' => $user->id],
            [
                'points' => 12,
                'category' => 'B',
                'issued_at' => $issuedAt,
                'authority_code' => '28-00',
                'categories_data' => $categoriesData,
                'valid_until' => $validUntil,
                'application_status' => 'en_attente',
            ]
        );

        $birthDate = $user->birth_date->format('Y-m-d');
        $application = PermitApplication::query()
            ->where('nie', $nie)
            ->whereDate('birth_date', $birthDate)
            ->first();

        if ($application) {
            $application->update(['user_id' => $user->id]);
        }

        if ($user->portalNotifications()->doesntExist()) {
            $user->portalNotifications()->create([
                'title' => 'portal.demo.welcome_title',
                'body' => 'portal.demo.welcome_body',
                'notified_at' => now(),
                'is_read' => false,
            ]);
        }

        if ($user->portalPayments()->doesntExist()) {
            PortalPayment::query()->create([
                'user_id' => $user->id,
                'label' => 'Tasa renovación permiso',
                'amount' => 28.50,
                'due_date' => now()->addDays(12),
                'status' => 'awaiting_whatsapp',
                'reference' => 'TAS-'.strtoupper(Str::random(8)),
            ]);
        }

        if ($user->portalAppointments()->doesntExist()) {
            PortalAppointment::query()->create([
                'user_id' => $user->id,
                'office' => 'Jefatura Provincial de Tráfico — Madrid',
                'procedure' => 'Renovación del permiso de conducción',
                'appointment_date' => now()->addDays(18)->startOfDay(),
                'appointment_time' => '10:30',
                'status' => 'confirmed',
            ]);
        }
    }

    /** @return list<array{code: string, valid_from: string|null, valid_until: string|null, codes: null, active: bool}> */
    private static function defaultCategories(\Illuminate\Support\Carbon $issued, \Illuminate\Support\Carbon $validUntil): array
    {
        $from = $issued->format('d-m-Y');
        $until = $validUntil->format('d-m-Y');
        $active = ['AM', 'A1', 'A2', 'A', 'B'];
        $all = ['AM', 'A1', 'A2', 'A', 'B', 'C1', 'C', 'D1', 'D', 'BE', 'C1E', 'CE', 'D1E', 'DE'];

        return array_map(fn ($code) => [
            'code' => $code,
            'valid_from' => in_array($code, $active, true) ? $from : null,
            'valid_until' => in_array($code, $active, true) ? $until : null,
            'codes' => null,
            'active' => in_array($code, $active, true),
        ], $all);
    }
}
