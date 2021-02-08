<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Session;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
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
        // if (!Session::get('admin')) {
        //     return redirect(route('login'));
        // }
        // return $next($request);
        // if(Auth::check() && Auth::user()->user_type_id == 2){
        //     return $next($request);
        // }
        // return redirect('home')->with('error',"You don't have admin access.");
        if(auth()->user()->user_type_id == 3){
            return $next($request);
        }
        return redirect('user')->with('error',"You don't have admin access.");

    }
}
