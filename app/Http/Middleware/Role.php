<?php
namespace App\Http\Middleware;
use Closure;
use Auth;
class Role
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, ...$roles)
    {
        // $user = Auth::user();
        // if( $user->isAdmin){
        //         return $next($request);x
        //     }
        // dd($user->role);
        // dd($roles);
        if(! Auth::user())
            return redirect()->back();
        // dd(Auth::user()->role);
        foreach($roles as $role) {
            if(Auth::user()->role === $role){
                // dump($role);
                return $next($request);
             }
        }
        return redirect()->back(); 
    }
}
