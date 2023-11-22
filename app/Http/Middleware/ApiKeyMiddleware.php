<?php

namespace App\Http\Middleware;

use App\Models\Customer;
use App\Models\Kurir;
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
    public $dataToken;

    public function handle(Request $request, Closure $next): Response
    {

        $token = $request->bearerToken();

        $customer = Customer::where('token', $token)->first();

        $kurir = Kurir::where('token', $token)->first();

        if (isset($customer)) {
            return $next($request);
        } elseif (isset($kurir)) {
            return $next($request);
        } else {
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
}
