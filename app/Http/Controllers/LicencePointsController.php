<?php

namespace App\Http\Controllers;

use App\Services\PortalDashboardService;
use Illuminate\View\View;

class LicencePointsController extends Controller
{
    public function __construct(private PortalDashboardService $portal)
    {
        $this->middleware('auth');
    }

    public function show(): View
    {
        $user = auth()->user();
        $this->portal->ensureProvisioned($user);

        $license = $user->licenseSummary;
        $maxPts = $this->portal->maxPoints();
        $pts = $license?->points ?? 0;
        $pct = $maxPts > 0 ? min(100, (int) round(($pts / $maxPts) * 100)) : 0;

        $history = $user->licensePointEvents()
            ->get()
            ->map(fn ($event) => [
                'date' => $event->occurred_at->format('d/m/Y'),
                'delta' => ($event->delta >= 0 ? '+' : '').$event->delta,
                'label' => $event->reason,
                'positive' => $event->delta >= 0,
            ])
            ->all();

        return view('licence.points', [
            'points' => $pts,
            'maxPts' => $maxPts,
            'pct' => $pct,
            'history' => $history,
        ]);
    }
}
