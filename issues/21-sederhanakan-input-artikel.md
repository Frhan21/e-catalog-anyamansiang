# 21 — Sederhanakan Input Artikel

**Konteks & Tujuan:**
Admin dengan pengetahuan teknologi terbatas perlu membuat artikel tanpa mengisi ringkasan dan metadata SEO secara manual.

**Ruang Lingkup:**
- Hapus input `excerpt`, `meta_title`, dan `meta_description` dari form artikel.
- Buat ringkasan otomatis dari teks `content`, tanpa HTML, maksimal 30 kata.
- Gunakan `title` dan nama situs sebagai judul metadata.
- Gunakan ringkasan otomatis sebagai deskripsi metadata.
- Pertahankan kolom database lama agar data lama tidak hilang, tetapi abaikan nilainya pada tampilan publik.

**Acceptance Criteria:**
- [x] Form artikel tidak menampilkan input ringkasan, meta judul, dan meta deskripsi.
- [x] Ringkasan publik berasal dari isi artikel dan maksimal 30 kata.
- [x] Metadata artikel berasal dari judul dan ringkasan otomatis.
- [x] Nilai lama pada tiga kolom tidak memengaruhi tampilan publik.

**Status:** done

**Catatan Testing:**
- Uji penghapusan HTML, normalisasi spasi, batas 30 kata, dan metadata artikel.
- Lulus: `php artisan test` (74 test, 338 assertions), `./vendor/bin/pint`, `npm run build`, dan `git diff --check`.
