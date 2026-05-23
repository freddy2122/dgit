<?php

namespace App\Http\Controllers;

use App\Services\PortalDashboardService;
use Illuminate\View\View;

class LicenceDigitalController extends Controller
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
        $showLicenseCard = $this->portal->licenseIsPublishedForClient($license);

        return view('licence.digital', [
            'license' => $license,
            'user' => $user,
            'showLicenseCard' => $showLicenseCard,
            'pts' => $license?->points,
            'maxPts' => $this->portal->maxPoints(),
            'ttlSeconds' => app(\App\Services\QrTokenService::class)->ttlSeconds(),
            'refreshBefore' => (int) config('dgt_qr.refresh_before_seconds', 15),
        ]);
    }
}
