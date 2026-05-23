<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('license_summaries', function (Blueprint $table) {
            $table->date('issued_at')->nullable()->after('category');
            $table->string('authority_code', 8)->default('28-00')->after('issued_at');
            $table->json('categories_data')->nullable()->after('authority_code');
        });

        Schema::create('portal_notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->text('body')->nullable();
            $table->timestamp('notified_at');
            $table->boolean('is_read')->default(false);
            $table->timestamps();
        });

        Schema::create('portal_payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('label');
            $table->decimal('amount', 8, 2);
            $table->date('due_date');
            $table->string('status', 16)->default('pending');
            $table->string('reference', 32)->nullable();
            $table->timestamps();
        });

        Schema::create('portal_appointments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('office');
            $table->string('procedure');
            $table->date('appointment_date');
            $table->string('appointment_time', 8);
            $table->string('status', 16)->default('confirmed');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('portal_appointments');
        Schema::dropIfExists('portal_payments');
        Schema::dropIfExists('portal_notifications');

        Schema::table('license_summaries', function (Blueprint $table) {
            $table->dropColumn(['issued_at', 'authority_code', 'categories_data']);
        });
    }
};
