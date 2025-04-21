@extends('layouts.app')

@section('content')
    <!-- Page Title & Action -->
    <div class="flex justify-between items-center mb-6">
        <h2 id="page-title" class="text-lg font-semibold">Dashboard</h2>
        <div class="flex space-x-2">
            <button class="bg-blue-600 text-white px-3 py-1 rounded-md text-sm hover:bg-blue-700 flex items-center">
                <i class="fas fa-plus mr-1"></i> Upload
            </button>
            <button class="border border-gray-300 px-3 py-1 rounded-md text-sm hover:bg-gray-100 flex items-center">
                <i class="fas fa-folder mr-1"></i> Folder Baru
            </button>
        </div>
    </div>

    <!-- Breadcrumb -->
    <div id="breadcrumb" class="flex items-center text-sm text-gray-600 mb-4">
        <a href="#" class="hover:text-blue-600">Archive</a>
        <span class="mx-1">/</span>
        <a href="#" class="hover:text-blue-600">Dashboard</a>
    </div>

    <!-- Halaman Dashboard -->
    <div id="dashboard-page" class="page-content">
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-6 text-center">
            <i class="fas fa-home text-blue-500 text-4xl mb-3"></i>
            <h3 class="text-xl font-medium text-gray-800 mb-2">Selamat Datang di Sistem Archive</h3>
            <p class="text-gray-600">Pilih menu di sidebar untuk melihat konten</p>
        </div>
    </div>

    <!-- Halaman lainnya -->
    @include('archive.pages.all-files')
    @include('archive.pages.shared')
    @include('archive.pages.recent')
    @include('archive.pages.favorites')
    @include('archive.pages.trash')
    @include('archive.pages.register')

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const sidebarToggle = document.getElementById('sidebar-toggle');
    const sidebar = document.getElementById('sidebar');

    // Toggle sidebar di mobile
    if (sidebarToggle && sidebar) {
        sidebarToggle.addEventListener('click', function () {
            sidebar.classList.toggle('hidden');
            sidebar.classList.toggle('block');
        });
    }

    function showPage(pageId) {
        const page = document.getElementById(pageId);
        if (!page) return;

        document.querySelectorAll('.page-content').forEach(p => p.classList.add('hidden'));
        page.classList.remove('hidden');
        updateBreadcrumb(pageId);

        if (window.innerWidth < 768 && sidebar) {
            sidebar.classList.add('hidden');
            sidebar.classList.remove('block');
        }
    }

    function updateBreadcrumb(pageId) {
        const breadcrumb = document.getElementById('breadcrumb');
        if (!breadcrumb) return;
        let html = '<a href="#" class="hover:text-blue-600">Archive</a>';
        const names = {
            'dashboard-page': 'Dashboard',
            'all-files-page': 'Semua File',
            'shared-page': 'Shared',
            'recent-page': 'Recent',
            'favorites-page': 'Favorites',
            'trash-page': 'Trash',
            'register-page': 'Daftar Karyawan'


        };
        const name = names[pageId] || 'Dashboard';
        html += `<span class="mx-1">/</span><a href="#" class="hover:text-blue-600">${name}</a>`;
        breadcrumb.innerHTML = html;
        const title = document.getElementById('page-title');
        if (title) title.innerText = name;
    }

    document.querySelectorAll('.sidebar-menu').forEach(menu => {
        menu.addEventListener('click', function (e) {
            e.preventDefault();
            const pageId = this.getAttribute('data-page');
            showPage(pageId);
            document.querySelectorAll('.sidebar-menu').forEach(m => {
                m.classList.remove('bg-blue-100', 'text-blue-600');
                m.classList.add('hover:bg-gray-100');
            });
            this.classList.add('bg-blue-100', 'text-blue-600');
            this.classList.remove('hover:bg-gray-100');
        });
    });

    // Show default
    showPage('dashboard-page');
    const defaultMenu = document.querySelector('[data-page="dashboard-page"]');
    if (defaultMenu) {
        defaultMenu.classList.add('bg-blue-100', 'text-blue-600');
        defaultMenu.classList.remove('hover:bg-gray-100');
    }
});
</script>
@endpush
