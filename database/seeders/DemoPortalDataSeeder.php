<?php

namespace Database\Seeders;

use App\Models\User;
use App\Services\PortalUserDataProvisioner;
use Illuminate\Database\Seeder;

class DemoPortalDataSeeder extends Seeder
{
    /**
     * Remplit permis / véhicules / dossier PERSEO pour le premier utilisateur ayant NIE + date de naissance.
     */
    public function run(): void
    {
        $user = User::query()
            ->whereNotNull('nie')
            ->whereNotNull('birth_date')
            ->orderBy('id')
            ->first();

        if (! $user) {
            $this->command?->warn('DemoPortalDataSeeder : aucun utilisateur avec NIE et date de naissance — ignoré.');

            return;
        }

        PortalUserDataProvisioner::provision($user);

        $this->command?->info('DemoPortalDataSeeder : données portail associées à l’utilisateur #'.$user->id.'.');
    }
}
