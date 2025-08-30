@extends('layouts.app')

@section('content')
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl md:text-3xl font-bold text-gray-900">
            Daftar Event
            @if (request('category'))
                <span class="text-gray-500 text-lg"> - Kategori "{{ request('category') }}"</span>
            @endif
        </h1>
        <a href="{{ route('home') }}" class="inline-flex items-center justify-center rounded-full px-5 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold shadow"><i class="fa-solid fa-arrow-left-long mr-2"></i>Kembali ke Home</a>
    </div>

    <!-- Filter -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
        <form method="GET" action="{{ route('events.list') }}"
            class="grid sm:grid-cols-[1fr,200px,200px,auto] gap-3 w-full md:w-auto">
            <input type="text" name="search" placeholder="Cari event..." value="{{ request('search') }}"
                class="border rounded-xl px-3 py-2">

            <select name="category" class="border rounded-xl px-3 py-2">
                <option value="">Semua Kategori</option>
                @foreach ($categories as $cat)
                    <option value="{{ $cat }}" {{ request('category') == $cat ? 'selected' : '' }}>
                        {{ $cat }}</option>
                @endforeach
            </select>

            <select name="sort" class="border rounded-xl px-3 py-2">
                <option value="">Urutkan</option>
                <option value="az" {{ request('sort') == 'az' ? 'selected' : '' }}>A-Z</option>
                <option value="za" {{ request('sort') == 'za' ? 'selected' : '' }}>Z-A</option>
                <option value="date_asc" {{ request('sort') == 'date_asc' ? 'selected' : '' }}>Tanggal Awal</option>
                <option value="date_desc" {{ request('sort') == 'date_desc' ? 'selected' : '' }}>Tanggal Terakhir</option>
            </select>

            <button type="submit"
                class="rounded-xl px-5 py-2 bg-indigo-600 text-white font-semibold hover:bg-indigo-700">Terapkan</button>


        </form>
        <!-- Filter status -->

        <div class="flex items-center gap-2 ">
            <span class="text-md text-gray-500 mr-2">Tampilkan:</span>
            <div class="inline-flex rounded-lg border gap-3 overflow-hidden">
                <a href="{{ route('events.list') }}"
                    class="px-3 py-2 text-sm {{ request('status') == null ? 'bg-indigo-600 text-white' : '' }}">Semua</a>
                <a href="{{ route('events.list', ['status' => 'aktif']) }}"
                    class="px-3 py-2 text-sm {{ request('status') == 'aktif' ? 'bg-indigo-600 text-white' : '' }}">Aktif</a>
                <a href="{{ route('events.list', ['status' => 'selesai']) }}"
                    class="px-3 py-2 text-sm {{ request('status') == 'selesai' ? 'bg-indigo-600 text-white' : '' }}">Selesai</a>
            </div>
        </div>
    </div>



    <!-- Event List -->
    <div class="grid grid-cols-1 mt-6 md:grid-cols-3 gap-6">
        @forelse($events as $event)
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
                        @elseif ($event->starts_at > now())
                            <span class="text-xs bg-yellow-100 text-yellow-600  px-2 py-1 rounded-full">Akan Datang</span>
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
                        <h3 class="text-lg font-bold mb-1 hover:underline">{{ Str::limit($event->title, 23, '...') }}</h3>
                    </a>

                    <!-- Deskripsi (hanya 1 baris) -->
                    <p class="text-sm text-gray-600 mb-3 truncate">{{ $event->description }}</p>
                </div>

            </div>
        @empty
            <p class="col-span-3 text-center text-gray-500">Belum ada event.</p>
        @endforelse
    </div>


    <!-- Pagination -->
    <div class="mt-6">
        {{ $events->links() }}
    </div>
    </div>
@endsection
