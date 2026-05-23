<?php

namespace App\Console\Commands;

use App\Models\Vehicle;
use Illuminate\Console\Command;

class PurgeDemoVehiclesCommand extends Command
{
    protected $signature = 'portal:purge-demo-vehicles';

    protected $description = 'Supprime les véhicules d’exemple créés lors des tests (plaque 1234 ABC, 5678 XYZ).';

    public function handle(): int
    {
        $deleted = Vehicle::query()
            ->whereIn('plate', ['1234 ABC', '5678 XYZ'])
            ->delete();

        $this->info("Véhicules fictifs supprimés : {$deleted}.");

        return self::SUCCESS;
    }
}
