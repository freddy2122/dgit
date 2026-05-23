<?php

namespace App\Http\Controllers;

use App\Services\PermitTramiteService;
use App\Services\PortalDashboardService;
use Illuminate\View\View;

class PortalDemarchesController extends Controller
{
    public function __construct(
        private PortalDashboardService $portal,
        private PermitTramiteService $tramites,
    ) {
        $this->middleware('auth');
    }

    public function index(): View
    {
        $user = auth()->user();
        $this->portal->ensureProvisioned($user);

        $application = $this->portal->resolveApplication($user);
        $status = $application?->status ?? 'en_attente';

        $stepMap = [
            'en_attente_paiement_whatsapp' => 1,
            'pendiente_pago' => 1,
            'en_tramitacion' => 2,
            'permiso_provisional' => 3,
            'en_fabricacion' => 4,
            'expedido' => 5,
            'expedie' => 5,
            'valide' => 6,
            'validado' => 6,
            'refuse' => 2,
            'rechazado' => 2,
        ];

        $currentStep = $stepMap[$status] ?? 1;

        $badgeClass = match ($status) {
            'refuse', 'rechazado' => 'bg-red-100 text-red-800',
            'en_attente_paiement_whatsapp', 'pendiente_pago' => 'bg-amber-100 text-amber-800',
            'valide', 'validado', 'expedido', 'expedie' => 'bg-emerald-100 text-emerald-800',
            default => 'bg-sky-100 text-sky-800',
        };

        $typeLabel = $application?->tramite_type
            ? $this->tramites->typeLabel($application->tramite_type)
            : __('portal.demarches.renewal');

        return view('portal.demarches', [
            'application' => $application,
            'license' => $user->licenseSummary,
            'status' => $status,
            'currentStep' => $currentStep,
            'badgeClass' => $badgeClass,
            'badgeLabel' => permit_status_label($status),
            'ref' => $application?->reference_code ?? '—',
            'deposed' => $application?->submitted_at?->format('d/m/Y') ?? '—',
            'typeLabel' => $typeLabel,
            'steps' => [
                ['n' => 1, 'label' => __('tramite.workflow.whatsapp')],
                ['n' => 2, 'label' => __('tramite.workflow.processing')],
                ['n' => 3, 'label' => __('tramite.workflow.provisional')],
                ['n' => 4, 'label' => __('tramite.workflow.fabrication')],
                ['n' => 5, 'label' => __('tramite.workflow.shipping')],
                ['n' => 6, 'label' => __('tramite.workflow.done')],
            ],
        ]);
    }
}
