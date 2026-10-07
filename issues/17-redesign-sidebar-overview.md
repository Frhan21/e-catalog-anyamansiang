# 17 — Redesign Sidebar dan Overview Admin

**Konteks & Tujuan:**
Dashboard admin masih memakai halaman bawaan Filament tanpa widget statistik dan sidebar belum ringkas. Admin butuh ikhtisar cepat konten dan navigasi yang tidak butuh scrolling, mirip pola shadcn/ui (sidebar collapsible dengan ikon).

**Ruang Lingkup:**
- Sidebar desktop collapsible (ikon + tooltip) memakai API native Filament `sidebarCollapsibleOnDesktop()`.
- Kelompok navigasi jadi objek `NavigationGroup` dengan ikon dan default `collapsed()`.
- Ringkas navbar: Overview, Konten Situs, Katalog Produk, Blog.
- Overview page custom pengganti Dashboard bawaan dengan widget statistik produk dan artikel.
- Tautan `Kembali ke Situs` di FOOTER sidebar menuju `/` target `_blank`.

**Acceptance Criteria:**
- [x] Overview menampilkan jumlah: total produk, ready_stock, pre_order, out_of_stock, total artikel, draft, terbit.
- [x] Sidebar collapsible dengan ikon tiap menu/kelompok.
- [x] Grup navigasi default collapsed.
- [x] Sidebar footer berisi `Kembali ke Situs`, href `/`, target `_blank`.
- [x] Test, Pint, dan build lulus.

**Blocked by:** 04 — Filament Admin Resources

**Status:** done

**Catatan Testing:**
- `php artisan test`
- `./vendor/bin/pint`
- `npm run build`
