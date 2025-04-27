<!-- resources/views/all-files.blade.php -->
@if(session('success'))
    <div class="bg-green-100 text-green-800 p-4 rounded mb-4">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="bg-red-100 text-red-800 p-4 rounded mb-4">
        {{ session('error') }}
    </div>
@endif

<div id="all-files-page" class="page-content p-6 space-y-6">
    <!-- Header Actions -->
    <div class="bg-white p-4 rounded-lg shadow relative">
        <div class="absolute top-4 right-4 flex items-center gap-2">
            <!-- Upload File Button -->
            <form action="{{ route('files.upload') }}" method="POST" enctype="multipart/form-data">
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
        <h1 class="text-2xl font-semibold text-gray-700">Manajemen File</h1>
    </div>

    <!-- Create Folder Form (Hidden Initially) -->
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
    <!-- List Files -->
<div class="bg-white p-6 rounded-lg shadow">
    <h2 class="text-lg font-semibold mb-4">Daftar File</h2>

    @if(count($files) > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($files as $file)
                <div class="border p-4 rounded-lg shadow-sm flex flex-col justify-between">
                    <div>
                        <p class="text-gray-700 font-semibold truncate">{{ $file['name'] }}</p>
                        <p class="text-gray-500 text-sm mt-1">{{ $file['created_at'] }}</p>
                    </div>
                    <div class="flex justify-end mt-4">
                        <a href="{{ $file['url'] }}" target="_blank" class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded-lg text-sm">
                            Lihat
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <p class="text-gray-500">Belum ada file yang diupload.</p>
    @endif
</div>

    <script>
function toggleCreateFolderForm() {
    var form = document.getElementById('create-folder-form');
    form.classList.toggle('hidden');
}
</script>
