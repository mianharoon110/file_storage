<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AuthCheck
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
        if(!session()->has('userId') && ($request->path() != '/' && $request->path() != 'register' )){
            return redirect('/')->with('fail','You must be logged in');
        }

        if(session()->has('userId') && ($request->path() == '/' || $request->path() == 'register' )){
            return back();
        }
        return $next($request);
    }
}
