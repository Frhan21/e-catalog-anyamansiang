<?php

use App\Livewire\Cart\Cart;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\SiteSetting;
use Livewire\Livewire;

function cartTestProduct(string $status = 'ready_stock', int $price = 100000, string $slug = 'tikar-munjung'): Product
{
    $category = ProductCategory::create(['name' => 'Tikar', 'slug' => 'tikar']);

    return Product::create([
        'category_id' => $category->id,
        'name' => 'Tikar Munjung',
        'slug' => $slug,
        'sku' => 'TM-001',
        'price' => $price,
        'availability_status' => $status,
        'is_active' => true,
        'primary_image' => 'products/tm.jpg',
    ]);
}

it('adds an active product to the cart', function () {
    $product = cartTestProduct();

    Livewire::test(Cart::class)
        ->call('add', $product)
        ->assertSessionHas('cart_items');
});

it('increments quantity when adding the same product twice', function () {
    $product = cartTestProduct();

    Livewire::test(Cart::class)
        ->call('add', $product)
        ->call('add', $product);

    $items = session('cart_items');
    expect($items)->toHaveCount(1);
    expect($items[0]['qty'])->toBe(2);
});

it('does not add out of stock products', function () {
    $product = cartTestProduct('out_of_stock');

    Livewire::test(Cart::class)
        ->call('add', $product)
        ->assertSessionMissing('cart_items');
});

it('does not add inactive products', function () {
    $product = cartTestProduct();
    $product->update(['is_active' => false]);

    Livewire::test(Cart::class)
        ->call('add', $product)
        ->assertSessionMissing('cart_items');
});

it('updates item quantity', function () {
    $product = cartTestProduct();

    Livewire::test(Cart::class)
        ->call('add', $product)
        ->call('updateQty', $product->id, 5);

    expect(session('cart_items')[0]['qty'])->toBe(5);
});

it('clamps quantity to the maximum for ready stock', function () {
    $product = cartTestProduct();

    Livewire::test(Cart::class)
        ->call('add', $product)
        ->call('updateQty', $product->id, 500);

    expect(session('cart_items')[0]['qty'])->toBe(99);
});

it('allows large quantity for pre order', function () {
    $product = cartTestProduct('pre_order');

    Livewire::test(Cart::class)
        ->call('add', $product)
        ->call('updateQty', $product->id, 500);

    expect(session('cart_items')[0]['qty'])->toBe(500);
});

it('removes an item from the cart', function () {
    $product = cartTestProduct();

    Livewire::test(Cart::class)
        ->call('add', $product)
        ->call('remove', $product->id)
        ->assertSessionMissing('cart_items');
});

it('clears the cart', function () {
    $product = cartTestProduct();

    Livewire::test(Cart::class)
        ->call('add', $product)
        ->call('clear')
        ->assertSessionMissing('cart_items');
});

it('requires buyer fields at checkout', function () {
    $product = cartTestProduct();

    Livewire::test(Cart::class)
        ->call('add', $product)
        ->set('name', '')
        ->set('phone', '')
        ->set('address', '')
        ->call('checkout')
        ->assertHasErrors(['name', 'phone', 'address']);
});

it('shows translated validation messages in english locale', function () {
    app()->setLocale('en');

    $product = cartTestProduct();

    Livewire::test(Cart::class)
        ->call('add', $product)
        ->set('name', '')
        ->set('phone', 'abc')
        ->set('address', '')
        ->call('checkout')
        ->assertHasErrors(['name' => 'required', 'phone' => 'regex', 'address' => 'required']);
});

it('validates phone format at checkout', function () {
    $product = cartTestProduct();

    Livewire::test(Cart::class)
        ->call('add', $product)
        ->set('name', 'Budi')
        ->set('phone', 'abc')
        ->set('address', 'Jl. Taratak')
        ->call('checkout')
        ->assertHasErrors(['phone']);
});

it('clears cart and dispatches whatsapp event after successful checkout', function () {
    SiteSetting::create([
        'group' => 'contact',
        'key' => 'contact_info',
        'payload' => ['whatsapp_number' => '6281234567890'],
    ]);
    $product = cartTestProduct();

    Livewire::test(Cart::class)
        ->call('add', $product)
        ->set('name', 'Budi Santoso')
        ->set('phone', '081234567890')
        ->set('address', 'Jl. Taratak No. 10')
        ->set('note', 'Mohon dikirim hari ini')
        ->call('checkout')
        ->assertSessionMissing('cart_items')
        ->assertDispatched('open-whatsapp');
});
