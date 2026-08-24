=== Zinn® Cache Pro ===
Contributors: zinndigital
Plugin URI: https://zinndigital.com
Author: Neil Lock — CEO, Zinn Digital® Ltd
Author URI: https://zinndigital.com
Tags: cache, page cache, object cache, performance, optimization
Requires at least: 6.6
Tested up to: 7.1
Requires PHP: 8.2
Stable tag: 1.0.0
License: GPLv3 or later
License URI: https://www.gnu.org/licenses/gpl-3.0.html

High-performance server-side caching for the Zinn Digital® hosting platform: full-page cache, object cache, database optimisation, and CSS/JS optimisation.

== Description ==

Zinn® Cache Pro is the full-featured caching engine shipped in the Zinn Digital® deploy footprint. It drives the server-level full-page cache, an object cache, database cleanup, and front-end asset optimisation.

It is a fork of the GPL-licensed LiteSpeed Cache plugin (see **Attribution** below). Full-page caching requires a LiteSpeed or OpenLiteSpeed web server with the LSCache module; on other servers the page cache is inactive while the remaining optimisation features continue to work.

**What it does**

* **Full-page cache.** Server-level caching via the LSCache module, with tag-based purging, ESI hole-punching, private and vary-aware caching, and a configurable crawler that keeps the cache warm.
* **Object cache.** Redis or Memcached backed persistent object caching, installed as a WordPress drop-in.
* **Database optimisation.** Scheduled and on-demand cleanup of revisions, auto-drafts, transients, and orphaned metadata.
* **Asset optimisation.** CSS/JS minification and combination, deferred and delayed JavaScript, lazy-loaded images, and font-display control.
* **Browser cache and HTTP/2 push controls**, plus fine-grained cache exclusions by URI, query string, cookie, role, and user agent.

**Relationship to the Zinn® Cache plugin**

`zinn-cache` is a lightweight cache *controller* — it stamps LSCache headers and mirrors purges to the control plane. Zinn® Cache Pro is the full engine. They are distinct plugins with distinct slugs, and they cooperate: when Zinn® Cache Pro is active, Zinn® Cache defers page caching to it and routes purges through its public actions.

== Attribution ==

Zinn® Cache Pro is a GPLv3 fork of **LiteSpeed Cache 7.8.1**, Copyright (C) 2015–2026 LiteSpeed Technologies, Inc., modified by Zinn Digital® Ltd from 2026-07-24.

The modifications are itemised in `CHANGES-FROM-UPSTREAM.md`. Bundled third-party components and their licences are listed in `THIRD-PARTY-NOTICES.md`, with full licence texts under `licenses/`.

LiteSpeed, LSCache, OpenLiteSpeed and QUIC.cloud are trademarks of LiteSpeed Technologies, Inc. Zinn® Cache Pro is an independent fork and is **not** affiliated with, endorsed by, or supported by LiteSpeed Technologies, Inc. Please do not report issues with this fork to LiteSpeed — see **Security** below.

== Installation ==

1. Upload the `zinn-cache-pro` folder to `/wp-content/plugins/` (this is done automatically as part of the Zinn® deploy footprint).
2. Activate the plugin through the **Plugins** screen in WordPress.
3. Go to **Zinn® Cache Pro** in the admin menu to configure caching, optimisation, and exclusions.

For full-page caching the host must run LiteSpeed Enterprise or OpenLiteSpeed with the LSCache module enabled.

== Frequently Asked Questions ==

= How is this different from the LiteSpeed Cache plugin? =

It is a fork of it. The caching engine is upstream's, under the GPLv3. The differences are the Zinn® branding and identifiers, the removal of the QUIC.cloud online-service integration, an added translation loader, and a raised PHP/WordPress floor. `CHANGES-FROM-UPSTREAM.md` lists every change.

= Why were the QUIC.cloud features removed? =

QUIC.cloud is a third-party paid service operated by LiteSpeed Technologies. It is not part of the Zinn Digital® product, and the integration sent site data to that third party — including on plugin deactivation and uninstall — without a meaningful opt-out. Image optimisation, UCSS/CCSS generation, VPI and the QUIC.cloud CDN depended on it and are therefore unavailable. All caching, crawling, database and asset-optimisation features are unaffected, and the Cloudflare and generic static-CDN integrations still work.

= Will this be updated from wordpress.org? =

No. Zinn® Cache Pro is not distributed through the wordpress.org plugin directory, and the plugin explicitly removes itself from the wordpress.org update payload so it can never be overwritten by a different plugin. Updates are delivered through the Zinn® deploy footprint.

= Does it conflict with the Zinn® Cache plugin? =

No. Zinn® Cache handles page caching only when no cache engine is present; when Zinn® Cache Pro is active it defers to it.

== Security ==

Report security issues with **this fork** to security@zinndigital.com — not to LiteSpeed Technologies. If an issue also affects upstream LiteSpeed Cache we will coordinate disclosure with them.

== Changelog ==

= 1.0.0 =
* Initial Zinn Digital® release, forked from LiteSpeed Cache 7.8.1.
* Rebranded to Zinn® Cache Pro: plugin identity, text domain, constants, hooks, PHP namespace, options and admin pages all carry Zinn® identifiers, so the fork never collides with an upstream install.
* Removed the QUIC.cloud service integration in full, including the deactivation survey, the install/upgrade/uninstall version check, and the remote-ZIP "beta test" install channel.
* Removed an undisclosed third-party IP lookup and a `fonts.gstatic.com` preconnect injected into front-end pages.
* Added a bundled-translation loader so the plugin is translatable in all supported locales.
* Raised the enforced minimums to PHP 8.2 and WordPress 6.6.

== Upgrade Notice ==

= 1.0.0 =
Initial release.
