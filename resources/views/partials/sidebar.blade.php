<aside id="sidebar" class="hidden md:block w-full md:w-64 bg-white rounded-lg shadow-md p-4 mb-4 md:mb-0 md:mr-4">
    <nav>
        <ul class="space-y-2">
            <li>
                <a href="#" class="sidebar-menu flex items-center space-x-2 p-2 rounded-lg hover:bg-gray-100" data-page="dashboard-page">
                    <i class="fas fa-home w-5"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li>
                <a href="#" class="sidebar-menu flex items-center space-x-2 p-2 rounded-lg hover:bg-gray-100" data-page="all-files-page">
                    <i class="fas fa-folder w-5"></i>
                    <span>Semua File</span>
                </a>
            </li>
            <li>
                <a href="#" class="sidebar-menu flex items-center space-x-2 p-2 rounded-lg hover:bg-gray-100" data-page="shared-page">
                    <i class="fas fa-share-alt w-5"></i>
                    <span>Shared</span>
                </a>
            </li>
            <li>
                <a href="#" class="sidebar-menu flex items-center space-x-2 p-2 rounded-lg hover:bg-gray-100" data-page="recent-page">
                    <i class="fas fa-clock w-5"></i>
                    <span>Recent</span>
                </a>
            </li>
            <li>
                <a href="#" class="sidebar-menu flex items-center space-x-2 p-2 rounded-lg hover:bg-gray-100" data-page="favorites-page">
                    <i class="fas fa-star w-5"></i>
                    <span>Favorites</span>
                </a>
            </li>
            <li>
                <a href="#" class="sidebar-menu flex items-center space-x-2 p-2 rounded-lg hover:bg-gray-100" data-page="trash-page">
                    <i class="fas fa-trash w-5"></i>
                    <span>Tong Sampah</span>
                </a>
            </li>
            <li>
    <a href="#" class="sidebar-menu flex items-center space-x-2 p-2 rounded-lg hover:bg-gray-100" data-page="register-page">
        <i class="fas fa-user-plus w-5"></i>
        <span>Daftar Karyawan</span>
    </a>
</li>

        </ul>
    </nav>

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
                        <textarea name="selected_items[]" rows="3" placeholder="path/to/delete1\npath/to/delete2" class="w-full text-sm border border-red-300 p-2 rounded-lg"></textarea>
                        <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white px-4 py-2.5 rounded-lg text-sm font-medium flex items-center justify-center shadow-sm">
                            Delete Selected
                        </button>
                    </div>
                </form>

            </div>
</aside>
