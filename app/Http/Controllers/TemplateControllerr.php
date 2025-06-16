<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\Archive; // Pastikan model Archive Anda sudah ada dan benar
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log; // Untuk logging error

class TemplateController extends Controller
{
    public function createFromTemplate(Request $request)
    {
        $request->validate([
            'new_document_name' => 'required|string|max:255',
            'template_filename' => 'required|string', // Ini adalah nama file template, e.g., "surat_resmi_template.docx"
        ]);

        $newDocumentName = $request->input('new_document_name');
        $templateFilename = $request->input('template_filename');
        $templateBaseDir = 'document_templates'; // Direktori tempat template disimpan di storage/app/
        $uploadsBaseDir = 'uploads/documents';   // Direktori tempat instance dokumen baru akan disimpan di storage/app/public/

        // 1. Cek apakah file template ada
        $templatePathSource = $templateBaseDir . '/' . $templateFilename; // Path relatif terhadap disk 'storage/app/'
        if (!Storage::disk('local')->exists($templatePathSource)) { // 'local' disk biasanya merujuk ke storage/app/
            return back()->with('error', 'File template tidak ditemukan.');
        }

        // 2. Tentukan ekstensi, tipe MIME, dan tipe Zoho berdasarkan ekstensi template
        $extension = pathinfo($templateFilename, PATHINFO_EXTENSION);
        $zohoType = '';
        $mimeType = '';

        switch (strtolower($extension)) {
            case 'docx':
                $zohoType = 'doc';
                $mimeType = 'application/vnd.openxmlformats-officedocument.wordprocessingml.document';
                break;
            case 'xlsx':
                $zohoType = 'sheet';
                $mimeType = 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet';
                break;
            case 'pptx':
                $zohoType = 'show';
                $mimeType = 'application/vnd.openxmlformats-officedocument.presentationml.presentation';
                break;
            default:
                return back()->with('error', 'Tipe file template tidak didukung.');
        }

        // 3. Buat nama file dan path unik untuk dokumen baru
        $uuid = (string) Str::uuid();
        $safeNewDocumentName = Str::slug($newDocumentName); // Membuat nama file aman untuk URL/path
        $newFileName = $safeNewDocumentName . '_' . $uuid . '.' . $extension;
        $relativePathForArchive = 'documents/' . $newFileName; // Path relatif untuk disimpan di DB dan Zoho callback
                                                              // Ini akan menjadi storage/app/public/uploads/documents/filename.ext
        $storagePathDestination = $uploadsBaseDir . '/' . $newFileName; // Path relatif terhadap disk 'public' (storage/app/public/)

        // 4. Salin file template ke lokasi baru
        // File disalin dari storage/app/document_templates/template.docx ke storage/app/public/uploads/documents/new_doc.docx
        $templateContent = Storage::disk('local')->get($templatePathSource);
        Storage::disk('public')->put($storagePathDestination, $templateContent); // 'public' disk merujuk ke storage/app/public/

        if (!Storage::disk('public')->exists($storagePathDestination)) {
             return back()->with('error', 'Gagal menyalin template untuk membuat dokumen baru.');
        }

        // 5. Persiapan untuk Zoho API (mirip dengan ArchiveController@createDoc)
        $documentIdForZoho = rtrim(strtr(base64_encode($relativePathForArchive), '+/', '-_'), '=');

        $zohoEndpoint = match ($zohoType) {
            'doc' => 'https://api.office-integrator.com/writer/officeapi/v1/document',
            'sheet' => 'https://api.office-integrator.com/sheet/officeapi/v1/spreadsheet',
            'show' => 'https://api.office-integrator.com/show/officeapi/v1/presentation',
        };

        $permissions = [
            'document.export' => true,
            'document.print'  => true,
            'document.edit'   => true,
        ];
        if ($zohoType === 'doc') {
            $permissions['review.comment'] = true;
            $permissions['collab.chat'] = true;
        }

        // Path lengkap ke file yang baru disalin di storage/app/public/uploads/documents/
        $fullPathForZohoUpload = Storage::disk('public')->path($storagePathDestination);

        // 6. Kirim permintaan ke Zoho
        try {
            $response = Http::timeout(60)->asMultipart()->post($zohoEndpoint, [
                ['name' => 'apikey', 'contents' => config('zoho.api_key')], // Pastikan config('zoho.api_key') ada
                ['name' => 'document', 'contents' => fopen($fullPathForZohoUpload, 'r'), 'filename' => $newFileName],
                ['name' => 'document_info', 'contents' => json_encode([
                    'document_name' => $newFileName,
                    'document_id'   => $documentIdForZoho,
                ])],
                ['name' => 'permissions', 'contents' => json_encode($permissions)],
                ['name' => 'editor_settings', 'contents' => json_encode(['language' => 'en'])],
                ['name' => 'callback_settings', 'contents' => json_encode([
                    'save_url'    => url('/zoho-call-back') . '?doc=' . $documentIdForZoho, // Pastikan URL callback ini benar
                    'save_format' => $extension,
                ])],
            ]);

            if (!$response->ok()) {
                Log::error('Zoho API error saat createFromTemplate', [
                    'status' => $response->status(),
                    'body'   => $response->body(),
                    'request_payload' => [ // Tambahkan payload untuk debugging jika perlu
                        'document_name' => $newFileName,
                        'document_id'   => $documentIdForZoho,
                        'save_url'      => url('/zoho-call-back') . '?doc=' . $documentIdForZoho,
                    ]
                ]);
                // Hapus file yang sudah disalin jika gagal kirim ke Zoho
                Storage::disk('public')->delete($storagePathDestination);
                return back()->with('error', 'Gagal membuat dokumen dari template via Zoho. Detail: ' . $response->reason());
            }

        } catch (\Exception $e) {
            Log::error('Exception saat createFromTemplate Zoho call', ['message' => $e->getMessage()]);
            Storage::disk('public')->delete($storagePathDestination);
            return back()->with('error', 'Terjadi kesalahan saat menghubungi layanan editor dokumen.');
        }


        // 7. Simpan metadata dokumen ke database
        Archive::create([
            'id'          => $uuid, // Menggunakan UUID yang sama
            'name'        => $newDocumentName . '.' . $extension, // Nama yang diinput pengguna + ekstensi
            'path'        => $relativePathForArchive, // Path relatif di dalam storage/app/public/uploads/
            'type'        => $mimeType,
            'size'        => Storage::disk('public')->size($storagePathDestination),
            'uploaded_by' => Auth::id(),
            'created_at'  => now(),
            'updated_at'  => now(),
            'is_deleted'  => false,
            'deleted_at'  => null,
        ]);

        $editorUrl = $response->json('document_url'); // Ambil document_url dari response JSON

        return $editorUrl
            ? redirect()->away($editorUrl)
            : back()->with('error', 'URL editor tidak ditemukan dari Zoho.');
    }
}