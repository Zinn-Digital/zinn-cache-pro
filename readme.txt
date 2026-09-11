=== Zinn® Cache Engine ===
Contributors: zinndigital
Plugin URI: https://zinndigital.com/wordpress-plugins/zinn-cache-pro
Author: Neil Lock — CEO, Zinn Digital® Ltd
Author URI: https://zinndigital.com
Tags: cache, page cache, object cache, performance, optimization
Requires at least: 6.6
Tested up to: 7.1
Requires PHP: 8.2
Stable tag: 1.2.1
License: GPLv3 or later
License URI: https://www.gnu.org/licenses/gpl-3.0.html

A complete caching and optimisation engine for WordPress — install this when your host provides no cache layer of its own. On Zinn Digital® hosting, install Zinn® Cache instead.

== Description ==

Zinn® Cache Engine is a complete caching and optimisation engine: a server-level full-page cache, an object cache, database cleanup, and front-end asset optimisation.

**Which Zinn® cache plugin do I need?** Exactly one of them:

* **Hosted with Zinn Digital®** — install **Zinn® Cache**. Your Zinn® server already runs the page cache; Zinn® Cache controls it and connects it to your dashboard. It is installed for you when your site is provisioned.
* **Hosted anywhere else** — install **Zinn® Cache Engine** (this plugin). It brings its own caching engine.

They are different plugins doing different jobs, not a free and a paid tier of one plugin. You do not need both.

It is a fork of the GPL-licensed LiteSpeed Cache plugin (see **Attribution** below). Full-page caching requires a LiteSpeed or OpenLiteSpeed web server with the LSCache module; on other servers the page cache is inactive while the remaining optimisation features continue to work.

**What it does**

* **Full-page cache.** Server-level caching via the LSCache module, with tag-based purging, ESI hole-punching, private and vary-aware caching, and a configurable crawler that keeps the cache warm.
* **Object cache.** Redis or Memcached backed persistent object caching, installed as a WordPress drop-in.
* **Database optimisation.** Scheduled and on-demand cleanup of revisions, auto-drafts, transients, and orphaned metadata.
* **Asset optimisation.** CSS/JS minification and combination, deferred and delayed JavaScript, lazy-loaded images, and font-display control.
* **Browser cache and HTTP/2 push controls**, plus fine-grained cache exclusions by URI, query string, cookie, role, and user agent.

**Relationship to the Zinn® Cache plugin**

`zinn-cache` is a cache *controller* — it stamps LSCache headers and mirrors purges to the Zinn® control plane. Zinn® Cache Engine is the *engine*. They are distinct plugins with distinct slugs, and if both are ever active they cooperate: Zinn® Cache defers page caching to the engine and routes purges through its public actions. In normal use you install one or the other, not both.

**Updates**

Zinn® Cache Engine updates itself from Zinn Digital®. The plugin asks `https://api.zinndigital.com` over HTTPS whether a newer release exists; the answer is authenticated with an HMAC signature, the download must be an HTTPS URL on a Zinn® host, and the zip is checked against the SHA-256 in the signed response before WordPress installs it. If the update endpoint is not configured the updater makes no external requests at all.

== Attribution ==

Zinn® Cache Engine is a GPLv3 fork of **LiteSpeed Cache 7.8.1**, Copyright (C) 2015–2026 LiteSpeed Technologies, Inc., modified by Zinn Digital® Ltd from 2026-07-24.

The modifications are itemised in `CHANGES-FROM-UPSTREAM.md`. Bundled third-party components and their licences are listed in `THIRD-PARTY-NOTICES.md`, with full licence texts under `licenses/`.

LiteSpeed, LSCache, OpenLiteSpeed and QUIC.cloud are trademarks of LiteSpeed Technologies, Inc. Zinn® Cache Engine is an independent fork and is **not** affiliated with, endorsed by, or supported by LiteSpeed Technologies, Inc. Please do not report issues with this fork to LiteSpeed — see **Security** below.

== Installation ==

1. Upload the `zinn-cache-pro` folder to `/wp-content/plugins/`, or install the zip from **Plugins → Add Plugin → Upload Plugin**.
2. Activate the plugin through the **Plugins** screen in WordPress.
3. Go to **Zinn® Cache Engine** in the admin menu to configure caching, optimisation, and exclusions.

For full-page caching the host must run LiteSpeed Enterprise or OpenLiteSpeed with the LSCache module enabled.

== Frequently Asked Questions ==

= How is this different from the LiteSpeed Cache plugin? =

It is a fork of it. The caching engine is upstream's, under the GPLv3. The differences are the Zinn® branding and identifiers, the removal of the QUIC.cloud online-service integration, an added translation loader, and a raised PHP/WordPress floor. `CHANGES-FROM-UPSTREAM.md` lists every change.

= Why were the QUIC.cloud features removed? =

QUIC.cloud is a third-party paid service operated by LiteSpeed Technologies. It is not part of the Zinn Digital® product, and the integration sent site data to that third party — including on plugin deactivation and uninstall — without a meaningful opt-out. Image optimisation, UCSS/CCSS generation, VPI and the QUIC.cloud CDN depended on it and are therefore unavailable. All caching, crawling, database and asset-optimisation features are unaffected, and the Cloudflare and generic static-CDN integrations still work.

Since 1.1.0 no QUIC.cloud surface remains anywhere in the plugin. The dashboard shows only cache status and crawler status, and the service is not named on any settings screen. Between 1.0.0 and 1.1.0 upstream's status panels were still drawn, reporting zero usage with sign-up buttons that could not act; that is what D17692 recorded and what 1.1.0 fixes.

= Will this be updated from wordpress.org? =

No. Zinn® Cache Engine is not distributed through the wordpress.org plugin directory, and the plugin explicitly removes itself from the wordpress.org update payload so it can never be overwritten by a different plugin. Updates are delivered from Zinn Digital® — the plugin checks `https://api.zinndigital.com` for a newer release, verifies the response signature and the package checksum, and installs it. See **Updates** below.

= Does it conflict with the Zinn® Cache plugin? =

No. Zinn® Cache handles page caching only when no cache engine is present; when Zinn® Cache Engine is active it defers to it.

== Security ==

Report security issues with **this fork** to security@zinndigital.com — not to LiteSpeed Technologies. If an issue also affects upstream LiteSpeed Cache we will coordinate disclosure with them.

== External services ==

This plugin talks to Zinn Digital®'s API on your behalf.

* **Support diagnostics (only when you press send).** If you ask us for help, the plugin can send
  a support report to `https://api.zinndigital.com/v1/connector/diagnostics`. **You are shown the
  exact payload first, already redacted, and nothing leaves your site until you press send.**
  Credentials are excluded by declaration rather than by matching key names, and render as
  `[not sent — credential]`. The plugin never sends this on its own initiative.


== Changelog ==

= 1.2.1 =
* Hardening: a settings rule can no longer be mistaken for a PHP function with the same name. The same shared settings code is what stopped Zinn® Translate saving its settings. Nothing about how this plugin behaves changes.

= 1.1.0 =
* Added the Zinn® panel: links to Zinn Digital® hosting, the Zinn® marketplace, Zinn Hub® and this plugin's user guide, from inside the WordPress admin.
* Removed every remaining QUIC.cloud surface. The 1.0.0 changelog said the integration was removed in full; the network coupling was, but upstream's QUIC.cloud panels were still drawn on the dashboard — a usage-statistics panel reading 0%, an "Enable QUIC.cloud Services" button, a "QUIC.cloud CDN" box and links to a competitor's products — and its service names still appeared on the CDN, Cache, Page Optimization, Image Optimization, Presets and Toolbox screens. None of it could do anything. All of it is gone (D17692).
* The dashboard now shows only what this build can actually serve: cache status and crawler status.
* Admin headings now show this plugin's own version instead of the upstream version it was forked from.

= 1.0.0 =
* Initial Zinn Digital® release, forked from LiteSpeed Cache 7.8.1.
* Rebranded to Zinn® Cache Engine: plugin identity, text domain, constants, hooks, PHP namespace, options and admin pages all carry Zinn® identifiers, so the fork never collides with an upstream install.
* Removed the QUIC.cloud service COUPLING: the deactivation survey, the install/upgrade/uninstall version check, the remote-ZIP "beta test" install channel, and the five QUIC.cloud settings screens. No site data leaves for that service and none of its features can be reached. The service's remaining screens and marketing copy were removed in 1.1.0 (D17692).
* Removed an undisclosed third-party IP lookup and a `fonts.gstatic.com` preconnect injected into front-end pages.
* Added a bundled-translation loader so the plugin is translatable in all supported locales.
* Raised the enforced minimums to PHP 8.2 and WordPress 6.6.

== Upgrade Notice ==

= 1.1.0 =
Removes the last QUIC.cloud panels and buttons, which could never work in this build. No setting changes and no cache is purged.

= 1.0.0 =
Initial release.
