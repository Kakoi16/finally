<?php

// app/Http/Middleware/LogUserActivity.php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\Models\Activity;

class LogUserActivity
{
    public function handle($request, Closure $next)
    {
        if (Auth::check()) {
            Activity::create([
                'user_id' => Auth::id(),
                'activity' => 'Mengunjungi halaman ' . $request->path(),
                'url' => $request->url(),
            ]);
        }

        return $next($request);
    }
}
