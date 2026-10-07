# 08 — Perbaikan Performa dan Redesign Lanjutan Publik

**Konteks & Tujuan:**
Halaman publik sudah berjalan, tetapi hero landing masih menyisakan ruang kosong besar, katalog terasa berantakan pada desktop, loading data produk/blog lambat, font terasa kaku, dan blog belum kuat secara visual. Ticket ini melanjutkan redesign publik dengan fokus performa, layout katalog, hero landing, font modern, dan blog editorial.

**Ruang Lingkup:**
- Optimasi query publik untuk katalog, landing, detail produk, blog index/detail.
- Perbaikan bug route kategori blog, active category, filter harga nol, dan related post ordering.
- Redesign hero landing agar muat di initial viewport, headline maksimal dua baris desktop, dan tidak ada area kosong slide.
- Redesign katalog dengan container konsisten, filter mobile collapsible, grid responsif stabil, dan kartu produk rapi.
- Redesign blog index dengan lead story dan grid pendukung yang lebih editorial.
- Ganti token font publik ke font sans modern yang tersedia lewat pipeline CSS saat ini.
- Browser debugging memakai halaman lokal untuk memeriksa layout, console, network, dan timing.

**Acceptance Criteria:**
- [ ] `/`, `/katalog`, `/blog`, `/blog/kategori/{slug}`, detail produk, dan detail blog tampil tanpa error.
- [ ] Hero landing tidak menyisakan blok kosong besar setelah konten hero pada desktop.
- [ ] Katalog memakai lebar container yang sejajar dengan nav/footer dan tidak menempel ke tepi viewport.
- [ ] Filter katalog nyaman di mobile/tablet dan tetap sticky di desktop.
- [ ] Query katalog/landing tidak eager-load gallery gambar yang tidak dipakai kartu.
- [ ] Blog index tidak mengambil relasi/kolom berat yang tidak dipakai kartu.
- [ ] Category blog route tidak kalah oleh route detail post.
- [ ] Filter harga `0` tetap bekerja.
- [ ] `currentCategory` tersedia pada halaman kategori blog.
- [ ] Browser check tidak menemukan error console kritis.
- [ ] `php artisan test`, `./vendor/bin/pint`, dan `npm run build` lulus.

**Blocked by:** none

**Status:** done

**Catatan Testing:**
- Browser check desktop/mobile untuk `/`, `/katalog`, `/blog`.
- `php artisan test`
- `./vendor/bin/pint`
- `npm run build`
