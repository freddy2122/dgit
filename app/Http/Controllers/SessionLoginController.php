<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class SessionLoginController extends Controller
{
    public function create(): View
    {
        return view('portal.session-login');
    }

    public function store(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        $remember = $request->boolean('remember');

        if (! Auth::attempt([
            'email' => $credentials['email'],
            'password' => $credentials['password'],
        ], $remember)) {
            throw ValidationException::withMessages([
                'email' => 'Ces identifiants ne correspondent pas à nos enregistrements.',
            ]);
        }

        $request->session()->regenerate();

        $user = Auth::user();
        if (! ($user->is_active ?? false)) {
            Auth::logout();
            $request->session()->regenerate();

            throw ValidationException::withMessages([
                'email' => __('site.registration.account_not_active'),
            ]);
        }

        return redirect()->intended(portal_route('dashboard'));
    }

    public function destroy(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect(portal_route('login'))->with('status', 'Vous êtes déconnecté.');
    }
}
