<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class TeacherMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
     if(Auth::check()){
                if(Auth::user()->role == 'teacher' && Auth::user()->status == 1){
                    return $next($request);
            } else {abort(403);}
        }
        return response()->json(
            ['faield'=> 'This Is Not teacher',]
        ,401);
    }
}
