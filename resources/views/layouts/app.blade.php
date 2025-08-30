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

    @include('layouts.footer')

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
            }, 5000);
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

        document.querySelector('form').addEventListener('submit', function(e) {
            const start = new Date(document.querySelector('[name="starts_at"]').value);
            const end = new Date(document.querySelector('[name="ends_at"]').value);
            const category = document.querySelector('[name="category"]').value.trim();

            if (!category) {
                alert('Kategori harus diisi!');
                e.preventDefault();
                return;
            }

            if (end && end < start) {
                alert('Tanggal selesai tidak boleh lebih kecil dari tanggal mulai!');
                e.preventDefault();
            }
        });
    </script>
</body>

</html>
