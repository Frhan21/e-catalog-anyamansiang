# 15 — English Navbar Labels + English URLs

**Konteks & Tujuan:**
Keputusan final: bilingual UI dibatalkan. Public URL tetap memakai slug Inggris, navbar memakai label Inggris, CMS dan mayoritas UI tetap bahasa Indonesia.

**Ruang Lingkup:**
- Public routes:
  - `/` (home)
  - `/about-us`
  - `/catalog`
  - `/products/{product:slug}`
  - `/blog`
  - `/blog/category/{category:slug}`
  - `/blog/{post:slug}`
- Route name tetap (`landing`, `about`, `catalog`, `products.show`, `posts.*`).
- Redirect permanen dari slug Indonesia lama ke URL Inggris.
- Hapus language toggle desktop dan mobile.
- Hapus route `/language` dan middleware locale switching.
- Navbar label hardcoded English: `Home`, `About Us`, `Catalog`, `Blog`, `Contact Us`.
- Cart button navbar icon-only.
- `<html lang="id">` tetap karena konten utama masih Indonesia.

**Acceptance Criteria:**
- [x] Semua public URL memakai English slugs seperti daftar di atas.
- [x] URL Indonesia lama redirect permanen ke URL Inggris yang sesuai.
- [x] Tidak ada toggle `ID | EN` desktop/mobile.
- [x] POST `/language` 404.
- [x] Session/cookie locale lama diabaikan.
- [x] Navbar label memakai English.
- [x] Cart button icon-only.
- [x] Category route tidak tertangkap sebagai post slug.
- [x] `php artisan test`, `./vendor/bin/pint`, `npm run build` lulus.

**Blocked by:** 10 — Section Tujuan; 11 — Statistik Counter; 12 — Tema Dark/Light Mode; 13 — Hero Slider; 14 — Footer Maps

**Status:** done

**Catatan Testing:**
- Pest feature: route English 200, route Indonesia redirect, `/language` 404, old locale ignored, navbar English, CMS text unchanged.
- Pest/Livewire: cart behavior tidak regress.
