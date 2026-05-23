<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Services\PortalUserDataProvisioner;
use Illuminate\Console\Command;

class ResetPortalClientDataCommand extends Command
{
    protected $signature = 'portal:reset-client-data
                            {user? : ID utilisateur client}
                            {--nie= : NIE du client}
                            {--email= : E-mail du client}
                            {--keep-vehicles : Conserver les véhicules}
                            {--force : Sans confirmation}';

    protected $description = 'Remet un client portail à l’état vide (permis, points, véhicules démo)';

    public function handle(): int
    {
        $user = $this->resolveUser();

        if (! $user) {
            $this->error('Client introuvable. Indiquez un ID, --nie= ou --email=.');

            return self::FAILURE;
        }

        if ($user->role !== 'user') {
            $this->error('Cet utilisateur n’est pas un client (role=user).');

            return self::FAILURE;
        }

        if (! $this->option('force') && ! $this->confirm("Réinitialiser les données portail de {$user->name} (#{$user->id}) ?", true)) {
            return self::SUCCESS;
        }

        if (! $this->option('keep-vehicles')) {
            $deletedVehicles = $user->vehicles()->delete();
            $this->line("Véhicules supprimés : {$deletedVehicles}");
        }

        PortalUserDataProvisioner::ensureEmptyLicense($user)->update([
            'points' => 0,
            'category' => '',
            'issued_at' => null,
            'authority_code' => '',
            'categories_data' => [],
            'valid_until' => null,
            'application_status' => 'en_attente',
        ]);

        $user->portalPayments()->delete();
        $user->portalAppointments()->delete();
        $user->portalNotifications()->where('title', 'like', 'portal.demo.%')->delete();

        $this->info("Client #{$user->id} remis à l’état vide. Statut permis : en_attente.");

        return self::SUCCESS;
    }

    private function resolveUser(): ?User
    {
        if ($id = $this->argument('user')) {
            return User::query()->find($id);
        }

        if ($nie = $this->option('nie')) {
            $normalized = strtoupper(preg_replace('/\s+/', '', (string) $nie));

            return User::query()->where('nie', $normalized)->first();
        }

        if ($email = $this->option('email')) {
            return User::query()->where('email', $email)->first();
        }

        return null;
    }
}
