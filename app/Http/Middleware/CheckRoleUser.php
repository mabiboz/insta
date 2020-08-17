<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Support\Facades\Auth;

class CheckRoleUser
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
        $user = Auth::user();
        if($user->role == User::ROLE_USER or $user->role == User::ROLE_AGENT){
            return $next($request);
        }else{
            return redirect('login');
        }
    }
}
