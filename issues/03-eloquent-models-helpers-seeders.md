# 03 — Eloquent Models, Helpers & Seeders

**Konteks & Tujuan:**
Tabel sudah ada, belum ada model dan helper. Ini fondasi untuk Filament admin, katalog Livewire, dan konten landing page.

**Ruang Lingkup:**
- Models: `ProductCategory`, `Product`, `ProductImage`, `PostCategory`, `Post`, `SiteSetting`, update `User`.
- Semua model punya `$fillable` eksplisit, eager load relasi, enum cast.
- `SiteSetting` cast payload array, observer(saved/deleted) untuk invalidate cache.
- Helper `setting()` via `SettingHelper.php`, helper `WhatsAppHelper::orderUrl($product, $setting)`.
- Seeder: admin default (`anyamansiangadmin`), payload setting dasar per `setting-spec.md`.

**Acceptance Criteria:**
- [ ] Model lengkap dengan relasi + cast yang benar.
- [ ] Helper `setting('contact_info.whatsapp_number')` ambil dari DB/cache.
- [ ] `WhatsAppHelper::orderUrl()` hasilkan URL `https://wa.me/...` ter-encode.
- [ ] Seeder jalan: admin bisa login, setting terisi.

**Blocked by:** 02 — Migration Database

**Status:** done

**Catatan Testing:**
- Verifikasi: `php artisan db:seed`, `php artisan test`, `./vendor/bin/pint`.
