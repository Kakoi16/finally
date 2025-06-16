<div id="create-page" class="page-content hidden p-4 md:p-6 space-y-6">

    <div class="bg-white p-6 rounded-lg shadow-md border border-gray-200">
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
    </div>

</div>