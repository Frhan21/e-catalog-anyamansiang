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
- [ ] Hero tetap autoplay saat load (multiple slides).
- [ ] Tombol prev/next muncul di hero dan dapat diklik untuk navigasi.
- [ ] Tidak ada tombol "Jeda slide" di hero.
- [ ] Tidak ada teks "Foto contoh" / caption yang muncul di atas gambar hero.
- [ ] Caption data tetap ada di CMS (untuk alt text) tapi tidak dirender sebagai visible label.
- [ ] Pagination dot tetap bekerja.
- [ ] `php artisan test`, `./vendor/bin/pint`, `npm run build` lulus.

**Blocked by:** None — can start immediately

**Status:** todo

**Catatan Testing:**
- Pest feature: assert hero markup mengandung `.swiper-button-prev` & `.swiper-button-next`, tidak ada `data-swiper-autoplay-toggle`, tidak ada caption text di hero.
- Manual: klik prev/next → slide berubah; autoplay tetap jalan; reload → autoplay aktif.