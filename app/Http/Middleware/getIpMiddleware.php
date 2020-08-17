<?php

namespace App\Http\Middleware;

use App\Models\IP;

use Closure;
use Illuminate\Http\Request;

class getIpMiddleware
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
        $url = Request::capture()->path();
        $ipAddress = Request::capture()->getClientIp();



        IP::create([
            "address"=>$ipAddress
        ]);


        

        return $next($request);
    }
}
