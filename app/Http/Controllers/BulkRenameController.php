<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class BulkRenameController extends Controller
{
    public function rename(Request $request)
    {
        $items = $request->items; // array of ['id' => ..., 'new_name' => ...]

        foreach ($items as $item) {
            Http::withHeaders([
                'apikey' => env('SUPABASE_API_KEY'),
                'Authorization' => 'Bearer ' . env('SUPABASE_API_KEY'),
            ])->patch(env('SUPABASE_URL') . '/rest/v1/archives?id=eq.' . $item['id'], [
                'name' => $item['new_name'],
            ]);
        }

        return response()->json(['message' => 'Items renamed']);
    }
}
