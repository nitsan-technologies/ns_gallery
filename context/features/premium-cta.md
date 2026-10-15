# Feature — Premium strip and ns_license free trial

*Status: Done. Verified live on TYPO3 14.3.7 (both edit forms, Page module, trial click-through). Requires
ns_license 14.5.4 (deep-link support) to be released.*

## Licensing status

Freemium per the NITSAN Free/Freemium sheet. Premium product: https://t3planet.de/typo3-galerie-erweiterung
(not linked from the UI; the trial stays inside the TYPO3 backend). Premium features:
`features/gallery-plugins.md`.

## Dependency

`composer.json` `"nitsan/ns-license": "^14.5.4"`, `ext_emconf.php` `'ns_license' => '14.5.4-14.9.99'`.

## Strip

Same implementation pattern as ns_revolution_slider (`Classes/Backend/PremiumStrip.php`).

- `Backend\PremiumStrip::render()` returns the HTML, or `''` if the ns_license route is missing.
  `PremiumStrip::PLUGIN_SIGNATURES` lists the CTypes that get the strip (`nsgallery_album`,
  `nsgallery_googlesearchimage`).
- Content: `actions-rocket` core icon (`IconSize::SMALL` on v13+, `'small'` on v12), headline and description
  on two lines, one `btn btn-primary` "Start Free Trial →" link (the arrow is `aria-hidden` markup, not part of
  the label; same tab).
- Wording and design are the team-wide standard from the 2026-10-14 review: "You're using the free version of
  [Extension Name]" / "Unlock premium features and get more out of [Extension Name]."
- Labels in `locallang.xlf`:
  - `premium.strip.headline`: "You're using the free version of NS Gallery"
  - `premium.strip.description`: "Unlock premium features and get more out of NS Gallery."
  - `premium.strip.trial`: "Start Free Trial"
- Styling: `.ns-gallery-premium-strip` (+ `-icon`, `-headline`, `-description`) in
  `Resources/Public/Css/backend-premium-strip.css` — light-blue card (`#e7f2fc`, border `#8eb6e8`, 4px `#2b6cb0`
  left accent, 6px radius, padding 14px 18px, text `#0d2c4a`), semibold 1.1em headline, `light-dark()` for dark
  mode, button `#007bff` (hover `#0062cc`, no wrap). Inside the FlexForm panel (`.panel > …`) it is inset by 16px.
  Same design as the ns_event / ns_helpdesk / ns_social_login strips.

## Placements

1. **Edit form, tab "plugin", top of the FlexForm panel** (above "Album per page" / "Images per page").
   Node resolver `1791976312` (**priority 42**) on `flexFormNoTabsContainer` (both FlexForms have one sheet).
   `PremiumStripFlexFormNoTabsContainerResolver` only matches `tt_content`, field `pi_flexform`, a CType from
   `PLUGIN_SIGNATURES`, not an inline child. v12 passes data to the constructor, v13+ calls `setData()`.
   The container extends core `FlexFormNoTabsContainer`, prepends the strip and adds the stylesheet via
   `stylesheetFiles`.
   - Priority must be unique per node name across all installed extensions: core's `NodeFactory` throws
     #1433155705 otherwise. Taken (code-read on this install): ns_news_comments 40, ns_event 41, ns_gallery 42,
     ns_helpdesk 43, ns_social_login 44, ns_faq 45, ns_open_streetmap 46. Each resolver returns `null` for foreign plugins, so they
     chain safely.
2. **Page module preview.** `EventListener\PremiumStripPreview` on `PageContentPreviewRenderingEvent`
   (tagged in `Services.yaml`, works on v12) prepends the strip to any existing preview content and adds the
   CSS via `PageRenderer::addCssFile()`. Record type from `getRecordType()` (v13+) or the row's `CType` (v12).

## Trial link

`UriBuilder::buildUriFromRoute('nitsan_nslicensemodule', ['trial' => 'ns_gallery'])` + `#free-section`.
ns_license's `get-license.js` (`maybeOpenTrialDeepLink()`) reads `?trial=`, removes it from the URL, activates
"My Extensions" or the Extensions catalog tab and opens its "Get New License" wizard with `ns_gallery`
preselected.

The ns_license module ("T3Planet Shop") requires **system maintainer** access. Other users (even admins) are
redirected to the Dashboard; the strip is still shown to them.
