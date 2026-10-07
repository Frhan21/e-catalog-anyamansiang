# Setting Spec — Site Settings Contract

## Bentuk Tabel

```sql
create table `site_settings` (
    `id`            bigint unsigned auto_increment primary key,
    `group`         varchar(50) not null,
    `key`           varchar(100) not null unique,
    `payload`       json not null,
    `created_at`    timestamp null,
    `updated_at`    timestamp null,
    index `site_settings_group_index` (`group`)
) default character set utf8mb4 collate 'utf8mb4_unicode_ci';
```

Satu record menyimpan satu section berbentuk payload JSON.

## Konvensi Kunci

Format akses: `key.sub_field`. Kolom `group` hanya untuk pengelompokan halaman admin dan query internal.

| group | key | isi |
|---|---|---|
| `general` | `site_general` | nama, tagline, logo, favicon, footer |
| `landing` | `landing_hero` | hero landing |
| `landing` | `landing_about` | cuplikan tentang di landing |
| `landing` | `landing_purpose` | tujuan & dampak |
| `landing` | `landing_stats` | statistik angka |
| `about` | `about_content` | isi halaman about lengkap |
| `contact` | `contact_info` | nomor, email, alamat, jam, maps |
| `social` | `social_media` | tautan media sosial |

## Payload Standar

### `general.site_general`

```json
{
  "site_name": "Koperasi Anyaman Mansiang",
  "site_tagline": "Karya Tradisi Taratak, Estetika Alam Berkelanjutan",
  "logo_path": "settings/logo.png",
  "favicon_path": "settings/favicon.ico",
  "footer_description": "Pusat kerajinan tangan anyaman mansiang asli Taratak."
}
```

### `landing.landing_hero`

```json
{
  "badge": "Kerajinan Asli Taratak",
  "headline": "Sentuhan Tradisi, Keindahan Alami yang Abadi",
  "subheadline": "Koleksi anyaman tangan eksklusif dari serat mansiang pilihan.",
  "cta_text": "Jelajahi Katalog",
  "cta_link": "/katalog",
  "slides": [
    {
      "image": "settings/hero-slide-1.jpg",
      "caption": "Anyaman Tikar Tradisional Berkualitas Tinggi",
      "sort_order": 1
    },
    {
      "image": "settings/hero-slide-2.jpg",
      "caption": "Koleksi Tas Mansiang Modern Nan Elegan",
      "sort_order": 2
    }
  ]
}
```

### `landing.landing_about`

```json
{
  "badge": "Filosofi Anyaman",
  "title": "Tumbuh dari Rawa, Dianyam dengan Cinta",
  "description": "Tanaman mansiang dipanen secara berkelanjutan dari rawa alami Taratak.",
  "primary_image": "settings/about-landing.jpg",
  "highlight_points": [
    { "label": "100% Serat Alami", "desc": "Bebas bahan kimia berbahaya" },
    { "label": "Pemberdayaan Lokal", "desc": "Dibuat langsung oleh ibu pengrajin desa" },
    { "label": "Kuat & Tahan Lama", "desc": "Serat ulet dengan teknik anyam rapat" }
  ]
}
```

### `landing.landing_purpose`

```json
{
  "badge": "Tujuan Koperasi",
  "title": "Membawa Manfaat bagi Bumi dan Masyarakat",
  "subtitle": "Koperasi Anyaman Mansiang hadir bukan hanya sebagai wadah usaha.",
  "items": [
    {
      "title": "Pemberdayaan Pengrajin",
      "description": "Membuka lapangan kerja dan kemandirian finansial.",
      "image": "settings/purpose-1.jpg"
    },
    {
      "title": "Pelestarian Warisan Kriya",
      "description": "Menjaga teknik menganyam tradisional Minangkabau.",
      "image": "settings/purpose-2.jpg"
    },
    {
      "title": "Pengembangan Produk Berkelanjutan",
      "description": "Mengembangkan desain anyaman yang relevan dengan pasar modern.",
      "image": "settings/purpose-3.jpg"
    }
  ]
}
```

### `landing.landing_stats`

```json
{
  "stats": [
    { "value": "50+", "label": "Ibu Pengrajin Berdaya" },
    { "value": "100+", "label": "Varian Desain Produk" },
    { "value": "100%", "label": "Bahan Alami Berkelanjutan" },
    { "value": "10+", "label": "Tahun Warisan Keahlian" }
  ]
}
```

### `about.about_content`

```json
{
  "hero_image": "settings/about-hero.jpg",
  "history_title": "Awal Mula Perjalanan Koperasi",
  "history_narrative": "Berawal dari kearifan lokal masyarakat Taratak dalam memanfaatkan tanaman mansiang.",
  "impact_title": "Dampak Sosial & Ekonomi",
  "impact_narrative": "Melalui koperasi ini, hasil anyaman memiliki nilai jual lebih tinggi.",
  "gallery": [
    { "image": "settings/gallery-1.jpg", "caption": "Proses penjemuran mansiang" },
    { "image": "settings/gallery-2.jpg", "caption": "Proses pewarnaan serat" },
    { "image": "settings/gallery-3.jpg", "caption": "Ibu pengrajin sedang menyelesaikan anyaman" }
  ]
}
```

### `contact.contact_info`

```json
{
  "whatsapp_number": "6281234567890",
  "whatsapp_display": "+62 812-3456-7890",
  "email": "anyamanmansiang@gmail.com",
  "phone": "+62 812-3456-7890",
  "address": "Taratak, Kenagarian Taratak, Kec. Payakumbuh, Sumatera Barat",
  "google_maps_embed": "https://maps.app.goo.gl/cCn4xYfTiMox9Wf76",
  "business_hours": "Senin - Sabtu: 08.00 - 17.00 WIB"
}
```

### `social.social_media`

```json
{
  "instagram": "https://instagram.com/anyamanmansiang",
  "tiktok": "https://tiktok.com/@anyamanmansiang",
  "facebook": "https://facebook.com/anyamanmansiang",
  "youtube": ""
}
```

## Helper

File: `app/Helpers/SettingHelper.php`.

```php
if (!function_exists('setting')) {
    function setting(string $keyPath, $default = null)
    {
        [$key, $subKey] = explode('.', $keyPath, 2) + [null, null];

        $settings = cache()->rememberForever("site_settings_{$key}", function () use ($key) {
            return \App\Models\SiteSetting::where('key', $key)->value('payload') ?? [];
        });

        if ($subKey === null) {
            return $settings ?: $default;
        }

        return data_get($settings, $subKey, $default);
    }
}
```

### Cache Invalidation
Model `App\Models\SiteSetting` mendaftarkan observer `saved` dan `deleted` untuk menghapus cache `site_settings_{key}` terkait.

```php
protected $casts = ['payload' => 'array'];

protected static function booted(): void
{
    static::saved(fn ($model) => cache()->forget("site_settings_{$model->key}"));
    static::deleted(fn ($model) => cache()->forget("site_settings_{$model->key}"));
}
```

## Aturan Akses
- Blade dan Controller wajib menggunakan helper `setting(...)`.
- Dilarang query `SiteSetting::where(...)` langsung.
- Dilarang menambah kunci baru di runtime tanpa migrasi seed.
- Format key: `group.sub_field`. Contoh: `setting('landing_hero.headline')`, `setting('contact_info.whatsapp_number')`.

## Acceptance Criteria
- Seluruh setting dapat diubah di Filament tanpa deploy ulang.
- Perubahan setting otomatis terlihat di frontend tanpa clear cache manual.
- Helper tidak query database di setiap request saat cache aktif.
- Payload selalu valid sesuai kontrak; validasi terjadi di layer Filament.
