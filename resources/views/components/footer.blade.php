@php
    $map = google_maps_url(setting('contact_info.google_maps_embed'));
    $embedUrl = null;
    $knownShare = 'https://maps.app.goo.gl/cCn4xYfTiMox9Wf76';
    $seedEmbed = 'https://www.google.com/maps?q=-0.1439297,100.4908906&z=16&output=embed';
    if ($map) {
        $path = parse_url($map, PHP_URL_PATH) ?? '';
        $query = [];
        parse_str(parse_url($map, PHP_URL_QUERY) ?? '', $query);
        if (str_starts_with($path, '/maps/embed') || (str_starts_with($path, '/maps') && ($query['output'] ?? '') === 'embed')) {
            $embedUrl = $map;
        } elseif ($map === $knownShare) {
            $embedUrl = $seedEmbed;
        }
    }
@endphp
<footer class="bg-mansiang-dark text-mansiang-ivory">
    <div class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8">
        <div class="grid gap-12 md:grid-cols-4">
            <div class="md:col-span-2">
                <div class="flex items-center gap-3">
                    <span class="flex h-11 w-11 items-center justify-center rounded-2xl bg-mansiang-green text-white">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 4h16v16H4z"/><path stroke-linecap="round" stroke-linejoin="round" d="M4 9h16M9 4v16"/></svg>
                    </span>
                    <span class="font-display text-xl font-bold">{{ setting('site_general.site_name', 'Koperasi Anyaman Mansiang') }}</span>
                </div>
                <p class="mt-4 max-w-md text-sm leading-relaxed text-mansiang-ivory/70">{!! setting('site_general.footer_description', 'Pusat kerajinan tangan anyaman mansiang asli Taratak.') !!}</p>
                @if($map)
                    <div class="mt-6 max-w-sm space-y-3">
                        <h4 class="text-sm font-bold uppercase tracking-[0.18em] text-mansiang-ochre">@lang('Lokasi')</h4>
                        @if($embedUrl)
                            <iframe src="{{ $embedUrl }}" title="@lang('Peta lokasi')" class="h-40 w-full rounded-2xl border-0" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                        @else
                            <a href="{{ $map }}" target="_blank" rel="noopener" class="inline-flex items-center gap-2 rounded-full bg-mansiang-ivory px-5 py-3 text-sm font-bold text-mansiang-dark hover:bg-mansiang-ochre">@lang('Buka di Google Maps')</a>
                        @endif
                    </div>
                @endif
                <div class="mt-6 flex flex-wrap items-center gap-3">
                    @foreach(['instagram', 'tiktok', 'facebook', 'youtube'] as $social)
                        @if(setting('social_media.'.$social))
                            <a href="{{ setting('social_media.'.$social) }}" target="_blank" rel="noopener" class="inline-flex h-10 w-10 items-center justify-center rounded-full border border-mansiang-ivory/15 text-mansiang-ivory/80 transition hover:border-mansiang-ochre hover:text-mansiang-ochre" aria-label="{{ ucfirst($social) }}">
                                @switch($social)
                                    @case('instagram')
                                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><rect x="3" y="3" width="18" height="18" rx="5"/><circle cx="12" cy="12" r="4"/><circle cx="17" cy="7" r="1" fill="currentColor" stroke="none"/></svg>
                                        @break
                                    @case('tiktok')
                                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M14 3v11.5a4.5 4.5 0 1 1-4.5-4.5"/><path stroke-linecap="round" stroke-linejoin="round" d="M14 5a6 6 0 0 0 5 5"/></svg>
                                        @break
                                    @case('facebook')
                                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M14 8h3V4h-3c-3 0-5 2-5 5v2H6v4h3v5h4v-5h3l1-4h-4V9c0-.6.4-1 1-1Z"/></svg>
                                        @break
                                    @case('youtube')
                                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><rect x="3" y="6" width="18" height="12" rx="4"/><path fill="currentColor" stroke="none" d="m10 9 5 3-5 3V9Z"/></svg>
                                        @break
                                @endswitch
                            </a>
                        @endif
                    @endforeach
                </div>
            </div>
            <div>
                <h4 class="text-sm font-bold uppercase tracking-[0.18em] text-mansiang-ochre">@lang('Kontak')</h4>
                <ul class="mt-4 space-y-2 text-sm text-mansiang-ivory/70">
                    <li>{{ setting('contact_info.whatsapp_display') }}</li>
                    <li>{{ setting('contact_info.email') }}</li>
                    <li>{{ setting('contact_info.address') }}</li>
                    <li>{{ setting('contact_info.business_hours') }}</li>
                </ul>
            </div>
            <div>
                <h4 class="text-sm font-bold uppercase tracking-[0.18em] text-mansiang-ochre">@lang('Jelajahi')</h4>
                <ul class="mt-4 space-y-2 text-sm text-mansiang-ivory/70">
                    <li><a href="{{ route('landing') }}" class="hover:text-mansiang-ochre">@lang('Beranda')</a></li>
                    <li><a href="{{ route('about') }}" class="hover:text-mansiang-ochre">@lang('Tentang Kami')</a></li>
                    <li><a href="{{ route('catalog') }}" class="hover:text-mansiang-ochre">@lang('Katalog')</a></li>
                    <li><a href="{{ route('posts.index') }}" class="hover:text-mansiang-ochre">@lang('Blog')</a></li>
                </ul>
            </div>
        </div>
        <div class="mt-12 border-t border-mansiang-ivory/10 pt-6 text-center text-xs text-mansiang-ivory/60">
            <p>@lang('Foto contoh di situs ini bukan dokumentasi Koperasi Anyaman Mansiang.')</p>
            <p class="mt-2">
                @lang('Foto kerajinan anyaman dari')
                <a href="https://commons.wikimedia.org/wiki/File:Basket_weaving_crafts_on_display_at_Rumeilah_Park_in_Doha.jpg" target="_blank" rel="noopener" class="underline transition hover:text-mansiang-ochre">Alex Sergeev</a>
                (<a href="https://creativecommons.org/licenses/by-sa/3.0/" target="_blank" rel="noopener" class="underline transition hover:text-mansiang-ochre">CC BY-SA 3.0</a>)
                @lang('dan')
                <a href="https://commons.wikimedia.org/wiki/File:Basket_weaving_in_process.jpg" target="_blank" rel="noopener" class="underline transition hover:text-mansiang-ochre">Rogerirakoze</a>
                @lang('serta')
                <a href="https://commons.wikimedia.org/wiki/File:Basket_weaver.jpg" target="_blank" rel="noopener" class="underline transition hover:text-mansiang-ochre">Masako Kato</a>
                (<a href="https://creativecommons.org/licenses/by-sa/4.0/" target="_blank" rel="noopener" class="underline transition hover:text-mansiang-ochre">CC BY-SA 4.0</a>)
                @lang('via Wikimedia Commons.')
            </p>
            &copy; {{ date('Y') }} {{ setting('site_general.site_name', 'Koperasi Anyaman Mansiang') }}. @lang('Seluruh hak cipta.')
        </div>
    </div>
</footer>