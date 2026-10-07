@props(['badge' => null, 'title', 'subtitle' => null, 'align' => 'left'])

<div class="{{ $align === 'center' ? 'mx-auto max-w-2xl text-center' : 'max-w-2xl' }}" data-animate>
    @if($badge)
        <span class="inline-flex items-center gap-2 text-xs font-bold uppercase tracking-[0.18em] text-mansiang-ochre">
            <span class="h-px w-8 bg-mansiang-ochre"></span>
            {{ $badge }}
        </span>
    @endif
    <h2 class="mt-4 font-display text-3xl font-bold leading-tight tracking-tight text-mansiang-ink md:text-4xl">{{ $title }}</h2>
    @if($subtitle)
        <p class="mt-3 text-base leading-relaxed text-mansiang-taupe">{{ $subtitle }}</p>
    @endif
</div>