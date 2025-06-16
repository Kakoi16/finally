{{-- Anda bisa menggunakan layout utama aplikasi Anda --}}
{{-- Contoh jika menggunakan layout default Laravel Breeze atau Jetstream: --}}
{{-- <x-app-layout> --}}
{{-- <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('View PDF: ') . $archive->name }}
        </h2>
    </x-slot> --}}

{{-- Jika tidak menggunakan layout, minimal ada HTML dasar --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>View PDF: {{ $archive->name }}</title>
    {{-- Tambahkan CSS jika perlu, misalnya Tailwind jika digunakan di project --}}
    {{-- <link href="{{ asset('css/app.css') }}" rel="stylesheet"> --}}
    <style>
        body, html {
            margin: 0;
            padding: 0;
            height: 100%;
            overflow: hidden; /* Mencegah scrollbar ganda */
            font-family: sans-serif; /* Font dasar */
        }
        .pdf-container {
            width: 100%;
            height: 100vh; /* Tinggi penuh viewport */
            display: flex;
            flex-direction: column;
        }
        .controls {
            padding: 12px 15px;
            background-color: #f1f5f9; /* slate-100 */
            border-bottom: 1px solid #e2e8f0; /* slate-200 */
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .controls strong {
            font-size: 1.1em;
            color: #1e293b; /* slate-800 */
        }
        .back-link {
            display: inline-flex;
            align-items: center;
            padding: 6px 12px;
            background-color: #4f46e5; /* indigo-600 */
            color: white;
            text-decoration: none;
            border-radius: 6px; /* rounded-md */
            font-size: 0.9em;
            transition: background-color 0.2s;
        }
        .back-link:hover {
            background-color: #4338ca; /* indigo-700 */
        }
        .pdf-iframe {
            flex-grow: 1; /* Mengisi sisa ruang */
            border: none;
        }
        .pdf-iframe p { /* Styling untuk pesan fallback */
            padding: 20px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="pdf-container">
        <div class="controls">
            <a href="{{ url()->previous() ?? route('archive') }}" class="back-link">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                </svg>
                Kembali
            </a>
            <strong>{{ $archive->name }}</strong>
        </div>
        <iframe src="{{ route('archives.streamPdf', $archive->id) }}" class="pdf-iframe" title="PDF Viewer: {{ $archive->name }}">
            <p>Browser Anda tidak mendukung untuk menampilkan PDF secara inline.
            <a href="{{ route('archives.streamPdf', $archive->id) }}" download="{{ $archive->name }}">Unduh PDF sebagai gantinya</a>.</p>
        </iframe>
    </div>
</body>
</html>
{{-- </x-app-layout> --}}