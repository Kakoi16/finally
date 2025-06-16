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
<<<<<<< HEAD
=======
    </div>
@endif

    <!-- Page Title & Action -->
    <div class="flex justify-between items-center mb-6">
        <h2 id="page-title" class="text-lg font-semibold">Dashboard</h2>
>>>>>>> 365f2682a4a0ba76b17f51277b96827dd8b5a819
    </div>
@endif

  
  <!-- Halaman Dashboard -->
  <div id="dashboard-page" class="page-content">
        <div class="bg-gradient-to-r from-blue-50 to-indigo-50 border border-blue-200 rounded-lg p-6 text-center shadow-md hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1">
            <div class="flex flex-col items-center">
                <div class="bg-blue-100 p-4 rounded-full mb-4">
                    <i class="fas fa-home text-blue-600 text-4xl"></i>
                </div>
                <h3 class="text-2xl font-bold text-gray-800 mb-3">Selamat Datang di Sistem Archive</h3>
                <p class="text-gray-600 max-w-md mx-auto">Pilih menu di sidebar untuk melihat konten</p>
                <div class="mt-6 flex flex-wrap justify-center gap-4">
                    <button class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-colors flex items-center">
                        <i class="fas fa-folder-open mr-2"></i> Jelajahi File
                    </button>
                    <button class="px-4 py-2 bg-indigo-500 text-white rounded-lg hover:bg-indigo-600 transition-colors flex items-center">
                        <i class="fas fa-plus mr-2"></i> Buat Baru
                    </button>
                </div>
            </div>
        </div>
    </div>
    <a href="{{ route('archive.trash') }}"
   class="inline-flex items-center hidden px-4 py-2 bg-red-600 text-white text-sm font-medium rounded hover:bg-red-700">
    <i class="fas fa-trash mr-2"></i> Lihat Tong Sampah
</a>

    <!-- Halaman lainnya -->
    @include('archive.pages.all-files')
@include('archive.pages.shared')
@include('archive.pages.create-files')
@include('archive.pages.recent')
@include('archive.pages.trash')
@include('archive.pages.submission')
@include('archive.pages.register')
@include('archive.pages.users')


@endsection

@push('scripts')
<script>

document.addEventListener('DOMContentLoaded', function () {
    const sidebarToggle = document.getElementById('sidebar-toggle');
    const sidebar = document.getElementById('sidebar');
    const actionCards = document.getElementById('action-cards');

    if (sidebarToggle) {
        sidebarToggle.addEventListener('click', function () {
            // Periksa apakah sedang di subfolder (action-cards terlihat)
            if (actionCards && !actionCards.classList.contains('hidden')) {
                // Toggle action-cards
                actionCards.classList.toggle('hidden');
                actionCards.classList.toggle('block');
            } else if (sidebar) {
                // Toggle sidebar
                sidebar.classList.toggle('hidden');
                sidebar.classList.toggle('block');
            }
        });
    }

    function showPage(pageId) {
    const page = document.getElementById(pageId);
    if (!page) return;

    document.querySelectorAll('.page-content').forEach(p => p.classList.add('hidden'));
    page.classList.remove('hidden');
    updateBreadcrumb(pageId);

    const activityName = {
        'dashboard-page': 'Buka Beranda',
        'all-files-page': 'Buka Semua File',
        'create-page': 'Buka untuk membuat template',
        'shared-page': 'Buka Berbagi',
        'recent-page': 'Buka Aktivitas',
        'submission-page': 'Buka Pengajuan surat',
        'trash-page': 'Buka Sampah',
        'register-page': 'Buka Daftar Karyawan',
        'user-page': 'Buka Semua Akun Karyawan'
    }[pageId] || `Buka ${pageId}`;

    fetch("/public/log-activity", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": "{{ csrf_token() }}"
        },
        body: JSON.stringify({
            activity: activityName,
            url: window.location.href
        })
    });

    // Toggle Bulk Actions
    const bulkActions = document.getElementById('bulk-actions-section');
    if (bulkActions) {
        if (pageId === 'all-files-page') {
            bulkActions.classList.remove('hidden');
            bulkActions.classList.add('block');
        } else {
            bulkActions.classList.add('hidden');
            bulkActions.classList.remove('block');
        }
    }

    if (window.innerWidth < 768 && sidebar) {
        sidebar.classList.add('hidden');
        sidebar.classList.remove('block');
    }
}



    function updateBreadcrumb(pageId) {
        const breadcrumb = document.getElementById('breadcrumb');
        if (!breadcrumb) return;
        let html = '<a href="#" class="hover:text-blue-600 transition-colors">Archive</a>';
        const names = {
            'dashboard-page': 'Beranda',
            'all-files-page': 'Semua File',
            'create-page': 'Buka untuk membuat template',
            'shared-page': 'Berbagi',
            'recent-page': 'Terbaru',
            'submission-page': 'Pengajuan Surat',
            'trash-page': 'Sampah',
            'register-page': 'Daftar Karyawan',
        'user-page': 'Buka Semua Akun Karyawan'


        };
        const name = names[pageId] || 'Dashboard';
        html += `<span class="mx-1">/</span><a href="#" class="hover:text-blue-600 transition-colors">${name}</a>`;
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
    
    // Add responsive behavior
    function handleResponsive() {
        const width = window.innerWidth;
        const contentArea = document.querySelector('.page-content');
        
        if (width < 640) { // Small screens
            if (contentArea) contentArea.classList.add('px-2', 'py-2');
        } else {
            if (contentArea) contentArea.classList.remove('px-2', 'py-2');
        }
    }
    
    // Initial call and event listener for resize
    handleResponsive();
    window.addEventListener('resize', handleResponsive);
});
</script>
@endpush
