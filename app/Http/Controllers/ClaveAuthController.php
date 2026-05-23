<?php

namespace App\Http\Controllers;

use App\Http\Controllers\PortalRegistrationController;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class ClaveAuthController extends Controller
{
    public const SESSION_CLAVE_NIE = 'clave_verified_nie';

    public const SESSION_CLAVE_NAME = 'clave_verified_name';

    public function redirectRoot(): RedirectResponse
    {
        return redirect()->to(portal_route('clave.conectar'));
    }

    public function showConnect(Request $request): View
    {
        return view('portal.clave-connect', [
            'intent' => $request->query('intent', 'login'),
            'next' => $request->query('next'),
            'prefillNie' => session(self::SESSION_CLAVE_NIE) ?? old('nie'),
        ]);
    }

    public function connect(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nie' => ['required', 'string', 'max:16', 'regex:/^([0-9]{8}|[xyz][0-9]{7})[a-z]$/i'],
            'password' => ['required', 'string', 'min:4'],
            'intent' => ['nullable', 'in:login,register'],
        ], $this->validationMessages());

        $nie = $this->normalizeNie($validated['nie']);
        $intent = $validated['intent'] ?? 'login';

        session([
            self::SESSION_CLAVE_NIE => $nie,
            self::SESSION_CLAVE_NAME => __('portal.clave.session_ok'),
        ]);

        if ($intent === 'register') {
            session([PortalRegistrationController::SESSION_AUTH => 'clave_mobile']);

            return redirect()
                ->to(portal_route('portal.identity'))
                ->with('status', __('portal.clave.register_ok'));
        }

        $user = $this->findUserByNie($nie);

        if ($user && ($user->is_active ?? false)) {
            if (! Hash::check($validated['password'], (string) $user->password)) {
                throw ValidationException::withMessages([
                    'password' => __('portal.clave.invalid_credentials'),
                ]);
            }

            Auth::login($user);
            $request->session()->regenerate();

            $next = $request->input('next');
            if ($next === 'dashboard') {
                return redirect()->to(portal_route('dashboard'));
            }

            return redirect()->intended(portal_route('dashboard'));
        }

        if ($user && ! ($user->is_active ?? false)) {
            return redirect()
                ->to(portal_route('login'))
                ->withErrors(['email' => __('portal.clave.account_inactive')]);
        }

        return redirect()
            ->to(portal_route('portal.inscription'))
            ->with('status', __('portal.clave.no_account_register'));
    }

    public function showInscripcion(): View
    {
        return view('portal.clave-inscripcion');
    }

    public function submitInscripcion(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'doc_type' => ['required', 'in:DNI,NIE'],
            'nie' => ['required', 'string', 'regex:/^([0-9]{8}|[XYZ][0-9]{7})[A-Z]$/i'],
            'phone' => ['required', 'string', 'max:32'],
            'email' => ['required', 'email'],
        ], $this->validationMessages());

        $nie = $this->normalizeNie($validated['nie']);

        session([
            self::SESSION_CLAVE_NIE => $nie,
            PortalRegistrationController::SESSION_AUTH => 'clave_mobile',
            'clave_inscripcion_phone' => preg_replace('/\s+/', '', $validated['phone']),
            'clave_inscripcion_email' => strtolower(trim($validated['email'])),
        ]);

        return redirect()
            ->to(portal_route('portal.identity'))
            ->with('status', __('portal.clave.inscripcion_ok'));
    }

    private function normalizeNie(?string $nie): string
    {
        return strtolower(preg_replace('/\s+/', '', (string) $nie) ?? '');
    }

    private function findUserByNie(string $nie): ?User
    {
        $normalized = $this->normalizeNie($nie);

        return User::query()
            ->where(function ($q) use ($normalized) {
                $q->where('nie', $normalized)
                    ->orWhere('nie', strtoupper($normalized));
            })
            ->first();
    }

    /** @return array<string, string> */
    private function validationMessages(): array
    {
        return [
            'nie.required' => __('portal.clave.validation_nie_required'),
            'nie.max' => __('portal.clave.validation_nie_max'),
            'nie.regex' => __('portal.clave.validation_nie_format'),
            'password.required' => __('portal.clave.validation_password_required'),
            'password.min' => __('portal.clave.validation_password_min'),
            'email.required' => __('portal.clave.validation_email_required'),
            'email.email' => __('portal.clave.validation_email_format'),
            'phone.required' => __('portal.clave.validation_phone_required'),
        ];
    }
}
