# 01 — Setup Library & Dependencies

**Konteks & Tujuan:**
Aplikasi belum punya library inti yang dibutuhkan: Livewire (reaktivitas katalog), Filament v3 (admin panel & CMS), Pest (testing), Swiper.js + GSAP (slider & motion). PHP 8.3.32 dan Composer sudah tersedia, MySQL Aiven sudah terhubung. Filament v3 butuh ekstensi `ext-intl` yang belum terpasang di sistem.

**Ruang Lingkup:**
- Pasang ekstensi OS `php8.3-intl` (wajib untuk Filament v3).
- Composer: `filament/filament:^3.2` (otomatis menarik `livewire/livewire:^3`), dev deps `pestphp/pest` + `pestphp/pest-plugin-laravel` (dengan `-W` untuk resolusi phpunit).
- Inisialisasi Pest di project (`pest --init`).
- npm: `swiper`, `gsap`.
- Buat module Vite terpisah `resources/js/sliders.js` dan `resources/js/animations.js` (inisialisasi Swiper & GSAP, dipanggil setelah DOM ready dan navigasi Livewire).

**Acceptance Criteria:**
- [ ] `php -m` memuat `intl`.
- [ ] `composer show livewire/livewire` dan `composer show filament/filament` terinstall.
- [ ] `vendor/bin/pest` berjalan (Pest terinisialisasi).
- [ ] `npm ls swiper gsap` sukses.
- [ ] `npm run build` sukses tanpa error.
- [ ] `resources/js/sliders.js` dan `resources/js/animations.js` ada dan ter-import di `resources/js/app.js`.

**Status:** done

**Catatan Testing:**
- Verifikasi: `npm run build`, `./vendor/bin/pint --test`, `php artisan test`.
- Jangan install library di luar daftar ini tanpa ticket baru.
