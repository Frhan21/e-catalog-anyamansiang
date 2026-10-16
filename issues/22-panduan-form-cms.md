# 22 — Panduan Form CMS

**Konteks & Tujuan:**
Admin dengan pengetahuan teknologi terbatas perlu memahami bagian website yang diatur oleh setiap form dan dampak tiap input.

**Ruang Lingkup:**
- Tambahkan penjelasan singkat pada form Landing Page, Tentang Kami, Pengaturan Situs, Kontak, dan Media Sosial.
- Tambahkan penjelasan singkat pada form Produk, Kategori Produk, Artikel, dan Kategori Artikel.
- Tambahkan petunjuk pada input yang berpotensi membingungkan.
- Gunakan komponen bawaan Filament dan bahasa Indonesia nonteknis.
- Tetapkan bagian Purpose Landing Page berisi tepat tiga item.

**Acceptance Criteria:**
- [x] Setiap form menjelaskan bagian website yang diaturnya.
- [x] Setiap bagian Landing Page menjelaskan konten yang tampil di halaman depan.
- [x] Status produk dan artikel dijelaskan dengan bahasa sederhana.
- [x] Format WhatsApp, URL, gambar, urutan, dan slug memiliki petunjuk yang relevan.
- [x] Purpose Landing Page tetap dibatasi tepat tiga item.
- [x] Tidak ada perubahan schema database, payload setting, atau tampilan publik.

**Status:** done

**Catatan Testing:**
- Uji halaman admin dan form resource menampilkan teks panduan utama.
- Lulus: `php artisan test` (75 test, 356 assertions), `./vendor/bin/pint --test`, `npm run build`, dan `git diff --check`.
