# Public Experience Adjustment Spec

## Problem Statement

Landing page sudah punya arah visual baru, tetapi beberapa bagian belum memenuhi kebutuhan presentasi koperasi: section tujuan masih kurang kaya secara visual, statistik belum hidup, hero slider belum mudah dikontrol, footer belum menampilkan lokasi, navbar belum memakai label dan URL Inggris, dan tampilan belum adaptif untuk light/dark mode.

## Solution

Tambahkan adjustment publik yang tetap ringan dan CMS-friendly: statistik dipindahkan sebelum section tujuan dan diberi animasi counter, section tujuan memakai empat gambar dengan layout desktop berupa heading di kiri dan galeri penuh di kanan, hero tetap autoplay tetapi punya tombol next/previous dan tidak menampilkan tombol jeda maupun label foto contoh, footer menampilkan Google Maps dari setting kontak, URL publik tetap memakai slug Inggris dengan tampilan Indonesia saja, dan theme mengikuti preferensi sistem dengan override user untuk light/dark.

## User Stories

1. As a visitor, I want statistics to appear before cooperative goals, so that impact is visible before reading purpose details.
2. As a visitor, I want statistic values to count from zero, so that impact numbers feel active and intentional.
3. As a visitor with reduced-motion preference, I want counters to render without distracting animation, so that the site respects my accessibility setting.
4. As a visitor, I want the cooperative goals section to show four images, so that the mission feels more visual and credible.
5. As a desktop visitor, I want the goals heading on the left and a two-by-two image gallery on the right, so that the section feels editorial instead of generic cards.
6. As a mobile visitor, I want the goals images to stack cleanly, so that the page stays easy to read on a small screen.
7. As a content editor, I want all four goals images to remain editable from the landing page CMS, so that final cooperative photos can replace placeholders without code changes.
8. As a visitor, I want the hero slider to keep autoplay, so that the landing page still feels alive.
9. As a visitor, I want previous and next buttons on the hero slider, so that I can manually navigate hero photos.
10. As a visitor, I do not want a visible pause button or placeholder-photo label in the hero, so that the first viewport feels clean.
11. As a visitor, I want the navigation, buttons, section labels, empty states, cart UI copy, and footer labels to be available in Indonesian and English, so that I can understand the interface in either language.
12. As a visitor, I want no language toggle in navigation, so that the header stays simple.
13. As a visitor, I want URL paths to stay in English for all public pages, so that shared links are consistent and easy for search engines.
14. As a visitor, I want CMS content to remain as entered by admin, so that only fixed UI chrome changes language in this first phase.
15. As a visitor, I want my language preference remembered, so that the site keeps the selected UI language across pages.
16. As an admin, I want no extra translated CMS fields in this phase, so that content management stays simple.
17. As a visitor, I want the footer to show the cooperative map, so that I can find the physical location quickly.
18. As an admin, I want the map URL stored in contact settings, so that wrong map data can be corrected without deployment.
19. As a visitor, I want the site to follow my system color preference by default, so that the first render matches my device.
20. As a visitor, I want a light/dark theme toggle, so that I can override the system preference.
21. As a returning visitor, I want my theme choice remembered, so that theme stays consistent across pages.
22. As a visitor using keyboard navigation, I want language, theme, and slider controls to be focusable and labelled, so that controls are accessible.
23. As a visitor, I want no horizontal scroll or layout jump from the new controls, so that public pages stay stable.
24. As a developer, I want the adjustments covered by tests at public-route and markup behavior seams, so that future redesigns do not regress key behavior.

## Implementation Decisions

- Navbar and URL use English. Site content remains authored language. Language switching is withdrawn: no toggle, no locale persistence, no runtime translation files.
- `/language` route and language forms are removed. Locale stays fixed `id`, ignoring old session/cookie choices. Navbar labels use explicit English copy, not global English locale.
- Cart button shows icon only.
- Navbar layout gets breathing room; no language control anywhere in navigation.
- Theme preference defaults to system preference and can be overridden by user to light or dark.
- Theme preference uses browser persistence and an early inline boot script to avoid visible flash.
- Dark mode is implemented through existing Tailwind/CSS token layer and public Blade classes; no new frontend dependency is introduced.
- Hero slider continues using existing Swiper dependency with autoplay enabled when multiple slides exist.
- Hero slider adds previous/next controls; pause/resume button is removed from the visible UI.
- Hero image attribution or placeholder warning is removed from hero viewport. If attribution remains needed for placeholder assets, keep it outside the hero in a less prominent footer/legal area.
- Landing statistics are rendered before the cooperative goals section.
- Counter animation uses existing GSAP or small native JavaScript; no extra counter package is added.
- Counter values support common suffixes and prefixes such as `50+`, `100%`, and `10+`.
- Counter animation honors reduced-motion preference and must not break values that are not parseable numbers.
- Cooperative goals use exactly four visible items; admin validation should guide editors to provide four items.
- Desktop goals layout uses a flex/grid split: section heading on the left and a 2x2 image gallery on the right; mobile collapses to one column.
- Footer map reads from `contact_info.google_maps_embed` and renders only when present.
- Contact settings store the map URL dynamically. A Google Maps share URL may be stored initially, but implementation should prefer a proper embeddable URL before rendering an iframe.
- Initial map source from user is `https://maps.app.goo.gl/cCn4xYfTiMox9Wf76`, resolving to Anyaman Mansiang Taratak/TOKO SABIL at approximately `-0.1439297,100.4908906`.
- If the provided URL cannot be embedded safely, show a regular “Open in Google Maps” link and leave iframe rendering disabled until an embed URL is supplied.

## Testing Decisions

- Feature tests should verify public English routes resolve and old Indonesian aliases redirect or remain intentionally supported.
- Feature tests should verify `/language` returns 404, language controls are absent, navbar labels are English, and old locale preferences do not change Indonesian UI.
- Feature tests should verify CMS content is not translated by the static UI translation layer.
- Feature tests should verify theme toggle markup and early theme preference hooks exist.
- Feature tests should verify hero slider renders previous and next controls, retains autoplay-compatible markup, and does not render the old pause button.
- Feature tests should verify stats markup appears before purpose markup and includes counter data attributes.
- Feature tests should verify purpose section renders four configured items with heading-left and two-by-two desktop layout hooks.
- Feature tests should verify footer map area renders when `contact_info.google_maps_embed` is present and is absent or downgraded to a link when empty/invalid.
- Existing Pest feature tests remain the main seam. Browser/manual verification covers actual Swiper navigation, counter animation, system theme behavior, and responsive layout.
- Full verification before completion: `php artisan test`, `./vendor/bin/pint`, `npm run build`.

## Out of Scope

- Translating product, category, post, and CMS-managed content into English.
- Adding per-field translation tables or JSON translation payloads for CMS content.
- Changing checkout/payment behavior.
- Adding new JavaScript dependencies for counters, i18n, or theme.
- Building a full design-system rewrite beyond light/dark token support.
- Guaranteeing the supplied Google Maps short link is embeddable without a proper iframe URL.

## Further Notes

URL policy from final clarification: all public route paths and navbar labels use English. Language conversion is withdrawn. Other UI and CMS content stay in Indonesian/authored language.

Map policy from clarification: store URL only in settings. Use the provided Google Maps link as initial dynamic value, but prefer converting it to a proper Google Maps embed URL during implementation if available.
