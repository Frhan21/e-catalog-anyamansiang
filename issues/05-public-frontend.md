# 05 — Public Frontend (Landing, Katalog, Detail, Blog)

**Konteks & Tujuan:**
Pengunjung bisa lihat landing page, lihat katalog (Livewire filter), detail produk, dan blog sesuai `specs/app-spec.md`. Dummy content agar terlihat utuh.

**Ruang Lingkup:**
- Routes: `/`, `/tentang-kami`, `/katalog`, `/produk/{slug}`, `/blog`, `/blog/{slug}`.
- Layout + komponen: `<x-product-card>`, `<x-section-heading>`, `<x-whatsapp-button>`.
- Livewire `ProductCatalog`: filter `#[Url]`, debounce, pagination, reset.
- Detail produk: galeri, info, related, share.
- Blog: daftar kategori + detail.
- Konten dari `site_settings`, jika kosong fallback dummy.

**Acceptance Criteria:**
- [ ] Landing tampil hero, about teaser, tujuan & dampak, produk unggulan, latest stories, footer lengkap.
- [ ] `/katalog` filter tanpa reload, state URL sinkron.
- [ ] Detail produk CTA WhatsApp valid.
- [ ] `/blog` dan detail artikel tampil.

**Blocked by:** 04 — Filament Admin Resources

**Status:** done

**Catatan Testing:**
- Verifikasi: `php artisan test`, `./vendor/bin/pint`, `npm run build`, akses manual.
