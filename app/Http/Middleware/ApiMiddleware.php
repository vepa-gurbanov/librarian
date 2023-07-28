<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ApiMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->is('api/v1/*')) {
            if ($request->api_id != 'b2b') {
                return response()->json([
                    'status' => 0,
                    'data' => [],
                ], Response::HTTP_NOT_FOUND);
            }
        }
        return $next($request);
    }
}
