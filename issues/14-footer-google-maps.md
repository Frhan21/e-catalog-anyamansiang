# 14 — Footer: Google Maps Lokasi Koperasi

**Konteks & Tujuan:**
Footer sekarang belum menampilkan lokasi fisik koperasi. Tambahkan map ke footer agar pengunjung bisa melihat lokasi Koperasi Anyaman Mansiang Taratak.

**Ruang Lingkup:**
- Tampilkan map berdasarkan `contact_info.google_maps_embed` di footer.
- Buat dynamic: URL diambil dari setting kontak (Filament bisa update kapan pun). Jika kosong → section map tidak ditampilkan.
- Jika URL bukan URL embed (`google.com/maps/embed`), jangan paksa iframe; render tombol/link "Buka di Google Maps" sebagai fallback.
- Isi setting seed `contact_info.google_maps_embed` dengan URL maps koperasi: `https://maps.app.goo.gl/cCn4xYfTiMox9Wf76` (menunjuk "Anyaman Mansiang Taratak / TOKO SABIL").
- Admin tetap bisa edit URL dari Filament `ManageContactInfo`.
- Dilarang hard-code URL di Blade.

**Acceptance Criteria:**
- [x] Map tampil di footer, dibaca dari setting `contact_info.google_maps_embed`.
- [x] Admin bisa ganti URL map dari Filament tanpa deploy.
- [x] Jika setting kosong, map tidak render.
- [x] Jika URL bukan embed URL, map fallback ke link "Buka di Google Maps" (bukan iframe).
- [x] Ukuran map proporsional & responsive; tidak bikin scroll horizontal di mobile.
- [x] `php artisan test`, `./vendor/bin/pint`, `npm run build` lulus.

**Blocked by:** None — can start immediately

**Status:** done

**Catatan Testing:**
- Pest: embed URL merender iframe; setting kosong tidak merender map; share URL merender fallback link.
- Manual: responsive desktop/mobile dan perubahan URL dari Filament diverifikasi.
- Diverifikasi pengguna bersama penutupan fitur inti.