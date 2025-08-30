@extends('layouts.app')

@section('content')
    <div class="max-w-5xl mx-auto">
        <!-- Header Gambar -->
        <div class="relative rounded-2xl overflow-hidden shadow-lg mb-6">
            @if ($event->image_path)
                <img src="{{ asset('storage/' . $event->image_path) }}" class="w-full h-64 md:h-96 object-cover"
                    alt="{{ $event->title }}">
            @endif

            <!-- Overlay Info -->
            <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/30 to-transparent flex items-end p-6">
                <div>
                    <a href="{{ route('events.list', ['category' => $event->category]) }}"
                        class="inline-flex items-center gap-1 text-xs bg-purple-600 text-white px-3 py-1 rounded-full hover:bg-purple-700 transition">
                        <i data-lucide="tag" class="w-4 h-4"></i>
                        {{ $event->category ?? 'Umum' }}
                    </a>
                    <h1 class="text-3xl font-bold text-white mt-2">{{ $event->title }}</h1>
                </div>
            </div>
        </div>

        <!-- Konten Detail + Deskripsi -->
        <div class="bg-white rounded-2xl shadow p-6 space-y-6">
            <!-- Info Event -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Lokasi -->
                <div>
                    <p class="text-sm text-gray-500 mb-1 flex items-center gap-1">
                        <i data-lucide="map-pin" class="w-4 h-4 text-indigo-500"></i> Lokasi
                    </p>
                    <a href="https://www.google.com/maps/search/?api=1&query={{ urlencode($event->location) }}"
                        target="_blank"
                        class="text-base font-medium text-indigo-600 hover:underline flex items-center gap-1">
                        {{ $event->location ?? 'Tidak tersedia' }}
                        <i data-lucide="external-link" class="w-4 h-4"></i>
                    </a>
                </div>

                <!-- Tanggal -->
                <div>
                    <p class="text-sm text-gray-500 mb-1 flex items-center gap-1">
                        <i data-lucide="calendar" class="w-4 h-4 text-indigo-500"></i> Tanggal

                    </p>

                    <a href="{{ route('events.calendar') }}"
                        class="text-base font-medium text-indigo-600 hover:underline flex items-center gap-1">
                        {{ \Illuminate\Support\Carbon::parse($event->starts_at)->format('d M Y H:i') }}
                        @if ($event->ends_at)
                            - {{ \Illuminate\Support\Carbon::parse($event->ends_at)->format('d M Y H:i') }}
                        @endif
                        <i data-lucide="external-link" class="w-4 h-4"></i>
                    </a>
                </div>

            </div>

            <!-- Status -->
            <div>
                @if ($event->ends_at < now())
                    <span class="inline-flex items-center gap-1 text-sm bg-red-100 text-red-600 px-3 py-1 rounded-full">
                        <i data-lucide="x-circle" class="w-4 h-4"></i> Event Selesai
                    </span>
                @elseif ($event->starts_at > now())
                    <span
                        class="inline-flex items-center gap-1 text-sm bg-yellow-100 text-yellow-600 px-3 py-1 rounded-full">
                        <i data-lucide="clock" class="w-4 h-4"></i> Akan Datang
                    </span>
                @else
                    <span class="inline-flex items-center gap-1 text-sm bg-green-100 text-green-600 px-3 py-1 rounded-full">
                        <i data-lucide="check-circle" class="w-4 h-4"></i> Sedang Berjalan
                    </span>
                @endif
            </div>

            <!-- Tombol Hubungi -->
            @if ($event->contact_whatsapp)
                <a target="_blank" href="https://wa.me/{{ preg_replace('/\D/', '', $event->contact_whatsapp) }}"
                    class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-green-600 text-white text-sm hover:bg-green-700 transition">
                    <i data-lucide="phone" class="w-4 h-4"></i>
                    Hubungi via WhatsApp
                </a>
            @endif

            <!-- Deskripsi -->
            @if ($event->description)
                <div class="prose max-w-none text-gray-700">
                    {!! nl2br(e($event->description)) !!}
                </div>
            @endif
        </div>

        <!-- Tombol Admin -->
        @auth
            @if (auth()->user()->is_admin)
                <div class="flex gap-3 mt-6">
                    <a href="{{ route('events.edit', $event) }}"
                        class="px-4 py-2 rounded-lg bg-indigo-600 text-white text-sm hover:bg-gray-800 transition">Edit</a>
                    <form id="delete-form" method="POST" action="{{ route('events.destroy', $event) }}">
                        @csrf
                        @method('DELETE')
                        <button type="button" id="delete-btn"
                            class="px-4 py-2 rounded-lg bg-red-600 text-white text-sm hover:bg-red-700 transition">
                            Hapus
                        </button>
                    </form>

                </div>
            @endif
        @endauth
    </div>
@endsection
