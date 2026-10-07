# Public Experience Redesign Spec

## Problem Statement

Public pages work but feel rigid, visually generic, and do not communicate modern craft. Slider and motion dependencies exist but are not visibly used. Admin works but lacks light brand identity.

## Solution

Redesign all public pages as a modern editorial craft catalogue using existing green, ochre, ivory, and charcoal tokens. Use large real-photo placeholders through external URLs, asymmetric layouts, restrained surfaces, a working Swiper hero/gallery, and GSAP reveal motion. Keep every content slot replaceable through current CMS/data fields. Apply only restrained brand polish to Filament.

## User Stories

1. As a visitor, I want a photo-led landing page so that I immediately understand the craft and origin.
2. As a visitor, I want smooth but restrained motion so that the site feels modern without becoming distracting.
3. As a visitor, I want product cards with clear price and availability so that I can browse quickly.
4. As a visitor, I want responsive catalogue filters so that products remain easy to find on mobile.
5. As a visitor, I want a rich product gallery and WhatsApp CTA so that ordering feels direct.
6. As a reader, I want editorial blog and about pages so that the cooperative story feels credible.
7. As an admin, I want branded but utilitarian CMS screens so that content management remains fast.
8. As a content editor, I want external placeholder URLs to remain replaceable by uploaded final assets.

## Implementation Decisions

- Keep Laravel Blade, Livewire, Tailwind v4, Swiper, and GSAP already installed.
- Public typography uses Outfit for display and body text to create a modern, professional tone without losing brand warmth.
- Landing hero fits below the navigation within the initial viewport, keeps its headline to at most two desktop lines, and removes dead space caused by mismatched section and slide heights.
- Catalogue uses the shared site container, collapsible mobile filters, stable responsive grids, and card-focused product queries.
- Blog index uses a stronger editorial hierarchy: one lead story followed by a clean supporting-story grid.
- Public list queries retrieve only card fields and required relations; detail pages explicitly eager-load displayed relations.
- Product and article images reserve stable aspect-ratio space, while non-critical images load lazily.
- External photo placeholders use verified Wikimedia Commons basket weaving photos with explicit attribution, avoiding unverified random image sources.
- Existing local/uploaded paths still work; a shared image URL helper resolves absolute URLs or storage paths.
- Catalogue price inputs are debounced so a Livewire request is not fired on every keystroke.
- Product search keeps contains-style LIKE search for small catalogues, with wildcard input escaped.
- List pages avoid selecting long text fields or loading unused gallery/author relations.
- Hero uses Swiper; product detail uses Swiper thumbnails; GSAP handles reveal animation only.
- Motion honors reduced-motion preference.
- Mobile layouts collapse to one column below `md`.
- Filament changes limited to brand name, palette, group ordering, and dashboard cleanup.

## Testing Decisions

- Feature tests verify all public routes, hero slider markup, external image resolution, catalogue filters, inactive content, and post visibility.
- Browser verification checks desktop and mobile layout, console errors, network requests, and representative page-load timing before and after the redesign.
- Regression tests cover zero-price filtering, category route precedence, active category state, and deterministic related-post ordering.
- Existing admin tests remain the main admin seam.
- Full Pest, Pint, and Vite build run at completion.

## Out of Scope

- Final cooperative photography; Wikimedia Commons images remain clearly labeled examples, not cooperative documentation.
- Major design-system rebuild beyond public-facing pages.
- Checkout or payment flow.
- Bespoke Filament dashboard widgets.

## Further Notes

Placeholder images must be replaceable without view-code changes.
