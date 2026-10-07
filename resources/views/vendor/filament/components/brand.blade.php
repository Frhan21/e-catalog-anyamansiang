@props([
    'heading' => null,
    'subheading' => null,
])

<x-filament-panels::page.simple>
    @if ($heading)
        <x-slot name="heading">
            {{ $heading }}
        </x-slot>
    @endif

    @if ($subheading)
        <x-slot name="subheading">
            {{ $subheading }}
        </x-slot>
    @endif

    {{ $slot }}
</x-filament-panels::page.simple>
