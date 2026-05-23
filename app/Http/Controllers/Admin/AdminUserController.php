<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Vehicle;
use App\Services\AdminLicenseService;
use App\Services\PortalNotificationService;
use App\Services\PortalUserDataProvisioner;
use App\Services\UserDocumentService;
use App\Support\VerificationCode;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class AdminUserController extends Controller
{
    public function __construct(
        private AdminLicenseService $licenses,
        private PortalNotificationService $notifications,
        private UserDocumentService $documents,
    ) {}

    public function index(Request $request): View
    {
        $query = User::query()->latest('id');

        if ($role = $request->query('role')) {
            $query->where('role', $role);
        } else {
            $query->where('role', 'user');
        }

        if ($search = trim((string) $request->query('q'))) {
            $query->where(function ($q) use ($search) {
                $q->where('email', 'like', "%{$search}%")
                    ->orWhere('nie', 'like', "%{$search}%")
                    ->orWhere('name', 'like', "%{$search}%")
                    ->orWhere('verification_code', 'like', "%{$search}%");
            });
        }

        $users = $query->with('licenseSummary')->paginate(25);
        $users->appends($request->query());

        return view('admin.users.index', [
            'users' => $users,
        ]);
    }

    public function create(): View
    {
        return view('admin.users.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'first_name' => ['required', 'string', 'max:100'],
            'last_name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'nie' => ['required', 'string', 'max:14'],
            'birth_date' => ['required', 'date'],
            'phone' => ['nullable', 'string', 'max:20'],
            'password' => ['required', 'string', 'min:8'],
        ]);

        $user = User::query()->create([
            'name' => trim($validated['first_name'].' '.$validated['last_name']),
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'nie' => strtoupper(preg_replace('/\s+/', '', $validated['nie'])),
            'birth_date' => $validated['birth_date'],
            'phone' => $validated['phone'] ?? null,
            'role' => 'user',
            'is_active' => true,
            'verification_code' => VerificationCode::generate(),
        ]);

        PortalUserDataProvisioner::ensureProfile($user);
        $this->licenses->ensureLicenseRecord($user);

        $this->notifications->notify($user, 'admin.notif_account_created_title', 'admin.notif_account_created_body', [
            'code' => $user->verification_code,
        ]);

        return redirect()
            ->route('admin.users.show', $user)
            ->with('status', __('admin.user_created'));
    }

    public function show(User $user): View
    {
        $user->load([
            'licenseSummary',
            'permitApplications',
            'vehicles',
            'portalPayments' => fn ($q) => $q->orderByDesc('due_date'),
            'portalNotifications' => fn ($q) => $q->latest('notified_at')->limit(5),
            'licensePointEvents' => fn ($q) => $q->limit(10),
        ]);

        return view('admin.users.show', ['user' => $user]);
    }

    public function updateLicense(Request $request, User $user): RedirectResponse
    {
        $validated = $request->validate([
            'points' => ['nullable', 'integer', 'min:0', 'max:12'],
            'category' => ['nullable', 'string', 'max:8'],
            'valid_until' => ['nullable', 'date'],
            'issued_at' => ['nullable', 'date'],
            'authority_code' => ['nullable', 'string', 'max:8'],
            'application_status' => ['nullable', 'string', 'max:40'],
            'categories' => ['nullable', 'array'],
            'categories.*' => ['string', 'max:4'],
        ]);

        // Cases décochées = absentes du POST → on enregistre une liste vide
        $validated['categories'] = $request->input('categories', []);

        $this->licenses->updateLicense($user, $validated);

        if ($user->email) {
            $this->notifications->notify($user, 'admin.notif_license_updated_title', 'admin.notif_license_updated_body', []);
        }

        return back()->with('status', __('admin.license_updated'));
    }

    public function adjustPoints(Request $request, User $user): RedirectResponse
    {
        $validated = $request->validate([
            'delta' => ['required', 'integer', 'not_in:0', 'between:-12,12'],
            'reason' => ['required', 'string', 'max:255'],
        ]);

        $this->licenses->adjustPoints($user, (int) $validated['delta'], $validated['reason']);

        $this->notifications->notify($user, 'admin.notif_points_updated_title', 'admin.notif_points_updated_body', [
            'delta' => $validated['delta'],
        ]);

        return back()->with('status', __('admin.points_updated'));
    }

    public function regenerateCode(User $user): RedirectResponse
    {
        $code = VerificationCode::generate();
        $user->update(['verification_code' => $code]);

        $this->notifications->notify($user, 'admin.notif_code_regenerated_title', 'admin.notif_code_regenerated_body', [
            'code' => $code,
        ]);

        return back()->with('status', __('admin.code_regenerated'));
    }

    public function storeVehicle(Request $request, User $user): RedirectResponse
    {
        $validated = $request->validate([
            'plate' => ['required', 'string', 'max:20'],
            'vehicle_type' => ['required', 'string', 'max:80'],
            'itv_valid_until' => ['nullable', 'date'],
            'status' => ['required', 'in:valid,pending,invalid'],
            'is_motorcycle' => ['nullable', 'boolean'],
        ]);

        $user->vehicles()->create([
            'plate' => $validated['plate'],
            'vehicle_type' => $validated['vehicle_type'],
            'itv_valid_until' => $validated['itv_valid_until'] ?? null,
            'status' => $validated['status'],
            'is_motorcycle' => (bool) ($validated['is_motorcycle'] ?? false),
        ]);

        $this->notifications->notify($user, 'admin.notif_vehicle_added_title', 'admin.notif_vehicle_added_body', [
            'plate' => $validated['plate'],
        ]);

        return back()->with('status', __('admin.vehicle_added'));
    }

    public function destroyVehicle(User $user, Vehicle $vehicle): RedirectResponse
    {
        abort_unless($vehicle->user_id === $user->id, 404);
        $vehicle->delete();

        return back()->with('status', __('admin.vehicle_removed'));
    }

    public function uploadDocuments(Request $request, User $user): RedirectResponse
    {
        abort_unless($user->role === 'user', 404);

        $request->validate([
            'license_photo' => ['nullable', 'file', 'max:5120', 'mimes:jpg,jpeg,png,webp', new \App\Rules\LicensePhotoFile],
            'dni_recto' => ['nullable', 'file', 'max:5120', 'mimes:jpg,jpeg,png,pdf'],
            'dni_verso' => ['nullable', 'file', 'max:5120', 'mimes:jpg,jpeg,png,pdf'],
            'signature' => ['nullable', 'file', 'max:2048', 'mimes:jpg,jpeg,png'],
        ]);

        if (! $request->hasFile('license_photo') && ! $request->hasFile('dni_recto') && ! $request->hasFile('dni_verso') && ! $request->hasFile('signature')) {
            return back()->withErrors(['documents' => __('admin.documents_none_selected')]);
        }

        $this->documents->storeMany($user, [
            'license_photo' => $request->file('license_photo'),
            'recto' => $request->file('dni_recto'),
            'verso' => $request->file('dni_verso'),
            'signature' => $request->file('signature'),
        ]);

        if ($user->email) {
            $this->notifications->notify($user, 'admin.notif_documents_updated_title', 'admin.notif_documents_updated_body', []);
        }

        return back()->with('status', __('admin.documents_saved'));
    }

    public function document(User $user, string $type): BinaryFileResponse|Response
    {
        abort_unless($user->role === 'user', 404);
        abort_unless(in_array($type, UserDocumentService::TYPES, true), 404);

        $absolute = $this->documents->absolutePath($this->documents->pathFor($user, $type));
        abort_unless($absolute, 404);

        return response()->file($absolute);
    }
}
