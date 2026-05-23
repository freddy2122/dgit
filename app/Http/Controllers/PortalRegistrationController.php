<?php

namespace App\Http\Controllers;

use App\Mail\OtpVerificationMail;
use App\Mail\WelcomePortalMail;
use App\Models\RegistrationDraft;
use App\Models\User;
use App\Services\PortalUserDataProvisioner;
use App\Services\UserDocumentService;
use App\Support\VerificationCode;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class PortalRegistrationController extends Controller
{
    public const SESSION_AUTH = 'portal_auth_method';

    public const SESSION_DRAFT = 'portal_draft_id';

    public function showInscription(): View
    {
        return view('portal.inscription');
    }

    public function chooseMethod(Request $request): RedirectResponse
    {
        $request->validate([
            'auth_method' => ['required', Rule::in(['clave_mobile', 'certificate', 'clave_permanent'])],
        ]);

        $method = $request->auth_method;

        if (in_array($method, ['clave_mobile', 'clave_permanent'], true)) {
            return redirect()->to(portal_route('clave.conectar', [
                'intent' => 'register',
            ]));
        }

        session([self::SESSION_AUTH => $method]);

        return redirect()->to(portal_route('portal.identity'));
    }

    public function showIdentity(): View|RedirectResponse
    {
        if (! session(self::SESSION_AUTH)) {
            return redirect()->to(portal_route('portal.inscription'));
        }

        return view('portal.identity', [
            'auth_method' => session(self::SESSION_AUTH),
            'prefillNie' => session(ClaveAuthController::SESSION_CLAVE_NIE) ?? old('nie'),
            'prefillPhone' => session('clave_inscripcion_phone') ?? old('phone'),
            'prefillEmail' => session('clave_inscripcion_email') ?? old('email'),
        ]);
    }

    public function storeIdentity(Request $request): RedirectResponse
    {
        if (! session(self::SESSION_AUTH)) {
            return redirect()->to(portal_route('portal.inscription'));
        }

        $nie = $this->normalizeNie($request->input('nie'));
        $email = strtolower(trim((string) $request->input('email')));
        $request->merge(['nie' => $nie, 'email' => $email]);

        $validated = $request->validate([
            'nie' => ['required', 'string', 'regex:/^([0-9]{8}|[XYZ][0-9]{7})[A-Z]$/i'],
            'birth_date' => ['required', 'date', 'before:today'],
            'phone' => ['required', 'string', 'max:32'],
            'email' => ['required', 'email'],
        ], [
            'nie.regex' => __('site.registration.nie_invalid'),
        ]);

        $phone = preg_replace('/\s+/', '', $validated['phone']);

        $activeUser = User::query()
            ->where(function ($q) use ($nie, $email) {
                $q->where('nie', $nie)->orWhere('email', $email);
            })
            ->where('is_active', true)
            ->first();

        if ($activeUser) {
            throw ValidationException::withMessages([
                'nie' => __('site.registration.account_exists'),
            ]);
        }

        $inactive = User::query()
            ->where(function ($q) use ($nie, $email) {
                $q->where('nie', $nie)->orWhere('email', $email);
            })
            ->where('is_active', false)
            ->first();

        if ($inactive) {
            throw ValidationException::withMessages([
                'email' => __('site.registration.account_inactive'),
            ]);
        }

        $code = (string) random_int(100000, 999999);

        $draft = RegistrationDraft::query()->create([
            'auth_method' => (string) session(self::SESSION_AUTH),
            'nie' => $nie,
            'birth_date' => $validated['birth_date'],
            'phone' => $phone,
            'email' => $email,
            'otp_hash' => Hash::make($code),
            'otp_expires_at' => now()->addMinutes(5),
            'otp_attempts' => 0,
        ]);

        session([self::SESSION_DRAFT => $draft->id]);

        Mail::to($email)->send(new OtpVerificationMail($draft, $code));

        Log::info('[SMS maquette DGT]', [
            'telephone' => $phone,
            'message' => __('site.registration.sms_log', ['code' => $code]),
        ]);

        return redirect()->route('portal.verify')->with('status', __('site.registration.code_sent'));
    }

    public function showVerify(): View|RedirectResponse
    {
        $draft = $this->currentDraft();
        if (! $draft) {
            return redirect()->route('portal.inscription');
        }
        if ($draft->otp_verified_at) {
            return redirect()->route('portal.complete');
        }

        return view('portal.verify-code', ['draft' => $draft]);
    }

    public function verifyCode(Request $request): RedirectResponse
    {
        $draft = $this->currentDraft();
        if (! $draft || $draft->otp_verified_at) {
            return redirect()->route('portal.inscription');
        }

        if ($draft->otpExpired()) {
            return redirect()->route('portal.verify')->withErrors(['code' => __('site.registration.code_expired')]);
        }

        if ($draft->otp_attempts >= 5) {
            throw ValidationException::withMessages(['code' => __('site.registration.too_many_attempts')]);
        }

        $request->validate([
            'code' => ['required', 'digits:6'],
        ]);

        if (! Hash::check($request->input('code'), $draft->otp_hash ?? '')) {
            $draft->increment('otp_attempts');

            throw ValidationException::withMessages(['code' => __('site.registration.code_invalid')]);
        }

        $draft->update([
            'otp_verified_at' => now(),
        ]);

        return redirect()->route('portal.complete')->with('status', __('site.registration.code_verified'));
    }

    public function showComplete(): View|RedirectResponse
    {
        $draft = $this->currentDraft();
        if (! $draft || ! $draft->otp_verified_at) {
            return redirect()->route('portal.inscription');
        }
        if ($draft->completed_at) {
            return redirect()->route('home')->with('status', __('site.registration.already_completed'));
        }

        return view('portal.complete', ['draft' => $draft]);
    }

    public function complete(Request $request): RedirectResponse
    {
        $draft = $this->currentDraft();
        if (! $draft || ! $draft->otp_verified_at || $draft->completed_at) {
            return redirect()->route('portal.inscription');
        }

        $validated = $request->validate([
            'first_name' => ['required', 'string', 'max:120'],
            'last_name' => ['required', 'string', 'max:120'],
            'nie' => ['required', 'string'],
            'phone' => ['required', 'string', 'max:32'],
            'email' => ['required', 'email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'address' => ['required', 'string', 'max:500'],
            'dni_recto' => ['nullable', 'file', 'max:5120', 'mimes:jpg,jpeg,png,pdf'],
            'dni_verso' => ['nullable', 'file', 'max:5120', 'mimes:jpg,jpeg,png,pdf'],
            'signature' => ['nullable', 'file', 'max:2048', 'mimes:jpg,jpeg,png'],
        ]);

        if ($this->normalizeNie($validated['nie']) !== $draft->nie) {
            throw ValidationException::withMessages(['nie' => __('site.registration.nie_mismatch')]);
        }
        if (strtolower(trim($validated['email'])) !== $draft->email) {
            throw ValidationException::withMessages(['email' => __('site.registration.email_mismatch')]);
        }
        if (preg_replace('/\s+/', '', trim($validated['phone'])) !== $draft->phone) {
            throw ValidationException::withMessages(['phone' => __('site.registration.phone_mismatch')]);
        }

        $dossier = 'DGT-'.strtoupper(Str::random(10));
        $activationToken = Str::random(64);

        $user = User::query()->create([
            'name' => trim($validated['first_name'].' '.$validated['last_name']),
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'email' => $draft->email,
            'password' => $validated['password'],
            'nie' => $draft->nie,
            'phone' => $draft->phone,
            'birth_date' => $draft->birth_date,
            'address' => $validated['address'],
            'auth_method' => $draft->auth_method,
            'is_active' => false,
            'dossier_number' => $dossier,
            'verification_code' => VerificationCode::generate(),
            'dni_recto_path' => null,
            'dni_verso_path' => null,
            'signature_path' => null,
        ]);

        app(UserDocumentService::class)->storeMany($user, [
            'recto' => $request->file('dni_recto'),
            'verso' => $request->file('dni_verso'),
            'signature' => $request->file('signature'),
        ]);
        $user->refresh();

        $draft->update([
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'address' => $validated['address'],
            'dni_recto_path' => $user->dni_recto_path,
            'dni_verso_path' => $user->dni_verso_path,
            'dossier_number' => $dossier,
            'activation_token' => $activationToken,
            'user_id' => $user->id,
            'completed_at' => now(),
        ]);

        PortalUserDataProvisioner::ensureProfile($user->fresh());
        PortalUserDataProvisioner::ensureEmptyLicense($user);

        $activationUrl = route('portal.activate', ['token' => $activationToken], true);

        Mail::to($user->email)->send(new WelcomePortalMail($user, $activationUrl));

        session()->forget([self::SESSION_AUTH, self::SESSION_DRAFT]);

        return redirect()->route('login')->with('status', __('site.registration.registered'));
    }

    public function activate(string $token): RedirectResponse
    {
        $draft = RegistrationDraft::query()->where('activation_token', $token)->first();
        if (! $draft || ! $draft->user_id) {
            abort(404);
        }
        $user = User::query()->findOrFail($draft->user_id);
        $user->update(['is_active' => true]);
        $draft->update(['activation_token' => null]);

        return redirect()->route('login')->with('status', __('site.registration.activated'));
    }

    private function currentDraft(): ?RegistrationDraft
    {
        $id = session(self::SESSION_DRAFT);
        if (! $id) {
            return null;
        }

        return RegistrationDraft::query()->find($id);
    }

    private function normalizeNie(?string $nie): string
    {
        $n = strtoupper(preg_replace('/\s+/', '', (string) $nie) ?? '');

        return $n;
    }
}
