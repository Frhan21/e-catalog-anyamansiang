<?php

use App\Models\SiteSetting;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('site_settings')) {
            return;
        }

        $contact = SiteSetting::where('key', 'contact_info')->first();
        $legacyMaps = [
            'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3',
            'https://maps.app.goo.gl/cCn4xYfTiMox9Wf76',
        ];

        if ($contact && in_array($contact->payload['google_maps_embed'] ?? null, $legacyMaps, true)) {
            $contact->update([
                'payload' => array_merge($contact->payload, [
                    'google_maps_embed' => 'https://www.google.com/maps?q=-0.1439297,100.4908906&z=16&output=embed',
                ]),
            ]);
        }

        $purpose = SiteSetting::where('key', 'landing_purpose')->first();
        $seededImages = [
            'https://upload.wikimedia.org/wikipedia/commons/4/44/Basket_weaving_in_process.jpg',
            'https://upload.wikimedia.org/wikipedia/commons/d/d0/Basket_weaver.jpg',
        ];
        $images = array_column($purpose?->payload['items'] ?? [], 'image');

        if ($purpose && $images === $seededImages) {
            $items = $purpose->payload['items'];
            $purpose->update([
                'payload' => array_merge($purpose->payload, [
                    'items' => array_merge($items, [
                        [
                            'title' => 'Pengembangan Produk Berkelanjutan',
                            'description' => 'Mengembangkan desain anyaman yang relevan dengan pasar modern.',
                            'image' => 'https://upload.wikimedia.org/wikipedia/commons/b/bb/Basket_weaving_crafts_on_display_at_Rumeilah_Park_in_Doha.jpg',
                        ],
                        [
                            'title' => 'Penguatan Ekonomi Lokal',
                            'description' => 'Memperluas peluang usaha dan pemasaran bagi masyarakat Taratak.',
                            'image' => 'https://upload.wikimedia.org/wikipedia/commons/4/44/Basket_weaving_in_process.jpg',
                        ],
                    ]),
                ]),
            ]);
        }
    }

    public function down(): void {}
};
