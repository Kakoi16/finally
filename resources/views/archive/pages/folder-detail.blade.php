@extends('layouts.app')
@section('custom-sidebar')
    {{-- Sidebar khusus untuk folder --}}
    <aside class="w-64 bg-gray-100 p-4 rounded-lg shadow-md mr-4">
        <a href="/archive">
        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" height="800px" width="800px" version="1.1" id="Capa_1" viewBox="0 0 58 58" xml:space="preserve">
<path style="fill:#EFCE4A;" d="M46.324,52.5H1.565c-1.03,0-1.779-0.978-1.51-1.973l10.166-27.871  c0.184-0.682,0.803-1.156,1.51-1.156H56.49c1.03,0,1.51,0.984,1.51,1.973L47.834,51.344C47.65,52.026,47.031,52.5,46.324,52.5z"/>
<g>
	<path style="fill:#EBBA16;" d="M50.268,12.5H25l-5-7H1.732C0.776,5.5,0,6.275,0,7.232V49.96c0.069,0.002,0.138,0.006,0.205,0.01   l10.015-27.314c0.184-0.683,0.803-1.156,1.51-1.156H52v-7.268C52,13.275,51.224,12.5,50.268,12.5z"/>
</g>
</svg>
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
