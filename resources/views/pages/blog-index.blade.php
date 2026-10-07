<x-layouts.app>
    @section('title', 'Blog — ' . setting('site_general.site_name', 'Koperasi Anyaman Mansiang'))
    @section('content')
        <section class="bg-mansiang-surface">
            <div class="mx-auto max-w-7xl px-4 py-12 sm:px-6 md:py-16 lg:px-8" data-animate>
                <p class="text-xs font-semibold uppercase tracking-[0.24em] text-mansiang-warm">{{ __('Jurnal koperasi') }}</p>
                <div class="mt-5 grid gap-5 md:grid-cols-12 md:items-end">
                    <h1 class="font-display text-4xl font-bold leading-[1.05] tracking-tight text-mansiang-ink md:col-span-7 md:text-6xl">{{ __('Blog anyaman mansiang') }}</h1>
                    <p class="max-w-xl text-base leading-relaxed text-mansiang-taupe md:col-span-5 md:justify-self-end">{{ __('Kisah pengrajin, kabar koperasi, dan cara merawat produk anyaman.') }}</p>
                </div>
            </div>
        </section>

        <section class="mx-auto max-w-7xl px-4 py-10 sm:px-6 md:py-16 lg:px-8">
            <nav aria-label="{{ __('Kategori artikel') }}" class="mb-10 flex flex-wrap gap-2 border-b border-mansiang-green/20 pb-5" data-animate>
                <a href="{{ route('posts.index') }}" wire:navigate @if(!isset($currentCategory)) aria-current="page" @endif class="rounded-full px-4 py-2 text-sm font-semibold transition focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-mansiang-green {{ !isset($currentCategory) ? 'bg-mansiang-dark text-mansiang-ivory shadow-sm' : 'text-mansiang-charcoal hover:bg-mansiang-surface' }}">{{ __('Semua') }}</a>
                @foreach($categories as $category)
                    <a href="{{ route('posts.category', $category) }}" wire:navigate @if(isset($currentCategory) && $currentCategory->id === $category->id) aria-current="page" @endif class="rounded-full px-4 py-2 text-sm font-semibold transition focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-mansiang-green {{ isset($currentCategory) && $currentCategory->id === $category->id ? 'bg-mansiang-dark text-mansiang-ivory shadow-sm' : 'text-mansiang-charcoal hover:bg-mansiang-surface' }}">{{ $category->name }}</a>
                @endforeach
            </nav>

            <div class="grid gap-x-8 gap-y-12 md:grid-cols-2">
                @forelse($posts as $post)
                    <article class="group min-w-0 {{ $loop->first ? 'md:col-span-2 md:grid md:grid-cols-12 md:gap-10 md:items-center border-b border-mansiang-green/20 pb-12' : '' }}" data-animate>
                        <a href="{{ route('posts.show', $post) }}" wire:navigate tabindex="-1" aria-hidden="true" class="block overflow-hidden rounded-2xl bg-mansiang-surface {{ $loop->first ? 'md:col-span-7' : '' }}">
                            <div class="{{ $loop->first ? 'aspect-[16/10]' : 'aspect-[16/10]' }}">
                                <img src="{{ media_url($post->featured_image) }}" alt="{{ media_alt($post->featured_image, $post->title) }}" @if($loop->first) loading="eager" fetchpriority="high" @else loading="lazy" @endif decoding="async" class="h-full w-full object-cover transition duration-500 group-hover:scale-105">
                            </div>
                        </a>
                        <div class="pt-5 {{ $loop->first ? 'md:col-span-5 md:py-8' : '' }}">
                            @if($post->category)
                                <span class="text-xs font-semibold uppercase tracking-widest text-mansiang-warm">{{ $post->category->name }}</span>
                            @endif
                            <h2 class="mt-3 font-display font-bold leading-tight tracking-tight text-mansiang-ink {{ $loop->first ? 'text-3xl lg:text-5xl' : 'text-2xl' }}">
                                <a href="{{ route('posts.show', $post) }}" wire:navigate class="transition hover:text-mansiang-green focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-mansiang-green">{{ $post->title }}</a>
                            </h2>
                            <p class="mt-4 max-w-xl text-sm leading-relaxed text-mansiang-taupe line-clamp-3">{{ $post->excerpt }}</p>
                            <p class="mt-5 text-xs font-medium text-mansiang-taupe">{{ $post->published_at?->format('d M Y') }} · {{ __(':count menit', ['count' => $post->reading_time_minutes]) }}</p>
                        </div>
                    </article>
                @empty
                    <div class="col-span-full rounded-2xl bg-mansiang-surface px-6 py-16 text-center" data-animate>
                        <p class="font-display text-3xl font-semibold text-mansiang-ink">{{ __('Belum ada artikel.') }}</p>
                        <p class="mx-auto mt-3 max-w-md text-sm leading-relaxed text-mansiang-taupe">{{ __('Artikel akan muncul setelah koperasi menerbitkan cerita baru.') }}</p>
                        <a href="{{ route('posts.index') }}" wire:navigate class="mt-6 inline-flex rounded-full bg-mansiang-dark px-5 py-2.5 text-sm font-semibold text-mansiang-ivory transition hover:bg-mansiang-green focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-mansiang-green">{{ __('Lihat semua artikel') }}</a>
                    </div>
                @endforelse
            </div>

            @if($posts->hasPages())
                <nav class="mt-12" aria-label="{{ __('Navigasi halaman artikel') }}">
                    {{ $posts->links() }}
                </nav>
            @endif
        </section>
    @endsection
</x-layouts.app>
