<aside id="sidebar" class="hidden md:flex md:flex-col w-full md:w-56 bg-white rounded-lg shadow-sm border border-gray-100 p-3 mb-4 md:mb-0 md:mr-4">
    <!-- Navigation Menu -->
    <nav class="flex-1">
        <ul class="space-y-1">
            <li>
                <a href="#" class="sidebar-menu flex items-center space-x-3 p-2.5 rounded-lg hover:bg-gray-50 text-gray-700 hover:text-gray-900 transition-colors" data-page="dashboard-page">
                    <i class="fas fa-home w-4 text-center text-gray-500"></i>
                    <span class="text-sm font-medium">Dashboard</span>
                </a>
            </li>
            <li>
                <a href="#" class="sidebar-menu flex items-center space-x-3 p-2.5 rounded-lg hover:bg-gray-50 text-gray-700 hover:text-gray-900 transition-colors" data-page="all-files-page">
                    <i class="fas fa-folder w-4 text-center text-blue-500"></i>
                    <span class="text-sm font-medium">Semua File</span>
                </a>
            </li>
            <li>
                <a href="#" class="sidebar-menu flex items-center space-x-3 p-2.5 rounded-lg hover:bg-gray-50 text-gray-700 hover:text-gray-900 transition-colors" data-page="shared-page">
                    <i class="fas fa-share-alt w-4 text-center text-green-500"></i>
                    <span class="text-sm font-medium">Shared</span>
                </a>
            </li>
            <li>
                <a href="#" class="sidebar-menu flex items-center space-x-3 p-2.5 rounded-lg hover:bg-gray-50 text-gray-700 hover:text-gray-900 transition-colors" data-page="recent-page">
                    <i class="fas fa-clock w-4 text-center text-yellow-500"></i>
                    <span class="text-sm font-medium">Recent</span>
                </a>
            </li>
            <li>
                <a href="#" class="sidebar-menu flex items-center space-x-3 p-2.5 rounded-lg hover:bg-gray-50 text-gray-700 hover:text-gray-900 transition-colors" data-page="favorites-page">
                    <i class="fas fa-star w-4 text-center text-purple-500"></i>
                    <span class="text-sm font-medium">Favorites</span>
                </a>
            </li>
            <li>
                <a href="#" class="sidebar-menu flex items-center space-x-3 p-2.5 rounded-lg hover:bg-gray-50 text-gray-700 hover:text-gray-900 transition-colors" data-page="trash-page">
                    <i class="fas fa-trash w-4 text-center text-red-500"></i>
                    <span class="text-sm font-medium">Tong Sampah</span>
                </a>
            </li>
            <li>
                <a href="#" class="sidebar-menu flex items-center space-x-3 p-2.5 rounded-lg hover:bg-gray-50 text-gray-700 hover:text-gray-900 transition-colors" data-page="register-page">
                    <i class="fas fa-user-plus w-4 text-center text-indigo-500"></i>
                    <span class="text-sm font-medium">Daftar Karyawan</span>
                </a>
            </li>
        </ul>
    </nav>

    <!-- Bulk Actions Section -->
    <div class="mt-auto pt-4 space-y-3 border-t border-gray-100">
        <!-- Bulk Rename Form -->
        <div class="bg-purple-50 rounded-lg p-3">
            <form method="POST" action="{{ route('folders.bulk.rename') }}">
                @csrf
                @isset($folderPath)
                <input type="hidden" name="folderPath" value="{{ $folderPath }}">
                @endisset

                <div class="space-y-2">
                    <textarea id="bulk-renames" name="renames" rows="2" placeholder="old_path_1|new_name_1&#10;old_path_2|new_name_2" class="w-full text-xs border border-purple-200 bg-white p-2 rounded focus:ring-1 focus:ring-purple-300 focus:border-purple-300"></textarea>
                    <button type="submit" class="w-full bg-purple-600 hover:bg-purple-700 text-white px-3 py-2 rounded text-xs font-medium flex items-center justify-center shadow-sm transition-colors">
                        <i class="fas fa-pen mr-2 text-xs"></i> Rename Selected
                    </button>
                </div>
            </form>
        </div>

        <!-- Bulk Delete Form -->
        <div class="bg-red-50 rounded-lg p-3">
            <form method="POST" action="{{ route('folders.bulk.delete') }}">
                @csrf
                @method('DELETE')
                <div class="space-y-2">
                    <textarea name="selected_items[]" rows="2" placeholder="path/to/delete1&#10;path/to/delete2" class="w-full text-xs border border-red-200 bg-white p-2 rounded focus:ring-1 focus:ring-red-300 focus:border-red-300"></textarea>
                    <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white px-3 py-2 rounded text-xs font-medium flex items-center justify-center shadow-sm transition-colors">
                        <i class="fas fa-trash-alt mr-2 text-xs"></i> Delete Selected
                    </button>
                </div>
            </form>
        </div>
    </div>
</aside>