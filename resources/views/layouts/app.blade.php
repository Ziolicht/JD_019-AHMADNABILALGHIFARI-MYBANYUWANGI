<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'MyBanyuwangi' }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <style>
        html {
            scroll-behavior: smooth;
        }
    </style>
    <script src="https://unpkg.com/lucide@latest"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="bg-gray-50 text-gray-800">
    @include('layouts.navigation')

    <main class="max-w-6xl mx-auto px-4 py-6">
        @yield('content')
    </main>

    {{-- FOOTER --}}
    <footer class="bg-gray-900 text-gray-300 mt-12">
        <div class="max-w-7xl mx-auto px-6 py-10">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">

                <!-- Brand & Deskripsi -->
                <div>
                    <h2 class="text-2xl font-bold text-white mb-4">MyBanyuwangi</h2>
                    <p class="text-gray-400 text-sm mb-4">
                        Temukan dan ikuti kegiatan menarik di sekitar kota Anda.
                    </p>
                    <div class="flex space-x-4">
                        <a href="#" class="text-gray-400 hover:text-white transition"><i
                                class="fab fa-facebook-f"></i></a>
                        <a href="#" class="text-gray-400 hover:text-white transition"><i
                                class="fab fa-instagram"></i></a>
                        <a href="#" class="text-gray-400 hover:text-white transition"><i
                                class="fab fa-twitter"></i></a>
                        <a href="#" class="text-gray-400 hover:text-white transition"><i
                                class="fab fa-youtube"></i></a>
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



    <script>
        lucide.createIcons();

        (function() {
            const wrappers = () => document.querySelectorAll('[data-user-menu]');
            const panels = () => document.querySelectorAll('[data-user-panel]');
            const closeAll = () => panels().forEach(p => p.classList.add('hidden'));

            wrappers().forEach(w => {
                const btn = w.querySelector('[data-user-button]');
                const panel = w.querySelector('[data-user-panel]');
                if (!btn || !panel) return;

                btn.addEventListener('click', (e) => {
                    e.stopPropagation();
                    const willOpen = panel.classList.contains('hidden');
                    closeAll();
                    if (willOpen) panel.classList.remove('hidden');
                });
            });

            document.addEventListener('click', closeAll);
            document.addEventListener('keydown', (e) => {
                if (e.key === 'Escape') closeAll();
            });
            window.addEventListener('scroll', closeAll, {
                passive: true
            });
        })();

        const mainNavbar = document.getElementById('mainNavbar');
        const glassNavbar = document.getElementById('glassNavbar');
        let scrollTimeout;

        window.addEventListener('scroll', () => {
            const mainNavbarBottom = mainNavbar.getBoundingClientRect().bottom;

            if (mainNavbarBottom <= 0) {
                glassNavbar.classList.remove('hidden');
            } else {
                glassNavbar.classList.add('hidden');
            }

            glassNavbar.style.opacity = '1';
            clearTimeout(scrollTimeout);
            scrollTimeout = setTimeout(() => {
                glassNavbar.style.opacity = '0';
            }, 1500);
        });

        document.addEventListener('click', (e) => {
            const menus = ['mainMobileMenu', 'glassMobileMenu'];
            menus.forEach(id => {
                const menu = document.getElementById(id);
                if (menu && !menu.classList.contains('hidden') &&
                    !menu.contains(e.target) &&
                    !e.target.closest('button')) {
                    menu.classList.add('hidden');
                }
            });
        });

        window.addEventListener('scroll', () => {
            ['mainMobileMenu', 'glassMobileMenu'].forEach(id => {
                const menu = document.getElementById(id);
                if (menu) menu.classList.add('hidden');
            });
        });

        function setupMobileMenu(buttonId, menuId) {
            const button = document.getElementById(buttonId);
            const menu = document.getElementById(menuId);

            if (button && menu) {
                button.addEventListener('click', () => {
                    menu.classList.toggle('hidden');
                });
            }
        }

        setupMobileMenu('mainMobileMenuButton', 'mainMobileMenu');
        setupMobileMenu('glassMobileMenuButton', 'glassMobileMenu');




        // alert
        document.getElementById('delete-btn').addEventListener('click', function() {
            Swal.fire({
                title: 'Yakin ingin menghapus?',
                text: "Event ini akan dihapus secara permanen!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form').submit();
                }
            });
        });
    </script>
</body>

</html>
