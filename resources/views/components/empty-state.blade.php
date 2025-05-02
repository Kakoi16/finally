<!-- Emptfy State -->
<div class="text-center py-16 bg-gray-50 rounded-lg border-2 border-dashed border-gray-200">
    <svg class="mx-auto h-14 w-14 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 13h6m-3-3v6m-9 1V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z" />
    </svg>
    <h3 class="mt-4 text-lg font-medium text-gray-700">No files found</h3>
    <p class="mt-1 text-gray-500 max-w-md mx-auto">This folder is empty. Upload files or create subfolders to get started.</p>
    <div class="mt-6 flex justify-center space-x-3">
    <form method="POST" action="{{ route('files.uploadToFolder', $folderName) }}" enctype="multipart/form-data" class="space-y-3">
                @csrf
                <div class="relative">
                    <input type="file" name="file" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                    <div class="flex items-center justify-between p-2.5 border border-emerald-200 bg-white rounded-lg text-sm text-gray-500">
                        <span class="truncate">Choose file</span>
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
</div>