<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class DeleteItemController extends Controller
{
    public function delete(Request $request)
    {
        $id = $request->id;

        $response = Http::withHeaders([
            'apikey' => env('SUPABASE_API_KEY'),
            'Authorization' => 'Bearer ' . env('SUPABASE_API_KEY'),
        ])->delete(env('SUPABASE_URL') . '/rest/v1/archives?id=eq.' . $id);

        return response()->json($response->json(), $response->status());
    }
}
