<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PortalNotification extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'body',
        'body_params',
        'notified_at',
        'is_read',
    ];

    protected $casts = [
        'notified_at' => 'datetime',
        'is_read' => 'boolean',
        'body_params' => 'array',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    protected function displayTitle(): Attribute
    {
        return Attribute::get(fn () => $this->translateField($this->attributes['title'] ?? ''));
    }

    protected function displayBody(): Attribute
    {
        return Attribute::get(function () {
            $body = $this->attributes['body'] ?? '';
            if ($body === '') {
                return '';
            }

            return $this->translateField($body, $this->body_params ?? []);
        });
    }

    /** @param  array<string, mixed>  $params */
    private function translateField(string $value, array $params = []): string
    {
        if (preg_match('/^(tramite|admin|portal)\.[a-z0-9_.]+$/i', $value)) {
            $params = $params !== [] ? $params : $this->resolveParamsForKey($value);

            return __($value, $params);
        }

        return $value;
    }

    /** @return array<string, mixed> */
    private function resolveParamsForKey(string $key): array
    {
        if (is_array($this->body_params) && $this->body_params !== []) {
            return $this->body_params;
        }

        $application = $this->user?->permitApplication;
        if (! $application) {
            return [];
        }

        $type = $application->tramite_type ?? 'obtencion';
        $typeCfg = config('dgt_tramites.types.'.$type, []);
        $typeLabel = portal_locale() === 'fr'
            ? ($typeCfg['label_fr'] ?? $type)
            : ($typeCfg['label_es'] ?? $type);

        return match ($key) {
            'tramite.notif_started_body' => [
                'ref' => $application->reference_code,
                'type' => $typeLabel,
            ],
            'tramite.notif_score_ok_body' => ['score' => $application->exam_score ?? 0],
            'tramite.notif_valid_body', 'admin.notif_validated_body', 'admin.notif_rejected_body' => [
                'ref' => $application->reference_code,
            ],
            default => [],
        };
    }
}
