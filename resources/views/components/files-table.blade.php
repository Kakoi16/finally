<!-- Files aaTable -->
<div class="mt-6 bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <!-- Header with search -->
    <div class="px-6 py-4 border-b border-gray-100 bg-white">
        <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4">
            <div>
                <h2 class="text-xl font-semibold text-gray-800">File Explorer</h2>
                <p class="text-sm text-gray-500 mt-1">Browse and manage your files</p>
            </div>
            <div class="relative w-full md:w-72">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
                <input type="text" placeholder="Search files..." class="block w-full pl-10 pr-3 py-2 border border-gray-200 rounded-lg text-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-100 focus:border-blue-300 bg-white transition">
            </div>
        </div>
    </div>

    <!-- Bulk actions toolbar (hidden by default) -->
    <div id="bulk-actions" class="hidden px-6 py-3 bg-blue-50 border-b border-blue-100">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <span id="selected-count" class="text-sm font-medium text-gray-700">0 items selected</span>
                <button class="text-sm text-blue-600 hover:text-blue-800 font-medium">Download</button>
                <button class="text-sm text-red-600 hover:text-red-800 font-medium">Delete</button>
            </div>
            <button id="clear-selection" class="text-sm text-gray-500 hover:text-gray-700">
                Clear
            </button>
        </div>
    </div>

    <!-- Files table -->
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-10">
                        <input type="checkbox" id="select-all" class="rounded text-blue-600 border-gray-300 focus:ring-blue-500">
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-32">Size</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-48">Modified</th>
                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider w-40">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($files as $file)
                <tr class="hover:bg-gray-50 transition-colors" data-id="{{ $file['path'] }}" data-type="{{ $file['type'] }}" data-name="{{ $file['name'] }}">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <input type="checkbox" name="selected_items[]" value="{{ $file['path'] }}" class="item-checkbox rounded text-blue-600 border-gray-300 focus:ring-blue-500">
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            @if($file['type'] === 'folder')
                            <!-- Folder Icon -->
                            <div class="flex-shrink-0 bg-yellow-50 p-2 rounded-lg mr-3 border border-yellow-100">
                                <svg class="w-5 h-5 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" />
                                </svg>
                            </div>
                            @else
                            <!-- File Icon with different types -->
                            @php
                            $fileExtension = pathinfo($file['name'], PATHINFO_EXTENSION);
                            $iconColor = 'text-gray-400';
                            $iconPath = '';

                            switch(strtolower($fileExtension)) {
                                case 'pdf':
                                    $iconColor = 'text-red-500';
                                    $iconPath = 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z';
                                    break;
                                case 'doc':
                                case 'docx':
                                    $iconColor = 'text-blue-500';
                                    $iconPath = 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z';
                                    break;
                                case 'xls':
                                case 'xlsx':
                                    $iconColor = 'text-green-500';
                                    $iconPath = 'M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z';
                                    break;
                                case 'jpg':
                                case 'jpeg':
                                case 'png':
                                case 'gif':
                                    $iconColor = 'text-purple-500';
                                    $iconPath = 'M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z';
                                    break;
                                default:
                                    $iconPath = 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z';
                            }
                            @endphp
                            <div class="flex-shrink-0 bg-gray-50 p-2 rounded-lg mr-3 border border-gray-100">
                                <svg class="w-5 h-5 {{ $iconColor }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="{{ $iconPath }}" />
                                </svg>
                            </div>
                            @endif
                            <div class="min-w-0">
                                <span class="text-sm font-medium text-gray-900 truncate block max-w-xs">{{ $file['name'] }}</span>
                                @if($file['type'] !== 'folder')
                                <span class="text-xs text-gray-500">{{ strtoupper($fileExtension) }}</span>
                                @endif
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        {{ $file['size'] ?? '--' }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        {{ $file['modified'] ?? '--' }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <div class="flex justify-end space-x-2">
                            @if($file['type'] === 'folder')
                            <a href="{{ route('folders.showAny', ['any' => $file['path']]) }}"
                                class="text-gray-500 hover:text-blue-600 p-2 rounded-md hover:bg-blue-50 transition-colors"
                                title="Open">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 19a2 2 0 01-2-2V7a2 2 0 012-2h4l2 2h4a2 2 0 012 2v1M5 19h14a2 2 0 002-2v-5a2 2 0 00-2-2H9a2 2 0 00-2 2v5a2 2 0 01-2 2z" />
                                </svg>
                            </a>
                            <button class="rename-item-btn text-gray-500 hover:text-gray-700 p-2 rounded-md hover:bg-gray-50 transition-colors" title="Rename">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                            </button>
                            @else
                            <a href="#" class="text-gray-500 hover:text-blue-600 p-2 rounded-md hover:bg-blue-50 transition-colors" title="View">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </a>
                            @endif
                            <a href="#" class="text-gray-500 hover:text-gray-700 p-2 rounded-md hover:bg-gray-50 transition-colors" title="Download">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                </svg>
                            </a>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Empty state -->
    @if(count($files) === 0)
    <div class="py-12 text-center">
        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 13h6m-3-3v6m-9 1V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z" />
        </svg>
        <h3 class="mt-2 text-sm font-medium text-gray-900">No files</h3>
        <p class="mt-1 text-sm text-gray-500">Upload or create your first file.</p>
        <div class="mt-6">
            <button type="button" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
                New File
            </button>
        </div>
    </div>
    @endif
</div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const checkboxes = document.querySelectorAll('.item-checkbox');
        const textarea = document.getElementById('bulk-renames');

        checkboxes.forEach(checkbox => {
            checkbox.addEventListener('change', updateRenameTextarea);
        });

        function updateRenameTextarea() {
    let lines = [];

    checkboxes.forEach(cb => {
        if (cb.checked) {
            const row = cb.closest('tr');
            const oldPath = cb.value;
            const currentName = row?.dataset.name;

            if (oldPath && currentName) {
                lines.push(`${oldPath}➡️${currentName}`);
            }
        }
    });

    textarea.value = lines.join('\n');
}


        // opsional pada cekbox
        const selectAll = document.getElementById('select-all');
        if (selectAll) {
            selectAll.addEventListener('change', () => {
                checkboxes.forEach(cb => cb.checked = selectAll.checked);
                updateRenameTextarea();
            });
        }
    });
    document.addEventListener('DOMContentLoaded', function () {
    const checkboxes = document.querySelectorAll('.item-checkbox');
    const textareaDelete = document.getElementById('bulk-delete');
    const selectAll = document.getElementById('select-all');

    function updateDeleteArea() {
    let paths = [];

    const fetchFolderContents = async (path) => {
    let allPaths = [];

    const fetchRecursive = async (prefix) => {
        try {
            const response = await fetch(`/api/folder-contents?prefix=${encodeURIComponent(prefix)}`);
            const data = await response.json();
            const paths = data.paths || [];

            for (const p of paths) {
                allPaths.push(p);

                // Cek apakah path ini adalah folder (dengan trailing slash)
                if (p.endsWith('/')) {
                    await fetchRecursive(p);
                }
            }
        } catch (error) {
            console.error('Gagal mengambil isi folder:', error);
        }
    };

    await fetchRecursive(path + '/'); // pastikan ada trailing slash
    return allPaths;
};


    const processCheckboxes = async () => {
        for (const cb of checkboxes) {
            if (cb.checked) {
                const itemPath = cb.value;
                const itemType = cb.closest('tr').dataset.type;

                paths.push(itemPath); // selalu tambahkan path utama

                // jika folder, fetch isinya
                if (itemType === 'folder') {
                    const contents = await fetchFolderContents(itemPath);
                    paths.push(...contents);
                }
            }
        }

        if (textareaDelete) {
            textareaDelete.value = paths.join('\n');
        }
    };

    processCheckboxes();
}

    // checkbox maasing-masing
    checkboxes.forEach(cb => {
        cb.addEventListener('change', updateDeleteArea);
    });

    // checkbox "select all"
    if (selectAll) {
        selectAll.addEventListener('change', () => {
            checkboxes.forEach(cb => cb.checked = selectAll.checked);
            updateDeleteArea();
        });
    }

    // Panggil saat pertama kali jika ada pre-checked
    updateDeleteArea();
});
</script>
