<?php

namespace CodeFin\Http\Middleware;

use Closure;
use HipsterJazzbo\Landlord\Facades\Landlord;
use Illuminate\Support\Facades\Auth;

class AddClientTenant
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
        if($request->is('api/*')){
            $user = Auth::guard('api')->user();
            if($user){
                $client = $user->client;
                Landlord::addTenant($client);
            }
        }
        return $next($request);
    }
}
