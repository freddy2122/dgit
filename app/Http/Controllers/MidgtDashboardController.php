<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;

class MidgtDashboardController extends Controller
{
    /**
     * Ancienne URL « mon espace » : redirige vers le tableau de bord unifié.
     */
    public function index(): RedirectResponse
    {
        return redirect(portal_route('dashboard'));
    }
}
