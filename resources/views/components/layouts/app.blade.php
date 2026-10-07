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

    <title>@yield('title', setting('site_general.site_name', 'Koperasi Anyaman Mansiang'))</title>
    <meta name="description" content="@yield('description', setting('site_general.site_tagline'))">

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
