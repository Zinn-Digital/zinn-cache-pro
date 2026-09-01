# Third-Party Notices — Zinn® Cache Engine

Zinn® Cache Engine is a fork of **LiteSpeed Cache 7.8.1** (Copyright © 2015–2026 LiteSpeed
Technologies, Inc.). The plugin as a whole is distributed under the **GNU General Public
License, version 3 or later (GPL-3.0-or-later)** — see the plugin's `LICENSE` file.
Zinn® Cache Engine is published by **Neil Lock — CEO, Zinn Digital® Ltd**, https://zinndigital.com.

The plugin bundles the third-party components listed below. Each is used under **its own
licence**, which is compatible with GPL-3.0-or-later. Nothing in this file changes the
licence of the plugin as a whole; the components below remain under the terms stated for
each. Full licence texts are reproduced in the `licenses/` directory alongside this file.

Files that are LiteSpeed Technologies' own work (including everything in `src/`, `cli/`,
`tpl/`, `data/`, `lang/`, `thirdparty/`, `autoload.php`, `litespeed-cache.php`,
`guest.vary.php`, and the LiteSpeed-authored assets listed in §6) are **not** listed here —
they are covered by the plugin's main copyright and GPL-3.0-or-later licence.

Audit performed against the upstream tree on **2026-07-24**. Every licence claim below was
verified by reading the actual file header or in-tree `LICENSE` file; where the bundled file
carries no notice, the upstream project's own licence file was consulted and that is stated
explicitly.

---

## 1. MIT

### 1.1 matthiasmullie/minify (modified)

| | |
|---|---|
| **Version** | undetermined — the files carry no version marker; they are described in-tree as a "modified PHP implementation" |
| **Licence** | `MIT` |
| **Copyright** | `Copyright (c) 2012 Matthias Mullie` (from `lib/css_js_min/minify/LICENSE`); file headers read `@copyright Copyright (c) 2012, Matthias Mullie. All rights reserved` |
| **Paths** | `lib/css_js_min/minify/LICENSE`<br>`lib/css_js_min/minify/minify.cls.php`<br>`lib/css_js_min/minify/css.cls.php`<br>`lib/css_js_min/minify/js.cls.php`<br>`lib/css_js_min/minify/exception.cls.php`<br>`lib/css_js_min/minify/data/js/keywords_after.txt`<br>`lib/css_js_min/minify/data/js/keywords_before.txt`<br>`lib/css_js_min/minify/data/js/keywords_reserved.txt`<br>`lib/css_js_min/minify/data/js/operators.txt`<br>`lib/css_js_min/minify/data/js/operators_after.txt`<br>`lib/css_js_min/minify/data/js/operators_before.txt` |
| **Upstream** | https://github.com/matthiasmullie/minify |
| **Licence text** | `licenses/MIT-matthiasmullie-minify.txt` (byte-for-byte copy of the in-tree `LICENSE`, which is authoritative) |

Note: `exception.cls.php` carries only `@author Matthias Mullie <minify@mullie.eu>` (no
`@copyright`/`@license` line), but it sits inside the directory governed by the in-tree
`LICENSE` and is part of the same package.

### 1.2 matthiasmullie/path-converter (modified)

| | |
|---|---|
| **Version** | undetermined — no version marker in the file |
| **Licence** | `MIT` |
| **Copyright** | `Copyright (c) 2015 Matthias Mullie` (from `lib/css_js_min/pathconverter/LICENSE`); file header reads `@copyright Copyright (c) 2015, Matthias Mullie. All rights reserved` |
| **Paths** | `lib/css_js_min/pathconverter/LICENSE`<br>`lib/css_js_min/pathconverter/converter.cls.php` |
| **Upstream** | https://github.com/matthiasmullie/path-converter |
| **Licence text** | `licenses/MIT-matthiasmullie-path-converter.txt` (byte-for-byte copy of the in-tree `LICENSE`, which is authoritative) |

### 1.3 loadCSS (Filament Group)

| | |
|---|---|
| **Version** | undetermined — no version string; the banner dates the copy to 2017 |
| **Licence** | `MIT` |
| **Copyright** | as written in the file: `/*! loadCSS. [c]2017 Filament Group, Inc. MIT License */` and `/*! loadCSS rel=preload polyfill. [c]2017 Filament Group, Inc. MIT License */` (`assets/js/css_async.js`, lines 1 and 3). Upstream `LICENSE` reads `Copyright (c) @scottjehl, 2016 Filament Group` |
| **Paths** | `assets/js/css_async.js`<br>`assets/js/css_async.min.js` — **both banners stripped**, see §5 |
| **Upstream** | https://github.com/filamentgroup/loadCSS |
| **Licence text** | `licenses/MIT-loadCSS-filament-group.txt` (upstream `LICENSE`, retrieved 2026-07-24) |

### 1.4 instant.page

| | |
|---|---|
| **Version** | **5.2.0** — quoted from `assets/js/instant_click.ori.js` line 1: `/*! instant.page v5.2.0 - (C) 2019-2024 Alexandre Dieulot - https://instant.page/license */` |
| **Licence** | `MIT` — confirmed at https://instant.page/license, which is the URL the banner itself points to |
| **Copyright** | `(C) 2019-2024 Alexandre Dieulot` (as written in the file banner); the licence page renders it `© 2019–2024 Alexandre Dieulot` |
| **Paths** | `assets/js/instant_click.ori.js`<br>`assets/js/instant_click.min.js` — **banner stripped**, see §5 |
| **Upstream** | https://instant.page/ · https://github.com/dieulot/instantpage |
| **Licence text** | `licenses/MIT-instant.page.txt` |

### 1.5 vanilla-lazyload (modified)

| | |
|---|---|
| **Version** | **undetermined.** No version string exists anywhere in the bundled files. Evidence narrows it to the 17.5.x–17.6.x range: `restoreAll` is present (added upstream at 17.5.0) and `class_native` is absent; whitespace-normalised byte counts place the file (21,518 B) between upstream 17.5.0 (21,401 B) and 17.6.0 (21,755 B). No upstream release matches exactly — the copy is modified (the automatic-instance block is commented out at the end of `lazyload.lib.js`). Do **not** state a version without re-deriving it. |
| **Licence** | `MIT` |
| **Copyright** | **not present in the bundled file** — the file carries no banner at all. Upstream `LICENSE` reads `Copyright (c) 2025 Andrea Verlicchi`. Because the bundled copy predates that line, the year in the reproduced text is the current upstream one; the holder (Andrea Verlicchi) is unambiguous. |
| **Paths** | `assets/js/lazyload.lib.js`<br>`assets/js/lazyload.min.js` (a minified concatenation of `lazyload.lib.js` + LiteSpeed's own `lazyload.init.js`) |
| **Upstream** | https://github.com/verlok/vanilla-lazyload |
| **Licence text** | `licenses/MIT-vanilla-lazyload.txt` (upstream `LICENSE`, retrieved 2026-07-24) |

Note: the absence of a banner here is **not** a stripped banner — upstream's own `dist/lazyload.min.js`
ships without one (verified against 17.8.3 / 17.8.5 / 17.9.0). MIT's notice requirement is
therefore satisfied by this file plus `licenses/MIT-vanilla-lazyload.txt`, not by a banner.

### 1.6 React and ReactDOM

| | |
|---|---|
| **Version** | **17.0.1** — quoted from `assets/js/react.min.js` line 1: `/** @license React v17.0.1`; the same file contains `version:"17.0.1"`. This single file bundles **both** `react.production.min.js` and `react-dom.production.min.js` (both filenames appear inside it). |
| **Licence** | `MIT` |
| **Copyright** | as written in the file: `Copyright (c) Facebook, Inc. and its affiliates.` |
| **Paths** | `assets/js/react.min.js` |
| **Upstream** | https://github.com/facebook/react |
| **Licence text** | `licenses/MIT-react.txt` (upstream `LICENSE` at tag `v17.0.1`) |

⚠️ **Non-licence risk, flagged for the fork owner:** React 17 reached end-of-life. Under
Zinn engineering rule §2.2 ("latest stable, never EOL") this bundled runtime is a defect
independent of licensing. The in-file banner also says the licence is "found in the LICENSE
file in the root directory of this source tree" — that file is **not** shipped by upstream
LiteSpeed Cache, which is part of the gap this notices file closes.

### 1.7 babel-standalone (Babel 6)

| | |
|---|---|
| **Version** | **6.26.0** — quoted from `assets/js/babel.min.js`: `t.version="6.26.0"` (occurs twice). Cross-checked against the npm registry: `babel-standalone` 6.26.0 exists and is the final release of that package (`dist-tags.latest = 6.26.0`), licensed MIT. |
| **Licence** | `MIT` |
| **Copyright** | **not present in the bundled file** — `babel.min.js` contains no copyright, licence or banner text of any kind (verified: zero matches for `Copyright`/`MIT`). Upstream `LICENSE` reads `Copyright (c) 2015 Daniel Lo Nigro`. The bundle additionally embeds Babel 6 core, upstream-licensed MIT to Sebastian McKenzie and other Babel contributors. |
| **Paths** | `assets/js/babel.min.js` (791 KB) |
| **Upstream** | https://github.com/babel/babel-standalone (merged into https://github.com/babel/babel as `@babel/standalone` from v7) |
| **Licence text** | `licenses/MIT-babel-standalone.txt` (upstream `LICENSE`, retrieved 2026-07-24) |

Note: the missing banner is **not** stripped — upstream `babel-standalone@6.26.0`'s own
`babel.min.js` and `babel.js` ship without a banner (verified against unpkg). MIT's notice
requirement is satisfied by this file plus `licenses/MIT-babel-standalone.txt`.

---

## 2. BSD-3-Clause

### 2.1 mrclay/minify (modified) — **no licence text was shipped upstream**

| | |
|---|---|
| **Version** | undetermined — no version marker in either file |
| **Licence** | `BSD-3-Clause` |
| **Copyright** | **not present in the bundled files.** Both headers give only `@package Minify` / `@author Stephen Clay <steve@mrclay.org>`. Upstream `LICENSE.txt` reads `Copyright (c) 2008 Ryan Grove <ryan@wonko.com>` / `Copyright (c) 2008 Steve Clay <steve@mrclay.org>` / `All rights reserved.` |
| **Paths** | `lib/html-min.cls.php` (upstream `Minify_HTML`)<br>`lib/urirewriter.cls.php` (upstream `Minify_CSS_UriRewriter`; the file itself links `https://github.com/mrclay/minify/issues/517`, confirming provenance) |
| **Upstream** | https://github.com/mrclay/minify |
| **Licence text** | `licenses/BSD-3-Clause-mrclay-minify.txt` (upstream `LICENSE.txt`, retrieved 2026-07-24) |

⚠️ **This is the most serious gap found.** BSD-3-Clause clause 2 requires that redistributions
"reproduce the above copyright notice, this list of conditions and the following disclaimer in
the documentation and/or other materials provided with the distribution." Upstream LiteSpeed
Cache 7.8.1 ships this code with **no copyright line and no licence text anywhere in the
package**. Shipping this file plus `licenses/BSD-3-Clause-mrclay-minify.txt` is what brings the
fork into compliance.

**Correction to the prior audit:** the earlier licence audit recorded `lib/css_js_min/minify/`
as mrclay/minify under BSD-3-Clause. That is wrong. Both in-tree `LICENSE` files under
`lib/css_js_min/` are **MIT, Matthias Mullie** (2012 and 2015 respectively). The mrclay code is
in `lib/html-min.cls.php` and `lib/urirewriter.cls.php`, which ship **no** `LICENSE` file at all.

---

## 3. Apache-2.0

Apache-2.0 is compatible with GPL-3.0-or-later (it is **not** compatible with GPL-2.0). The
plugin is GPL-3.0-or-later, so these components are fine — but the fork must not be
down-licensed to GPLv2 while they remain bundled.

Neither upstream project ships a `NOTICE` file (verified: `typekit/webfontloader` has no
`NOTICE`; `marcelodolza/iziModal` has none), so no `NOTICE` content needs propagating under
Apache-2.0 §4(d). A single copy of the licence text serves both components, since the
Apache-2.0 text carries no per-component copyright line.

### 3.1 Web Font Loader

| | |
|---|---|
| **Version** | **1.6.28** — quoted from `assets/js/webfontloader.js` line 1: `/* Web Font Loader v1.6.28 - (c) Adobe Systems, Google. License: Apache 2.0 */` |
| **Licence** | `Apache-2.0` |
| **Copyright** | as written in the file: `(c) Adobe Systems, Google` |
| **Paths** | `assets/js/webfontloader.js`<br>`assets/js/webfontloader.min.js` — **banner stripped**, see §5 |
| **Upstream** | https://github.com/typekit/webfontloader |
| **Licence text** | `licenses/Apache-2.0.txt` |

### 3.2 iziModal

| | |
|---|---|
| **Version** | **JS 1.6.0, CSS 1.5.1 — the two disagree.** JS, from `assets/js/iziModal.min.js`: `* iziModal \| v1.6.0`. CSS, from `assets/css/iziModal.min.css`: `* iziModal \| v1.5.1`. Both quoted verbatim. |
| **Licence** | `Apache-2.0` — **not MIT**, contrary to common assumption. Verified against upstream `package.json` at tag `v1.6.0`: `"license": "Apache-2.0"`, and on `master`. |
| **Copyright** | as written in the files: `by Marcelo Dolce.` (no formal copyright line is present in either bundled file) |
| **Paths** | `assets/js/iziModal.min.js`<br>`assets/css/iziModal.min.css` |
| **Upstream** | https://github.com/marcelodolza/iziModal · https://izimodal.marcelodolza.com/ |
| **Licence text** | `licenses/Apache-2.0.txt` |

Note: Apache-2.0 §4(c) requires retaining attribution notices. Both bundled files **do** retain
their header block, so no banner restoration is needed for iziModal; the gap was only the
missing licence text, closed by `licenses/Apache-2.0.txt`.

---

## 4. Unidentified — requires resolution before wordpress.org submission

Nothing in this section may ship until it is resolved. Do not guess a licence for any of these.

1. **`lib/php-compatibility.func.php` — `http_build_url()` polyfill (lines 17–137).**
   The file header claims it as LiteSpeed's own ("LiteSpeed PHP compatibility functions for
   lower PHP version") and carries no third-party attribution. However, the `http_build_url()`
   polyfill it contains, together with its `HTTP_URL_*` constant block, matches a
   widely-circulated public snippet reimplementing the PECL `pecl_http` function, and the
   `array_key_first()` / `array_column()` polyfills in the same file are likewise
   commonly-copied. **Action:** confirm with LiteSpeed Technologies (or by diffing against the
   known public snippet) whether this is original work before relying on the GPL claim.
   Low practical risk, but unverifiable from the tree alone.

2. **`assets/img/slack-logo.png` — RESOLVED, not shipped.**
   A third-party brand mark (Slack Technologies, LLC) that upstream ships with no licence or
   trademark notice. It is **removed from this fork** (`drop_paths` in the rebrand manifest),
   along with the LiteSpeed community banner that displayed it and the stylesheet rule that
   referenced it. Recorded here so a future upstream bump does not quietly reintroduce it.

3. **`assets/js/lazyload.lib.js` / `lazyload.min.js` version.**
   Not a licence blocker (the licence is certain: MIT / Andrea Verlicchi), but the exact
   upstream version could not be established and the copy is modified. **Action:** record the
   real version by asking upstream or by pinning a fresh vendored copy in the fork.

4. **`assets/js/babel.min.js` — Babel 6 core sub-components.**
   The bundle is `babel-standalone` 6.26.0 (MIT, established above), but a 791 KB webpack
   bundle of Babel 6 may embed further MIT/BSD-licensed transitive dependencies whose own
   notices were dropped at bundle time; only `babel-plugin-transform-decorators-legacy` is
   still name-visible in the minified output. **Action:** either (a) drop Babel from the fork
   (it exists only to transpile the two admin React components at runtime and is a large,
   long-EOL payload), or (b) rebuild from a lockfile and generate a per-dependency notice list.
   Option (a) is strongly preferred and also resolves §1.6.

---

## 5. Stripped licence banners inherited from upstream

Three shipped, browser-served files have had their licence banner removed while the
unminified sibling in the same directory retains it. In each case the stripped file is the one
actually served by the plugin — `src/optimize.cls.php:17-18` defines
`LIB_FILE_CSS_ASYNC = 'assets/js/css_async.min.js'` and
`LIB_FILE_WEBFONTLOADER = 'assets/js/webfontloader.min.js'`, and `src/gui.cls.php:536`
enqueues `assets/js/instant_click.min.js` — so the notice is missing from exactly the copy
that reaches end users, while the compliant sibling is never served. Two are MIT (notice required
by the licence's sole condition) and one is Apache-2.0 (notice required by §4(c)).

| File | Licence | Banner status |
|---|---|---|
| `assets/js/css_async.min.js` | MIT (loadCSS) | both banners removed; present in `css_async.js` |
| `assets/js/instant_click.min.js` | MIT (instant.page) | banner removed; present in `instant_click.ori.js` |
| `assets/js/webfontloader.min.js` | Apache-2.0 (Web Font Loader) | banner removed; present in `webfontloader.js` |

The exact restorations are machine-readable in `banners.json` next to this file. They must be
applied to the fork before release.

---

## 6. Accounting — every file in `assets/js/`, `assets/css/` and `lib/`

Files marked *LiteSpeed's own work* are covered by the plugin's main copyright and are
deliberately not itemised above.

### `assets/js/` (21 files)

| File | Disposition |
|---|---|
| `babel.min.js` | third-party — §1.7 |
| `component.cdn.js` | LiteSpeed's own work (`@author Hai Zheng`) |
| `component.crawler.js` | LiteSpeed's own work (`@author Hai Zheng`) |
| `css_async.js` | third-party — §1.3 |
| `css_async.min.js` | third-party — §1.3 (banner stripped, §5) |
| `guest.docref.js` | LiteSpeed's own work |
| `guest.docref.min.js` | LiteSpeed's own work |
| `guest.js` | LiteSpeed's own work |
| `guest.min.js` | LiteSpeed's own work |
| `instant_click.min.js` | third-party — §1.4 (banner stripped, §5) |
| `instant_click.ori.js` | third-party — §1.4 |
| `iziModal.min.js` | third-party — §3.2 |
| `js_delay.js` | LiteSpeed's own work |
| `js_delay.min.js` | LiteSpeed's own work |
| `lazyload.init.js` | LiteSpeed's own work (`@author LiteSpeed`) |
| `lazyload.lib.js` | third-party — §1.5 |
| `lazyload.min.js` | third-party — §1.5 (vanilla-lazyload + LiteSpeed's `lazyload.init.js`, minified together) |
| `litespeed-cache-admin.js` | LiteSpeed's own work |
| `react.min.js` | third-party — §1.6 |
| `webfontloader.js` | third-party — §3.1 |
| `webfontloader.min.js` | third-party — §3.1 (banner stripped, §5) |

### `assets/css/` (5 files)

| File | Disposition |
|---|---|
| `iziModal.min.css` | third-party — §3.2 |
| `litespeed-dark-mode.css` | LiteSpeed's own work |
| `litespeed-dummy.css` | LiteSpeed's own work |
| `litespeed-legacy.css` | LiteSpeed's own work |
| `litespeed.css` | LiteSpeed's own work (includes a base64-embedded `litespeedfont` icon font, LiteSpeed's own) |

### `lib/` (17 files)

| File | Disposition |
|---|---|
| `css_js_min/minify/LICENSE` | third-party licence text — §1.1 |
| `css_js_min/minify/minify.cls.php` | third-party — §1.1 |
| `css_js_min/minify/css.cls.php` | third-party — §1.1 |
| `css_js_min/minify/js.cls.php` | third-party — §1.1 |
| `css_js_min/minify/exception.cls.php` | third-party — §1.1 |
| `css_js_min/minify/data/js/keywords_after.txt` | third-party data — §1.1 |
| `css_js_min/minify/data/js/keywords_before.txt` | third-party data — §1.1 |
| `css_js_min/minify/data/js/keywords_reserved.txt` | third-party data — §1.1 |
| `css_js_min/minify/data/js/operators.txt` | third-party data — §1.1 |
| `css_js_min/minify/data/js/operators_after.txt` | third-party data — §1.1 |
| `css_js_min/minify/data/js/operators_before.txt` | third-party data — §1.1 |
| `css_js_min/pathconverter/LICENSE` | third-party licence text — §1.2 |
| `css_js_min/pathconverter/converter.cls.php` | third-party — §1.2 |
| `guest.cls.php` | LiteSpeed's own work |
| `html-min.cls.php` | third-party — §2.1 |
| `object-cache.php` | LiteSpeed's own work (WP drop-in) |
| `php-compatibility.func.php` | LiteSpeed's own work per its header — but see §4 item 1 |
| `urirewriter.cls.php` | third-party — §2.1 |

### `thirdparty/` (30 files) — **not** third-party code

Despite the directory name, `thirdparty/` contains **LiteSpeed's own** compatibility shims for
other WordPress plugins (WooCommerce, Elementor, WPML, …). `thirdparty/entry.inc.php` states
it is "The registry for Third Party Plugins Integration files"; every class is namespaced
`LiteSpeed\Thirdparty` and headed `@package LiteSpeed`. A grep across all PHP in `src/`,
`cli/`, `tpl/`, `thirdparty/` and the root files found **no** non-LiteSpeed `@author`,
`@copyright` or `@license` markers outside `lib/` (which is fully itemised above). Nothing in
`src/` is vendored third-party code.

---

## 7. Licence-text index

| File | Covers | Source |
|---|---|---|
| `licenses/MIT-matthiasmullie-minify.txt` | §1.1 | exact copy of in-tree `lib/css_js_min/minify/LICENSE` (authoritative) |
| `licenses/MIT-matthiasmullie-path-converter.txt` | §1.2 | exact copy of in-tree `lib/css_js_min/pathconverter/LICENSE` (authoritative) |
| `licenses/MIT-loadCSS-filament-group.txt` | §1.3 | upstream `filamentgroup/loadCSS` `LICENSE` |
| `licenses/MIT-instant.page.txt` | §1.4 | https://instant.page/license (the URL named in the file's own banner) |
| `licenses/MIT-vanilla-lazyload.txt` | §1.5 | upstream `verlok/vanilla-lazyload` `LICENSE` |
| `licenses/MIT-react.txt` | §1.6 | upstream `facebook/react` `LICENSE` at tag `v17.0.1` |
| `licenses/MIT-babel-standalone.txt` | §1.7 | upstream `babel/babel-standalone` `LICENSE` |
| `licenses/BSD-3-Clause-mrclay-minify.txt` | §2.1 | upstream `mrclay/minify` `LICENSE.txt` |
| `licenses/Apache-2.0.txt` | §3.1, §3.2 | canonical Apache License 2.0 text |

All non-in-tree texts retrieved 2026-07-24.
