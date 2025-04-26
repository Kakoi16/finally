<!-- resources/views/all-files.blade.php -->

<div id="all-files-page" class="page-content hidden p-6 space-y-6">
    <!-- Upload File Section -->
    <div class="bg-white p-6 rounded-lg shadow relative">
        <div class="absolute top-4 right-4">
            <form action="{{ route('files.upload') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="flex items-center gap-2">
                    <input type="file" name="file" id="file" class="hidden" onchange="this.form.submit()">
                    <label for="file" class="cursor-pointer bg-blue-500 hover:bg-blue-600 text-white text-sm py-1 px-3 rounded">
                        Upload
                    </label>
                </div>
            </form>
        </div>
        <h2 class="text-lg font-semibold mb-4">Upload File</h2>
        <p class="text-sm text-gray-600">Pilih file untuk diupload menggunakan tombol di atas</p>
    </div>
    
    <!-- Create Folder Section -->
    <div class="bg-white p-6 rounded-lg shadow relative">
        <div class="absolute top-4 right-4">
            <form action="{{ route('folders.create') }}" method="POST">
                @csrf
                <button type="submit" class="bg-green-500 hover:bg-green-600 text-white text-sm py-1 px-3 rounded">
                    Buat Folder
                </button>
            </form>
        </div>
        <h2 class="text-lg font-semibold mb-4">Buat Folder Baru</h2>
        <form method="POST" class="space-y-4">
            <div>
                <label for="folder_name" class="block text-sm font-medium text-gray-700">Nama Folder</label>
                <input type="text" name="folder_name" id="folder_name" class="mt-2 block w-full text-sm text-gray-900 border border-gray-300 rounded-lg focus:outline-none p-2">
            </div>
        </form>
    </div>
</div>