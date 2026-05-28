<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('permit_applications', function (Blueprint $table) {
            $table->unsignedTinyInteger('exam_errors')->nullable()->after('exam_score');
        });
    }

    public function down(): void
    {
        Schema::table('permit_applications', function (Blueprint $table) {
            $table->dropColumn('exam_errors');
        });
    }
};
