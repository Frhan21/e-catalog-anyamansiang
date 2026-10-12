# 13 — Hero Slider: Nav Next/Prev + Hapus Pause & Label

**Konteks & Tujuan:**
Hero slider sekarang punya pagination, autoplay, pause/resume button, dan label "Foto contoh" per slide. Minta: tetap autoplay, tambahkan tombol prev/next untuk navigasi manual, hapus tulisan "foto contoh" dan hapus jeda slide (pause button).

**Ruang Lingkup:**
- Pertahankan autoplay hero (multiple slides).
- Tambahkan tombol navigasi prev/next (Swiper Navigation module — sudah ter-import, hanya perlu elemen `.swiper-button-prev` / `.swiper-button-next`).
- Hapus `<button data-swiper-autoplay-toggle>` dari markup landing.
- Hapus label "Foto contoh" (`{{ $slide['caption'] }}` yang muncul absolut bottom-right di hero).
- Caption di CMS tetap tersimpan (untuk keperluan alt/aksesibilitas), hanya tidak dirender sebagai teks visible di hero.
- Hapus pemanggilan pause/resume event listener di `sliders.js`.
- Style prev/next buttons agar konsisten dengan brand (round, transparent/ivory border).

**Acceptance Criteria:**
- [x] Hero tetap autoplay saat load (multiple slides).
- [x] Tombol prev/next muncul di hero dan dapat diklik untuk navigasi.
- [x] Tidak ada tombol "Jeda slide" di hero.
- [x] Tidak ada teks "Foto contoh" / caption yang muncul di atas gambar hero.
- [x] Caption data tetap ada di CMS (untuk alt text) tapi tidak dirender sebagai visible label.
- [x] Pagination dot tetap bekerja.
- [x] `php artisan test`, `./vendor/bin/pint`, `npm run build` lulus.

**Blocked by:** None — can start immediately

**Status:** done

**Catatan Testing:**
- Pest: `.swiper-button-prev`/`.swiper-button-next` render; tanpa `data-swiper-autoplay-toggle`; tanpa caption visible.
- Manual: prev/next berjalan; autoplay tetap active; dot paginasi berjalan.
- Diverifikasi pengguna bersama penutupan fitur inti.