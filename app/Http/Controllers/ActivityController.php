<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Activity;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ActivityController extends Controller
{
    public function store(Request $request)
    {
        try {
            $request->validate([
                'activity' => 'required|string|max:255',
                'url' => 'nullable|string|max:2048',
            ]);

            if (!Auth::check()) {
                return response()->json(['status' => 'error', 'message' => 'User not authenticated'], 401);
            }

            Activity::create([
                'user_id' => Auth::id(),
                'activity' => $request->activity,
                'url' => $request->url
            ]);

            return response()->json(['status' => 'success']);
        } catch (\Exception $e) {
            Log::error('Log Activity Error: ' . $e->getMessage());
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }
    
    
}
