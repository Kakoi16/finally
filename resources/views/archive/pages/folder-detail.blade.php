@extends('layouts.app')
@section('custom-sidebar')
    {{-- Sidebar khusus untuk folder --}}
    <aside class="w-64 bg-gray-100 p-4 rounded-lg shadow-md mr-4">
        <a href="/archive">
        <svg height="88px" width="88px" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 58 58" xml:space="preserve" fill="#000000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path style="fill:#EFCE4A;" d="M46.324,52.5H1.565c-1.03,0-1.779-0.978-1.51-1.973l10.166-27.871 c0.184-0.682,0.803-1.156,1.51-1.156H56.49c1.03,0,1.51,0.984,1.51,1.973L47.834,51.344C47.65,52.026,47.031,52.5,46.324,52.5z"></path> <g> <path style="fill:#EBBA16;" d="M50.268,12.5H25l-5-7H1.732C0.776,5.5,0,6.275,0,7.232V49.96c0.069,0.002,0.138,0.006,0.205,0.01 l10.015-27.314c0.184-0.683,0.803-1.156,1.51-1.156H52v-7.268C52,13.275,51.224,12.5,50.268,12.5z"></path> </g> </g></svg>
        </a>
        <ul class="space-y-2">
            <li>
                <a href="{{ route('folders.open', $folderName) }}" class="block px-2 py-1 rounded hover:bg-blue-100">Isi Folder</a>
            </li>
            <li>
                <a href="#" class="block px-2 py-1 rounded hover:bg-blue-100">Tambah File</a>
            </li>
            <li>
                <a href="#" class="block px-2 py-1 rounded hover:bg-blue-100">Edit Folder</a>
            </li>
            <li>
                <a href="#" class="block px-2 py-1 rounded hover:bg-blue-100 text-red-500">Hapus Folder</a>
            </li>
        </ul>
    </aside>
@endsection

@section('content')
    <div class="p-6">
    <div class="mt-6">
    <h2 class="text-xl font-semibold mb-2">Tambah Subfolder</h2>
    <form method="POST" action="{{ route('folders.createSubfolder', $folderName) }}">
        @csrf
        <input type="text" name="folder_name" placeholder="Nama Subfolder" class="border p-2 rounded w-full mb-2">
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Buat Subfolder</button>
    </form>
</div>

<div class="mt-6">
    <h2 class="text-xl font-semibold mb-2">Upload File ke Folder Ini</h2>
    <form method="POST" action="{{ route('files.uploadToFolder', $folderName) }}" enctype="multipart/form-data">
        @csrf
        <input type="file" name="file" class="border p-2 rounded w-full mb-2">
        <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">Upload File</button>
    </form>
</div>

        <h1 class="text-2xl font-bold">Folder: {{ $folderName }}</h1>
        <p>Berikut adalah isi folder <strong>{{ $folderName }}</strong>.</p>

        <!-- Daftar file dalam folder bisa ditampilkan di sini -->
        <div class="mt-4">
            <!-- Misalnya, menampilkan file terkait folder ini -->
            @foreach($files as $file)
    <div>{{ $file['name'] }}</div>  
@endforeach

        </div>
    </div>
@endsection
