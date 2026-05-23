<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('permit_applications', function (Blueprint $table) {
            $table->string('medical_certificate_path')->nullable()->after('notes');
            $table->foreignId('opened_by')->nullable()->after('medical_certificate_path')->constrained('users')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('permit_applications', function (Blueprint $table) {
            $table->dropConstrainedForeignId('opened_by');
            $table->dropColumn('medical_certificate_path');
        });
    }
};
