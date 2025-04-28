@extends('layouts.app')

@section('custom-sidebar')
<aside class="w-72 bg-white p-6 rounded-xl shadow-sm border border-gray-100 mr-6">
    <div class="flex items-center mb-8">
        <a href="/archive" class="flex items-center group">
            <div class="bg-yellow-50 p-2 rounded-lg group-hover:bg-yellow-100 transition border border-yellow-100">
                <svg class="w-6 h-6 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" />
                </svg>
            </div>
            <span class="ml-3 font-semibold text-gray-700 group-hover:text-gray-900 transition">Folder Actions</span>
        </a>
    </div>

    <div class="space-y-5">
        <!-- Create Subfolder -->
        <div class="bg-blue-50/50 p-4 rounded-lg border border-blue-100">
            <h3 class="text-sm font-semibold text-blue-800 mb-3 flex items-center">
                <svg class="w-4 h-4 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
                Create Subfolder
            </h3>
            <form method="POST" action="{{ route('folders.createSubfolder', $folderName) }}" class="space-y-3">
                @csrf
                <input type="text" name="folder_name" placeholder="Enter subfolder name" class="text-sm border border-blue-200 bg-white p-2.5 rounded-lg w-full focus:outline-none focus:ring-2 focus:ring-blue-200">
                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-2.5 rounded-lg text-sm font-medium flex items-center justify-center shadow transition">
                    Create Subfolder
                </button>
            </form>
        </div>

        <!-- Upload File -->
        <div class="bg-emerald-50/50 p-4 rounded-lg border border-emerald-100">
            <h3 class="text-sm font-semibold text-emerald-800 mb-3 flex items-center">
                <svg class="w-4 h-4 mr-2 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                </svg>
                Upload File
            </h3>
            <form method="POST" action="{{ route('files.uploadToFolder', $folderName) }}" enctype="multipart/form-data" class="space-y-3">
                @csrf
                <label class="relative cursor-pointer">
                    <input type="file" name="file" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" onchange="this.nextElementSibling.innerText = this.files[0]?.name || 'Choose file'">
                    <div class="flex items-center justify-between p-2.5 border border-emerald-200 bg-white rounded-lg text-sm text-gray-500">
                        <span class="truncate">Choose file</span>
                        <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                        </svg>
                    </div>
                </label>
                <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2.5 rounded-lg text-sm font-medium flex items-center justify-center shadow transition">
                    Upload File
                </button>
            </form>
        </div>

        <!-- Folder Actions -->
        <div class="space-y-1.5">
            <form method="POST" action="{{ route('folders.rename', $folderName) }}" class="flex flex-col">
                @csrf
                <button type="submit" class="flex items-center px-4 py-2.5 rounded-lg hover:bg-gray-50 text-gray-600 hover:text-gray-900 text-sm font-medium border border-gray-100 transition">
                    <svg class="w-5 h-5 mr-3 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    Rename Folder
                </button>
            </form>

            <form method="POST" action="{{ route('folders.delete', $folderName) }}" onsubmit="return confirm('Are you sure you want to delete this folder?')" class="flex flex-col">
                @csrf
                @method('DELETE')
                <button type="submit" class="flex items-center px-4 py-2.5 rounded-lg hover:bg-red-50 text-red-600 hover:text-red-700 text-sm font-medium border border-gray-100 transition">
                    <svg class="w-5 h-5 mr-3 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                    Delete Folder
                </button>
            </form>
        </div>
    </div>
</aside>
@endsection
