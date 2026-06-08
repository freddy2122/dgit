<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SedeMirrorController extends Controller
{
    public function show(Request $request): View|RedirectResponse
    {
        $path = trim((string) $request->route('path'), '/');

        if (sede_normalize_path($path) === 'midgt') {
            return redirect()->to(portal_route('midgt.index'));
        }

        $claveDirect = match (sede_normalize_path($path)) {
            'es/acceso/clave/plataforma', 'es/acceso/clave/registrarse' => portal_route('clave.inscripcion'),
            'es/acceso/clave/conectar' => portal_route('clave.conectar'),
            'es/acceso/clave' => portal_route('clave.conectar'),
            default => null,
        };
        if ($claveDirect) {
            return redirect()->to($claveDirect);
        }

        $localRoute = portal_local_route_for_sede_path($path);
        if ($localRoute) {
            return redirect()->to(portal_route($localRoute));
        }

        $page = sede_resolve_page($path);

        if (! empty($page['dgt'])) {
            return redirect()->to(dgt_href($page['path']));
        }

        if ($page && ! empty($page['view'])) {
            return view('sede.'.$page['view'], [
                'path' => $path,
                'page' => $page,
                'title' => sede_page_title($path),
            ]);
        }

        return view('pages.sede-mirror', [
            'path' => $path,
            'title' => sede_page_title($path),
            'page' => $page,
            'sedeNav' => config('dgt_sede_nav', []),
        ]);
    }
}
