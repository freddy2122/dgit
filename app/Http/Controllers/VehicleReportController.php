<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\ResolvesPortalUser;
use App\Models\Vehicle;
use Illuminate\View\View;

class VehicleReportController extends Controller
{
    use ResolvesPortalUser;

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(): View
    {
        $vehicles = $this->portalUser()->vehicles()->orderBy('plate')->get();

        return view('vehicles.report', [
            'vehicles' => $vehicles,
        ]);
    }

    public function show(?Vehicle $vehicle = null): View
    {
        $user = $this->portalUser();
        $vehicle = $vehicle
            ? $user->vehicles()->whereKey($vehicle->id)->firstOrFail()
            : $user->vehicles()->orderBy('plate')->firstOrFail();

        return view('vehicles.details', [
            'vehicle' => $vehicle,
        ]);
    }
}
