<?php

use App\Helpers\WhatsAppHelper;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\SiteSetting;

it('helper setting reads payload from database', function () {
    SiteSetting::create([
        'group' => 'contact',
        'key' => 'contact_info',
        'payload' => ['whatsapp_number' => '6281234567890'],
    ]);

    expect(setting('contact_info.whatsapp_number'))->toBe('6281234567890');
});

it('helper setting caches payload', function () {
    SiteSetting::create([
        'group' => 'contact',
        'key' => 'contact_info',
        'payload' => ['whatsapp_number' => '6281234567890'],
    ]);

    setting('contact_info.whatsapp_number');

    $calls = 0;
    SiteSetting::saving(function () use (&$calls) {
        $calls++;
    });

    setting('contact_info.whatsapp_number');

    expect($calls)->toBe(0);
});

it('generates whatsapp order url with encoded message', function () {
    $category = ProductCategory::create(['name' => 'Tikar', 'slug' => 'tikar']);
    $product = Product::create([
        'category_id' => $category->id,
        'name' => 'Tikar Munjung',
        'slug' => 'tikar-munjung',
        'sku' => 'TM-001',
        'price' => 150000,
        'primary_image' => 'products/tm.jpg',
    ]);

    $url = WhatsAppHelper::orderUrl($product, ['whatsapp_number' => '6281234567890']);

    expect($url)->toContain('https://wa.me/6281234567890?text=');
    expect($url)->toContain(rawurlencode('Tikar Munjung'));
    expect($url)->toContain(urlencode('TM-001'));
});

it('generates whatsapp contact url for general inquiries', function () {
    expect(WhatsAppHelper::contactUrl('6281234567890'))->toBe('https://wa.me/6281234567890');
    expect(WhatsAppHelper::contactUrl('+62 812-3456-7890'))->toBe('https://wa.me/6281234567890');
    expect(WhatsAppHelper::contactUrl(null))->toBe('#');
    expect(WhatsAppHelper::contactUrl(''))->toBe('#');
});

it('generates whatsapp cart invoice url with structured message', function () {
    $url = WhatsAppHelper::cartMessageUrl('6281234567890', [
        ['name' => 'Tikar Munjung', 'sku' => 'TM-001', 'price' => 150000, 'qty' => 2],
        ['name' => 'Bakul Rotan', 'sku' => 'BR-002', 'price' => 45000, 'qty' => 1],
    ], [
        'name' => 'Budi Santoso',
        'phone' => '081234567890',
        'address' => 'Jl. Taratak No. 10',
        'note' => 'Mohon dikirim hari ini',
    ]);

    expect($url)->toContain('https://wa.me/6281234567890?text=');
    expect($url)->toContain(rawurlencode('Tikar Munjung'));
    expect($url)->toContain(rawurlencode('TM-001'));
    expect($url)->toContain(rawurlencode('Rp 300.000'));
    expect($url)->toContain(rawurlencode('Rp 345.000'));
    expect($url)->toContain(rawurlencode('Budi Santoso'));
    expect($url)->toContain(rawurlencode('Jl. Taratak No. 10'));
    expect($url)->toContain(rawurlencode('Mohon dikirim hari ini'));
});

it('cart invoice uses dash when buyer note is empty', function () {
    $url = WhatsAppHelper::cartMessageUrl('6281234567890', [
        ['name' => 'Tikar Munjung', 'sku' => 'TM-001', 'price' => 150000, 'qty' => 1],
    ], [
        'name' => 'Budi',
        'phone' => '081234567890',
        'address' => 'Jl. Taratak',
        'note' => '',
    ]);

    expect($url)->toContain(rawurlencode('Catatan: -'));
});
