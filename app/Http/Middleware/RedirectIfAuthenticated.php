<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

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
            $role = Auth::user()->role;
        if($role == User::ROLE_USER or $role == User::ROLE_AGENT){
            return redirect()->route('user.dashboard');
        }elseif($role == User::ROLE_MABINO){
            return redirect()->route('admin.dashboard');
        }else{
            Auth::logout();
            return redirect("/login");
        }
        }

        return $next($request);
    }
}
