<?php

use App\Enums\AvailabilityStatus;
use App\Enums\PostStatus;
use App\Livewire\Catalog\ProductCatalog;
use App\Models\Post;
use App\Models\PostCategory;
use App\Models\Product;
use App\Models\ProductCategory;
use Livewire\Livewire;

it('renders public pages', function () {
    $category = ProductCategory::create(['name' => 'Tikar', 'slug' => 'tikar']);
    $product = Product::create([
        'category_id' => $category->id,
        'name' => 'Tikar Munjung',
        'slug' => 'tikar-munjung',
        'price' => 185000,
        'primary_image' => 'products/tikar-munjung.jpg',
        'availability_status' => AvailabilityStatus::ReadyStock,
        'is_active' => true,
        'is_featured' => true,
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

    $this->get('/')->assertOk()->assertSee('Tikar Munjung')
        ->assertViewHas('featured', function ($products) {
            expect($products->first()->relationLoaded('images'))->toBeFalse();
            expect($products->first()->getAttributes())->not->toHaveKeys(['description', 'usage_instructions']);

            return true;
        })
        ->assertViewHas('latestPosts', function ($posts) {
            expect($posts->first()->relationLoaded('author'))->toBeFalse();
            expect($posts->first()->getAttributes())->not->toHaveKeys(['content', 'meta_description']);

            return true;
        });
    $this->get('/about-us')->assertOk();
    $this->get('/catalog')->assertOk();
    $this->get('/products/'.$product->slug)->assertOk()->assertSee('Tikar Munjung');
    $this->get('/blog')->assertOk()->assertSee('Mengenal Mansiang');
    $this->get('/blog/'.$post->slug)->assertOk()->assertSee('Mengenal Mansiang');
});

it('filters catalog products', function () {
    $category = ProductCategory::create(['name' => 'Tas', 'slug' => 'tas']);

    Product::create([
        'category_id' => $category->id,
        'name' => 'Tas Selempang',
        'slug' => 'tas-selempang',
        'price' => 145000,
        'primary_image' => 'products/tas-selempang.jpg',
        'availability_status' => AvailabilityStatus::PreOrder,
        'is_active' => true,
    ]);

    Product::create([
        'category_id' => $category->id,
        'name' => 'Dompet Anyam',
        'slug' => 'dompet-anyam',
        'price' => 75000,
        'primary_image' => 'products/dompet-anyam.jpg',
        'availability_status' => AvailabilityStatus::ReadyStock,
        'is_active' => true,
    ]);

    Livewire::test(ProductCatalog::class)
        ->set('search', 'Tas')
        ->assertSee('Tas Selempang')
        ->assertDontSee('Dompet Anyam')
        ->set('search', '')
        ->set('availability', AvailabilityStatus::ReadyStock->value)
        ->assertSee('Dompet Anyam')
        ->assertDontSee('Tas Selempang');
});

it('applies zero price filters', function () {
    $category = ProductCategory::create(['name' => 'Aksesori', 'slug' => 'aksesori']);

    Product::create([
        'category_id' => $category->id,
        'name' => 'Sampel Gratis',
        'slug' => 'sampel-gratis',
        'price' => 0,
        'primary_image' => 'products/sampel-gratis.jpg',
        'availability_status' => AvailabilityStatus::ReadyStock,
        'is_active' => true,
    ]);

    Product::create([
        'category_id' => $category->id,
        'name' => 'Gantungan Kunci',
        'slug' => 'gantungan-kunci',
        'price' => 15000,
        'primary_image' => 'products/gantungan-kunci.jpg',
        'availability_status' => AvailabilityStatus::ReadyStock,
        'is_active' => true,
    ]);

    Livewire::test(ProductCatalog::class)
        ->set('minPrice', 0)
        ->assertSet('minPrice', 0)
        ->assertSee('Sampel Gratis')
        ->assertSee('Gantungan Kunci')
        ->set('maxPrice', 0)
        ->assertSet('maxPrice', 0)
        ->assertSee('Sampel Gratis')
        ->assertDontSee('Gantungan Kunci');
});

it('renders the active blog category', function () {
    $category = PostCategory::create(['name' => 'Kabar Koperasi', 'slug' => 'kabar-koperasi']);

    Post::create([
        'post_category_id' => $category->id,
        'title' => 'Rapat Anggota Tahunan',
        'slug' => 'rapat-anggota-tahunan',
        'content' => '<p>Isi artikel.</p>',
        'status' => PostStatus::Published,
        'published_at' => now(),
    ]);

    $this->get('/blog/category/'.$category->slug)
        ->assertOk()
        ->assertSee('Rapat Anggota Tahunan')
        ->assertViewHas('currentCategory', fn (PostCategory $view) => $view->is($category));
});

it('resets catalog pagination when filters are reset', function () {
    Livewire::test(ProductCatalog::class)
        ->call('setPage', 2)
        ->assertSet('paginators.page', 2)
        ->call('resetFilters')
        ->assertSet('paginators.page', 1);
});

it('orders related posts deterministically', function () {
    $category = PostCategory::create(['name' => 'Cerita', 'slug' => 'cerita']);

    $post = Post::create([
        'post_category_id' => $category->id,
        'title' => 'Artikel Utama',
        'slug' => 'artikel-utama',
        'content' => '<p>Isi artikel.</p>',
        'status' => PostStatus::Published,
        'published_at' => now(),
    ]);

    $older = Post::create([
        'post_category_id' => $category->id,
        'title' => 'Artikel Lama',
        'slug' => 'artikel-lama',
        'content' => '<p>Isi artikel.</p>',
        'status' => PostStatus::Published,
        'published_at' => now()->subDays(2),
    ]);

    $newer = Post::create([
        'post_category_id' => $category->id,
        'title' => 'Artikel Baru',
        'slug' => 'artikel-baru',
        'content' => '<p>Isi artikel.</p>',
        'status' => PostStatus::Published,
        'published_at' => now()->subDay(),
    ]);

    $this->get('/blog/'.$post->slug)
        ->assertOk()
        ->assertViewHas('relatedPosts', fn ($posts) => $posts->pluck('id')->all() === [$newer->id, $older->id]);
});

it('hides inactive products and draft posts', function () {
    $category = ProductCategory::create(['name' => 'Tikar', 'slug' => 'tikar']);
    $product = Product::create([
        'category_id' => $category->id,
        'name' => 'Produk Nonaktif',
        'slug' => 'produk-nonaktif',
        'price' => 10000,
        'primary_image' => 'products/x.jpg',
        'is_active' => false,
    ]);

    $postCategory = PostCategory::create(['name' => 'Berita', 'slug' => 'berita']);
    $post = Post::create([
        'post_category_id' => $postCategory->id,
        'title' => 'Draft Rahasia',
        'slug' => 'draft-rahasia',
        'content' => '<p>Draft.</p>',
        'status' => PostStatus::Draft,
    ]);

    $this->get('/products/'.$product->slug)->assertNotFound();
    $this->get('/blog/'.$post->slug)->assertNotFound();
});

it('redirects legacy indonesian urls permanently and preserves query', function () {
    $category = ProductCategory::create(['name' => 'Tikar', 'slug' => 'tikar']);
    $product = Product::create([
        'category_id' => $category->id,
        'name' => 'Tikar Munjung',
        'slug' => 'tikar-munjung',
        'price' => 185000,
        'primary_image' => 'products/tikar-munjung.jpg',
        'availability_status' => AvailabilityStatus::ReadyStock,
        'is_active' => true,
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

    $this->get('/tentang-kami')->assertRedirect('/about-us');
    $this->get('/katalog')->assertRedirect('/catalog');
    $this->get('/produk/'.$product->slug)->assertRedirect('/products/'.$product->slug);
    $this->get('/blog/kategori/'.$postCategory->slug)->assertRedirect('/blog/category/'.$postCategory->slug);
    $this->get('/katalog?page=2')->assertRedirect('/catalog?page=2');
});

it('withdraws locale switching and ignores old locale preferences', function () {
    $this->post('/language', ['locale' => 'en'])->assertNotFound();

    $this->withSession(['locale' => 'en'])
        ->withCookie('locale', 'en')
        ->get('/catalog')
        ->assertOk()
        ->assertSee('<html lang="id"', false)
        ->assertSee('Home')
        ->assertSee('About Us')
        ->assertSee('Catalog')
        ->assertSee('Cari nama, SKU, material...')
        ->assertDontSee('Search products');
});

it('does not treat a category slug as a post slug', function () {
    $category = PostCategory::create(['name' => 'Cerita', 'slug' => 'cerita']);

    $this->get('/blog/category/'.$category->slug)->assertOk();
    $this->get('/blog/cerita')->assertNotFound();
});
