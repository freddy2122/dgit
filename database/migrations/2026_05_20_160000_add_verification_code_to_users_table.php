<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('verification_code', 20)->nullable()->unique()->after('dossier_number');
        });

        User::query()->whereNull('verification_code')->each(function (User $user) {
            do {
                $code = 'VER-'.strtoupper(Str::random(4)).'-'.strtoupper(Str::random(4));
            } while (User::query()->where('verification_code', $code)->exists());
            $user->update(['verification_code' => $code]);
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('verification_code');
        });
    }
};
