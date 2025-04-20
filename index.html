<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Archive Perusahaan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebarToggle = document.getElementById('sidebar-toggle');
            const sidebar = document.getElementById('sidebar');
            
            // Toggle sidebar di mobile
            sidebarToggle.addEventListener('click', function() {
                sidebar.classList.toggle('hidden');
                sidebar.classList.toggle('block');
            });

            // Fungsi untuk menampilkan halaman berdasarkan menu yang dipilih
            function showPage(pageId) {
                // Sembunyikan semua halaman
                document.querySelectorAll('.page-content').forEach(page => {
                    page.classList.add('hidden');
                });
                
                // Tampilkan halaman yang dipilih
                document.getElementById(pageId).classList.remove('hidden');
                
                // Update breadcrumb
                updateBreadcrumb(pageId);
                
                // Tutup sidebar di mobile
                if (window.innerWidth < 768) {
                    sidebar.classList.add('hidden');
                    sidebar.classList.remove('block');
                }
            }

            // Fungsi untuk update breadcrumb
            function updateBreadcrumb(pageId) {
                const breadcrumb = document.getElementById('breadcrumb');
                let html = '<a href="#" class="hover:text-blue-600">Archive</a>';
                
                switch(pageId) {
                    case 'dashboard-page':
                        html += '<span class="mx-1">/</span><a href="#" class="hover:text-blue-600">Dashboard</a>';
                        break;
                    case 'all-files-page':
                        html += '<span class="mx-1">/</span><a href="#" class="hover:text-blue-600">Semua File</a>';
                        break;
                    case 'shared-page':
                        html += '<span class="mx-1">/</span><a href="#" class="hover:text-blue-600">Shared</a>';
                        break;
                    case 'recent-page':
                        html += '<span class="mx-1">/</span><a href="#" class="hover:text-blue-600">Recent</a>';
                        break;
                    case 'favorites-page':
                        html += '<span class="mx-1">/</span><a href="#" class="hover:text-blue-600">Favorites</a>';
                        break;
                    case 'trash-page':
                        html += '<span class="mx-1">/</span><a href="#" class="hover:text-blue-600">Trash</a>';
                        break;
                    default:
                        html += '<span class="mx-1">/</span><a href="#" class="hover:text-blue-600">Dashboard</a>';
                }
                
                breadcrumb.innerHTML = html;
            }

            // Tambahkan event listener untuk setiap menu sidebar
            document.querySelectorAll('.sidebar-menu').forEach(menu => {
                menu.addEventListener('click', function(e) {
                    e.preventDefault();
                    const pageId = this.getAttribute('data-page');
                    showPage(pageId);
                    
                    // Update active menu
                    document.querySelectorAll('.sidebar-menu').forEach(m => {
                        m.classList.remove('bg-blue-100', 'text-blue-600');
                        m.classList.add('hover:bg-gray-100');
                    });
                    this.classList.add('bg-blue-100', 'text-blue-600');
                    this.classList.remove('hover:bg-gray-100');
                });
            });

            // Tampilkan halaman default (Dashboard)
            showPage('dashboard-page');
            document.querySelector('[data-page="dashboard-page"]').classList.add('bg-blue-100', 'text-blue-600');
            document.querySelector('[data-page="dashboard-page"]').classList.remove('hover:bg-gray-100');
        });
    </script>
</head>
<body class="bg-gray-50">
    <div class="min-h-screen flex flex-col">
        <!-- Header -->
        <header class="bg-blue-600 text-white shadow-md">
            <div class="container mx-auto px-4 py-3 flex justify-between items-center">
                <div class="flex items-center space-x-2">
                    <button id="sidebar-toggle" class="md:hidden mr-2">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                    <i class="fas fa-archive text-2xl"></i>
                    <h1 class="text-xl font-bold">Archive Perusahaan</h1>
                </div>
                <div class="flex items-center space-x-4">
                    <div class="relative">
                        <input type="text" placeholder="Cari file..." class="py-1 px-3 pr-8 rounded-full text-gray-800 text-sm w-40 md:w-64 focus:outline-none">
                        <i class="fas fa-search absolute right-3 top-2 text-gray-500"></i>
                    </div>
                    <div class="w-8 h-8 rounded-full bg-blue-500 flex items-center justify-center">
                        <span class="text-sm font-medium">AD</span>
                    </div>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="flex-grow container mx-auto px-4 py-6 flex flex-col md:flex-row">
            <!-- Sidebar - Hidden on mobile by default -->
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
                                <span>Trash</span>
                            </a>
                        </li>
                    </ul>
                </nav>

                <div class="mt-8">
                    <h3 class="font-medium text-gray-500 text-sm mb-2">Kategori</h3>
                    <ul class="space-y-1">
                        <li><a href="#" class="text-sm p-2 block rounded-lg hover:bg-gray-100">Keuangan</a></li>
                        <li><a href="#" class="text-sm p-2 block rounded-lg hover:bg-gray-100">HRD</a></li>
                        <li><a href="#" class="text-sm p-2 block rounded-lg hover:bg-gray-100">Proyek</a></li>
                        <li><a href="#" class="text-sm p-2 block rounded-lg hover:bg-gray-100">Legal</a></li>
                    </ul>
                </div>
            </aside>

            <!-- File Content -->
            <section class="flex-grow bg-white rounded-lg shadow-md p-4">
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

                <!-- Halaman Semua File -->
                <div id="all-files-page" class="page-content hidden">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ukuran</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Diubah</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <!-- Folder -->
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <i class="fas fa-folder text-yellow-400 mr-3"></i>
                                            <span class="text-sm font-medium">Laporan Keuangan 2023</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">-</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">15 Jan 2024</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <button class="text-blue-600 hover:text-blue-900 mr-3"><i class="fas fa-share-alt"></i></button>
                                        <button class="text-gray-600 hover:text-gray-900"><i class="fas fa-ellipsis-v"></i></button>
                                    </td>
                                </tr>

                                <!-- Files -->
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <i class="fas fa-file-pdf text-red-500 mr-3"></i>
                                            <span class="text-sm font-medium">Laporan Tahunan 2023.pdf</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">2.4 MB</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">10 Jan 2024</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <button class="text-blue-600 hover:text-blue-900 mr-3"><i class="fas fa-share-alt"></i></button>
                                        <button class="text-gray-600 hover:text-gray-900"><i class="fas fa-ellipsis-v"></i></button>
                                    </td>
                                </tr>

                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <i class="fas fa-file-excel text-green-600 mr-3"></i>
                                            <span class="text-sm font-medium">Data Karyawan.xlsx</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">1.8 MB</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">5 Jan 2024</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <button class="text-blue-600 hover:text-blue-900 mr-3"><i class="fas fa-share-alt"></i></button>
                                        <button class="text-gray-600 hover:text-gray-900"><i class="fas fa-ellipsis-v"></i></button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="mt-6 flex justify-between items-center">
                        <div class="text-sm text-gray-500">
                            Menampilkan 1-3 dari 10 item
                        </div>
                        <div class="flex space-x-1">
                            <button class="px-3 py-1 border rounded-md text-sm bg-white hover:bg-gray-50">
                                <i class="fas fa-chevron-left"></i>
                            </button>
                            <button class="px-3 py-1 border rounded-md text-sm bg-blue-600 text-white">1</button>
                            <button class="px-3 py-1 border rounded-md text-sm bg-white hover:bg-gray-50">2</button>
                            <button class="px-3 py-1 border rounded-md text-sm bg-white hover:bg-gray-50">3</button>
                            <button class="px-3 py-1 border rounded-md text-sm bg-white hover:bg-gray-50">
                                <i class="fas fa-chevron-right"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Halaman Shared -->
                <div id="shared-page" class="page-content hidden">
                    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-6 text-center">
                        <i class="fas fa-share-alt text-yellow-500 text-4xl mb-3"></i>
                        <h3 class="text-xl font-medium text-gray-800 mb-2">File yang Dibagikan</h3>
                        <p class="text-gray-600">Daftar file yang telah dibagikan dengan Anda</p>
                    </div>
                </div>

                <!-- Halaman Recent -->
                <div id="recent-page" class="page-content hidden">
                    <div class="bg-purple-50 border border-purple-200 rounded-lg p-6 text-center">
                        <i class="fas fa-clock text-purple-500 text-4xl mb-3"></i>
                        <h3 class="text-xl font-medium text-gray-800 mb-2">File Terakhir Diakses</h3>
                        <p class="text-gray-600">Daftar file yang baru saja Anda buka</p>
                    </div>
                </div>

                <!-- Halaman Favorites -->
                <div id="favorites-page" class="page-content hidden">
                    <div class="bg-pink-50 border border-pink-200 rounded-lg p-6 text-center">
                        <i class="fas fa-star text-pink-500 text-4xl mb-3"></i>
                        <h3 class="text-xl font-medium text-gray-800 mb-2">File Favorit</h3>
                        <p class="text-gray-600">Daftar file yang telah Anda tandai sebagai favorit</p>
                    </div>
                </div>

                <!-- Halaman Trash -->
                <div id="trash-page" class="page-content hidden">
                    <div class="bg-red-50 border border-red-200 rounded-lg p-6 text-center">
                        <i class="fas fa-trash text-red-500 text-4xl mb-3"></i>
                        <h3 class="text-xl font-medium text-gray-800 mb-2">Tong Sampah</h3>
                        <p class="text-gray-600">File yang telah dihapus akan disimpan di sini selama 30 hari</p>
                    </div>
                </div>
            </section>
        </main>

        <!-- Footer -->
        <footer class="bg-white border-t py-4">
            <div class="container mx-auto px-4 text-center text-sm text-gray-500">
                &copy; 2024 Archive Perusahaan. All rights reserved.
            </div>
        </footer>
    </div>
</body>
</html>