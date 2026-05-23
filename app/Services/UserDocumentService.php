<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class UserDocumentService
{
    public const TYPES = ['license_photo', 'recto', 'verso', 'signature'];

    public function pathFor(User $user, string $type): ?string
    {
        return match ($type) {
            'license_photo' => $user->license_photo_path,
            'recto' => $user->dni_recto_path,
            'verso' => $user->dni_verso_path,
            'signature' => $user->signature_path,
            default => null,
        };
    }

    /** Chemin affiché sur la carte permis (photo dédiée, sinon recto DNI si image). */
    public function cardPhotoPath(User $user): ?string
    {
        $dedicated = $this->pathFor($user, 'license_photo');
        if ($dedicated && $this->isImage($dedicated) && $this->exists($user, 'license_photo')) {
            return $dedicated;
        }

        $recto = $this->pathFor($user, 'recto');
        if ($recto && $this->isImage($recto) && $this->exists($user, 'recto')) {
            return $recto;
        }

        return null;
    }

    public function hasCardPhoto(User $user): bool
    {
        return $this->cardPhotoPath($user) !== null;
    }

    public function hasDedicatedLicensePhoto(User $user): bool
    {
        return $this->exists($user, 'license_photo');
    }

    public function exists(User $user, string $type): bool
    {
        $path = $this->pathFor($user, $type);

        return $path && Storage::disk('local')->exists($path);
    }

    public function isImage(string $path): bool
    {
        return (bool) preg_match('/\.(jpe?g|png|webp)$/i', $path);
    }

    /** @return array{license_photo: bool, recto: bool, verso: bool, signature: bool} */
    public function status(User $user): array
    {
        return [
            'license_photo' => $this->exists($user, 'license_photo'),
            'recto' => $this->exists($user, 'recto'),
            'verso' => $this->exists($user, 'verso'),
            'signature' => $this->exists($user, 'signature'),
        ];
    }

    /**
     * @param  array{license_photo?: UploadedFile|null, recto?: UploadedFile|null, verso?: UploadedFile|null, signature?: UploadedFile|null}  $files
     */
    public function storeMany(User $user, array $files): User
    {
        $updates = [];

        if (! empty($files['license_photo'])) {
            $updates['license_photo_path'] = $this->storeFile($user, 'license_photo', $files['license_photo']);
        }
        if (! empty($files['recto'])) {
            $updates['dni_recto_path'] = $this->storeFile($user, 'recto', $files['recto']);
        }
        if (! empty($files['verso'])) {
            $updates['dni_verso_path'] = $this->storeFile($user, 'verso', $files['verso']);
        }
        if (! empty($files['signature'])) {
            $updates['signature_path'] = $this->storeFile($user, 'signature', $files['signature']);
        }

        if ($updates !== []) {
            $user->update($updates);
        }

        return $user->fresh();
    }

    public function storeFile(User $user, string $type, UploadedFile $file): string
    {
        $old = $this->pathFor($user, $type);
        if ($old) {
            Storage::disk('local')->delete($old);
        }

        $folder = match ($type) {
            'signature' => 'dgt_signatures',
            'license_photo' => 'dgt_license_photos',
            default => 'dgt_ids',
        };

        $dir = $folder.'/user-'.$user->id;

        if ($type === 'license_photo') {
            return $this->storeProcessedLicensePhoto($user, $file, $dir);
        }

        return $file->store($dir, 'local');
    }

    private function storeProcessedLicensePhoto(User $user, UploadedFile $file, string $dir): string
    {
        $processor = app(LicensePhotoProcessor::class);
        $processedPath = $processor->process($file);
        $relative = $dir.'/license-'.now()->format('Ymd-His').'.jpg';

        try {
            Storage::disk('local')->put($relative, (string) file_get_contents($processedPath));

            return $relative;
        } finally {
            if (is_file($processedPath) && str_starts_with($processedPath, sys_get_temp_dir())) {
                @unlink($processedPath);
            }
        }
    }

    public function absolutePath(?string $relativePath): ?string
    {
        if (! $relativePath || ! Storage::disk('local')->exists($relativePath)) {
            return null;
        }

        return storage_path('app/'.$relativePath);
    }
}
