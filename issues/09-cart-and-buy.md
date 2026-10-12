# 09 — Cart & Buy (Session, Checkout via WhatsApp)

**Konteks & Tujuan:**
Pengunjung perlu bisa memesan lebih dari satu produk dengan jumlah yang diinginkan. Sumber ide: `cart-and-buy.md` di vault Obsidian (`D:\2026 - VAULT NOTES\anyaman-masiang\issues\`). Pembayaran tetap tidak realtime — checkout mengirim isi keranjang sebagai invoice WhatsApp.

**Ruang Lingkup:**
- Cart disimpan di session (tanpa DB/auth): struktur `[{ id, name, sku, slug, price, qty }]`.
- Tombol `Beli` di card & detail: bypass cart, langsung WhatsApp qty 1 (format `WhatsAppHelper::orderUrl`).
- Tombol `+ Keranjang` di card & detail: tambah item (item sama menambah qty), badge navbar naik, drawer auto-terbuka.
- Slide-over drawer: daftar item, ubah qty, hapus item, subtotal, kosongkan, form checkout (Nama & No. Telp & Alamat wajib, Catatan opsional), tombol kirim.
- Qty: min 1; `ready_stock` max 99; `pre_order` max 9999; `out_of_stock` tidak bisa ditambah.
- Invoice WhatsApp multibaris per `specs/app-spec.md`; setelah checkout cart dikosongkan.
- Navbar: desktop 3 kolom justify-between (brand | menu | Contact + Cart+badge); mobile: brand | Cart + hamburger.
- Livewire `App\Livewire\Cart\Cart` + event `cart-count` untuk badge.
- `WhatsAppHelper` tambah pesan invoice multi-item.

**Acceptance Criteria:**
- [x] Add/update/remove qty bekerja, subtotal benar, cart bertahan antar halaman.
- [x] Checkout menghasilkan URL WA valid + pesan ter-encode, lalu cart kosong.
- [x] Validasi checkout: field wajib, regex telp, qty terbatas.
- [x] `out_of_stock` tak bisa masuk cart; Buy hanya untuk produk aktif.
- [x] Navbar 3 kolom sesuai spec; badge & drawer berfungsi.
- [x] `php artisan test`, `./vendor/bin/pint`, `npm run build` lulus.

**Blocked by:** 08 — Perbaikan Performa dan Redesign Lanjutan Publik

**Status:** done

**Catatan Testing:**
- Pest: happy path cart, validasi checkout, edge qty/status, kegagalan kontak, dan snapshot session.
- Manual: drawer desktop/mobile, badge reaktif, dan alur WhatsApp diverifikasi pengguna.
- Verifikasi otomatis final: 69 test lulus dengan 315 assertion; Pint dan build Vite lulus.
