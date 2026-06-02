<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PermitApplication;
use App\Models\PortalPayment;
use App\Models\User;
use App\Services\AdminActivityLogger;
use App\Services\PortalNotificationService;
use App\Services\PermitTramiteService;
use App\Support\ExamResultPresenter;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminApplicationController extends Controller
{
    public function __construct(
        private PermitTramiteService $tramites,
        private AdminActivityLogger $logger,
        private PortalNotificationService $notifications,
    ) {
    }

    public function index(Request $request): View
    {
        $query = PermitApplication::query()->with('user')->latest('updated_at');

        if ($status = $request->query('status')) {
            $query->where('status', $status);
        }

        if ($search = trim((string) $request->query('q'))) {
            $query->where(function ($q) use ($search) {
                $q->where('reference_code', 'like', "%{$search}%")
                    ->orWhere('nie', 'like', "%{$search}%")
                    ->orWhereHas('user', fn ($u) => $u
                        ->where('email', 'like', "%{$search}%")
                        ->orWhere('name', 'like', "%{$search}%")
                        ->orWhere('last_name', 'like', "%{$search}%"));
            });
        }

        return view('admin.applications.index', [
            'applications' => tap($query->paginate(20), fn ($p) => $p->appends($request->query())),
        ]);
    }

    public function create(Request $request): View
    {
        return view('admin.applications.create', [
            'users' => User::query()->where('role', 'user')->orderBy('name')->get(),
            'types' => config('dgt_tramites.types', []),
            'categoryCodes' => \App\Models\LicenseSummary::categoryCodes(),
            'selectedUserId' => $request->integer('user_id') ?: null,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'user_id' => ['required', 'exists:users,id'],
            'tramite_type' => ['required', 'string', 'in:'.implode(',', array_keys(config('dgt_tramites.types', [])))],
            'requested_category' => ['nullable', 'string', 'max:8'],
            'medical_certificate' => ['nullable', 'file', 'max:5120', 'mimes:jpg,jpeg,png,pdf'],
        ]);

        $user = User::query()->findOrFail($validated['user_id']);
        $medical = $request->file('medical_certificate');

        $application = $this->tramites->submit(
            $user,
            $validated['tramite_type'],
            null,
            $medical,
            auth()->id(),
            $validated['requested_category'] ?? null,
        );

        $this->logger->log('application.create', $application);

        return redirect()
            ->route('admin.applications.show', $application)
            ->with('status', __('admin.application_created'));
    }

    public function show(PermitApplication $application): View
    {
        $application->load(['user.licenseSummary', 'validator', 'payments', 'openedByUser']);

        $presenter = new ExamResultPresenter($application, $application->user, $application->user?->licenseSummary);

        return view('admin.applications.show', [
            'application' => $application,
            'typeLabel' => $this->tramites->typeLabel($application->tramite_type ?? 'obtencion'),
            'nextStatuses' => $this->nextStatuses($application->status),
            'suggestedTramitacionPercent' => $presenter->statusDefaultValidationPercent(),
            'clientTramitacionPercent' => $presenter->validationPercent(),
            'categoryCodes' => \App\Models\LicenseSummary::categoryCodes(),
        ]);
    }

    public function confirmPayment(PermitApplication $application, PortalPayment $payment): RedirectResponse
    {
        abort_unless($payment->permit_application_id === $application->id, 404);
        $this->tramites->confirmPayment($payment);
        $this->logger->log('payment.confirm_whatsapp', $payment);

        return back()->with('status', __('admin.payment_confirmed'));
    }

    public function advanceStatus(Request $request, PermitApplication $application): RedirectResponse
    {
        $validated = $request->validate([
            'status' => ['required', 'string'],
        ]);

        $this->tramites->advanceStatus($application, $validated['status']);
        $this->logger->log('application.advance', $application, $validated['status']);

        return back()->with('status', __('admin.status_updated'));
    }

    public function approve(PermitApplication $application): RedirectResponse
    {
        $sequence = ['en_attente_paiement_whatsapp', 'en_tramitacion', 'permiso_provisional', 'en_fabricacion', 'expedido', 'valide'];
        $idx = array_search($application->status, $sequence, true);

        if ($idx === false) {
            return back()->withErrors(['status' => __('admin.cannot_fast_validate')]);
        }

        for ($i = $idx + 1; $i < count($sequence); $i++) {
            $application = $this->tramites->advanceStatus($application, $sequence[$i]);
        }

        $this->logger->log('application.validate', $application);

        return back()->with('status', __('admin.application_validated'));
    }

    public function updateExam(Request $request, PermitApplication $application): RedirectResponse
    {
        $validated = $request->validate([
            'exam_score' => ['nullable', 'integer', 'min:0', 'max:100'],
            'exam_errors' => ['nullable', 'integer', 'min:0', 'max:30'],
            'tramitacion_percent' => ['nullable', 'integer', 'min:0', 'max:100'],
            'score_improvement_paid' => ['nullable', 'boolean'],
        ]);

        $application->update([
            'exam_score' => $request->filled('exam_score') ? (int) $validated['exam_score'] : null,
            'exam_errors' => $request->filled('exam_errors') ? (int) $validated['exam_errors'] : null,
            'tramitacion_percent' => $request->filled('tramitacion_percent')
                ? (int) $validated['tramitacion_percent']
                : null,
            'score_improvement_paid' => $request->boolean('score_improvement_paid'),
        ]);

        if ($application->examPassed() && $application->wasChanged('exam_score')) {
            $this->notifications->notify($application->user, 'tramite.notif_score_ok_title', 'tramite.notif_score_ok_body', [
                'score' => $application->exam_score ?? 0,
            ]);
        }

        $this->logger->log('application.exam', $application);

        return back()->with('status', __('admin.exam_updated'));
    }

    public function updateTramitacionPercent(Request $request, PermitApplication $application): RedirectResponse
    {
        $validated = $request->validate([
            'tramitacion_percent' => ['nullable', 'integer', 'min:0', 'max:100'],
            'requested_category' => ['nullable', 'string', 'max:8'],
        ]);

        $updates = [
            'tramitacion_percent' => $request->filled('tramitacion_percent')
                ? (int) $validated['tramitacion_percent']
                : null,
        ];

        if ($request->has('requested_category')) {
            $updates['requested_category'] = filled($validated['requested_category'] ?? null)
                ? strtoupper(preg_replace('/[^A-Z0-9]/', '', (string) $validated['requested_category']))
                : null;
        }

        $application->update($updates);

        $this->logger->log('application.tramitacion_percent', $application, (string) ($application->tramitacion_percent ?? 'auto'));

        return back()->with('status', __('admin.tramitacion_updated'));
    }

    public function reject(Request $request, PermitApplication $application): RedirectResponse
    {
        $request->validate(['reason' => ['nullable', 'string', 'max:500']]);

        $application->update([
            'status' => 'refuse',
            'validated_by' => auth()->id(),
            'validated_at' => now(),
            'notes' => trim(($application->notes ?? '')."\n".__('admin.reject_reason').': '.($request->input('reason') ?? '—')),
        ]);

        $application->user->licenseSummary?->update(['application_status' => 'refuse']);

        $this->notifications->notify($application->user, 'admin.notif_rejected_title', 'admin.notif_rejected_body', [
            'ref' => $application->reference_code,
        ]);

        $this->logger->log('application.reject', $application, $request->input('reason'));

        return back()->with('status', __('admin.application_rejected'));
    }

    /** @return list<string> */
    private function nextStatuses(string $current): array
    {
        return match ($current) {
            'en_attente_paiement_whatsapp' => ['en_tramitacion'],
            'en_tramitacion' => ['permiso_provisional', 'refuse'],
            'permiso_provisional' => ['en_fabricacion'],
            'en_fabricacion' => ['expedido'],
            'expedido' => ['valide'],
            default => [],
        };
    }
}
