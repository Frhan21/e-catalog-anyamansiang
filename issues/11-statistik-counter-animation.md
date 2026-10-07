# 11 — Statistik: Pindah ke Atas Tujuan + Counter Animation

**Konteks & Tujuan:**
Statistik sekarang berada di bawah section tujuan dan hanya statis. Pindahkan blok statistik ke atas section tujuan, dan tambahkan animasi counter dari 0 ke nilai akhir saat terlihat viewport.

**Ruang Lingkup:**
- Pindahkan markup `landing_stats` dari bawah `landing_purpose` ke atasnya, tetap dalam section `bg-mansiang-surface`.
- Tambahkan counter animation: parse angka dari `value` (contoh `50+`, `100%`, `10+`), animasi 0 → target saat elemen masuk viewport.
- Honor `prefers-reduced-motion`: jika aktif, tampilkan nilai akhir tanpa animasi.
- Nilai non-numeric tetap dirender apa adanya tanpa error.
- Tidak menambah dependency baru; gunakan GSAP/ScrollTrigger yang sudah ada atau native IntersectionObserver.

**Acceptance Criteria:**
- [ ] Statistik tampil sebelum section tujuan di landing page.
- [ ] Setiap statistik menampilkan counter animation dari 0 ke nilai akhir saat scroll masuk viewport.
- [ ] Counter berhenti di nilai akhir yang benar (termasuk suffix `+`, `%`).
- [ ] `prefers-reduced-motion: reduce` menampilkan nilai akhir langsung tanpa animasi.
- [ ] Nilai non-numeric (misal `N/A`) tetap tampil benar tanpa JS error.
- [ ] `php artisan test`, `./vendor/bin/pint`, `npm run build` lulus.

**Blocked by:** None — can start immediately

**Status:** todo

**Catatan Testing:**
- Pest feature: assert stats markup muncul sebelum purpose markup di HTML landing.
- Manual: scroll ke section, counter berjalan; toggle reduced-motion, nilai langsung tampil.