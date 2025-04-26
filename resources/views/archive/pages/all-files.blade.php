<!-- resources/views/all-files.blade.php -->

<div id="all-files-page" class="page-content hidden p-6 space-y-6">
    <!-- Upload File Section -->
    <div class="bg-white p-6 rounded-lg shadow relative">
        <div class="absolute top-4 right-4 flex items-center gap-2">
            <form action="{{ route('files.upload') }}" method="POST" enctype="multipart/form-data" class="relative">
                @csrf
                <input type="file" name="file" id="file" class="hidden" onchange="this.form.submit()">
                <label for="file" class="cursor-pointer bg-blue-500 hover:bg-blue-600 text-white p-2 rounded-full flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                    </svg>
                </label>
            </form>

            <!-- Create Folder Button -->
            <button onclick="toggleCreateFolderForm()" type="button" class="bg-green-500 hover:bg-green-600 text-white p-2 rounded-full flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m-9 1V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z" />
                </svg>
            </button>
        </div>
    </div>

    <!-- Create Folder Form (hidden initially) -->
    <div id="create-folder-form" class="bg-white p-6 rounded-lg shadow hidden">
        <h2 class="text-lg font-semibold mb-4">Buat Folder Baru</h2>
        <form action="{{ route('folders.create') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label for="folder_name" class="block text-sm font-medium text-gray-700">Nama Folder</label>
                <input type="text" name="folder_name" id="folder_name" class="mt-2 block w-full text-sm text-gray-900 border border-gray-300 rounded-lg focus:outline-none p-2">
            </div>
            <div class="flex justify-end">
                <button type="submit" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function toggleCreateFolderForm() {
        const form = document.getElementById('create-folder-form');
        form.classList.toggle('hidden');
    }
</script>
