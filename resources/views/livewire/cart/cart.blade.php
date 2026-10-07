<div x-data="{ open: false }"
     x-on:open-cart.window="open = true"
     x-on:close-cart.window="open = false"
     class="relative"
>
    <div x-show="open" x-cloak x-transition.opacity class="fixed inset-0 z-50 bg-mansiang-dark/50 backdrop-blur-sm" @click="open = false" aria-hidden="true"></div>

    <section x-show="open" x-cloak x-transition:enter="transition ease-out duration-300" x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0"
             x-transition:leave="transition ease-in duration-200" x-transition:leave-start="translate-x-0" x-transition:leave-end="translate-x-full"
             x-trap.noscroll="open"
             class="fixed inset-y-0 right-0 z-50 flex w-full max-w-md flex-col bg-white shadow-2xl"
             role="dialog" aria-modal="true" aria-label="{{ __('Keranjang belanja') }}"
    >
        <header class="flex items-center justify-between border-b border-mansiang-ink/10 px-5 py-4">
            <h2 class="font-display text-xl font-semibold text-mansiang-ink">{{ __('Keranjang') }}</h2>
            <button type="button" @click="open = false" class="rounded-xl p-2 text-mansiang-ink transition hover:bg-mansiang-surface" aria-label="{{ __('Tutup keranjang') }}">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" d="M6 6l12 12M18 6L6 18"/></svg>
            </button>
        </header>

        <div class="flex-1 overflow-y-auto px-5 py-4" x-cloak>
            @if(count($items) === 0)
                <div class="flex h-full flex-col items-center justify-center gap-3 text-center">
                    <svg class="h-12 w-12 text-mansiang-taupe/60" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z"/><path stroke-linecap="round" stroke-linejoin="round" d="M3 6h18"/><path stroke-linecap="round" d="M16 10a4 4 0 0 1-8 0"/></svg>
                    <p class="font-display text-lg font-semibold text-mansiang-ink">{{ __('Keranjang masih kosong') }}</p>
                    <p class="text-sm text-mansiang-taupe">{{ __('Yuk, jelajahi koleksi anyaman kami.') }}</p>
                </div>
            @else
                <ul class="space-y-4">
                    @foreach($items as $item)
                        <li class="rounded-2xl border border-mansiang-ink/10 bg-mansiang-canvas p-4">
                            <div class="flex items-start justify-between gap-3">
                                <div class="min-w-0">
                                    <p class="truncate font-semibold text-mansiang-ink">{{ $item['name'] }}</p>
                                    <p class="text-xs text-mansiang-taupe">SKU {{ $item['sku'] ?? '-' }}</p>
                                </div>
                                <button type="button" wire:click="remove({{ $item['id'] }})" class="rounded-lg p-1.5 text-mansiang-taupe transition hover:bg-red-50 hover:text-red-600" aria-label="{{ __('Hapus :name', ['name' => $item['name']]) }}">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" d="M6 6l12 12M18 6L6 18"/></svg>
                                </button>
                            </div>
                            <div class="mt-3 flex items-center justify-between gap-3">
                                <div class="inline-flex items-center rounded-full border border-mansiang-ink/15 bg-white">
                                    <button type="button" wire:click="updateQty({{ $item['id'] }}, {{ $item['qty'] }} - 1)" class="flex h-8 w-8 items-center justify-center rounded-l-full text-mansiang-ink transition hover:bg-mansiang-surface disabled:opacity-30" @disabled($item['qty'] <= 1) aria-label="{{ __('Kurangi jumlah :name', ['name' => $item['name']]) }}">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" d="M5 12h14"/></svg>
                    </button>
                                    <span class="min-w-8 text-center text-sm font-bold text-mansiang-ink">{{ $item['qty'] }}</span>
                                    <button type="button" wire:click="updateQty({{ $item['id'] }}, {{ $item['qty'] }} + 1)" class="flex h-8 w-8 items-center justify-center rounded-r-full text-mansiang-ink transition hover:bg-mansiang-surface" aria-label="{{ __('Tambah jumlah :name', ['name' => $item['name']]) }}">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" d="M12 5v14M5 12h14"/></svg>
                                    </button>
                                </div>
                                <p class="text-sm font-bold text-mansiang-warm">Rp {{ number_format($item['price'] * $item['qty'], 0, ',', '.') }}</p>
                            </div>
                        </li>
                    @endforeach
                </ul>

                <div class="mt-5 flex items-center justify-between rounded-2xl bg-mansiang-surface px-4 py-3">
                    <span class="text-sm font-semibold text-mansiang-ink">{{ __('Subtotal') }}</span>
                    <span class="font-display text-lg font-bold text-mansiang-warm">Rp {{ number_format($this->subtotal(), 0, ',', '.') }}</span>
                </div>

                <form wire:submit="checkout" class="mt-6 space-y-4 border-t border-mansiang-ink/10 pt-5">
                    <div>
                        <label for="cart-name" class="mb-1.5 block text-xs font-bold uppercase tracking-[0.14em] text-mansiang-taupe">{{ __('Nama') }} <span class="text-red-600">*</span></label>
                        <input id="cart-name" type="text" wire:model.blur="name" autocomplete="name" class="w-full rounded-xl border border-mansiang-ink/10 bg-white px-3.5 py-3 text-sm text-mansiang-charcoal outline-none transition focus:border-mansiang-green focus:ring-2 focus:ring-mansiang-green/20" placeholder="{{ __('Nama lengkap') }}">
                        @error('name') <p class="mt-1 text-xs font-medium text-red-600">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="cart-phone" class="mb-1.5 block text-xs font-bold uppercase tracking-[0.14em] text-mansiang-taupe">{{ __('No. Telp') }} <span class="text-red-600">*</span></label>
                        <input id="cart-phone" type="tel" wire:model.blur="phone" autocomplete="tel" class="w-full rounded-xl border border-mansiang-ink/10 bg-white px-3.5 py-3 text-sm text-mansiang-charcoal outline-none transition focus:border-mansiang-green focus:ring-2 focus:ring-mansiang-green/20" placeholder="0812-3456-7890">
                        @error('phone') <p class="mt-1 text-xs font-medium text-red-600">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="cart-address" class="mb-1.5 block text-xs font-bold uppercase tracking-[0.14em] text-mansiang-taupe">{{ __('Alamat') }} <span class="text-red-600">*</span></label>
                        <textarea id="cart-address" wire:model.blur="address" rows="2" class="w-full rounded-xl border border-mansiang-ink/10 bg-white px-3.5 py-3 text-sm text-mansiang-charcoal outline-none transition focus:border-mansiang-green focus:ring-2 focus:ring-mansiang-green/20" placeholder="{{ __('Alamat pengiriman') }}"></textarea>
                        @error('address') <p class="mt-1 text-xs font-medium text-red-600">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="cart-note" class="mb-1.5 block text-xs font-bold uppercase tracking-[0.14em] text-mansiang-taupe">{{ __('Catatan') }}</label>
                        <textarea id="cart-note" wire:model.blur="note" rows="2" class="w-full rounded-xl border border-mansiang-ink/10 bg-white px-3.5 py-3 text-sm text-mansiang-charcoal outline-none transition focus:border-mansiang-green focus:ring-2 focus:ring-mansiang-green/20" placeholder="{{ __('Opsional') }}"></textarea>
                        @error('note') <p class="mt-1 text-xs font-medium text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <button type="submit" class="inline-flex w-full items-center justify-center gap-2 rounded-full bg-mansiang-green px-5 py-3.5 text-sm font-bold text-white transition hover:bg-mansiang-dark focus:outline-none focus:ring-2 focus:ring-mansiang-green/40 disabled:opacity-60" wire:loading.attr="disabled">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13 5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17"/><circle cx="9" cy="19" r="1" fill="currentColor"/><circle cx="17" cy="19" r="1" fill="currentColor"/></svg>
                        {{ __('Kirim Pesanan via WhatsApp') }}
                    </button>
                </form>

                <button type="button" wire:click="clear" class="mt-3 w-full rounded-xl border border-mansiang-ink/15 px-5 py-2.5 text-sm font-semibold text-mansiang-taupe transition hover:border-red-300 hover:text-red-600">
                    {{ __('Kosongkan keranjang') }}
                </button>
            @endif
        </div>
    </section>
</div>
