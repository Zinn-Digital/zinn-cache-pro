# Changes from upstream

**Zinn Cache Pro** is a modified version of **LiteSpeed Cache 7.8.1**
(Copyright © 2015–2026 LiteSpeed Technologies, Inc., GPL-3.0-or-later).

Modified by **Zinn Digital® Ltd** (Neil Lock, CEO). First modified release: **2026-07-24**.

This file is the GPL-3.0 §5(a) record of what was changed. It is generated from a reviewed
manifest rather than written by hand: the fork is derived mechanically from a SHA-256-pinned
upstream release, so every difference below is either a manifest rule or a manifest patch, and
`composer run rebrand:verify` proves the shipped tree contains nothing else.

- Upstream release: `litespeed-cache.7.8.1.zip`
- SHA-256: `b4c550a197f30212ab59489f75eb00e3610253db9ee3d837b1e8f7bf8ba803a9`
- Source: <https://downloads.wordpress.org/plugin/litespeed-cache.7.8.1.zip>

The licence is unchanged: this fork is distributed under **GPL-3.0-or-later**, the same terms as
upstream. Every upstream copyright, authorship and licence notice is preserved verbatim.

---

## 1. Identity (rebranding)

So the fork is a genuinely distinct plugin that can never collide with an upstream install:

| Upstream | Zinn® Cache Pro |
|---|---|
| `litespeed-cache` (slug, text domain) | `zinn-cache-pro` |
| `LiteSpeed` (PHP namespace) | `ZinnCachePro` |
| `LSCWP_`, `LSWCP_`, `LITESPEED_` (constants) | `ZINN_CACHE_PRO_` |
| `litespeed_` (action/filter prefix) | `zinn_cache_pro_` |
| `litespeed`, `litespeed-*` (admin pages) | `zinn-cache-pro`, `zinn-cache-pro-*` |
| `litespeed-cache-conf` (options row) | `zinn-cache-pro-cache-conf` |
| `litespeed/v1`, `litespeed/v3` (REST) | `zinn-cache-pro/v1`, `zinn-cache-pro/v3` |
| `lang/` | `languages/` |

**Deliberately NOT renamed** — these are the LiteSpeed *web server's* contracts, not the
plugin's identity, and renaming them would break caching outright:
`X-LiteSpeed-Cache-Control`, `X-LiteSpeed-Purge`, `X-LiteSpeed-Purge2`, `X-LiteSpeed-Tag`,
`X-LiteSpeed-Vary`, `X-LiteSpeed-Debug`, `x-litespeed-cache`, `<IfModule LiteSpeed>`,
`%{ENV:LSCACHE_VARY_VALUE}`, the `_lscache_vary` cookie, the `LSCACHE_VARY_COOKIE` /
`LSCACHE_VARY_VALUE` / `X-LSCACHE` / `LSWS_EDITION` server variables, and the cross-plugin
convention constants `DONOTCACHEPAGE`, `LSCACHE_NO_CACHE` and `LSCACHE_IS_ESI` that other
plugins read and set.

The `litespeed-*` CSS class names and admin stylesheet filenames are also left alone: they are
internal to the plugin's own admin UI, never appear in front-end HTML, and renaming them
mechanically across PHP + CSS + JS would risk breaking selectors for no functional gain.

## 2. QUIC.cloud service integration — removed in full

QUIC.cloud is a paid service operated by LiteSpeed Technologies. It is not part of the Zinn
Digital® product, and several of its call paths sent customer data to that third party with no
meaningful opt-out. All of it is removed:

- **Deactivation survey.** A browser-side POST of the site URL and a deactivation reason to
  `https://wpapi.quic.cloud/survey`, fired when an administrator deactivates the plugin.
- **Version check.** `Cloud::version_check()` POSTed the PHP version, plugin version and site
  URL to `wpapi.quic.cloud` on install, on upgrade, from the auto-update hook, and on
  **uninstall**. No option gated it.
- **Remote-ZIP install channel.** `Debug2::beta_test()` forged the `update_plugins` transient
  with a QUIC.cloud-supplied ZIP URL and ran `Plugin_Upgrader` on it. Neutered entirely, and the
  "Beta Test" admin tab that drove it is gone.
- **The central gate.** `Cloud_Request::_maybe_cloud()` now denies every request, plus the paths
  that did not route through it: node discovery and load-checking, the socket latency ping, the
  IP-allowlist fetch, the server public-key fetch, the optimised-image pull, and the Guest Mode
  daily list sync.
- **Remote markup in the admin.** QUIC.cloud-supplied `mini_html` / `promo` / news blobs were
  stored and echoed into the WordPress admin through `wp_kses_post()`. A third party can no
  longer place markup inside a customer's dashboard.
- **Admin surfaces.** The "Online Services" tab, the QUIC.cloud CDN tab, the Beta Test tab, the
  dashboard upsell banner and the `wp litespeed-online` WP-CLI command are removed.

**Consequently unavailable:** image optimisation, UCSS, critical CSS, viewport images (VPI),
low-quality image placeholders, and the QUIC.cloud CDN — all were QUIC.cloud-only services and
all default to off upstream. **Unaffected:** page caching, crawling, ESI, guest mode, object
cache, database optimisation, browser cache, CSS/JS minify/combine/defer/delay, lazy loading,
and the Cloudflare and generic static-CDN integrations.

## 3. Other privacy and safety changes

- Removed an **undisclosed third-party lookup** to `https://cyberpanel.sh/?ip`, sent with a
  spoofed `curl/8.7.1` User-Agent. The Toolbox IP check now reports the server's own address.
- Removed a `preconnect` to **`fonts.gstatic.com`** that was injected into every customer
  front-end page by the CSS optimiser.
- **Every `data-` attribute the plugin promotes to a URL is now scheme-checked before it is
  assigned.** WordPress's `kses` never protocol-checks a `data-` attribute, so on a site whose
  theme, page builder or custom-attributes plugin passes `data-*` through, a low-privileged
  author could ship `data-…-src="javascript:…"` and have this plugin turn it into a live `src`.
  Guarded in four built files: `js_delay.js`/`.min.js` (the delayed `<iframe>` and `<script>`
  restore) and `lazyload.lib.js`/`.min.js` (`img`, `iframe`, `<source>` and `video` `src`, video
  `poster`, and the CSS `background-image`). Scheme validation uses the browser's own URL parser
  rather than a regex, so the tab/newline obfuscations a browser ignores *inside* a URL are
  resolved the same way here. An `<iframe>` is restricted to `http`/`https`; the media sinks also
  accept `data:image/…`, which cannot execute script in an image context; the CSS sink is
  assigned the parser's normalised href so a quote in the value cannot close the `url("…")`
  string. Refused values are dropped and logged to the console, never assigned.
- **wordpress.org updates are blocked.** The plugin declares `Update URI: https://zinndigital.com`
  and additionally removes itself from the `update_plugins` transient, so it can never be
  overwritten by a different plugin that happens to share a slug on a registry we do not control.

## 4. Additions

- **`zinn/bootstrap.php`** — the only Zinn-authored code in the plugin. Upstream never calls
  `load_plugin_textdomain()` anywhere, because a wordpress.org-hosted plugin receives language
  packs automatically; a fork never will. Without this loader the plugin would ship ~1,360
  translatable strings that could not be translated into any locale. Registered on `init` to
  avoid the WordPress 6.7 `_load_textdomain_just_in_time` notice.
- **`languages/zinn-cache-pro.pot`** — regenerated from the fork's own source. Upstream's bundled
  template was for version 7.7 and could never match.
- **`THIRD-PARTY-NOTICES.md` + `licenses/`** — an aggregate inventory of bundled third-party
  components with their licences and copyright holders, and the full licence texts. Upstream
  ships no such file, and the MIT and BSD-3-Clause components it bundles require their notices
  to be reproduced in redistributions.
- **`security.md`** — rewritten to point at Zinn®'s disclosure channel instead of LiteSpeed's.

## 5. Requirements raised

The enforced floors now match the declared header, and both are non-EOL runtimes:

| | Upstream | Zinn® Cache Pro |
|---|---|---|
| PHP | 7.2 | **8.2** |
| WordPress | 5.3 | **6.6** |

## 6. Removed files

Upstream development and packaging files that must not reach a customer site
(`composer.json`, `composer.lock`, `package.json`, `package-lock.json`, `phpcs.xml.dist`,
`phpcs.ruleset.xml`, `typos.toml`, `qc-ping.txt`), upstream's `readme.txt`, `changelog.txt` and
`security.md` (all replaced, because mechanically rebranding them would assert a release history
and a `Contributors:` account that are not ours), the stale bundled `.pot`, and the five
QUIC.cloud screens left unreachable by the excision.

---

## Reproducing this fork

```sh
cd wp
composer run rebrand:fetch    # download + SHA-256-verify the pinned upstream
composer run rebrand          # re-derive plugins/zinn-cache-pro/
composer run rebrand:verify   # prove the committed tree matches, byte for byte
```

The rules and patches live in `wp/rebrand/litespeed-cache.rebrand.json`. Every hand-authored
file lives in `wp/rebrand/overlay/` — never edit `wp/plugins/zinn-cache-pro/` directly, because
the next `rebrand` run discards it.
