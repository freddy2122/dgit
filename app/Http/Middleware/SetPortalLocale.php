<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\URL;
use Symfony\Component\HttpFoundation\Response;

class SetPortalLocale
{
    /** @var list<string> */
    private const ALLOWED = ['es', 'fr'];

    public function handle(Request $request, Closure $next): Response
    {
        // Backoffice admin : interface toujours en français
        if ($request->is('admin') || $request->is('admin/*')) {
            App::setLocale('fr');

            return $next($request);
        }

        $locale = $request->segment(1);

        if (! in_array($locale, self::ALLOWED, true)) {
            $locale = $request->session()->get('portal_locale', portal_default_locale());
        }

        if (! in_array($locale, self::ALLOWED, true)) {
            $locale = portal_default_locale();
        }

        $request->session()->put('portal_locale', $locale);
        App::setLocale($locale);
        URL::defaults(['locale' => $locale]);

        return $next($request);
    }
}
