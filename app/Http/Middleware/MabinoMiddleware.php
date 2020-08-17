<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Support\Facades\Auth;

class MabinoMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = Auth::user();
        if ($user->role == User::ROLE_MABINO and $user->verify == User::VERIFIED_AND_ACCEPT_RULE and $user->status == User::ACTIVE) {
            return $next($request);

        } else {
            return redirect("/login");

        }
    }
}
