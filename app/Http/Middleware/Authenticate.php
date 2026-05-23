<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        if ($request->expectsJson()) {
            return null;
        }

        $locale = $request->route('locale') ?? $request->segment(1);
        if (! in_array($locale, ['es', 'fr'], true)) {
            $locale = $request->session()->get('portal_locale', 'es');
        }

        return route('login', ['locale' => $locale]);
    }
}
