# ns_gallery — Session state

## 2026-10-14 — ns_license integration, premium strip, agent context

- Branch `master` (HEAD d669a83). All changes uncommitted.
- Added `nitsan/ns-license ^14.5.4` / `ns_license 14.5.4-14.9.99`.
- Premium strip with "Start Free Trial" → ns_license module `?trial=ns_gallery#free-section` in the edit form
  and the Page module preview of both plugins (see `features/premium-cta.md`). Resolver priority 42.
- Verified live on TYPO3 14.3.7 classic (temporary admin made system maintainer, two hidden test elements;
  all removed afterwards, `settings.php` restored). Not tested on v12/v13. Frontend not tested.
- Created agent context (`AGENTS.md`, `CLAUDE.md`, `context/`, `tasks/`); no previous context existed.

## 2026-10-14 — Banner redesign from review

- Team-wide wording ("You're using the free version of NS Gallery" / "Unlock premium features and get more
  out of NS Gallery."), two-line layout, arrow on the button, more padding, rounded card, inset inside the
  FlexForm panel (see `features/premium-cta.md`). Version 14.0.0 → 14.1.0 (`ext_emconf.php`).
- Page module verified live on 14.3.7; test data removed. Uncommitted.

## 2026-10-15 — Context audit

- Code-read audit: fixed the resolver priority list (`features/premium-cta.md`), noted that the upgrade wizard
  only sets `CType` (`architecture.md`), the v14 `addPiFlexFormValue()` deprecation (`core.md`) and the shared
  `plugin.tx_nsgallery_album.*` setting names (`features/gallery-plugins.md`).
