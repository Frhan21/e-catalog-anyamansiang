<x-layouts.app>
    @section('title', setting('site_general.site_name', 'Koperasi Anyaman Mansiang'))
    @section('content')
        <section class="relative overflow-hidden bg-mansiang-dark text-mansiang-ivory">
            <div class="swiper" data-swiper="hero">
                <div class="swiper-wrapper">
                    @forelse((array) setting('landing_hero.slides', []) as $slide)
                        <div class="swiper-slide relative min-h-[calc(100dvh-5rem)]">
                            <img src="{{ media_url($slide['image'] ?? null, 'settings/hero-slide-1.jpg') }}" alt="{{ media_alt($slide['image'] ?? null, $slide['caption'] ?? '') }}" class="absolute inset-0 h-full w-full object-cover">
                            <div class="absolute inset-0 bg-gradient-to-r from-mansiang-dark via-mansiang-dark/80 to-mansiang-dark/20"></div>
                            <div class="absolute inset-0 bg-gradient-to-t from-mansiang-dark/90 via-transparent to-mansiang-dark/30"></div>
                            <div class="relative flex min-h-[calc(100dvh-5rem)] items-center py-12 sm:py-16">
                                <div class="mx-auto w-full max-w-7xl px-4 sm:px-6 lg:px-8">
                                    <div class="max-w-4xl">
                                        <span class="text-xs font-bold uppercase tracking-[0.24em] text-mansiang-ochre" data-animate="load">{{ setting('landing_hero.badge', 'Kerajinan Asli Taratak') }}</span>
                                        <h1 class="mt-5 max-w-4xl font-display text-4xl font-semibold leading-[0.98] tracking-[-0.04em] text-balance md:text-6xl lg:text-7xl" data-animate="load">{{ setting('landing_hero.headline', 'Sentuhan Tradisi, Keindahan Alami yang Abadi') }}</h1>
                                        <p class="mt-6 max-w-2xl text-base leading-7 text-mansiang-ivory/80 sm:text-lg" data-animate="load">{{ setting('landing_hero.subheadline', 'Koleksi anyaman tangan eksklusif dari serat mansiang pilihan.') }}</p>
                                        <div class="mt-9 flex flex-wrap items-center gap-4" data-animate="load">
                                            <a href="{{ setting('landing_hero.cta_link', '/catalog') }}" class="rounded-full bg-mansiang-ochre px-8 py-4 font-bold text-mansiang-dark shadow-xl shadow-mansiang-ochre/30 transition hover:bg-mansiang-warm active:translate-y-px">
                                                {{ setting('landing_hero.cta_text', 'Jelajahi Katalog') }}
                                            </a>
                                             <a href="{{ route('about') }}" class="rounded-full border border-mansiang-ivory/30 px-8 py-4 font-semibold text-mansiang-ivory transition hover:border-mansiang-ivory hover:bg-mansiang-ivory/10">
                                                {{ __('Cerita Kami') }}
                                            </a>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    @empty
                        <div class="swiper-slide relative min-h-[calc(100dvh-5rem)]">
                            <div class="absolute inset-0 bg-mansiang-dark"></div>
                            <div class="relative flex min-h-[calc(100dvh-5rem)] items-center py-12 sm:py-16">
                                <div class="mx-auto w-full max-w-7xl px-4 sm:px-6 lg:px-8">
                                    <h1 class="font-display text-4xl font-semibold leading-[0.98] tracking-[-0.04em]">{{ setting('landing_hero.headline', 'Sentuhan Tradisi, Keindahan Alami yang Abadi') }}</h1>
                                </div>
                            </div>
                        </div>
                    @endforelse
                </div>
                <div class="swiper-pagination !bottom-10"></div>
                <button type="button" class="swiper-button-prev !left-4 !top-1/2 !-translate-y-1/2 absolute flex h-12 w-12 items-center justify-center rounded-full border border-mansiang-ivory/40 bg-mansiang-dark/40 backdrop-blur !text-mansiang-ivory transition hover:bg-mansiang-dark/70" aria-label="@lang('Foto sebelumnya')">
                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" aria-hidden="true"><path d="m15 18-6-6 6-6"/></svg>
                </button>
                <button type="button" class="swiper-button-next !right-4 !top-1/2 !-translate-y-1/2 absolute flex h-12 w-12 items-center justify-center rounded-full border border-mansiang-ivory/40 bg-mansiang-dark/40 backdrop-blur !text-mansiang-ivory" aria-label="@lang('Foto berikutnya')">
                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" aria-hidden="true"><path d="m9 18 6-6-6-6"/></svg>
                </button>
            </div>
        </section>

        <section class="bg-mansiang-canvas py-24 md:py-32">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="grid items-center gap-14 md:grid-cols-2 lg:gap-20">
                    <div class="relative order-2 md:order-1">
                        <div class="aspect-[4/5] overflow-hidden rounded-[2.5rem] shadow-2xl shadow-mansiang-dark/30" data-animate>
                            <img src="{{ media_url(setting('landing_about.primary_image'), 'settings/about-landing.jpg') }}" alt="{{ media_alt(setting('landing_about.primary_image'), 'Tentang Kami') }}" class="h-full w-full object-cover">
                        </div>
                        <div class="absolute -bottom-8 -right-4 hidden aspect-square w-48 overflow-hidden rounded-[2rem] border-8 border-mansiang-canvas shadow-xl lg:block" data-animate>
                            <img src="{{ media_url(setting('about_content.hero_image'), 'settings/about-hero.jpg') }}" alt="{{ media_alt(setting('about_content.hero_image'), 'Detail') }}" class="h-full w-full object-cover">
                        </div>
                    </div>
                    <div class="order-1 md:order-2">
                        <x-section-heading
                            :badge="setting('landing_about.badge', 'Filosofi Anyaman')"
                            :title="setting('landing_about.title', 'Tumbuh dari Rawa, Dianyam dengan Cinta')"
                            :subtitle="setting('landing_about.description', 'Tanaman mansiang dipanen secara berkelanjutan dari rawa alami Taratak.')"
                        />
                        <ul class="mt-8 space-y-5">
                            @foreach((array) setting('landing_about.highlight_points', []) as $point)
                                <li class="flex items-start gap-4" data-animate>
                                    <span class="mt-1 flex h-6 w-6 shrink-0 items-center justify-center rounded-full bg-mansiang-green/10 text-mansiang-green">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                    </span>
                                    <div>
                                        <p class="font-bold text-mansiang-ink">{{ $point['label'] ?? '' }}</p>
                                        <p class="text-sm leading-relaxed text-mansiang-taupe">{{ $point['desc'] ?? '' }}</p>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                        <a href="{{ route('about') }}" class="mt-10 inline-flex items-center gap-2 font-bold text-mansiang-green transition hover:text-mansiang-ink" data-animate>
                            {{ __('Baca Selengkapnya') }}
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <section class="bg-mansiang-surface py-24 md:py-32">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-2 gap-8 rounded-[2.5rem] bg-mansiang-dark p-10 text-center md:grid-cols-4 md:p-14" data-animate>
                    @foreach((array) setting('landing_stats.stats', []) as $stat)
                        <div>
                            <p class="font-display text-4xl font-bold text-mansiang-ochre md:text-5xl" data-counter-value="{{ $stat['value'] ?? '' }}">{{ $stat['value'] ?? '' }}</p>
                            <p class="mt-2 text-sm text-mansiang-ivory/70">{{ $stat['label'] ?? '' }}</p>
                        </div>
                    @endforeach
                </div>
                <div class="mt-20 grid gap-12 lg:grid-cols-[minmax(16rem,0.7fr)_minmax(0,1.3fr)] lg:items-start lg:gap-16" data-purpose-grid>
                    <div class="lg:sticky lg:top-28">
                        <x-section-heading
                            :badge="setting('landing_purpose.badge', 'Tujuan Koperasi')"
                            :title="setting('landing_purpose.title', 'Membawa Manfaat bagi Bumi dan Masyarakat')"
                            :subtitle="setting('landing_purpose.subtitle', 'Koperasi Anyaman Mansiang hadir bukan hanya sebagai wadah usaha.')"
                        />
                    </div>
                    <div class="grid gap-6 sm:grid-cols-2">
                        @foreach(array_slice((array) setting('landing_purpose.items', []), 0, 4) as $index => $item)
                            <article class="group relative min-h-72 overflow-hidden rounded-[2rem] lg:min-h-80" data-animate>
                                <img src="{{ media_url($item['image'] ?? null, 'settings/purpose-'.($index + 1).'.jpg') }}" alt="{{ media_alt($item['image'] ?? null, $item['title'] ?? '') }}" class="absolute inset-0 h-full w-full object-cover transition duration-700 group-hover:scale-105">
                                <div class="absolute inset-x-0 bottom-0 bg-gradient-to-t from-mansiang-dark via-mansiang-dark/70 to-transparent p-6">
                                    <h3 class="font-display text-xl font-bold text-mansiang-ivory">{{ $item['title'] ?? '' }}</h3>
                                    <p class="mt-1 text-sm text-mansiang-ivory/80">{{ $item['description'] ?? '' }}</p>
                                </div>
                            </article>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>

        <section class="bg-mansiang-canvas py-24 md:py-32">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="flex items-end justify-between gap-6">
                    <x-section-heading :badge="__('Koleksi')" :title="__('Produk Unggulan')" :subtitle="__('Pilihan terbaik dari pengrajin Taratak.')" />
                    <a href="{{ route('catalog') }}" class="hidden shrink-0 items-center gap-2 rounded-full border border-mansiang-ink/15 px-6 py-3 font-bold text-mansiang-ink transition hover:border-mansiang-green hover:text-mansiang-green sm:inline-flex">
                        {{ __('Lihat Semua') }}
                    </a>
                </div>
                <div class="mt-12 grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
                    @forelse($featured as $product)
                        <x-product-card :product="$product" />
                    @empty
                        <p class="col-span-full py-16 text-center text-mansiang-taupe">{{ __('Belum ada produk unggulan.') }}</p>
                    @endforelse
                </div>
            </div>
        </section>

        <section class="bg-mansiang-canvas pb-24 md:pb-32">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="flex items-end justify-between gap-6">
                    <x-section-heading :badge="__('Cerita')" :title="__('Kisah Terbaru')" :subtitle="__('Dari pengrajin dan koperasi.')" />
                    <a href="{{ route('posts.index') }}" class="hidden shrink-0 items-center gap-2 rounded-full border border-mansiang-ink/15 px-6 py-3 font-bold text-mansiang-ink transition hover:border-mansiang-green hover:text-mansiang-green sm:inline-flex">
                        {{ __('Semua Artikel') }}
                    </a>
                </div>
                <div class="mt-12 grid gap-6 md:grid-cols-3">
                    @forelse($latestPosts as $post)
                        <article class="group overflow-hidden rounded-[2rem] bg-white shadow-[0_18px_45px_-35px_rgba(42,61,47,.45)] ring-1 ring-mansiang-ink/10 transition hover:-translate-y-1" data-animate>
                            <a href="{{ route('posts.show', $post) }}" wire:navigate>
                                <div class="aspect-[16/10] bg-mansiang-surface overflow-hidden">
                                    <img src="{{ media_url($post->featured_image) }}" alt="{{ $post->title }}" class="h-full w-full object-cover transition duration-500 group-hover:scale-105">
                                </div>
                            </a>
                            <div class="p-6">
                                <span class="text-xs font-bold uppercase tracking-[0.18em] text-mansiang-ochre">{{ $post->category?->name }}</span>
                                <a href="{{ route('posts.show', $post) }}" wire:navigate class="mt-2 block font-display text-xl font-semibold leading-snug text-mansiang-ink hover:text-mansiang-green">{{ $post->title }}</a>
                                <p class="mt-2 text-sm leading-relaxed text-mansiang-taupe line-clamp-2">{{ $post->excerpt }}</p>
                                <p class="mt-4 text-xs text-mansiang-taupe">{{ $post->published_at?->format('d M Y') }} · {{ $post->reading_time_minutes }} {{ __('menit baca') }}</p>
                            </div>
                        </article>
                    @empty
                        <p class="col-span-full py-16 text-center text-mansiang-taupe">{{ __('Belum ada artikel.') }}</p>
                    @endforelse
                </div>
            </div>
        </section>
    @endsection
</x-layouts.app>
