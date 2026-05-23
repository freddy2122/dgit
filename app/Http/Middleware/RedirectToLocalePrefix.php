<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RedirectToLocalePrefix
{
    /** @var list<string> */
    private const LOCALES = ['es', 'fr'];

    /** @var list<string> */
    private const EXCLUDED_PREFIXES = [
        'admin',
        'sanctum',
        '_ignition',
        'livewire',
        'storage',
        'api',
    ];

    public function handle(Request $request, Closure $next): Response
    {
        if (in_array($request->segment(1), self::LOCALES, true)) {
            return $next($request);
        }

        foreach (self::EXCLUDED_PREFIXES as $prefix) {
            if ($request->segment(1) === $prefix || str_starts_with($request->path(), $prefix.'/')) {
                return $next($request);
            }
        }

        $locale = $request->session()->get('portal_locale', portal_default_locale());
        if (! in_array($locale, self::LOCALES, true)) {
            $locale = portal_default_locale();
        }

        $path = trim($request->path(), '/');
        $target = $path === '' ? "/{$locale}" : "/{$locale}/{$path}";

        if ($query = $request->getQueryString()) {
            $target .= '?'.$query;
        }

        return redirect($target, 302);
    }
}
