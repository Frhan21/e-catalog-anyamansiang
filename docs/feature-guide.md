# Panduan Fitur & Roadmap — Koperasi Anyaman Mansiang

> Referensi: `specs/*.md` (sumber kebenaran), `issues/*.md` (tracker kerja).
> Digunakan sebagai panduan penggunaan aplikasi dan materi pengembangan lanjutan.

---

## Fitur tersedia di kode

- Status berikut berdasarkan pemeriksaan kode dan keberadaan test, bukan hasil menjalankan test pada sesi ini.
- Belum semua acceptance criteria dan perilaku browser diverifikasi. Label tersedia tidak otomatis berarti ticket sudah selesai.

### 1. Halaman Publik (Blade + Livewire)
- **Apa:** Landing page, About Us, Katalog, Detail Produk, Blog (index, kategori, detail).
- **Cara pakai:** buka URL publik — `/`, `/about-us`, `/catalog`, `/products/{slug}`, `/blog`, `/blog/{slug}` (`routes/web.php:11-17`).
- **Detail teknis:** `App\Livewire\Catalog\ProductCatalog`, `App\Http\Controllers\{LandingController, AboutController, ProductController, PostController}`.
- **URL lama redirect 301:** `/tentang-kami` → `/about-us`, `/katalog` → `/catalog`, `/produk/*` → `/products/*`, `/blog/kategori/*` → `/blog/category/*` (test: `tests/Feature/PublicPagesTest.php:207-247`).

### 2. Katalog Produk + Filter (Live Search)
- **Apa:** Cari produk + filter kategori, ketersediaan, rentang harga. State tersinkron ke URL.
- **Cara pakai:** ketik di kotak pencarian (debounce 300ms), centang kategori, pilih status stok, isi harga min/max. Filter share-able via URL (`?search=kursi&availability=ready_stock`).
- **Detail teknis:** `App\Livewire\Catalog\ProductCatalog` — atribut `#[Url(history: true)]` (`app/Livewire/Catalog/ProductCatalog.php:17-30`). Reset halamasi otomatis saat filter berubah (`updating()`). Tombol "Reset" memanggil `resetFilters()`.
- **Dapat dites di:** `tests/Feature/PublicPagesTest.php:55-120`.

### 3. Detail Produk
- **Apa:** Galeri Swiper multi-foto, harga, status stok, SKU, dimensi, material, deskripsi, petunjuk perawatan, estimasi produksi utk pre-order, slider produk terkait (4 produk, satu kategori), counter `views_count` bertambah tiap kunjung.
- **Cara pakai:** klik produk di katalog → `/products/{slug}`.
- **Detail teknis:** `ProductController::show` (`app/Http/Controllers/ProductController.php:10-27`) eager load `category` & `images` (anti N+1). Badge stok: Ready Stock (hijau), Pre Order (warm), Stok Habis (merah).

### 4. Blog & Kategori
- **Apa:** Daftar artikel ringkas, filter per kategori, detail memo (featured image), related posts (3, satu kategori), search (placeholder text), `views_count`, `read_minutes`, auto `published_at`.
- **Cara pakai (jawaban umum):** link `/blog`; klik kategori → `/blog/category/{slug}`; klik judul → `/blog/{slug}`.
- **Detail teknis:** `PostController` (`app/Http/Controllers/PostController.php:11-57`). Scope `Post::published()` → hanya status `published` DAN `published_at <= now` (`app/Models/Post.php:44-49`) — jadi jadwal masa depan tersembunyi otomatis.
- **Dapat dites di:** `tests/Feature/PublicPagesTest.php:122-205`.

### 5. Admin CMS (Filament) & Setting
- **Apa:** Login (email / username), Overview statistik, CRUD Produk + Foto + Kategori Produk, CRUD Artikel + Kategori Artikel, halaman Setting (Landing, About, Site Settings, Contact Info, Social Media).
- **Cara pakai:** akses `/admin` → login. Sidebar grouping: "Konten Situs", "Katalog Produk", "Blog".
- **Workflow produk:** buat "Kategori Produk" dulu → buka "Produk" → isi Nama (slug otomatis saat blur), Harga, SKU opsional, Status, Gambar Utama, Galeri, Aktif/Unggulan. Pre-order wajib isi "Estimasi Produksi (hari)" minimal 1.
- **Workflow artikel:** buat "Kategori Artikel" dulu → buka "Artikel" → isi Judul (slug otomatis), kategori, penulis opsional, status. Status `published` wajib isi "Tanggal Publikasi"; draft dan jadwal masa depan tidak tampil publik.
- **Workflow konten:** buka "Landing Page", "Tentang Kami", "Pengaturan Situs", "Kontak", atau "Media Sosial" → ubah field → klik **Simpan**. Spec penutupan menetapkan Landing "Purpose" tepat 3 item; kode admin masih memvalidasi 4 sampai issue 19 dikerjakan. Kontak WhatsApp wajib format `628xxxxxxxxxx`; URL maps wajib HTTPS Google Maps.
- **Upload:** foto produk → disk `public/products`; artikel → `public/posts`; setting → `public/settings`.
- **Detail teknis:** panel `admin` (`app/Providers/Filament/AdminPanelProvider.php:24-47`), resources `app/Filament/Resources/`, pages `app/Filament/Pages/`. Login fleksibel: `AdminPagesTest` (`tests/Feature/AdminPagesTest.php:35-229`).

### 6. Site Setting + Helper `setting()`
- **Apa:** Semua teks/logo CMS terpusat di tabel `site_settings`, diakses helper `setting('key.sub_field')` dengan cache otomatis (invalidate saat disave/delete).
- **Cara pakai:** di Blade: `setting('site_general.site_name')`; di PHP class: `setting('contact_info.whatsapp_number')` (contoh `app/Livewire/Cart/Cart.php:142`).
- **Aturan:** dilarang query `SiteSetting` langsung dari Blade/Controller.
- **Dapat dites di:** `tests/Unit/HelpersTest.php:8-94`.

### 7. WhatsApp Integration
- **Apa:** Semua link WA lewat `WhatsAppHelper` — contact `wa.me/{no}`, order single produk, invoice keranjang multi-baris (item × qty, total, nama, telp, alamat, catatan).
- **Cara pakai:** konfigurasi nomor di Admin → Contact Info (`contact_info.whatsapp_number`), otomatis dipakai tombol "Beli Sekarang", tombol WA floating, dan checkout keranjang.
- **Detail teknis:** `app/Helpers/WhatsAppHelper.php:9-76`. Nomor dinormalkan (digit saja); `#` fallback bila kosong.

### 8. Frontend Motion (Swiper + GSAP)
- **Apa:** Hero slider autoplay + navigasi, galeri "Tujuan" responsif, animasi reveal & counter angka statistik saat scroll, hormat `prefers-reduced-motion`.
- **Cara pakai:** otomatis; ini modul Vite terpisah.
- **Detail teknis:** `resources/js/sliders.js:10-37`, `resources/js/animations.js:16-78`. Wajib re-init pada navigasi Livewire.

### 9. Footer: Sosial Media + Google Maps
- **Apa:** Link sosial dari setting, embed maps aman (iframe) + link buka di Google Maps (fallback).
- **Detail teknis:** `resources/views/components/footer.blade.php:1-96`; test `tests/Feature/UiFixesTest.php:171-234`.

### 10. Galeri About Us
- **Apa:** Galeri di halaman About (data `setting('about_content.gallery')` → array `{image, caption}`).
- **Cara pakai (admin):** isi di halaman "Tentang Kami" — repeater tanpa batas item.
- **Batasan publik:** halaman publik menampilkan maks **10 foto** (`array_slice`). Layout: mobile 2 kolom; desktop asimetris (12 kolom, indeks 0/3/6/9 = `md:col-span-7`, sisanya `md:col-span-5`). Caption desktop hanya muncul saat hover.
- **Detail teknis:** tidak ada lightbox.

### 11. Toggle Tema Dark/Light
- **Apa:** Tombol toggle di nav (desktop + mobile), simpan preferensi di `localStorage('theme')` (`dark`/`light`), fallback `prefers-color-scheme`.
- **Cara pakai:** klik tombol → class `dark` di-toggle di `<html>`, langsung berubah, bertahan antar halaman & navigasi Livewire.
- **Detail teknis:** `data-theme-toggle` di `resources/views/components/nav.blade.php:22-37`; skrip pre-paint di `resources/views/components/layouts/app.blade.php`. Catatan: `aria-label` tombol hardcoded `"Toggle theme"` (English), belum diterjemahkan.

### 12. Site Setting & Helper `setting()`
- **Apa:** Semua teks/logo/asset CMS terpusat di tabel `site_settings`, diakses helper `setting('group.key')`.
- **Lokasi helper:** `app/Helpers/SettingHelper.php` (bukan di support). Cache per-key via `cache()->rememberForever('site_settings_{key}')`; otomatis invalidasi saat `SiteSetting` disave/delete.
- **Helper lokal di file itu:** `media_url()`, `media_alt()`, `google_maps_url()` (validasi embed aman).
- **Aturan:** dilarang query `SiteSetting` langsung dari Blade/Controller — selalu lewat `setting()`.
- **Dapat detes di:** `tests/Unit/HelpersTest.php:8-94`.

### 13. Bilingual UI (English + Indonesia)
- **Dibatalkan untuk fase publik.** Aplikasi berjalan dalam satu locale tetap `id`, tanpa switcher runtime, tanpa rute `/language`.
- Navlink publik tetap memakai label English tetap (hardcoded), bukan hasil translasi runtime.
- File `lang/id.json` dan `lang/en.json` masih ada sebagai aset; pengaktifan bilingual memerlukan spec, UI switch, dan middleware tersendiri.
- Tidak ada label bilingual aktif yang perlu diverifikasi untuk fase penutupan fitur inti.

---

## STATUS: SELESAI DAN TERVERIFIKASI

### 10. Cart & Buy (Session → WhatsApp Checkout)
- **Apa:** Keranjang multi-produk di session (tanpa DB/auth). Struktur item `{ id, name, sku, slug, price, qty }`.
- **Berjalan:**
  - Tambah via event `add-to-cart`, item sama menaikkan qty.
  - Qty min 1; ready_stock max 99; pre_order max 9999; out_of_stock ditolak.
  - Badge navbar, auto-open drawer, update qty, hapus, kosongkan, subtotal.
  - Checkout memvalidasi pembeli dan memakai snapshot session sebagai sumber invoice WhatsApp.
  - Kontak/URL WhatsApp invalid mempertahankan cart dan input checkout.
- **Cara pakai:** klik "+ Keranjang" → drawer terbuka → ubah qty → isi Nama, No. Telp, Alamat → kirim → WhatsApp admin terbuka.
- **Test:** `tests/Feature/CartTest.php`.

### 11. Penutupan fitur inti
- Share WhatsApp, Facebook, dan salin tautan tersedia di detail produk.
- Detail produk dan artikel memakai canonical, Open Graph, dan Twitter Card dinamis.
- Galeri About memakai mosaic otomatis maksimal 10 gambar; shape ditentukan posisi dan gambar memakai `object-cover`.
- Purpose memakai tepat 3 item pada CMS dan frontend.
- Issue 09–14 dan 19 berstatus `done` setelah test otomatis dan smoke test browser desktop/mobile.
- Verifikasi final: 69 test, 315 assertion, Pint, dan build Vite lulus.

---

## Daftar Posisi File Utama (cheatsheet)

| Area            | Path                                     | Catatan                                  |
|-----------------|------------------------------------------|------------------------------------------|
| Routes          | `routes/web.php`                         | 7 rute publik + 4 redirect 301            |
| Katalog Filter  | `app/Livewire/Catalog/ProductCatalog.php`| `#[Url(history: true)]`, `resetFilters()` |
| Cart            | `app/Livewire/Cart/Cart.php`             | session `cart_items`, event Livewire      |
| Detail Produk   | `app/Http/Controllers/ProductController.php` | `+views_count`, related 4             |
| Blog            | `app/Http/Controllers/PostController.php`| `Post::published()`, paginate(9)          |
| WA Helper       | `app/Helpers/WhatsAppHelper.php`         | `contactUrl`, `orderUrl`, `shareUrl`, `cartMessageUrl`|
| Setting Helper  | `app/Helpers/SettingHelper.php`           | `setting('key.sub_field')` + cache        |
| Filament Admin  | `app/Filament/Resources/`, `app/Filament/Pages/` | panel `/admin`                   |
| Models          | `app/Models/` (7 model)                  | `$fillable` eksplisit, enum cast          |
| Slider/Motion   | `resources/js/sliders.js`, `resources/js/animations.js` | init + Livewire hook        |
| Spec (SOT)      | `specs/*.md`                             | perubahan wajib update spec dulu          |
| Tracker         | `issues/{nn}-*.md`                       | status per file                           |
| Test Suite      | `tests/Feature/`, `tests/Unit/`          | Pest; happy path + batasan                |
