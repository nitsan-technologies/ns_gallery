# Run quality checks

The repo has no PHPUnit, PHPStan or CS config. Available checks:

```bash
# PHP syntax, once per installed PHP version (8.1+)
for f in $(find . -name "*.php" -not -path "./.git/*"); do php -l "$f"; done

# composer.json (expected warning: deprecated licence id "GPL-2.0+")
composer validate --no-check-publish

# XLF well-formedness
for f in Resources/Private/Language/*.xlf; do xmllint --noout "$f"; done
```

Fluid templates can't be checked with `xmllint` (conditions like `{a} && {b}` are not valid XML).
After adding or renaming classes in Classic mode run `typo3 dumpautoload`, then `typo3 cache:flush`.

## Manual test (per TYPO3 major 12 / 13 / 14)

Setup: static template "Gallery" or site set `nitsan/ns-gallery`; two albums with images; a page with
"Album View" and one with "Google Search View".

1. Edit form of each gallery element → tab "plugin": one premium strip at the top of the FlexForm panel.
   Other plugins' FlexForms (e.g. ns_event, ns_news_comments) keep only their own strip or none.
2. Page module: one strip in the preview of each gallery element, none on other content elements.
3. "Start Free Trial" opens the ns_license module and its trial wizard for `ns_gallery`
   (needs a system maintainer). Check light and dark backend themes.
4. Frontend Album View: covers render, click opens the lightbox, arrows follow the `controls` setting.
   With more albums than "Album per page": pagination, or "Load More" with `Paging = loadmore`.
5. Frontend Google Search View: images of all selected albums in the grid, pagination works.
6. Without jQuery on the page and `jQuery = 0`, the lightbox does not open (expected; enable the setting).

Remove test albums, content elements and temporary backend users afterwards.
