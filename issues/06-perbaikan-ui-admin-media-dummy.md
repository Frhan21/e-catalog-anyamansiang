# 06 — Perbaikan UI Admin dan Media Dummy

**Konteks & Tujuan:**
Hasil QA menemukan `section-heading` gagal saat subtitle tidak diberikan, navigasi admin belum terkelompok, form landing terlalu panjang, dan file dummy gambar berisi SVG dengan ekstensi JPEG sehingga browser tidak menampilkannya secara konsisten.

**Ruang Lingkup:**
- Tambah default prop komponen heading.
- Kelompokkan sidebar menjadi Konten Situs, Katalog Produk, dan Blog.
- Kelompokkan form landing menjadi Hero, About, Purpose, dan Stats.
- Ganti dummy image menjadi file JPEG/PNG valid tanpa reset database.
- Font tetap sampai evaluasi visual berikutnya.

**Acceptance Criteria:**
- [ ] Detail artikel dengan related post tidak error.
- [ ] Sidebar Filament tampil per kelompok.
- [ ] Form landing tampil per tab/section.
- [ ] Semua gambar dummy dapat dibuka sebagai gambar valid.
- [ ] Test, Pint, dan build lulus.

**Blocked by:** 05 — Public Frontend

**Status:** done

**Catatan Testing:**
- `php artisan test`
- `./vendor/bin/pint --test`
- `npm run build`
