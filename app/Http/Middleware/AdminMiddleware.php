<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle($request, Closure $next)
    {
        if (Auth::check() && Auth::user()->rol === 'Administrador') {
            return $next($request);
        }

        abort(403, 'No tienes permisos para acceder a esta página.');
    }
}


