# Database Spec — Koperasi Anyaman Mansiang

## Prinsip
- Database: MySQL.
- Seluruh primary key: `BIGINT UNSIGNED AUTO_INCREMENT`.
- Seluruh tabel menggunakan `created_at` dan `updated_at`.
- Slug dan kode bisnis yang dipakai dalam URL harus unik.
- Gunakan foreign key database, bukan validasi aplikasi saja.

## Entity Relationship Diagram

```text
[users] 1 ────< [posts] >──── 1 [post_categories]

[product_categories] 1 ────< [products] 1 ────< [product_images]

[site_settings]
```

## Table: `users`
Akun administrator Filament. Login mendukung email atau username.

| Kolom | Tipe | Aturan |
|---|---|---|
| `id` | big integer unsigned | primary key |
| `name` | varchar(255) | required |
| `username` | varchar(100) | required, unique |
| `email` | varchar(255) | required, unique |
| `email_verified_at` | timestamp | nullable |
| `password` | varchar(255) | required, hashed |
| `remember_token` | varchar(100) | nullable |

## Table: `product_categories`
Kategori klasifikasi produk anyaman.

| Kolom | Tipe | Aturan |
|---|---|---|
| `id` | big integer unsigned | primary key |
| `name` | varchar(150) | required |
| `slug` | varchar(180) | required, unique |
| `description` | text | nullable |
| `image` | varchar(255) | nullable |
| `sort_order` | integer | default `0` |
| `is_active` | boolean | default `true` |

## Table: `products`
Katalog produk utama.

| Kolom | Tipe | Aturan |
|---|---|---|
| `id` | big integer unsigned | primary key |
| `category_id` | big integer unsigned | required, FK ke `product_categories.id`, cascade on delete |
| `sku` | varchar(50) | nullable, unique |
| `name` | varchar(255) | required |
| `slug` | varchar(255) | required, unique |
| `price` | decimal(12,2) unsigned | required |
| `description` | longtext | nullable |
| `dimensions` | varchar(150) | nullable |
| `material` | varchar(255) | default `100% Tanaman Mansiang Alami` |
| `usage_instructions` | text | nullable |
| `availability_status` | enum | `ready_stock`, `pre_order`, atau `out_of_stock`; default `ready_stock` |
| `estimated_production_days` | integer unsigned | nullable; hanya diisi untuk pre-order |
| `is_featured` | boolean | default `false` |
| `is_active` | boolean | default `true` |
| `primary_image` | varchar(255) | required |
| `views_count` | big integer unsigned | default `0` |

## Table: `product_images`
Galeri foto multi-sudut produk.

| Kolom | Tipe | Aturan |
|---|---|---|
| `id` | big integer unsigned | primary key |
| `product_id` | big integer unsigned | required, FK ke `products.id`, cascade on delete |
| `image_path` | varchar(255) | required |
| `caption` | varchar(255) | nullable |
| `sort_order` | integer | default `0` |

## Table: `post_categories`
Kategori artikel; terpisah dari kategori produk.

| Kolom | Tipe | Aturan |
|---|---|---|
| `id` | big integer unsigned | primary key |
| `name` | varchar(150) | required |
| `slug` | varchar(180) | required, unique |
| `description` | text | nullable |

## Table: `posts`
Artikel kegiatan, pencapaian, dan cerita pengrajin.

| Kolom | Tipe | Aturan |
|---|---|---|
| `id` | big integer unsigned | primary key |
| `post_category_id` | big integer unsigned | required, FK ke `post_categories.id`, restrict on delete |
| `author_id` | big integer unsigned | nullable, FK ke `users.id`, null on delete |
| `title` | varchar(255) | required |
| `slug` | varchar(255) | required, unique |
| `excerpt` | text | nullable |
| `content` | longtext | required; HTML dari Rich Editor |
| `featured_image` | varchar(255) | nullable |
| `status` | enum | `draft` atau `published`; default `draft` |
| `published_at` | timestamp | nullable |
| `reading_time_minutes` | integer unsigned | default `1` |
| `meta_title` | varchar(255) | nullable |
| `meta_description` | text | nullable |

## Table: `site_settings`
Konfigurasi konten dinamis CMS. Satu record menyimpan satu section berbentuk payload JSON.

| Kolom | Tipe | Aturan |
|---|---|---|
| `id` | big integer unsigned | primary key |
| `group` | varchar(50) | required, indexed; nilai: `general`, `landing`, `about`, `contact`, `social` |
| `key` | varchar(100) | required, unique |
| `payload` | json | required |

Kontrak payload dan akses helper dijelaskan di [[setting-spec]].

## Index Tambahan
- `products`: index gabungan `category_id`, `is_active`, `availability_status`.
- `products`: index `price` untuk range filter.
- `posts`: index gabungan `status`, `published_at`.
- `site_settings`: index `group`.

## Aturan Data
- Produk tidak dapat ada tanpa kategori.
- Menghapus kategori produk menghapus produknya beserta galeri.
- Menghapus kategori artikel ditolak bila masih memiliki artikel.
- Menghapus admin tidak menghapus artikel; `author_id` menjadi `NULL`.
- `estimated_production_days` harus `NULL` untuk status selain `pre_order`.
- Produk publik harus `is_active = true`.
- Artikel publik harus berstatus `published` dan `published_at` tidak lebih besar dari waktu sekarang.
