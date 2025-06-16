<<<<<<< HEAD
<aside id="action-cards" class="md:w-72 bg-white p-4 rounded-xl shadow-lg border border-slate-200 md:mr-4 space-y-6">

    {{-- Judul Utama Panel Aksi --}}
    <div class="flex items-center pb-3 border-b border-slate-200">
        <div class="bg-indigo-100 p-2.5 rounded-lg border border-indigo-200 shadow-sm">
            <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" stroke-width="1.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12.75V12A2.25 2.25 0 014.5 9.75h15A2.25 2.25 0 0121.75 12v.75m-8.69-6.44l-2.12-2.12a1.5 1.5 0 00-1.061-.44H4.5A2.25 2.25 0 002.25 6v12a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9a2.25 2.25 0 00-2.25-2.25h-5.379a1.5 1.5 0 01-1.06-.44z"></path>
            </svg>
        </div>
        <span class="ml-3 text-lg font-semibold text-slate-700">Aksi Folder</span>
    </div>

    <div class="space-y-5 custom-scrollbar overflow-y-auto max-h-[calc(100vh-12rem)] pr-1"> {{-- Sesuaikan max-h --}}
        <div class="bg-blue-50 p-4 rounded-xl border border-blue-200 shadow-md transition-all hover:shadow-lg">
            <h3 class="text-md font-semibold text-blue-800 mb-3.5 flex items-center">
                <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 10v6m3-3h-6m2-5.657a4.5 4.5 0 100 9.314a4.5 4.5 0 000-9.314z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.5A5.5 5.5 0 006.5 12a5.5 5.5 0 005.5 5.5A5.5 5.5 0 0017.5 12 5.5 5.5 0 0012 6.5z" />
                </svg>
                Buat Subfolder
=======
<!-- Action Caards -->
<aside id="action-cards" class="md:w-64 bg-white p-3 rounded-lg shadow-sm border border-gray-100 md:mr-4">

    <div class="flex items-center mb-8">
        <a href="/archive" class="flex items-center group">
            <div class="bg-yellow-50 p-2 rounded-lg group-hover:bg-yellow-100 transition-colors border border-yellow-100">
                <svg class="w-6 h-6 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" />
                </svg>
            </div>
            <span class="ml-3 font-semibold text-gray-700 group-hover:text-gray-900 transition-colors">Folder Actions</span>
        </a>
    </div>

    <div class="space-y-5">
        <!-- Create Subfolder Card -->
        <div class="bg-blue-50/50 p-4 rounded-lg border border-blue-100">
            <h3 class="text-sm font-semibold text-blue-800 mb-3 flex items-center">
                <svg class="w-4 h-4 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
                Create Subfolder
>>>>>>> 365f2682a4a0ba76b17f51277b96827dd8b5a819
            </h3>
            <form method="POST" action="{{ route('folders.subfolder.create', ['path' => $folderPath]) }}" class="space-y-3">
                @csrf
                <div>
<<<<<<< HEAD
                    <label for="subfolder_name" class="sr-only">Nama Subfolder</label>
                    <input type="text" name="folder_name" id="subfolder_name" placeholder="Nama subfolder baru"
                           class="text-sm border-blue-300 bg-white p-2.5 rounded-lg w-full shadow-inner focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-150 placeholder-slate-400">
                </div>
                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-all duration-150 text-sm font-medium flex items-center justify-center shadow-md hover:shadow-lg">
                    <svg class="w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                    Buat
=======
                    <input type="text" name="folder_name" placeholder="Enter subfolder name"
                        class="text-sm border border-blue-200 bg-white p-2.5 rounded-lg w-full focus:outline-none focus:ring-2 focus:ring-blue-200 focus:border-blue-300 transition">
                </div>
                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-2.5 rounded-lg transition duration-200 text-sm font-medium flex items-center justify-center shadow-sm">
                    Create Subfolder
>>>>>>> 365f2682a4a0ba76b17f51277b96827dd8b5a819
                </button>
            </form>
        </div>

<<<<<<< HEAD
        <div class="bg-emerald-50 p-4 rounded-xl border border-emerald-200 shadow-md transition-all hover:shadow-lg">
            <h3 class="text-md font-semibold text-emerald-800 mb-3.5 flex items-center">
                <svg class="w-5 h-5 mr-2 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 16.5V9.75m0 0l3 3m-3-3l-3 3M6.75 19.5a4.5 4.5 0 01-1.41-8.775 5.25 5.25 0 0110.338 0 4.5 4.5 0 01-1.41 8.775H6.75z" />
                </svg>
                Unggah File
            </h3>
            <form method="POST" action="{{ route('files.uploadToFolder', $currentFolder ?? '') }}" enctype="multipart/form-data" class="space-y-3">
                @csrf
                <div class="relative group">
                    <label for="fileInput" class="sr-only">Pilih file</label>
                    <input id="fileInput" type="file" name="file" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10" onchange="updateFileName(this)">
                    <div id="fileLabel" class="flex items-center justify-between p-2.5 border border-emerald-300 bg-white rounded-lg text-sm text-slate-500 group-hover:border-emerald-400 transition-colors duration-150 cursor-pointer shadow-inner">
                        <span class="truncate block">Pilih file untuk diunggah</span>
                        <svg class="w-5 h-5 text-emerald-500 flex-shrink-0 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                             <path stroke-linecap="round" stroke-linejoin="round" d="M12 16.5V9.75m0 0l3 3m-3-3l-3 3M6.75 19.5a4.5 4.5 0 01-1.41-8.775 5.25 5.25 0 0110.338 0 4.5 4.5 0 01-1.41 8.775H6.75z" />
                        </svg>
                    </div>
                </div>
                <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2 rounded-lg transition-all duration-150 text-sm font-medium flex items-center justify-center shadow-md hover:shadow-lg">
                    <svg class="w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                    </svg>
                    Unggah
=======
        <!-- Upload File Card -->
        <div class="bg-emerald-50/50 p-4 rounded-lg border border-emerald-100">
            <h3 class="text-sm font-semibold text-emerald-800 mb-3 flex items-center">
                <svg class="w-4 h-4 mr-2 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                </svg>
                Upload File
            </h3>
            <form method="POST" action="{{ route('files.uploadToFolder', $currentFolder) }}" enctype="multipart/form-data" class="space-y-3">

                @csrf
                <div class="relative">
                    <input id="fileInput" type="file" name="file" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" onchange="updateFileName(this)">
                    <div id="fileLabel" class="flex items-center justify-between p-2.5 border border-emerald-200 bg-white rounded-lg text-sm text-gray-500">
                        <span class="truncate">Pilih file untuk diunggah</span>
                        <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                        </svg>
                    </div>
                </div>

                <button type="submit" class="w-full bg-emerald-600 bg-blue-600 text-white rounded px-4 py-2.5 rounded-lg transition duration-200 text-sm font-medium flex items-center justify-center shadow-sm">
                    Upload File
>>>>>>> 365f2682a4a0ba76b17f51277b96827dd8b5a819
                </button>
            </form>
        </div>

<<<<<<< HEAD
        <div class="bg-purple-50 p-4 rounded-xl border border-purple-200 shadow-md transition-all hover:shadow-lg">
            <h3 class="text-md font-semibold text-purple-800 mb-3.5 flex items-center">
                 <svg class="w-5 h-5 mr-2 text-purple-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 4.5v15m6-15v15m-10.875 0h15.75c.621 0 1.125-.504 1.125-1.125V5.625c0-.621-.504-1.125-1.125-1.125H4.125C3.504 4.5 3 5.004 3 5.625v12.75c0 .621.504 1.125 1.125 1.125H9z" />
                </svg>
                Aksi Massal
            </h3>
            <div class="space-y-4">
                <form method="POST" action="{{ route('folders.bulk.rename') }}">
                    @csrf
                    @isset($folderPath)
                    <input type="hidden" name="folderPath" value="{{ $folderPath }}">
                    @endisset
                    <div class="space-y-2">
                        <label for="bulk-renames" class="sr-only">Data untuk ganti nama massal</label>
                        <textarea id="bulk-renames" name="renames" rows="4" placeholder="path_lama_1➡️nama_baru_1&#10;path_lama_2➡️nama_baru_2" class="w-full text-xs border-purple-300 bg-white p-2.5 rounded-lg shadow-inner focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-colors duration-150 placeholder-slate-400"></textarea>
                        <button type="submit" class="w-full bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg text-sm font-medium flex items-center justify-center shadow-md hover:shadow-lg transition-all duration-150">
                            <svg class="w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125" />
                            </svg>
                            Ganti Nama
=======
        <!-- Bulk Actions Card -->
        <div class="bg-purple-50/50 p-4 rounded-lg border border-purple-100">
            <h3 class="text-sm font-semibold text-purple-800 mb-3 flex items-center">
                <svg class="w-4 h-4 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
                Bulk Actions
            </h3>
            <div class="space-y-3">
                <!-- Bulk Rename Form -->
                <form method="POST" action="{{ route('folders.bulk.rename') }}">
                    @csrf
                    <input type="hidden" name="folderPath" value="{{ $folderPath }}">
                    <div class="space-y-2">
                        <textarea id="bulk-renames" name="renames" rows="3" placeholder="old_path_1|new_name_1\nold_path_2|new_name_2" class="w-full text-sm border border-purple-300 p-2 rounded-lg"></textarea>

                        <button type="submit" class="w-full bg-purple-600 hover:bg-purple-700 text-white px-4 py-2.5 rounded-lg text-sm font-medium flex items-center justify-center shadow-sm">
                            Rename Selected
>>>>>>> 365f2682a4a0ba76b17f51277b96827dd8b5a819
                        </button>
                    </div>
                </form>

<<<<<<< HEAD
                <form method="POST" action="{{ route('folders.bulk.delete') }}">
                    @csrf
                    @method('DELETE')
                    <div class="space-y-2">
                        <label for="bulk-delete" class="sr-only">Data untuk hapus massal</label>
                        <textarea id="bulk-delete" name="bulk-delete" rows="4" placeholder="path/untuk/dihapus1&#10;path/untuk/dihapus2" class="w-full text-xs border-red-300 bg-white p-2.5 rounded-lg shadow-inner focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-colors duration-150 placeholder-slate-400"></textarea>
                        <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg text-sm font-medium flex items-center justify-center shadow-md hover:shadow-lg transition-all duration-150">
                            <svg class="w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                               <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12.56 0c1.153 0 2.24.095 3.23.261m-3.23-.261L3.375 6M17.25 9v-2.25A2.25 2.25 0 0015 4.5H9A2.25 2.25 0 006.75 6.75V9" />
                            </svg>
                            Hapus
                        </button>
                    </div>
                </form>
=======
                <!-- Bulk Delete Form -->
                <form method="POST" action="{{ route('folders.bulk.delete') }}">
                    @csrf
                    @method('DELETE')
                    <div class="space-y-2 mt-3">
                    <textarea id="bulk-delete" name="bulk-delete" rows="3" placeholder="path/to/delete1\npath/to/delete2" class="w-full text-sm border border-red-300 p-2 rounded-lg"></textarea>
                    </textarea>
                        <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white px-4 py-2.5 rounded-lg text-sm font-medium flex items-center justify-center shadow-sm">
                            Delete Selected
                        </button>
                    </div>
                </form>

>>>>>>> 365f2682a4a0ba76b17f51277b96827dd8b5a819
            </div>
        </div>
    </div>
</aside>
<script>
    function updateFileName(input) {
<<<<<<< HEAD
        const fileLabelSpan = document.getElementById('fileLabel').querySelector('span');
        if (input.files && input.files.length > 0) {
            fileLabelSpan.textContent = input.files[0].name;
        } else {
            fileLabelSpan.textContent = 'Pilih file untuk diunggah';
        }
    }
</script>
<style>
    /* Gaya untuk scrollbar kustom jika diperlukan (opsional) */
    .custom-scrollbar::-webkit-scrollbar {
        width: 6px;
    }
    .custom-scrollbar::-webkit-scrollbar-track {
        background: transparent; /* Atau bg-slate-100 jika ingin terlihat */
    }
    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: #cbd5e1; /* gray-300 */
        border-radius: 3px;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover {
        background: #94a3b8; /* gray-500 */
    }
</style>
=======
        const fileLabel = document.getElementById('fileLabel').querySelector('span');
        if (input.files.length > 0) {
            fileLabel.textContent = input.files[0].name;
        } else {
            fileLabel.textContent = 'Pilih file untuk diunggah';
        }
    }
    
</script>
>>>>>>> 365f2682a4a0ba76b17f51277b96827dd8b5a819
