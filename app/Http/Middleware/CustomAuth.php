<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CustomAuth
{
    public function handle(Request $request, Closure $next)
    {
        if (!session()->has('user')) {
            return redirect()->route('login')->withErrors(['msg' => 'Silakan login terlebih dahulu.']);
        }

        return $next($request);
    }
}
