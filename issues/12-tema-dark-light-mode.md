# 12 — Tema Dark/Light Mode Publik

**Konteks & Tujuan:**
Tampilan publik saat ini fixed light mode. Tambahkan dark mode agar pengunjung bisa memilih, dan default ikut preferensi sistem.

**Ruang Lingkup:**
- Tambahkan toggle light/dark di `<x-nav />` (desktop dan mobile).
- Default: ikut `prefers-color-scheme` sistem.
- Override user disimpan di `localStorage`, tahan antar reload dan navigasi.
- Tambahkan inline script kecil di `<head>` (sebelum render) untuk mengecek `localStorage`/`prefers-color-scheme` dan men-set `class="dark"` pada `<html>` agar tidak ada flash.
- Extend token warna di `resources/css/app.css` untuk dark variant (`dark:` mode) atau pakai CSS variables di dalam `:root` dan `.dark`.
- Pastikan semua section publik (hero, about, purpose, stats, produk, footer, nav) tampil benar di kedua mode.

**Acceptance Criteria:**
- [ ] Toggle light/dark tersedia di navbar (desktop & mobile) dan dapat diklik.
- [ ] Pertama kalinya: tema = preferensi sistem (light/dark).
- [ ] Setelah user klik toggle, pilihan tersimpan dan berlaku di seluruh halaman.
- [ ] Tidak ada flash light-then-dark saat reload (early script berjalan).
- [ ] Semua section publik (nav, hero, about, purpose, stats, produk, footer) readable di light & dark mode.
- [ ] `php artisan test`, `./vendor/bin/pint`, `npm run build` lulus.

**Blocked by:** None — can start immediately

**Status:** todo

**Catatan Testing:**
- Pest feature: assert toggle element exists di nav, assert early theme script ada di layout `<head>`.
- Manual: reload page → ikut sistem; klik toggle → berubah & persist; cek semua section.