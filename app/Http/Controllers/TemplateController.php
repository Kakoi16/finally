<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

class TemplateController extends Controller
{
    public function editOnline($encodedPath)
    {
        $baseFolder  = storage_path("app/public/uploads");
        $decodedPath = base64_decode(urldecode($encodedPath));
        $fullPath    = realpath($baseFolder . DIRECTORY_SEPARATOR . $decodedPath);

        // Log path info untuk debugging
        Log::info('editOnline request', [
            'decodedPath' => $decodedPath,
            'fullPath' => $fullPath,
            'baseFolder' => realpath($baseFolder),
        ]);

        // Validasi keamanan path
        if (!$fullPath || !str_starts_with($fullPath, realpath($baseFolder))) {
            abort(403, 'Access denied: Invalid path.');
        }

        if (!File::exists($fullPath) || !File::isFile($fullPath)) {
            abort(404, 'File not found.');
        }

        try {
            $response = Http::timeout(30)->asMultipart()->post(
                'https://api.office-integrator.com/writer/officeapi/v1/document',
                [
                    [
                        'name'     => 'apikey',
                        'contents' => config('zoho.api_key'),
                    ],
                    [
                        'name'     => 'document',
                        'contents' => fopen($fullPath, 'r'),
                        'filename' => basename($fullPath),
                    ],
                    [
                        'name'     => 'document_info',
                        'contents' => json_encode([
                            'document_name' => basename($fullPath),
                            'document_id'   => md5($fullPath),
                        ]),
                    ],
                    [
                        'name'     => 'permissions',
                        'contents' => json_encode([
                            'document.export' => true,
                            'document.print'  => true,
                            'document.edit'   => true,
                            'review.comment'  => true,
                            'collab.chat'     => true,
                        ]),
                    ],
                    [
                        'name'     => 'editor_settings',
                        'contents' => json_encode([
                            'unit'     => 'in',
                            'language' => 'en',
                            'view'     => 'pageview',
                        ]),
                    ],
                    [
                        'name'     => 'callback_settings',
                        'contents' => json_encode([
                            'save_format'  => pathinfo($fullPath, PATHINFO_EXTENSION),
                            'save_url'     => route('template.zoho.save', [
                                'path' => base64_encode($decodedPath)
                            ]),
                            'context_info' => 'LaravelApp',
                        ]),
                    ],
                ]
            );
        } catch (\Illuminate\Http\Client\RequestException $e) {
            Log::error('Zoho API request failed', [
                'message' => $e->getMessage()
            ]);

            return response()->json([
                'error' => 'Request to Zoho failed.',
                'message' => $e->getMessage()
            ], 500);
        }

        if (!$response->ok()) {
            Log::error('Zoho API error', ['response' => $response->body()]);
            return response()->json([
                'error' => 'Failed to initiate Zoho editor.',
                'details' => $response->body()
            ], 500);
        }

        $data = $response->json();

        return view('templates.zoho-edit', [
            'documentUrl' => $data['document_url'] ?? null,
        ]);
    }

    public function zohoSave(Request $request)
    {
        if (!$request->hasFile('content')) {
            return response()->json(['status' => 'error', 'message' => 'No file content provided'], 400);
        }

        $file = $request->file('content');

        // Ambil dan decode path
        $encodedPath = $request->query('path');
        if (!$encodedPath) {
            return response()->json(['status' => 'error', 'message' => 'Path not provided'], 400);
        }

        $decodedPath = base64_decode($encodedPath);
        $baseFolder  = storage_path("app/public/uploads");
        $fullPath    = realpath($baseFolder . DIRECTORY_SEPARATOR . $decodedPath);

        // Log path untuk debugging
        Log::info('zohoSave', [
            'decodedPath' => $decodedPath,
            'fullPath' => $fullPath,
        ]);

        if (!$fullPath || !str_starts_with($fullPath, realpath($baseFolder))) {
            return response()->json(['status' => 'error', 'message' => 'Invalid path'], 403);
        }

        try {
            File::put($fullPath, file_get_contents($file->getRealPath()));
            return response()->json(['status' => 'success']);
        } catch (\Exception $e) {
            Log::error('Failed to save file', [
                'message' => $e->getMessage()
            ]);
            return response()->json([
                'status'  => 'error',
                'message' => 'Failed to save file.',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }
}
