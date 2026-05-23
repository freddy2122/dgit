<?php

namespace App\Support;

use App\Models\User;
use Illuminate\Support\Str;

class VerificationCode
{
    public static function generate(): string
    {
        do {
            $code = 'VER-'.strtoupper(Str::random(4)).'-'.strtoupper(Str::random(4));
        } while (User::query()->where('verification_code', $code)->exists());

        return $code;
    }

    public static function normalize(?string $code): string
    {
        return strtoupper(preg_replace('/\s+/', '', (string) $code));
    }
}
