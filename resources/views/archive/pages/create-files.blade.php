<div id="create-page" class="page-content hidden p-4 md:p-6 bg-gray-100 min-h-screen flex items-center justify-center">

    <div class="container bg-white rounded-lg shadow-xl p-6 md:p-8 w-full max-w-md">
        <h2 class="text-3xl font-bold text-gray-800 mb-6 text-center">Upload Versi Aplikasi Terbaru</h2>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <strong class="font-bold">Berhasil!</strong>
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        <form action="{{ route('app-update.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <div>
                <label for="version" class="block text-sm font-medium text-gray-700 mb-2">Versi Aplikasi (misal: 1.2.0)</label>
                <input type="text" name="version" id="version" required
                       class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm
                              transition duration-150 ease-in-out focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-white">
            </div>

            <div>
                <label for="app_file" class="block text-sm font-medium text-gray-700 mb-2">File APK</label>
                <input type="file" name="app_file" id="app_file" required
                       class="mt-1 block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50
                              file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold
                              file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 transition duration-150 ease-in-out
                              focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 focus:ring-offset-white">
                <p class="mt-1 text-xs text-gray-500">Ukuran file maksimal: 200MB (contoh).</p>
            </div>

            <div>
                <button type="submit"
                        class="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-lg font-semibold text-white bg-blue-600
                               hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500
                               transition duration-150 ease-in-out">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                    Upload
                </button>
            </div>
        </form>
    </div>

<!--<div class="bg-white p-6 rounded-lg shadow-md border border-gray-200">
        <h2 class="text-xl font-semibold text-gray-800 mb-5 border-b pb-3">Buat Dokumen Baru</h2>
        <form action="{{ route('archives.createDoc') }}" method="POST" target="_blank" class="space-y-5">
            @csrf
            <div>
                <label for="doc_name" class="block text-sm font-medium text-gray-700 mb-1">Nama Dokumen</label>
                <input type="text" name="name" id="doc_name"
                       class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-sm p-2.5 placeholder-gray-400"
                       required
                       placeholder="Contoh: Laporan Keuangan Q3">
            </div>

            <div>
                <label for="doc_type" class="block text-sm font-medium text-gray-700 mb-1">Pilih Tipe Dokumen</label>
                <select name="type" id="doc_type"
                        class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-sm p-2.5"
                        required>
                    <option value="doc">Dokumen Word (.docx)</option>
                </select>
            </div>

            <div class="pt-2 flex justify-end">
                <button type="submit"
                        class="inline-flex items-center justify-center px-4 py-2.5 border border-transparent rounded-lg text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 transition-colors duration-150 shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <svg class="w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Buat Dokumen
                </button>
            </div>
        </form>
    </div>

    <div class="bg-white p-6 rounded-lg shadow-md border border-gray-200">
        <h2 class="text-xl font-semibold text-gray-800 mb-5 border-b pb-3">Buat Dokumen dari Template</h2>
        <form action="{{ route('archives.createTemplateDoc') }}" method="POST" target="_blank" class="space-y-5">
            @csrf
            <div>
                <label for="template_doc_name" class="block text-sm font-medium text-gray-700 mb-1">Judul Dokumen (dari Template)</label>
                <input type="text" name="name" id="template_doc_name"
                       class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-sm p-2.5 placeholder-gray-400"
                       required
                       placeholder="Contoh: Surat Penawaran - Klien Z">
            </div>

            <div class="pt-2 flex justify-end">
                <button type="submit"
                        class="inline-flex items-center justify-center px-4 py-2.5 border border-transparent rounded-lg text-sm font-medium text-white bg-green-600 hover:bg-green-700 transition-colors duration-150 shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                    <svg class="w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                    </svg>
                    Buat dari Template Word
                </button>
            </div>
        </form>
    </div>-->
</div>