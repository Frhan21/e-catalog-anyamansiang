<div class="mx-auto max-w-7xl space-y-8 px-4 py-8 sm:px-6 sm:py-12 lg:px-8">
    <section class="relative overflow-hidden rounded-3xl bg-mansiang-dark px-5 py-8 text-white shadow-[0_24px_70px_-45px_rgba(42,61,47,.8)] sm:px-8 sm:py-10 lg:px-12 lg:py-14">
        <div class="pointer-events-none absolute -right-16 -top-20 h-64 w-64 rounded-full border border-white/10"></div>
        <div class="pointer-events-none absolute -bottom-24 right-24 h-48 w-48 rounded-full bg-mansiang-ochre/10 blur-3xl"></div>

        <div class="relative grid gap-8 lg:grid-cols-[minmax(0,1fr)_18rem] lg:items-end">
            <div>
                <p class="text-xs font-bold uppercase tracking-[0.22em] text-mansiang-ochre">{{ __('Koleksi pengrajin') }}</p>
                <h2 class="mt-3 max-w-2xl font-display text-3xl font-semibold leading-tight tracking-tight text-balance sm:text-4xl">{{ __('Anyaman bernilai guna, dibuat dengan ketekunan.') }}</h2>
                <p class="mt-4 max-w-xl text-sm leading-7 text-white/65 sm:text-base">{{ __('Temukan karya mansiang untuk rumah, hadiah, dan kebutuhan sehari-hari.') }}</p>
            </div>

            <label class="group relative block">
                <span class="sr-only">{{ __('Cari produk') }}</span>
                <svg class="pointer-events-none absolute left-4 top-1/2 h-5 w-5 -translate-y-1/2 text-white/45 transition group-focus-within:text-mansiang-ochre" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" aria-hidden="true">
                    <circle cx="11" cy="11" r="7"></circle>
                    <path d="m20 20-3.5-3.5"></path>
                </svg>
                <input wire:model.live.debounce.300ms="search" type="search" placeholder="{{ __('Cari nama, SKU, material...') }}" class="w-full rounded-full border border-white/15 bg-white/10 py-3.5 pl-12 pr-5 text-sm text-white outline-none placeholder:text-white/40 transition focus:border-mansiang-ochre focus:bg-white/15 focus:ring-2 focus:ring-mansiang-ochre/30">
            </label>
        </div>
    </section>

    <section class="grid gap-8 lg:grid-cols-[14rem_minmax(0,1fr)] xl:grid-cols-[16rem_minmax(0,1fr)] lg:items-start">
        <aside class="lg:sticky lg:top-24">
            <details class="group rounded-2xl border border-mansiang-ink/10 bg-white p-5 lg:rounded-none lg:border-0 lg:bg-transparent lg:p-0" open>
                <summary class="flex cursor-pointer list-none items-center justify-between gap-4 lg:pointer-events-none">
                    <h3 class="font-display text-xl font-semibold text-mansiang-ink">{{ __('Saring koleksi') }}</h3>
                    <span class="text-sm font-semibold text-mansiang-green group-open:hidden lg:hidden">{{ __('Buka') }}</span>
                    <span class="hidden text-sm font-semibold text-mansiang-green group-open:inline lg:hidden">{{ __('Tutup') }}</span>
                </summary>
                <div class="mt-5 space-y-6 border-t border-mansiang-ink/10 pt-5 lg:mt-4 lg:pt-4">
                    <button type="button" wire:click="resetFilters" class="text-xs font-bold uppercase tracking-[0.14em] text-mansiang-warm transition hover:text-mansiang-ink focus:outline-none focus:ring-2 focus:ring-mansiang-green/30">{{ __('Reset filter') }}</button>

                    <fieldset>
                        <legend class="mb-3 text-xs font-bold uppercase tracking-[0.16em] text-mansiang-taupe">{{ __('Kategori') }}</legend>
                        <div class="space-y-2">
                            @foreach($categories as $category)
                                <label class="group flex cursor-pointer items-center justify-between gap-3 py-1.5 text-sm text-mansiang-charcoal">
                                    <span class="transition group-hover:text-mansiang-green">{{ $category->name }}</span>
                                    <input type="checkbox" wire:model.live="selectedCategories" value="{{ $category->id }}" class="rounded border-mansiang-ink/20 text-mansiang-green focus:ring-mansiang-green">
                                </label>
                            @endforeach
                        </div>
                    </fieldset>

                    <label class="block">
                        <span class="mb-2 block text-xs font-bold uppercase tracking-[0.16em] text-mansiang-taupe">{{ __('Ketersediaan') }}</span>
                        <select wire:model.live="availability" class="w-full rounded-xl border border-mansiang-ink/10 bg-white px-3.5 py-3 text-sm text-mansiang-charcoal outline-none transition focus:border-mansiang-green focus:ring-2 focus:ring-mansiang-green/20">
                            <option value="">{{ __('Semua status') }}</option>
                            @foreach($availabilityOptions as $value => $label)
                                <option value="{{ $value }}">{{ $label }}</option>
                            @endforeach
                        </select>
                    </label>

                    <fieldset>
                        <legend class="mb-2 text-xs font-bold uppercase tracking-[0.16em] text-mansiang-taupe">{{ __('Rentang harga') }}</legend>
                        <div class="grid grid-cols-2 gap-2">
                            <label>
                                <span class="sr-only">{{ __('Harga minimum') }}</span>
                                <input wire:model.live.debounce.300ms="minPrice" type="number" min="0" placeholder="{{ __('Minimum') }}" class="w-full rounded-xl border border-mansiang-ink/10 bg-white px-3 py-3 text-sm text-mansiang-charcoal outline-none transition focus:border-mansiang-green focus:ring-2 focus:ring-mansiang-green/20">
                            </label>
                            <label>
                                <span class="sr-only">{{ __('Harga maksimum') }}</span>
                                <input wire:model.live.debounce.300ms="maxPrice" type="number" min="0" placeholder="{{ __('Maksimum') }}" class="w-full rounded-xl border border-mansiang-ink/10 bg-white px-3 py-3 text-sm text-mansiang-charcoal outline-none transition focus:border-mansiang-green focus:ring-2 focus:ring-mansiang-green/20">
                            </label>
                        </div>
                    </fieldset>
                </div>
            </details>
        </aside>

        <div>
            <div class="mb-6 flex items-end justify-between gap-4 border-b border-mansiang-ink/10 pb-4">
                <div>
                    <p class="text-xs font-bold uppercase tracking-[0.16em] text-mansiang-ochre">{{ __('Katalog') }}</p>
                    <p class="mt-1 text-sm text-mansiang-taupe">{{ __(':count produk ditemukan', ['count' => $products->total()]) }}</p>
                </div>
                <span wire:loading class="text-xs font-semibold text-mansiang-green">{{ __('Memuat...') }}</span>
            </div>

            <div wire:loading.class="opacity-50" class="grid grid-cols-1 gap-6 transition sm:grid-cols-2 xl:grid-cols-3">
                @forelse($products as $product)
                    <x-product-card :product="$product" />
                @empty
                    <div class="col-span-full rounded-[1.75rem] bg-mansiang-surface px-6 py-16 text-center">
                        <p class="font-display text-2xl font-semibold text-mansiang-ink">{{ __('Produk belum ditemukan') }}</p>
                        <p class="mx-auto mt-2 max-w-md text-sm leading-6 text-mansiang-taupe">{{ __('Coba kata kunci lain atau hapus beberapa filter untuk melihat lebih banyak karya.') }}</p>
                        <button type="button" wire:click="resetFilters" class="mt-6 text-sm font-semibold text-mansiang-green underline decoration-mansiang-green/30 underline-offset-4 hover:decoration-mansiang-green">{{ __('Hapus semua filter') }}</button>
                    </div>
                @endforelse
            </div>

            <div class="mt-10 border-t border-mansiang-ink/10 pt-6">
                {{ $products->links() }}
            </div>
        </div>
    </section>
</div>
