{{-- HERO / CAROUSEL --}}
<section x-data="heroSlider()" x-init="init()" @mouseenter="pause()" @mouseleave="resume()" class="relative">
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
                                <img :src="s.thumb1" class="w-8 h-8 rounded-full ring-2 ring-white"
                                    alt="">
                                <img :src="s.thumb2" class="w-8 h-8 rounded-full ring-2 ring-white"
                                    alt="">
                                <img :src="s.thumb3" class="w-8 h-8 rounded-full ring-2 ring-white"
                                    alt="">
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
