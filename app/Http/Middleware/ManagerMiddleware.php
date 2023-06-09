<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Foundation\Auth\User;

class ManagerMiddleware
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
        if($user->role=='manager' ||$user->role=='customer_care_manager')
        {
            return $next($request);
        }
        else
        {
            return redirect('/dashboard');
        }

    }
}
