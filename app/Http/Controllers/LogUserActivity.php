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
        \Log::info('LogUserActivity middleware jalan. Path: '.$request->path());
        Activity::create([
    'user_id' => Auth::id(),
    'activity' => 'Mengakses ' . $request->path(),
    'url' => $request->fullUrl(),
    'created_at' => now(),
    'updated_at' => now(),
]);

    }
    return $next($request);
}

}
