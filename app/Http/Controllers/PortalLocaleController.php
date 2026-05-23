<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class PortalLocaleController extends Controller
{
    /** @var list<string> */
    private const ALLOWED = ['es', 'fr'];

    public function update(Request $request, string $locale): RedirectResponse
    {
        $newLocale = $request->input('locale', $locale);

        if (! in_array($newLocale, self::ALLOWED, true)) {
            $newLocale = 'es';
        }

        $request->session()->put('portal_locale', $newLocale);

        return redirect()->to(locale_switch_url($newLocale));
    }
}
