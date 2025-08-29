<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }} id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'MyBanyuwangi' }}</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- Styles -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script src="//unpkg.com/alpinejs" defer></script>
    <style>
        html {
            scroll-behavior: smooth;
        }
    </style>
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100">
        @include('layouts.navigation')

        <!-- Page Heading -->
        @isset($header)
            <header class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endisset

        <!-- Page Content -->
        <main class="max-w-6xl mx-auto px-4 py-6">
            {{ $slot }}
            @if (session('success'))
                <div class="mb-4 p-3 rounded-md bg-green-100 text-green-800">{{ session('success') }}</div>
            @endif
            @if ($errors->any())
                <div class="mb-4 p-3 rounded-md bg-red-100 text-red-800">
                    <ul class="list-disc list-inside text-sm">
                        @foreach ($errors->all() as $e)
                            <li>{{ $e }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            @yield('content')
        </main>


        {{-- FOOTER --}}
        <section id="footer">
            <footer class="bg-gray-900 text-gray-300 mt-12 absolute bottom w-full">
                <div class="max-w-7xl mx-auto px-6 py-10">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-8">

                        <!-- Brand & Deskripsi -->
                        <div>
                            <h2 class="text-2xl font-bold text-white mb-4">MyBanyuwangi</h2>
                            <p class="text-gray-400 text-sm mb-4">
                                Temukan dan ikuti kegiatan menarik di sekitar kota Anda.
                            </p>
                            <!-- Sosial Media -->
                            <div class="flex space-x-4">
                                <a href="#" class="text-gray-400 hover:text-white transition">
                                    <i class="fab fa-facebook-f"></i>
                                </a>
                                <a href="#" class="text-gray-400 hover:text-white transition">
                                    <i class="fab fa-instagram"></i>
                                </a>
                                <a href="#" class="text-gray-400 hover:text-white transition">
                                    <i class="fab fa-twitter"></i>
                                </a>
                                <a href="#" class="text-gray-400 hover:text-white transition">
                                    <i class="fab fa-youtube"></i>
                                </a>
                            </div>
                        </div>

                        <!-- Quick Links -->
                        <div>
                            <h3 class="text-white font-semibold mb-4">Navigasi</h3>
                            <ul class="space-y-2 text-gray-400">
                                <li><a href="/" class="hover:text-white transition">Beranda</a></li>
                                <li><a href="/#events" class="hover:text-white transition">Event</a></li>
                                <li><a href="/about" class="hover:text-white transition">Tentang Kami</a></li>
                                <li><a href="/#footer" class="hover:text-white transition">Kontak</a></li>
                            </ul>
                        </div>

                        <!-- Kategori -->
                        <div>
                            <h3 class="text-white font-semibold mb-4">Kategori</h3>
                            <ul class="space-y-2 text-gray-400">
                                <li><a href="#" class="hover:text-white transition">Musik</a></li>
                                <li><a href="#" class="hover:text-white transition">Olahraga</a></li>
                                <li><a href="#" class="hover:text-white transition">Pameran</a></li>
                                <li><a href="#" class="hover:text-white transition">Lainnya</a></li>
                            </ul>
                        </div>

                        <!-- Newsletter -->
                        <div>
                            <h3 class="text-white font-semibold mb-4">Berlangganan</h3>
                            <p class="text-gray-400 text-sm mb-4">
                                Dapatkan info event terbaru langsung ke email Anda.
                            </p>
                            <form action="#" method="POST" class="flex">
                                <input type="email" placeholder="Email Anda"
                                    class="w-full px-3 py-2 rounded-l-md focus:outline-none text-gray-800">
                                <button type="submit"
                                    class="bg-indigo-600 px-4 py-2 rounded-r-md text-white hover:bg-indigo-700">
                                    Kirim
                                </button>
                            </form>
                        </div>
                    </div>

                    <hr class="my-6 border-gray-700">

                    <div class="flex flex-col md:flex-row justify-between items-center text-sm text-gray-400">
                        <p>&copy; {{ date('Y') }} MyBanyuwangi. Semua Hak Dilindungi.</p>
                        <div class="flex space-x-4 mt-2 md:mt-0">
                            <a href="#" class="hover:text-white">Privasi</a>
                            <a href="#" class="hover:text-white">Syarat & Ketentuan</a>
                        </div>
                    </div>
                </div>
            </footer>
        </section>

    </div>

</body>

</html>
