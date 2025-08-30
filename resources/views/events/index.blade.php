{{-- resources/views/events/index.blade.php --}}
@extends('layouts.app')

@section('content')
    <section x-data="heroSlider()" x-init="init()" @mouseenter="pause()" @mouseleave="resume()" class="relative">
        {{-- HERO / CAROUSEL --}}
        <div class="rounded-3xl overflow-hidden bg-gray-200 ">
            <div class="relative h-[480px] md:h-[540px]">
                <template x-for="(s, i) in slides" :key="i">
                    <div x-show="active===i" x-transition.opacity.duration.500ms class="absolute inset-0">
                        <img :src="s.image" class="w-full h-full object-cover" alt="">
                        <div class="absolute inset-0 bg-gradient-to-tr from-black/60 via-black/30 to-transparent"></div>

                        <div class="absolute left-8 md:left-14 top-1/2 -translate-y-1/2 text-white max-w-xl">
                            <p class="text-xs md:text-sm tracking-widest opacity-80 uppercase">MyBanyuwangi</p>
                            <h1 class="text-3xl md:text-5xl font-extrabold leading-tight mb-4" x-text="s.title"></h1>
                            <p class="text-base md:text-lg opacity-90 mb-6" x-text="s.desc"></p>

                            <div class="flex flex-col sm:flex-row gap-3">
                                <a href="#events"
                                    class="inline-flex items-center justify-center rounded-full px-5 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold shadow">
                                    Lihat Event <i class="fa-solid fa-arrow-right-long ml-2"></i>
                                </a>

                                <form method="GET" action="{{ route('events.index') }}#events"
                                    class="flex bg-white/90 backdrop-blur rounded-full overflow-hidden">
                                    <input name="search" placeholder="Cari event…"
                                        class="px-4 py-2 text-sm md:text-base outline-none bg-transparent text-gray-800 w-48 md:w-64" />
                                    <button class="px-4 py-2 text-indigo-600 font-semibold">Cari</button>
                                </form>
                            </div>
                        </div>

                        <div
                            class="hidden md:flex items-center gap-3 absolute right-6 bottom-6 bg-white/90 backdrop-blur rounded-2xl px-4 py-3 shadow">
                            <div class="flex -space-x-2">
                                <img :src="s.thumb1" class="w-8 h-8 rounded-full ring-2 ring-white" alt="">
                                <img :src="s.thumb2" class="w-8 h-8 rounded-full ring-2 ring-white" alt="">
                                <img :src="s.thumb3" class="w-8 h-8 rounded-full ring-2 ring-white" alt="">
                            </div>
                            <div>
                                <p class="text-xs text-gray-500">Event Unggulan</p>
                                <p class="text-sm font-semibold text-gray-800">Temukan pengalaman seru tiap pekan</p>
                            </div>
                        </div>
                    </div>
                </template>

                <button @click="prev"
                    class="absolute left-3 top-1/2 -translate-y-1/2 bg-black/50 text-white w-10 h-10 rounded-full grid place-items-center hover:bg-black/70">
                    <i class="fa-solid fa-chevron-left"></i>
                </button>
                <button @click="next"
                    class="absolute right-3 top-1/2 -translate-y-1/2 bg-black/50 text-white w-10 h-10 rounded-full grid place-items-center hover:bg-black/70">
                    <i class="fa-solid fa-chevron-right"></i>
                </button>

                <div class="absolute bottom-4 left-1/2 -translate-x-1/2 flex items-center gap-2">
                    <template x-for="(s, i) in slides" :key="'dot' + i">
                        <button @click="go(i)" class="h-2.5 rounded-full transition-all"
                            :class="active === i ? 'w-6 bg-white' : 'w-2.5 bg-white/60'"></button>
                    </template>
                </div>
            </div>
        </div>

        <div class="mt-6 flex flex-wrap items-center justify-center gap-8 opacity-70">
            <span class="text-sm">Follow</span>
            <div class="flex items-center gap-3">
                <i class="fa-brands fa-facebook-f"></i>
                <i class="fa-brands fa-instagram"></i>
                <i class="fa-brands fa-x-twitter"></i>
            </div>
            <div class="h-5 w-px bg-gray-300"></div>
            <h1>@mybanyuwangiofficial</h1>
        </div>
    </section>

    {{-- EVENT POPULER --}}
    <section class="mt-12">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl md:text-3xl font-bold text-gray-900">Event Terbaru</h2>
                <p class="text-gray-500 text-sm">Minggu ini di Banyuwangi</p>
            </div>
            <div class="hidden md:flex gap-2">
                <button id="popPrev" class="w-9 h-9 rounded-full border grid place-items-center hover:bg-gray-100">
                    <i class="fa-solid fa-chevron-left text-sm"></i>
                </button>
                <button id="popNext" class="w-9 h-9 rounded-full border grid place-items-center hover:bg-gray-100">
                    <i class="fa-solid fa-chevron-right text-sm"></i>
                </button>
            </div>
        </div>

        <div id="popWrap" class="mt-6 flex gap-6 overflow-x-auto snap-x snap-mandatory scroll-smooth pb-2">
            @php
                $popular =
                    $popularEvents ?? null ?:
                    \App\Models\Event::query()->latest('starts_at')->take(6)->get() ?? collect();
            @endphp

            @forelse($popular as $ev)
                <a href="{{ route('events.show', $ev) }}"
                    class="min-w-[260px] max-w-[260px] snap-start bg-white rounded-2xl overflow-hidden shadow hover:shadow-lg transition">
                    <div class="h-40 bg-gray-200">
                        @if ($ev->image_path)
                            <img class="w-full h-full object-cover" src="{{ asset('storage/' . $ev->image_path) }}"
                                alt="{{ $ev->title }}">
                        @endif
                    </div>
                    <div class="p-4">
                        <p class="text-xs text-gray-500 flex items-center gap-1">
                            <i class="fa-regular fa-calendar"></i>
                            {{ \Illuminate\Support\Carbon::parse($ev->starts_at)->format('d M Y') }}
                        </p>
                        <h3 class="mt-1 font-semibold text-gray-900 line-clamp-1">{{ $ev->title }}</h3>
                        <p class="text-sm text-gray-500 line-clamp-2">
                            {{ \Illuminate\Support\Str::limit($ev->location, 60) }}
                        </p>

                    </div>
                </a>
            @empty
                @for ($i = 0; $i < 6; $i++)
                    <div class="min-w-[260px] max-w-[260px] snap-start bg-white rounded-2xl overflow-hidden shadow">
                        <div class="h-40 bg-gray-200"></div>
                        <div class="p-4">
                            <p class="text-xs text-gray-500">12 Okt 2025</p>
                            <h3 class="mt-1 font-semibold">Contoh Event Banyuwangi</h3>
                            <p class="text-sm text-gray-500">Taman Blambangan</p>
                        </div>
                    </div>
                @endfor
            @endforelse
        </div>
    </section>

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

    {{-- DAFTAR EVENT (anchor id events) --}}
    <div class="opacity-0 mt-5" id="events">test</div>
    <section class="mt-20">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl md:text-3xl font-bold text-gray-900">Daftar Event</h2>
            <a href="{{ route('events.list') }}"
                class="inline-flex items-center justify-center rounded-full px-5 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold shadow">Lihat
                Semua Event<i class="fa-solid fa-arrow-right-long ml-2"></i></a>

        </div>

        {{-- Filter utama --}}
        @if (request('date'))
            <div class="mb-4 text-center">
                <h2 class="text-lg font-semibold text-indigo-600">
                    Event pada {{ \Carbon\Carbon::parse(request('date'))->translatedFormat('d F Y') }}
                </h2>
                <a href="{{ route('events.list') }}" class="text-sm text-gray-500 hover:underline">Lihat Semua Event</a>
            </div>
        @endif

        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
            <form id="filterForm" method="GET" action="{{ route('events.list') }}"
                class="grid sm:grid-cols-[1fr,200px,200px,auto] gap-3 w-full md:w-auto">
                <input name="search" placeholder="Cari event…" value="{{ request('search') }}"
                    class="border rounded-xl px-4 py-2">
                <select name="category" id="categorySelect" class="border rounded-xl px-4 py-2">
                    <option value="">Semua Kategori</option>
                    @isset($categories)
                        @foreach ($categories as $cat)
                            <option value="{{ $cat }}" @selected(request('category') == $cat)>{{ $cat }}</option>
                        @endforeach
                    @endisset
                    {{-- khusus: gunakan ini supaya controller paham filter "Event Selesai" --}}
                    <option value="Event Selesai" @selected(request('category') == 'Event Selesai')>Event Selesai</option>
                </select>

                <select name="sort" class="border rounded-xl px-4 py-2">
                    <option value="">Urutkan</option>
                    <option value="date_desc" @selected(request('sort') == 'date_desc')>Terbaru</option>
                    <option value="date_asc" @selected(request('sort') == 'date_asc')>Terlama</option>
                    <option value="az" @selected(request('sort') == 'az')>A–Z</option>
                    <option value="za" @selected(request('sort') == 'za')>Z–A</option>
                </select>

                <button type="submit"
                    class="rounded-xl px-5 py-2 bg-indigo-600 text-white font-semibold hover:bg-indigo-700">Terapkan</button>
            </form>

            {{-- Quick status filter (All / Aktif / Selesai) --}}
            <div class="flex items-center gap-2">
                <span class="text-sm text-gray-500 mr-2">Tampilkan:</span>
                <div class="inline-flex rounded-lg border overflow-hidden">
                    <a href="{{ route('events.index') }}#events"
                        class="px-3 py-2 text-sm {{ request('status') == null ? 'bg-indigo-600 text-white' : 'bg-white' }}">Semua</a>
                    <a href="{{ route('events.index', ['status' => 'aktif']) }}#events"
                        class="px-3 py-2 text-sm {{ request('status') == 'aktif' ? 'bg-indigo-600 text-white' : 'bg-white' }}">Aktif</a>
                    <a href="{{ route('events.index', ['status' => 'selesai']) }}#events"
                        class="px-3 py-2 text-sm {{ request('status') == 'selesai' ? 'bg-indigo-600 text-white' : 'bg-white' }}">Selesai</a>
                </div>
            </div>

        </div>

        {{-- Grid event --}}
        <div id="eventsGrid" class="mt-6 grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse(($events ?? collect())->items() as $event)
                @php
                    // toISO untuk data attribute (jika null, kosong)
                    $endsAtIso = $event->ends_at
                        ? \Illuminate\Support\Carbon::parse($event->ends_at)->toIsoString()
                        : '';
                @endphp

                <div class="bg-white rounded-2xl shadow hover:shadow-xl transition overflow-hidden">
                    <!-- Gambar -->
                    <a href="{{ route('events.show', $event) }}" class="relative group">
                        <img src="{{ asset('storage/' . $event->image_path) }}" alt="{{ $event->title }}"
                            class="w-full h-48 object-cover transform group-hover:scale-105 transition duration-300">

                        <!-- Overlay tanggal -->
                        <div class="absolute top-3 left-3 bg-white rounded-lg shadow p-2 text-center">
                            <p class="text-xl font-bold text-indigo-600">
                                {{ \Carbon\Carbon::parse($event->starts_at)->format('d') }}
                            </p>
                            <p class="text-xs text-gray-500">
                                {{ \Carbon\Carbon::parse($event->starts_at)->format('M, Y') }}
                            </p>
                        </div>

                        <!-- Badge status -->
                        <div class="absolute top-3 right-3">
                            @if ($event->ends_at < now())
                                <span class="text-xs bg-red-100 text-red-600 px-2 py-1 rounded-full">Event Selesai</span>
                            @else
                                <span class="text-xs bg-green-100 text-green-600 px-2 py-1 rounded-full">Sedang
                                    Berjalan</span>
                            @endif
                        </div>
                    </a>

                    {{-- CARD CONTENT --}}

                    <div class="p-4 flex gap-y-3 flex-col">
                        {{-- kategori --}}
                        <div class="flex justify-between items-center mb-2">
                            <a href="{{ route('events.list', ['category' => $event->category]) }}"
                                class="text-xs text-purple-600 font-semibold hover:underline flex items-center gap-1">
                                <i data-lucide="tag" class="w-4 h-4 text-purple-500"></i>
                                {{ $event->category ?? 'Umum' }}
                            </a>

                            @if ($event->location)
                                <a href="https://maps.google.com?q={{ urlencode($event->location) }}" target="_blank"
                                    class="text-xs text-indigo-500 flex items-center gap-1 hover:underline">
                                    <i data-lucide="map-pin" class="w-4 h-4"></i>
                                    {{ Str::limit($event->location, 20, '...') }}
                                </a>
                            @endif
                        </div>

                        <!-- Judul -->
                        <a href="{{ route('events.show', $event) }}">
                            <h3 class="text-lg font-bold mb-1 hover:underline">{{ Str::limit($event->title, 23, '...') }}
                            </h3>
                        </a>

                        <!-- Deskripsi (hanya 1 baris) -->
                        <p class="text-sm text-gray-600 mb-3 truncate">{{ $event->description }}</p>
                    </div>

                </div>
            @empty
                <div class="col-span-full rounded-2xl border bg-white p-10 text-center text-gray-500">
                    Belum ada event. Tambahkan dari menu Admin.
                </div>
            @endforelse
        </div>

        {{-- Pagination --}}
        <div class="mt-6">
            {{ ($events ?? collect())->withQueryString()->links() }}
        </div>
    </section>

    {{-- CTA strip --}}
    <section class="mt-16">
        <div class="rounded-3xl overflow-hidden bg-indigo-50">
            <div class="px-6 md:px-10 py-8 md:py-10 flex flex-col md:flex-row items-center justify-between gap-6">
                <h3 class="text-2xl md:text-3xl font-extrabold text-gray-900">Siap jalan? <span
                        class="text-indigo-600">Temukan Event Seru</span> sekarang.</h3>
                <a href="{{ route('events.calendar') }}"
                    class="rounded-full px-6 py-3 bg-indigo-600 text-white font-semibold hover:bg-indigo-700 inline-flex items-center">
                    Buka Kalender Event <i class="fa-solid fa-arrow-right ml-2"></i>
                </a>
            </div>
        </div>
    </section>

    {{-- SCRIPTS --}}
    <script>
        // Hero slider (Alpine data defined in earlier code — kept)
        function heroSlider() {
            return {
                active: 0,
                timer: null,
                slides: [{
                        image: "{{ asset('images/ijen.jpg') }}",
                        title: "Rasakan Serunya Agenda Kota",
                        desc: "Temukan kegiatan terbaru di Banyuwangi — budaya, musik, kuliner.",
                        thumb1: "{{ asset('images/sritanjung.jpg') }}",
                        thumb2: "{{ asset('images/baluran.jpg') }}",
                        thumb3: "{{ asset('images/pulaumerah.jpg') }}"
                    },
                    {
                        image: "{{ asset('images/pulaumerah.jpg') }}",
                        title: "Festival & Parade Setiap Pekan",
                        desc: "Jadwal lengkap acara favoritmu, diperbarui setiap saat.",
                        thumb1: "{{ asset('images/ijen.jpg') }}",
                        thumb2: "{{ asset('images/baluran.jpg') }}",
                        thumb3: "{{ asset('images/sritanjung.jpg') }}"
                    },
                    {
                        image: "{{ asset('images/baluran.jpg') }}",
                        title: "Dukung UMKM & Komunitas",
                        desc: "Pameran, bazar, dan kegiatan komunitas hadir dekat denganmu.",
                        thumb1: "{{ asset('images/ijen.jpg') }}",
                        thumb2: "{{ asset('images/pulaumerah.jpg') }}",
                        thumb3: "{{ asset('images/sritanjung.jpg') }}"
                    }
                ],
                pause() {
                    clearInterval(this.interval);
                    this.interval = null;
                },
                resume() {
                    if (!this.interval) {
                        this.start();
                    }
                },
                next() {
                    this.active = (this.active + 1) % this.slides.length
                },
                prev() {
                    this.active = (this.active === 0) ? this.slides.length - 1 : this.active - 1
                },
                go(i) {
                    this.active = i
                },
                init() {
                    this.timer = setInterval(() => this.next(), 4000)
                }
            }
        }

        // Popular scroller arrows (same as before)
        const wrap = document.getElementById('popWrap');
        const prevBtn = document.getElementById('popPrev');
        const nextBtn = document.getElementById('popNext');
        if (wrap && prevBtn && nextBtn) {
            const step = 300;
            prevBtn.addEventListener('click', () => wrap.scrollBy({
                left: -step,
                behavior: 'smooth'
            }));
            nextBtn.addEventListener('click', () => wrap.scrollBy({
                left: step,
                behavior: 'smooth'
            }));
        }

        // ---------- Client-side status filter (Aktif) ----------
        const statusAll = document.getElementById('statusAll');
        const statusAktif = document.getElementById('statusAktif');
        const statusSelesai = document.getElementById('statusSelesai');
        const eventsGrid = document.getElementById('eventsGrid');
        const filterForm = document.getElementById('filterForm');
        const categorySelect = document.getElementById('categorySelect');

        function showAllCards() {
            document.querySelectorAll('.event-card').forEach(c => c.style.display = '');
            setActiveStatusButton('all');
        }

        function showActiveCardsClient() {
            const now = new Date();
            document.querySelectorAll('.event-card').forEach(card => {
                const endsAt = card.dataset.endsAt;
                if (!endsAt || endsAt === '') {
                    // no ends_at -> treat as active
                    card.style.display = '';
                    return;
                }
                const endsDate = new Date(endsAt);
                if (endsDate < now) {
                    // already finished -> hide
                    card.style.display = 'none';
                } else {
                    card.style.display = '';
                }
            });
            setActiveStatusButton('aktif');
        }

        function setActiveStatusButton(type) {
            [statusAll, statusAktif, statusSelesai].forEach(b => b.classList.remove('bg-indigo-600', 'text-white'));
            if (type === 'all') statusAll.classList.add('bg-indigo-600', 'text-white');
            if (type === 'aktif') statusAktif.classList.add('bg-indigo-600', 'text-white');
            if (type === 'selesai') statusSelesai.classList.add('bg-indigo-600', 'text-white');
        }

        // wire buttons
        if (statusAll) statusAll.addEventListener('click', (e) => {
            e.preventDefault();
            // clear category param and submit form to get server list (or just show all)
            categorySelect.value = '';
            // submit so server returns full set (useful if you had server-side filtering previously)
            filterForm.submit();
        });

        if (statusAktif) statusAktif.addEventListener('click', (e) => {
            e.preventDefault();
            // client-side filter (does not submit the form)
            showActiveCardsClient();
        });

        if (statusSelesai) statusSelesai.addEventListener('click', (e) => {
            e.preventDefault();
            // set category to "Event Selesai" (controller supports this) and submit so server returns only finished events
            categorySelect.value = 'Event Selesai';
            filterForm.submit();
        });

        // on load: set proper active status btn depending on query param
        document.addEventListener('DOMContentLoaded', () => {
            const params = new URLSearchParams(window.location.search);
            const cat = params.get('category');
            if (cat === 'Event Selesai') {
                setActiveStatusButton('selesai');
            } else {
                // default show server-side results; mark "Semua" active
                setActiveStatusButton('all');
            }
        });
    </script>
@endsection
