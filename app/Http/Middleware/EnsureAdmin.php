<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (! $user) {
            return redirect()->guest(portal_route('login'));
        }

        if (! $user->isStaff()) {
            abort(403, __('admin.access_denied'));
        }

        return $next($request);
    }
}
