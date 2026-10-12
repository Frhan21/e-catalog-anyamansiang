# Deployment — Koperasi Anyaman Mansiang

Prosedur ini untuk rilis baru Laravel 12 pada environment production yang sudah ada. Jalankan dengan cara staged/atomic bila memungkinkan. Dokumen ini tidak menjamin deployed; hasil verifikasi bertanggung jawab pada pelaksana deployment.

## Prasyarat

- Environment Laravel 12 / PHP 8.3 sudah aktif.
- Akses server atau platform hosting yang bisa menjalankan `composer`, PHP CLI, dan operasi release.
- Git sudah diverifikasi; commit perubahan termasuk dokumentasi telah masuk repository.
- Tidak ada migrasi baru, schema update, atau seeder yang diperlukan untuk perubahan ini.

## Sebelum Rilis

1. Catat versi/commit hash saat ini sebagai rujukan rollback.
2. Backup database terbaru dan verifikasi file backup dapat dibaca.
3. Backup seluruh `storage/app/public` yang digunakan disk `public`.
4. Simpan nilai dan konfigurasi `.env` yang relevan, terutama `APP_KEY`, `APP_ENV`, `APP_DEBUG`, `APP_URL`, database, session, mail, dan storage. Jangan menyebarkan file ini di repository/channel publik.
5. Pastikan daftar perubahan production sudah dicatat dalam release notes/commit message.

## Rilis Bertahap

```bash
git fetch origin
git switch --detach <target-commit>
composer install --no-dev --optimize-autoloader --no-interaction
php artisan config:clear
php artisan route:clear
php artisan view:clear
npm ci
npm run build
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan up
```

Gunakan symlink `current` ke direktori release baru sebelum mematikan maintenance mode. Setiap release menyimpan file lama sampai switch selesai.

- Pertahankan `APP_KEY` lama; jangan generate ulang.
- Jangan menjalankan `migrate`, `migrate:fresh`, `db:seed`, `migrate:refresh`, atau perintah destructive apa pun.
- Perbarui symlink `storage` ke storage yang sama/tersambung bila release baru belum menyediakannya.

## Permissions dan Docroot

- Web server menggunakan `public/` sebagai document root.
- symlink storage mengikuti konfigurasi deployment dan menunjuk ke lokal `storage/app/public`.
- Gunakan permission direktori yang paling kecil yang dapat bekerja, umumnya `755` untuk direktori dan `644` untuk file, milik user web server/proses deployment.
- Set `0777` hanya bila memang wajib dan hanya untuk path yang dibutuhkan. Jangan membuat seluruh storage atau release menjadi `0777`.

## Verifikasi

Setelah `php artisan up` dan switch selesai:

1. Halaman publik: landing, about, katalog, detail produk, blog detail.
2. Admin: `/admin` dapat dimuat; jangan menyertakan atau menyebarkan kredensial.
3. Smoke test cart: add, ubah qty, hapus, checkout valid, dan kasus kontak gagal.
4. Smoke test mobile drawer/nav dan halaman publik pada viewport kecil.
5. Verifikasi path asset Vite dan symlink storage publik.
6. Verifikasi `APP_URL` berisi domain HTTPS production agar canonical dan meta image menjadi URL absolut production.
7. Buka `public/images/branding/og-default.png` langsung tanpa login, lalu uji satu URL lewat Facebook Sharing Debugger/LinkedIn Post Inspector.
8. Verifikasi environment production tetap `APP_DEBUG=false`.
9. Catat hasil smoke test dalam catatan release; jangan menyatakan sukses bila langkah tidak dijalankan.

## Rollback

Jika verifikasi gagal atau terjadi regresi penting:

1. `php artisan down`.
2. Arahkan symlink `current` kembali ke release/commit sebelumnya.
3. Ulangi cache config/routes/views yang relevan sesuai release target.
4. `php artisan up`.
5. Uji rute publik, admin, cart, dan asset yang gagal.
6. Kembalikan database/storage dari backup hanya jika perubahan deployment benar-benar menyentuhnya. Untuk rilis tanpa migration/seeder ini tidak boleh diperlukan.

Rollback mengembalikan kode dan state cache/route ke rilis sebelumnya; ia tidak menghapus riwayat Git atau rilis baru yang gagal.

## Keamanan Kredensial

Penghapusan kredensial plaintext dari working tree tidak menghapusnya dari history Git. Pemilik sistem tetap wajib merotasi credential yang pernah tercatat, memeriksa log/session/backup yang mungkin berisi nilai lama, dan menangani history melalui proses terpisah yang disetujui.
