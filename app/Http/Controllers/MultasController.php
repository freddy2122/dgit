<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\ResolvesPortalUser;
use App\Services\PortalDashboardService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MultasController extends Controller
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

        return view('multas.index', [
            'fines' => collect(),
            'pending' => collect(),
        ]);
    }

    public function pay(Request $request): RedirectResponse
    {
        return redirect()
            ->to(portal_route('multas.index'))
            ->withErrors(['payment' => __('site.multas.contact_gestoria')]);
    }

    public function appeal(): View
    {
        return view('multas.appeal');
    }

    public function storeAppeal(Request $request): RedirectResponse
    {
        $request->validate([
            'reference' => ['required', 'string', 'max:64'],
            'reason' => ['required', 'string', 'max:2000'],
        ]);

        return redirect()
            ->to(portal_route('multas.appeal'))
            ->with('portal_success', __('site.multas.appeal_sent'));
    }
}
