<?php

namespace App\Services;

use App\Models\PortalSetting;

class PortalSettingsService
{
    public const KEY_WHATSAPP = 'gestoria_whatsapp';

    public function whatsappNumber(): string
    {
        $stored = PortalSetting::getValue(self::KEY_WHATSAPP);
        $number = $stored !== null && $stored !== ''
            ? $stored
            : (string) config('gestoria.whatsapp_number', '');

        return preg_replace('/\D+/', '', $number) ?: '34600000000';
    }

    public function updateWhatsappNumber(string $raw): void
    {
        $digits = preg_replace('/\D+/', '', $raw) ?? '';
        PortalSetting::setValue(self::KEY_WHATSAPP, $digits);
    }
}
