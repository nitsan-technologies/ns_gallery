# ns_gallery — Core facts

## Identity

| Item | Value |
|---|---|
| Extension key | `ns_gallery` |
| Composer name | `nitsan/ns-gallery` |
| Title (ext_emconf) / product name | TYPO3 Gallery Extension / All in One Gallery |
| Namespace | `NITSAN\NsGallery\` → `Classes/` (ext_emconf also declares a `Classes/` classmap) |
| Version (ext_emconf) | 14.1.0 (latest tag 14.0.0) |
| Repository | https://github.com/nitsan-technologies/ns_gallery |
| Licensing status (NITSAN Free/Freemium sheet) | **Freemium** — this repo is the free version |
| Premium version (sheet) | https://t3planet.de/typo3-galerie-erweiterung (price "unknown" in the sheet) |

## Compatibility

| Source | TYPO3 | PHP |
|---|---|---|
| `ext_emconf.php` | `12.0.0-14.9.99` | not declared |
| `composer.json` | `^12 \|\| ^13 \|\| ^14` | not declared |
| ns_license 14.5.4 (dependency) | `12.4.18-14.9.99` | — |

- Effective minimum is **TYPO3 12.4.18** because of ns_license; the extension's own constraint still says 12.0.0.
- New premium-strip classes use constructor promotion, `readonly` and `catch` without variable → PHP 8.1+
  (TYPO3 12 minimum anyway).

## Dependencies

| Package | Constraint | Why |
|---|---|---|
| `typo3/cms-core` | `^12 \|\| ^13 \|\| ^14` | core |
| `nitsan/ns-license` / `ns_license` | `^14.5.4` / `14.5.4-14.9.99` | TYPO3 Shop module + free-trial deep link (see `features/premium-cta.md`) |
| jQuery | not declared | lightGallery and `customJs.js` need it; bundled copy loaded only with the `jQuery` setting (default off) |

## Tooling

- No PHPUnit, PHPStan, CS fixer or package.json in the repo.
- CI: `.github/workflows/ter-release.yml` only (publishes tags to TER).
- Translations: Crowdin, source files `Resources/Private/Language/*.xlf` (no `.crowdin.yml` in the repo).

## Conventions

- Extbase plugins registered as content elements (`ExtensionUtility::PLUGIN_TYPE_CONTENT_ELEMENT`),
  constructor injection in `NsAlbumController`, `Configuration/Services.yaml` autowires `NITSAN\NsGallery\`.
- Backend additions (premium strip) use core icons, Bootstrap utilities and their own stylesheet in
  `Resources/Public/Css/`, `light-dark()` for both backend colour schemes.

## Known issues (existing, not fixed)

Behaviour details: `features/gallery-plugins.md`. All code-read.

- TypoScript `templateRootPaths.0 = EXT:{extension.shortExtensionKey}/…` is not substituted (literal path);
  Google Search View's `layoutRootPaths.0` points to `EXT:tx_nsgallery/…`. Rendering works only through the
  `.1` paths from the constants.
- The site set's `setup.typoscript` imports `TypoScript/setup.typoscript` and then repeats its whole content.
- `PagingPosition` / `GlobalPagingPosition` reference an undefined constant `appearanceSettings.appearance.PagingPosition`.
- `page.meta.viewport` is overwritten and all frontend assets (lightGallery, GI-TheWall, Font Awesome, 3 CSS,
  `customJs.js`) load on every page, even without a gallery.
- "Album View" registers a `show` action that `NsAlbumController` doesn't have.
- Repositories ignore the storage page (`setRespectStoragePage(false)`); the `storagePid` setting only feeds
  the unused `module.tx_nsgallery` TypoScript.
- `List.html` renders two nested elements with the same id `ajax-{getContentId}`.
- Backend module leftovers: no module is registered, but `Templates/NsGalleryBackend/*`, `Layouts/Backend.html`,
  `Templates/Default/ConstantEditor*.html`, `module.tx_nsgallery*` TypoScript/constants, the backend-scope CSP
  for Google Fonts, `JavaScript/Datatables.js`, `Main.js`, `jquery.js`, `ThemeContainsViewHelper`,
  `Css/global.css`, `main.css`, `default.css` and `Vendor/bootstrap4.3.1.min.css` belong to it.
- `galleryAlbum.xml` wraps `sheetTitle` in the legacy `<TCEforms>` element.
- `ExtensionManagementUtility::addPiFlexFormValue()` in `TCA/Overrides/tt_content.php` is deprecated in TYPO3 14
  (removed in v15) and logs a deprecation there.
- `Classes/Utility/label.php` declares lowercase class `label` (TCA `label_userFunc` of `nsmedia`).
- TCA `iconfile` uses `.gif` icons; `cruser_id` columns are obsolete since v12.
- `composer.json` licence `GPL-2.0+` is a deprecated SPDX id (`composer validate` warning).
- README badge says v13.0.0 / TYPO3 13 / GPL-3.0 and links to t3planet.com instead of the sheet's premium URL.
- `ter-release.yml` uses PHP 7.4 and the deprecated `::set-output`.
