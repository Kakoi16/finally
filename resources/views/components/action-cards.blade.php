<aside class="w-72 bg-white p-6 rounded-xl shadow-sm border border-gray-100 mr-6">
    <div class="flex items-center mb-8">
        <a href="/archive" class="flex items-center group">
            <div class="bg-yellow-50 p-2 rounded-lg group-hover:bg-yellow-100 transition-colors border border-yellow-100">
                <svg class="w-6 h-6 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" />
                </svg>
            </div>
            <span class="ml-3 font-semibold text-gray-700 group-hover:text-gray-900 transition-colors">Folder Actions</span>
        </a>
    </div>

    <div class="space-y-5">
        <!-- Create Subfolder Card -->
        <div class="bg-blue-50/50 p-4 rounded-lg border border-blue-100">
            <h3 class="text-sm font-semibold text-blue-800 mb-3 flex items-center">
                <svg class="w-4 h-4 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
                Create Subfolder
            </h3>
            <form method="POST" action="{{ route('folders.subfolder.create', ['path' => $folderPath]) }}" class="space-y-3">
                @csrf
                <div>
                    <input type="text" name="folder_name" placeholder="Enter subfolder name"
                        class="text-sm border border-blue-200 bg-white p-2.5 rounded-lg w-full focus:outline-none focus:ring-2 focus:ring-blue-200 focus:border-blue-300 transition">
                </div>
                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-2.5 rounded-lg transition duration-200 text-sm font-medium flex items-center justify-center shadow-sm">
                    Create Subfolder
                </button>
            </form>
        </div>

        <!-- Upload File Card -->
        <div class="bg-emerald-50/50 p-4 rounded-lg border border-emerald-100">
            <h3 class="text-sm font-semibold text-emerald-800 mb-3 flex items-center">
                <svg class="w-4 h-4 mr-2 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                </svg>
                Upload File
            </h3>
            <form method="POST" action="{{ route('files.uploadToFolder', $currentFolder) }}" enctype="multipart/form-data" class="space-y-3">

                @csrf
                <div class="relative">
                    <input id="fileInput" type="file" name="file" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" onchange="updateFileName(this)">
                    <div id="fileLabel" class="flex items-center justify-between p-2.5 border border-emerald-200 bg-white rounded-lg text-sm text-gray-500">
                        <span class="truncate">Pilih file untuk diunggah</span>
                        <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                        </svg>
                    </div>
                </div>

                <button type="submit" class="w-full bg-emerald-600 bg-blue-600 text-white rounded px-4 py-2.5 rounded-lg transition duration-200 text-sm font-medium flex items-center justify-center shadow-sm">
                    Upload File
                </button>
            </form>
        </div>

        <!-- Bulk Actions Card -->
        <div class="bg-purple-50/50 p-4 rounded-lg border border-purple-100">
            <h3 class="text-sm font-semibold text-purple-800 mb-3 flex items-center">
                <svg class="w-4 h-4 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
                Bulk Actions
            </h3>
            <div class="space-y-3">
                <!-- Bulk Rename Form -->
                <form method="POST" action="{{ route('folders.bulk.rename') }}">
                    @csrf
                    <input type="hidden" name="folderPath" value="{{ $folderPath }}">
                    <div class="space-y-2">
                        <textarea id="bulk-renames" name="renames" rows="3" placeholder="old_path_1|new_name_1\nold_path_2|new_name_2" class="w-full text-sm border border-purple-300 p-2 rounded-lg"></textarea>

                        <button type="submit" class="w-full bg-purple-600 hover:bg-purple-700 text-white px-4 py-2.5 rounded-lg text-sm font-medium flex items-center justify-center shadow-sm">
                            Rename Selected
                        </button>
                    </div>
                </form>

                <!-- Bulk Delete Form -->
                <form method="POST" action="{{ route('folders.bulk.delete') }}">
                    @csrf
                    @method('DELETE')
                    <div class="space-y-2 mt-3">
                    <textarea id="bulk-delete" name="bulk-delete" rows="3" placeholder="path/to/delete1\npath/to/delete2" class="w-full text-sm border border-red-300 p-2 rounded-lg"></textarea>
                    </textarea>
                        <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white px-4 py-2.5 rounded-lg text-sm font-medium flex items-center justify-center shadow-sm">
                            Delete Selected
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</aside>
<script>
    function updateFileName(input) {
        const fileLabel = document.getElementById('fileLabel').querySelector('span');
        if (input.files.length > 0) {
            fileLabel.textContent = input.files[0].name;
        } else {
            fileLabel.textContent = 'Pilih file untuk diunggah';
        }
    }
    
</script>