<?php

use App\Models\SiteSetting;
use Illuminate\Support\Facades\Storage;

if (! function_exists('media_url')) {
    function media_url(?string $path, ?string $fallback = null): string
    {
        $value = $path ?: $fallback;

        if (! $value) {
            return '';
        }

        if (str_starts_with($value, 'http://') || str_starts_with($value, 'https://')) {
            return $value;
        }

        return Storage::url($value);
    }
}

if (! function_exists('media_alt')) {
    function media_alt(?string $path, string $description): string
    {
        return str_contains($path ?? '', 'upload.wikimedia.org')
            ? __('Foto contoh kerajinan anyaman, bukan dokumentasi Koperasi Anyaman Mansiang')
            : $description;
    }
}

if (! function_exists('google_maps_url')) {
    function google_maps_url(mixed $url): ?string
    {
        if (! is_string($url) || ! filter_var($url, FILTER_VALIDATE_URL)) {
            return null;
        }

        $parts = parse_url($url);

        return ($parts['scheme'] ?? '') === 'https'
            && in_array(strtolower($parts['host'] ?? ''), ['google.com', 'www.google.com', 'maps.google.com', 'maps.app.goo.gl'], true)
            && ! isset($parts['user'])
            && ! isset($parts['pass'])
            && (! isset($parts['port']) || $parts['port'] === 443)
                ? $url
                : null;
    }
}

if (! function_exists('setting')) {
    function setting(string $keyPath, $default = null)
    {
        [$key, $subKey] = array_pad(explode('.', $keyPath, 2), 2, null);

        $settings = cache()->rememberForever("site_settings_{$key}", function () use ($key) {
            return SiteSetting::where('key', $key)->value('payload') ?? [];
        });

        if ($subKey === null) {
            return $settings ?: $default;
        }

        return data_get($settings, $subKey, $default);
    }
}

if (! function_exists('branding_url')) {
    function branding_url(): string
    {
        $path = setting('site_general.logo_path');

        if (is_string($path) && $path !== '' && Storage::disk('public')->exists($path)) {
            $absolutePath = Storage::disk('public')->path($path);
            $seedLogoHash = '41d12832495c64e6b852daf8d7bc73670da701fe8e2583c556bb074213287eb8';

            if (hash_file('sha256', $absolutePath) === $seedLogoHash) {
                return asset('images/branding/logo.png');
            }

            return Storage::disk('public')->url($path);
        }

        return asset('images/branding/logo.png');
    }
}
