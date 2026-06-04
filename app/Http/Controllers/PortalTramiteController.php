<?php

namespace App\Http\Controllers;

use App\Models\PermitApplication;
use App\Support\ExamResultPresenter;
use App\Services\PermitTramiteService;
use App\Services\PortalDashboardService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PortalTramiteController extends Controller
{
    public function __construct(
        private PermitTramiteService $tramites,
        private PortalDashboardService $portal,
    ) {
        $this->middleware('auth');
    }

    public function start(Request $request): RedirectResponse
    {
        abort_unless(config('gestoria.client_can_start_tramite', false), 403);

        $validated = $request->validate([
            'sede_path' => ['required', 'string', 'max:255'],
        ]);

        $type = $this->tramites->typeForPath($validated['sede_path']);
        abort_unless($type, 404);

        $user = auth()->user();
        $this->portal->ensureProvisioned($user);

        $application = $this->tramites->submit($user, $type, $validated['sede_path']);

        return redirect()
            ->to(portal_route('portal.tramite.show', ['application' => $application->id]))
            ->with('status', __('tramite.started'));
    }

    public function show(PermitApplication $application): View
    {
        $this->authorizeApplication($application);

        $application->load(['user.licenseSummary']);
        $pendingPayments = $application->user->portalPayments()
            ->where('permit_application_id', $application->id)
            ->whereIn('status', ['pending', 'awaiting_whatsapp'])
            ->get();

        $user = $application->user;
        $license = $user?->licenseSummary;
        $exam = (new ExamResultPresenter($application, $user, $license))->toArray();
        $heldCategories = $license ? $license->heldCategoryCodesForDisplay() : [];
        $tramitePayload = [
            'exam' => $exam,
            'points' => $license?->points ?? 0,
            'max_points' => \App\Models\LicenseSummary::MAX_POINTS,
            'reference' => $application->reference_code,
            'status' => permit_status_label($application->status),
            'held_categories' => $heldCategories,
            'requested_category' => $application->displayRequestedCategory($license),
            'tramite_type' => $this->tramites->typeLabel($application->tramite_type ?? 'obtencion'),
        ];

        return view('portal.tramite-show', [
            'application' => $application,
            'pendingPayments' => $pendingPayments,
            'typeLabel' => $this->tramites->typeLabel($application->tramite_type),
            'requiresMedical' => $this->tramites->requiresMedical($application->tramite_type),
            'workflowSteps' => $this->workflowSteps($application),
            'exam' => $exam,
            'tramitePayload' => $tramitePayload,
            'profileUser' => $user,
            'license' => $license,
        ]);
    }

    public function payScore(PermitApplication $application): RedirectResponse
    {
        abort(403, __('tramite.payment_whatsapp_only'));
    }

    public function payFee(PermitApplication $application): RedirectResponse
    {
        abort(403, __('tramite.payment_whatsapp_only'));
    }

    /** @return list<array{key: string, label: string, done: bool, active: bool}> */
    private function workflowSteps(PermitApplication $application): array
    {
        $order = [
            'en_attente_paiement_whatsapp',
            'en_tramitacion',
            'permiso_provisional',
            'en_fabricacion',
            'expedido',
            'valide',
        ];
        $current = array_search($application->status, $order, true);
        $keys = ['whatsapp', 'processing', 'provisional', 'fabrication', 'shipping', 'done'];

        return collect($keys)->map(function ($key, $i) use ($current) {
            return [
                'key' => $key,
                'label' => __('tramite.workflow.'.$key),
                'done' => $current !== false && $i < $current,
                'active' => $current !== false && $i === $current,
            ];
        })->values()->all();
    }

    private function authorizeApplication(PermitApplication $application): void
    {
        abort_unless($application->user_id === auth()->id(), 403);
    }
}
