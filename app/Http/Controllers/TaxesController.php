<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\ResolvesPortalUser;
use App\Models\PortalPayment;
use App\Services\PortalDashboardService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TaxesController extends Controller
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

        $taxes = $user->portalPayments()->orderByDesc('due_date')->get();

        return view('taxes.index', [
            'taxes' => $taxes,
            'pending' => $taxes->filter(fn ($t) => $t->isPending()),
        ]);
    }

    public function pay(): View
    {
        $user = $this->portalUser();
        $this->portal->ensureProvisioned($user);

        return view('taxes.pay', [
            'pending' => $user->portalPayments()->whereIn('status', ['pending', 'awaiting_whatsapp'])->orderBy('due_date')->get(),
        ]);
    }

    public function processPay(Request $request): RedirectResponse
    {
        return redirect()
            ->to(portal_route('portal.payments'))
            ->withErrors(['payment' => __('tramite.payment_whatsapp_only')]);
    }

    public function receipt(): View
    {
        $user = $this->portalUser();
        $this->portal->ensureProvisioned($user);

        return view('taxes.receipt', [
            'paid' => $user->portalPayments()->where('status', 'paid')->orderByDesc('due_date')->get(),
        ]);
    }
}
