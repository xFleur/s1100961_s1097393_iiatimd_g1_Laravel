<?php

namespace App\Http\Middleware;

use Closure;
use Tymon\JWTAuth\Facades\JWTAuth;

class JWTMiddleware
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
        $message = '';

        try {
             //checks valid token invalidations 
            JWTAuth::parseToken()->authenticate();
            return $next($request);

        }catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e){
               //do whatever you want to do if a token expired
            $message = 'Token expired';
        }catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e){
               //do whatever you want to do if a token is invalid
            $message = 'Invalid Token ';
        }catch (\Tymon\JWTAuth\Exceptions\JWTException $e){
            //do whatever you want to do if a token is not present
            $message = 'provide Token ';
        }
        //give message back
        return response()->json([
            'succes' => false,
            'message' => $message
        ]);
    }
}
