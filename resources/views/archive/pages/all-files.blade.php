@php
$files = $allArchives ?? []; // Gunakan $allArchives jika ada, jika tidak, array kosong
$filteredFiles = [];

// Filter file yang berada di root direktori 'uploads/'
// Ini adalah logika yang sama dengan kode asli Anda, hanya dipindahkan ke atas untuk kejelasan
foreach ($files as $file) {
    if (!isset($file->path)) {
        continue;
    }
    // Hapus 'uploads/' dari path untuk mendapatkan path relatif
    $relativePath = str_replace('uploads/', '', $file->path);
    // Hanya tampilkan file yang tidak ada di dalam subfolder (tidak mengandung '/')
    if (strpos($relativePath, '/') === false) {
        $filteredFiles[] = $file;
    }
}
@endphp

<<<<<<< HEAD
{{-- Notifikasi Error --}}
=======

>>>>>>> 365f2682a4a0ba76b17f51277b96827dd8b5a819
@if(session('error'))
<div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-md shadow-sm transform transition-all duration-300 hover:scale-102 hover:shadow-md" role="alert">
    <div class="flex items-center">
        <svg class="w-5 h-5 mr-3 text-red-500" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
        </svg>
        <p class="font-medium">{{ session('error') }}</p>
    </div>
</div>
@endif

<div id="all-files-page" data-log-activity="Lihat Semua File" class="page-content p-4 md:p-6 space-y-6">
    {{-- Header dengan Breadcrumbs dan Tombol Aksi --}}
    <div class="bg-gradient-to-r from-white to-blue-50 p-4 md:p-6 rounded-lg shadow-md border border-gray-200 flex flex-col md:flex-row justify-between items-start md:items-center gap-4 transition-all duration-300 hover:shadow-lg">
        <div class="space-y-1">
            <h1 class="text-2xl font-semibold text-gray-800 flex items-center">
                <span class="mr-2">Arsip File</span>
                <span class="inline-block animate-pulse bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded-full">Aktif</span>
            </h1>
            <nav class="flex" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
                    <li class="inline-flex items-center">
                        <a href="#" class="inline-flex items-center text-sm font-medium text-gray-500 hover:text-blue-600 transition-colors duration-150">
                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path></svg>
                            Beranda
                        </a>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <svg class="rtl:rotate-180 w-3 h-3 text-gray-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                            </svg>
                            @if(isset($currentFolder))
                            <span class="ms-1 text-sm font-semibold text-gray-700 md:ms-2">{{ $currentFolder }}</span>
                            @else
                            <span class="ms-1 text-sm font-semibold text-gray-700 md:ms-2">Semua File</span>
                            @endif
                        </div>
                    </li>
                </ol>
            </nav>
        </div>

        {{-- Tombol Aksi --}}
        <div class="flex flex-wrap items-center gap-3">
            {{-- Tombol Unggah File --}}
            <form action="{{ route('files.upload') }}" method="POST" enctype="multipart/form-data" class="flex items-center">
                @csrf
                <input type="file" name="file" id="file" class="hidden" onchange="this.form.submit()" aria-label="Pilih file untuk diunggah">
                <label for="file" class="cursor-pointer bg-gradient-to-r from-blue-600 to-blue-700 text-white px-4 py-2.5 rounded-lg flex items-center gap-2 transition-all duration-300 shadow-sm hover:shadow-blue-200 hover:translate-y-[-2px]">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                    </svg>
                    <span class="text-sm font-medium">Unggah</span>
                </label>
            </form>

<<<<<<< HEAD
            {{-- Tombol Buat Folder --}}
            <button onclick="toggleCreateFolderForm()" type="button" class="bg-gradient-to-r from-green-600 to-green-700 text-white px-4 py-2.5 rounded-lg flex items-center gap-2 transition-all duration-300 shadow-sm hover:shadow-green-200 hover:translate-y-[-2px]">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 13h6m-3-3v6m-9 1V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z" />
=======
            <!-- Create Folder Button -->
            <button onclick="toggleCreateFolderForm()" type="button" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2.5 rounded-lg flex items-center gap-2 transition-colors shadow-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m-9 1V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z" />
>>>>>>> 365f2682a4a0ba76b17f51277b96827dd8b5a819
                </svg>
                <span class="text-sm font-medium">Folder Baru</span>
            </button>
        </div>
    </div>

    {{-- Form Buat Folder (Tersembunyi Awalnya) --}}
    <div data-log-activity="Membuat Folder" id="create-folder-form" class="bg-white p-6 rounded-lg shadow-md border border-gray-200 hidden animate-fade-in">
        <h2 class="text-xl font-semibold text-gray-800 mb-4 flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 13h6m-3-3v6m-9 1V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z" />
            </svg>
            Buat Folder Baru
        </h2>
        <form action="{{ route('folders.create') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label for="folder_name" class="block text-sm font-medium text-gray-700 mb-1">Nama Folder</label>
                <input type="text" name="folder_name" id="folder_name" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-sm p-2.5" placeholder="Masukkan nama folder" required>
            </div>
            <div class="flex justify-end gap-3 pt-2">
                <button type="button" onclick="toggleCreateFolderForm()" class="px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 transition-colors duration-150 shadow-sm">
                    Batal
                </button>
<<<<<<< HEAD
                <button type="submit" class="px-4 py-2 border border-transparent rounded-lg text-sm font-medium text-white bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 transition-all duration-300 shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Buat Folder
                </button>
=======
                <button 
    type="submit" 
    class="x-4 py-2.5 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 transition-colors shadow-sm"
>
    <span class="text-sm font-medium text-black">Create Folder</span>
</button>
>>>>>>> 365f2682a4a0ba76b17f51277b96827dd8b5a819
            </div>
        </form>
    </div>

    {{-- Tabel Daftar File --}}
    <div class="bg-white p-4 md:p-6 rounded-lg shadow-md border border-gray-200 transition-all duration-300 hover:shadow-lg">
        <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4 mb-6">
            <h2 class="text-xl font-semibold text-gray-800 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                </svg>
                Semua File
            </h2>
            <div class="relative w-full md:w-72">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
                <input type="text" id="search-files" placeholder="Cari file atau folder..." class="block w-full pl-10 pr-3 py-2.5 border border-gray-300 rounded-lg text-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-150" aria-label="Kolom pencarian file">
            </div>
        </div>

<<<<<<< HEAD
        @if(!empty($filteredFiles) && count($filteredFiles) > 0)
        <div class="overflow-x-auto rounded-lg border border-gray-200">
            <table class="min-w-full divide-y divide-gray-200 text-sm">
                <thead class="bg-gradient-to-r from-gray-50 to-blue-50">
                    <tr>
                        <th class="px-4 py-3 w-10 text-center">
                            <input type="checkbox" id="select-all" class="rounded text-blue-600 border-gray-300 focus:ring-blue-500 shadow-sm" aria-label="Pilih semua item">
                        </th>
                        <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Nama</th>
                        <th scope="col" class="px-3 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider hidden md:table-cell">Tanggal Modifikasi</th>
                        <th scope="col" class="px-3 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider hidden lg:table-cell">Ukuran</th>
                        <th scope="col" class="px-4 py-3 text-right text-xs font-medium text-gray-600 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($filteredFiles as $file)
                        @if(!$file->is_deleted)
                            @php
                            $extension = pathinfo($file->name ?? '', PATHINFO_EXTENSION);
                            $encodedPath = urlencode(base64_encode($file->path ?? ''));
                            $isFolder = (isset($file->type) && $file->type === 'folder');
                            @endphp
                            <tr class="hover:bg-blue-50 transition-colors duration-150 file-row" data-path="{{ $file->path ?? '' }}" data-type="{{ $file->type ?? '' }}" data-name="{{ $file->name ?? '' }}">
                                <td class="px-4 py-2 w-10 text-center">
                                    <input type="checkbox" name="selected_items[]" value="{{ $file->path ?? '' }}" class="item-checkbox rounded text-blue-600 border-gray-300 focus:ring-blue-500 shadow-sm" aria-label="Pilih item {{ $file->name ?? '' }}">
                                </td>
                                <td class="px-4 py-2 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-8 w-8 flex items-center justify-center rounded-full bg-gray-100 mr-3">
                                        @if($isFolder)
                                            <svg class="text-yellow-500 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M2 6a2 2 0 012-2h5l2 2h5a2 2 0 012 2v6a2 2 0 01-2 2H4a2 2 0 01-2-2V6z"/>
                                            </svg>
                                        @else
                                            <svg class="text-blue-500 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A1 1 0 0111.293 2.707L12.586 4H16a2 2 0 012 2v8a2 2 0 01-2 2H4a2 2 0 01-2-2V6a2 2 0 012-2zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd" />
                                            </svg>
                                        @endif
                                        </div>
                                        <span class="text-sm text-gray-800 font-medium truncate" style="max-width: 200px;" title="{{ $file->name ?? '' }}">
                                            @if($isFolder)
                                                <a href="{{ route('folders.open', ['folderName' => basename($file->path ?? '')]) }}" class="hover:underline hover:text-blue-600 transition-colors duration-150">
                                                    {{ $file->name ?? 'N/A' }}
                                                </a>
                                            @else
                                                {{ $file->name ?? 'N/A' }}
                                            @endif
                                        </span>
                                    </div>
                                </td>
                                <td class="px-3 py-2 text-xs text-gray-600 hidden md:table-cell whitespace-nowrap">
                                    {{ $file->created_at ? \Carbon\Carbon::parse($file->created_at)->isoFormat('D MMM YYYY, HH:mm') : 'N/A' }}
                                </td>
                                <td class="px-3 py-2 text-xs text-gray-600 hidden lg:table-cell whitespace-nowrap">
                                    {{ $file->size ?? ($isFolder ? '--' : 'N/A') }}
                                </td>
                                <td class="px-4 py-2 text-right whitespace-nowrap">
                                    <div class="flex justify-end items-center gap-2 actions opacity-0 md:opacity-100">
                                        @if($isFolder)
                                        <a href="{{ route('folders.open', ['folderName' => basename($file->path ?? '')]) }}" class="text-blue-600 hover:text-blue-800 transition-all duration-150 p-1.5 hover:bg-blue-100 rounded-full" title="Buka Folder">
                                            <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12.75 15l3-3m0 0l-3-3m3 3h-7.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        </a>
                                        @else
                                        <a href="{{ $file->url ?? '#' }}" target="_blank" class="text-green-600 hover:text-green-800 transition-all duration-150 p-1.5 hover:bg-green-100 rounded-full" title="Lihat File">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" stroke-width="1.5">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            </svg>
                                        </a>
                                        @endif

                                        @if(isset($file->type))
                                            @if($isFolder)
                                            <a data-log-activity="Download Folder" href="{{ route('download.folder', ['folderPath' => $encodedPath]) }}" class="text-gray-600 hover:text-gray-800 transition-all duration-150 p-1.5 hover:bg-gray-200 rounded-full" title="Unduh Folder">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" /></svg>
                                            </a>
                                            @else
                                            <a href="{{ route('download.file', ['filePath' => $encodedPath]) }}" class="text-gray-600 hover:text-gray-800 transition-all duration-150 p-1.5 hover:bg-gray-200 rounded-full" title="Unduh File">
                                                 <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" /></svg>
                                            </a>
                                                @if(in_array(strtolower($extension), ['doc', 'docx', 'xls', 'xlsx', 'pptx']))
                                                <a target="_blank" href="{{ route('template.edit', ['encodedPath' => $encodedPath]) }}" class="text-purple-600 hover:text-purple-800 transition-all duration-150 p-1.5 hover:bg-purple-100 rounded-full" title="Edit Template">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" stroke-width="1.5">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                                    </svg>
                                                </a>
                                                @endif
                                            @endif
                                        @endif
                                        {{-- Tombol aksi lainnya seperti hapus bisa ditambahkan di sini --}}
                                    </div>
                                </td>
                            </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        {{-- UI Fallback jika tidak ada file --}}
        <div class="text-center py-12 md:py-16 bg-gradient-to-r from-gray-50 to-blue-50 rounded-lg border-2 border-dashed border-gray-200 transition-all duration-300 hover:shadow-inner">
            <svg class="mx-auto h-16 w-16 text-gray-400" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12.75V12A2.25 2.25 0 014.5 9.75h15A2.25 2.25 0 0121.75 12v.75m-8.69-6.44l-2.12-2.12a1.5 1.5 0 00-1.061-.44H4.5A2.25 2.25 0 002.25 6v12a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9a2.25 2.25 0 00-2.25-2.25h-5.379a1.5 1.5 0 01-1.06-.44z" />
=======
        @if(!empty($files) && count($files) > 0)
<div class="overflow-x-auto rounded-lg border border-gray-200">
    <table class="min-w-full divide-y divide-gray-200 text-sm">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-4 py-2 w-8">
                    <input type="checkbox" id="select-all" class="rounded text-blue-600 border-gray-300 focus:ring-blue-500">
                </th>
                <th scope="col" class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                <th scope="col" class="px-2 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden sm:table-cell">Type</th>
                <th scope="col" class="px-2 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden md:table-cell">Modified</th>
                <th scope="col" class="px-2 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden lg:table-cell">Size</th>
                <th scope="col" class="px-2 py-2 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @foreach($filteredFiles as $file)
            <tr class="hover:bg-gray-50 transition-colors" data-id="{{ $file['path'] }}" data-type="{{ $file['type'] }}" data-name="{{ $file['name'] }}">
                <td class="px-4 py-2 w-8">
                    <input type="checkbox" name="selected_items[]" value="{{ $file['path'] }}" class="item-checkbox rounded text-blue-600 border-gray-300 focus:ring-blue-500">
                </td>
                <td class="px-4 py-2">
                    <div class="flex items-center">
                        @if(isset($file['type']) && $file['type'] === 'folder')
                        <svg class="flex-shrink-0 h-4 w-4 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" />
                        </svg>
                        @else
                        <svg class="flex-shrink-0 h-4 w-4 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        @endif
                        <span class="ml-2 text-sm text-gray-900 truncate max-w-[120px] sm:max-w-xs">{{ $file['name'] }}</span>
                    </div>
                </td>
                <td class="px-2 py-2 hidden sm:table-cell">
                    <span class="px-1.5 py-0.5 text-xs rounded-full bg-gray-100 text-gray-800 capitalize">
                        {{ $file['type'] ?? 'file' }}
                    </span>
                </td>
                <td class="px-2 py-2 text-xs text-gray-500 hidden md:table-cell">
                    {{ $file['created_at'] ?? 'N/A' }}
                </td>
                <td class="px-2 py-2 text-xs text-gray-500 hidden lg:table-cell">
                    {{ $file['size'] ?? 'N/A' }}
                </td>
                <td class="px-2 py-2 text-right">
                    <div class="flex justify-end gap-2">
                        @if(isset($file['type']) && $file['type'] === 'folder')
                        <a href="{{ route('folders.open', ['folderName' => basename($file['path'])]) }}" class="text-blue-600 hover:text-blue-800 transition-colors" title="Open">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M3 14h18m-8-4v8m-7 0h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                            </svg>
                        </a>
                        @else
                        <a href="{{ $file['url'] ?? '#' }}" target="_blank" class="text-blue-600 hover:text-blue-800 transition-colors" title="View">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </a>
                        @endif
                    @php
    $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
    $encodedPath = urlencode(base64_encode($file['path']));
@endphp

@if(isset($file['type']))
    @if($file['type'] === 'folder')
        <a href="{{ route('download.folder', ['folderPath' => $encodedPath]) }}" class="text-gray-600 hover:text-gray-800" title="Download Folder">
            <!-- Folder download icon -->
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
            </svg>
        </a>
    @else
        <a href="{{ route('download.file', ['filePath' => $encodedPath]) }}" class="text-gray-600 hover:text-gray-800" title="Download File">
            <!-- File download icon -->
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
        </a>
@if (session('success'))
    <div class="bg-green-100 text-green-800 px-4 py-2 rounded shadow mb-4">
        {{ session('success') }}
    </div>
@endif

        @if(in_array(strtolower($extension), ['doc', 'docx', 'xls', 'xlsx']))
            <a target="_blank" href="{{ route('template.edit.online', ['filePath' => $encodedPath]) }}" class="ml-2 text-blue-600 hover:text-blue-800" title="Edit Template">
                <!-- Edit icon -->
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536M9 11l6.586-6.586a2 2 0 112.828 2.828L11 13H9v-2zM4 20h16" />
                </svg>
            </a>
        @endif
    @endif
@endif



                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@else

        <!-- Fallback UI when no files are found -->
        <div class="text-center py-16 bg-gray-50 rounded-lg border-2 border-dashed border-gray-200">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 13h6m-3-3v6m-9 1V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z" />
>>>>>>> 365f2682a4a0ba76b17f51277b96827dd8b5a819
            </svg>
            <h3 class="mt-4 text-lg font-medium text-gray-900">Belum ada file</h3>
            <p class="mt-1 text-sm text-gray-500">Unggah file baru atau buat folder untuk memulai.</p>
            <div class="mt-6 flex flex-wrap justify-center items-center gap-3">
                <button type="button" onclick="document.getElementById('file').click()" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-300 hover:shadow-md hover:translate-y-[-2px]">
                    <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                    </svg>
                    Unggah File
                </button>
<<<<<<< HEAD
                <button onclick="toggleCreateFolderForm()" type="button" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-all duration-300 hover:shadow-md hover:translate-y-[-2px]">
                    <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 13h6m-3-3v6m-9 1V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z" />
                    </svg>
                    Folder Baru
                </button>
=======
                <button 
    onclick="toggleCreateFolderForm()" 
    type="button" 
    class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-200"
>
    <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m-9 1V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z" />
    </svg>
    New Folder
</button>
>>>>>>> 365f2682a4a0ba76b17f51277b96827dd8b5a819
            </div>
        </div>
        @endif
    </div>
</div>

<style>
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-fade-in {
        animation: fadeIn 0.3s ease-out forwards;
    }
    .file-row .actions {
        opacity: 0;
        transition: opacity 0.15s ease-in-out;
    }
    .file-row:hover .actions {
        opacity: 1;
    }
    @keyframes pulse {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.7; }
    }
    .animate-pulse {
        animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
    }
    .hover\:scale-102:hover {
        transform: scale(1.02);
    }
    @media (max-width: 768px) {
        .file-row .actions {
            opacity: 1;
        }
    }
</style>

<script>
    function toggleCreateFolderForm() {
        const form = document.getElementById('create-folder-form');
        const folderNameInput = document.getElementById('folder_name');
        form.classList.toggle('hidden');
        if (!form.classList.contains('hidden')) {
            folderNameInput.focus();
        } else {
            folderNameInput.value = ''; // Kosongkan input saat disembunyikan
        }
    }
<<<<<<< HEAD

    document.addEventListener('DOMContentLoaded', function () {
        const selectAllCheckbox = document.getElementById('select-all');
        const itemCheckboxes = document.querySelectorAll('.item-checkbox');
        const searchInput = document.getElementById('search-files');

        // Fungsi untuk Select All Checkbox
        if (selectAllCheckbox) {
            selectAllCheckbox.addEventListener('change', () => {
                itemCheckboxes.forEach(cb => {
                    // Hanya ubah state checkbox yang terlihat (tidak terfilter oleh search)
                    if (cb.closest('tr').style.display !== 'none') {
                        cb.checked = selectAllCheckbox.checked;
                    }
                });
                // Panggil fungsi update untuk bulk actions jika ada
                if (typeof updateRenameTextarea === 'function') updateRenameTextarea();
                if (typeof updateDeleteArea === 'function') updateDeleteArea();
            });
        }

        // Event listener untuk checkbox individual
        itemCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', () => {
                // Panggil fungsi update untuk bulk actions jika ada
                if (typeof updateRenameTextarea === 'function') updateRenameTextarea();
                if (typeof updateDeleteArea === 'function') updateDeleteArea();

                // Update state selectAllCheckbox
                if (selectAllCheckbox) {
                    let allVisibleChecked = true;
                    let anyVisibleChecked = false;
                    itemCheckboxes.forEach(cb => {
                        if (cb.closest('tr').style.display !== 'none') {
                            if (!cb.checked) allVisibleChecked = false;
                            if (cb.checked) anyVisibleChecked = true;
                        }
                    });
                    selectAllCheckbox.checked = allVisibleChecked;
                    // Indeterminate state jika tidak semua terpilih tapi ada beberapa yang terpilih
                    if (!allVisibleChecked && anyVisibleChecked) {
                        selectAllCheckbox.indeterminate = true;
                    } else {
                        selectAllCheckbox.indeterminate = false;
                    }
                }
            });
        });

        // Fungsi Pencarian Sederhana di Frontend
        if (searchInput) {
            searchInput.addEventListener('keyup', function() {
                const searchTerm = this.value.toLowerCase();
                const tableRows = document.querySelectorAll('tbody tr.file-row');
                let visibleCount = 0;

                tableRows.forEach(row => {
                    const fileName = row.dataset.name.toLowerCase();
                    if (fileName.includes(searchTerm)) {
                        row.style.display = '';
                        visibleCount++;
                    } else {
                        row.style.display = 'none';
                    }
                });

                // Update select all checkbox state based on filtered results
                if(selectAllCheckbox) {
                    let allFilteredChecked = true;
                    let anyFilteredChecked = false;
                    if (visibleCount > 0) {
                        itemCheckboxes.forEach(cb => {
                            const row = cb.closest('tr');
                            if (row.style.display !== 'none') { // Hanya pertimbangkan baris yang visible
                                if (!cb.checked) allFilteredChecked = false;
                                if (cb.checked) anyFilteredChecked = true;
                            }
                        });
                        selectAllCheckbox.checked = allFilteredChecked && anyFilteredChecked; // Harus ada yang tercentang dan semuanya tercentang
                        selectAllCheckbox.indeterminate = !allFilteredChecked && anyFilteredChecked;

                    } else { // Jika tidak ada hasil pencarian
                        selectAllCheckbox.checked = false;
                        selectAllCheckbox.indeterminate = false;
                    }
                }
            });
        }

        // Sisa skrip Anda untuk bulk rename dan delete
        // Pastikan textarea `bulk-renames` dan `bulk-delete` ada di HTML Anda
        const textareaRename = document.getElementById('bulk-renames');
        const textareaDelete = document.getElementById('bulk-delete');

        function updateRenameTextarea() {
            if (!textareaRename) return;
            let lines = [];
            itemCheckboxes.forEach(cb => {
                if (cb.checked) {
                    const row = cb.closest('tr');
                    const oldPath = cb.value;
                    const currentName = row?.dataset.name;
                    if (oldPath && currentName) {
                        lines.push(`${oldPath}➡️${currentName}`);
                    }
                }
            });
            textareaRename.value = lines.join('\n');
        }

        async function updateDeleteArea() {
            if (!textareaDelete) return;
            let paths = [];

            const fetchFolderContents = async (folderPath) => {
                // Implementasi Anda untuk mengambil konten folder (jika diperlukan untuk UI frontend)
                // Untuk saat ini, kita asumsikan backend menangani logika folder secara rekursif
                // Fungsi ini mungkin tidak diperlukan jika backend sudah menangani penghapusan folder secara rekursif
                // Jika Anda ingin menampilkan semua file yang akan dihapus (termasuk isi folder) di textarea,
                // Anda perlu endpoint API yang mengembalikan daftar file dalam folder.
                // Kode asli Anda memiliki `/api/folder-contents`, jadi saya akan biarkan kerangkanya.
                let allPathsInFolder = [];
                try {
                    // const response = await fetch(`/api/folder-contents?prefix=${encodeURIComponent(folderPath + '/')}`);
                    // const data = await response.json();
                    // allPathsInFolder = data.paths || [];
                    // console.log(`Contents for ${folderPath}:`, allPathsInFolder);
                } catch (error) {
                    console.error('Gagal mengambil isi folder (opsional):', error);
                }
                return allPathsInFolder; // Ini akan menjadi array kosong jika API tidak dipanggil/berhasil
            };

            for (const cb of itemCheckboxes) {
                if (cb.checked) {
                    const itemPath = cb.value;
                    const itemType = cb.closest('tr').dataset.type;
                    paths.push(itemPath); // Tambahkan path utama

                    // Jika Anda ingin menambahkan semua isi folder ke textarea secara eksplisit:
                    // if (itemType === 'folder') {
                    //     const contents = await fetchFolderContents(itemPath);
                    //     paths.push(...contents);
                    // }
                }
            }
            textareaDelete.value = paths.join('\n');
        }

        // Panggil update saat halaman dimuat jika ada item yang sudah tercentang
        if (textareaRename || textareaDelete) {
            updateRenameTextarea();
            updateDeleteArea();
        }
    });
=======
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
            if (cb.checked) {
                const itemPath = cb.value;
                const itemType = cb.closest('tr').dataset.type;

                paths.push(itemPath); // selalu tambahkan path utama

                // jika folder, fetch isinya
                if (itemType === 'folder') {
                    const contents = await fetchFolderContents(itemPath);
                    paths.push(...contents);
                }
            }
        }

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
>>>>>>> 365f2682a4a0ba76b17f51277b96827dd8b5a819
</script>