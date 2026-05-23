<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Http\UploadedFile;
class LicensePhotoFile implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (! $value instanceof UploadedFile || ! $value->isValid()) {
            return;
        }

        $minW = (int) config('license_photo.min_width', 250);
        $minH = (int) config('license_photo.min_height', 308);

        $size = @getimagesize($value->getRealPath());
        if ($size === false) {
            $fail(__('validation.image'));

            return;
        }

        [$width, $height] = $size;
        if ($width < $minW || $height < $minH) {
            $fail(__('portal.license.photo_too_small', [
                'min_width' => $minW,
                'min_height' => $minH,
                'width_mm' => config('license_photo.width_mm', 26),
                'height_mm' => config('license_photo.height_mm', 32),
            ]));
        }
    }
}
