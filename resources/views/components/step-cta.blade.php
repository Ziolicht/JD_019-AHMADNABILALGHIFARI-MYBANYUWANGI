    {{-- STEP / CTA --}}
    <section class="mt-16 text-center w-full">
        <h2 class="text-2xl md:text-3xl font-bold text-gray-900">Jelajah Event Jadi Simpel!</h2>
        <p class="text-gray-500 text-sm mt-1">Cari, pilih, dan datang — semua informasi ada di MyBanyuwangi.</p>
        <div class="mt-8 grid md:grid-cols-3 gap-6">
            <div class="rounded-3xl border bg-white p-6 text-left">
                <div class="w-10 h-10 rounded-full grid place-items-center bg-indigo-50 text-indigo-600 font-bold">1</div>
                <h3 class="mt-4 font-semibold text-gray-900">Cari Event</h3>
                <p class="text-sm text-gray-500 mt-1">Gunakan pencarian & kategori untuk menemukan kegiatan favoritmu.</p>
                <a href="{{ route('events.index') }}"
                    class="mt-4 inline-flex items-center text-indigo-600 font-semibold">Mulai Cari <i
                        class="fa-solid fa-arrow-right ml-2 text-sm"></i></a>
            </div>
            <div class="rounded-3xl bg-indigo-600 text-white p-6 text-left shadow-md">
                <div class="w-10 h-10 rounded-full grid place-items-center bg-white/20 font-bold">2</div>
                <h3 class="mt-4 font-semibold">Cek Detail</h3>
                <p class="text-sm mt-1 opacity-90">Baca deskripsi, lokasi, tanggal & kontak penyelenggara.</p>
                <a href="{{ route('events.index') }}" class="mt-4 inline-flex items-center font-semibold">Pelajari <i
                        class="fa-solid fa-arrow-right ml-2 text-sm"></i></a>
            </div>
            <div class="rounded-3xl border bg-white p-6 text-left">
                <div class="w-10 h-10 rounded-full grid place-items-center bg-indigo-50 text-indigo-600 font-bold">3</div>
                <h3 class="mt-4 font-semibold text-gray-900">Datang & Nikmati</h3>
                <p class="text-sm text-gray-500 mt-1">Tandai kalendermu dan ajak teman-temanmu.</p>
                <a href="{{ route('events.index') }}"
                    class="mt-4 inline-flex items-center text-indigo-600 font-semibold">Lihat Jadwal <i
                        class="fa-solid fa-arrow-right ml-2 text-sm"></i></a>
            </div>
        </div>
    </section>
