@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto">
    <!-- Header Gambar -->
    <div class="relative rounded-2xl overflow-hidden shadow-lg mb-6">
        @if ($event->image_path)
            <img src="{{ asset('storage/' . $event->image_path) }}"
                class="w-full h-64 md:h-96 object-cover" alt="{{ $event->title }}">
        @endif

        <!-- Overlay Info -->
        <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/30 to-transparent flex items-end p-6">
            <div>
                <span class="text-xs bg-purple-600 text-white px-3 py-1 rounded-full">{{ $event->category ?? 'Umum' }}</span>
                <h1 class="text-3xl font-bold text-white mt-2">{{ $event->title }}</h1>
            </div>
        </div>
    </div>

    <!-- Konten Detail -->
    <div class="bg-white rounded-2xl shadow p-6 mb-6">
        <!-- Info Event -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div>
                <p class="text-sm text-gray-500 mb-1">📍 Lokasi</p>
                <p class="text-base font-medium text-gray-700">{{ $event->location ?? 'Tidak tersedia' }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500 mb-1">🗓️ Tanggal</p>
                <p class="text-base font-medium text-gray-700">
                    {{ \Illuminate\Support\Carbon::parse($event->starts_at)->format('d M Y H:i') }}
                    @if ($event->ends_at)
                        - {{ \Illuminate\Support\Carbon::parse($event->ends_at)->format('d M Y H:i') }}
                    @endif
                </p>
            </div>
        </div>

        <!-- Status -->
        <div class="mb-4">
            @if($event->ends_at < now())
                <span class="text-sm bg-red-100 text-red-600 px-3 py-1 rounded-full">Event Selesai</span>
            @else
                <span class="text-sm bg-green-100 text-green-600 px-3 py-1 rounded-full">Sedang Berjalan</span>
            @endif
        </div>

        <!-- Tombol Hubungi -->
        @if ($event->contact_whatsapp)
            <a target="_blank" href="https://wa.me/{{ preg_replace('/\D/', '', $event->contact_whatsapp) }}"
                class="inline-flex items-center gap-2 mt-3 px-4 py-2 rounded-lg bg-green-600 text-white text-sm hover:bg-green-700 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 11.5a8.38 8.38 0 01-.9 3.8 8.5 8.5 0 01-7.6 4.7 8.38 8.38 0 01-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 01-.9-3.8 8.5 8.5 0 014.7-7.6 8.38 8.38 0 013.8-.9h.5a8.48 8.48 0 018 8v.5z" />
                </svg>
                Hubungi via WhatsApp
            </a>
        @endif
    </div>

    <!-- Deskripsi -->
    @if ($event->description)
        <div class="bg-white rounded-2xl shadow p-6 prose max-w-none mb-6">
            {!! nl2br(e($event->description)) !!}
        </div>
    @endif

    <!-- Tombol Admin -->
    @auth
        @if (auth()->user()->is_admin)
            <div class="flex gap-3">
                <a href="{{ route('events.edit', $event) }}"
                    class="px-4 py-2 rounded-lg bg-indigo-600 text-white text-sm hover:bg-gray-800 transition">Edit</a>
                <form method="POST" action="{{ route('events.destroy', $event) }}"
                    onsubmit="return confirm('Hapus event?')">
                    @csrf @method('DELETE')
                    <button class="px-4 py-2 rounded-lg bg-red-600 text-white text-sm hover:bg-red-700 transition">Hapus</button>
                </form>
            </div>
        @endif
    @endauth
</div>
@endsection
