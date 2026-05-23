<?php

namespace App\Console\Commands;

use Database\Seeders\AdminUserSeeder;
use Illuminate\Console\Command;

class SeedAdminCommand extends Command
{
    protected $signature = 'admin:seed
                            {--email= : E-mail admin (remplace ADMIN_EMAIL)}
                            {--password= : Mot de passe (remplace ADMIN_PASSWORD)}';

    protected $description = 'Crée ou met à jour le compte administrateur par défaut';

    public function handle(): int
    {
        if ($this->option('email')) {
            config(['admin.seed_email' => $this->option('email')]);
        }
        if ($this->option('password')) {
            config(['admin.seed_password' => $this->option('password')]);
        }

        $this->call('db:seed', [
            '--class' => AdminUserSeeder::class,
            '--force' => true,
        ]);

        $email = config('admin.seed_email');
        $this->info("Admin prêt : {$email} → /admin");

        return self::SUCCESS;
    }
}
