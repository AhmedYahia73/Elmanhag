<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
          if(Auth::check()){
                if((Auth::user()->role == 'admin' || Auth::user()->role == 'supAdmin') && Auth::user()->status == 1){
                    return $next($request);
                } else{abort(403);}
        } return response()->json(
            ['faield'=> 'This Is Not Admin',]
        ,401);
    }
}
