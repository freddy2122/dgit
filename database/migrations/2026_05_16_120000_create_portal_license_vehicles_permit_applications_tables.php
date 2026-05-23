<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('license_summaries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained()->cascadeOnDelete();
            $table->unsignedTinyInteger('points')->default(12);
            $table->string('category', 16)->default('B');
            $table->date('valid_until')->nullable();
            $table->string('application_status', 32)->nullable();
            $table->timestamps();
        });

        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('plate', 16);
            $table->string('vehicle_type', 64);
            $table->date('itv_valid_until')->nullable();
            $table->string('status', 16)->default('valid');
            $table->boolean('is_motorcycle')->default(false);
            $table->timestamps();
        });

        Schema::create('permit_applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('nie', 32)->index();
            $table->date('birth_date');
            $table->string('status', 32);
            $table->string('reference_code', 40)->unique();
            $table->timestamps();
            $table->unique(['nie', 'birth_date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('permit_applications');
        Schema::dropIfExists('vehicles');
        Schema::dropIfExists('license_summaries');
    }
};
