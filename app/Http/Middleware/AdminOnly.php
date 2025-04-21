<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminOnly
{
    public function handle(Request $request, Closure $next)
    {
        if (!session('is_admin')) {
            return redirect()->route('login')->withErrors(['access' => 'Hanya admin yang boleh masuk.']);
        }

        return $next($request);
    }
}
