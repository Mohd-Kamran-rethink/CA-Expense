<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Foundation\Auth\User;

class SuperManagerMiddleware
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
        $user=User::find(session('user')->id);
        if($user->role=='manager' && $user->is_admin=='Yes')
        {
            return $next($request);
        }
        else
        {
            return redirect('/dashboard');
        }
    }
}
