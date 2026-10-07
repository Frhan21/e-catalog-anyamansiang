<?php

use App\Enums\AvailabilityStatus;
use App\Models\Product;
use App\Models\ProductCategory;

it('belongs to a category', function () {
    $category = ProductCategory::create([
        'name' => 'Tikar Anyam',
        'slug' => 'tikar-anyam',
    ]);

    $product = Product::create([
        'category_id' => $category->id,
        'name' => 'Tikar Munjung',
        'slug' => 'tikar-munjung',
        'price' => 150000,
        'primary_image' => 'products/tikar-munjung.jpg',
    ]);

    expect($product->category->is($category))->toBeTrue();
});

it('has many images', function () {
    $category = ProductCategory::create(['name' => 'Kategori', 'slug' => 'kategori']);
    $product = Product::create([
        'category_id' => $category->id,
        'name' => 'Produk A',
        'slug' => 'produk-a',
        'price' => 50000,
        'primary_image' => 'products/a.jpg',
    ]);

    $product->images()->create(['image_path' => 'products/a-1.jpg']);
    $product->images()->create(['image_path' => 'products/a-2.jpg']);

    expect($product->images()->count())->toBe(2);
});

it('defaults availability status to ready_stock', function () {
    $category = ProductCategory::create(['name' => 'K', 'slug' => 'k']);
    $product = Product::create([
        'category_id' => $category->id,
        'name' => 'P',
        'slug' => 'p',
        'price' => 1000,
        'primary_image' => 'products/p.jpg',
        'availability_status' => 'ready_stock',
    ]);

    expect($product->availability_status)->toBe(AvailabilityStatus::ReadyStock);
});
