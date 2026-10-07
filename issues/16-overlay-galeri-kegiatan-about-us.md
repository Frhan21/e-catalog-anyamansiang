# 16 — Overlay Galeri Kegiatan About Us

**Konteks & Tujuan:**
Galeri kegiatan di halaman About Us masih menaruh caption di bawah gambar. Desain perlu dibuat seperti section Tujuan Koperasi: gambar dan caption menyatu lewat overlay, dengan layout mosaic yang lebih menarik.

**Ruang Lingkup:**
- Halaman `/about-us`, section `Galeri Kegiatan`.
- Maksimal render 10 foto dari `about_content.gallery`.
- Caption muncul sebagai overlay di atas gambar, bukan blok bawah.
- Desktop/tablet memakai variasi ukuran card dalam layout mosaic.
- Mobile tetap responsif dan rapi.
- Reuse animasi scroll reveal yang sudah ada via `data-animate`.
- Hover menampilkan caption dan scale gambar.
- Tidak menambah modal/lightbox dan tidak menambah dependency.

**Acceptance Criteria:**
- [x] Gallery render maksimal 10 item.
- [x] Caption berada di overlay gambar.
- [x] Card punya variasi ukuran pada desktop/tablet.
- [x] Gambar scale saat hover.
- [x] Item tetap memakai `data-animate` untuk reveal fade-up saat scroll.
- [x] Layout mobile tetap rapi tanpa interaksi modal.
- [x] `php artisan test`, `./vendor/bin/pint`, `npm run build` lulus.

**Status:** done

**Catatan Testing:**
- Tambahkan feature test untuk memastikan item ke-11 tidak dirender dan markup overlay/mosaic/reveal ada.
