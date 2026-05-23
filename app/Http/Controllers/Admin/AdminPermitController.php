<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LicenseSummary;
use Illuminate\View\View;

class AdminPermitController extends Controller
{
    public function index(): View
    {
        return view('admin.permits.index', [
            'licenses' => LicenseSummary::query()
                ->with('user')
                ->latest('updated_at')
                ->paginate(25),
        ]);
    }
}
