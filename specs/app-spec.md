# App Spec — Koperasi Anyaman Mansiang

## Tujuan
Website e-katalog modern, artisanal, dan interaktif untuk Koperasi Anyaman Mansiang. Sistem memamerkan produk kerajinan tangan, menjelaskan dampak pemberdayaan pengrajin, dan memfasilitasi pemesanan langsung melalui WhatsApp.

## Aktor
- Pengunjung: melihat produk, memfilter katalog, membaca artikel, memesan lewat WhatsApp.
- Admin: mengelola produk, kategori, artikel, konten landing/about, kontak, dan media sosial.

## Landing Page

### Hero
- Headline dan sub-headline dinamis dari `site_settings`.
- CTA menuju `/katalog`.
- Slideshow produk/kegiatan dengan Swiper.js.

### About Teaser
- Menjelaskan filosofi anyaman mansiang.
- Link menuju `/tentang-kami`.

### Tujuan & Dampak
- Menampilkan tujuan koperasi dan dampak sosial ekonomi.
- Mendukung gambar dan daftar highlight.

### Produk Unggulan
- Menampilkan produk dengan `is_featured = true` dan `is_active = true`.
- Card menampilkan gambar, nama, kategori, harga, dan status.

### Latest Stories
- Menampilkan 3 artikel terbaru dengan status `published` dan `published_at <= now()`.

### Footer
- Identitas koperasi, navigasi, kontak, jam operasional, media sosial, dan peta.

## About Page
- Sejarah awal berdiri koperasi.
- Proses produksi (budidaya, pengeringan, pewarnaan, penganyaman).
- Dampak sosial dan ekonomi.
- Galeri kegiatan dengan slider/lightbox.

## Katalog

### Filter
- Search berdasarkan nama produk, SKU, dan material.
- Multi-filter kategori.
- Rentang harga minimum dan maksimum.
- Ketersediaan: `ready_stock`, `pre_order`, `out_of_stock`.
- Filter sinkron dengan query string URL.
- Tombol reset menghapus seluruh filter dan query string terkait.

### Product Card
- Thumbnail utama.
- Badge status.
- Nama kategori.
- Nama produk.
- Harga dalam format Rupiah.
- Link detail.

### Pagination
- Livewire asynchronous pagination.
- Mempertahankan filter/query string saat pindah halaman.

## Detail Produk
- Galeri foto multi-sudut.
- Nama, kategori, SKU, harga, deskripsi.
- Dimensi, material, kegunaan/perawatan.
- Estimasi produksi jika status `pre_order`.
- Produk terkait maksimal 4 dari kategori sama.
- CTA pembelian hanya tampil jika produk aktif (`Tambah ke Keranjang` + `Beli Sekarang`).
- Tombol share WhatsApp, Facebook, dan salin tautan.

## Cart & Buy

### Prinsip
- Keranjang disimpan di **session** (tanpa tabel DB, tanpa auth).
- Tidak ada pembayaran realtime; checkout mengirim isi keranjang sebagai pesan WhatsApp.
- Semua tautan WhatsApp dibangun lewat `App\Helpers\WhatsAppHelper`.

### Tombol Beli (Buy)
- Tersedia di kartu katalog dan halaman detail untuk produk `ready_stock`/`pre_order` yang aktif.
- Tidak menyentuh keranjang; langsung membuka WhatsApp dengan pesan order qty 1 (format `WhatsApp Order`).

### Keranjang (Cart)
- Item yang bisa ditambah: produk aktif dengan status `ready_stock` atau `pre_order`. Produk `out_of_stock` tidak dapat ditambah.
- Klik `+ Keranjang`: badge jumlah item di navbar bertambah dan slide-over drawer terbuka.
- Slide-over drawer memuat: daftar item, pengubah qty, hapus item, subtotal, kosongkan (batal), form checkout, dan tombol kirim.
- struktur item session: `[{ id, name, sku, slug, price, qty }]` — harga dipakai dari nilai saat add (snapshot).
- Qty minimum 1. Maksimum: `ready_stock` 99, `pre_order` 9999. Minimum order qty adalah fitur masa depan (belum diimplementasikan).
- Item yang sama di-add lagi menambah qty, bukan duplikat baris.

### Checkout (di dalam drawer)
- Field wajib: Nama (`required|max:100`), No. Telp (`regex:/^[0-9+\-\s]{9,17}$/`), Alamat (`required|max:500`).
- Field opsional: Catatan.

## WhatsApp Order
Format pesan:

```text
Halo Admin Koperasi Anyaman Mansiang, saya tertarik memesan produk [Nama Produk] (Kode: [SKU]) dengan harga Rp [Harga]. Link: [URL Produk]. Apakah stok masih tersedia?
```

Nomor WhatsApp berasal dari `setting('contact_info.whatsapp_number')`.

### Invoice Keranjang (checkout)
Format multibaris:

```text
Halo Admin Koperasi Anyaman Mansiang, saya ingin memesan:
1. [Nama] ([SKU]) x[Qty] = Rp [Subtotal item]
2. ...
Total: Rp [Total]
Nama: [Nama]
Telp: [No. Telp]
Alamat: [Alamat]
Catatan: [Catatan atau -]
```

Setelah URL WhatsApp terbentuk, keranjang dikosongkan.

## Blog
- Daftar artikel dengan filter kategori.
- Hanya artikel `published` dan `published_at <= now()` yang tampil publik.
- Detail menampilkan judul, featured image, kategori, penulis, tanggal, reading time, dan HTML dari Rich Editor.
- OpenGraph & Twitter Card dinamis.

## Acceptance Criteria Utama
- Pengunjung dapat menemukan produk melalui search dan filter tanpa full-page reload.
- URL filter dapat dibagikan dan menghasilkan state filter sama.
- Tombol order menghasilkan URL WhatsApp yang valid dan pesan ter-encode.
- Pengunjung dapat menambah produk ke keranjang, mengubah qty, menghapus item, dan checkout via WhatsApp dengan invoice terstruktur.
- Keranjang bertahan antar halaman dalam satu session dan kosong setelah checkout.
- Konten landing/about dapat diubah lewat Filament tanpa mengubah kode.
- Draft dan artikel terjadwal tidak terlihat sebelum waktu publikasi.

## Navbar
- Desktop: tiga kolom `justify-between` — brand kiri, menu tengah, tombol `Contact` (WhatsApp) + tombol `Cart` (badge) kanan.
- Mobile: brand kiri, `Cart` + hamburger kanan; menu dan `Contact` berada di panel mobile.
- Klik tombol `Cart` membuka slide-over drawer keranjang; badge menampilkan jumlah item.
