<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::query()->updateOrCreate(
            ['email' => 'admin@dgt.local'],
            [
                'name' => 'Agent DGT Demo',
                'first_name' => 'Agent',
                'last_name' => 'DGT',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
                'is_active' => true,
                'nie' => 'ADMIN0000X',
            ]
        );

        $this->command?->info('Compte admin : admin@dgt.local / admin123 → /admin');
    }
}
