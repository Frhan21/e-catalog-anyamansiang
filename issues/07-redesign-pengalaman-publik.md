# 07 — Redesign Pengalaman Publik dan Poles Filament

**Konteks & Tujuan:**
UI publik berfungsi namun terasa kaku dan generik. Redesign seluruh halaman memakai arah editorial kriya modern, foto nyata sementara, slider nyata, serta motion halus. Filament cukup diberi identitas brand ringan tanpa mengganggu kegunaan CRUD.

**Ruang Lingkup:**
- Landing, katalog, detail produk, about, blog index/detail, nav, footer, dan komponen bersama.
- Hero dan galeri memakai Swiper.
- Reveal motion memakai GSAP dan menghormati reduced motion.
- Foto contoh URL eksternal dan tetap bisa diganti melalui CMS.
- Filament: brand name, palette, sidebar grouping, dashboard ringkas.
- Font tidak diubah sampai evaluasi terpisah.

**Acceptance Criteria:**
- [x] Semua halaman publik responsif dan mengikuti desain baru.
- [x] Hero slider dan product gallery berfungsi.
- [x] Animasi masuk aktif tanpa scroll listener manual dan nonaktif pada reduced motion.
- [x] External/local image path sama-sama ter-render.
- [x] Filament tetap utilitarian dengan identitas koperasi.
- [x] Test, Pint, build lulus.

**Blocked by:** 06 — Perbaikan UI Admin dan Media Dummy

**Status:** done

**Catatan Testing:**
- `php artisan test`
- `./vendor/bin/pint --test`
- `npm run build`
