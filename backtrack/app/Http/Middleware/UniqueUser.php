<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class UniqueUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        $user_key = $request->cookie("uniqueId");
        if(!$user_key) {
            $user_key = str_random(40);
        }
        $cookie = cookie('uniqueId', $user_key);
        return $next($request)->cookie($cookie);
    }
}
