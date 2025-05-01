<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class RenameItemController extends Controller
{
    public function rename(Request $request)
    {
        $id = $request->id;
        $newName = $request->new_name;

        $response = Http::withHeaders([
            'apikey' => env('SUPABASE_API_KEY'),
            'Authorization' => 'Bearer ' . env('SUPABASE_API_KEY'),
        ])->patch(env('SUPABASE_URL') . '/rest/v1/archives?id=eq.' . $id, [
            'name' => $newName,
        ]);

        return response()->json($response->json(), $response->status());
    }
}
