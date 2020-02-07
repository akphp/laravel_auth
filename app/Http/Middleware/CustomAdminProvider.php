<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Config;

class CustomAdminProvider
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
        $parms = $request->all();
        if(array_key_exists('provider' , $parms)){
            Config::set('auth.guards.api.provider', $parms['provider']);
        }
        return $next($request);
    }
}
