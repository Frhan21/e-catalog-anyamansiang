# Architecture — Koperasi Anyaman Mansiang

## Layers

```
┌─────────────────────────────────────────────────────────────────────┐
│ Presentation                                                        │
│ Blade Views + Livewire Components + Alpine.js + Tailwind CSS        │
│ Motion: Swiper.js + GSAP/ScrollTrigger                              │
├─────────────────────────────────────────────────────────────────────┤
│ Admin / CMS                                                         │
│ Filament v3 Resources & Manage Pages                                │
│ ProductResource | PostResource | Category Resources | Settings      │
├─────────────────────────────────────────────────────────────────────┤
│ Application                                                         │
│ Controllers, Livewire Components, Form Requests, Helpers            │
│ WhatsApp Helper, SEO/OpenGraph Builder, Setting Helper              │
├─────────────────────────────────────────────────────────────────────┤
│ Domain / Data                                                       │
│ Eloquent Models + MySQL Migrations                                  │
├─────────────────────────────────────────────────────────────────────┤
│ Storage                                                             │
│ MySQL Database + Local Public Storage (images)                      │
└─────────────────────────────────────────────────────────────────────┘
```

## Directory Structure

```
anyaman-mansiang-katalog/
├── app/
│   ├── Helpers/
│   │   ├── SettingHelper.php
│   │   └── WhatsAppHelper.php
│   ├── Filament/
│   │   ├── Pages/
│   │   │   ├── ManageLandingPage.php
│   │   │   ├── ManageAboutPage.php
│   │   │   └── ManageSiteSettings.php
│   │   └── Resources/
│   │       ├── ProductResource.php
│   │       ├── ProductCategoryResource.php
│   │       ├── PostResource.php
│   │       └── PostCategoryResource.php
│   ├── Http/
│   │   └── Controllers/
│   │       ├── LandingController.php
│   │       ├── AboutController.php
│   │       ├── ProductController.php
│   │       └── PostController.php
│   ├── Livewire/
│   │   └── Catalog/
│   │       └── ProductCatalog.php
│   ├── Models/
│   │   ├── User.php
│   │   ├── Product.php
│   │   ├── ProductCategory.php
│   │   ├── ProductImage.php
│   │   ├── Post.php
│   │   ├── PostCategory.php
│   │   └── SiteSetting.php
│   └── View/
│       └── Components/
│           ├── ProductCard.php
│           ├── SectionHeading.php
│           └── WhatsAppButton.php
├── config/
│   └── constants.php (opsional, contoh: default paginate size)
├── database/
│   ├── migrations/
│   └── seeders/
│       └── AdminUserSeeder.php
├── resources/
│   ├── css/
│   │   └── app.css
│   ├── js/
│   │   ├── app.js
│   │   ├── sliders.js
│   │   └── animations.js
│   └── views/
│       ├── components/
│       ├── layouts/
│       ├── pages/
│       └── livewire/
├── routes/
│   └── web.php
├── tests/
│   └── Feature/
│       ├── CatalogTest.php
│       ├── ProductTest.php
│       ├── PostTest.php
│       └── SettingTest.php
├── docs/                    (di root repo, mirror dari vault)
├── specs/                   (di root repo, mirror dari vault)
├── issues/                  (di root repo, mirror dari vault)
└── AGENTS.md
```

## Routing (web.php)

| Method | URI | Handler | Keterangan |
|---|---|---|---|
| GET | `/` | LandingController@index | Halaman beranda |
| GET | `/tentang-kami` | AboutController@index | Halaman about |
| GET | `/katalog` | ProductCatalog (Livewire) | Halaman katalog dengan filter |
| GET | `/produk/{product:slug}` | ProductController@show | Detail produk |
| GET | `/blog` | PostController@index | Daftar artikel |
| GET | `/blog/{post:slug}` | PostController@show | Detail artikel |
| GET | `/admin` | Filament | Admin panel (auto-route) |

## Alur Pemesanan via WhatsApp
1. Pengunjung buka detail produk.
2. Controller memanggil `WhatsAppHelper::orderUrl($product, $setting)`.
3. Helper membangun URL:
   ```
   https://wa.me/{number}?text=Halo%20Admin...
   ```
4. Tombol "Pesan via WhatsApp" mengarahkan ke URL tersebut.

## Alur Filter Katalog
1. Livewire `ProductCatalog` load produk dengan eager load.
2. Properti publik: `$search`, `$selectedCategories`, `$minPrice`, `$maxPrice`, `$availability`.
3. Setiap properti di-cast ke URL lewat `#[Url]`.
4. Computed property `$products` merender hasil filter secara reaktif.

## Optimasi
- Eager load relasi produk.
- Lazy load galeri dengan Swiper lazy.
- Query string filter untuk shareable URL dan SEO.
- SEO tags dinamis di detail produk dan artikel.
- Cache `site_settings` forever dengan invalidasi otomatis.
