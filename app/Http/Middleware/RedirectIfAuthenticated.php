<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
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
        if (Auth::guard($guard)->check()) {
            //return redirect(RouteServiceProvider::HOME);

            $user = \Auth::user();
            if($user->hasRole(['Admin', 'Sub-Admin'])){
                return redirect('/dashboard');
                  
            }else if($user->hasRole(['Investor', 'Company'])){

                return redirect('/investor/dashboard');
            } else {
                return redirect('/denied');
            }
        }

        return $next($request);
    }
}
