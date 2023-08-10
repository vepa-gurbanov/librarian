<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        if ($request->routeIs('admin.login') && Auth::guard('web')->check()) {
            return to_route('admin.dashboard');
        } elseif ($request->routeIs(['login', 'register', 'verify', 'resend']) and Auth::guard('reader')->check()) {
            return to_route('home');
        }

        return $next($request);
    }
}
