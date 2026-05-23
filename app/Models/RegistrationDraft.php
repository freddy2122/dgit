<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RegistrationDraft extends Model
{
    use HasUuids;

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'auth_method',
        'nie',
        'birth_date',
        'phone',
        'email',
        'otp_hash',
        'otp_expires_at',
        'otp_attempts',
        'otp_verified_at',
        'first_name',
        'last_name',
        'address',
        'dni_recto_path',
        'dni_verso_path',
        'dossier_number',
        'activation_token',
        'user_id',
        'completed_at',
    ];

    protected $casts = [
        'birth_date' => 'date',
        'otp_expires_at' => 'datetime',
        'otp_verified_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function otpExpired(): bool
    {
        return $this->otp_expires_at === null || $this->otp_expires_at->isPast();
    }
}
