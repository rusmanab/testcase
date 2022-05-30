<?php

namespace App\Http\Middleware;

use Closure;

class ApiToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ( $request->has('api_token') ) {
            $token = $request->api_token;
            if ($token == 'majoo123!@#$') {
                return $next($request);
            }
            return response()->json([
                'success' => false,
                'message' => "Autorisasi gagal, silakan login kembali.",
            ],200);
        }else{
            return response()->json([
                'success' => false,
                'message' => "Butuh api_token.",
            ],200);
        }
    }
}
