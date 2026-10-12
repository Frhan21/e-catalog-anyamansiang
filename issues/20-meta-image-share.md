# 20 — Meta image share absolut

**Tujuan:** Integrasi gambar pengguna untuk preview share situs tanpa perubahan database.

**Scope:** Gambar default publik, metadata OG/Twitter seluruh halaman, URL image absolut, foto produk/artikel tetap diutamakan. Dimensi/MIME hanya dinyatakan untuk gambar default yang diketahui. Tidak memeriksa URL eksternal melalui request server.

**Acceptance Criteria:**
- [x] Gambar default tersedia tanpa login atau storage symlink.
- [x] Homepage dan halaman lain memiliki metadata share default.
- [x] Detail produk/artikel memakai URL gambar absolut; gambar kosong memakai default.
- [x] Test, Pint, build lulus.

**Status:** done

**Testing:** Pest HTTP publik menguji default dan URL foto produk. Preview platform production perlu diuji setelah deploy dengan `APP_URL` domain HTTPS production.
