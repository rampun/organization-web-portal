<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckMember
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // return $next($request);
        if($request->user() && $request->user()->role == 'member'){

            return $next($request);
            
        }
        // if the role is other than member, show the unauthorized view
        return redirect('/unauthorized');
    }
}
