@extends('layouts.app')

@section('content')
@if(session('success'))
    <div 
        x-data="{ show: true }" 
        x-show="show" 
        x-transition 
        class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mt-4 max-w-lg mx-auto shadow"
        role="alert"
    >
        <strong class="font-bold">Berhasil!</strong>
        <span class="block sm:inline">{{ session('success') }}</span>
        <span 
            class="absolute top-0 bottom-0 right-0 px-4 py-3 cursor-pointer"
            @click="show = false"
        >
            <svg class="fill-current h-6 w-6 text-green-700" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                <title>Close</title>
                <path d="M14.348 5.652a1 1 0 0 0-1.414 0L10 8.586 7.066 5.652a1 1 0 1 0-1.414 1.414L8.586 10l-2.934 2.934a1 1 0 1 0 1.414 1.414L10 11.414l2.934 2.934a1 1 0 0 0 1.414-1.414L11.414 10l2.934-2.934a1 1 0 0 0 0-1.414z"/>
            </svg>
        </span>
    </div>
@endif

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
    @include('archive.pages.submission')
    @include('archive.pages.trash')
    @include('archive.pages.register')

@endsection

@push('scripts')
<script>
   
   document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.open-folder').forEach(icon => {
            icon.addEventListener('click', function (e) {
                e.preventDefault();
                
                const folderPath = this.getAttribute('data-path');
                const container = document.getElementById('subfolders-' + folderPath);

                fetch(`/folders/${folderPath}`)
                    .then(response => response.text())
                    .then(html => {
                        container.innerHTML = html;
                    })
                    .catch(error => {
                        console.error('Failed to load subfolders:', error);
                        container.innerHTML = '<p class="text-red-500">Error loading subfolders.</p>';
                    });
            });
        });
    });

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
        // Hanya tampilkan halaman yang dipilih
        const page = document.getElementById(pageId);
        if (!page) return;

        // Sembunyikan semua halaman terlebih dahulu
        document.querySelectorAll('.page-content').forEach(p => p.classList.add('hidden'));
        // Tampilkan halaman yang dipilih
        page.classList.remove('hidden');

        // Perbarui breadcrumb
        updateBreadcrumb(pageId);

        // Untuk tampilan mobile, sembunyikan sidebar
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
            'submission-page': 'submission',
            'trash-page': 'Trash',
            'register-page': 'Daftar Karyawan'
        };
        const name = names[pageId] || 'Dashboard';
        html += `<span class="mx-1">/</span><a href="#" class="hover:text-blue-600">${name}</a>`;
        breadcrumb.innerHTML = html;

        // Update judul halaman
        const title = document.getElementById('page-title');
        if (title) title.innerText = name;
    }

    // Menambahkan event listener pada menu sidebar
    document.querySelectorAll('.sidebar-menu').forEach(menu => {
        menu.addEventListener('click', function (e) {
            e.preventDefault();
            const pageId = this.getAttribute('data-page');

            // Tampilkan halaman yang dipilih
            showPage(pageId);

            // Update status aktif pada menu sidebar
            document.querySelectorAll('.sidebar-menu').forEach(m => {
                m.classList.remove('bg-blue-100', 'text-blue-600');
                m.classList.add('hover:bg-gray-100');
            });

            this.classList.add('bg-blue-100', 'text-blue-600');
            this.classList.remove('hover:bg-gray-100');
        });
    });

    // Show default page (Dashboard) saat pertama kali halaman dimuat
    showPage('dashboard-page');
    const defaultMenu = document.querySelector('[data-page="dashboard-page"]');
    if (defaultMenu) {
        defaultMenu.classList.add('bg-blue-100', 'text-blue-600');
        defaultMenu.classList.remove('hover:bg-gray-100');
    }

    // Handling URL hash (e.g. for /folders/{folderName}#)
    window.addEventListener('hashchange', function () {
        const folderName = window.location.hash.substring(1); // Ambil bagian setelah '#'
        if (folderName) {
            // Logika untuk menampilkan halaman folder
            showPage(folderName);
        }
    });
});

</script>
@endpush