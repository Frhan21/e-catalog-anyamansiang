@php
    $wa = \App\Helpers\WhatsAppHelper::contactUrl(setting('contact_info.whatsapp_number'));
@endphp
<header x-data="{ open: false }" @keydown.escape.window="if (open) { open = false; $refs.toggle.focus() }" @click.outside="open = false" class="sticky top-0 z-40 border-b border-mansiang-ink/10 bg-mansiang-canvas/90 backdrop-blur-xl">
    <nav class="mx-auto flex h-20 max-w-7xl items-center justify-between gap-6 px-4 sm:px-6 lg:px-8" aria-label="Main navigation">
        <a href="{{ route('landing') }}" class="flex min-w-0 items-center gap-3">
            <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-2xl bg-mansiang-green text-white shadow-lg shadow-mansiang-green/20">
                <svg class="h-6 w-6" aria-hidden="true" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 4h16v16H4z"/><path stroke-linecap="round" stroke-linejoin="round" d="M4 9h16M9 4v16"/></svg>
            </span>
            <span class="min-w-0 break-words font-display text-base font-bold leading-tight text-mansiang-ink sm:text-xl">{{ setting('site_general.site_name', 'Anyaman Mansiang') }}</span>
        </a>

        <div class="hidden lg:flex lg:flex-1 lg:justify-center">
            <div class="flex items-center gap-8 whitespace-nowrap text-sm font-semibold text-mansiang-charcoal">
                <a href="{{ route('landing') }}" class="transition hover:text-mansiang-green">Home</a>
                <a href="{{ route('about') }}" class="transition hover:text-mansiang-green">About Us</a>
                <a href="{{ route('catalog') }}" class="transition hover:text-mansiang-green">Catalog</a>
                <a href="{{ route('posts.index') }}" class="transition hover:text-mansiang-green">Blog</a>
            </div>
        </div>

        <div class="hidden items-center gap-3 lg:flex">
            <a href="{{ $wa }}" target="_blank" rel="noopener" class="rounded-full bg-mansiang-green px-5 py-2.5 text-sm font-bold text-white transition hover:bg-mansiang-dark">Contact Us</a>
            <livewire:cart.cart-button />
            <button type="button" data-theme-toggle class="rounded-full border border-mansiang-ink/15 p-2.5 text-mansiang-ink transition hover:bg-mansiang-surface" aria-label="Toggle theme">
                <svg class="hidden dark:block h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="12" r="5"/><path stroke-linecap="round" d="M12 1v2m0 18v2M4.22 4.22l1.42 1.42m12.72 12.72 1.42 1.42M1 12h2m18 0h2M4.22 19.78l1.42-1.42M18.36 5.64l1.42-1.42"/></svg>
                <svg class="block dark:hidden h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"/></svg>
            </button>
        </div>

        <div class="flex items-center gap-3 lg:hidden">
            <livewire:cart.cart-button />
            <button type="button" data-theme-toggle class="rounded-full border border-mansiang-ink/15 p-2.5 text-mansiang-ink transition hover:bg-mansiang-surface" aria-label="Toggle theme">
                <svg class="hidden dark:block h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="12" r="5"/><path stroke-linecap="round" d="M12 1v2m0 18v2M4.22 4.22l1.42 1.42m12.72 12.72 1.42 1.42M1 12h2m18 0h2M4.22 19.78l1.42-1.42M18.36 5.64l1.42-1.42"/></svg>
                <svg class="block dark:hidden h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"/></svg>
            </button>
            <button x-ref="toggle" type="button" @click="open = !open" :aria-expanded="open.toString()" aria-controls="mobile-navigation" aria-label="Navigation menu" class="shrink-0 rounded-xl p-3 text-mansiang-ink">
                <svg class="h-6 w-6" aria-hidden="true" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" d="M4 7h16M4 12h16M4 17h16"/></svg>
            </button>
        </div>
    </nav>

    <nav id="mobile-navigation" x-show="open" style="display: none" @click="if ($event.target.closest('a')) open = false" aria-label="Mobile navigation" class="absolute inset-x-0 top-full border-b border-mansiang-ink/10 bg-mansiang-canvas px-4 py-4 shadow-lg lg:hidden">
        <div class="mx-auto flex max-w-7xl flex-col gap-1 text-sm font-semibold text-mansiang-charcoal">
            <a href="{{ route('landing') }}" class="rounded-lg px-3 py-3 hover:bg-mansiang-surface">Home</a>
            <a href="{{ route('about') }}" class="rounded-lg px-3 py-3 hover:bg-mansiang-surface">About Us</a>
            <a href="{{ route('catalog') }}" class="rounded-lg px-3 py-3 hover:bg-mansiang-surface">Catalog</a>
            <a href="{{ route('posts.index') }}" class="rounded-lg px-3 py-3 hover:bg-mansiang-surface">Blog</a>
            <a href="{{ $wa }}" target="_blank" rel="noopener" class="mt-2 rounded-full bg-mansiang-green px-5 py-3 text-center font-bold text-white hover:bg-mansiang-dark">Contact Us</a>
        </div>
    </nav>
</header>
