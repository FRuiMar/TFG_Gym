<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Access\AuthorizationException;

class UserMW
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        if (Auth::check() && Auth::user()->role === 'NORMAL') {
            return $next($request);
        }

        //return redirect('dashboard')->with('error', 'No tienes permiso para acceder a esta página.');
        throw new AuthorizationException('No tienes permiso para acceder a esta página.');
    }
}
