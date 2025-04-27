@extends('layouts.app')
@section('custom-sidebar')
    {{-- Sidebar khusus untuk folder --}}
    <aside class="w-64 bg-white p-4 rounded-lg shadow-md mr-4 border border-gray-200">
        <div class="flex items-center mb-6">
            <a href="/archive" class="flex items-center">
                <svg height="32px" width="32px" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 58 58" xml:space="preserve" fill="#EFCE4A">
                    <path style="fill:#EFCE4A;" d="M46.324,52.5H1.565c-1.03,0-1.779-0.978-1.51-1.973l10.166-27.871 c0.184-0.682,0.803-1.156,1.51-1.156H56.49c1.03,0,1.51,0.984,1.51,1.973L47.834,51.344C47.65,52.026,47.031,52.5,46.324,52.5z"></path>
                    <path style="fill:#EBBA16;" d="M50.268,12.5H25l-5-7H1.732C0.776,5.5,0,6.275,0,7.232V49.96c0.069,0.002,0.138,0.006,0.205,0.01 l10.015-27.314c0.184-0.683,0.803-1.156,1.51-1.156H52v-7.268C52,13.275,51.224,12.5,50.268,12.5z"></path>
                </svg>
                <span class="ml-2 font-semibold text-gray-700">Folder Actions</span>
            </a>
        </div>
        <ul class="space-y-2">
            <li>
            <form method="POST" action="{{ route('folders.createSubfolder', $folderName) }}">
                    @csrf
                    <div class="mb-3">
                        <input type="text" name="folder_name" placeholder="Nama Subfolder" 
                               class="border border-gray-300 p-2 rounded w-full focus:outline-none focus:ring-2 focus:ring-blue-200">
                    </div>
                    <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded transition duration-200">
                        Buat Subfolder
                    </button>
                </form>
            </li>
            <li>
                <a href="#" class="flex items-center px-3 py-2 rounded hover:bg-blue-50 text-gray-700 hover:text-blue-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                    Tambah File
                </a>
            </li>
            <li>
                <a href="#" class="flex items-center px-3 py-2 rounded hover:bg-blue-50 text-gray-700 hover:text-blue-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                    </svg>
                    Edit Folder
                </a>
            </li>
            <li>
                <a href="#" class="flex items-center px-3 py-2 rounded hover:bg-red-50 text-red-600 hover:text-red-700">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                    </svg>
                    Hapus Folder
                </a>
            </li>
        </ul>
    </aside>
@endsection

@section('content')
    <div class="p-6 bg-white rounded-lg shadow-sm border border-gray-200">
        <h1 class="text-2xl font-bold text-gray-800 mb-2">Folder: {{ $folderName }}</h1>
        <p class="text-gray-600 mb-6">Berikut adalah isi folder <strong>{{ $folderName }}</strong>.</p>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Form Tambah Subfolder -->
            <div class="bg-blue-50 p-4 rounded-lg border border-blue-100">
                <h2 class="text-lg font-semibold mb-3 text-gray-700">Tambah Subfolder</h2>
                <form method="POST" action="{{ route('folders.createSubfolder', $folderName) }}">
                    @csrf
                    <div class="mb-3">
                        <input type="text" name="folder_name" placeholder="Nama Subfolder" 
                               class="border border-gray-300 p-2 rounded w-full focus:outline-none focus:ring-2 focus:ring-blue-200">
                    </div>
                    <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded transition duration-200">
                        Buat Subfolder
                    </button>
                </form>
            </div>

            <!-- Form Upload File -->
            <div class="bg-green-50 p-4 rounded-lg border border-green-100">
                <h2 class="text-lg font-semibold mb-3 text-gray-700">Upload File ke Folder Ini</h2>
                <form method="POST" action="{{ route('files.uploadToFolder', $folderName) }}" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <input type="file" name="file" 
                               class="border border-gray-300 p-2 rounded w-full focus:outline-none focus:ring-2 focus:ring-green-200">
                    </div>
                    <button type="submit" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded transition duration-200">
                        Upload File
                    </button>
                </form>
            </div>
        </div>

        <!-- Daftar file dalam folder -->
        <div class="mt-8">
            <h2 class="text-xl font-semibold mb-4 text-gray-700">Daftar File</h2>
            @if(count($files) > 0)
                <div class="bg-gray-50 rounded-lg border border-gray-200 overflow-hidden">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama File</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($files as $file)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $file['name'] }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        <a href="#" class="text-blue-500 hover:text-blue-700 mr-3">View</a>
                                        <a href="#" class="text-red-500 hover:text-red-700">Delete</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-8 bg-gray-50 rounded-lg border border-gray-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 13h6m-3-3v6m-9 1V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z" />
                    </svg>
                    <p class="mt-2 text-gray-500">Folder ini kosong. Silakan upload file atau buat subfolder.</p>
                </div>
            @endif
        </div>
    </div>
@endsection