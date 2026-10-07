<x-layouts.app>
    @section('title', __('Tentang Kami') . ' — ' . setting('site_general.site_name', 'Koperasi Anyaman Mansiang'))
    @section('content')
        <section class="overflow-hidden bg-mansiang-dark text-mansiang-ivory">
            <div class="mx-auto grid max-w-7xl gap-10 px-4 py-16 sm:px-6 md:grid-cols-12 md:py-24 lg:px-8">
                <div class="md:col-span-8" data-animate>
                    <p class="mb-5 text-xs font-semibold uppercase tracking-[0.24em] text-mansiang-ochre">{{ __('Kisah kami') }}</p>
                    <h1 class="max-w-4xl font-display text-5xl font-bold leading-[1.05] md:text-7xl">{{ __('Tradisi yang tumbuh bersama masyarakat.') }}</h1>
                </div>
                <div class="flex items-end md:col-span-4 md:pb-2" data-animate>
                    <p class="max-w-sm border-l border-mansiang-ivory/30 pl-5 text-base leading-relaxed text-mansiang-ivory/75">{{ setting('site_general.site_tagline') }}</p>
                </div>
            </div>
        </section>

        <section class="mx-auto max-w-7xl px-4 py-16 sm:px-6 md:py-28 lg:px-8">
            <div class="grid items-start gap-10 md:grid-cols-12 md:gap-8">
                <div class="md:col-span-7" data-animate>
                    <div class="aspect-[5/6] overflow-hidden bg-mansiang-surface md:aspect-[4/3]">
                        <img src="{{ media_url(setting('about_content.hero_image'), 'settings/about-hero.jpg') }}" alt="{{ media_alt(setting('about_content.hero_image'), __('Tentang Kami')) }}" class="h-full w-full object-cover">
                    </div>
                </div>
                <div class="md:col-span-5 md:pt-20" data-animate>
                    <span class="font-display text-5xl text-mansiang-ochre/70">01</span>
                    <h2 class="mt-6 font-display text-3xl font-bold leading-tight text-mansiang-ink md:text-5xl">{{ setting('about_content.history_title', 'Awal Mula Perjalanan Koperasi') }}</h2>
                    <div class="prose prose-mansiang mt-6 max-w-none leading-relaxed">{!! setting('about_content.history_narrative', 'Berawal dari kearifan lokal masyarakat Taratak dalam memanfaatkan tanaman mansiang.') !!}</div>
                </div>
            </div>
        </section>

        <section class="bg-mansiang-surface">
            <div class="mx-auto grid max-w-7xl gap-8 px-4 py-16 sm:px-6 md:grid-cols-12 md:py-24 lg:px-8">
                <div class="md:col-span-4" data-animate>
                    <span class="font-display text-5xl text-mansiang-warm/60">02</span>
                </div>
                <div class="md:col-span-8" data-animate>
                    <h2 class="max-w-3xl font-display text-3xl font-bold leading-tight text-mansiang-ink md:text-5xl">{{ setting('about_content.impact_title', 'Dampak Sosial & Ekonomi') }}</h2>
                    <div class="prose prose-mansiang mt-6 max-w-2xl leading-relaxed">{!! setting('about_content.impact_narrative', 'Melalui koperasi ini, hasil anyaman memiliki nilai jual lebih tinggi.') !!}</div>
                </div>
            </div>
        </section>

        <section class="mx-auto max-w-7xl px-4 py-16 sm:px-6 md:py-28 lg:px-8">
            <div class="mb-10 flex items-end justify-between border-b border-mansiang-green/20 pb-6" data-animate>
                <h2 class="font-display text-3xl font-bold text-mansiang-ink md:text-5xl">{{ __('Galeri Kegiatan') }}</h2>
                <span class="hidden text-sm text-mansiang-taupe sm:block">{{ __('Karya, proses, dan kebersamaan') }}</span>
            </div>
            @php($galleryItems = array_slice((array) setting('about_content.gallery', []), 0, 10))
            <div data-gallery-grid class="grid grid-cols-2 gap-3 md:grid-cols-12 md:gap-5">
                @foreach($galleryItems as $index => $item)
                    @php($isWide = in_array($index, [0, 3, 6, 9], true))
                    <figure class="group relative aspect-[4/5] overflow-hidden rounded-2xl bg-mansiang-surface {{ $isWide ? 'md:col-span-7 md:aspect-[16/10]' : 'md:col-span-5 md:aspect-[4/5]' }}" data-animate>
                        <img src="{{ media_url($item['image'] ?? null, 'settings/gallery-'.($index + 1).'.jpg') }}" alt="{{ media_alt($item['image'] ?? null, $item['caption'] ?? '') }}" loading="lazy" class="h-full w-full object-cover transition duration-700 group-hover:scale-105">
                        <div class="pointer-events-none absolute inset-0 bg-gradient-to-t from-mansiang-dark via-mansiang-dark/25 to-transparent opacity-60 transition-opacity duration-500 md:opacity-40 md:group-hover:opacity-80"></div>
                        @if($item['caption'] ?? null)
                            <figcaption class="absolute inset-x-0 bottom-0 p-4 text-sm text-mansiang-ivory transition duration-500 md:translate-y-3 md:opacity-0 md:group-hover:translate-y-0 md:group-hover:opacity-100">
                                <span class="font-semibold">{{ $item['caption'] }}</span>
                            </figcaption>
                        @endif
                    </figure>
                @endforeach
            </div>
        </section>
    @endsection
</x-layouts.app>
