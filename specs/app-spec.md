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

## Metadata Share
- Semua halaman publik selalu punya `og:title`, `og:description`, `og:type`, `og:url`, `og:image`, dan `twitter:card`.
- `og:image` dan `twitter:image` wajib URL absolut; `url()` untuk path storage, `asset()` untuk fallback publik.
- Fallback share: `public/images/branding/og-default.png` (1733x907, PNG). Dipakai saat produk atau artikel tidak punya gambar. Fallback juga menjadi `og:image` halaman tanpa section gambar.
- Dimensi dan tipe gambar hanya dinyatakan untuk fallback, karena dimensi gambar produk/artikel tidak tercatat di database.
- Nilai diambil dari section halaman; halaman tanpa section memakai nama/tagline situs dan URL saat ini.
- Tidak ada pemeriksaan URL eksternal dari server; gambar storage/CDN harus dapat diakses publik tanpa login.

## About Page
- Sejarah awal berdiri koperasi.
- Proses produksi ditulis sebagai narasi CMS dan/atau galeri existing dari `about_content`, tanpa menambah fakta bisnis yang belum diberikan pemilik.
- Dampak sosial dan ekonomi.
- Galeri kegiatan render maksimal 10 foto sebagai mosaic dengan caption overlay sesuai issue 16.
- Admin mengunggah gambar dan caption melalui `about_content.gallery`; bentuk slot ditentukan frontend secara otomatis, bukan dipilih admin.
- Mobile memakai 2 kolom dengan rasio 4:5. Mulai breakpoint `md`, indeks 0, 3, 6, 9 memakai 7 dari 12 kolom dengan rasio 16:10; sisanya 5 kolom dengan rasio 4:5.
- Gambar memakai `object-cover`: memenuhi slot tanpa distorsi, dengan kemungkinan pemotongan tepi. Item setelah foto ke-10 tetap tersimpan tetapi tidak ditampilkan.
- Tidak ada modal/lightbox dan tidak ada dependency baru untuk galeri.

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
- Tombol share WhatsApp, salin tautan, dan Facebook; semua kontak WhatsApp lewat `WhatsAppHelper` tanpa hardcode nomor.
- Canonical URL, Open Graph, dan Twitter Card dinamis sesuai produk yang sedang dilihat.
- `og:image` dan `twitter:image` wajib berupa URL absolut. Detail produk memakai foto utama produk jika ada; jika kosong memakai fallback `public/images/branding/og-default.png`.

## Cart & Buy

### Prinsip
- Keranjang disimpan di **session** (tanpa tabel DB, tanpa auth). Session adalah sumber kebenaran isi keranjang; harga item adalah snapshot saat tambah ke keranjang, kembali dibaca dari session saat checkout, bukan dari state sementara komponen.
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
- Nomor WhatsApp tujuan wajib terisi dan valid sebelum URL WhatsApp dibuat. Jika URL WhatsApp invalid atau konfigurasi kontak kosong/tidak valid, checkout ditolak dengan pesan yang jelas.
- Checkout yang ditolak tidak boleh mengosongkan session cart.
- Cart hanya boleh dikosongkan setelah URL checkout berhasil dibuat dan diproses, sebelum membuka WhatsApp; jangan mengosongkan cart sebagai respons sampingan kegagalan URL atau kontak.
- Validasi form tetap menolak field wajib kosong sebelum interaksi dengan konfigurasi kontak.

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

Setelah URL WhatsApp valid terbentuk, keranjang dikosongkan dan WhatsApp dibuka. Jika konfigurasi kontak/URL invalid, cart dan input checkout dipertahankan.

## Blog
- Daftar artikel dengan filter kategori.
- Hanya artikel `published` dan `published_at <= now()` yang tampil publik.
- Detail menampilkan judul, featured image, kategori, penulis, tanggal, reading time, dan HTML dari Rich Editor.
- Ringkasan artikel dibuat otomatis dari maksimal 30 kata pertama `content` setelah HTML dan spasi berlebih dihapus.
- Canonical URL, Open Graph, dan Twitter Card dinamis sesuai artikel yang sedang dilihat. Meta judul memakai judul artikel dan nama situs; meta deskripsi memakai ringkasan otomatis.
- `og:image` dan `twitter:image` wajib berupa URL absolut. Detail artikel memakai featured image jika ada; jika kosong memakai fallback `public/images/branding/og-default.png`.

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
