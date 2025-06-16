<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use App\Models\Archive;
use App\Models\InformasiAdmin; // <-- Pastikan import ini ada
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\SimpleType\Jc;
use PhpOffice\PhpWord\Style\Language;
use PhpOffice\PhpWord\Shared\Converter;
use PhpOffice\PhpWord\Style\Table;

class ArchiveController extends Controller
{
    public function index()
    {
        try {
            if (Auth::check()) {
                Activity::create([
                    'user_id' => Auth::id(),
                    'activity' => 'Mengakses halaman arsip',
                    'url' => request()->url(),
                ]);
            }

            $activities = Auth::check()
                ? Activity::where('user_id', Auth::id())->latest()->limit(10)->get()
                : collect();

            $allArchives = DB::table('archives')->orderBy('created_at', 'desc')->get();
            $sharedArchives = DB::table('archives')->where('type', '!=', 'folder')->orderBy('created_at', 'desc')->get();
            $karyawans = User::where('role', 'karyawan')->get();
            $users = User::all();
            $trashedItems = Archive::where('is_deleted', true)->orderBy('deleted_at', 'desc')->get();
            
            // [PERBAIKAN] Ambil data informasi sebelum return view
            $informasi = InformasiAdmin::latest()->paginate(10);

            // [PERBAIKAN] Hanya ada satu return view yang mengirim semua data
            return view('archive.archive', [
                'allArchives' => $allArchives,
                'sharedArchives' => $sharedArchives,
                'karyawans' => $karyawans,
                'users' => $users,
                'activities' => $activities,
                'trashedItems' => $trashedItems,
                'informasi' => $informasi, // <-- Data informasi sekarang dikirim
            ]);
        } catch (\Exception $e) {
            return response()->view('errors.custom', ['message' => $e->getMessage()], 500);
        }
    }

    public function trash()
    {
        try {
            // Ambil data yang is_deleted = true (manual soft deleted)
            $trashedItems = Archive::where('is_deleted', true)->orderBy('deleted_at', 'desc')->get();
            return view('archive.pages.trash', compact('trashedItems'));
        } catch (\Exception $e) {
            return response()->view('errors.custom', ['message' => $e->getMessage()], 500);
        }
    }

    public function deletePermanent(Request $request)
    {
        $id = $request->input('id');
        $item = Archive::where('id', $id)->first();  // Hapus method withTrashed()

        if ($item) {
            $storagePath = storage_path('app/public/uploads/' . $item->path);

            if (\File::isFile($storagePath)) {
                \File::delete($storagePath);
            } elseif (\File::isDirectory($storagePath)) {
                \File::deleteDirectory($storagePath);
            }

            // Hapus permanen data dari database dengan delete() biasa
            $item->delete();
        }

        return redirect()->route('archive')->with('success', 'Item dihapus permanen.');
    }

    public function restore(Request $request)
    {
        $id = $request->input('id');

        // Restore berarti update is_deleted jadi false dan deleted_at null
        Archive::where('id', $id)->update([
            'is_deleted' => false,
            'deleted_at' => null,
        ]);

        return redirect()->route('archive')->with('success', 'Item berhasil dikembalikan.');
    }
 public function createDoc(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'type' => 'required|in:doc,sheet,show',
    ]);

    $name = $request->input('name');
    $type = $request->input('type');
    $uuid = (string) Str::uuid();

    // Tentukan ekstensi dan MIME berdasarkan tipe
    $extension = match ($type) {
        'doc' => 'docx',
        'sheet' => 'xlsx',
        'show' => 'pptx',
    };

    $mimeType = match ($type) {
        'doc' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        'sheet' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        'show' => 'application/vnd.openxmlformats-officedocument.presentationml.presentation',
    };

    $relativePath = 'template/' . $name . '.' . $extension;
    $storagePath = storage_path('app/public/uploads/' . $relativePath);

    // Buat direktori jika belum ada
    if (!file_exists(dirname($storagePath))) {
        mkdir(dirname($storagePath), 0755, true);
    }

    // Simpan file kosong agar bisa dikirim ke Zoho
    file_put_contents($storagePath, ' '); // isi 1 byte

    $documentId = rtrim(strtr(base64_encode($relativePath), '+/', '-_'), '=');
    $zohoEndpoint = match ($type) {
        'doc' => 'https://api.office-integrator.com/writer/officeapi/v1/document',
        'sheet' => 'https://api.office-integrator.com/sheet/officeapi/v1/spreadsheet',
        'show' => 'https://api.office-integrator.com/show/officeapi/v1/presentation',
    };

    // Permissions default + tambahan jika perlu
    $permissions = [
        'document.export' => true,
        'document.print'  => true,
        'document.edit'   => true,
    ];
    if ($type === 'doc') {
        $permissions['review.comment'] = true;
        $permissions['collab.chat'] = true;
    }

    // Kirim permintaan ke Zoho
    $response = Http::timeout(30)->asMultipart()->post($zohoEndpoint, [
        ['name' => 'apikey', 'contents' => config('zoho.api_key')],
        ['name' => 'document', 'contents' => fopen($storagePath, 'r'), 'filename' => basename($storagePath)],
        ['name' => 'document_info', 'contents' => json_encode([
            'document_name' => basename($storagePath),
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
        Log::error('Zoho API error saat createDoc', [
            'status' => $response->status(),
            'body'   => $response->body(),
        ]);
        return back()->with('error', 'Gagal membuat dokumen dari Zoho.');
    }

    // Simpan metadata dokumen ke database
    Archive::create([
        'id'          => $uuid,
        'name' => $name . '.' . $extension,
        'path'        => $relativePath,
        'type'        => $mimeType,
        'size'        => Storage::disk('public')->size('uploads/' . $relativePath),
        'uploaded_by' => auth()->id(),
        'created_at'  => now(),
        'updated_at'  => now(),
        'is_deleted'  => false,
        'deleted_at'  => null,
    ]);

    $editorUrl = $response['document_url'] ?? null;

    return $editorUrl
        ? redirect()->away($editorUrl)
        : back()->with('error', 'URL editor tidak ditemukan dari Zoho.');
}
 protected function getRomanMonth($monthNumber)
    {
        $romans = ["I", "II", "III", "IV", "V", "VI", "VII", "VIII", "IX", "X", "XI", "XII"];
        if ($monthNumber >= 1 && $monthNumber <= 12) {
            return $romans[$monthNumber - 1];
        }
        // Fallback jika bulan tidak valid, atau sesuaikan sesuai kebutuhan
        return str_pad((string)$monthNumber, 2, '0', STR_PAD_LEFT);
    }

    protected function generateNextDocumentNumber($type = 'SURATKELUAR', $departmentCode = 'UMUM')
    {
        $year = Carbon::now()->year;
        $month = Carbon::now()->month; // Angka bulan (1-12)

        // Kunci counter bisa berdasarkan tipe, departemen, tahun, dan bulan jika ingin reset bulanan/tahunan
        // Contoh: reset tahunan per departemen
        $counterKey = "doc_num_{$type}_{$departmentCode}_{$year}";
        $formattedDocumentNumber = '';

        DB::transaction(function () use ($counterKey, $year, $month, $departmentCode, &$formattedDocumentNumber) {
            $counter = DB::table('document_counters')
                        ->where('counter_key', $counterKey)
                        ->lockForUpdate() // Lock baris untuk mencegah race condition
                        ->first();

            if (!$counter) {
                $currentValue = 1;
                DB::table('document_counters')->insert([
                    'counter_key' => $counterKey,
                    'current_value' => $currentValue,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            } else {
                $currentValue = $counter->current_value + 1;
                DB::table('document_counters')
                    ->where('counter_key', $counterKey)
                    ->update(['current_value' => $currentValue, 'updated_at' => now()]);
            }

            // Format Nomor Surat: 001/DEPT/BULAN-ROMAWI/TAHUN
            // Sesuaikan format ini dengan kebutuhan Anda
            $paddedNumber = str_pad($currentValue, 3, '0', STR_PAD_LEFT); // misal: 001, 002
            $romanMonth = $this->getRomanMonth($month);

            // Contoh Format: 001/SK/UMUM/V/2025
            // $formattedDocumentNumber = "{$paddedNumber}/SK/{$departmentCode}/{$romanMonth}/{$year}";

            // Format lebih sederhana untuk template ini: NO.URUT/NAMA_TEMPLATE/BULAN-ROMAWI/TAHUN
            // $formattedDocumentNumber = "{$paddedNumber}/TEMPLATE/{$romanMonth}/{$year}";

            // Format yang lebih umum untuk No. Surat: NomorUrut/KodeSurat/KodeUnit/BulanRomawi/Tahun
            // Contoh: 001/A.1/SEKRT/{$romanMonth}/{$year}
            // Untuk contoh ini, kita buat sederhana:
            $formattedDocumentNumber = "No. {$paddedNumber}/SIMPAP/{$romanMonth}/{$year}";


        });

        return $formattedDocumentNumber;
    }
public function createTemplateDoc(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $baseName = $request->input('name');
        $uuid = (string) Str::uuid();
        $documentNameWithExtension = $baseName . '.docx';
        $documentRelativePath = 'template/' . $documentNameWithExtension;

        $saveDir = storage_path('app/public/uploads/template');
        $fullSavePath = $saveDir . '/' . $documentNameWithExtension;
        $generatedDocumentNumber = $this->generateNextDocumentNumber('TEMPLATE', 'DEPT');

        try {
            if (!file_exists($saveDir)) {
                mkdir($saveDir, 0775, true);
            }

            $phpWord = new PhpWord();
            $phpWord->getSettings()->setThemeFontLang(new Language('id-ID'));
            $phpWord->getSettings()->setUpdateFields(true);

            $pageEffectiveWidthTwips = Converter::cmToTwip(15.5);
            $sectionStyle = ['marginLeft' => Converter::cmToTwip(2.5), 'marginRight' => Converter::cmToTwip(2.5), 'marginTop' => Converter::cmToTwip(2), 'marginBottom' => Converter::cmToTwip(2)];
            $currentSection = $phpWord->addSection($sectionStyle);
            $header = $currentSection->addHeader();

            // --- KOP SURAT UTAMA (Logo & Info Perusahaan) ---
            $kopTableStyle = ['width' => $pageEffectiveWidthTwips, 'cellMargin' => 0, 'borderSize' => 0];
            $kopTable = $header->addTable($kopTableStyle);
            $kopTable->addRow();
            
            $logoCellWidth = Converter::cmToTwip(3);
            $infoCellWidth = $pageEffectiveWidthTwips - $logoCellWidth;

            // Ganti 'middle' menjadi 'center'
            $logoCell = $kopTable->addCell($logoCellWidth, ['valign' => 'center']);
            $logoCell->addText(''); // Placeholder logo

            // Ganti 'middle' menjadi 'center'
            $infoCell = $kopTable->addCell($infoCellWidth, ['valign' => 'center']);
            $infoParagraphStyle = ['alignment' => Jc::CENTER, 'spaceBefore' => 0, 'spaceAfter' => 60];
            $infoCell->addText('FILE ARCHIVE ONLINE', ['bold' => true, 'size' => 14, 'name' => 'Arial'], $infoParagraphStyle);
            $infoCell->addText('Jln. Disitu nomer nya sekitaran itu', ['size' => 10, 'name' => 'Arial'], $infoParagraphStyle);
            $infoCell->addText('Telp: 85156052392 , Email: simpap@simpap.my.id', ['size' => 9, 'name' => 'Arial'], $infoParagraphStyle);
            $infoCell->addText('Website: simpap.my.id', ['size' => 9, 'name' => 'Arial'], $infoParagraphStyle);
            
            $header->addLine(['weight' => 1, 'width' => $pageEffectiveWidthTwips, 'height' => 0, 'color' => '000000']);
            $header->addTextBreak(0.5);

            // --- NOMOR DAN TANGGAL (MENYAMPING) ---
            $subHeaderTableStyle = ['width' => $pageEffectiveWidthTwips, 'cellMargin' => 0, 'borderSize' => 0];
            $subHeaderTable = $header->addTable($subHeaderTableStyle);
            $subHeaderTable->addRow();

            $nomorCellWidth = (int)($pageEffectiveWidthTwips * 0.6);
            $tanggalCellWidth = $pageEffectiveWidthTwips - $nomorCellWidth;

            // Ganti 'middle' menjadi 'center'
            $cellNomor = $subHeaderTable->addCell($nomorCellWidth, ['valign' => 'center']);
            $cellNomor->addText(
                'Nomor    : ' . htmlspecialchars($generatedDocumentNumber),
                ['name' => 'Arial', 'size' => 11],
                ['spaceBefore' => 0, 'spaceAfter' => 0]
            );

            // Ganti 'middle' menjadi 'center'
            $cellTanggal = $subHeaderTable->addCell($tanggalCellWidth, ['valign' => 'center']);
            $cellTanggal->addText(
                'Tanggal  : ' . Carbon::now()->translatedFormat('d F Y'),
                ['name' => 'Arial', 'size' => 11],
                ['alignment' => Jc::END, 'spaceBefore' => 0, 'spaceAfter' => 0]
            );
            // --- AKHIR BAGIAN NOMOR DAN TANGGAL ---


            $writer = IOFactory::createWriter($phpWord, 'Word2007');
            $writer->save($fullSavePath);

            // ... (sisa kode untuk Zoho, penyimpanan DB, dan error handling lainnya tetap sama) ...
            if (!file_exists($fullSavePath)) {
                Log::error('File gagal disimpan ke server path setelah generate: ' . $fullSavePath);
                return back()->with('error', 'Gagal menyimpan file template ke server.');
            }
            $fileSize = filesize($fullSavePath);
            $mimeType = 'application/vnd.openxmlformats-officedocument.wordprocessingml.document';

            $zohoDocumentId = rtrim(strtr(base64_encode($documentRelativePath), '+/', '-_'), '=');
            $zohoApiKey = config('zoho.api_key');

            if (empty($zohoApiKey)) {
                Log::error('Zoho API Key tidak dikonfigurasi untuk createTemplateDoc.');
                if (file_exists($fullSavePath)) unlink($fullSavePath);
                return back()->with('error', 'Konfigurasi API Zoho tidak lengkap.');
            }

            $zohoEndpoint = 'https://api.office-integrator.com/writer/officeapi/v1/document';
            $permissions = [
                'document.export' => true, 'document.print'  => true, 'document.edit'   => true,
                'review.comment'  => true, 'collab.chat'     => true,
            ];
            $userId = Auth::id() ?? 'guest_user_id';
            $userName = Auth::check() ? Auth::user()->name : 'Guest User';

            $response = Http::timeout(60)->asMultipart()->post($zohoEndpoint, [
                ['name' => 'apikey', 'contents' => $zohoApiKey],
                ['name' => 'document', 'contents' => fopen($fullSavePath, 'r'), 'filename' => $documentNameWithExtension],
                ['name' => 'document_info', 'contents' => json_encode(['document_name' => $documentNameWithExtension, 'document_id' => $zohoDocumentId])],
                ['name' => 'permissions', 'contents' => json_encode($permissions)],
                ['name' => 'user_info', 'contents' => json_encode(['user_id' => (string)$userId, 'display_name' => $userName])],
                ['name' => 'editor_settings', 'contents' => json_encode(['language' => 'id'])],
                ['name' => 'callback_settings', 'contents' => json_encode(['save_url' => route('zoho.template.saveCallback', ['docId' => $zohoDocumentId]), 'save_format' => 'docx'])],
            ]);

            if (!$response->ok()) {
                Log::error('Zoho API error saat createTemplateDoc', ['status' => $response->status(), 'body' => $response->body(), 'request_data' => ['document_id' => $zohoDocumentId, 'filename' => $documentNameWithExtension]]);
                if (file_exists($fullSavePath)) unlink($fullSavePath);
                return back()->with('error', 'Gagal memproses dokumen template dengan Zoho. Status: ' . $response->status());
            }

            Archive::create([
                'id'            => $uuid,
                'name'          => $documentNameWithExtension,
                'path'          => $documentRelativePath,
                'type'          => $mimeType,
                'size'          => $fileSize,
                'uploaded_by'   => Auth::id(),
                'document_number' => $generatedDocumentNumber,
                'created_at'    => now(),
                'updated_at'    => now(),
                'is_deleted'    => 0,
                'deleted_at'    => null,
            ]);

            $editorUrl = $response->json('document_url');
            if ($editorUrl) {
                return redirect()->away($editorUrl);
            }

            Log::warning('URL editor Zoho tidak ditemukan setelah API call berhasil di createTemplateDoc.', ['response_body' => $response->body()]);
            if (file_exists($fullSavePath)) unlink($fullSavePath);
            Archive::where('id', $uuid)->delete();
            return back()->with('error', 'Gagal mendapatkan URL editor Zoho meskipun API berhasil.');

        } catch (\PhpOffice\PhpWord\Exception\Exception $e) {
            Log::error('PHPWord Exception dalam createTemplateDoc: ' . $e->getMessage() . ' - Trace: ' . $e->getTraceAsString());
            if (isset($fullSavePath) && file_exists($fullSavePath)) unlink($fullSavePath);
            return back()->with('error', 'Kesalahan saat membuat file Word: ' . $e->getMessage());
        } catch (\GuzzleHttp\Exception\RequestException $e) {
            Log::error('Zoho API Guzzle error dalam createTemplateDoc: ' . $e->getMessage(), ['response' => $e->hasResponse() ? (string) $e->getResponse()->getBody() : 'No response']);
            if (isset($fullSavePath) && file_exists($fullSavePath)) unlink($fullSavePath);
            return back()->with('error', 'Kesalahan koneksi ke layanan Zoho: ' . $e->getMessage());
        } catch (\Exception $e) {
            Log::error('Error umum dalam createTemplateDoc: ' . $e->getMessage() . ' - Trace: ' . $e->getTraceAsString());
            if (isset($fullSavePath) && file_exists($fullSavePath)) unlink($fullSavePath);
            return back()->with('error', 'Terjadi kesalahan umum saat membuat template dokumen: ' . $e->getMessage());
        }
    }
        /**
     * Menangani callback penyimpanan dari Zoho untuk template dokumen.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $docId (Base64 encoded relative path)
     * @return \Illuminate\Http\JsonResponse
     */
    public function handleZohoTemplateSaveCallback(Request $request, $docId)
    {
        Log::info('Zoho Template Save Callback received for encoded docId: ' . $docId);
        // Zoho biasanya mengirim file dengan kunci 'document' atau langsung di body.
        // Parameter $request->all() bisa dilihat di log untuk detailnya.

        try {
            // Decode $docId untuk mendapatkan path relatif asli
            // Hati-hati: base64_decode bisa menghasilkan karakter non-UTF8 jika input tidak valid
            $decodedRelativePath = base64_decode(strtr($docId, '-_', '+/'));
            if ($decodedRelativePath === false) {
                Log::error('Zoho Template Save Callback: Gagal decode docId', ['encoded_doc_id' => $docId]);
                return response()->json(['status' => 'error', 'message' => 'Invalid document identifier.'], 400);
            }

            $fullStoragePath = storage_path('app/public/uploads/' . $decodedRelativePath);
            $saveDir = dirname($fullStoragePath);

            if (!file_exists($saveDir)) {
                mkdir($saveDir, 0775, true);
            }

            // Cara Zoho mengirim file bisa bervariasi, cek dokumentasi Zoho Office Integrator
            // atau log $request untuk memastikan. Umumnya via 'document' key (multipart) atau raw body.
            $fileSaved = false;

            if ($request->hasFile('document') && $request->file('document')->isValid()) {
                $file = $request->file('document');
                $file->move($saveDir, basename($fullStoragePath)); // Simpan file yang diupload
                $fileSaved = true;
                Log::info('Zoho document saved from multipart to: ' . $fullStoragePath);
            } elseif (!empty($request->getContent())) {
                // Jika file dikirim sebagai raw request body
                file_put_contents($fullStoragePath, $request->getContent());
                $fileSaved = true;
                Log::info('Zoho document saved from raw body to: ' . $fullStoragePath);
            }

            if ($fileSaved && file_exists($fullStoragePath)) {
                // Update ukuran file di database
                $archive = Archive::where('path', $decodedRelativePath)->first();
                if ($archive) {
                    $archive->size = filesize($fullStoragePath);
                    $archive->updated_at = now(); // Perbarui timestamp update
                    $archive->save();
                    Log::info('Archive record updated for path: ' . $decodedRelativePath . ' with new size: ' . $archive->size);
                } else {
                    Log::warning('Archive record not found for path: ' . $decodedRelativePath . ' during Zoho callback.');
                }
                // Zoho biasanya mengharapkan respons JSON atau hanya status 200 OK
                return response()->json(['status' => 'success', 'message' => 'Document saved successfully by callback.']);
            } else {
                Log::error('Zoho Template Save Callback: No valid file content received.', [
                    'has_file_document' => $request->hasFile('document'),
                    'is_file_valid' => $request->hasFile('document') ? $request->file('document')->isValid() : null,
                    'content_length' => $request->header('Content-Length'),
                ]);
                return response()->json(['status' => 'error', 'message' => 'No valid file content received.'], 400);
            }
        } catch (\Exception $e) {
            Log::error('Error in Zoho Template Save Callback: ' . $e->getMessage(), [
                'encoded_doc_id' => $docId,
                'trace' => $e->getTraceAsString(),
            ]);
            return response()->json(['status' => 'error', 'message' => 'Server error during save: ' . $e->getMessage()], 500);
        }
    }
    
      /**
     * Menampilkan halaman dengan PDF viewer (iframe).
     *
     * @param  \App\Models\Archive  $archive
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function showPdfPage(Archive $archive)
    {
        if ($archive->type !== 'application/pdf') {
            Log::warning("Attempted to view non-PDF file as PDF: ID {$archive->id}, Type: {$archive->type}");
            // Redirect ke halaman unduh jika bukan PDF, atau tampilkan pesan error
            // Anda mungkin sudah punya rute download.file, jika tidak, ini bisa jadi fallback:
             return redirect()->route('download.file', ['filePath' => urlencode(base64_encode($archive->path))])
                              ->with('warning', 'File ini bukan PDF, memulai unduhan.');
            // atau
            // return back()->with('error', 'File ini bukan PDF dan tidak bisa ditampilkan langsung.');
        }

        // Pengecekan hak akses bisa ditambahkan di sini
        // Contoh: if (Auth::user()->cannot('view', $archive)) { abort(403); }

        return view('archive.pdf-viewer', compact('archive'));
    }

    /**
     * Mengirimkan konten file PDF ke browser.
     *
     * @param  \App\Models\Archive  $archive
     * @return \Symfony\Component\HttpFoundation\StreamedResponse|\Illuminate\Http\RedirectResponse
     */
    public function streamPdf(Archive $archive)
    {
        if ($archive->type !== 'application/pdf') {
            Log::error("Stream attempt for non-PDF file: ID {$archive->id}, Type: {$archive->type}");
            abort(404, 'File bukan PDF.');
        }

        // Pengecekan hak akses bisa ditambahkan di sini
        // Contoh: if (Auth::user()->cannot('view', $archive)) { abort(403); }

        $filePath = 'uploads/' . $archive->path; // Path relatif terhadap disk 'public'

        if (!Storage::disk('public')->exists($filePath)) {
            Log::error("PDF file not found for streaming: ID {$archive->id}, Path: {$filePath}");
            abort(404, 'File PDF tidak ditemukan di storage.');
        }

        $absoluteFilePath = Storage::disk('public')->path($filePath);

        $headers = [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . basename($archive->name) . '"',
        ];

        return response()->file($absoluteFilePath, $headers);
    }

}