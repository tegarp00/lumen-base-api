<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class WithAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Pre-Middleware Action
        //$token = app('App\Http\Controllers\AuthController')->tocen;
        $dapp = $request->session()->get('dapp');
        $token = $request->header('authorization');

        if($token == null || $dapp == null) {
           return response()->json([
                "status" => false,
                "message" => "Token not provided",
                "data" => []
            ], 401); 
        }

        if(!Hash::check($dapp, $token)) {
          return response()->json([
                "status" => false,
                "message" => "Invalid Token",
                "data" => []
            ], 401); 
        }
      

        // Post-Middleware Action
        return $next($request);


    }
}
