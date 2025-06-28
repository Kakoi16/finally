<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;               // <‑‑ tambahkan

class TemplateController extends Controller
{
    /* ----------------- util ----------------- */
    private function logErrorToFile($message, $context = [])
    {
        $logFile = base_path('public_html/error.log');           // sesuaikan jika perlu
        $date    = date('Y-m-d H:i:s');
        $contextStr = !empty($context) ? json_encode($context) : '';
        file_put_contents(
            $logFile,
            "[$date] ERROR: $message $contextStr" . PHP_EOL,
            FILE_APPEND | LOCK_EX
        );
    }

    /* ----------------- callback ----------------- */
    public function zohoCallback(Request $request)
    {
        Log::info('Zoho Callback Request', [
            'headers' => $request->headers->all(),
            'body'    => $request->all(),
        ]);

        // validasi file
        if (!$request->hasFile('content') || !$request->file('content')->isValid()) {
            Log::error('Invalid callback data', ['data' => $request->all()]);
            return response()->json(['error' => 'Invalid file upload'], 400);
        }

        try {
            $uploadedFile = $request->file('content');
            $filename     = $request->input('filename', 'document_' . time() . '.docx');
            $documentId   = $request->input('document_id');

            // folder dasar penyimpanan
            $baseFolder = storage_path('app/public/uploads');

            // decode path asal dari document_id
            $relativePath = $documentId ? base64_decode(strtr($documentId, '-_~', '+/=')) : $filename;

            // sanitasi path
            $relativePath = ltrim(str_replace(['../', './', '..\\', '\\'], '', $relativePath), '/');

            // path lengkap tempat menyimpan
            $savePath = $baseFolder . DIRECTORY_SEPARATOR . $relativePath;

            // buat folder jika belum ada
            if (!File::isDirectory(dirname($savePath))) {
                File::makeDirectory(dirname($savePath), 0755, true, true);
            }

            // simpan file
            $uploadedFile->move(dirname($savePath), basename($savePath));

            return response()->json(['message' => 'File saved successfully']);
        } catch (\Exception $e) {
            Log::error('Zoho callback error', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Failed to save file'], 500);
        }
    }

    /* ----------------- edit online ----------------- */
    public function editOnline($encodedPath)
{
    $baseFolder  = storage_path("app/public/uploads");
    $decodedPath = base64_decode(urldecode($encodedPath));
    $fullPath    = realpath($baseFolder . DIRECTORY_SEPARATOR . $decodedPath);

    // Cek keamanan path
    if (!$fullPath || !str_starts_with($fullPath, realpath($baseFolder))) {
        abort(403, 'Access denied.');
    }

    if (!File::exists($fullPath) || !File::isFile($fullPath)) {
        abort(404, 'File not found.');
    }

    // Ambil path relatif
    $relativePath = trim(str_replace(realpath($baseFolder), '', $fullPath), DIRECTORY_SEPARATOR);

    // Buat document_id yang valid: url-safe base64, max 250 chars
    $documentId = rtrim(strtr(base64_encode($relativePath), '+/', '-_'), '=');
    $documentId = substr($documentId, 0, 250); // jaga-jaga

    Log::debug('document_info sent to Zoho', [
        'document_id'   => $documentId,
        'document_name' => basename($fullPath),
    ]);

    try {
        $response = Http::timeout(30)
            ->asMultipart()
            ->post('https://api.office-integrator.com/writer/officeapi/v1/document', [
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
                        'document_id'   => $documentId,
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
                        'save_url'    => url('/zoho-callback'),
                        'save_format' => 'docx',
                    ]),
                ],
            ]);
    } catch (\Illuminate\Http\Client\RequestException $e) {
        Log::error('Zoho API Request Exception', ['error' => $e->getMessage()]);
        return response()->json([
            'error'   => 'Request to Zoho failed.',
            'message' => $e->getMessage(),
        ], 500);
    }

    if (!$response->ok()) {
        Log::error('Zoho API Response Error', ['body' => $response->body()]);
        return response()->json([
            'error'   => 'Failed to initiate Zoho editor.',
            'details' => $response->body(),
        ], 500);
    }

    $data = $response->json();
    return view('templates.zoho-edit', [
        'documentUrl' => $data['document_url'] ?? null,
    ]);
}

}
