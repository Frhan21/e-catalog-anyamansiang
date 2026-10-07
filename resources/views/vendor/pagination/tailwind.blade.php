@if ($paginator->hasPages())
    <nav role="navigation" aria-label="{{ __('Navigasi halaman') }}" class="flex flex-wrap items-center justify-between gap-4">
        <p class="text-sm text-mansiang-taupe">{{ __('Menampilkan :first sampai :last dari :total hasil', ['first' => $paginator->firstItem() ?? 0, 'last' => $paginator->lastItem() ?? 0, 'total' => $paginator->total()]) }}</p>

        <div class="flex items-center gap-1.5">
            @if ($paginator->onFirstPage())
                <span class="rounded-full border border-mansiang-ink/15 px-4 py-2 text-sm font-semibold text-mansiang-taupe/60" aria-disabled="true">{!! __('pagination.previous') !!}</span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="rounded-full border border-mansiang-ink/15 px-4 py-2 text-sm font-semibold text-mansiang-ink transition hover:border-mansiang-green hover:text-mansiang-green">{!! __('pagination.previous') !!}</a>
            @endif

            @foreach ($elements as $element)
                @if (is_string($element))
                    <span class="px-2 text-sm text-mansiang-taupe">{{ $element }}</span>
                @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <span aria-current="page" class="inline-flex h-9 min-w-9 items-center justify-center rounded-full bg-mansiang-dark px-3 text-sm font-bold text-mansiang-ivory">{{ $page }}</span>
                        @else
                            <a href="{{ $url }}" class="inline-flex h-9 min-w-9 items-center justify-center rounded-full px-3 text-sm font-semibold text-mansiang-charcoal transition hover:bg-mansiang-surface" aria-label="{{ __('Ke halaman :page', ['page' => $page]) }}">{{ $page }}</a>
                        @endif
                    @endforeach
                @endif
            @endforeach

            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="rounded-full border border-mansiang-ink/15 px-4 py-2 text-sm font-semibold text-mansiang-ink transition hover:border-mansiang-green hover:text-mansiang-green">{!! __('pagination.next') !!}</a>
            @else
                <span class="rounded-full border border-mansiang-ink/15 px-4 py-2 text-sm font-semibold text-mansiang-taupe/60" aria-disabled="true">{!! __('pagination.next') !!}</span>
            @endif
        </div>
    </nav>
@endif