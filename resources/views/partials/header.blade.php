<header class="bg-white text-slate-700 shadow-sm border-b border-slate-200 sticky top-0 z-40">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-3 flex justify-between items-center">
        {{-- Bagian Kiri: Tombol Sidebar & Logo/Judul Aplikasi --}}
        <div class="flex items-center space-x-3">
            <button id="sidebar-toggle" type="button" aria-label="Toggle sidebar" class="md:hidden p-2 -ml-2 rounded-md text-slate-500 hover:bg-slate-100 hover:text-slate-700 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500 transition-colors duration-150">
                <span class="sr-only">Buka sidebar</span>
                <i class="fas fa-bars text-xl"></i>
            </button>
            <a href="/public/archive" class="flex items-center space-x-2.5 text-slate-700 hover:text-indigo-600 transition-colors duration-150 group">
                <i class="fas fa-archive text-2xl text-indigo-600 group-hover:text-indigo-700 transition-colors duration-150"></i>
                <h1 class="text-xl font-semibold hidden md:block">Archive Perusahaan</h1>
            </a>
        </div>

        {{-- Bagian Kanan: Menu Pengguna --}}
        <div class="flex items-center">
            @auth
            <div class="relative">
                {{-- Tombol Avatar Pengguna --}}
                <button onclick="toggleProfileMenu()" type="button" class="flex items-center justify-center w-9 h-9 rounded-full bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-150" id="user-menu-button" aria-expanded="false" aria-haspopup="true">
                    <span class="sr-only">Buka menu pengguna</span>
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </button>

                {{-- Dropdown Menu Pengguna --}}
                <div id="profile-menu"
                     class="absolute right-0 mt-2.5 w-64 origin-top-right bg-white rounded-lg shadow-xl ring-1 ring-black ring-opacity-5 focus:outline-none hidden z-50"
                     role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button" tabindex="-1">
                    <div class="py-1" role="none">
                        {{-- Informasi Pengguna di Dropdown --}}
                        <div class="px-4 py-3 border-b border-slate-200">
                            <p class="text-sm font-semibold text-slate-800 truncate" role="none">{{ Auth::user()->name }}</p>
                            <p class="text-xs text-slate-500 truncate mt-0.5" role="none">{{ Auth::user()->email }}</p>
                            <p class="text-xs text-indigo-600 font-medium capitalize mt-1.5" role="none">{{ Auth::user()->role }}</p>
                        </div>
                        {{-- Link Profil --}}
                        <a href="{{ route('profile') }}" class="group flex items-center w-full px-4 py-2.5 text-sm text-slate-700 hover:bg-slate-100 hover:text-slate-900 transition-colors duration-150" role="menuitem" tabindex="-1">
                            <i class="fas fa-user-circle w-4 h-4 mr-2.5 text-slate-400 group-hover:text-slate-500 transition-colors duration-150"></i>
                            Profil Saya
                        </a>
                        {{-- Tombol Logout --}}
                        <form method="POST" action="{{ route('logout') }}" role="none">
                            @csrf
                            <button type="submit" class="group flex w-full items-center px-4 py-2.5 text-sm text-red-600 hover:bg-red-50 hover:text-red-700 transition-colors duration-150" role="menuitem" tabindex="-1">
                                <i class="fas fa-sign-out-alt w-4 h-4 mr-2.5 text-red-400 group-hover:text-red-500 transition-colors duration-150"></i>
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @endauth

            {{-- Contoh Tombol Login/Register untuk Guest (jika diperlukan) --}}
            {{-- @guest
                <div class="flex items-center space-x-3 ml-4">
                    <a href="{{ route('login') }}" class="text-sm font-medium text-slate-600 hover:text-indigo-600 transition-colors duration-150">Login</a>
                    <a href="{{ route('register') }}" class="text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 px-3.5 py-2 rounded-md shadow-sm transition-colors duration-150">
                        Register
                    </a>
                </div>
            @endguest --}}
        </div>
    </div>
</header>

<script>
    function toggleProfileMenu() {
        const menu = document.getElementById('profile-menu');
        menu.classList.toggle('hidden');
        // Update aria-expanded status
        const button = document.getElementById('user-menu-button');
        if (button) {
            button.setAttribute('aria-expanded', menu.classList.contains('hidden') ? 'false' : 'true');
        }
    }

    // Tutup menu jika klik di luar
    document.addEventListener('click', function(event) {
        const profileMenuButton = document.getElementById('user-menu-button'); // Tombol avatar
        const profileMenu = document.getElementById('profile-menu'); // Dropdown

        // Cek apakah menu ada dan sedang terbuka
        if (profileMenu && !profileMenu.classList.contains('hidden')) {
            // Cek apakah klik terjadi di luar tombol DAN di luar menu
            if (profileMenuButton && !profileMenuButton.contains(event.target) && !profileMenu.contains(event.target)) {
                profileMenu.classList.add('hidden');
                // Update aria-expanded status
                profileMenuButton.setAttribute('aria-expanded', 'false');
            }
        }
    });
</script>