<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        $email = config('admin.seed_email');
        $password = config('admin.seed_password');

        User::query()->updateOrCreate(
            ['email' => $email],
            [
                'name' => 'Administrateur',
                'first_name' => 'Admin',
                'last_name' => 'DGT',
                'password' => Hash::make($password),
                'role' => 'admin',
                'is_active' => true,
                'nie' => 'ADMIN0000X',
            ]
        );

        $this->command?->info("Compte admin : {$email} → /admin (mot de passe = celui défini dans ADMIN_PASSWORD ou admin123)");
    }
}
