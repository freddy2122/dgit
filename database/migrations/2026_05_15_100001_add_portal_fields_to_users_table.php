<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('first_name')->nullable()->after('name');
            $table->string('last_name')->nullable()->after('first_name');
            $table->string('nie', 32)->nullable()->unique()->after('last_name');
            $table->string('phone', 32)->nullable()->after('nie');
            $table->date('birth_date')->nullable()->after('phone');
            $table->text('address')->nullable()->after('birth_date');
            $table->string('auth_method', 32)->nullable()->after('address');
            $table->boolean('is_active')->default(true)->after('auth_method');
            $table->string('dossier_number', 32)->nullable()->unique()->after('is_active');
            $table->string('dni_recto_path')->nullable()->after('dossier_number');
            $table->string('dni_verso_path')->nullable()->after('dni_recto_path');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'first_name',
                'last_name',
                'nie',
                'phone',
                'birth_date',
                'address',
                'auth_method',
                'is_active',
                'dossier_number',
                'dni_recto_path',
                'dni_verso_path',
            ]);
        });
    }
};
