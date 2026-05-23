<?php

namespace App\Services;

use App\Models\AdminActivityLog;
use Illuminate\Database\Eloquent\Model;

class AdminActivityLogger
{
    public function log(string $action, ?Model $subject = null, ?string $details = null): void
    {
        if (! auth()->check()) {
            return;
        }

        AdminActivityLog::query()->create([
            'admin_id' => auth()->id(),
            'action' => $action,
            'subject_type' => $subject ? $subject->getMorphClass() : null,
            'subject_id' => $subject?->getKey(),
            'details' => $details,
        ]);
    }
}
