<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Auth;

class Role
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        // return $next($request);

         // dd($roles);
        // if(Auth::user()->role === 'admin')
        //     return $next($request);

        foreach($roles as $role) {
            // dd($role);
        if(Auth::user()->role === $role)
                return $next($request);
        }

        return redirect()->back()->with('error','You have not admin access');
    }
}
