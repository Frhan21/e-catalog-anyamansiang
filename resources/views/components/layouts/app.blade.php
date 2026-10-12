<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script>
        try {
            var theme = localStorage.getItem('theme')
            document.documentElement.classList.toggle('dark', theme ? theme === 'dark' : matchMedia('(prefers-color-scheme: dark)').matches)
        } catch (e) {
            document.documentElement.classList.toggle('dark', matchMedia('(prefers-color-scheme: dark)').matches)
        }
    </script>

    <link rel="icon" href="{{ branding_url() }}">
    <title>@yield('title', setting('site_general.site_name', 'Koperasi Anyaman Mansiang'))</title>
    <meta name="description" content="@yield('description', setting('site_general.site_tagline'))">
    @php
        $ogImage = trim($__env->yieldContent('og_image'));
        $isDefaultImage = $ogImage === '';
        $ogImageUrl = $isDefaultImage ? asset('images/branding/og-default.png') : url($ogImage);
        $ogTitle = trim($__env->yieldContent('og_title')) ?: trim($__env->yieldContent('title')) ?: setting('site_general.site_name', 'Koperasi Anyaman Mansiang');
        $ogDescription = trim($__env->yieldContent('og_description')) ?: trim($__env->yieldContent('description')) ?: setting('site_general.site_tagline', 'Sentuhan Tradisi, Keindahan Alami');
        $canonical = trim($__env->yieldContent('canonical')) ?: url()->current();
    @endphp
    <link rel="canonical" href="{{ $canonical }}">
    <meta property="og:title" content="{{ $ogTitle }}">
    <meta property="og:description" content="{{ $ogDescription }}">
    <meta property="og:type" content="@yield('og_type', 'website')">
    <meta property="og:url" content="{{ $canonical }}">
    <meta property="og:image" content="{{ $ogImageUrl }}">
    @if($isDefaultImage)
        <meta property="og:image:width" content="1733">
        <meta property="og:image:height" content="907">
        <meta property="og:image:type" content="image/png">
    @endif
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $ogTitle }}">
    <meta name="twitter:description" content="{{ $ogDescription }}">
    <meta name="twitter:image" content="{{ $ogImageUrl }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    <style>[x-cloak] { display: none !important; }</style>
</head>
<body data-public-site class="bg-mansiang-canvas text-mansiang-ink font-sans antialiased" x-data @open-whatsapp.window="window.open($event.detail.url, '_blank')">
    <x-nav />

    <main class="min-h-[100dvh]">
        @yield('content')
        {{ $slot ?? '' }}
    </main>

    <x-footer />

    <livewire:cart.cart />

    @livewireScripts
</body>
</html>
