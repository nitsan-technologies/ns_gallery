# Feature — Album View and Google Search View

*Status: Done (free version). Behaviour below is code-read; known defects live in `core.md`.*

## Setup

1. Include the static template "Gallery" or the site set `nitsan/ns-gallery` ("Gallery Sets").
2. Create albums (`tx_nsgallery_domain_model_nsalbum`), each with one or more media records holding files.
   Records can live on any page (storage page is ignored).
3. Add "Album View" or "Google Search View", pick the albums and set the items per page.

## Settings

Classic constants and site set settings use the same names below `plugin.tx_nsgallery_album.`; Google Search
View reads its `paginationType` from there too.

| Setting (constant / site set) | Default | Effect |
|---|---|---|
| `appearanceSettings.appearance.jQuery` | off | Load the bundled jQuery |
| `appearanceSettings.appearance.Paging` | `pagination` | `pagination` or `loadmore` → `settings.paginationType` |
| `appearanceSettings.generalGallery.controls` | 1 | lightGallery navigation arrows (FlexForm `settings.controls` overrides) |
| `storageSettings.storagePid` | empty / 0 | Only used by the old backend module TypoScript |

## Album View (`listAction()`)

- Loads the selected albums in FlexForm order, drops albums without media.
- `ArrayPaginator` + `SimplePagination` with `settings.recordPerPage`; page from `tx_nsgallery_album[currentPage]`.
- Inline JS per content element initialises lightGallery on `.nsGallery-<uid>` after `window.load`
  (needs jQuery on the page), downloads disabled.

## Google Search View (`googleAction()`)

- Collects every file of every media record of the selected albums into one list.
- Same pagination; page from `tx_nsgallery_googlesearchimage[currentPage]`. Rendered with GI-TheWall.

## Load more

`Js/customJs.js` handles `.article-load-more` clicks: fetches the next page via AJAX, appends the items and
updates or hides the button.

## Premium-only (not in this repo)

Per the product page: masonry, mosaic, isotope, slider/carousel and zoom gallery styles, album gallery on a
separate page, video galleries (local, YouTube, Vimeo), extended lightbox controls (fullscreen, thumbnails,
zoom, slideshow, download, social sharing), dark theme, lazy load, image spacing.
