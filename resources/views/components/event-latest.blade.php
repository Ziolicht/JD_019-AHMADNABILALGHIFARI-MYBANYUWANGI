    {{-- EVENT Terbaru --}}
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
