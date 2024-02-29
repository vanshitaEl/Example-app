<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

use function PHPUnit\Framework\returnValue;

class AuthCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    // public function handle(Request $request, Closure $next)
    // {

    //     if(!$request->has('doctor') && ($request->path() !='login' && $request->path() !='register' )){
    //        return redirect('login')->with('fail','You must be logged in');

    //     }
    //     if($request->has('doctor') && ($request->path() == 'login' || $request->path() == 'register' ) ){
    //         return back();
    //     }
    //     return $next($request);
    // }


    public function handle(Request $request, Closure $next)
    {
      
        if (!Auth::guard('doctor')->check()) {
            return redirect('login')->with('fail', 'You must be logged in');
        }
        return $next($request);
    }
}
