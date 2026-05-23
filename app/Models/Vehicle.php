<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Vehicle extends Model
{
    protected $fillable = [
        'user_id',
        'plate',
        'vehicle_type',
        'itv_valid_until',
        'status',
        'is_motorcycle',
    ];

    protected $casts = [
        'itv_valid_until' => 'date',
        'is_motorcycle' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
