<?php

namespace App\Support;

class LicenseCardLayout
{
    /** @return array{scale: string, wrap: string, box: string} */
    public static function classes(string $size = 'display'): array
    {
        $scale = match ($size) {
            'thumb' => 'scale-[0.38] origin-top-left -mb-[240px] -mr-[380px]',
            'dashboard' => 'scale-[0.55] sm:scale-[0.65] origin-top-left',
            default => '',
        };

        $wrap = match ($size) {
            'thumb' => 'h-[150px] w-[240px] overflow-hidden',
            'dashboard' => 'w-full overflow-visible',
            default => 'w-full',
        };

        $box = 'license-card-face relative shrink-0 h-[390px] w-[620px] max-w-full overflow-hidden rounded-2xl border border-pink-200 bg-pink-50 shadow-2xl';

        return [
            'scale' => $scale,
            'wrap' => $wrap,
            'box' => $box,
        ];
    }
}
