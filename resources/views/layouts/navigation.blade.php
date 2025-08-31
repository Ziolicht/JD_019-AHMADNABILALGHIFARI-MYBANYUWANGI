<!-- Navbar Utama -->
<nav id="mainNavbar" class="bg-white border-b shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">

            <!-- Logo -->
            <a href="/" class="text-xl font-bold text-gray-800">MyBanyuwangi</a>

            <!-- Menu Utama -->
            <div class="hidden md:flex space-x-8">
                <a href="/" class="text-gray-600 hover:text-gray-900">Beranda</a>
                <a href="#events" class="text-gray-600 hover:text-gray-900">Event</a>
                <a href="{{ route('about') }}" class="text-gray-600 hover:text-gray-900">Tentang</a>
                <a href="/#footer" class="text-gray-600 hover:text-gray-900">Kontak</a>
            </div>

            <!-- User Menu -->
            <div class="flex items-center space-x-4">
                @auth
                    @if (auth()->user()->is_admin)
                        <a href="{{ route('events.create') }}"
                            class="hidden sm:inline-block px-3 py-1.5 rounded-md bg-indigo-600 text-white text-sm hover:bg-indigo-700">
                            + Buat Event
                        </a>
                    @endif

                    <!-- Profil Dropdown -->
                    <div class="relative" data-user-menu>
                        <button type="button" class="flex items-center space-x-2 focus:outline-none" data-user-button>
                            <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=4f46e5&color=fff"
                                class="w-8 h-8 rounded-full" alt="avatar">
                            <span class="hidden sm:inline text-gray-700">{{ Auth::user()->name }}</span>
                            <i class="fa-solid fa-chevron-down text-gray-500 text-xs"></i>
                        </button>

                        <!-- Dropdown Panel -->
                        <div class="hidden absolute right-0 mt-2 w-48 bg-white border rounded-lg shadow-lg z-[60]"
                            data-user-panel>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit"
                                    class="w-full text-left px-4 py-2 text-gray-700 rounded-lg hover:bg-gray-100">
                                    <i class="fa-solid fa-right-from-bracket mr-2"></i> Logout
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="text-sm text-gray-700 hover:text-indigo-600 font-medium">Login</a>
                    <a href="{{ route('register') }}"
                        class="text-sm text-white bg-indigo-600 hover:bg-indigo-700 px-3 py-2 rounded-md">Daftar</a>
                @endauth
            </div>

            <!-- Mobile Menu Button -->
            <div class="md:hidden flex items-center">
                <button id="mainMobileMenuButton" class="text-gray-700 focus:outline-none">
                    <i class="fa-solid fa-bars text-xl"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div id="mainMobileMenu" class="hidden md:hidden px-4 pb-4 space-y-2">
        <a href="/" class="block text-gray-600 hover:text-gray-900">Beranda</a>
        <a href="/#events" class="block text-gray-600 hover:text-gray-900">Event</a>
        <a href="/about" class="block text-gray-600 hover:text-gray-900">Tentang</a>
        <a href="/#footer" class="block text-gray-600 hover:text-gray-900">Kontak</a>
    </div>
</nav>

<!-- Glass Navbar -->
<nav id="glassNavbar"
    class="fixed top-0 left-0 w-full z-50 hidden bg-white/30 backdrop-blur-lg shadow-md transition-all duration-500">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">

            <!-- Logo -->
            <a href="/" class="text-xl font-bold text-gray-800">MyBanyuwangi</a>

            <!-- Menu Utama -->
            <div class="hidden md:flex space-x-8">
                <a href="/" class="text-gray-600 hover:text-gray-900">Beranda</a>
                <a href="/#events" class="text-gray-600 hover:text-gray-900">Event</a>
                <a href="/about" class="text-gray-600 hover:text-gray-900">Tentang</a>
                <a href="#footer" class="text-gray-600 hover:text-gray-900">Kontak</a>
            </div>

            <!-- User Menu -->
            <div class="flex items-center space-x-4">
                @auth
                    @if (auth()->user()->is_admin)
                        <a href="{{ route('events.create') }}"
                            class="hidden sm:inline-block px-3 py-1.5 rounded-md bg-indigo-600 text-white text-sm hover:bg-indigo-700">
                            + Buat Event
                        </a>
                    @endif

                    <!-- Profil Dropdown -->
                    <div class="relative" data-user-menu>
                        <button type="button" class="flex items-center space-x-2 focus:outline-none" data-user-button>
                            <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=4f46e5&color=fff"
                                class="w-8 h-8 rounded-full" alt="avatar">
                            <span class="hidden sm:inline text-gray-700">{{ Auth::user()->name }}</span>
                            <i class="fa-solid fa-chevron-down text-gray-500 text-xs"></i>
                        </button>

                        <!-- Dropdown Panel -->
                        <div class="hidden absolute right-0 mt-2 w-48 bg-white border rounded-lg shadow-lg z-[60]"
                            data-user-panel>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit"
                                    class="w-full text-left px-4 py-2 text-gray-700 rounded-lg hover:bg-gray-100">
                                    <i class="fa-solid fa-right-from-bracket mr-2"></i> Logout
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}"
                        class="text-sm text-gray-700 hover:text-indigo-600 font-medium">Login</a>
                    <a href="{{ route('register') }}"
                        class="text-sm text-white bg-indigo-600 hover:bg-indigo-700 px-3 py-2 rounded-md">Daftar</a>
                @endauth
            </div>

            <!-- Mobile Menu Button -->
            <div class="md:hidden flex items-center">
                <button id="glassMobileMenuButton" class="text-gray-700 focus:outline-none">
                    <i class="fa-solid fa-bars text-xl"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div id="glassMobileMenu" class="hidden md:hidden px-4 pb-4 space-y-2">
        <a href="/" class="block text-gray-600 hover:text-gray-900">Beranda</a>
        <a href="/#events" class="block text-gray-600 hover:text-gray-900">Event</a>
        <a href="/about" class="block text-gray-600 hover:text-gray-900">Tentang</a>
        <a href="/#footer" class="block text-gray-600 hover:text-gray-900">Kontak</a>
    </div>
</nav>
