<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ApiKeyMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        $rawToken = "DWuqUHWDUhDQUDadaq";
        $token = $request->bearerToken();
        if ($rawToken == $token) {
            return $next($request);
        }
        return response()->json(
            [
                'code' => 401,
                'message' => 'Please insert api key',
                'status' => false
            ],
            401
        );
    }
}