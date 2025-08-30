
    {{-- PENGUMUMAN --}}
    <section class="mt-16 grid md:grid-cols-2 gap-8 items-center">
        <div class="rounded-3xl overflow-hidden bg-gray-200 h-[320px]">
            <img src="{{ asset('images/pulaumerah.jpg') }}" class="w-full h-full object-cover" alt="">
        </div>
        <div>
            <p class="uppercase text-xs tracking-widest text-gray-500">Pengumuman</p>
            <h3 class="mt-2 text-3xl md:text-4xl font-extrabold text-gray-900">Banyuwangi Culture Week</h3>
            <p class="mt-3 text-gray-600">Rangkaian acara budaya, pameran UMKM, parade musik & kuliner. Jangan lewatkan
                diskon tiket masuk venue tertentu khusus warga.</p>

            <div class="mt-6 flex items-center gap-4">
                <div class="rounded-2xl bg-white border px-4 py-3">
                    <p class="text-xs text-gray-500">Sampai</p>
                    <p class="font-semibold text-gray-900">28 September 2025</p>
                </div>
                <div class="text-right">
                    <a href="{{ route('events.list') }}" class="text-indigo-600 btn font-semibold hover:underline">Lihat
                        Semua</a>
                </div>
            </div>
        </div>
    </section>
