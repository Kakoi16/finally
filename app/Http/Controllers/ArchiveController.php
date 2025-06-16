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
    
}
