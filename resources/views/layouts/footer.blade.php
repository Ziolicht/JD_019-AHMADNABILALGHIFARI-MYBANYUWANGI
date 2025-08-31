    {{-- FOOTER --}}
    <footer class="bg-gray-900 text-gray-300 mt-12" id="footer">
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
                        <li><a href="{{ route('events.list', ['category' => 'Musik']) }}"
                                class="hover:text-white transition">Musik</a></li>
                        <li><a href="{{ route('events.list', ['category' => 'Seni']) }}"
                                class="hover:text-white transition">Seni</a></li>
                        <li><a href="{{ route('events.list', ['category' => 'Olahraga']) }}"
                                class="hover:text-white transition">Olahraga</a></li>
                        <li><a href="{{ route('events.list', ['category' => 'Pendidikan']) }}"
                                class="hover:text-white transition">Pendidikan</a></li>
                    </ul>
                </div>

                {{-- Kontak --}}
                <div>
                    <h3 class="text-white font-semibold mb-4">Kontak Kami</h3>
                    <a target="_blank" href="https://wa.me/6281234567890"
                        class="hover:text-white transition flex items-center gap-2">
                        <i data-lucide="phone" class="w-4 h-4"></i>
                        Hubungi via WhatsApp
                    </a>

                </div>
            </div>

            <hr class="my-6 border-gray-700">

            <div class="flex flex-col md:flex-row justify-between items-center text-sm text-gray-400">
                <p>&copy; {{ date('Y') }} MyBanyuwangi. Semua Hak Dilindungi.</p>
            </div>
        </div>
    </footer>
