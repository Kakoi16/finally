<!-- resources/views/all-files.blade.php -->

<div id="all-files-page" class="page-content hidden p-6 space-y-6">

    <div class="flex gap-6 w-10">
            <!-- Upload File Section -->
            <div class="bg-white p-6 rounded-lg shadow">
                <h2 class="text-lg font-semibold mb-4">Upload File</h2>
                <form action="{{ route('files.upload') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    <div>
                        <label for="file" class="block text-sm font-medium text-gray-700">Pilih file untuk diupload</label>
                        <input type="file" name="file" id="file" class="mt-2 block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none">
                    </div>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                        Upload
                    </button>
                </form>
            </div>
        
            <!-- Create Folder Section -->
            <div class="bg-white p-6 rounded-lg shadow">
                <h2 class="text-lg font-semibold mb-4">Buat Folder Baru</h2>
                <form action="{{ route('folders.create') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label for="folder_name" class="block text-sm font-medium text-gray-700">Nama Folder</label>
                        <input type="text" name="folder_name" id="folder_name" class="mt-2 block w-full text-sm text-gray-900 border border-gray-300 rounded-lg focus:outline-none p-2">
                    </div>
                    <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
                        Buat Folder
                    </button>
                </form>
            </div>
    </div>

</div>
