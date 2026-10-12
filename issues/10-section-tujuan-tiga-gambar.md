# 10 — Section Tujuan: Tiga Gambar & Layout Editorial

**Konteks & Tujuan:**
Section "Tujuan Koperasi" sekarang hanya dua kartu gambar dengan rasio tidak konsisten dan kurang kuat secara visual. Referensi desain: satu gambar besar di kiri, dua gambar ditumpuk di kanan. Pemindahan statistik dan counter ditangani ticket terpisah.

**Ruang Lingkup:**
- Ubah layout desktop section `landing_purpose` menjadi dua kolom tidak simetris: satu gambar besar (span penuh tinggi) di kiri, dua gambar ditumpuk di kanan.
- Mobile dan tablet: satu kolom, tiga kartu seperti sekarang, fallback aman.
- CMS: batasi `landing_purpose.items` menjadi tepat 3 item di form Filament (helper text + default count). Judul, deskripsi, gambar tetap per item.
- Tidak menuliskan kode sebelum spec `specs/public-adjustments-spec.md` disetujui.

**Acceptance Criteria:**
- [x] Desktop (≥lg): tiga gambar tampil, satu besar di kiri dan dua menumpuk di kanan.
- [x] Mobile/tablet: tiga gambar tersusun satu kolom tanpa overflow horizontal.
- [x] Semua gambar, judul, deskripsi tetap dari `setting('landing_purpose.items')`.
- [x] Helper text CMS menjelaskan jumlah item yang diharapkan = 3.
- [x] `php artisan test`, `./vendor/bin/pint`, `npm run build` lulus.

**Blocked by:** None — can start immediately

**Status:** done

**Catatan Testing:**
- Pest: render landing, 3 item purpose muncul, class layout desktop.
- Manual: viewport md/lg/xl, tanpa scroll horizontal.
- Diverifikasi pengguna bersama penutupan fitur inti.