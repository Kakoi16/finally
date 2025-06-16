<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class SubfolderController extends Controller
{
    public function editOnl(string $encodedPath)
    {
        $baseFolder = storage_path('app/public/uploads');
        Log::debug('Base folder path:', ['baseFolder' => $baseFolder]);

        $urlDecodedPath = urldecode($encodedPath);
        $decodedPath = base64_decode($urlDecodedPath);
        Log::debug('Decoded path:', [
            'encodedPath'    => $encodedPath,
            'urlDecodedPath' => $urlDecodedPath,
            'decodedPath'    => $decodedPath,
        ]);

        $fullPath = realpath($baseFolder . DIRECTORY_SEPARATOR . $decodedPath);
        if (!$fullPath || !str_starts_with($fullPath, realpath($baseFolder))) {
            abort(403, 'Access denied.');
        }

        if (!File::exists($fullPath) || !File::isFile($fullPath)) {
            abort(404, 'File not found.');
        }

        $relativePath = trim(Str::replaceFirst($baseFolder, '', $fullPath), DIRECTORY_SEPARATOR);
        $documentId = rtrim(strtr(base64_encode($relativePath), '+/', '-_'), '=');
        $extension = strtolower(pathinfo($fullPath, PATHINFO_EXTENSION));
        $allowedExtensions = ['docx', 'xlsx', 'pptx'];

        if (!in_array($extension, $allowedExtensions)) {
            abort(415, 'Unsupported file type');
        }

        // Tentukan endpoint Zoho berdasarkan ekstensi file
        switch ($extension) {
            case 'xlsx':
                $zohoEndpoint = 'https://api.office-integrator.com/sheet/officeapi/v1/spreadsheet';
                break;
            case 'pptx':
                $zohoEndpoint = 'https://api.office-integrator.com/show/officeapi/v1/presentation';
                break;
            case 'docx':
            default:
                $zohoEndpoint = 'https://api.office-integrator.com/writer/officeapi/v1/document';
                break;
        }

        $permissions = $this->getZohoPermissions($extension);

        Log::info('Sending document to Zoho', [
            'relativePath' => $relativePath,
            'documentId'   => $documentId,
            'zohoEndpoint' => $zohoEndpoint,
        ]);

        $response = Http::timeout(30)->asMultipart()->post($zohoEndpoint, [
            ['name' => 'apikey', 'contents' => config('zoho.api_key')],
            ['name' => 'document', 'contents' => fopen($fullPath, 'r'), 'filename' => basename($fullPath)],
            ['name' => 'document_info', 'contents' => json_encode([
                'document_name' => basename($fullPath),
                'document_id'   => $documentId,
            ])],
            ['name' => 'permissions', 'contents' => json_encode($permissions)],
            ['name' => 'editor_settings', 'contents' => json_encode([
                'language' => 'en',
            ])],
            ['name' => 'callback_settings', 'contents' => json_encode([
                'save_url'    => url('/zoho-call-back') . '?doc=' . $documentId,
                'save_format' => $extension,
            ])],
        ]);

        if (!$response->ok()) {
            Log::error('Zoho API error', [
                'status' => $response->status(),
                'body'   => $response->body(),
            ]);
            return response()->json([
                'error'   => 'Zoho responded with error',
                'code'    => $response->status(),
                'details' => $response->body(),
            ], 500);
        }

        return view('templates.zoho-editSub', [
            'documentUrl' => $response->json()['document_url'] ?? null,
        ]);
    }

    // Helper untuk menentukan permission berdasarkan tipe file
    private function getZohoPermissions(string $extension): array
    {
        $permissions = [
            'document.export' => true,
            'document.print'  => true,
            'document.edit'   => true,
        ];

        if ($extension === 'docx') {
            $permissions['review.comment'] = true;
            $permissions['collab.chat'] = true;
        }

        return $permissions;
    }

    public function zohoCallbackk(Request $request)
    {
        Log::info('Zoho Callback Request', [
            'headers' => $request->headers->all(),
            'body'    => $request->all(),
        ]);
        Log::debug('Zoho Callback Payload', [
            'input' => $request->all(),
            'query' => $request->query(),
        ]);

        $documentId = $request->input('document_id') ?? $request->query('doc');

        if (!$request->hasFile('content') || !$request->file('content')->isValid()) {
            Log::error('Invalid file upload from Zoho', ['data' => $request->all()]);
            return response()->json(['error' => 'Invalid file upload'], 400);
        }

        try {
            $uploadedFile = $request->file('content');
            $filename     = $request->input('filename', 'document_' . time());

            if ($documentId) {
                $decoded = base64_decode(strtr($documentId, '-_', '+/'));
                $relativePath = ltrim($decoded, '/\\');
            } else {
                $searchFolder = storage_path('app/public/uploads');
                $files = File::allFiles($searchFolder);
                $matched = collect($files)->first(fn($file) => $file->getFilename() === $filename);

                $relativePath = $matched
                    ? trim(Str::replaceFirst($searchFolder, '', $matched->getRealPath()), DIRECTORY_SEPARATOR)
                    : $filename;
            }

            $relativePath = str_replace(['..\\', '../', './', '\\'], '/', $relativePath);
            $relativePath = ltrim($relativePath, '/');

            $baseFolder = storage_path('app/public/uploads');
            $fullPath = $baseFolder . '/' . $relativePath;
            $pathInfo = pathinfo($fullPath);

            $realBase = realpath($baseFolder);
            $realTarget = realpath($pathInfo['dirname']) ?: $pathInfo['dirname'];
            if (!Str::startsWith($realTarget, $realBase)) {
                Log::warning('Attempt to save outside base folder', [
                    'realTarget' => $realTarget,
                    'realBase'   => $realBase,
                ]);
                return response()->json(['error' => 'Invalid file path'], 403);
            }

            if (!File::isDirectory($pathInfo['dirname'])) {
                File::makeDirectory($pathInfo['dirname'], 0755, true);
                Log::info('Target directory created', ['dir' => $pathInfo['dirname']]);
            }

            $uploadedFile->move($pathInfo['dirname'], $pathInfo['basename']);

            Log::info('File saved successfully', [
                'savePath'    => $fullPath,
                'fileName'    => $pathInfo['basename'],
                'documentId'  => $documentId,
            ]);

            return response()->json(['message' => 'File saved successfully']);
        } catch (\Exception $e) {
            Log::error('Zoho callback error', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Failed to save file'], 500);
        }
    }
}
