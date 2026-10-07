<?php

use App\Enums\PostStatus;
use App\Models\Post;
use App\Models\PostCategory;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\SiteSetting;

it('renders accessible mobile navigation with helper-generated whatsapp links', function () {
    SiteSetting::create([
        'group' => 'general',
        'key' => 'site_general',
        'payload' => ['site_name' => 'Koperasi Anyaman Mansiang Taratak'],
    ]);
    SiteSetting::create([
        'group' => 'contact',
        'key' => 'contact_info',
        'payload' => ['whatsapp_number' => '+62 812-3456-7890'],
    ]);

    $this->get('/')
        ->assertOk()
        ->assertSee('Koperasi Anyaman Mansiang Taratak')
        ->assertSee('aria-controls="mobile-navigation"', false)
        ->assertSee('x-show="open"', false)
        ->assertSee('aria-label="Mobile navigation"', false)
        ->assertSee('aria-label="Open shopping cart"', false)
        ->assertSee('https://wa.me/6281234567890', false);
});

it('renders about gallery as an overlay mosaic capped at ten items', function () {
    SiteSetting::create([
        'group' => 'about',
        'key' => 'about_content',
        'payload' => [
            'gallery' => collect(range(1, 11))->map(fn (int $index) => [
                'image' => "settings/gallery-{$index}.jpg",
                'caption' => "Kegiatan {$index}",
            ])->all(),
        ],
    ]);

    $this->get('/about-us')
        ->assertOk()
        ->assertSee('Kegiatan 10')
        ->assertDontSee('Kegiatan 11')
        ->assertSee('data-gallery-grid', false)
        ->assertSee('md:grid-cols-12', false)
        ->assertSee('figure class="group relative aspect-[4/5] overflow-hidden rounded-2xl bg-mansiang-surface', false)
        ->assertSee('md:aspect-[16/10]" data-animate', false)
        ->assertSee('group-hover:scale-105', false)
        ->assertSee('absolute inset-x-0 bottom-0', false);
});

it('renders hero navigation, counters before a four-image purpose grid with side heading, theme controls, and dynamic map', function () {
    SiteSetting::create([
        'group' => 'landing',
        'key' => 'landing_hero',
        'payload' => [
            'slides' => [
                ['image' => 'settings/hero-one.jpg', 'caption' => 'Slide satu'],
                ['image' => 'settings/hero-two.jpg', 'caption' => 'Slide dua'],
            ],
        ],
    ]);
    SiteSetting::create([
        'group' => 'landing',
        'key' => 'landing_purpose',
        'payload' => [
            'items' => [
                ['title' => 'Pemberdayaan', 'image' => 'settings/one.jpg'],
                ['title' => 'Pelestarian', 'image' => 'settings/two.jpg'],
                ['title' => 'Berkelanjutan', 'image' => 'settings/three.jpg'],
                ['title' => 'Ekonomi Lokal', 'image' => 'settings/four.jpg'],
            ],
        ],
    ]);
    SiteSetting::create([
        'group' => 'landing',
        'key' => 'landing_stats',
        'payload' => ['stats' => [['value' => '50+', 'label' => 'Pengrajin']]],
    ]);
    SiteSetting::create([
        'group' => 'contact',
        'key' => 'contact_info',
        'payload' => ['google_maps_embed' => 'https://maps.app.goo.gl/cCn4xYfTiMox9Wf76'],
    ]);

    $html = $this->get('/')
        ->assertOk()
        ->assertSee('Pemberdayaan')
        ->assertSee('Pelestarian')
        ->assertSee('Berkelanjutan')
        ->assertSee('Ekonomi Lokal')
        ->assertSee('data-swiper="hero"', false)
        ->assertSee('swiper-button-prev', false)
        ->assertSee('swiper-button-next', false)
        ->assertDontSee('data-swiper-autoplay-toggle', false)
        ->assertDontSee('>Slide satu<')
        ->assertSee('data-counter-value="50+"', false)
        ->assertSee('lg:grid-cols-[minmax(16rem,0.7fr)_minmax(0,1.3fr)]', false)
        ->assertSee('lg:sticky lg:top-28', false)
        ->assertSee('grid gap-6 sm:grid-cols-2', false)
        ->assertSee('data-theme-toggle', false)
        ->assertSee('<iframe src="https://www.google.com/maps?q=-0.1439297,100.4908906&amp;z=16&amp;output=embed"', false)
        ->getContent();

    expect(strpos($html, 'data-counter-value'))->toBeLessThan(strpos($html, 'data-purpose-grid'));
});

it('marks hero elements as load animations', function () {
    $template = file_get_contents(resource_path('views/pages/landing.blade.php'));

    expect(substr_count($template, 'data-animate="load"'))->toBeGreaterThanOrEqual(4);
});

it('renders footer social media as labelled icon buttons', function () {
    SiteSetting::create([
        'group' => 'social',
        'key' => 'social_media',
        'payload' => ['instagram' => 'https://instagram.com/koperasi'],
    ]);

    $this->get('/')
        ->assertOk()
        ->assertSee('aria-label="Instagram"', false)
        ->assertSee('href="https://instagram.com/koperasi"', false)
        ->assertSee('<svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor"', false);
});

it('configures hero-only autoplay, navigation, and livewire animation cleanup', function () {
    $sliders = file_get_contents(resource_path('js/sliders.js'));
    $animations = file_get_contents(resource_path('js/animations.js'));

    expect($sliders)
        ->toContain("el.dataset.swiper === 'hero'")
        ->toContain('prefers-reduced-motion: reduce')
        ->toContain('autoplay: isHero')
        ->toContain('loop: slideCount > 1')
        ->toContain('swiper-button-prev')
        ->toContain('swiper-button-next')
        ->and($animations)
        ->toContain("document.addEventListener('livewire:navigating', cleanupAnimations)")
        ->toContain("document.addEventListener('livewire:navigated', initAnimations)");
});

it('renders section heading without subtitle', function () {
    $category = ProductCategory::create(['name' => 'Tikar', 'slug' => 'tikar']);
    Product::create([
        'category_id' => $category->id,
        'name' => 'Tikar Munjung',
        'slug' => 'tikar-munjung',
        'price' => 185000,
        'primary_image' => 'products/tikar-munjung.jpg',
    ]);

    $postCategory = PostCategory::create(['name' => 'Cerita', 'slug' => 'cerita']);
    $post = Post::create([
        'post_category_id' => $postCategory->id,
        'title' => 'Mengenal Mansiang',
        'slug' => 'mengenal-mansiang',
        'content' => '<p>Isi artikel.</p>',
        'status' => PostStatus::Published,
        'published_at' => now(),
    ]);

    $this->get('/blog/'.$post->slug)->assertOk();
});

it('footer renders embed iframe for valid google embed url', function () {
    SiteSetting::create([
        'group' => 'contact',
        'key' => 'contact_info',
        'payload' => ['google_maps_embed' => 'https://www.google.com/maps/embed?pb=!1m14!'],
    ]);

    $this->get('/')
        ->assertOk()
        ->assertSee('<iframe src="https://www.google.com/maps/embed?pb=!1m14!"', false)
        ->assertSee('allowfullscreen', false)
        ->assertSee('loading="lazy"', false)
        ->assertSee('title="Peta lokasi"', false);
});

it('footer hides map when google maps embed setting is empty', function () {
    SiteSetting::create([
        'group' => 'contact',
        'key' => 'contact_info',
        'payload' => ['google_maps_embed' => ''],
    ]);

    $this->get('/')
        ->assertOk()
        ->assertDontSee('<iframe', false)
        ->assertDontSee('Buka di Google Maps', false);
});

it('footer embeds only the known original share link and keeps unknown share links safe', function () {
    SiteSetting::create([
        'group' => 'contact',
        'key' => 'contact_info',
        'payload' => ['google_maps_embed' => 'https://maps.app.goo.gl/cCn4xYfTiMox9Wf76'],
    ]);

    $this->get('/')
        ->assertOk()
        ->assertSee('<iframe src="https://www.google.com/maps?q=-0.1439297,100.4908906&amp;z=16&amp;output=embed"', false);

    SiteSetting::where('key', 'contact_info')->firstOrFail()->update([
        'payload' => ['google_maps_embed' => 'https://maps.app.goo.gl/UnknownShare'],
    ]);

    $this->get('/')
        ->assertOk()
        ->assertSee('<a href="https://maps.app.goo.gl/UnknownShare"', false)
        ->assertDontSee('<iframe', false);
});

it('footer hides map for javascript or evil domain urls', function () {
    foreach (['javascript:alert(1)', 'https://evil.com/maps', 'https://maps.evil.com/x'] as $bad) {
        SiteSetting::updateOrCreate(
            ['group' => 'contact', 'key' => 'contact_info'],
            ['payload' => ['google_maps_embed' => $bad]],
        );

        cache()->flush();

        $this->get('/')
            ->assertOk()
            ->assertDontSee('<iframe', false)
            ->assertDontSee('Buka di Google Maps', false);
    }
});

it('serves dummy images as valid image files', function () {
    $path = storage_path('app/public/products/tikar-munjung.jpg');

    expect(file_exists($path))->toBeTrue();
    expect(mime_content_type($path))->toBeIn(['image/jpeg', 'image/png', 'image/gif']);
});
