# Admin Spec — Koperasi Anyaman Mansiang

## Otentikasi Admin
- Single admin role.
- Login mendukung email atau username.
- Akun default dibuat oleh seeder:
  - `email: anyamanmansiang@gmail.com`, password: `anyamanmansiang2026*` -> hanya untuk gmail saja, tidak usah gunakan di dalam aplikasi
  - kredensial cpanel server `usn : anyamans`;  `pass : Xk:T+M$86E` -> ini juga tidak usah dimasukkan ke dalam aplikasi dan arsitektur auth nya 
  - `username: anyamansiangadmin`, password: `adminanyamansiang123` -> gunakan ini, jika diperlukan dengan format email gunakan `anyamanmansiang@gmail.com`
- Password default wajib diganti setelah login pertama.

## Product Resource
CRUD produk anyaman.

Field:
- `category_id`: select kategori produk, required.
- `sku`: text, nullable, unique.
- `name`: text, required.
- `slug`: text, required, unique, auto-generate dari nama bila kosong.
- `price`: numeric, required, minimum `0`.
- `description`: rich editor, nullable.
- `dimensions`: text, nullable.
- `material`: text, default `100% Tanaman Mansiang Alami`.
- `usage_instructions`: rich editor, nullable.
- `availability_status`: select enum, required.
- `estimated_production_days`: number, nullable, hanya tampil untuk `pre_order`.
- `is_featured`: toggle, default `false`.
- `is_active`: toggle, default `true`.
- `primary_image`: image upload, required, disk `public`, direktori `products`.
- `images`: repeater galeri multi-foto, disk `public`, direktori `products`.

Validasi:
- `estimated_production_days` wajib diisi jika status `pre_order`.
- `estimated_production_days` harus `NULL` jika status bukan `pre_order`.
- `primary_image` wajib untuk produk aktif.

## Product Category Resource
CRUD kategori produk.

Field:
- `name`, `slug`, `description`, `image`, `sort_order`, `is_active`.

Validasi:
- `slug` unique.
- `is_active = false` tidak menghapus produk terkait, hanya menyembunyikan kategori dari filter publik.

## Post Resource
CRUD artikel blog.

Field:
- `post_category_id`: select kategori artikel, required.
- `author_id`: select admin, nullable.
- `title`, `slug`, `excerpt`, `content`, `featured_image`, `status`, `published_at`, `reading_time_minutes`, `meta_title`, `meta_description`.

Validasi:
- `slug` unique.
- `published_at` wajib diisi jika status `published`.
- `featured_image` wajib untuk artikel published.
- `meta_title` maksimal 255 karakter.
- `meta_description` maksimal 500 karakter.

## Post Category Resource
CRUD kategori artikel.

Field:
- `name`, `slug`, `description`.

Validasi:
- `slug` unique.
- Kategori tidak dapat dihapus bila masih memiliki artikel.

## Manage Landing Page
Pengaturan konten landing page.

### `landing_hero`
- `badge`: text.
- `headline`: text.
- `subheadline`: text.
- `cta_text`: text.
- `cta_link`: text.
- `slides`: repeater berisi `image`, `caption`, `sort_order`.

### `landing_about`
- `badge`: text.
- `title`: text.
- `description`: rich text.
- `primary_image`: image.
- `highlight_points`: repeater berisi `label`, `desc`.

### `landing_purpose`
- `badge`: text.
- `title`: text.
- `subtitle`: text.
- `items`: repeater berisi `title`, `description`, `image`.

### `landing_stats`
- `stats`: repeater berisi `value`, `label`.

## Manage About Page
Pengaturan konten halaman tentang koperasi.

### `about_content`
- `hero_image`: image.
- `history_title`: text.
- `history_narrative`: rich text.
- `impact_title`: text.
- `impact_narrative`: rich text.
- `gallery`: repeater berisi `image`, `caption`.

## Manage Site Settings
Pengaturan konten global.

### `site_general`
- `site_name`: text.
- `site_tagline`: text.
- `logo_path`: image.
- `favicon_path`: file.
- `footer_description`: rich text.

### `contact_info`
- `whatsapp_number`: text, format internasional tanpa tanda `+`.
- `whatsapp_display`: text.
- `email`: email.
- `phone`: text.
- `address`: text.
- `google_maps_embed`: text.
- `business_hours`: text.

### `social_media`
- `instagram`: url.
- `tiktok`: url.
- `facebook`: url.
- `youtube`: url.

## Overview dan Navigasi Admin
- Dashboard admin bernama `Overview`.
- Overview menampilkan jumlah total produk, produk `ready_stock`, produk `pre_order`, produk `out_of_stock`, total artikel, artikel draft, dan artikel terbit.
- Sidebar desktop dapat diciutkan menjadi ikon dengan tooltip; sidebar mobile tetap memakai drawer bawaan Filament.
- Navigasi disusun ringkas: Overview, Konten Situs, Katalog Produk, dan Blog.
- Setiap kelompok dan item navigasi memiliki ikon.
- Kelompok navigasi dapat dibuka dan ditutup serta tampil tertutup secara default untuk mengurangi scrolling.
- Bagian terbawah sidebar menyediakan tautan `Kembali ke Situs` menuju root URL `/` di tab baru.

## Acceptance Criteria Admin
- Admin dapat login dengan email atau username.
- Admin dapat CRUD produk, kategori produk, artikel, dan kategori artikel.
- Admin dapat mengubah seluruh konten landing, about, konten global, kontak, dan media sosial tanpa mengubah kode.
- Upload gambar tersimpan di disk `public` dengan direktori tertata.
- Validasi form mencegah data tidak konsisten.
- Draft dan artikel terjadwal tidak tampil di frontend.
