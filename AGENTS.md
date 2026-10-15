# AGENTS.md — ns_gallery (All in One Gallery)

Agent router for the All in One Gallery free extension. Load only what your task needs.

> **Principles:** `context/principles.md`
> **Session log:** `context/session-state.md`
> **Doc index:** `context/docs-map.md`

---

## Always load

| File | Why |
|---|---|
| `context/principles.md` | Guardrails, "nothing that works may break" rule |
| `context/core.md` | Identity, TYPO3/PHP/ns_license constraints, tooling, known issues |

---

## Task router

| Task | Load |
|---|---|
| Album View / Google Search View plugins, albums and media records, lightbox, pagination / load more, TypoScript / site set settings | `context/features/gallery-plugins.md` |
| Premium strip / free trial / ns_license dependency | `context/features/premium-cta.md` |
| Classes, tables, TCA, templates, assets, upgrade wizard | `context/architecture.md` |
| Lint / validate / manual test | `tasks/run-quality.md` |
| Update agent context after a change | `tasks/context-update.md` |

---

## Feature status

| Feature | Status | Agent entry |
|---|---|---|
| "Album View" content element (albums → lightGallery lightbox, pagination or load more) | Done | `context/features/gallery-plugins.md` |
| "Google Search View" content element (all images of the selected albums in a GI-TheWall grid) | Done | `context/features/gallery-plugins.md` |
| Premium strip + ns_license free-trial deep link (edit form + Page module) | Done (needs ns_license 14.5.4 release) | `context/features/premium-cta.md` |

---

## Quick commands

```bash
cd packages/ns_gallery            # or typo3conf/ext/ns_gallery in Classic mode
for f in $(find . -name "*.php" -not -path "./.git/*"); do php -l "$f"; done
composer validate --no-check-publish
for f in Resources/Private/Language/*.xlf; do xmllint --noout "$f"; done
```
