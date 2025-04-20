<!-- resources/views/home.blade.php -->

@extends('layouts.app')

@section('content')
<div class="bg-white min-h-screen py-16 px-6 sm:px-12 lg:px-32">
    <div class="max-w-4xl mx-auto bg-gray-50 p-10 rounded-2xl shadow-lg border border-gray-200">
        <h1 class="text-3xl font-bold text-gray-800 mb-6">Sistem File Archive Perusahaan</h1>
        <p class="text-gray-700 leading-relaxed mb-4">
            <strong>Sistem File Archive Perusahaan</strong> merupakan aplikasi digital yang digunakan untuk
            mengelola dan menyimpan seluruh arsip file template surat resmi perusahaan. Sistem ini bertujuan
            untuk menyediakan akses yang terstandarisasi terhadap dokumen administratif perusahaan,
            mempermudah proses pengajuan surat, serta memastikan keteraturan nomor surat berdasarkan
            riwayat penggunaan di masing-masing jenis dokumen.
        </p>
        <p class="text-gray-700 leading-relaxed mb-4">
            Sistem ini memungkinkan pengguna untuk mengunduh template surat sesuai kebutuhan,
            mengajukan permohonan pembuatan surat, dan mendapatkan nomor surat resmi yang terekam
            secara historis.
        </p>
        <p class="text-gray-700 leading-relaxed">
            Setiap template surat sudah diklasifikasikan berdasarkan kategori, seperti: <span class="font-medium">Surat Keterangan Karyawan</span>,
            <span class="font-medium">Pengajuan Keluhan</span>, <span class="font-medium">Permohonan Cuti</span>, <span class="font-medium">Surat Rekomendasi</span>, dan lainnya.
        </p>
    </div>
</div>
@endsection
