<aside id="sidebar" class="hidden md:relative fixed md:flex md:flex-col w-72 bg-white rounded-xl shadow-lg border border-gray-100 p-4 mr-6 space-y-6 z-100">

    <div class="px-2 py-2 text-center border-b border-gray-200 pb-4 mb-2">
        <a href="#" class="text-xl font-semibold text-indigo-600 hover:text-indigo-700 transition-colors">
            SIMPAP
        </a>
    </div>

    <nav class="flex-1 custom-scrollbar overflow-y-auto pr-1">
        <ul class="space-y-1.5">
            <li>
                {{-- Contoh state aktif (biasanya diatur oleh JS, ini hanya untuk visualisasi) --}}
                <a data-log-activity="Klik menu Dashboard" href="#" class="sidebar-menu sidebar-menu-active flex items-center space-x-3 px-3 py-2.5 rounded-lg text-indigo-700 bg-indigo-50 transition-colors duration-150" data-page="dashboard-page">
                    <i class="fas fa-home w-5 h-5 text-center text-indigo-600"></i>
                    <span class="text-sm font-semibold">Beranda</span>
                </a>
            </li>
            <li>
                <a data-log-activity="Klik menu Semua File" href="#" class="sidebar-menu flex items-center space-x-3 px-3 py-2.5 rounded-lg text-gray-700 hover:bg-gray-100 hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-gray-50 transition-colors duration-150" data-page="all-files-page">
                    <i class="fas fa-folder w-5 h-5 text-center text-blue-500"></i>
                    <span class="text-sm font-medium">Semua File</span>
                </a>
            </li>
            <li>
                <a href="#" class="sidebar-menu flex items-center space-x-3 px-3 py-2.5 rounded-lg text-gray-700 hover:bg-gray-100 hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-gray-50 transition-colors duration-150" data-page="create-page">
                    <i class="fas fa-file-alt w-5 h-5 text-center text-cyan-500"></i> {{-- Mengganti fa-file dengan fa-file-alt untuk ikon yang sedikit berbeda --}}
                    <span class="text-sm font-medium">Buat File</span>
                </a>
            </li>
            <li>
                <a data-log-activity="Klik menu Berbagi" href="#" class="sidebar-menu flex items-center space-x-3 px-3 py-2.5 rounded-lg text-gray-700 hover:bg-gray-100 hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-gray-50 transition-colors duration-150" data-page="shared-page">
                    <i class="fas fa-share-alt w-5 h-5 text-center text-green-500"></i>
                    <span class="text-sm font-medium">Berbagi</span>
                </a>
            </li>
            <li>
                <a href="#" class="sidebar-menu flex items-center space-x-3 px-3 py-2.5 rounded-lg text-gray-700 hover:bg-gray-100 hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-gray-50 transition-colors duration-150" data-page="recent-page">
                    <i class="fas fa-history w-5 h-5 text-center text-amber-500"></i> {{-- Mengganti fa-clock dengan fa-history --}}
                    <span class="text-sm font-medium">Aktivitas</span>
                </a>
            </li>
            <li>
                <a href="#" class="sidebar-menu flex items-center space-x-3 px-3 py-2.5 rounded-lg text-gray-700 hover:bg-gray-100 hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-gray-50 transition-colors duration-150" data-page="submission-page">
                    <i class="fas fa-star w-5 h-5 text-center text-purple-500"></i>
                    <span class="text-sm font-medium">Pengajuan Surat</span>
                </a>
            </li>
             <li>
                <a href="{{ route('archive.trash') }}" class="sidebar-menu flex items-center space-x-3 px-3 py-2.5 rounded-lg text-gray-700 hover:bg-gray-100 hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-gray-50 transition-colors duration-150" data-page="trash-page">
                    <i class="fas fa-trash-alt w-5 h-5 text-center text-red-500"></i> {{-- Mengganti fa-trash dengan fa-trash-alt --}}
                    <span class="text-sm font-medium">Sampah</span>
                </a>
            </li>
            <li>
                <a href="#" class="sidebar-menu flex items-center space-x-3 px-3 py-2.5 rounded-lg text-gray-700 hover:bg-gray-100 hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-gray-50 transition-colors duration-150" data-page="register-page"> {{-- Pastikan route('archive.trash') di atas tidak salah peruntukan untuk 'Daftar Karyawan' --}}
                    <i class="fas fa-user-plus w-5 h-5 text-center text-teal-500"></i>
                    <span class="text-sm font-medium">Daftar Karyawan</span>
                </a>
            </li>
           <li>
    <a href="#" class="sidebar-menu flex items-center space-x-3 px-3 py-2.5 rounded-lg text-gray-700 hover:bg-gray-100 hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-gray-50 transition-colors duration-150" data-page="user-page">
        {{-- Ikon diganti menjadi 'fas fa-users' untuk "Semua Akun" --}}
        <i class="fas fa-users w-5 h-5 text-center text-teal-500"></i>
        <span class="text-sm font-medium">Semua Akun</span>
    </a>
</li>
        </ul>
    </nav>

    <div id="bulk-actions-section" class="pt-4 border-t border-gray-200 space-y-4">
        <h4 class="px-2 text-xs font-semibold text-gray-500 uppercase tracking-wider">Aksi Massal</h4>

        <div class="bg-purple-50 rounded-lg p-4 shadow-sm">
            <form method="POST" action="{{ route('folders.bulk.rename') }}">
                @csrf
                @isset($folderPath)
                <input type="hidden" name="folderPath" value="{{ $folderPath }}">
                @endisset
                <div class="space-y-2">
                    <label for="bulk-renames" class="sr-only">Data untuk rename massal</label>
                    <textarea id="bulk-renames" name="renames" rows="5" placeholder="path_lama_1➡️nama_baru_1&#10;path_lama_2➡️nama_baru_2" class="w-full text-xs border-purple-200 bg-white p-2.5 rounded-md shadow-inner focus:ring-1 focus:ring-purple-400 focus:border-purple-400 transition-colors"></textarea>
                    <button type="submit" class="w-full bg-purple-600 hover:bg-purple-700 text-white px-3 py-2 rounded-md text-xs font-semibold flex items-center justify-center shadow-md hover:shadow-lg transition-all duration-150">
                        <i class="fas fa-pencil-alt mr-1.5 text-xs"></i> Ganti Nama Terpilih
                    </button>
                </div>
            </form>
        </div>

        <div class="bg-red-50 rounded-lg p-4 shadow-sm">
            <form method="POST" action="{{ route('folders.bulk.delete') }}">
                @csrf
                @method('DELETE')
                <div class="space-y-2">
                    <label for="bulk-delete" class="sr-only">Data untuk hapus massal</label>
                    <textarea id="bulk-delete" name="bulk-delete" rows="3" placeholder="path/untuk/dihapus1&#10;path/untuk/dihapus2" class="w-full text-xs border-red-200 bg-white p-2.5 rounded-md shadow-inner focus:ring-1 focus:ring-red-400 focus:border-red-400 transition-colors"></textarea>
                    <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white px-3 py-2 rounded-md text-xs font-semibold flex items-center justify-center shadow-md hover:shadow-lg transition-all duration-150">
                        <i class="fas fa-trash-alt mr-1.5 text-xs"></i> Hapus Terpilih
                    </button>
                </div>
            </form>
        </div>
    </div>
</aside>

<style>
    /* Gaya untuk scrollbar kustom jika diperlukan (opsional) */
    .custom-scrollbar::-webkit-scrollbar {
        width: 6px;
    }
    .custom-scrollbar::-webkit-scrollbar-track {
        background: transparent;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: #cbd5e1; /* gray-300 */
        border-radius: 3px;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover {
        background: #94a3b8; /* gray-500 */
    }

    /* Gaya untuk menu aktif (contoh, biasanya ditambahkan oleh JavaScript) */
    .sidebar-menu.sidebar-menu-active {
        /* Kelas sudah diterapkan di HTML untuk contoh Beranda */
        /* background-color: #e0e7ff; /* indigo-100 atau bg-indigo-50 */
        /* color: #4338ca; /* indigo-700 */
        /* font-weight: 600; /* semibold */
    }
    .sidebar-menu.sidebar-menu-active i {
        /* color: #4f46e5; /* indigo-600 */
    }
</style>