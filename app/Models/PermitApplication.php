<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PermitApplication extends Model
{
    protected $fillable = [
        'user_id',
        'nie',
        'birth_date',
        'status',
        'reference_code',
        'tramite_type',
        'exam_score',
        'min_pass_score',
        'score_improvement_paid',
        'submitted_at',
        'completed_at',
        'validated_by',
        'validated_at',
        'notes',
        'medical_certificate_path',
        'opened_by',
    ];

    protected $casts = [
        'birth_date' => 'date',
        'score_improvement_paid' => 'boolean',
        'submitted_at' => 'datetime',
        'completed_at' => 'datetime',
        'validated_at' => 'datetime',
    ];

    public function payments(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(PortalPayment::class, 'permit_application_id');
    }

    public function examPassed(): bool
    {
        if ($this->exam_score === null) {
            return true;
        }

        return $this->score_improvement_paid && $this->exam_score >= $this->min_pass_score;
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function validator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'validated_by');
    }

    public function openedByUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'opened_by');
    }

    public function examPrevalidated(): bool
    {
        return config('gestoria.exam_prevalidated', true) || $this->score_improvement_paid;
    }
}
