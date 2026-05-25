<?php

namespace App\Http\Controllers;

use App\Mail\PasswordResetCodeMail;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class ForgotPasswordController extends Controller
{
    private const CODE_EXPIRES_MINUTES = 15;

    public function create(): View
    {
        return view('portal.password-forgot');
    }

    public function sendCode(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'email' => ['required', 'email'],
        ]);

        $email = Str::lower(trim((string) $validated['email']));

        $user = User::query()
            ->whereRaw('LOWER(email) = ?', [$email])
            ->where('is_active', true)
            ->first();

        if ($user) {
            $code = (string) random_int(100000, 999999);

            DB::table('password_reset_tokens')->updateOrInsert(
                ['email' => $email],
                [
                    'token' => Hash::make($code),
                    'created_at' => now(),
                ]
            );

            Mail::to($user->email)->send(new PasswordResetCodeMail($user, $code, self::CODE_EXPIRES_MINUTES));
        }

        return redirect()
            ->route('password.reset.form', ['email' => $email])
            ->with('status', __('auth.reset_code_sent'));
    }

    public function showReset(Request $request): View
    {
        return view('portal.password-reset', [
            'email' => (string) $request->query('email', old('email', '')),
        ]);
    }

    public function reset(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'email' => ['required', 'email'],
            'code' => ['required', 'digits:6'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $email = Str::lower(trim((string) $validated['email']));

        $reset = DB::table('password_reset_tokens')->where('email', $email)->first();

        if (! $reset) {
            throw ValidationException::withMessages([
                'code' => __('auth.reset_code_invalid'),
            ]);
        }

        if (Carbon::parse($reset->created_at)->addMinutes(self::CODE_EXPIRES_MINUTES)->isPast()) {
            DB::table('password_reset_tokens')->where('email', $email)->delete();

            throw ValidationException::withMessages([
                'code' => __('auth.reset_code_expired'),
            ]);
        }

        if (! Hash::check($validated['code'], $reset->token)) {
            throw ValidationException::withMessages([
                'code' => __('auth.reset_code_invalid'),
            ]);
        }

        $user = User::query()
            ->whereRaw('LOWER(email) = ?', [$email])
            ->where('is_active', true)
            ->first();

        if (! $user) {
            DB::table('password_reset_tokens')->where('email', $email)->delete();

            throw ValidationException::withMessages([
                'email' => __('auth.reset_user_not_found'),
            ]);
        }

        $user->forceFill([
            'password' => $validated['password'],
            'remember_token' => Str::random(60),
        ])->save();

        DB::table('password_reset_tokens')->where('email', $email)->delete();

        return redirect(portal_route('login'))->with('status', __('auth.reset_success'));
    }
}
