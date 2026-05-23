<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use RuntimeException;

class LicensePhotoProcessor
{
    public function targetWidth(): int
    {
        return (int) config('license_photo.target_width', 312);
    }

    public function targetHeight(): int
    {
        return (int) config('license_photo.target_height', 384);
    }

    /**
     * Recadre (cover) et redimensionne la photo au format carte permis.
     */
    public function process(UploadedFile $file): string
    {
        if (! extension_loaded('gd')) {
            return $file->getRealPath();
        }

        $src = $this->loadImage($file);
        if (! $src) {
            return $file->getRealPath();
        }

        $targetW = $this->targetWidth();
        $targetH = $this->targetHeight();
        $srcW = imagesx($src);
        $srcH = imagesy($src);

        $scale = max($targetW / $srcW, $targetH / $srcH);
        $scaledW = (int) ceil($srcW * $scale);
        $scaledH = (int) ceil($srcH * $scale);

        $scaled = imagecreatetruecolor($scaledW, $scaledH);
        $this->fillWhite($scaled);
        imagecopyresampled($scaled, $src, 0, 0, 0, 0, $scaledW, $scaledH, $srcW, $srcH);

        $cropX = (int) max(0, floor(($scaledW - $targetW) / 2));
        $cropY = (int) max(0, floor(($scaledH - $targetH) / 2));

        $dest = imagecreatetruecolor($targetW, $targetH);
        $this->fillWhite($dest);
        imagecopy($dest, $scaled, 0, 0, $cropX, $cropY, $targetW, $targetH);

        imagedestroy($src);
        imagedestroy($scaled);

        $tmp = tempnam(sys_get_temp_dir(), 'license_photo_');
        if ($tmp === false) {
            imagedestroy($dest);
            throw new RuntimeException('Unable to create temp file for license photo.');
        }

        $outPath = $tmp.'.jpg';
        @unlink($tmp);
        imagejpeg($dest, $outPath, (int) config('license_photo.jpeg_quality', 88));
        imagedestroy($dest);

        return $outPath;
    }

    /** @return \GdImage|false */
    private function loadImage(UploadedFile $file): \GdImage|false
    {
        $path = $file->getRealPath();
        $mime = $file->getMimeType() ?: mime_content_type($path);

        return match ($mime) {
            'image/jpeg', 'image/jpg' => imagecreatefromjpeg($path),
            'image/png' => imagecreatefrompng($path),
            'image/webp' => function_exists('imagecreatefromwebp') ? imagecreatefromwebp($path) : false,
            default => false,
        };
    }

    private function fillWhite(\GdImage $image): void
    {
        $white = imagecolorallocate($image, 255, 255, 255);
        imagefill($image, 0, 0, $white);
    }
}
