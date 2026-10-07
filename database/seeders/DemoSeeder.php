<?php

namespace Database\Seeders;

use App\Enums\AvailabilityStatus;
use App\Enums\PostStatus;
use App\Models\Post;
use App\Models\PostCategory;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\User;
use Illuminate\Database\Seeder;

class DemoSeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Tikar Anyam', 'slug' => 'tikar-anyam', 'image' => 'categories/tikar-anyam.jpg'],
            ['name' => 'Tas Mansiang', 'slug' => 'tas-mansiang', 'image' => 'categories/tas-mansiang.jpg'],
            ['name' => 'Aksesoris', 'slug' => 'aksesoris', 'image' => 'categories/aksesoris.jpg'],
        ];

        foreach ($categories as $data) {
            ProductCategory::firstOrCreate(['slug' => $data['slug']], $data);
        }

        $products = [
            [
                'category_slug' => 'tikar-anyam',
                'sku' => 'TM-001',
                'name' => 'Tikar Munjung',
                'slug' => 'tikar-munjung',
                'price' => 185000,
                'description' => '<p>Tikar anyam mansiang ukuran besar untuk ruang keluarga.</p>',
                'dimensions' => '120 x 180 cm',
                'availability_status' => AvailabilityStatus::ReadyStock,
                'is_featured' => true,
                'primary_image' => 'https://upload.wikimedia.org/wikipedia/commons/b/bb/Basket_weaving_crafts_on_display_at_Rumeilah_Park_in_Doha.jpg',
                'images' => ['https://upload.wikimedia.org/wikipedia/commons/d/d0/Basket_weaver.jpg', 'https://upload.wikimedia.org/wikipedia/commons/4/44/Basket_weaving_in_process.jpg'],
            ],
            [
                'category_slug' => 'tas-mansiang',
                'sku' => 'TM-T01',
                'name' => 'Tas Selempang Mansiang',
                'slug' => 'tas-selempang-mansiang',
                'price' => 145000,
                'description' => '<p>Tas selempang modern dari serat mansiang.</p>',
                'dimensions' => '25 x 20 x 8 cm',
                'availability_status' => AvailabilityStatus::PreOrder,
                'estimated_production_days' => 7,
                'is_featured' => true,
                'primary_image' => 'https://upload.wikimedia.org/wikipedia/commons/b/bb/Basket_weaving_crafts_on_display_at_Rumeilah_Park_in_Doha.jpg',
                'images' => ['https://upload.wikimedia.org/wikipedia/commons/4/44/Basket_weaving_in_process.jpg'],
            ],
            [
                'category_slug' => 'aksesoris',
                'sku' => 'TM-A01',
                'name' => 'Dompet Anyam',
                'slug' => 'dompet-anyam',
                'price' => 75000,
                'description' => '<p>Dompet anyam kecil.</p>',
                'dimensions' => '20 x 10 cm',
                'availability_status' => AvailabilityStatus::ReadyStock,
                'is_featured' => false,
                'primary_image' => 'https://upload.wikimedia.org/wikipedia/commons/d/d0/Basket_weaver.jpg',
                'images' => [],
            ],
        ];

        foreach ($products as $data) {
            $category = ProductCategory::where('slug', $data['category_slug'])->first();
            unset($data['category_slug']);
            $images = $data['images'];
            unset($data['images']);

            $product = Product::firstOrCreate(
                ['slug' => $data['slug']],
                array_merge($data, ['category_id' => $category->id])
            );

            foreach ($images as $path) {
                $product->images()->firstOrCreate(['image_path' => $path]);
            }
        }

        $postCategory = PostCategory::firstOrCreate(
            ['slug' => 'cerita-pengrajin'],
            ['name' => 'Cerita Pengrajin', 'description' => 'Kisah dari balik anyaman mansiang.']
        );

        $author = User::first();

        $posts = [
            [
                'title' => 'Mengenal Tanaman Mansiang',
                'slug' => 'mengenal-tanaman-mansiang',
                'excerpt' => 'Tanaman yang menjadi dasar karya koperasi.',
                'content' => '<p>Tanaman mansiang tumbuh di rawa Taratak dan menjadi bahan utama kerajinan.</p>',
                'featured_image' => 'https://upload.wikimedia.org/wikipedia/commons/4/44/Basket_weaving_in_process.jpg',
                'status' => PostStatus::Published,
                'published_at' => now()->subDay(),
            ],
            [
                'title' => 'Pemberdayaan Ibu-Ibu Pengrajin',
                'slug' => 'pemberdayaan-ibu-pengrajin',
                'excerpt' => 'Dari menganyam hingga mandiri finansial.',
                'content' => '<p>Koperasi memberdayakan puluhan ibu pengrajin di desa.</p>',
                'featured_image' => 'posts/pemberdayaan.jpg',
                'status' => PostStatus::Published,
                'published_at' => now()->subDays(3),
            ],
        ];

        foreach ($posts as $data) {
            Post::firstOrCreate(
                ['slug' => $data['slug']],
                array_merge($data, ['post_category_id' => $postCategory->id, 'author_id' => $author?->id])
            );
        }
    }
}
