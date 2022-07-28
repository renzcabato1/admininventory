<?php

namespace App\Http\Middleware;

use Closure;

class Admin
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
        if (auth()->user()->role == "User") {
            return redirect('requests');
        }
        elseif(auth()->user()->role == "Approver")
        {
            return redirect('for-approval');
        }
        elseif(auth()->user()->role == "Admin")
        {
            return $next($request);
        }
        return $next($request);
    }
}
