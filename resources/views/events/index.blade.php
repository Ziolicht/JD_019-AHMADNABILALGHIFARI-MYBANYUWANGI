{{-- resources/views/events/index.blade.php --}}
@extends('layouts.app')

@section('content')
<x-hero />
<x-event-latest />
<x-step-cta />
<x-announcement />

{{-- ANCHOR untuk navigasi --}}
<div class="opacity-0 mt-5" id="events"></div>

<section class="mt-20">
    <!-- Header dan tombol lihat semua -->
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-2xl md:text-3xl font-bold text-gray-900">Daftar Event</h2>
        <a href="{{ route('events.list') }}"
            class="inline-flex items-center justify-center rounded-full px-5 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold shadow">
            Lihat Semua Event<i class="fa-solid fa-arrow-right-long ml-2"></i>
        </a>
    </div>

    {{-- Jika filter tanggal digunakan --}}
    @if (request('date'))
        <div class="mb-4 text-center">
            <h2 class="text-lg font-semibold text-indigo-600">
                Event pada {{ \Carbon\Carbon::parse(request('date'))->translatedFormat('d F Y') }}
            </h2>
            <a href="{{ route('events.list') }}" class="text-sm text-gray-500 hover:underline">Lihat Semua Event</a>
        </div>
    @endif

    <!-- Filter dan status -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">

        {{-- Form filter utama --}}
        <form id="filterForm" method="GET" action="{{ route('events.index') }}" 
            class="grid sm:grid-cols-[1fr,200px,200px,auto] gap-3 w-full md:w-auto">

            <!-- Search -->
            <input name="search" placeholder="Cari event…" value="{{ request('search') }}"
                class="border rounded-xl px-4 py-2">

            <!-- Filter kategori -->
            <select name="category" id="categorySelect" class="border rounded-xl px-4 py-2">
                <option value="">Semua Kategori</option>
                @isset($categories)
                    @foreach ($categories as $cat)
                        <option value="{{ $cat }}" @selected(request('category') == $cat)>{{ $cat }}</option>
                    @endforeach
                @endisset
                <option value="Event Selesai" @selected(request('category') == 'Event Selesai')>Event Selesai</option>
            </select>

            <!-- Urutkan -->
            <select name="sort" class="border rounded-xl px-4 py-2">
                <option value="">Urutkan</option>
                <option value="date_desc" @selected(request('sort') == 'date_desc')>Terbaru</option>
                <option value="date_asc" @selected(request('sort') == 'date_asc')>Terlama</option>
                <option value="az" @selected(request('sort') == 'az')>A–Z</option>
                <option value="za" @selected(request('sort') == 'za')>Z–A</option>
            </select>

            <!-- Tombol -->
            <button type="submit"
                class="rounded-xl px-5 py-2 bg-indigo-600 text-white font-semibold hover:bg-indigo-700">Terapkan</button>
        </form>

        {{-- Quick status filter --}}
        <div class="flex items-center gap-2">
            <span class="text-sm text-gray-500 mr-2">Tampilkan:</span>
            <div class="inline-flex rounded-lg border overflow-hidden">
                <a href="{{ route('events.index') }}#events"
                    class="px-3 py-2 text-sm {{ request('status') == null ? 'bg-indigo-600 text-white' : 'bg-white' }}">
                    Semua
                </a>
                <a href="{{ route('events.index', ['status' => 'aktif']) }}#events"
                    class="px-3 py-2 text-sm {{ request('status') == 'aktif' ? 'bg-indigo-600 text-white' : 'bg-white' }}">
                    Aktif
                </a>
                <a href="{{ route('events.index', ['status' => 'selesai']) }}#events"
                    class="px-3 py-2 text-sm {{ request('status') == 'selesai' ? 'bg-indigo-600 text-white' : 'bg-white' }}">
                    Selesai
                </a>
            </div>
        </div>
    </div>

    {{-- Grid daftar event --}}
    <div id="eventsGrid" class="mt-6 grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse(($events ?? collect())->items() as $event)
            @php
                // ISO format untuk kebutuhan data attribute (opsional)
                $endsAtIso = $event->ends_at ? \Illuminate\Support\Carbon::parse($event->ends_at)->toIsoString() : '';
            @endphp

            <div class="bg-white rounded-2xl shadow hover:shadow-xl transition overflow-hidden">
                <!-- Thumbnail & badge -->
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
                        @elseif ($event->starts_at > now())
                            <span class="text-xs bg-yellow-100 text-yellow-600 px-2 py-1 rounded-full">Akan Datang</span>
                        @else
                            <span class="text-xs bg-green-100 text-green-600 px-2 py-1 rounded-full">Sedang Berjalan</span>
                        @endif
                    </div>
                </a>

                <!-- Konten card -->
                <div class="p-4 flex flex-col gap-y-3">
                    {{-- Kategori dan lokasi --}}
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
                        <h3 class="text-lg font-bold mb-1 hover:underline">{{ Str::limit($event->title, 23, '...') }}</h3>
                    </a>

                    <!-- Deskripsi singkat -->
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
