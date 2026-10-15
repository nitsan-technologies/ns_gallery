# ns_gallery — Operating Principles

*Every change to code, context or docs must serve the goals below.*

---

## Goal 1 — Nothing that works may break

The extension is declared for TYPO3 v12, v13 and v14 at the same time (Composer and Classic mode).

- Every change must keep all three majors working. Use feature checks instead of version numbers where
  the API differs (`enum_exists(IconSize::class)`, `method_exists($event, 'getRecordType')`, the
  constructor + `setData()` pair in the node resolver) and register event listeners in
  `Configuration/Services.yaml` (`#[AsEventListener]` needs v13).
- Prefer the smallest change that fixes the root cause. No drive-by refactors.
- Run `tasks/run-quality.md` and re-test the affected flow in a frontend and backend before claiming done.

## Goal 2 — Token-cost efficiency (agent context)

- **DRY context:** each fact lives in exactly ONE file. Reference, don't copy.
- **Load on demand:** read `context/features/<area>.md` for the task, not everything.
- **Prune as you go:** keep `context/session-state.md` short.

## Goal 3 — Accuracy and trust

- Answer from context + code, never from invented API, table or field names.
- Conflicting facts across files = fix the source file.

---

## Guardrails (non-negotiable)

- Keep the static template (`Configuration/TypoScript/`), the site set (`Configuration/Sets/ns_gallery/`,
  incl. `settings.definitions.yaml`) and the constants in
  `TypoScript/FeaturesConstants/commonSettings_constants.typoscript` in sync when adding or renaming a setting.
- Do not change ns_license from an ns_gallery task; reuse its module and trial modal.
- All UI text goes into `Resources/Private/Language/*.xlf` (English source only, translations via Crowdin),
  no hard-coded labels.
- FormEngine node resolver priorities must be unique per node name across all installed extensions
  (see `features/premium-cta.md`).

---

## Apply this whenever you

- Edit `context/` or `AGENTS.md`
- Land a feature or bugfix (update the matching `context/features/*.md` + `session-state.md`)
