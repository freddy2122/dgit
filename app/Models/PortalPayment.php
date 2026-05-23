<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PortalPayment extends Model
{
    protected $fillable = [
        'user_id',
        'permit_application_id',
        'label',
        'amount',
        'due_date',
        'status',
        'reference',
        'payment_kind',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'due_date' => 'date',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function permitApplication(): BelongsTo
    {
        return $this->belongsTo(PermitApplication::class);
    }

    public function isPending(): bool
    {
        return in_array($this->status, ['pending', 'awaiting_whatsapp'], true);
    }

    public function isPaid(): bool
    {
        return $this->status === 'paid';
    }
}
