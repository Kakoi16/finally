<div id="halo-page" class="page-content hidden">
    <div class="p-6 max-w-4xl mx-auto bg-white shadow-md rounded-lg mt-6">
        <div class="flex items-center space-x-4 mb-4">
            <div class="bg-blue-100 p-3 rounded-full">
                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M12 2a10 10 0 100 20 10 10 0 000-20z" />
                </svg>
            </div>
            <div>
                <h2 class="text-2xl font-bold text-gray-800">Halo, Selamat Datang!</h2>
                <p class="text-sm text-gray-500">Ini adalah tampilan awal halaman Archive.</p>
            </div>
        </div>

        <div class="border-t pt-4">
            <p class="text-gray-700 leading-relaxed">
                Anda sekarang berada di halaman default sistem manajemen arsip. Gunakan menu di sebelah kiri untuk menavigasi ke berbagai fitur seperti pengajuan surat, berbagi file, melihat file terbaru, hingga mengelola akun karyawan.
            </p>
            <div class="mt-6">
                <a href="#" data-page="dashboard-page"
                   class="inline-block bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition-all shadow-md">
                    Lanjut ke Dashboard
                </a>
            </div>
        </div>
    </div>
</div>
<a href="{{ route('archive.trash') }}"
   class="inline-flex items-center hidden px-4 py-2 bg-red-600 text-white text-sm font-medium rounded hover:bg-red-700">
    <i class="fas fa-trash mr-2"></i> Lihat Tong Sampah
</a>
