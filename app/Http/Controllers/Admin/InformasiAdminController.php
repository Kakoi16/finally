<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\InformasiAdmin;
use Illuminate\Http\Request;

class InformasiAdminController extends Controller
{
    /**
     * Menampilkan daftar informasi.
     */
    public function index()
    {
        $informasi = InformasiAdmin::latest()->paginate(10);
        // Menggunakan view 'archive.pages.shared' untuk menampilkan data
        return view('archive.pages.shared', compact('informasi'));
    }

    /**
     * Menampilkan form untuk membuat data baru.
     */
    public function create()
    {
        return view('admin.informasi.create');
    }

    /**
     * Menyimpan data baru ke database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'caption' => 'required|string|max:255',
        ]);

        InformasiAdmin::create($request->all());

        // [PERBAIKAN] Mengarahkan kembali ke halaman utama arsip
        return redirect()->route('archive')
                         ->with('success', 'Informasi berhasil ditambahkan.');
    }

    /**
     * Menampilkan form untuk mengedit data.
     */
    public function edit(InformasiAdmin $informasi)
    {
        return view('admin.informasi.edit', compact('informasi'));
    }

    /**
     * Memperbarui data di database.
     */
    public function update(Request $request, InformasiAdmin $informasi)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'caption' => 'required|string|max:255',
        ]);

        $informasi->update($request->all());

        // [PERBAIKAN] Mengarahkan kembali ke halaman utama arsip
        return redirect()->route('archive')
                         ->with('success', 'Informasi berhasil diperbarui.');
    }

    /**
     * Menghapus data dari database.
     */
    public function destroy(InformasiAdmin $informasi)
    {
        $informasi->delete();

        // [PERBAIKAN] Mengarahkan kembali ke halaman utama arsip
        return redirect()->route('archive')
                         ->with('success', 'Informasi berhasil dihapus.');
    }
}
