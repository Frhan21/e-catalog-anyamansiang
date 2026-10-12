# 19 — Penutupan Fitur Inti

**Konteks & Tujuan:**
Menutup celah fitur inti publik tanpa memperluas schema database: share produk, metadata detail, keamanan checkout session, penyajian proses produksi, dan penyelarasan jumlah item tujuan.

**Ruang Lingkup:**
- Detail produk menyediakan share WhatsApp dan salin tautan; share WhatsApp memakai `App\Helpers\WhatsAppHelper`, bukan nomor hardcoded.
- Detail produk dan artikel menyediakan canonical URL, Open Graph, dan Twitter Card dinamis memakai metadata native Blade/HTML.
- Checkout menolak nomor WhatsApp kosong/tidak valid atau URL hasil helper yang invalid tanpa mengosongkan cart.
- Session `cart_items` menjadi sumber authoritative snapshot checkout, termasuk nama, SKU, slug, harga snapshot, dan qty; state komponen tidak boleh menggantikan sumber session.
- Cart hanya dikosongkan setelah URL WhatsApp valid berhasil dibentuk dan siap diproses.
- Halaman About menjelaskan proses produksi melalui field narasi dan galeri existing. Jangan menambah fakta bisnis yang tidak diberikan pemilik.
- Galeri About mengikuti issue 16: mosaic, caption overlay, maksimal 10 foto, tanpa lightbox.
- Landing purpose memakai tepat 3 item; selaraskan validasi `ManageLandingPage` dan tampilan publik dengan spec.
- Tidak menambah migration, tabel, kolom, seeder, dependency, atau lightbox.

**Acceptance Criteria:**
- [x] Share WhatsApp dan salin tautan bekerja pada detail produk; Facebook tetap bekerja.
- [x] Canonical, Open Graph, dan Twitter Card detail produk memakai data produk aktif dan URL canonical.
- [x] Canonical, Open Graph, dan Twitter Card detail artikel memakai data artikel published dan URL canonical.
- [x] Checkout dengan kontak kosong/tidak valid atau URL invalid menampilkan kegagalan jelas dan mempertahankan cart beserta input checkout.
- [x] Checkout membangun invoice dari snapshot session authoritative dan hanya mengosongkan cart setelah URL valid terbentuk.
- [x] Narasi proses produksi memakai konten CMS existing tanpa fakta bisnis baru.
- [x] Galeri About tetap maksimal 10, mosaic, overlay, dan tanpa lightbox sesuai issue 16.
- [x] Landing purpose divalidasi tepat 3 item dan frontend tidak mengharapkan 4 item.
- [x] Tidak ada migration atau seeder baru.
- [x] `php artisan test`, `./vendor/bin/pint`, dan `npm run build` lulus.
- [x] Smoke test browser desktop/mobile mencakup share/copy, metadata source, checkout gagal/sukses, purpose, dan galeri About.

**Status:** done

**Catatan Testing:**
- Pest mencakup metadata produk/artikel, share URL, copy-link markup, session authoritative, dan cart tetap utuh pada kegagalan kontak/URL.
- Verifikasi otomatis final: 69 test lulus dengan 315 assertion; Pint dan build Vite lulus.
- Smoke test browser desktop/mobile dikonfirmasi lulus oleh pengguna.
