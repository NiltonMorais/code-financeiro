<?php

namespace CodeFin\Http\Middleware;

use Closure;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\Facades\Auth;

class AuthenticateFromToken
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
        if(!Auth::guard('web')->check() && Auth::guard('api')->check()){
            $id = Auth::guard('api')->user()->id;
            Auth::guard('web')->loginUsingId($id);
        }
        if(!Auth::guard('web')->check()){
            throw new AuthenticationException('Unauthenticated.');
        }

        return $next($request);
    }
}
