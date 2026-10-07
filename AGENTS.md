# AGENTS.md — Pedoman Pengembangan Koperasi Anyaman Mansiang

Dokumen ini selaras dengan `docs/architecture.md` dan dokumen di `specs/`.
File ini ditempatkan di root repository sebagai `AGENTS.md`.

## 1. Project Overview & Stack
- Website: e-katalog & company profile Koperasi Anyaman Mansiang.
- Backend: Laravel 12 (PHP 8.3+).
- Admin panel & CMS: Filament PHP v3.
- Reactivity: Livewire v3 + Alpine.js.
- Styling: Tailwind CSS.
- Slider & motion: Swiper.js + GSAP + ScrollTrigger.
- Database: MySQL.
- Testing & linting: Pest PHP + Laravel Pint.
- Asset storage: local public storage (`storage/app/public` lewat symlink).

## 2. Workflow Pengembangan (Spec-Driven Development)
Semua pekerjaan kerjakan melalui issue tracker dengan urutan skill berikut:

1. `/grill-me` — wawancara intensif untuk mematangkan plan dari ide/kebutuhan.
2. `/to-spec` — plan diubah menjadi spec di `specs/`.
3. `/to-tickets` — spec dipecah menjadi ticket di `issues/{nn}-nama-issue.md`.
4. `/implement` — implementasi ticket dengan TDD.

Setiap ticket wajib punya dokumen `issues/{nn}-nama-issue.md` yang menjelaskan:
- Konteks & tujuan pekerjaan.
- Ruang lingkup (scope) pekerjaan.
- Acceptance criteria.
- Status (`todo`, `in progress`, `blocked`, `done`).
- Catatan Testing.

## 3. Aturan Spec-Driven
- Jangan menulis kode sebelum spec selesai dan disetujui.
- Spec adalah sumber kebenaran untuk schema, aturan bisnis, dan alur UI.
- Perubahan aturan bisnis wajib memperbarui spec lebih dulu.
- Tidak boleh menambah fitur di luar spec tanpa ticket baru.

## 4. Aturan TDD
- Kerjakan dengan siklus red-green-refactor.
- Test minimal mencakup: happy path, batasan validasi, dan error handling kritis.
- Perintah verifikasi wajib sebelum menyatakan selesai:
  - `php artisan test`
  - `./vendor/bin/pint`
  - `npm run build`

## 5. Code Style & Architecture Conventions

### Livewire Components
- Katalog publik: `App\Livewire\Catalog\ProductCatalog`.
- Filter & search: `wire:model.live.debounce.300ms`.
- State filter disinkronkan ke URL lewat atribut `#[Url]`.

### Filament Resources
- Lokasi: `App\Filament\Resources\`.
- Form schema deklaratif.
- Upload memakai disk `public` dengan direktori tertata:
  - `products/` untuk foto produk.
  - `posts/` untuk gambar artikel.
  - `settings/` untuk logo, favicon, dan asset CMS.
- Settings page memakai Filament Manage Pages di `App\Filament\Pages\`.

### Frontend & Blade
- Komponen reusable di `resources/views/components/` (contoh: `<x-product-card>`, `<x-section-heading>`, `<x-whatsapp-button>`).
- Larangan menggunakan jQuery di frontend; gunakan Alpine.js untuk interaktivitas DOM.
- Inisialisasi Swiper.js dan GSAP di module Vite terpisah:
  - `resources/js/sliders.js`
  - `resources/js/animations.js`
- Jalankan setelah DOM ready dan pada event navigasi Livewire.
- Larangan script CDN langsung di Blade; semua library lewat npm dan Vite.

### Models & Database
- Setiap model wajib punya explicit `$fillable`; dilarang `$guarded = []`.
- Eager load relasi untuk mencegah N+1, contoh: `with(['category', 'images'])`.
- Status ketersediaan produk memakai enum cast (`ready_stock`, `pre_order`, `out_of_stock`).
- Setiap migrasi wajib punya foreign key constraint dengan aturan `ON DELETE` yang jelas.

### Site Settings
- Akses selalu lewat helper `setting('key.sub_field')` (lihat `specs/setting-spec.md`).
- Helper otomatis cache payload per key dan invalidate saat `SiteSetting` disimpan/dihapus.
- Dilarang query `SiteSetting` langsung dari Blade/Controller tanpa helper.

## 6. Design System Tokens
- Font display: Playfair Display / Cormorant Garamond.
- Font body: Plus Jakarta Sans.
- Primary: `mansiang-green` `#4A6B53`, `mansiang-dark` `#2A3D2F`.
- Accent: `mansiang-warm` `#A36A43`, `mansiang-ochre` `#C88D58`.
- Background: `mansiang-ivory` `#FDFBF7`, `mansiang-surface` `#F4EFE6`.
- Text: deep espresso charcoal `#1F2923`, muted taupe `#706E6B`.

## 7. Testing & Verification Rules
- Jalankan test: `php artisan test`
- Periksa format: `./vendor/bin/pint`
- Build aset: `npm run build`

## 8. Strict Constraints
- Dilarang menambahkan komentar kode kecuali diminta eksplisit.
- Dilarang menyimpan kredensial di repository; gunakan `.env` atau secret manager.
- Semua tautan WhatsApp wajib lewat helper `App\Helpers\WhatsAppHelper`.
- Gambar wajib di-resize untuk web dan disimpan dengan nama aman (slug + hash).
- Dilarang memakai jQuery di frontend.