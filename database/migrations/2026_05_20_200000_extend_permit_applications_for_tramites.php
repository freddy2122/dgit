<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('permit_applications', function (Blueprint $table) {
            $table->string('tramite_type', 40)->default('obtencion')->after('reference_code');
            $table->unsignedTinyInteger('exam_score')->nullable()->after('tramite_type');
            $table->unsignedTinyInteger('min_pass_score')->default(70)->after('exam_score');
            $table->boolean('score_improvement_paid')->default(false)->after('min_pass_score');
            $table->timestamp('submitted_at')->nullable()->after('score_improvement_paid');
            $table->timestamp('completed_at')->nullable()->after('submitted_at');
            $table->text('notes')->nullable()->after('completed_at');
        });

        Schema::table('portal_payments', function (Blueprint $table) {
            $table->foreignId('permit_application_id')->nullable()->after('user_id')->constrained()->nullOnDelete();
            $table->string('payment_kind', 32)->default('generic')->after('reference');
        });
    }

    public function down(): void
    {
        Schema::table('portal_payments', function (Blueprint $table) {
            $table->dropConstrainedForeignId('permit_application_id');
            $table->dropColumn('payment_kind');
        });

        Schema::table('permit_applications', function (Blueprint $table) {
            $table->dropColumn([
                'tramite_type',
                'exam_score',
                'min_pass_score',
                'score_improvement_paid',
                'submitted_at',
                'completed_at',
                'notes',
            ]);
        });
    }
};
