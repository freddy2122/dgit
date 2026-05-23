<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PermitApplication;
use App\Models\PortalPayment;
use App\Models\User;
use App\Models\Vehicle;
use Illuminate\View\View;

class AdminDashboardController extends Controller
{
    public function index(): View
    {
        $today = now()->startOfDay();

        return view('admin.dashboard', [
            'stats' => [
                'applications_today' => PermitApplication::query()->where('created_at', '>=', $today)->count(),
                'permits_validated' => PermitApplication::query()->whereIn('status', ['valide', 'validado'])->count(),
                'payments_received' => PortalPayment::query()->where('status', 'paid')->where('updated_at', '>=', $today)->count(),
                'pending_files' => PermitApplication::query()->whereIn('status', ['pendiente_pago', 'en_tramitacion', 'en_attente', 'en_cours'])->count(),
                'users_total' => User::query()->where('role', 'user')->count(),
                'vehicles_total' => Vehicle::query()->count(),
            ],
            'recentApplications' => PermitApplication::query()
                ->with('user')
                ->latest('updated_at')
                ->limit(8)
                ->get(),
        ]);
    }
}
