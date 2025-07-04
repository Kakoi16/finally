<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PengajuanSurat;
use App\Models\Archive;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use App\Models\User; // Import model User
use App\Models\Notification; // <<< IMPORT MODEL NOTIFICATION
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule; // Import Rule untuk validasi enum
use PDF; // Tambahkan ini
use Carbon\Carbon;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class PengajuanSuratController extends Controller
{
    /**
     * Menyimpan pengajuan surat baru dari karyawan.
     */
     public function store(Request $request)
    {
        $validatedRules = [
            'surat_number' => 'required|string|max:255|unique:pengajuan_surats,surat_number',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'category' => 'required|string|max:255',
            'start_date' => 'nullable|date_format:Y-m-d',
            'end_date' => 'nullable|date_format:Y-m-d|after_or_equal:start_date',
            'reason' => 'nullable|string',
            'position' => 'nullable|string|max:255',
            'join_date' => 'nullable|date_format:Y-m-d',
            'purpose' => 'nullable|string',
            'department' => 'nullable|string|max:255',
            'complaint_category' => 'nullable|string|max:255',
            'complaint_description' => 'nullable|string',
            'recommended_name' => 'nullable|string|max:255',
            'recommender_name' => 'nullable|string|max:255',
            'recommender_position' => 'nullable|string|max:255',
            'recommendation_reason' => 'nullable|string',
            'user_id' => 'nullable|exists:users,id',

            // Validasi untuk file yang diunggah pengguna (jika ada)
            'user_uploaded_attachment' => 'nullable|file|mimes:pdf|max:2048', // Max 2MB
        ];
        Log::info('User ID saat menyimpan pengajuan:', ['user_id' => auth()->id()]);

        $validatedData = $request->validate($validatedRules);

        // Data untuk PDF sama dengan validatedData, bisa ditambahkan item lain jika perlu
$userId = auth()->id();
$profileUrl = 'https://simpap.my.id/public/profile/' . $userId;

$qrSvg = QrCode::format('svg')->size(200)->generate($profileUrl);
$base64Qr = 'data:image/svg+xml;base64,' . base64_encode($qrSvg);

// Siapkan data untuk PDF (gabungan dari validatedData dan QR Code)
$pdfData = $validatedData;
$pdfData['qr_code'] = $base64Qr;
$pdfData['current_date'] = Carbon::now()->translatedFormat('d F Y');

// Isi recommender_name jika kosong untuk Surat Rekomendasi
if ($pdfData['category'] === 'Surat Rekomendasi' && empty($pdfData['recommender_name'])) {
    $pdfData['recommender_name'] = $pdfData['name'];
}


        // 1. Generate PDF dari data formulir
        $generatedPdfFileName = Str::slug($validatedData['surat_number'] . '_' . $validatedData['category'] . '_generated') . '.pdf';
        $generatedPdfStoragePath = 'karyawan/' . $generatedPdfFileName; // Relative to 'uploads/' directory in public disk

        $viewName = 'pdf_templates.default_surat'; // Fallback
        switch ($validatedData['category']) {
            case 'Permohonan Cuti': $viewName = 'pdf_templates.permohonan_cuti'; break;
            case 'Surat Keterangan Karyawan': $viewName = 'pdf_templates.keterangan_karyawan'; break;
            case 'Pengajuan Keluhan': $viewName = 'pdf_templates.pengajuan_keluhan'; break;
            case 'Surat Rekomendasi': $viewName = 'pdf_templates.surat_rekomendasi'; break;
        }

        DB::beginTransaction();
        try {
            if (!view()->exists($viewName)) {
                throw new \Exception("Template PDF tidak ditemukan: {$viewName}");
            }
            $pdf = PDF::loadView($viewName, $pdfData);
            $pdfContent = $pdf->output(); // Dapatkan konten PDF sebagai string

            // Simpan PDF yang di-generate ke storage
            // Path lengkap: storage/app/public/uploads/generated_surat/namafile.pdf
            Storage::disk('public')->put('uploads/' . $generatedPdfStoragePath, $pdfContent);

            // Data untuk tabel pengajuan_surats
            $dataToStorePengajuan = $validatedData;
            unset($dataToStorePengajuan['user_uploaded_attachment']); // Hapus file dari data utama

            $dataToStorePengajuan['attachment'] = $generatedPdfFileName; // Nama file PDF yang di-generate
            $dataToStorePengajuan['attachment_path'] = $generatedPdfStoragePath; // Path PDF yang di-generate
            $dataToStorePengajuan['status'] = PengajuanSurat::STATUS_PROSES;
            $dataToStorePengajuan['user_id'] = auth()->id(); 


            // 2. Buat entri PengajuanSurat
            $pengajuanSurat = PengajuanSurat::create($dataToStorePengajuan);

            // 3. Buat entri Archive untuk PDF yang di-generate
            Archive::create([
                'pengajuan_surat_id' => $pengajuanSurat->id,
                'document_number'    => $pengajuanSurat->surat_number,
                'name'               => $generatedPdfFileName,
                'path'               => $generatedPdfStoragePath,
                'type'               => 'application/pdf', // Tipe file PDF
                'size'               => strlen($pdfContent), // Ukuran file dalam bytes
                'uploaded_by'        => $pengajuanSurat->name, // Nama pengaju
                'description'        => 'Surat Utama (Generated System)', // Deskripsi tambahan
            ]);

            // 4. Handle user_uploaded_attachment (lampiran opsional dari pengguna)
            if ($request->hasFile('user_uploaded_attachment') && $request->file('user_uploaded_attachment')->isValid()) {
                $fileObjectUser = $request->file('user_uploaded_attachment');
                // Gunakan nama file asli yang dikirim dari frontend (sudah termasuk nomor surat)
                $fileNameToStoreUser = $fileObjectUser->getClientOriginalName();

                // Simpan file unggahan pengguna
                // Path: storage/app/public/uploads/karyawan_attachments/namafile.pdf
                $userUploadedPath = $fileObjectUser->storeAs('uploads/karyawan_attachments', $fileNameToStoreUser, 'public');
                $userUploadedPathForDb = 'karyawan_attachments/' . $fileNameToStoreUser; // Path relatif untuk DB

                // Buat entri Archive untuk file yang diunggah pengguna
                Archive::create([
                    'pengajuan_surat_id' => $pengajuanSurat->id,
                    'document_number'    => $pengajuanSurat->surat_number, // Bisa sama atau berbeda jika perlu
                    'name'               => $fileNameToStoreUser,
                    'path'               => $userUploadedPathForDb,
                    'type'               => $fileObjectUser->getClientMimeType(),
                    'size'               => $fileObjectUser->getSize(),
                    'uploaded_by'        => $pengajuanSurat->name,
                    'description'        => 'Lampiran Pendukung (Unggahan Pengguna)',
                ]);
            }

            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Pengajuan surat berhasil disimpan, PDF telah digenerate dan diarsipkan.',
                'data' => $pengajuanSurat
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Pengajuan Surat Store Failed: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'request_data' => $request->except('user_uploaded_attachment') // Jangan log file content
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Gagal menyimpan data pengajuan surat: ' . $e->getMessage(),
            ], 500);
        }
    }
    /**
     * Menampilkan daftar pengajuan surat untuk admin.
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function indexForAdmin(Request $request)
    {
        $query = PengajuanSurat::orderBy('created_at', 'desc');

        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }
        
        // Filter berdasarkan pencarian
        if ($request->filled('search')) {
            $searchTerm = '%' . $request->search . '%';
            $query->where(function($q) use ($searchTerm) {
                $q->where('name', 'like', $searchTerm)
                  ->orWhere('surat_number', 'like', $searchTerm)
                  ->orWhere('category', 'like', $searchTerm)
                  ->orWhere('email', 'like', $searchTerm); // Tambahkan pencarian berdasarkan email jika relevan
            });
        }

        $submissions = $query->paginate(10); // Ambil 10 data per halaman
        return response()->json($submissions);
    }

    public function updateStatus(Request $request, PengajuanSurat $pengajuanSurat)
    {
        $validated = $request->validate([
            'status' => [
                'required',
                Rule::in([PengajuanSurat::STATUS_DISETUJUI, PengajuanSurat::STATUS_DITOLAK]),
            ],
            'remarks' => 'nullable|string|max:1000', // Opsional: alasan penolakan atau catatan
        ]);

        $oldStatus = $pengajuanSurat->status; // Simpan status lama
        $pengajuanSurat->status = $validated['status'];
        // Anda bisa menyimpan remarks jika ada kolomnya
        // $pengajuanSurat->remarks = $validated['remarks'] ?? null;
        $pengajuanSurat->save();

        // --- TAMBAHKAN LOGIKA NOTIFIKASI DI SINI ---
        if ($oldStatus !== PengajuanSurat::STATUS_DISETUJUI && $pengajuanSurat->status === PengajuanSurat::STATUS_DISETUJUI) {
            // Pastikan notifikasi hanya dibuat jika status berubah menjadi DISETUJUI
            $recipientUser = null;
            // Coba temukan user_id dari pengajuan, jika tidak ada, gunakan email
            if ($pengajuanSurat->user_id) {
                $recipientUser = User::find($pengajuanSurat->user_id);
            } elseif ($pengajuanSurat->email) {
                $recipientUser = User::where('email', $pengajuanSurat->email)->first();
            }

            if ($recipientUser) {
                Notification::create([
                    'user_id' => $recipientUser->id,
                    'type' => 'status_update',
                    'title' => 'Surat Anda Telah Disetujui!',
                    'message' => "Pengajuan surat \"{$pengajuanSurat->surat_number}\" ({$pengajuanSurat->category}) telah disetujui. Anda bisa mengunduhnya sekarang.",
                    'read' => false,
                    'data' => [
                        'pengajuan_id' => $pengajuanSurat->id,
                        'surat_number' => $pengajuanSurat->surat_number,
                        'category' => $pengajuanSurat->category,
                        'status' => $pengajuanSurat->status,
                    ],
                ]);
                Log::info("Notifikasi persetujuan surat dibuat untuk user_id: {$recipientUser->id}");
            } else {
                Log::warning("Gagal membuat notifikasi: User penerima tidak ditemukan untuk pengajuan ID: {$pengajuanSurat->id}");
            }
        }
        // --- AKHIR LOGIKA NOTIFIKASI ---

        return response()->json([
            'success' => true,
            'message' => 'Status pengajuan surat berhasil diperbarui menjadi ' . $validated['status'] . '.',
            'data' => $pengajuanSurat
        ]);
    }
    
      public function getUserNotifications(Request $request)
    {
        $user = $request->user();

        if (!$user) {
            return response()->json(['message' => 'Unauthenticated.'], 401);
        }

        $notifications = Notification::where('user_id', $user->id)
                                    ->orderBy('created_at', 'desc')
                                    ->limit(10) // Ambil 10 notifikasi terbaru
                                    ->get();

        // Tandai notifikasi yang belum dibaca sebagai sudah dibaca (opsional, tergantung alur UI)
        // Notification::where('user_id', $user->id)->where('read', false)->update(['read' => true]);

        return response()->json([
            'success' => true,
            'data' => $notifications,
            'unread_count' => Notification::where('user_id', $user->id)->where('read', false)->count(),
        ]);
    }

    // --- TAMBAHKAN METHOD UNTUK MENANDAI NOTIFIKASI SEBAGAI DIBACA ---
    public function markNotificationAsRead(Request $request, Notification $notification)
    {
        $user = $request->user();

        if (!$user || $notification->user_id !== $user->id) {
            return response()->json(['message' => 'Unauthorized.'], 403);
        }

        $notification->read = true;
        $notification->save();

        return response()->json(['success' => true, 'message' => 'Notifikasi berhasil ditandai sebagai dibaca.']);
    }


    public function statusByUser(Request $request)
{
    $user = $request->user();

    if (!$user) {
        \Log::warning('User tidak ditemukan di statusByUser');
        return response()->json([
            'success' => false,
            'message' => 'User tidak ditemukan atau token tidak valid.'
        ], 401);
    }

    \Log::info('statusByUser called for user email: ' . $user->email);

    try {
        $pengajuanList = PengajuanSurat::where('email', $user->email)
            ->orderBy('created_at', 'desc')
            ->get();
    } catch (\Exception $e) {
        \Log::error('Query error in statusByUser: ' . $e->getMessage());
        return response()->json([
            'success' => false,
            'message' => 'Terjadi kesalahan pada server: ' . $e->getMessage(),
        ], 500);
    }

    return response()->json([
        'success' => true,
        'data' => $pengajuanList
    ]);
}
// app/Http/Controllers/PengajuanSuratController.php

public function checkPendingSubmission(Request $request)
{
    // Validasi hanya untuk 'category' karena 'email' akan diambil dari user yang login
    $validated = $request->validate([
        'category' => 'required|string|max:255',
    ]);

    $user = $request->user(); // Dapatkan user yang terotentikasi via Sanctum

    if (!$user) {
        // Ini seharusnya tidak terjadi jika middleware auth:sanctum bekerja dengan benar
        // dan token valid dikirim, tetapi sebagai lapisan keamanan tambahan.
        \Log::warning('checkPendingSubmission: User not authenticated despite auth:sanctum middleware.');
        return response()->json(['message' => 'Unauthenticated.'], 401);
    }

    $email = $user->email; // Gunakan email dari user yang login
    $category = $validated['category'];

    try {
        $pendingSubmission = PengajuanSurat::where('email', $email)
            ->where('category', $category)
            ->where('status', PengajuanSurat::STATUS_PROSES) // Menggunakan konstanta dari model
            ->orderBy('created_at', 'desc')
            ->first();

        if ($pendingSubmission) {
            // Ada pengajuan yang sedang diproses
            return response()->json(['status' => PengajuanSurat::STATUS_PROSES]);
        } else {
            // Tidak ada pengajuan 'Proses' yang ditemukan untuk user dan kategori ini
            return response()->json(['status' => 'aman']);
        }
    } catch (\Exception $e) {
        // Log error untuk diagnosis yang lebih baik
        \Log::error('Error in checkPendingSubmission for user ' . $email . ', category ' . $category . ': ' . $e->getMessage(), [
            'trace' => $e->getTraceAsString() // Optional: tambahkan trace untuk detail lebih
        ]);
        // Jangan tampilkan detail error ke frontend di lingkungan produksi
        $errorMessage = config('app.debug') ? 'Server error: ' . $e->getMessage() : 'Terjadi kesalahan pada server saat memeriksa status.';
        return response()->json(['message' => $errorMessage], 500);
    }
}

 public function generatePdfPreview(Request $request)
    {
        // Validasi data yang diperlukan untuk PDF, bisa disesuaikan
        $validatedData = $request->validate([
            'surat_number' => 'nullable|string|max:255',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'category' => 'required|string|max:255',
            'start_date' => 'nullable|date_format:Y-m-d',
            'end_date' => 'nullable|date_format:Y-m-d',
            'reason' => 'nullable|string',
            'position' => 'nullable|string|max:255',
            'join_date' => 'nullable|date_format:Y-m-d',
            'purpose' => 'nullable|string',
            'department' => 'nullable|string|max:255',
            'complaint_category' => 'nullable|string|max:255',
            'complaint_description' => 'nullable|string',
            'recommended_name' => 'nullable|string|max:255',
            'recommender_name' => 'nullable|string|max:255', // Akan diisi dari 'name' jika kosong
            'recommender_position' => 'nullable|string|max:255',
            'recommendation_reason' => 'nullable|string',
            // Tambahkan field lain jika perlu untuk PDF
        ]);

        $data = $validatedData;
        // Set tanggal hari ini untuk PDF jika diperlukan
        $data['current_date'] = Carbon::now()->translatedFormat('d F Y');

        if ($data['category'] === 'Surat Rekomendasi' && empty($data['recommender_name'])) {
            $data['recommender_name'] = $data['name'];
        }
        if (empty($data['surat_number']) && $request->filled('generated_surat_number_for_pdf')) {
            // Jika frontend mengirimkan nomor surat yang baru digenerate khusus untuk PDF
            $data['surat_number'] = $request->input('generated_surat_number_for_pdf');
        } elseif (empty($data['surat_number'])) {
            $data['surat_number'] = 'Belum Ada / Preview';
        }


        $viewName = 'pdf_templates.default_surat'; // Fallback template
        switch ($data['category']) {
            case 'Permohonan Cuti':
                $viewName = 'pdf_templates.permohonan_cuti';
                break;
            case 'Surat Keterangan Karyawan':
                $viewName = 'pdf_templates.keterangan_karyawan';
                break;
            case 'Pengajuan Keluhan':
                $viewName = 'pdf_templates.pengajuan_keluhan';
                break;
            case 'Surat Rekomendasi':
                $viewName = 'pdf_templates.surat_rekomendasi';
                break;
        }

        try {
            if (!view()->exists($viewName)) {
                Log::error("PDF template not found: {$viewName}");
                return response()->json(['message' => 'Template PDF tidak ditemukan.'], 500);
            }

            // Set default paper size and orientation (opsional)
            // $pdf = PDF::loadView($viewName, $data)->setPaper('a4', 'portrait');
            $pdf = PDF::loadView($viewName, $data);

            $fileName = Str::slug($data['category'] . '_' . $data['name'] . '_' . time()) . '.pdf';

            // return $pdf->stream($fileName); // Untuk menampilkan di browser
            return $pdf->download($fileName); // Untuk langsung download

        } catch (\Exception $e) {
            Log::error('Error generating PDF: ' . $e->getMessage());
            Log::error('Data for PDF: ', $data);
            Log::error('View name: ' . $viewName);
            return response()->json(['message' => 'Gagal membuat PDF: ' . $e->getMessage()], 500);
        }
    }
public function reject(Request $request)
{
    $request->validate([
        'id' => 'required|exists:pengajuan_surats,id',
        'remarks' => 'required|string|max:1000',
    ]);

    $pengajuan = PengajuanSurat::findOrFail($request->id);
    $pengajuan->status = PengajuanSurat::STATUS_DITOLAK;
    $pengajuan->remarks = $request->remarks;
    $pengajuan->save();

    return redirect()->back()->with('success', 'Pengajuan surat berhasil ditolak dengan alasan.');
}

    // app/Http/Controllers/PengajuanSuratController.php

public function downloadGeneratedPdf(Request $request, PengajuanSurat $pengajuan)
{
    $loggedInUser = $request->user(); // Ganti nama variabel agar lebih jelas: user yang sedang login

    // Pastikan user ada dan valid
    if (!$loggedInUser) {
        Log::warning('Akses ditolak: Tidak ada user terautentikasi saat mencoba mengunduh surat ID ' . $pengajuan->id);
        return response()->json(['message' => 'Tidak terautentikasi.'], 401);
    }

    // Keamanan Lapis 1: Izinkan jika user adalah pemilik surat ATAU user memiliki role 'admin'
    // Logika ini sudah benar jika $loggedInUser->role sudah teruji
    if ($pengajuan->email !== $loggedInUser->email && $loggedInUser->role !== 'admin') {
        Log::warning('Akses ditolak: User ' . $loggedInUser->email . ' (Role: ' . $loggedInUser->role . ') mencoba mengunduh surat ID ' . $pengajuan->id . ' milik ' . $pengajuan->email);
        return response()->json(['message' => 'Akses ditolak. Anda tidak memiliki izin untuk mengakses file ini.'], 403);
    }

    // --- Log Debugging Sangat Penting di Sini ---
    Log::info('--- Memanggil downloadGeneratedPdf untuk Pengajuan ID: ' . $pengajuan->id . ' ---');
    Log::info('Status Pengajuan dari DB: ' . $pengajuan->status);
    Log::info('Nilai Konstanta STATUS_DISETUJUI: ' . PengajuanSurat::STATUS_DISETUJUI);
    // --- Akhir Log Debugging ---

    // Siapkan data untuk PDF
    $pdfData = $pengajuan->toArray(); // Konversi model ke array untuk data dasar

    // --- BARIS YANG DIPERBAIKI UNTUK QR CODE ---
    // Gunakan user_id dari pengajuan surat, bukan dari user yang sedang login
    $qrProfileId = $pengajuan->user_id; 
    // Fallback jika somehow user_id di pengajuan kosong (meskipun seharusnya tidak)
    if (empty($qrProfileId)) {
        // Jika user_id di pengajuan kosong, fallback ke ID user yang mengajukan berdasarkan email
        // Ini membutuhkan query ke tabel users, pastikan User model sudah diimport
        $applicantUser = \App\Models\User::where('email', $pengajuan->email)->first();
        $qrProfileId = $applicantUser ? $applicantUser->id : $loggedInUser->id; // Fallback terakhir ke ID admin jika tidak ditemukan
        Log::warning('User ID untuk QR Code kosong di pengajuan ID ' . $pengajuan->id . ', menggunakan ID: ' . $qrProfileId);
    }
    
    $profileUrl = 'https://simpap.my.id/public/profile/' . $qrProfileId;
    $qrSvg = QrCode::format('svg')->size(200)->generate($profileUrl);
    $base64Qr = 'data:image/svg+xml;base64,' . base64_encode($qrSvg);
    $pdfData['qr_code'] = $base64Qr;
    // --- AKHIR PERBAIKAN QR CODE ---

    $pdfData['current_date'] = Carbon::now()->translatedFormat('d F Y');
    $pdfData['status'] = $pengajuan->status; // PENTING: Lewatkan status terbaru ke view

    // Tentukan view template berdasarkan kategori
    $viewName = 'pdf_templates.default_surat';
    switch ($pengajuan->category) {
        case 'Permohonan Cuti': $viewName = 'pdf_templates.permohonan_cuti'; break;
        case 'Surat Keterangan Karyawan': $viewName = 'pdf_templates.keterangan_karyawan'; break;
        case 'Pengajuan Keluhan': $viewName = 'pdf_templates.pengajuan_keluhan'; break;
        case 'Surat Rekomendasi': $viewName = 'pdf_templates.surat_rekomendasi'; break;
    }

    DB::beginTransaction(); // Mulai transaksi database
    try {
        if (!view()->exists($viewName)) {
            throw new \Exception("Template PDF tidak ditemukan: {$viewName}");
        }

        $pdf = PDF::loadView($viewName, $pdfData);
        $pdfContent = $pdf->output(); // Dapatkan konten PDF sebagai string

        // Tentukan nama file dan path untuk PDF yang telah disetujui
        $approvedFileName = Str::slug($pengajuan->surat_number . '_' . $pengajuan->category . '_disetujui') . '.pdf';
        $approvedStorageRelativePath = 'karyawan/' . $approvedFileName; // Path relatif untuk DB
        $fullApprovedStoragePath = 'uploads/' . $approvedStorageRelativePath; // Path lengkap untuk Storage::put/download

        // Opsi: Hapus file lama jika nama file berubah atau untuk memastikan versi terbaru
        if ($pengajuan->attachment_path && $pengajuan->attachment_path !== $approvedStorageRelativePath) {
            $oldFullPath = 'uploads/' . $pengajuan->attachment_path;
            if (Storage::disk('public')->exists($oldFullPath)) {
                Storage::disk('public')->delete($oldFullPath);
                Log::info('File PDF lama dihapus untuk ID: ' . $pengajuan->id . ' di: ' . $oldFullPath);
            }
        }

        // Simpan PDF yang di-generate ulang dengan stempel persetujuan
        Storage::disk('public')->put($fullApprovedStoragePath, $pdfContent);
        Log::info('PDF yang disetujui berhasil disimpan untuk ID: ' . $pengajuan->id . ' di: ' . $fullApprovedStoragePath);

        // Update path dan nama file di model PengajuanSurat di database
        if ($pengajuan->attachment !== $approvedFileName || $pengajuan->attachment_path !== $approvedStorageRelativePath) {
            $pengajuan->attachment = $approvedFileName;
            $pengajuan->attachment_path = $approvedStorageRelativePath;
            $pengajuan->save();
            Log::info('Model PengajuanSurat diupdate dengan path lampiran baru untuk ID: ' . $pengajuan->id);
        } else {
             Log::info('Path lampiran di model PengajuanSurat sudah yang terbaru untuk ID: ' . $pengajuan->id);
        }
        
        DB::commit(); // Komit transaksi

        // Kirim file untuk diunduh.
        if (Storage::disk('public')->exists($fullApprovedStoragePath)) {
            Log::info('Mengirim file PDF untuk diunduh dari: ' . $fullApprovedStoragePath);
            return Storage::disk('public')->download($fullApprovedStoragePath, $approvedFileName);
        } else {
            Log::error('File PDF yang disetujui tidak ditemukan setelah disimpan. Path: ' . $fullApprovedStoragePath);
            return response()->json(['message' => 'Terjadi kesalahan: File PDF yang disetujui tidak ditemukan di server setelah regenerasi.'], 500);
        }

    } catch (\Exception $e) {
        DB::rollBack(); // Rollback transaksi jika ada error
        Log::error('Error saat me-regenerate atau mengunduh PDF untuk ID ' . $pengajuan->id . ': ' . $e->getMessage(), [
            'trace' => $e->getTraceAsString(),
            'request_data' => $request->except('user_uploaded_attachment')
        ]);
        return response()->json(['message' => 'Gagal me-regenerate atau mengunduh file PDF: ' . $e->getMessage()], 500);
    }
}
public function getLastNumber(Request $request)
{
    $category = $request->input('category'); // Ambil dari body POST

    if (!$category) {
        return response()->json([
            'message' => 'Kategori surat tidak ditemukan.'
        ], 400);
    }

    $lastSurat = PengajuanSurat::where('category', $category)
        ->orderByDesc('created_at')
        ->first();

    $lastNumber = $lastSurat ? $lastSurat->surat_number : null;

    return response()->json([
        'last_number' => $lastNumber
    ]);
}


}
