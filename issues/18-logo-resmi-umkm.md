# 18 — Aktifkan logo resmi dengan fallback FTP dan override CMS

**Konteks & tujuan:** Logo UMKM resmi harus menggantikan ikon generik, langsung tersedia setelah deployment FTP, dan tetap dapat diperbarui lewat CMS tanpa migration atau seeder production.

**Ruang lingkup:** Asumsi PNG sumber sudah diproses dari JPEG pengguna (tanpa redraw), fallback publik, branding admin dengan backdrop ivory dan teks nama situs, logo sidebar diciutkan yang tetap dapat diklik, regenerasi favicon, helper `branding_url()` tunggal, dan pengujian perilaku.

**Blocked by:** None — can start immediately.

**Status:** done

**Blocker visual:** Selesai. Logo UMKM sudah diproses dari JPEG pengguna menjadi PNG 406x403 tanpa redraw. Placeholder seed lama di produksi tetap bisa menutupi logo baru; dikecualikan via hash `41d12832495c64e6b852daf8d7bc73670da701fe8e2583c556bb074213287eb8` agar tak ada upload lain yang terganggu.

**Catatan deployment:** Path logo lama yang masih valid di DB tetap override fallback, kecuali file berisi placeholder seed lama (hash di atas). Admin dapat mengganti upload atau mengosongkan field agar fallback dipakai.

- [x] PNG sumber di `public/images/branding/logo.png` dan `storage/app/public/settings/logo.png` tanpa redraw; tidak ada SVG atau mark/light.
- [x] Header, footer, favicon, dan branding admin memakai satu helper `branding_url()` dengan backdrop ivory `#FDFBF7`.
- [x] Sidebar admin terbuka menampilkan logo beserta nama situs; sidebar diciutkan menampilkan logo yang dapat diklik untuk membuka sidebar, dengan kontrol native yang tetap dapat dioperasikan melalui keyboard.
- [x] `public/favicon.ico` dibuat ulang dari PNG via GD multi-resolusi 16/32/48.
- [x] Upload CMS (PNG, JPEG, WebP hingga 2 MB) override fallback publik.
- [x] Placeholder seed lama dikecualikan berdasarkan hash; upload lain tetap dipakai.
- [x] Tidak membutuhkan migration atau seeder saat deployment.

**Catatan Testing:** `php artisan test`: 65 passed, 296 assertions, 3 risky dilaporkan; tidak ada test dihapus. `./vendor/bin/pint`, `npm run build`, dan `git diff --check` berhasil. Fallback kosong, file hilang, upload override, favicon tanpa MIME hardcoded, CMS satu logo, brand sidebar dengan teks, dan logo sidebar diciutkan diuji. Generator/fixture placeholder lama tidak ditemukan; cabang hash lama belum diuji dengan fixture reproduktif.

Playwright localhost: screenshot header/footer desktop light/dark, mobile, dan login admin dibuka untuk inspeksi di `/tmp/opencode/logo-*.png`. Semua logo termuat dengan ukuran native 406x403; backdrop terukur `rgb(253, 251, 247)`. Header desktop 52px, mobile 44px, footer 56px, admin 36px. `public/hot` menunjuk Vite aktif; CSS tampil. Server pengujian memakai port 8010 dengan PID di `/tmp/opencode/serve.pid`. URL storage memakai APP_URL lokal port 8000 yang juga berhasil memuat gambar. Tidak ada commit, migration, atau seeder dijalankan. Perubahan footer di luar branding dan `docs/feature-guide.md` dipertahankan.

Sidebar admin memakai icon alias `panels::sidebar.expand-button` yang Replacement logo 24px, sehingga tombol buka bawaan Filament tetap dipakai (label `sr-only`, keyboard Enter dan Space, klik) tanpa view atau CSS tambahan. Logo dibuka 36px di sidebar 320px; nama situs tampil di sebelahnya dan hilang saat sidebar 87px. Screenshot inspeksi di `/tmp/opencode/admin-expanded.png` dan `/tmp/opencode/admin-collapsed.png`.
