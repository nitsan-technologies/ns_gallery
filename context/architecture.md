# ns_gallery — Architecture

## Content elements (`ext_localconf.php`, `Configuration/TCA/Overrides/tt_content.php`)

| CType | Title | Controller → actions (all non-cacheable except `google`) | FlexForm |
|---|---|---|---|
| `nsgallery_album` | Album View | `NsAlbumController` → `list`, `show` (missing) | `Configuration/FlexForms/galleryAlbum.xml` |
| `nsgallery_googlesearchimage` | Google Search View | `NsAlbumController` → `google` (cached) | `Configuration/FlexForms/galleryGoogleImage.xml` |

- Both use icon `ns_gallery-plugin-album` in the type select (`ns_gallery-plugin-googlesearchimage` only in the
  wizard), wizard group `ns-gallery` in `Configuration/page.tsconfig`, edit-form tab `plugin` with `pi_flexform`.
- FlexForms have one sheet `sDEF`: `settings.recordPerPage` (required, default 10), `settings.records`
  (albums, group), Album View also `settings.controls` (navigation arrows: inherit / true / false).
- No Page module preview template; the preview shows the header plus the premium strip.
- Upgrade wizard `NsGalleryCTypeMigration` moves old `list_type` records to the CTypes. It only sets `CType`
  (`list_type` stays filled); despite its description it does not migrate backend user permissions (code-read).
## Classes

| Class | Role |
|---|---|
| `Controller/NsAlbumController` | `listAction()` (albums with media), `googleAction()` (all files of the albums), `makeGalleryInitilization()` (lightGallery init JS via `AssetCollector`) |
| `Domain/Model/NsAlbum` | `title`, `media` (ObjectStorage of `NsMedia`) |
| `Domain/Model/NsMedia` | `media` (ObjectStorage of FileReference) |
| `Domain/Repository/NsAlbumRepository` | Sorted by `sorting`, storage page ignored; `setSettingsForGallery()` builds the lightGallery `controls:` option |
| `Domain/Repository/NsMediaRepository` | Sorted by `sorting`, storage page ignored |
| `Upgrades/NsGalleryCTypeMigration` | `list_type` → CType migration |
| `Utility/label` | `label_userFunc` for `nsmedia` records ("Album Media (n)") |
| `ViewHelpers/ThemeContainsViewHelper` | Not used by current templates |
| `Backend/PremiumStrip` | Premium strip HTML + trial URL, list of plugin CTypes (see `features/premium-cta.md`) |
| `Form/Container/PremiumStripFlexFormNoTabsContainer` | Core `FlexFormNoTabsContainer` + strip on top |
| `Form/Resolver/PremiumStripFlexFormNoTabsContainerResolver` | Picks the container above for both gallery FlexForms |
| `EventListener/PremiumStripPreview` | `PageContentPreviewRenderingEvent`: strip in the Page module preview |

## Tables (`ext_tables.sql`)

| Table | Content |
|---|---|
| `tx_nsgallery_domain_model_nsalbum` | `title`, `media` (inline 1:n to `nsmedia`, `foreign_sortby sorting`) |
| `tx_nsgallery_domain_model_nsmedia` | `nsalbum` (parent), `media` (FAL files), `sortby sorting` |

Both have language, workspace, `hidden`, `starttime`/`endtime` columns.

## Views

| File | Used by |
|---|---|
| `Layouts/Default.html` | Frontend wrapper |
| `Templates/NsAlbum/List.html` | Album covers → lightGallery per album, `Partials/Pagination.html` |
| `Templates/NsAlbum/Google.html` | GI-TheWall grid of all images, `Partials/Pagination.html` |
| `Partials/Pagination.html` | Numbered pagination or "Load More" (`settings.paginationType`) |
| `Partials/NoRecordFound.html` | Empty state |
| `Templates/NsGalleryBackend/*`, `Layouts/Backend.html`, `Templates/Default/ConstantEditor*.html` | Not rendered (old backend module) |

## Assets

- Frontend (TypoScript `page.*`, every page): `Vendor/lightgallery`, `Vendor/gi-thewall`, `Vendor/fontAwesome`,
  `Css/nsgallery.css`, `nsgallery-theme.css`, `customCss.css`, `Js/customJs.js` (load-more AJAX),
  optional `Vendor/initializr/jquery.min.js`.
- Backend: `Css/backend-premium-strip.css` (strip only). Other backend assets are leftovers (see `core.md`).
- `Configuration/JavaScriptModules.php` maps `@nitsan/ns-gallery/` → `Resources/Public/JavaScript/`.
- `Configuration/ContentSecurityPolicies.php`: backend scope allows Google Fonts styles/fonts.

## Labels

`locallang.xlf` (UI, constants, premium strip), `locallang_db.xlf` (TCA, wizard), `galleryAlbum.xlf` /
`galleryGoogleImage.xlf` (FlexForms), `locallang_nsgallery.xlf`, `locallang_csh_*.xlf`.
