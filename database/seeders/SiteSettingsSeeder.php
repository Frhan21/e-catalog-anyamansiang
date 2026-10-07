<?php

namespace Database\Seeders;

use App\Models\SiteSetting;
use Illuminate\Database\Seeder;

class SiteSettingsSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            'general' => [
                'key' => 'site_general',
                'payload' => [
                    'site_name' => 'Koperasi Anyaman Mansiang',
                    'site_tagline' => 'Karya Tradisi Taratak, Estetika Alam Berkelanjutan',
                    'logo_path' => 'settings/logo.png',
                    'favicon_path' => 'settings/favicon.ico',
                    'footer_description' => 'Pusat kerajinan tangan anyaman mansiang asli Taratak.',
                ],
            ],
            'landing' => [
                'key' => 'landing_hero',
                'group' => 'landing',
                'payload' => [
                    'badge' => 'Kerajinan Asli Taratak',
                    'headline' => 'Sentuhan Tradisi, Keindahan Alami yang Abadi',
                    'subheadline' => 'Koleksi anyaman tangan eksklusif dari serat mansiang pilihan.',
                    'cta_text' => 'Jelajahi Katalog',
                    'cta_link' => '/catalog',
                    'slides' => [
                        ['image' => 'https://upload.wikimedia.org/wikipedia/commons/b/bb/Basket_weaving_crafts_on_display_at_Rumeilah_Park_in_Doha.jpg', 'caption' => 'Foto contoh: Kerajinan Anyaman Tradisional', 'sort_order' => 1],
                        ['image' => 'https://upload.wikimedia.org/wikipedia/commons/4/44/Basket_weaving_in_process.jpg', 'caption' => 'Foto contoh: Proses Menganyam Tradisional', 'sort_order' => 2],
                    ],
                ],
            ],
            'landing_about' => [
                'key' => 'landing_about',
                'group' => 'landing',
                'payload' => [
                    'badge' => 'Filosofi Anyaman',
                    'title' => 'Tumbuh dari Rawa, Dianyam dengan Cinta',
                    'description' => 'Tanaman mansiang dipanen secara berkelanjutan dari rawa alami Taratak.',
                    'primary_image' => 'https://upload.wikimedia.org/wikipedia/commons/d/d0/Basket_weaver.jpg',
                    'highlight_points' => [
                        ['label' => '100% Serat Alami', 'desc' => 'Bebas bahan kimia berbahaya'],
                        ['label' => 'Pemberdayaan Lokal', 'desc' => 'Dibuat langsung oleh ibu pengrajin desa'],
                        ['label' => 'Kuat & Tahan Lama', 'desc' => 'Serat ulet dengan teknik anyam rapat'],
                    ],
                ],
            ],
            'landing_purpose' => [
                'key' => 'landing_purpose',
                'group' => 'landing',
                'payload' => [
                    'badge' => 'Tujuan Koperasi',
                    'title' => 'Membawa Manfaat bagi Bumi dan Masyarakat',
                    'subtitle' => 'Koperasi Anyaman Mansiang hadir bukan hanya sebagai wadah usaha.',
                    'items' => [
                        ['title' => 'Pemberdayaan Pengrajin', 'description' => 'Membuka lapangan kerja dan kemandirian finansial.', 'image' => 'https://upload.wikimedia.org/wikipedia/commons/4/44/Basket_weaving_in_process.jpg'],
                        ['title' => 'Pelestarian Warisan Kriya', 'description' => 'Menjaga teknik menganyam tradisional Minangkabau.', 'image' => 'https://upload.wikimedia.org/wikipedia/commons/d/d0/Basket_weaver.jpg'],
                        ['title' => 'Pengembangan Produk Berkelanjutan', 'description' => 'Mengembangkan desain anyaman yang relevan dengan pasar modern.', 'image' => 'https://upload.wikimedia.org/wikipedia/commons/b/bb/Basket_weaving_crafts_on_display_at_Rumeilah_Park_in_Doha.jpg'],
                        ['title' => 'Penguatan Ekonomi Lokal', 'description' => 'Memperluas peluang usaha dan pemasaran bagi masyarakat Taratak.', 'image' => 'https://upload.wikimedia.org/wikipedia/commons/4/44/Basket_weaving_in_process.jpg'],
                    ],
                ],
            ],
            'landing_stats' => [
                'key' => 'landing_stats',
                'group' => 'landing',
                'payload' => [
                    'stats' => [
                        ['value' => '50+', 'label' => 'Ibu Pengrajin Berdaya'],
                        ['value' => '100+', 'label' => 'Varian Desain Produk'],
                        ['value' => '100%', 'label' => 'Bahan Alami Berkelanjutan'],
                        ['value' => '10+', 'label' => 'Tahun Warisan Keahlian'],
                    ],
                ],
            ],
            'about_content' => [
                'key' => 'about_content',
                'group' => 'about',
                'payload' => [
                    'hero_image' => 'https://upload.wikimedia.org/wikipedia/commons/b/bb/Basket_weaving_crafts_on_display_at_Rumeilah_Park_in_Doha.jpg',
                    'history_title' => 'Awal Mula Perjalanan Koperasi',
                    'history_narrative' => 'Berawal dari kearifan lokal masyarakat Taratak dalam memanfaatkan tanaman mansiang.',
                    'impact_title' => 'Dampak Sosial & Ekonomi',
                    'impact_narrative' => 'Melalui koperasi ini, hasil anyaman memiliki nilai jual lebih tinggi.',
                    'gallery' => [
                        ['image' => 'https://upload.wikimedia.org/wikipedia/commons/b/bb/Basket_weaving_crafts_on_display_at_Rumeilah_Park_in_Doha.jpg', 'caption' => 'Foto contoh kerajinan anyaman'],
                        ['image' => 'https://upload.wikimedia.org/wikipedia/commons/d/d0/Basket_weaver.jpg', 'caption' => 'Foto contoh detail anyaman'],
                        ['image' => 'https://upload.wikimedia.org/wikipedia/commons/4/44/Basket_weaving_in_process.jpg', 'caption' => 'Foto contoh proses menganyam'],
                    ],
                ],
            ],
            'contact_info' => [
                'key' => 'contact_info',
                'group' => 'contact',
                'payload' => [
                    'whatsapp_number' => '6281234567890',
                    'whatsapp_display' => '+62 812-3456-7890',
                    'email' => 'anyamanmansiang@gmail.com',
                    'phone' => '+62 812-3456-7890',
                    'address' => 'Taratak, Kenagarian Taratak, Kec. Payakumbuh, Sumatera Barat',
                    'google_maps_embed' => 'https://www.google.com/maps?q=-0.1439297,100.4908906&z=16&output=embed',
                    'business_hours' => 'Senin - Sabtu: 08.00 - 17.00 WIB',
                ],
            ],
            'social_media' => [
                'key' => 'social_media',
                'group' => 'social',
                'payload' => [
                    'instagram' => 'https://instagram.com/anyamanmansiang',
                    'tiktok' => 'https://tiktok.com/@anyamanmansiang',
                    'facebook' => 'https://facebook.com/anyamanmansiang',
                    'youtube' => '',
                ],
            ],
        ];

        foreach ($settings as $data) {
            SiteSetting::firstOrCreate(
                ['key' => $data['key']],
                [
                    'group' => $data['group'] ?? 'general',
                    'payload' => $data['payload'],
                ]
            );
        }
    }
}
