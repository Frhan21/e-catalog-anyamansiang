# 04 — Filament Admin Panel & Resources

**Konteks & Tujuan:**
Admin perlu kelola produk, kategori, artikel, dan konten CMS tanpa tulis kode, sesuai `specs/admin-spec.md`.

**Ruang Lingkup:**
- Panel `admin`, path `/admin`, guard default, login via email atau username.
- Resources: `ProductResource`, `ProductCategoryResource`, `PostResource`, `PostCategoryResource`.
- Manage Pages: `ManageLandingPage`, `ManageAboutPage`, `ManageSiteSettings` menulis record `site_settings`.
- Upload disk `public`, direktori `products/`, `posts/`, `settings/`.
- Validasi sesuai `admin-spec.md` termasuk kondisi khusus `estimated_production_days` dan `published_at`.

**Acceptance Criteria:**
- [ ] Admin bisa login `/admin` dengan username/email.
- [ ] CRUD produk/kategori/artikel berfungsi, upload masuk direktori benar.
- [ ] Halaman landing/about/settings bisa diubah tanpa deploy.
- [ ] Draft/terjadwal tidak tampil di frontend.

**Blocked by:** 03 — Eloquent Models, Helpers & Seeders

**Status:** done

**Catatan Testing:**
- Verifikasi: `php artisan test`, `./vendor/bin/pint`, akses manual `/admin`.
