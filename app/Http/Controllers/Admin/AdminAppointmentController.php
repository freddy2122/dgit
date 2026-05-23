<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PortalAppointment;
use Illuminate\View\View;

class AdminAppointmentController extends Controller
{
    public function index(): View
    {
        return view('admin.appointments.index', [
            'appointments' => PortalAppointment::query()
                ->with('user')
                ->latest('appointment_date')
                ->paginate(30),
        ]);
    }
}
