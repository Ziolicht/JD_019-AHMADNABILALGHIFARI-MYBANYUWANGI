@extends('layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto p-6">
        <h1 class="text-3xl font-extrabold text-gray-800 mb-8 text-center">Kalender Event</h1>

        <!-- Header Bulan -->
        <div class="flex justify-between items-center mb-6">
            <button class="flex items-center px-4 py-2 bg-white shadow rounded-lg hover:bg-gray-100 transition">
                <i class="fa-solid fa-chevron-left mr-2 text-gray-500"></i> Sebelumnya
            </button>
            <h2 class="text-2xl font-bold text-indigo-600">{{ \Carbon\Carbon::now()->translatedFormat('F Y') }}</h2>
            <button class="flex items-center px-4 py-2 bg-white shadow rounded-lg hover:bg-gray-100 transition">
                Berikutnya <i class="fa-solid fa-chevron-right ml-2 text-gray-500"></i>
            </button>
        </div>

        <!-- Kalender Grid -->
        <div class="bg-white rounded-2xl shadow-lg p-4">
            <div class="grid grid-cols-7 text-center font-semibold text-gray-600 border-b pb-3">
                <div>Sen</div>
                <div>Sel</div>
                <div>Rab</div>
                <div>Kam</div>
                <div>Jum</div>
                <div>Sab</div>
                <div>Min</div>
            </div>

            <div class="grid grid-cols-7 gap-2 mt-3">
                @foreach ($dates as $date)
                    @php
                        $dayEvents = $events->filter(function ($event) use ($date) {
                            return \Carbon\Carbon::parse($event->starts_at)->isSameDay($date);
                        });

                        $isToday = $date->isToday();
                    @endphp
                    <div
                        class="relative h-28 border rounded-xl p-3 flex flex-col justify-between bg-gray-50 hover:bg-indigo-50 transition shadow-sm">
                        <a href="{{ route('events.list', ['date' => $date->format('Y-m-d')]) }}"
                            class="absolute inset-0 z-10"></a>

                        <span class="text-sm font-bold {{ $isToday ? 'text-indigo-600' : 'text-gray-700' }}">
                            {{ $date->format('d') }}
                        </span>

                        @php
                            $now = \Carbon\Carbon::now();
                            $statusClass = '';
                            if ($dayEvents->count() > 0) {
                                if ($dayEvents->every(fn($event) => \Carbon\Carbon::parse($event->ends_at)->isPast())) {
                                    $statusClass = 'bg-gray-400'; // semua event selesai
                                // } elseif (
                                //     $dayEvents->some(fn($event) => \Carbon\Carbon::parse($event->starts_at)->isFuture())
                                // ) {
                                //     $statusClass = 'bg-yellow-500'; // ada yang belum dimulai
                                } else {
                                    $statusClass = 'bg-green-500'; // sedang berjalan
                                }
                            }
                        @endphp

                        @if ($dayEvents->count() > 0)
                            <span class="absolute top-2 right-2 w-2 h-2 rounded-full {{ $statusClass }}"></span>
                        @endif

                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
