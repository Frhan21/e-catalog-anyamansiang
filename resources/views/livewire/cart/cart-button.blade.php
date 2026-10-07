<div>
    <button type="button"
            x-data
            @click="$dispatch('open-cart')"
            class="relative inline-flex h-11 w-11 items-center justify-center rounded-full border border-mansiang-ink/15 bg-white text-mansiang-ink transition hover:border-mansiang-green hover:text-mansiang-green"
            aria-label="{{ __('Open shopping cart') }}"
    >
        <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z"/>
            <path stroke-linecap="round" stroke-linejoin="round" d="M3 6h18"/>
            <path stroke-linecap="round" d="M16 10a4 4 0 0 1-8 0"/>
        </svg>
        @if($count > 0)
            <span class="absolute -right-1 -top-1 flex h-5 min-w-5 items-center justify-center rounded-full bg-mansiang-warm px-1 text-[11px] font-bold text-white" aria-label="{{ __(':count items in cart', ['count' => $count]) }}">{{ $count }}</span>
        @endif
    </button>
</div>
