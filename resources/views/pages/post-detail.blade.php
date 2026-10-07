<x-layouts.app>
    @section('title', $post->meta_title ?: ($post->title . ' — ' . setting('site_general.site_name', 'Koperasi Anyaman Mansiang')))
    @section('description', $post->meta_description ?: $post->excerpt)
    @section('content')
        <article class="bg-mansiang-canvas">
            <header class="mx-auto max-w-7xl px-4 pt-12 sm:px-6 md:pt-20 lg:px-8">
                <nav class="mb-10 text-sm text-mansiang-taupe" aria-label="Breadcrumb" data-animate>
                    <a href="{{ route('posts.index') }}" class="hover:text-mansiang-green">{{ __('Blog') }}</a>
                    <span class="mx-2">/</span>
                    <span>{{ $post->category?->name }}</span>
                </nav>
                <div class="grid gap-10 md:grid-cols-12 md:items-end">
                    <div class="md:col-span-8" data-animate>
                        <span class="text-xs font-semibold uppercase tracking-[0.22em] text-mansiang-warm">{{ $post->category?->name }}</span>
                        <h1 class="mt-5 max-w-4xl font-display text-4xl font-bold leading-[1.08] text-mansiang-ink md:text-6xl">{{ $post->title }}</h1>
                    </div>
                    <div class="md:col-span-4 md:pb-2" data-animate>
                        <div class="flex flex-wrap gap-x-5 gap-y-2 text-sm text-mansiang-taupe">
                            @if($post->author)<span>{{ $post->author->name }}</span>@endif
                            @if($post->published_at)<span>{{ $post->published_at->format('d M Y') }}</span>@endif
                            <span>{{ $post->reading_time_minutes }} {{ __('menit baca') }}</span>
                        </div>
                    </div>
                </div>
            </header>

            @if($post->featured_image)
                <div class="mx-auto max-w-7xl px-4 pt-12 sm:px-6 md:pt-16 lg:px-8" data-animate>
                    <div class="aspect-[16/9] overflow-hidden bg-mansiang-surface md:aspect-[21/9]">
                        <img src="{{ media_url($post->featured_image) }}" alt="{{ media_alt($post->featured_image, $post->title) }}" loading="eager" fetchpriority="high" decoding="async" class="h-full w-full object-cover">
                    </div>
                </div>
            @endif

            <div class="mx-auto max-w-7xl px-4 py-12 sm:px-6 md:py-20 lg:px-8">
                <div class="grid gap-12 md:grid-cols-12">
                    <aside class="md:col-span-3" data-animate>
                        <div class="border-l border-mansiang-green/30 pl-5 md:sticky md:top-24">
                            <p class="text-xs font-semibold uppercase tracking-widest text-mansiang-warm">{{ __('Diterbitkan') }}</p>
                            <p class="mt-2 text-sm text-mansiang-charcoal">{{ $post->published_at?->format('d M Y') }}</p>
                            <p class="mt-6 text-xs font-semibold uppercase tracking-widest text-mansiang-warm">{{ __('Kategori') }}</p>
                            <p class="mt-2 text-sm text-mansiang-charcoal">{{ $post->category?->name }}</p>
                        </div>
                    </aside>
                    <div class="md:col-span-9 md:col-start-4" data-animate>
                        <div class="prose prose-mansiang max-w-none text-lg leading-relaxed">{!! $post->content !!}</div>
                    </div>
                </div>
            </div>
        </article>

        @if($relatedPosts->isNotEmpty())
            <section class="bg-mansiang-surface">
                <div class="mx-auto max-w-7xl px-4 py-16 sm:px-6 md:py-24 lg:px-8">
                    <div class="mb-10 flex items-end justify-between border-b border-mansiang-green/20 pb-6" data-animate>
                        <x-section-heading :badge="__('Selanjutnya')" :title="__('Baca Juga')" />
                    </div>
                    <div class="grid gap-x-8 gap-y-10 md:grid-cols-3">
                        @foreach($relatedPosts as $related)
                            <article class="group min-w-0" data-animate>
                                <a href="{{ route('posts.show', $related) }}" wire:navigate tabindex="-1" aria-hidden="true" class="block overflow-hidden bg-mansiang-canvas">
                                    <div class="aspect-[4/3]">
                                        <img src="{{ media_url($related->featured_image) }}" alt="{{ media_alt($related->featured_image, $related->title) }}" loading="lazy" decoding="async" class="h-full w-full object-cover transition duration-500 group-hover:scale-105">
                                    </div>
                                </a>
                                <h2 class="mt-5 font-display text-2xl font-bold leading-tight text-mansiang-ink">
                                    <a href="{{ route('posts.show', $related) }}" wire:navigate class="transition hover:text-mansiang-green focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-mansiang-green">{{ $related->title }}</a>
                                </h2>
                                <p class="mt-3 text-sm text-mansiang-taupe">{{ $related->published_at?->format('d M Y') }}</p>
                            </article>
                        @endforeach
                    </div>
                </div>
            </section>
        @endif
    @endsection
</x-layouts.app>
