# 02 — Migration Database Sesuai Struktur Disetujui

**Konteks & Tujuan:**
Database MySQL (Aiven) sudah terhubung dan migrasi default Laravel sudah jalan. Struktur tabel yang disetujui ada di `specs/database-spec.md`. Perlu migrasi untuk seluruh tabel domain: users (tambah `username`), product_categories, products, product_images, post_categories, posts, site_settings — lengkap dengan foreign key, index gabungan, dan enum.

**Ruang Lingkup:**
- Alter `users`: tambah kolom `username` varchar(100) unique (login admin via email atau username).
- `product_categories`: name, slug unique, description, image, sort_order, is_active.
- `products`: FK `category_id` (cascade on delete), sku unique nullable, name, slug unique, price decimal(12,2) unsigned, description longText, dimensions, material (default `100% Tanaman Mansiang Alami`), usage_instructions, enum `availability_status` (`ready_stock`/`pre_order`/`out_of_stock`), estimated_production_days, is_featured, is_active, primary_image, views_count; index gabungan `[category_id, is_active, availability_status]` dan index `price`.
- `product_images`: FK `product_id` (cascade on delete), image_path, caption, sort_order.
- `post_categories`: name, slug unique, description.
- `posts`: FK `post_category_id` (restrict on delete), FK `author_id` (null on delete), title, slug unique, excerpt, content longText, featured_image, enum `status` (`draft`/`published`), published_at, reading_time_minutes, meta_title, meta_description; index gabungan `[status, published_at]`.
- `site_settings`: `group` (indexed), `key` unique, `payload` json.

**Acceptance Criteria:**
- [ ] `php artisan migrate` sukses tanpa error.
- [ ] Semua tabel sesuai `specs/database-spec.md` (kolom, tipe, default, nullable).
- [ ] Foreign key constraint ada dengan aturan ON DELETE yang benar (cascade untuk kategori produk & galeri; restrict untuk kategori artikel; null on delete untuk author).
- [ ] Index gabungan dan index `price` terbuat.
- [ ] `migrate:status` menunjukkan semua migrasi berstatus Ran.

**Blocked by:** 01 — Setup Library & Dependencies

**Status:** done

**Catatan Testing:**
- Verifikasi: `php artisan migrate`, `php artisan migrate:status`, cek struktur via `php artisan db:show` atau query `SHOW CREATE TABLE`.
- Database bersifat shared (Aiven) — jangan `migrate:fresh` tanpa konfirmasi.
