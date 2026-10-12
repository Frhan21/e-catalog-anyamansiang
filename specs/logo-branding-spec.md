# Logo Branding Spec — Anyaman Mansiang Taratak

## Problem Statement

Logo website masih memakai ikon SVG generik dan belum memakai logo UMKM resmi. Logo resmi sudah diproses dari JPEG pengguna menjadi PNG sumber di `public/images/branding/logo.png` dan `storage/app/public/settings/logo.png`; aset ini tidak boleh di-redraw. Logo harus aktif di header, footer, favicon, dan branding admin. Deployment memakai FTP/cPanel tanpa akses terminal, sehingga solusi tidak boleh bergantung pada seeder, migration, atau perintah manual setelah deploy. Admin tetap perlu bisa mengganti satu logo lewat CMS.

## Solution

Logo UMKM memakai PNG hasil proses dari JPEG pengguna tanpa redraw. Aset bawaan ikut deployment lewat direktori publik agar langsung tampil setelah FTP deploy. Upload dari CMS tetap menjadi override bila admin mengganti logo lewat halaman pengaturan, kecuali file placeholder seed lama dengan SHA-256 `41d12832495c64e6b852daf8d7bc73670da701fe8e2583c556bb074213287eb8`.

## User Stories

1. Sebagai pengunjung, saya ingin melihat logo UMKM resmi di header, sehingga identitas website jelas.
2. Sebagai pengunjung, saya ingin melihat logo resmi di footer, sehingga branding konsisten sampai akhir halaman.
3. Sebagai pengunjung mobile, saya ingin logo tetap terbaca dalam ruang sempit, sehingga navigasi tidak penuh.
4. Sebagai pengunjung, saya ingin browser menampilkan favicon resmi, sehingga tab website mudah dikenali.
5. Sebagai admin, saya ingin logo bawaan sudah tampil setelah deploy FTP, sehingga saya tidak perlu upload ulang.
6. Sebagai admin, saya ingin bisa mengganti satu logo dari CMS, sehingga pembaruan logo tidak perlu mengubah kode.
7. Sebagai admin, saya ingin branding di panel admin memakai logo yang sama dengan situs publik, sehingga identitas konsisten.
8. Sebagai developer, saya ingin fallback logo ada di `public`, sehingga workflow FTP/cPanel tidak membutuhkan terminal.
9. Sebagai developer, saya ingin path upload tetap memakai disk `public`, sehingga pola media CMS tetap sama.
10. Sebagai developer, saya ingin semua komponen logo memakai helper setting, sehingga tidak ada query langsung ke database dari Blade.

## Implementation Decisions

- Logo resmi adalah PNG sumber yang sama di `public/images/branding/logo.png` dan `storage/app/public/settings/logo.png`; tidak ada SVG maupun redraw.
- `public/favicon.ico` dibuat ulang dari PNG menggunakan GD, berisi multi-resolusi 16x16, 32x32, dan 48x48.
- Aset bawaan disimpan di direktori publik agar ikut deploy FTP dan bisa tampil tanpa symlink storage.
- Upload CMS tetap memakai disk `public` dan direktori `settings`; upload baru menjadi override terhadap aset bawaan.
- Payload `site_general` hanya menyimpan satu `logo_path`; field legacy `logo_light_path`, `logo_mark_path`, dan `favicon_path` tidak lagi dibaca.
- Tidak ada migration baru karena settings berbentuk JSON payload.
- Tidak ada seeder wajib untuk deployment karena fallback publik dipakai langsung bila DB belum memiliki path baru.
- Header dan footer memakai logo yang sama dengan backdrop ivory `#FDFBF7` agar transparan rapi.
- Layout menambahkan favicon dari `branding_url()` tanpa atribut `type` yang hardcoded.
- Komponen publik dan admin memakai helper `branding_url()` untuk path storage dan path publik.

## Testing Decisions

- Test memeriksa perilaku publik, bukan detail piksel logo.
- Test memastikan halaman publik memuat fallback logo bawaan bila setting kosong atau file hilang.
- Test memastikan upload settings/logo.png dengan hash berbeda dari placeholder seed lama tetap override fallback.
- Test memastikan favicon aktif di layout tanpa `type="image/png"` hardcoded.
- Test memastikan field legacy logo light/mark/favicon tidak muncul di payload.
- Prior art memakai Pest feature test untuk render halaman publik.

## Out of Scope

- Redesign logo.
- Menambah field logo light, mark, atau favicon terpisah.
- Mengubah struktur database settings.
- Menjalankan seeder di production.
- Otomatis membuat symlink storage di cPanel.
- Menghapus atau merotasi kredensial lama dalam dokumen admin.

## Further Notes

Server production memakai FTP/cPanel. `public_html/storage` tetap perlu symlink permanen agar upload CMS dari disk `public` dapat diakses. Logo bawaan tetap tampil meski symlink belum tersedia karena berada langsung di public asset. Placeholder seed lama dengan hash `41d12832495c64e6b852daf8d7bc73670da701fe8e2583c556bb074213287eb8` dikecualikan sehingga produksi yang sebelumnya diisi path lama tetap memakai fallback publik.
