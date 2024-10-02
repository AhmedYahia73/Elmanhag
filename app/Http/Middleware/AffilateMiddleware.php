<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AffilateMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
          if(Auth::check()){
          if((Auth::user()->role == 'affilate' && Auth::user()->status == 1) || !empty(Auth::user()->affilate_code)){
          return $next($request);
          } else {abort(403);}
          }return response()->json(
          ['faield'=> 'This Is Not Student',]
          ,401);
    }
}
