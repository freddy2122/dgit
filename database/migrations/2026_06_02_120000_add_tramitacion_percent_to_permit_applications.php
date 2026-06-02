<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('permit_applications', function (Blueprint $table) {
            $table->unsignedTinyInteger('tramitacion_percent')->nullable()->after('exam_errors');
        });
    }

    public function down(): void
    {
        Schema::table('permit_applications', function (Blueprint $table) {
            $table->dropColumn('tramitacion_percent');
        });
    }
};
