<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Harmoni Event - Penyelenggara Acara Profesional</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#f0f4ff',
                            100: '#e0e9ff',
                            200: '#c7d7fe',
                            300: '#a5b8fc',
                            400: '#8191f8',
                            500: '#667eea',
                            600: '#5468d6',
                            700: '#4553b5',
                            800: '#3b4492',
                            900: '#343d75',
                        },
                        secondary: {
                            50: '#f9f0ff',
                            100: '#f3e0ff',
                            200: '#e7c2ff',
                            300: '#d694ff',
                            400: '#c45cff',
                            500: '#a855f7',
                            600: '#9333ea',
                            700: '#7e22ce',
                            800: '#6b21a8',
                            900: '#591c87',
                        },
                        dark: {
                            900: '#0f172a',
                            800: '#1e293b',
                            700: '#334155',
                        }
                    }
                }
            }
        }
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #3b4492 0%, #591c87 100%);
        }
        .glass-card {
            background: rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.15);
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.15);
        }
        .glass-nav {
            background: rgba(15, 23, 42, 0.7);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
        .event-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.15), 0 10px 10px -5px rgba(0, 0, 0, 0.05);
        }
        .mobile-menu {
            transition: all 0.3s ease;
        }
        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #a855f7 100%);
            color: white;
            transition: all 0.3s ease;
        }
        .btn-primary:hover {
            background: linear-gradient(135deg, #5468d6 0%, #9333ea 100%);
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.2);
        }
        .btn-outline {
            border: 1px solid rgba(255, 255, 255, 0.3);
            transition: all 0.3s ease;
        }
        .btn-outline:hover {
            border-color: rgba(255, 255, 255, 0.5);
            background: rgba(255, 255, 255, 0.05);
        }
    </style>
</head>
<body class="min-h-screen text-white">
    <!-- Navigation -->
    <nav class="glass-nav fixed w-full z-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <div class="flex items-center">
                    <span class="text-xl font-bold text-white">Harmoni Event</span>
                </div>
                <div class="hidden md:block">
                    <div class="ml-10 flex items-baseline space-x-4">
                        <a href="#" class="px-3 py-2 rounded-md text-sm font-medium text-white bg-white bg-opacity-10">Beranda</a>
                        <a href="#" class="px-3 py-2 rounded-md text-sm font-medium text-white hover:bg-white hover:bg-opacity-10">Acara</a>
                        <a href="#" class="px-3 py-2 rounded-md text-sm font-medium text-white hover:bg-white hover:bg-opacity-10">Layanan</a>
                        <a href="#" class="px-3 py-2 rounded-md text-sm font-medium text-white hover:bg-white hover:bg-opacity-10">Galeri</a>
                        <a href="#" class="px-3 py-2 rounded-md text-sm font-medium text-white hover:bg-white hover:bg-opacity-10">Kontak</a>
                        <a href="/login" class="px-3 py-2 rounded-md text-sm font-medium text-white hover:bg-white hover:bg-opacity-10">Masuk</a>
                        <a href="/register" class="px-3 py-2 rounded-md text-sm font-medium text-white btn-primary">Daftar</a>
                    </div>
                </div>
                <div class="md:hidden">
                    <button id="mobile-menu-button" class="p-2 rounded-md hover:bg-white hover:bg-opacity-10 focus:outline-none">
                        <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
        
        <!-- Mobile Menu -->
        <div id="mobile-menu" class="mobile-menu hidden md:hidden glass-nav">
            <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3">
                <a href="#" class="block px-3 py-2 rounded-md text-base font-medium text-white bg-white bg-opacity-10">Beranda</a>
                <a href="#" class="block px-3 py-2 rounded-md text-base font-medium text-white hover:bg-white hover:bg-opacity-10">Acara</a>
                <a href="#" class="block px-3 py-2 rounded-md text-base font-medium text-white hover:bg-white hover:bg-opacity-10">Layanan</a>
                <a href="#" class="block px-3 py-2 rounded-md text-base font-medium text-white hover:bg-white hover:bg-opacity-10">Galeri</a>
                <a href="#" class="block px-3 py-2 rounded-md text-base font-medium text-white hover:bg-white hover:bg-opacity-10">Kontak</a>
                <a href="/login" class="block px-3 py-2 rounded-md text-base font-medium text-white hover:bg-white hover:bg-opacity-10">Masuk</a>
                <a href="/register" class="block px-3 py-2 rounded-md text-base font-medium text-white btn-primary">Daftar</a>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="pt-32 pb-20 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            <div class="glass-card rounded-2xl p-8 md:p-12">
                <div class="md:flex md:items-center md:justify-between">
                    <div class="md:w-1/2">
                        <h1 class="text-4xl md:text-5xl font-bold mb-4 text-white">Ciptakan Acara Tak Terlupakan</h1>
                        <p class="text-lg mb-8 text-white text-opacity-90">Kami merancang dan melaksanakan acara luar biasa yang meninggalkan kesan mendalam. Dari pertemuan perusahaan hingga pernikahan impian.</p>
                        <div class="flex space-x-4">
                            <button class="btn-primary px-6 py-3 rounded-lg font-medium">Konsultasi Gratis</button>
                            <button class="btn-outline px-6 py-3 rounded-lg font-medium">Lihat Portofolio</button>
                        </div>
                    </div>
                    <div class="hidden md:block md:w-2/5 mt-8 md:mt-0">
                        <img src="https://images.unsplash.com/photo-1511578314322-379afb476865?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60" alt="Persiapan acara" class="rounded-xl shadow-xl">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section class="py-16 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            <h2 class="text-3xl font-bold text-center mb-12 text-white">Layanan Unggulan Kami</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Layanan 1 -->
                <div class="glass-card rounded-2xl p-6 transition duration-300 hover:bg-opacity-20">
                    <div class="bg-white bg-opacity-10 w-16 h-16 rounded-full flex items-center justify-center mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-2 text-white">Perencanaan Acara</h3>
                    <p class="text-white text-opacity-90">Desain dan koordinasi acara lengkap dari konsep hingga eksekusi, memastikan setiap detail sempurna.</p>
                </div>
                
                <!-- Layanan 2 -->
                <div class="glass-card rounded-2xl p-6 transition duration-300 hover:bg-opacity-20">
                    <div class="bg-white bg-opacity-10 w-16 h-16 rounded-full flex items-center justify-center mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-2 text-white">Pencarian Venue</h3>
                    <p class="text-white text-opacity-90">Akses ke venue eksklusif dan hubungan dengan lokasi terbaik untuk menemukan tempat sempurna untuk acara Anda.</p>
                </div>
                
                <!-- Layanan 3 -->
                <div class="glass-card rounded-2xl p-6 transition duration-300 hover:bg-opacity-20">
                    <div class="bg-white bg-opacity-10 w-16 h-16 rounded-full flex items-center justify-center mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-2 text-white">Hiburan</h3>
                    <p class="text-white text-opacity-90">Kurasi pemain, DJ, band, dan pilihan hiburan unik untuk memukau tamu Anda.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Featured Events -->
    <section class="py-16 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            <div class="flex justify-between items-center mb-12">
                <h2 class="text-3xl font-bold text-white">Acara Mendatang</h2>
                <a href="#" class="text-sm font-medium hover:underline text-white">Lihat Semua Acara →</a>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Acara 1 -->
                <div class="glass-card rounded-2xl overflow-hidden event-card transition duration-300">
                    <img src="https://images.unsplash.com/photo-1492684223066-81342ee5ff30?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60" alt="Acara konser" class="w-full h-48 object-cover">
                    <div class="p-6">
                        <div class="flex justify-between items-start mb-2">
                            <span class="bg-white bg-opacity-10 text-xs px-3 py-1 rounded-full text-white">Musik</span>
                            <span class="text-sm text-white text-opacity-80">15 Juni 2023</span>
                        </div>
                        <h3 class="text-xl font-semibold mb-2 text-white">Festival Summer Beats</h3>
                        <p class="text-sm text-white text-opacity-90 mb-4">Bergabunglah dengan kami untuk festival musik terbesar musim panas ini menampilkan artis internasional ternama.</p>
                        <button class="w-full btn-primary py-2 rounded-lg font-medium">Dapatkan Tiket</button>
                    </div>
                </div>
                
                <!-- Acara 2 -->
                <div class="glass-card rounded-2xl overflow-hidden event-card transition duration-300">
                    <img src="https://images.unsplash.com/photo-1519671482749-fd09be7ccebf?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60" alt="Acara korporat" class="w-full h-48 object-cover">
                    <div class="p-6">
                        <div class="flex justify-between items-start mb-2">
                            <span class="bg-white bg-opacity-10 text-xs px-3 py-1 rounded-full text-white">Bisnis</span>
                            <span class="text-sm text-white text-opacity-80">5 Juli 2023</span>
                        </div>
                        <h3 class="text-xl font-semibold mb-2 text-white">Tech Innovators Summit</h3>
                        <p class="text-sm text-white text-opacity-90 mb-4">Pertemuan pemimpin industri untuk membahas masa depan teknologi dan inovasi.</p>
                        <button class="w-full btn-primary py-2 rounded-lg font-medium">Daftar Sekarang</button>
                    </div>
                </div>
                
                <!-- Acara 3 -->
                <div class="glass-card rounded-2xl overflow-hidden event-card transition duration-300">
                    <img src="https://images.unsplash.com/photo-1519225421980-715cb0215aed?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60" alt="Acara pernikahan" class="w-full h-48 object-cover">
                    <div class="p-6">
                        <div class="flex justify-between items-start mb-2">
                            <span class="bg-white bg-opacity-10 text-xs px-3 py-1 rounded-full text-white">Pernikahan</span>
                            <span class="text-sm text-white text-opacity-80">20 Agustus 2023</span>
                        </div>
                        <h3 class="text-xl font-semibold mb-2 text-white">Pameran Pernikahan</h3>
                        <p class="text-sm text-white text-opacity-90 mb-4">Temukan tren terbaru dalam pernikahan dan temui vendor terbaik untuk hari spesial Anda.</p>
                        <button class="w-full btn-primary py-2 rounded-lg font-medium">Pelajari Lebih Lanjut</button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials -->
    <section class="py-16 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            <h2 class="text-3xl font-bold text-center mb-12 text-white">Apa Kata Klien Kami</h2>
            <div class="glass-card rounded-2xl p-8">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <!-- Testimoni 1 -->
                    <div class="bg-white bg-opacity-10 rounded-xl p-6">
                        <div class="flex items-center mb-4">
                            <img src="https://randomuser.me/api/portraits/women/32.jpg" alt="Sarah Johnson" class="w-12 h-12 rounded-full mr-4">
                            <div>
                                <h4 class="font-semibold text-white">Sarah Johnson</h4>
                                <p class="text-sm text-white text-opacity-80">Klien Pernikahan</p>
                            </div>
                        </div>
                        <p class="text-white text-opacity-90">"Harmoni Event membuat hari pernikahan kami benar-benar magis. Setiap detail sempurna dan mereka mengurus segalanya sehingga kami bisa menikmati hari spesial kami."</p>
                    </div>
                    
                    <!-- Testimoni 2 -->
                    <div class="bg-white bg-opacity-10 rounded-xl p-6">
                        <div class="flex items-center mb-4">
                            <img src="https://randomuser.me/api/portraits/men/45.jpg" alt="Michael Chen" class="w-12 h-12 rounded-full mr-4">
                            <div>
                                <h4 class="font-semibold text-white">Michael Chen</h4>
                                <p class="text-sm text-white text-opacity-80">Klien Korporat</p>
                            </div>
                        </div>
                        <p class="text-white text-opacity-90">"Konferensi tahunan kami dieksekusi dengan sempurna. Perhatian tim terhadap detail dan keterampilan pemecahan masalah sangat mengesankan. Sangat direkomendasikan!"</p>
                    </div>
                    
                    <!-- Testimoni 3 -->
                    <div class="bg-white bg-opacity-10 rounded-xl p-6">
                        <div class="flex items-center mb-4">
                            <img src="https://randomuser.me/api/portraits/women/68.jpg" alt="Emily Rodriguez" class="w-12 h-12 rounded-full mr-4">
                            <div>
                                <h4 class="font-semibold text-white">Emily Rodriguez</h4>
                                <p class="text-sm text-white text-opacity-80">Pesta Ulang Tahun</p>
                            </div>
                        </div>
                        <p class="text-white text-opacity-90">"Pesta kejutan yang mereka atur untuk ulang tahun ke-30 saya melebihi mimpi terliar saya. Tema, dekorasi, dan hiburan semuanya tepat!"</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-20 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            <div class="glass-card rounded-2xl p-12 text-center">
                <h2 class="text-3xl md:text-4xl font-bold mb-6 text-white">Siap Menciptakan Acara Impian Anda?</h2>
                <p class="text-lg mb-8 max-w-2xl mx-auto text-white text-opacity-90">Mari diskusikan bagaimana kami dapat mewujudkan visi Anda dengan layanan perencanaan acara ahli kami.</p>
                <div class="flex flex-col sm:flex-row justify-center space-y-4 sm:space-y-0 sm:space-x-4">
                    <button class="btn-primary px-8 py-3 rounded-lg font-medium">Mulai Sekarang</button>
                    <button class="btn-outline px-8 py-3 rounded-lg font-medium">Hubungi Kami</button>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="glass-nav py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <h3 class="text-lg font-semibold mb-4 text-white">Harmoni Event</h3>
                    <p class="text-sm text-white text-opacity-80">Menciptakan pengalaman tak terlupakan melalui perencanaan dan eksekusi acara yang luar biasa.</p>
                </div>
                <div>
                    <h3 class="text-lg font-semibold mb-4 text-white">Tautan Cepat</h3>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-sm hover:underline text-white text-opacity-80">Beranda</a></li>
                        <li><a href="#" class="text-sm hover:underline text-white text-opacity-80">Tentang Kami</a></li>
                        <li><a href="#" class="text-sm hover:underline text-white text-opacity-80">Layanan</a></li>
                        <li><a href="#" class="text-sm hover:underline text-white text-opacity-80">Galeri</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-lg font-semibold mb-4 text-white">Layanan</h3>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-sm hover:underline text-white text-opacity-80">Pernikahan</a></li>
                        <li><a href="#" class="text-sm hover:underline text-white text-opacity-80">Acara Korporat</a></li>
                        <li><a href="#" class="text-sm hover:underline text-white text-opacity-80">Pesta Pribadi</a></li>
                        <li><a href="#" class="text-sm hover:underline text-white text-opacity-80">Konferensi</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-lg font-semibold mb-4 text-white">Kontak</h3>
                    <ul class="space-y-2">
                        <li class="text-sm text-white text-opacity-80">Jl. Acara No. 123, Suite 100</li>
                        <li class="text-sm text-white text-opacity-80">Jakarta Selatan, 12345</li>
                        <li class="text-sm text-white text-opacity-80">info@harmonievent.com</li>
                        <li class="text-sm text-white text-opacity-80">(021) 1234-5678</li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-white border-opacity-20 mt-12 pt-8 text-center text-sm text-white text-opacity-80">
                <p>© 2023 Harmoni Event. Semua hak dilindungi.</p>
            </div>
        </div>
    </footer>

    <script>
        // Mobile menu toggle functionality
        const mobileMenuButton = document.getElementById('mobile-menu-button');
        const mobileMenu = document.getElementById('mobile-menu');

        mobileMenuButton.addEventListener('click', function() {
            const isHidden = mobileMenu.classList.contains('hidden');
            
            if (isHidden) {
                mobileMenu.classList.remove('hidden');
                mobileMenu.classList.add('block');
            } else {
                mobileMenu.classList.remove('block');
                mobileMenu.classList.add('hidden');
            }
        });

        // Close mobile menu when clicking outside
        document.addEventListener('click', function(event) {
            const isClickInside = mobileMenu.contains(event.target) || mobileMenuButton.contains(event.target);
            
            if (!isClickInside && !mobileMenu.classList.contains('hidden')) {
                mobileMenu.classList.remove('block');
                mobileMenu.classList.add('hidden');
            }
        });

        // Handle login/register navigation
        document.querySelectorAll('a[href="/login"], a[href="/register"]').forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                window.location.href = this.getAttribute('href');
            });
        });
    </script>
</body>
</html>