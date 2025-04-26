<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Arsip Perusahaan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .parallax {
            background-attachment: fixed;
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
        }
    </style>
</head>
<body class="font-sans bg-gray-50">
    <!-- Navigasi -->
    <nav class="bg-blue-800 text-white shadow-lg fixed w-full z-10">
        <div class="container mx-auto px-4 py-3 flex justify-between items-center">
            <div class="flex items-center space-x-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                </svg>
                <span class="text-xl font-bold">ArsipKu</span>
            </div>
            
            <!-- Desktop Menu -->
            <div class="hidden md:flex space-x-6">
                <a href="#" class="hover:text-blue-200 transition duration-300">Beranda</a>
                <a href="#" class="hover:text-blue-200 transition duration-300">Arsip</a>
                <a href="#" class="hover:text-blue-200 transition duration-300">Kategori</a>
                <a href="#" class="hover:text-blue-200 transition duration-300">Tentang</a>
            </div>
            
            <div class="flex items-center space-x-4">
                <a href="/login" class="hidden md:block bg-blue-600 hover:bg-blue-700 px-4 py-2 rounded-lg transition duration-300">Login</a>
                <!-- Mobile menu button -->
                <button id="mobile-menu-button" class="md:hidden focus:outline-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>
        </div>
        
        <!-- Mobile Menu (Hidden by default) -->
        <div id="mobile-menu" class="md:hidden hidden bg-blue-700">
            <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3">
                <a href="#" class="block px-3 py-2 rounded-md text-base font-medium hover:bg-blue-600">Beranda</a>
                <a href="#" class="block px-3 py-2 rounded-md text-base font-medium hover:bg-blue-600">Arsip</a>
                <a href="#" class="block px-3 py-2 rounded-md text-base font-medium hover:bg-blue-600">Kategori</a>
                <a href="#" class="block px-3 py-2 rounded-md text-base font-medium hover:bg-blue-600">Tentang</a>
                <a href="/login" class="block px-3 py-2 rounded-md text-base font-medium bg-blue-600 hover:bg-blue-500">Login</a>
            </div>
        </div>
    </nav>

    <!-- Hero Section dengan Parallax -->
    <section class="parallax h-screen flex items-center justify-center pt-16" style="background-image: url('https://images.unsplash.com/photo-1450101499163-c8848c66ca85?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80');">
        <div class="bg-black bg-opacity-50 p-8 rounded-lg max-w-2xl mx-4">
            <h1 class="text-4xl md:text-5xl font-bold text-white mb-4">Sistem Arsip Digital Perusahaan</h1>
            <p class="text-xl text-gray-200 mb-6">Kelola dokumen perusahaan Anda dengan aman dan terorganisir</p>
            <button class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg text-lg font-semibold">Mulai Jelajahi Arsip</button>
        </div>
    </section>

    <!-- Fitur -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold text-center text-gray-800 mb-12">Fitur Unggulan</h2>
            
            <div class="grid md:grid-cols-3 gap-8">
                <!-- Fitur 1 -->
                <div class="bg-gray-50 p-6 rounded-lg shadow-md hover:shadow-lg transition-shadow">
                    <div class="text-blue-600 mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-2 text-gray-800">Klasifikasi Dokumen</h3>
                    <p class="text-gray-600">Organisir dokumen berdasarkan kategori dan jenis untuk memudahkan pencarian.</p>
                </div>
                
                <!-- Fitur 2 -->
                <div class="bg-gray-50 p-6 rounded-lg shadow-md hover:shadow-lg transition-shadow">
                    <div class="text-blue-600 mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-2 text-gray-800">Pencarian Cepat</h3>
                    <p class="text-gray-600">Temukan dokumen yang Anda butuhkan dalam hitungan detik dengan fitur pencarian canggih.</p>
                </div>
                
                <!-- Fitur 3 -->
                <div class="bg-gray-50 p-6 rounded-lg shadow-md hover:shadow-lg transition-shadow">
                    <div class="text-blue-600 mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-2 text-gray-800">Keamanan Data</h3>
                    <p class="text-gray-600">Dokumen perusahaan Anda terlindungi dengan sistem keamanan berlapis.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Parallax Section 2 -->
    <section class="parallax h-64 flex items-center justify-center" style="background-image: url('https://images.unsplash.com/photo-1551288049-bebda4e38f71?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80');">
        <div class="bg-black bg-opacity-50 p-6 rounded-lg max-w-3xl mx-4">
            <h2 class="text-2xl md:text-3xl font-bold text-white text-center">Lebih dari 10.000 Dokumen Telah Diarsipkan</h2>
        </div>
    </section>

    <!-- Arsip Terbaru -->
    <section class="py-16 bg-gray-50">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold text-center text-gray-800 mb-12">Arsip Terbaru</h2>
            
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Dokumen 1 -->
                <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-transform hover:-translate-y-1">
                    <div class="bg-blue-100 p-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <div class="p-4">
                        <h3 class="font-semibold text-lg mb-2 text-gray-800">Laporan Keuangan Q1 2023</h3>
                        <p class="text-gray-600 text-sm mb-3">Diupload: 15 April 2023</p>
                        <div class="flex justify-between items-center">
                            <span class="bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded">Keuangan</span>
                            <button class="text-blue-600 hover:text-blue-800 text-sm font-medium">Lihat Detail</button>
                        </div>
                    </div>
                </div>
                
                <!-- Dokumen 2 -->
                <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-transform hover:-translate-y-1">
                    <div class="bg-green-100 p-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <div class="p-4">
                        <h3 class="font-semibold text-lg mb-2 text-gray-800">Rapat Direksi Mei 2023</h3>
                        <p class="text-gray-600 text-sm mb-3">Diupload: 10 Mei 2023</p>
                        <div class="flex justify-between items-center">
                            <span class="bg-green-100 text-green-800 text-xs px-2 py-1 rounded">Rapat</span>
                            <button class="text-blue-600 hover:text-blue-800 text-sm font-medium">Lihat Detail</button>
                        </div>
                    </div>
                </div>
                
                <!-- Dokumen 3 -->
                <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-transform hover:-translate-y-1">
                    <div class="bg-purple-100 p-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <div class="p-4">
                        <h3 class="font-semibold text-lg mb-2 text-gray-800">Kontrak Kerja Vendor</h3>
                        <p class="text-gray-600 text-sm mb-3">Diupload: 5 Mei 2023</p>
                        <div class="flex justify-between items-center">
                            <span class="bg-purple-100 text-purple-800 text-xs px-2 py-1 rounded">Hukum</span>
                            <button class="text-blue-600 hover:text-blue-800 text-sm font-medium">Lihat Detail</button>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="text-center mt-10">
                <button class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-medium">Lihat Semua Arsip</button>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-10">
        <div class="container mx-auto px-4">
            <div class="grid md:grid-cols-4 gap-8">
                <div>
                    <h3 class="text-xl font-bold mb-4">ArsipKu</h3>
                    <p class="text-gray-400">Sistem manajemen arsip digital untuk perusahaan modern.</p>
                </div>
                <div>
                    <h4 class="font-semibold mb-4">Tautan Cepat</h4>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-400 hover:text-white">Beranda</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white">Tentang Kami</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white">Kebijakan Privasi</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white">Syarat & Ketentuan</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-semibold mb-4">Kontak</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li>Jl. Arsip No. 123, Jakarta</li>
                        <li>info@arsipku.com</li>
                        <li>+62 123 4567 890</li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-semibold mb-4">Berlangganan</h4>
                    <p class="text-gray-400 mb-2">Dapatkan pembaruan terbaru dari kami.</p>
                    <div class="flex">
                        <input type="email" placeholder="Email Anda" class="px-3 py-2 bg-gray-700 text-white rounded-l focus:outline-none w-full">
                        <button class="bg-blue-600 hover:bg-blue-700 px-4 py-2 rounded-r">Kirim</button>
                    </div>
                </div>
            </div>
            <div class="border-t border-gray-700 mt-8 pt-6 text-center text-gray-400">
                <p>&copy; 2023 ArsipKu. Semua hak dilindungi.</p>
            </div>
        </div>
    </footer>
    
    <script>
        // Toggle mobile menu
        const mobileMenuButton = document.getElementById('mobile-menu-button');
        const mobileMenu = document.getElementById('mobile-menu');
        
        mobileMenuButton.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
        });
    </script>
</body>
</html>