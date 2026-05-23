<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class SedeHubController extends Controller
{
    public function index(): View
    {
        $cards = [
            ['key' => 'permis', 'href' => portal_route('permis.index'), 'icon' => '🪪'],
            ['key' => 'vehicles', 'href' => sede_href('es/vehiculos/informacion-de-vehiculos/informe-de-un-vehiculo'), 'icon' => '🚗', 'auth' => true],
            ['key' => 'fines', 'href' => portal_route('multas.index'), 'icon' => '⚠️', 'auth' => true],
            ['key' => 'taxes', 'href' => portal_route('taxes.index'), 'icon' => '💶', 'auth' => true],
            ['key' => 'appointment', 'href' => portal_route('portal.appointments'), 'icon' => '📅', 'auth' => true],
            ['key' => 'verify', 'href' => portal_route('documents.verify'), 'icon' => '✓'],
        ];

        return view('sede.index', ['cards' => $cards]);
    }
}
