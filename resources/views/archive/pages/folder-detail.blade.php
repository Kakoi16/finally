@extends('layouts.app')
@section('custom-sidebar')
    {{-- Sidebar khusus untuk folder --}}
    <aside class="w-64 bg-gray-100 p-4 rounded-lg shadow-md mr-4">
        <h2 class="text-lg font-bold mb-4">Navigasi Folder</h2>
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
