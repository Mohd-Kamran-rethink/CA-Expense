<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Foundation\Auth\User;

class CommonUsers
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
        if(session('user'))
        {
            return $next($request);
        }
        else
        {
            return redirect('/dashboard');
        }

    }
}
