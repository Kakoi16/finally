<<<<<<< HEAD
<div class="mt-6 bg-white rounded-xl shadow-lg border border-slate-200 overflow-hidden">
    <div class="px-6 py-5 border-b border-slate-200 bg-white">
        <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4">
            <div>
                <h2 class="text-xl font-semibold text-slate-800">File Explorer</h2>
                <p class="text-sm text-slate-500 mt-1">Jelajahi dan kelola file Anda.</p>
            </div>
            <div class="relative w-full md:w-72">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
                <input type="text" id="file-search-input" placeholder="Cari file atau folder..."
                       class="block w-full pl-10 pr-3 py-2.5 border border-slate-300 rounded-lg text-sm placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 bg-white transition-colors duration-150">
=======
<!-- Files aaTable -->
<div class="mt-6 bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <!-- Header with search -->
    <div class="px-6 py-4 border-b border-gray-100 bg-white">
        <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4">
            <div>
                <h2 class="text-xl font-semibold text-gray-800">File Explorer</h2>
                <p class="text-sm text-gray-500 mt-1">Browse and manage your files</p>
            </div>
            <div class="relative w-full md:w-72">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
                <input type="text" placeholder="Search files..." class="block w-full pl-10 pr-3 py-2 border border-gray-200 rounded-lg text-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-100 focus:border-blue-300 bg-white transition">
>>>>>>> 365f2682a4a0ba76b17f51277b96827dd8b5a819
            </div>
        </div>
    </div>

<<<<<<< HEAD
    <div id="bulk-actions" class="hidden px-6 py-3 bg-indigo-50 border-b border-indigo-200">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <span id="selected-count" class="text-sm font-medium text-indigo-700">0 item terpilih</span>
                <button class="text-sm text-indigo-600 hover:text-indigo-800 font-semibold p-1.5 rounded-md hover:bg-indigo-100 transition-colors duration-150 flex items-center">
                    <svg class="w-4 h-4 mr-1.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" />
                    </svg>
                    Unduh
                </button>
                <button class="text-sm text-red-600 hover:text-red-800 font-semibold p-1.5 rounded-md hover:bg-red-100 transition-colors duration-150 flex items-center">
                    <svg class="w-4 h-4 mr-1.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12.56 0c1.153 0 2.24.095 3.23.261m-3.23-.261L3.375 6M17.25 9v-2.25A2.25 2.25 0 0015 4.5H9A2.25 2.25 0 006.75 6.75V9" />
                    </svg>
                    Hapus
                </button>
            </div>
            <button id="clear-selection" class="text-sm text-slate-500 hover:text-slate-700 font-medium p-1.5 rounded-md hover:bg-slate-100 transition-colors duration-150">
                Bersihkan
=======
    <!-- Bulk actions toolbar (hidden by default) -->
    <div id="bulk-actions" class="hidden px-6 py-3 bg-blue-50 border-b border-blue-100">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <span id="selected-count" class="text-sm font-medium text-gray-700">0 items selected</span>
                <button class="text-sm text-blue-600 hover:text-blue-800 font-medium">Download</button>
                <button class="text-sm text-red-600 hover:text-red-800 font-medium">Delete</button>
            </div>
            <button id="clear-selection" class="text-sm text-gray-500 hover:text-gray-700">
                Clear
>>>>>>> 365f2682a4a0ba76b17f51277b96827dd8b5a819
            </button>
        </div>
    </div>

<<<<<<< HEAD
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-slate-200">
            <thead class="bg-slate-50">
                <tr>
                    <th scope="col" class="px-6 py-3.5 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider w-12">
                        <label for="select-all" class="sr-only">Pilih semua</label>
                        <input type="checkbox" id="select-all" class="rounded text-indigo-600 border-slate-300 focus:ring-indigo-500 shadow-sm">
                    </th>
                    <th scope="col" class="px-6 py-3.5 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Nama</th>
                    <th scope="col" class="px-6 py-3.5 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider w-36">Ukuran</th>
                    <th scope="col" class="px-6 py-3.5 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider w-48">Dimodifikasi</th>
                    <th scope="col" class="px-6 py-3.5 text-right text-xs font-semibold text-slate-500 uppercase tracking-wider w-44">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-slate-200">
                @forelse($files as $file)
                    @php
                        // Asumsi $file adalah stdClass object dari DB::table() atau Eloquent model
                        $fileId = $file->id;
                        $fileType = $file->type; // Ini adalah MIME type, e.g., 'application/pdf', 'folder'
                        $filePath = $file->path;
                        $fileName = $file->name;
                        // Ekstensi untuk ikon dan logika tombol edit, diambil dari nama file
                        $fileExtensionForIcon = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
                    @endphp

                    @continue(isset($file->is_deleted) && $file->is_deleted == 1)
                    <tr class="hover:bg-slate-50/70 transition-colors duration-150 file-row" data-id="{{ $filePath }}" data-type="{{ $fileType }}" data-name="{{ $fileName }}">
                        <td class="px-6 py-3 whitespace-nowrap">
                            <label for="item-{{ str_replace('/', '-', $filePath) }}" class="sr-only">Pilih {{ $fileName }}</label>
                            <input type="checkbox" id="item-{{ str_replace('/', '-', $filePath) }}" name="selected_items[]" value="{{ $filePath }}" class="item-checkbox rounded text-indigo-600 border-slate-300 focus:ring-indigo-500 shadow-sm">
                        </td>
                        <td class="px-6 py-3 whitespace-nowrap max-w-sm xl:max-w-md">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 w-10 h-10 flex items-center justify-center rounded-lg mr-3.5
                                    @if($fileType === 'folder') bg-amber-100 border border-amber-200 @else bg-slate-100 border border-slate-200 @endif">
                                    @if($fileType === 'folder')
                                        <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" stroke-width="1.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12.75V12A2.25 2.25 0 014.5 9.75h15A2.25 2.25 0 0121.75 12v.75m-8.69-6.44l-2.12-2.12a1.5 1.5 0 00-1.061-.44H4.5A2.25 2.25 0 002.25 6v12a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9a2.25 2.25 0 00-2.25-2.25h-5.379a1.5 1.5 0 01-1.06-.44z" />
                                        </svg>
                                    @else
                                        @php
                                        $iconColor = 'text-slate-500'; // Default
                                        $iconPath = 'M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H6.938c-.75 0-1.031.75-.625 1.313l2.75 4.125c.406.625.031 1.313-.625 1.313H4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z'; // DocumentTextIcon

                                        switch($fileExtensionForIcon) {
                                            case 'pdf': $iconColor = 'text-red-500'; break;
                                            case 'doc': case 'docx': $iconColor = 'text-blue-500'; break;
                                            case 'xls': case 'xlsx': $iconColor = 'text-green-500'; break;
                                            case 'ppt': case 'pptx': $iconColor = 'text-orange-500'; break;
                                            case 'jpg': case 'jpeg': case 'png': case 'gif': case 'svg': $iconColor = 'text-purple-500'; $iconPath = 'M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.65-1.65l1.65-1.65a2.25 2.25 0 013.182 0l3.086 3.086m-6.75-6.75l2.25-2.25a2.25 2.25 0 00-3.182 0l-2.25 2.25a2.25 2.25 0 003.182 0zM4.5 5.625a3.375 3.375 0 116.75 0 3.375 3.375 0 01-6.75 0z'; break; // PhotoIcon
                                            case 'zip': case 'rar': $iconColor = 'text-gray-500'; $iconPath = 'M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10.5 18.75h3M10.5 12h3m2.25-3V4.875c0-.621-.504-1.125-1.125-1.125H9.375c-.621 0-1.125.504-1.125 1.125V9M15 9V4.5M9 9V4.5m6 4.5v1.875a.375.375 0 01-.375.375H9.375a.375.375 0 01-.375-.375V9m6-4.5h-1.5m-3 0h-1.5m-3 0H6M13.5 9H12v1.5h1.5V9zm-3 0H9v1.5h1.5V9z'; break; // ArchiveBoxIcon
                                        }
                                        @endphp
                                        <svg class="w-5 h-5 {{ $iconColor }}" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" stroke-width="1.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="{{ $iconPath }}" />
                                        </svg>
                                    @endif
                                </div>
                                <div class="min-w-0">
                                    <a href="{{ $fileType === 'folder' ? route('folders.showAny', ['any' => $filePath]) : ($fileType === 'application/pdf' ? route('archives.showPdfPage', ['archive' => $fileId]) : '#') }}"
                                       class="text-sm font-medium text-slate-800 hover:text-indigo-600 hover:underline truncate block transition-colors duration-150"
                                       title="{{ $fileName }}"
                                       @if($fileType === 'application/pdf') target="_blank" @endif >
                                        {{ $fileName }}
                                    </a>
                                    @if($fileType !== 'folder')
                                        <span class="text-xs text-slate-500 uppercase">{{ $fileExtensionForIcon }} File</span>
                                    @else
                                        <span class="text-xs text-slate-500">Folder</span>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-3 whitespace-nowrap text-sm text-slate-600">
                            {{-- Format ukuran file jika ada, jika tidak, '--' --}}
                            {{ isset($file->size) ? (is_numeric($file->size) ? round($file->size / 1024, 2) . ' KB' : $file->size) : '--' }}
                        </td>
                        <td class="px-6 py-3 whitespace-nowrap text-sm text-slate-600">
                             {{-- Menggunakan updated_at atau created_at jika 'modified' tidak ada --}}
                            {{ isset($file->updated_at) ? \Carbon\Carbon::parse($file->updated_at)->translatedFormat('d M Y, H:i') : (isset($file->created_at) ? \Carbon\Carbon::parse($file->created_at)->translatedFormat('d M Y, H:i') : (isset($file->modified) ? \Carbon\Carbon::parse($file->modified)->translatedFormat('d M Y, H:i') : '--')) }}
                        </td>
                        <td class="px-6 py-3 whitespace-nowrap text-right text-sm font-medium">
                            <div class="flex justify-end items-center space-x-1">
                                @if($fileType === 'folder')
                                    <a href="{{ route('folders.showAny', ['any' => $filePath]) }}" class="p-1.5 rounded-md text-slate-500 hover:bg-indigo-100 hover:text-indigo-600 transition-colors duration-150" title="Buka Folder">
                                        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12.75 15l3-3m0 0l-3-3m3 3h-7.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </a>
                                @else
                                    {{-- Tombol Lihat/View PDF (Ikon Mata) --}}
                                    @if($fileType === 'application/pdf')
                                        <a href="{{ route('archives.showPdfPage', ['archive' => $fileId]) }}" target="_blank" class="p-1.5 rounded-md text-slate-500 hover:bg-green-100 hover:text-green-600 transition-colors duration-150" title="Lihat File PDF">
                                            <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            </svg>
                                        </a>
                                    @else
                                        {{-- Placeholder agar spacing konsisten jika tidak ada tombol lihat --}}
                                        {{-- <span class="p-1.5 w-8 h-8 block"></span> --}}
                                    @endif
                                @endif

                                {{-- Tombol Unduh --}}
                                @if($fileType !== 'folder') {{-- Folder diunduh melalui rute yang berbeda, dan mungkin tidak selalu ada tombol unduh individual folder di sini --}}
                                <a href="{{ route('download.file', ['filePath' => urlencode(base64_encode($filePath))]) }}" class="p-1.5 rounded-md text-slate-500 hover:bg-slate-200 hover:text-slate-700 transition-colors duration-150" title="Unduh File">
                                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" />
                                    </svg>
                                </a>
                                @else {{-- Untuk folder, tombol unduh bisa merujuk ke download.folder --}}
                                 <a href="{{ route('download.folder', ['folderPath' => urlencode(base64_encode($filePath))]) }}" class="p-1.5 rounded-md text-slate-500 hover:bg-slate-200 hover:text-slate-700 transition-colors duration-150" title="Unduh Folder">
                                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" />
                                    </svg>
                                </a>
                                @endif


                                {{-- Tombol Edit Template --}}
                                @if($fileType !== 'folder' && in_array($fileExtensionForIcon, ['doc', 'docx', 'xls', 'xlsx', 'pptx']))
                                    <a href="{{ route('template.edit', ['encodedPath' => urlencode(base64_encode($filePath))]) }}" target="_blank" class="p-1.5 rounded-md text-slate-500 hover:bg-purple-100 hover:text-purple-600 transition-colors duration-150" title="Edit Template">
                                        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                        </svg>
                                    </a>
                                @endif
                                {{-- Tombol Hapus Individual (opsional) --}}
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="py-16 text-center">
                            <div class="inline-flex flex-col items-center">
                                <svg class="mx-auto h-16 w-16 text-slate-300" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12.75V12A2.25 2.25 0 014.5 9.75h15A2.25 2.25 0 0121.75 12v.75m-8.69-6.44l-2.12-2.12a1.5 1.5 0 00-1.061-.44H4.5A2.25 2.25 0 002.25 6v12a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9a2.25 2.25 0 00-2.25-2.25h-5.379a1.5 1.5 0 01-1.06-.44z" />
                                </svg>
                                <h3 class="mt-3 text-md font-semibold text-slate-700">Tidak ada file atau folder</h3>
                                <p class="mt-1 text-sm text-slate-500">Unggah atau buat file/folder pertama Anda.</p>
                                <div class="mt-6">
                                    {{-- Tombol ini bisa memicu modal upload atau navigasi ke halaman buat file --}}
                                    <button type="button"
                                            class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-lg text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-150">
                                        <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                                        </svg>
                                        Buat Baru
                                    </button>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<script>
// Script Anda yang sudah ada (untuk bulk actions, search, dll.)
// Pastikan bagian JavaScript ini tidak bentrok dan berfungsi sesuai harapan.
// Jika ada textarea dengan ID 'bulk-renames' atau 'bulk-delete', pastikan elemen tersebut ada di DOM atau
// JavaScript Anda menangani kasus di mana elemen tersebut tidak ditemukan (misalnya, dengan if (textarea)).

document.addEventListener('DOMContentLoaded', function () {
    const checkboxes = document.querySelectorAll('.item-checkbox');
    const textarea = document.getElementById('bulk-renames'); // Pastikan elemen ini ada, atau tambahkan pengecekan

    if (textarea) { // Tambahkan pengecekan
        checkboxes.forEach(checkbox => {
            checkbox.addEventListener('change', updateRenameTextarea);
        });
    }


    function updateRenameTextarea() {
        if (!textarea) return; // Keluar jika textarea tidak ada
        let lines = [];
        checkboxes.forEach(cb => {
            if (cb.checked) {
                const row = cb.closest('tr');
                const oldPath = cb.value;
                const currentName = row?.dataset.name;

                if (oldPath && currentName) {
                    lines.push(`${oldPath}➡️${currentName}`);
                }
            }
        });
        textarea.value = lines.join('\n');
    }

    const selectAll = document.getElementById('select-all');
    if (selectAll) {
        selectAll.addEventListener('change', () => {
            checkboxes.forEach(cb => cb.checked = selectAll.checked);
            if (textarea) { // Panggil hanya jika textarea ada
                 updateRenameTextarea();
            }
        });
    }
    if (textarea && selectAll && selectAll.checked) { // Inisialisasi jika selectAll sudah tercentang
        updateRenameTextarea();
    }
});

document.addEventListener('DOMContentLoaded', function () {
    const checkboxes = document.querySelectorAll('.item-checkbox');
    const textareaDelete = document.getElementById('bulk-delete'); // Pastikan elemen ini ada
    const selectAll = document.getElementById('select-all');

    async function updateDeleteArea() { // jadikan async karena ada await
        if (!textareaDelete) return; // Keluar jika textareaDelete tidak ada

        let paths = [];

        const fetchFolderContents = async (path) => {
            let allPaths = [];
            const fetchRecursive = async (prefix) => {
                try {
                    // Pastikan URL API ini benar dan mengembalikan JSON yang diharapkan
                    const response = await fetch(`/api/folder-contents?prefix=${encodeURIComponent(prefix)}`);
                    if (!response.ok) {
                        console.error('Gagal mengambil isi folder:', response.status, await response.text());
                        return;
                    }
                    const data = await response.json();
                    const currentPaths = data.paths || [];

                    for (const p of currentPaths) {
                        allPaths.push(p);
                        if (p.endsWith('/')) { // Cek folder berdasarkan trailing slash
                            await fetchRecursive(p);
                        }
                    }
                } catch (error) {
                    console.error('Error saat mengambil isi folder:', error);
                }
            };
            // Pastikan path folder memiliki trailing slash untuk konsistensi
            await fetchRecursive(path.endsWith('/') ? path : path + '/');
            return allPaths;
        };

        for (const cb of checkboxes) { // Ganti nama variabel agar tidak konflik
=======
    <!-- Files table -->
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-10">
                        <input type="checkbox" id="select-all" class="rounded text-blue-600 border-gray-300 focus:ring-blue-500">
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-32">Size</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-48">Modified</th>
                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider w-40">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($files as $file)
                <tr class="hover:bg-gray-50 transition-colors" data-id="{{ $file['path'] }}" data-type="{{ $file['type'] }}" data-name="{{ $file['name'] }}">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <input type="checkbox" name="selected_items[]" value="{{ $file['path'] }}" class="item-checkbox rounded text-blue-600 border-gray-300 focus:ring-blue-500">
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            @if($file['type'] === 'folder')
                            <!-- Folder Icon -->
                            <div class="flex-shrink-0 bg-yellow-50 p-2 rounded-lg mr-3 border border-yellow-100">
                                <svg class="w-5 h-5 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" />
                                </svg>
                            </div>
                            @else
                            <!-- File Icon with different types -->
                            @php
                            $fileExtension = pathinfo($file['name'], PATHINFO_EXTENSION);
                            $iconColor = 'text-gray-400';
                            $iconPath = '';

                            switch(strtolower($fileExtension)) {
                                case 'pdf':
                                    $iconColor = 'text-red-500';
                                    $iconPath = 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z';
                                    break;
                                case 'doc':
                                case 'docx':
                                    $iconColor = 'text-blue-500';
                                    $iconPath = 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z';
                                    break;
                                case 'xls':
                                case 'xlsx':
                                    $iconColor = 'text-green-500';
                                    $iconPath = 'M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z';
                                    break;
                                case 'jpg':
                                case 'jpeg':
                                case 'png':
                                case 'gif':
                                    $iconColor = 'text-purple-500';
                                    $iconPath = 'M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z';
                                    break;
                                default:
                                    $iconPath = 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z';
                            }
                            @endphp
                            <div class="flex-shrink-0 bg-gray-50 p-2 rounded-lg mr-3 border border-gray-100">
                                <svg class="w-5 h-5 {{ $iconColor }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="{{ $iconPath }}" />
                                </svg>
                            </div>
                            @endif
                            <div class="min-w-0">
                                <span class="text-sm font-medium text-gray-900 truncate block max-w-xs">{{ $file['name'] }}</span>
                                @if($file['type'] !== 'folder')
                                <span class="text-xs text-gray-500">{{ strtoupper($fileExtension) }}</span>
                                @endif
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        {{ $file['size'] ?? '--' }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        {{ $file['modified'] ?? '--' }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <div class="flex justify-end space-x-2">
                            @if($file['type'] === 'folder')
                            <a href="{{ route('folders.showAny', ['any' => $file['path']]) }}"
                                class="text-gray-500 hover:text-blue-600 p-2 rounded-md hover:bg-blue-50 transition-colors"
                                title="Open">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 19a2 2 0 01-2-2V7a2 2 0 012-2h4l2 2h4a2 2 0 012 2v1M5 19h14a2 2 0 002-2v-5a2 2 0 00-2-2H9a2 2 0 00-2 2v5a2 2 0 01-2 2z" />
                                </svg>
                            </a>
                            @else
                            <a href="#" class="text-gray-500 hover:text-blue-600 p-2 rounded-md hover:bg-blue-50 transition-colors" title="View">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </a>
                            @endif
                          @if(isset($file['type']))
    @if($file['type'] === 'folder')
        <a href="{{ route('download.folder', ['folderPath' => urlencode(base64_encode($file['path']))]) }}" class="text-gray-600 hover:text-gray-800" title="Download Folder">
            <!-- Icon for folder download -->
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
            </svg>
        </a>
    @else
        <a href="{{ route('download.file', ['filePath' => urlencode(base64_encode($file['path']))]) }}" class="text-gray-600 hover:text-gray-800" title="Download File">
            <!-- Icon for file download -->
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
        </a>
    @endif
@endif

                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Empty state -->
    @if(count($files) === 0)
    <div class="py-12 text-center">
        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 13h6m-3-3v6m-9 1V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z" />
        </svg>
        <h3 class="mt-2 text-sm font-medium text-gray-900">No files</h3>
        <p class="mt-1 text-sm text-gray-500">Upload or create your first file.</p>
        <div class="mt-6">
            <button type="button" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
                New File
            </button>
        </div>
    </div>
    @endif
</div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const checkboxes = document.querySelectorAll('.item-checkbox');
        const textarea = document.getElementById('bulk-renames');

        checkboxes.forEach(checkbox => {
            checkbox.addEventListener('change', updateRenameTextarea);
        });

        function updateRenameTextarea() {
    let lines = [];

    checkboxes.forEach(cb => {
        if (cb.checked) {
            const row = cb.closest('tr');
            const oldPath = cb.value;
            const currentName = row?.dataset.name;

            if (oldPath && currentName) {
                lines.push(`${oldPath}➡️${currentName}`);
            }
        }
    });

    textarea.value = lines.join('\n');
}


        // opsional pada cekbox
        const selectAll = document.getElementById('select-all');
        if (selectAll) {
            selectAll.addEventListener('change', () => {
                checkboxes.forEach(cb => cb.checked = selectAll.checked);
                updateRenameTextarea();
            });
        }
    });
    document.addEventListener('DOMContentLoaded', function () {
    const checkboxes = document.querySelectorAll('.item-checkbox');
    const textareaDelete = document.getElementById('bulk-delete');
    const selectAll = document.getElementById('select-all');

    function updateDeleteArea() {
    let paths = [];

    const fetchFolderContents = async (path) => {
    let allPaths = [];

    const fetchRecursive = async (prefix) => {
        try {
            const response = await fetch(`/api/folder-contents?prefix=${encodeURIComponent(prefix)}`);
            const data = await response.json();
            const paths = data.paths || [];

            for (const p of paths) {
                allPaths.push(p);

                // Cek apakah path ini adalah folder (dengan trailing slash)
                if (p.endsWith('/')) {
                    await fetchRecursive(p);
                }
            }
        } catch (error) {
            console.error('Gagal mengambil isi folder:', error);
        }
    };

    await fetchRecursive(path + '/'); // pastikan ada trailing slash
    return allPaths;
};


    const processCheckboxes = async () => {
        for (const cb of checkboxes) {
>>>>>>> 365f2682a4a0ba76b17f51277b96827dd8b5a819
            if (cb.checked) {
                const itemPath = cb.value;
                const itemType = cb.closest('tr').dataset.type;

<<<<<<< HEAD
                paths.push(itemPath);

=======
                paths.push(itemPath); // selalu tambahkan path utama

                // jika folder, fetch isinya
>>>>>>> 365f2682a4a0ba76b17f51277b96827dd8b5a819
                if (itemType === 'folder') {
                    const contents = await fetchFolderContents(itemPath);
                    paths.push(...contents);
                }
            }
        }
<<<<<<< HEAD
        // Hilangkan duplikat jika ada
        textareaDelete.value = [...new Set(paths)].join('\n');
    }


    if (textareaDelete) { // Tambahkan pengecekan
        checkboxes.forEach(cb => {
            cb.addEventListener('change', updateDeleteArea);
        });

        if (selectAll) {
            selectAll.addEventListener('change', () => {
                checkboxes.forEach(cb => cb.checked = selectAll.checked);
                updateDeleteArea();
            });
        }
        // Panggil saat pertama kali jika ada pre-checked
        updateDeleteArea();
    }
});

document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('file-search-input');
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            const filter = searchInput.value.toLowerCase();
            const rows = document.querySelectorAll('.file-row');
            rows.forEach(row => {
                const name = row.dataset.name ? row.dataset.name.toLowerCase() : '';
                if (name.includes(filter)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    }
});
</script>
=======

        if (textareaDelete) {
            textareaDelete.value = paths.join('\n');
        }
    };

    processCheckboxes();
}

    // checkbox maasing-masing
    checkboxes.forEach(cb => {
        cb.addEventListener('change', updateDeleteArea);
    });

    // checkbox "select all"
    if (selectAll) {
        selectAll.addEventListener('change', () => {
            checkboxes.forEach(cb => cb.checked = selectAll.checked);
            updateDeleteArea();
        });
    }

    // Panggil saat pertama kali jika ada pre-checked
    updateDeleteArea();
});
</script>
>>>>>>> 365f2682a4a0ba76b17f51277b96827dd8b5a819
