# 10 — Section Tujuan: Tiga Gambar & Layout Editorial

**Konteks & Tujuan:**
Section "Tujuan Koperasi" sekarang hanya dua kartu gambar dengan rasio tidak konsisten dan kurang kuat secara visual. Referensi desain: satu gambar besar di kiri, dua gambar ditumpuk di kanan. Pemindahan statistik dan counter ditangani ticket terpisah.

**Ruang Lingkup:**
- Ubah layout desktop section `landing_purpose` menjadi dua kolom tidak simetris: satu gambar besar (span penuh tinggi) di kiri, dua gambar ditumpuk di kanan.
- Mobile dan tablet: satu kolom, tiga kartu seperti sekarang, fallback aman.
- CMS: batasi `landing_purpose.items` menjadi tepat 3 item di form Filament (helper text + default count). Judul, deskripsi, gambar tetap per item.
- Tidak menuliskan kode sebelum spec `specs/public-adjustments-spec.md` disetujui.

**Acceptance Criteria:**
- [ ] Desktop (≥lg): tiga gambar tampil, satu besar di kiri dan dua menumpuk di kanan.
- [ ] Mobile/tablet: tiga gambar tersusun satu kolom tanpa overflow horizontal.
- [ ] Semua gambar, judul, deskripsi tetap dari `setting('landing_purpose.items')`.
- [ ] Helper text CMS menjelaskan jumlah item yang diharapkan = 3.
- [ ] `php artisan test`, `./vendor/bin/pint`, `npm run build` lulus.

**Blocked by:** None — can start immediately

**Status:** todo

**Catatan Testing:**
- Pest feature: render landing, assert 3 item purpose muncul, assert class layout desktop presence.
- Manual: cek `md`/`lg`/`xl` viewport, tidak ada scroll horizontal.