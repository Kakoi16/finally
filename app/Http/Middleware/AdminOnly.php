<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminOnly
{

public function handle(Request $request, Closure $next)
{
    if (!Auth::check()) {
        return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
    }

    if (Auth::user()->role !== 'admin') {
        abort(403, 'Akses hanya untuk admin.');
    }

    return $next($request);
}

}
