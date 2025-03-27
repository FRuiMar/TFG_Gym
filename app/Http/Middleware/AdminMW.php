<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Auth\Access\AuthorizationException;

class AdminMW
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        if (Auth::check() && Auth::user()->role === 'ADMIN') {
            return $next($request);
        }

        //return Redirect::route('dashboard')->with('error', 'No tienes permiso para acceder a esta página.');
        throw new AuthorizationException('No tienes permiso para acceder a esta página.');
    }
}
