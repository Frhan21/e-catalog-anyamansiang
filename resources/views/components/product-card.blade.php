@php
    $canOrder = $product->is_active && $product->availability_status->value !== 'out_of_stock';
    $buyUrl = $canOrder ? \App\Helpers\WhatsAppHelper::orderUrl($product, setting('contact_info', [])) : '#';
@endphp
<article class="group overflow-hidden rounded-2xl bg-white ring-1 ring-mansiang-ink/10 transition duration-300 hover:-translate-y-1 hover:shadow-[0_24px_70px_-40px_rgba(42,61,47,.45)] active:translate-y-0">
    <a href="{{ route('products.show', $product) }}" wire:navigate>
        <div class="aspect-[4/3] bg-mansiang-surface overflow-hidden">
            <img src="{{ media_url($product->primary_image) }}" alt="{{ media_alt($product->primary_image, $product->name) }}" loading="lazy" class="h-full w-full object-cover transition duration-500 group-hover:scale-105">
        </div>
    </a>
    <div class="p-5">
        <div class="flex items-center justify-between gap-3 text-xs text-mansiang-taupe">
            <span class="font-semibold text-mansiang-green">{{ $product->category?->name }}</span>
            <span class="rounded-full px-3 py-1 {{ $product->availability_status->value === 'ready_stock' ? 'bg-mansiang-green/10 text-mansiang-green' : ($product->availability_status->value === 'pre_order' ? 'bg-mansiang-ochre/15 text-mansiang-warm' : 'bg-red-100 text-red-800') }}">
                {{ $product->availability_status->value === 'ready_stock' ? __('Ready Stock') : ($product->availability_status->value === 'pre_order' ? __('Pre Order') : __('Kosong')) }}
            </span>
        </div>
        <a href="{{ route('products.show', $product) }}" wire:navigate class="mt-3 block font-display text-lg font-semibold leading-snug text-mansiang-ink hover:text-mansiang-green">{{ $product->name }}</a>
        <p class="mt-4 text-lg font-bold text-mansiang-warm">Rp {{ number_format($product->price, 0, ',', '.') }}</p>

        @if($canOrder)
            <div class="mt-5 grid grid-cols-2 gap-2">
                <a href="{{ $buyUrl }}" target="_blank" rel="noopener" class="inline-flex items-center justify-center gap-1.5 rounded-full bg-mansiang-green px-4 py-2.5 text-xs font-bold text-white transition hover:bg-mansiang-dark">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M13 5h6m0 0v6m0-6L10 14"/><path stroke-linecap="round" stroke-linejoin="round" d="M5 7v12h12"/></svg>
                    {{ __('Beli') }}
                </a>
                <button type="button" x-data @click="$dispatch('add-to-cart', { productId: {{ $product->id }} })" class="inline-flex items-center justify-center gap-1.5 rounded-full border border-mansiang-ink/15 px-4 py-2.5 text-xs font-bold text-mansiang-charcoal transition hover:border-mansiang-green hover:text-mansiang-green">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z"/><path stroke-linecap="round" stroke-linejoin="round" d="M3 6h18"/></svg>
                    {{ __('Keranjang') }}
                </button>
            </div>
        @endif
    </div>
</article>
