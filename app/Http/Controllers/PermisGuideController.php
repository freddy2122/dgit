<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PermisGuideController extends Controller
{
    public function index(): View
    {
        return view('permis.index', [
            'sedeNav' => config('dgt_sede_nav', []),
        ]);
    }

    public function page(Request $request): RedirectResponse
    {
        $slug = (string) $request->route('slug');

        if ($slug === 'suivi') {
            return redirect()->to(portal_route('licence.status'));
        }

        $map = [
            'nouveau' => 'es/permisos-de-conducir/obtencion-y-gestion-de-permisos',
            'renouvellement' => 'es/permisos-de-conducir/obtencion-y-gestion-de-permisos/renovacion-de-permiso-proximo-a-caducar',
            'canje' => 'es/permisos-de-conducir/canjes-de-permisos',
            'changement-adresse' => 'es/permisos-de-conducir/direccion-para-notificaciones',
            'duplicata' => 'es/permisos-de-conducir/obtencion-y-gestion-de-permisos/duplicado-de-permisos',
            'international' => 'es/permisos-de-conducir/permiso-de-conduccion-internacional',
        ];
        $path = $map[$slug] ?? null;

        abort_unless($path, 404);

        return redirect()->to(sede_href($path));
    }
}
