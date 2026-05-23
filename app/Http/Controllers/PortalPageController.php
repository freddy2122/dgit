<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\ResolvesPortalUser;
use App\Models\PortalAppointment;
use App\Models\PortalPayment;
use App\Services\PortalDashboardService;
use App\Services\PortalNotificationService;
use App\Services\UserDocumentService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PortalPageController extends Controller
{
    use ResolvesPortalUser;

    public function __construct(
        private PortalDashboardService $portal,
        private UserDocumentService $documents,
        private PortalNotificationService $notifications,
    ) {
        $this->middleware('auth');
    }

    public function payments(): View
    {
        $user = $this->portalUser();
        $this->portal->ensureProvisioned($user);

        $payments = $user->portalPayments()->orderByDesc('due_date')->get();
        $pending = $payments->whereIn('status', ['pending', 'awaiting_whatsapp']);
        $paid = $payments->where('status', 'paid');

        return view('portal.payments', [
            'payments' => $payments,
            'pending' => $pending,
            'paid' => $paid,
            'pendingTotal' => number_format((float) $pending->sum('amount'), 2, ',', ''),
        ]);
    }

    public function pay(Request $request): RedirectResponse
    {
        return redirect()
            ->route('portal.payments')
            ->with('portal_success', __('tramite.payment_whatsapp_only'));
    }

    public function appointments(): View
    {
        $user = $this->portalUser();
        $this->portal->ensureProvisioned($user);

        return view('portal.appointments', [
            'appointments' => $user->portalAppointments()->orderBy('appointment_date')->get(),
            'offices' => [
                'Jefatura Provincial de Tráfico — Madrid',
                'Jefatura Provincial de Tráfico — Barcelona',
                'Oficina de Tráfico — Valencia',
            ],
            'procedures' => [
                __('portal.demarches.renewal'),
                __('portal.dashboard.procedure_duplicate'),
                __('portal.dashboard.procedure_vehicle'),
            ],
        ]);
    }

    public function storeAppointment(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'office' => ['required', 'string', 'max:120'],
            'procedure' => ['required', 'string', 'max:120'],
            'appointment_date' => ['required', 'date', 'after_or_equal:today'],
            'appointment_time' => ['required', 'string', 'max:8'],
        ]);

        PortalAppointment::query()->create([
            'user_id' => auth()->id(),
            'office' => $validated['office'],
            'procedure' => $validated['procedure'],
            'appointment_date' => $validated['appointment_date'],
            'appointment_time' => $validated['appointment_time'],
            'status' => 'confirmed',
        ]);

        return redirect()
            ->route('portal.appointments')
            ->with('portal_success', __('portal.appointments.success'));
    }

    public function profile(): View
    {
        $user = $this->portalUser();
        $this->portal->ensureProvisioned($user);

        return view('portal.profile', [
            'user' => $user,
            'docStatus' => $this->documents->status($user),
        ]);
    }

    public function storeDocuments(Request $request): RedirectResponse
    {
        $user = $this->portalUser();

        $request->validate([
            'license_photo' => ['nullable', 'file', 'max:5120', 'mimes:jpg,jpeg,png,webp', new \App\Rules\LicensePhotoFile],
            'dni_recto' => ['nullable', 'file', 'max:5120', 'mimes:jpg,jpeg,png,pdf'],
            'dni_verso' => ['nullable', 'file', 'max:5120', 'mimes:jpg,jpeg,png,pdf'],
            'signature' => ['nullable', 'file', 'max:2048', 'mimes:jpg,jpeg,png'],
        ]);

        if (! $request->hasFile('license_photo') && ! $request->hasFile('dni_recto') && ! $request->hasFile('dni_verso') && ! $request->hasFile('signature')) {
            return back()->withErrors(['documents' => __('portal.profile.documents_none_selected')]);
        }

        $this->documents->storeMany($user, [
            'license_photo' => $request->file('license_photo'),
            'recto' => $request->file('dni_recto'),
            'verso' => $request->file('dni_verso'),
            'signature' => $request->file('signature'),
        ]);

        $target = match ($request->input('redirect_to')) {
            'licence.digital' => portal_route('licence.digital'),
            'portal.profile' => portal_route('portal.profile'),
            default => portal_route('dashboard'),
        };

        return redirect()
            ->to($target)
            ->with('portal_success', __('portal.profile.documents_saved'));
    }

    public function notifications(): View
    {
        $user = $this->portalUser();
        $this->portal->ensureProvisioned($user);

        return view('portal.notifications', [
            'notifications' => $user->portalNotifications()->latest('notified_at')->get(),
        ]);
    }

}
