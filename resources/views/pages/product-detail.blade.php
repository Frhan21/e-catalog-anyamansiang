<x-layouts.app>
    @section('title', $product->name . ' — ' . setting('site_general.site_name', 'Koperasi Anyaman Mansiang'))
    @section('content')
        <section class="mx-auto max-w-6xl px-4 py-10 sm:py-14">
            <nav class="mb-8 flex items-center gap-2 text-sm text-mansiang-taupe" aria-label="Breadcrumb">
                <a href="{{ route('catalog') }}" class="transition hover:text-mansiang-green">{{ __('Katalog') }}</a>
                <span aria-hidden="true">/</span>
                <span class="truncate">{{ $product->category?->name }}</span>
            </nav>

            <div class="grid gap-10 lg:grid-cols-[minmax(0,1.05fr)_minmax(0,1fr)] lg:gap-14">
                <div>
                    @php
                        $gallery = collect([$product->primary_image])->filter()->merge($product->images->pluck('image_path'))->unique()->values();
                    @endphp

                    @if($gallery->count() > 1)
                        <div class="product swiper group relative overflow-hidden rounded-[2rem] bg-mansiang-surface" data-swiper="product">
                            <div class="swiper-wrapper">
                                @foreach($gallery->values() as $index => $image)
                                    <div class="swiper-slide">
                                        <div class="aspect-[4/3] overflow-hidden">
                                            <img src="{{ media_url($image) }}" alt="{{ media_alt($image, $product->name.' — foto '.($index + 1)) }}" @if($index === 0) loading="eager" fetchpriority="high" @else loading="lazy" @endif decoding="async" class="h-full w-full object-cover">
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="swiper-pagination !bottom-4"></div>
                            <button type="button" class="swiper-button-prev absolute left-4 top-1/2 z-10 flex h-10 w-10 -translate-y-1/2 items-center justify-center rounded-full bg-white/85 text-mansiang-ink opacity-0 shadow-sm backdrop-blur transition hover:bg-white group-hover:opacity-100 focus:opacity-100" aria-label="Foto sebelumnya">
                                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75"><path d="m15 18-6-6 6-6"/></svg>
                            </button>
                            <button type="button" class="swiper-button-next absolute right-4 top-1/2 z-10 flex h-10 w-10 -translate-y-1/2 items-center justify-center rounded-full bg-white/85 text-mansiang-ink opacity-0 shadow-sm backdrop-blur transition hover:bg-white group-hover:opacity-100 focus:opacity-100" aria-label="Foto berikutnya">
                                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75"><path d="m9 18 6-6-6-6"/></svg>
                            </button>
                        </div>
                    @else
                        <div class="aspect-[4/3] overflow-hidden rounded-[2rem] bg-mansiang-surface">
                            <img src="{{ media_url($product->primary_image) }}" alt="{{ media_alt($product->primary_image, $product->name) }}" loading="eager" fetchpriority="high" decoding="async" class="h-full w-full object-cover">
                        </div>
                    @endif
                </div>

                <div class="lg:pt-2">
                    <div class="flex flex-wrap items-center gap-3">
                        <span class="inline-flex items-center gap-2 rounded-full bg-mansiang-surface px-3.5 py-1.5 text-xs font-bold uppercase tracking-[0.12em] {{ $product->availability_status->value === 'ready_stock' ? 'text-mansiang-green' : ($product->availability_status->value === 'pre_order' ? 'text-mansiang-warm' : 'text-red-700') }}">
                            <span class="h-1.5 w-1.5 rounded-full {{ $product->availability_status->value === 'ready_stock' ? 'bg-mansiang-green' : ($product->availability_status->value === 'pre_order' ? 'bg-mansiang-warm' : 'bg-red-700') }}"></span>
                            {{ $product->availability_status->value === 'ready_stock' ? __('Ready Stock') : ($product->availability_status->value === 'pre_order' ? __('Pre Order') : __('Stok Habis')) }}
                        </span>
                        @if($product->sku)
                            <span class="text-xs font-semibold uppercase tracking-[0.14em] text-mansiang-taupe">SKU {{ $product->sku }}</span>
                        @endif
                    </div>

                    <h1 class="mt-5 font-display text-4xl font-semibold leading-[1.1] tracking-tight text-balance text-mansiang-ink sm:text-5xl">{{ $product->name }}</h1>
                    <p class="mt-3 text-sm font-medium text-mansiang-taupe">{{ $product->category?->name }}</p>

                    <p class="mt-7 font-display text-3xl font-semibold tracking-tight text-mansiang-warm">Rp {{ number_format($product->price, 0, ',', '.') }}</p>

                    @if($product->availability_status->value === 'pre_order' && $product->estimated_production_days)
                        <p class="mt-3 inline-flex items-center gap-2 rounded-xl bg-mansiang-surface px-4 py-2.5 text-sm text-mansiang-charcoal">
                            <svg class="h-4 w-4 text-mansiang-warm" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 2"/></svg>
                            {{ __('Estimasi produksi :days hari', ['days' => $product->estimated_production_days]) }}
                        </p>
                    @endif

                    @if($product->dimensions || $product->material)
                        <dl class="mt-7 grid grid-cols-2 gap-3">
                            @if($product->dimensions)
                                <div class="rounded-2xl bg-mansiang-surface px-4 py-3">
                                    <dt class="text-xs font-bold uppercase tracking-[0.14em] text-mansiang-taupe">{{ __('Dimensi') }}</dt>
                                    <dd class="mt-1 text-sm font-medium text-mansiang-charcoal">{{ $product->dimensions }}</dd>
                                </div>
                            @endif
                            @if($product->material)
                                <div class="rounded-2xl bg-mansiang-surface px-4 py-3">
                                    <dt class="text-xs font-bold uppercase tracking-[0.14em] text-mansiang-taupe">{{ __('Material') }}</dt>
                                    <dd class="mt-1 text-sm font-medium text-mansiang-charcoal">{{ $product->material }}</dd>
                                </div>
                            @endif
                        </dl>
                    @endif

                    @if($product->description)
                        <div class="mt-8 max-w-prose space-y-4 text-[0.95rem] leading-7 text-mansiang-charcoal/90">
                            {!! $product->description !!}
                        </div>
                    @endif

                    @if($product->usage_instructions)
                        <div class="mt-8 rounded-2xl border border-mansiang-ink/10 bg-mansiang-canvas p-5">
                            <h3 class="font-display text-lg font-semibold text-mansiang-ink">{{ __('Petunjuk Perawatan') }}</h3>
                            <div class="mt-3 space-y-3 text-sm leading-6 text-mansiang-charcoal/85">
                                {!! $product->usage_instructions !!}
                            </div>
                        </div>
                    @endif

                    @php
                        $canOrder = $product->is_active && $product->availability_status->value !== 'out_of_stock';
                        $buyUrl = $canOrder ? \App\Helpers\WhatsAppHelper::orderUrl($product, setting('contact_info', [])) : '#';
                    @endphp
                    <div class="mt-9 flex flex-wrap items-center gap-3">
                        @if($canOrder)
                            <button type="button" x-data @click="$dispatch('add-to-cart', { productId: {{ $product->id }} })" class="inline-flex items-center gap-2 rounded-full border border-mansiang-ink/15 px-6 py-3 text-sm font-semibold text-mansiang-charcoal transition hover:border-mansiang-green hover:text-mansiang-green active:scale-[0.98]">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z"/><path stroke-linecap="round" stroke-linejoin="round" d="M3 6h18"/></svg>
                                {{ __('Tambah ke Keranjang') }}
                            </button>
                            <a href="{{ $buyUrl }}" target="_blank" rel="noopener" class="inline-flex items-center gap-2 rounded-full bg-mansiang-green px-6 py-3 text-sm font-bold text-white transition hover:bg-mansiang-dark active:scale-[0.98]">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M13 5h6m0 0v6m0-6L10 14"/><path stroke-linecap="round" stroke-linejoin="round" d="M5 7v12h12"/></svg>
                                {{ __('Beli Sekarang') }}
                            </a>
                        @endif
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" target="_blank" rel="noopener" class="inline-flex items-center gap-2 rounded-full border border-mansiang-ink/15 px-6 py-3 text-sm font-semibold text-mansiang-charcoal transition hover:border-mansiang-green hover:text-mansiang-green active:scale-[0.98]">
                            {{ __('Bagikan ke Facebook') }}
                        </a>
                    </div>
                </div>
            </div>

            @if($related->isNotEmpty())
                <section class="mt-20 border-t border-mansiang-ink/10 pt-12">
                    <x-section-heading :badge="__('Lainnya')" :title="__('Produk Terkait')" />
                    <div class="mt-8 grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
                        @foreach($related as $relatedProduct)
                            <x-product-card :product="$relatedProduct" />
                        @endforeach
                    </div>
                </section>
            @endif
        </section>
    @endsection
</x-layouts.app>
