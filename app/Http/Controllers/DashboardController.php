<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\ResolvesPortalUser;
use App\Services\PermitStatusSearchService;
use App\Services\PortalDashboardService;
use App\Support\ExamResultPresenter;
use Illuminate\View\View;

class DashboardController extends Controller
{
    use ResolvesPortalUser;
    public function __construct(private PortalDashboardService $portal)
    {
        $this->middleware('auth');
    }

    public function index(): View
    {
        $user = $this->portalUser();
        $this->portal->ensureProvisioned($user);
        $user->refresh();

        $license = $user->licenseSummary;
        $vehicles = $user->vehicles()->orderBy('plate')->get();
        $application = $this->portal->resolveApplication($user);
        $maxPts = $this->portal->maxPoints();
        $pts = $license?->points ?? 0;
        $exam = $application ? (new ExamResultPresenter($application, $user, $license))->toArray() : ['show' => false];
        $statusPayload = $application
            ? app(PermitStatusSearchService::class)->toPayload([
                'found' => true,
                'user' => $user,
                'application' => $application,
                'search_mode' => 'code',
                'account_inactive' => false,
            ])
            : [
                'points' => $pts,
                'exam' => $exam,
                'held_categories' => $license ? $license->activeCategoryCodes()->values()->all() : [],
            ];
        $procedures = $this->portal->proceduresForUser($user)->all();

        $pendingPayments = $user->portalPayments()->whereIn('status', ['pending', 'awaiting_whatsapp'])->get();
        $pendingTotalAmount = (float) $pendingPayments->sum('amount');
        $pendingTotal = number_format($pendingTotalAmount, 2, ',', '');
        $nextDue = $pendingPayments->min('due_date');

        $nextAppointment = $user->portalAppointments()
            ->where('appointment_date', '>=', now()->startOfDay())
            ->orderBy('appointment_date')
            ->orderBy('appointment_time')
            ->first();

        return view('dashboard.index', [
            'license' => $license,
            'application' => $application,
            'vehicles' => $vehicles,
            'pts' => $pts,
            'maxPts' => $maxPts,
            'exam' => $exam,
            'statusPayload' => $statusPayload,
            'procedures' => $procedures,
            'hasLicenseData' => $this->portal->licenseIsPublishedForClient($license),
            'nextAppointment' => $nextAppointment,
            'notifications' => $user->portalNotifications()->latest('notified_at')->take(3)->get(),
            'pendingTotal' => $pendingTotal,
            'pendingTotalAmount' => $pendingTotalAmount,
            'paymentDue' => $nextDue?->format('d/m/Y') ?? '—',
            'nie' => $user->nie ?? '—',
        ]);
    }

}
