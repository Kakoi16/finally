<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminOnly
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = session('user');

        if (!is_array($user) || !isset($user['role']) || $user['role'] !== 'admin') {
            abort(403, 'Akses hanya untuk admin.');
        }

        return $next($request);
    }
}
