<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfNoUsers
{
    /**
     * Si no hay usuarios, fuerza el flujo de configuración inicial.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (User::query()->exists()) {
            return $next($request);
        }

        if ($request->routeIs('setup.*') || $request->is('up')) {
            return $next($request);
        }

        return redirect()->route('setup.create');
    }
}
