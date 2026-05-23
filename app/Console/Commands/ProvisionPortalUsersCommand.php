<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Services\PortalUserDataProvisioner;
use Illuminate\Console\Command;

class ProvisionPortalUsersCommand extends Command
{
    protected $signature = 'portal:provision-users {--user= : ID utilisateur (sinon tous avec NIE + date de naissance)}';

    protected $description = 'Crée permis, véhicules et dossier PERSEO pour les comptes existants';

    public function handle(): int
    {
        $query = User::query()->whereNotNull('nie')->whereNotNull('birth_date');

        if ($id = $this->option('user')) {
            $query->whereKey($id);
        }

        $count = 0;
        $query->each(function (User $user) use (&$count) {
            PortalUserDataProvisioner::provision($user);
            $count++;
            $this->line("Provisionné : #{$user->id} {$user->email}");
        });

        $this->info("{$count} compte(s) traité(s).");

        return self::SUCCESS;
    }
}
