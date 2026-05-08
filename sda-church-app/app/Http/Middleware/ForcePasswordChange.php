<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ForcePasswordChange
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (\Illuminate\Support\Facades\Auth::check() && $request->user()->must_change_password) {
            $allowedRoutes = ['password.change.form', 'password.change.store', 'logout'];
            if (!$request->routeIs($allowedRoutes)) {
                return redirect()->route('password.change.form');
            }
        }

        return $next($request);
    }
}
