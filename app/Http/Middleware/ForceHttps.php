<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ForceHttps
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
<<<<<<< HEAD
        // if (
        //     !$request->secure() &&
        //      (!isset($_SERVER['HTTP_X_FORWARDED_PROTO']) || $_SERVER['HTTP_X_FORWARDED_PROTO'] !== 'https')
        //  ) {
        //      return redirect()->secure($request->getRequestUri());
        //  }
    
        //  return $next($request);
=======
        if (
            !$request->secure() &&
             (!isset($_SERVER['HTTP_X_FORWARDED_PROTO']) || $_SERVER['HTTP_X_FORWARDED_PROTO'] !== 'https')
         ) {
             return redirect()->secure($request->getRequestUri());
         }
    
         return $next($request);
>>>>>>> 365f2682a4a0ba76b17f51277b96827dd8b5a819
    }
    
    
}
