<!-- resources/views/all-files.blade.php -->

<div id="all-files-page" class="page-content hidden p-6 space-y-6">

    <div class="flex flex-wrap gap-6 justify-center md:flex-nowrap">
        <!-- Upload File Section -->
        <div class="bg-white p-6 rounded-lg shadow w-full md:w-1/2 xl:w-1/3">
            <h2 class="text-lg font-semibold mb-4">Upload File</h2>
            <form action="{{ route('files.upload') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                <div>
                    <label for="file" class="block text-sm font-medium text-gray-700">Pilih file untuk diupload</label>
                    <input type="file" name="file" id="file" class="mt-2 block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none">
                </div>
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Upload
                </button>
            </form>
        </div>
        
        <!-- Create Folder Section -->
        <div class="bg-white p-6 rounded-lg shadow w-full md:w-1/2 xl:w-1/3">
            <h2 class="text-lg font-semibold mb-4">Buat Folder Baru</h2>
            <form action="{{ route('folders.create') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label for="folder_name" class="block text-sm font-medium text-gray-700">Nama Folder</label>
                    <input type="text" name="folder_name" id="folder_name" class="mt-2 block w-full text-sm text-gray-900 border border-gray-300 rounded-lg focus:outline-none p-2">
                </div>
                <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                    Buat Folder
                </button>
            </form>
        </div>
    </div>

</div>