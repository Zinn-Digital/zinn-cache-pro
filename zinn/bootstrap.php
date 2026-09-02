<?php
/**
 * Zinn integration layer for Zinn Cache Engine.
 *
 * Everything in this directory is Zinn-authored — it is NOT derived from upstream, and it is
 * the only part of this plugin held to the full WordPress Coding Standards ruleset (see
 * wp/phpcs.xml.dist). The upstream-derived tree around it is vendored third-party code we
 * deliberately do not restyle.
 *
 * The file is loaded from the very end of the main plugin file, after upstream has finished
 * bootstrapping, so nothing here can change how the cache engine starts up.
 *
 * @package ZinnCachePro
 */

declare( strict_types=1 );

namespace ZinnCachePro\Zinn;

defined( 'WPINC' ) || exit;

/**
 * Load the plugin's bundled translations.
 *
 * Upstream never calls load_plugin_textdomain() anywhere in its 200-odd PHP files: as a
 * wordpress.org-hosted plugin it relies entirely on WordPress fetching language packs from
 * translate.wordpress.org by slug. A fork is not on wordpress.org and will never receive
 * those packs, so without this call the plugin ships ~1,400 translatable strings that can
 * never be translated into any of the 58 locales the platform serves.
 *
 * Registered on `init` rather than `plugins_loaded`: since WordPress 6.7 a text domain loaded
 * before `init` triggers the `_load_textdomain_just_in_time` _doing_it_wrong() notice, and our
 * coding-standards gate treats notices as failures. The just-in-time loader alone is not a
 * substitute — it looks in WP_LANG_DIR/plugins, not in a non-wordpress.org plugin's own
 * languages/ directory.
 *
 * @return void
 */
function load_translations(): void {
	load_plugin_textdomain(
		'zinn-cache-pro',
		false,
		dirname( ZINN_CACHE_PRO_BASENAME ) . '/languages'
	);
}

/**
 * The plugin's own release version, as WordPress sees it.
 *
 * ⛔ NOT `ZINN_CACHE_PRO_V`. That constant carries UPSTREAM's version (7.8.1 — the LiteSpeed
 * Cache release this fork is derived from) and is used throughout the vendored tree for cache
 * busting and migration gates. The fork's own release version is 1.0.0 and lives only in the
 * main file's `Version:` header, which is the number WordPress compares against an update
 * offer. Handing the updater 7.8.1 would make every genuine 1.x release look like a
 * downgrade and no update would ever install.
 *
 * @return string Version string, or '' if the header cannot be read.
 */
function plugin_version(): string {
	static $version = null;

	if ( null !== $version ) {
		return $version;
	}

	$data    = get_file_data( plugin_file(), array( 'Version' => 'Version' ), 'plugin' );
	$version = isset( $data['Version'] ) ? (string) $data['Version'] : '';

	return $version;
}

/**
 * Absolute path to the main plugin file.
 *
 * @return string
 */
function plugin_file(): string {
	return ZINN_CACHE_PRO_DIR . 'zinn-cache-pro.php';
}

/**
 * Whether an update offer's package URL points at Zinn Digital®.
 *
 * @param mixed $offer An entry from the `update_plugins` transient.
 * @return bool
 */
function is_zinn_offer( $offer ): bool {
	$package = is_object( $offer ) && isset( $offer->package ) && is_scalar( $offer->package )
		? (string) $offer->package
		: '';

	if ( '' === $package ) {
		return false;
	}

	$scheme = (string) wp_parse_url( $package, PHP_URL_SCHEME );
	$host   = (string) wp_parse_url( $package, PHP_URL_HOST );

	return Updater::is_package_host_allowed( $scheme, $host, 'zinndigital.com' );
}

/**
 * Stop wordpress.org from overwriting this fork with the upstream plugin.
 *
 * The fork's slug is `zinn-cache-pro`, which does not exist on wordpress.org, so the update
 * API will not match it today. That is a weak guarantee to bet 90,000 customer sites on: it
 * depends on a slug staying unclaimed on a public registry we do not control. The plugin
 * header also declares `Update URI: https://zinndigital.com`, which WordPress 5.8+ honours by
 * skipping the wordpress.org check entirely — this filter is the belt to that braces, and it
 * removes a FOREIGN offer for our basename from the update payload rather than trying to
 * answer it.
 *
 * ⛔⛔ IT MUST NOT REMOVE OUR OWN OFFER, AND THE EARLIER VERSION OF THIS FUNCTION WOULD HAVE.
 * `Updater::inject_update()` adds our release on `pre_set_site_transient_update_plugins`
 * (a WRITE); this filter runs on `site_transient_update_plugins` (every READ). An
 * unconditional `unset()` therefore deleted, on the very next read, the update the updater
 * had just injected — so the admin would show no update, for ever, with nothing logged and
 * every gate green. The two halves were written months apart and each is correct alone; it is
 * only their ORDER that breaks, which is invisible in either file on its own.
 *
 * So the discriminator is the package host: an offer whose package is HTTPS on a Zinn® host is
 * ours and is kept, anything else for our basename is stripped.
 *
 * @param mixed $transient The `update_plugins` site transient.
 * @return mixed
 */
function block_dotorg_updates( $transient ) {
	if ( ! is_object( $transient ) ) {
		return $transient;
	}

	$basename = ZINN_CACHE_PRO_BASENAME;

	foreach ( array( 'response', 'no_update' ) as $bucket ) {
		if ( ! isset( $transient->{$bucket} ) || ! is_array( $transient->{$bucket} ) ) {
			continue;
		}

		if ( ! array_key_exists( $basename, $transient->{$bucket} ) ) {
			continue;
		}

		if ( is_zinn_offer( $transient->{$bucket}[ $basename ] ) ) {
			continue;
		}

		unset( $transient->{$bucket}[ $basename ] );
	}

	return $transient;
}

/**
 * Register the self-hosted updater.
 *
 * ⚖️ Owner ruling 2026-09-01, asked with the measurement in front of him: this fork is offered
 * as a public download, and until today it blocked wordpress.org updates with nothing in their
 * place — so every copy a customer installed was frozen for ever, on a fork whose own rebrand
 * manifest records patching an XSS. It now updates from Zinn Digital® over the same
 * HMAC-authenticated, checksum-verified channel `zinn-cache` uses. Absent config = inert.
 *
 * @return void
 */
function register_updater(): void {
	( new Updater( plugin_file(), plugin_version() ) )->register();
}

require_once __DIR__ . '/class-updater.php';

add_action( 'init', __NAMESPACE__ . '\\load_translations' );
add_filter( 'site_transient_update_plugins', __NAMESPACE__ . '\\block_dotorg_updates' );

/**
 * Load the Zinn® panel — hosting, the marketplace, Zinn Hub® and this plugin's user guide.
 *
 * ⚖️ Owner, 2026-09-01: *"each plugin should promote our hosting and marketplace as well as
 * Zinn Hub global marketplace inside people's site in the admin dashboard"*, and *"user guides
 * for them … linked to in the plugins dashboard"*.
 *
 * ⛔ `class-zinn-promo.php` is Zinn-authored and lives in `rebrand/overlay/zinn/`, beside this
 * file, for the reason the header above gives: anything written straight into the generated
 * tree is destroyed by the next `composer run rebrand`.
 *
 * ⛔ The class is deliberately GLOBAL while this file is namespaced, so it is required by path
 * and called by a string callable — `Zinn_Cache_Pro_Promo::class` here would resolve to
 * `ZinnCachePro\Zinn\Zinn_Cache_Pro_Promo`, which does not exist. `php -l` cannot see that.
 *
 * ⭐ The settings-screen panel attaches by SCREEN, not by a template patch: this plugin's admin
 * is upstream's and a `file_patches` entry into it would rot on the next version bump.
 *
 * @return void
 */
function load_promo(): void {
	require_once __DIR__ . '/class-zinn-cache-pro-promo.php';
	call_user_func( array( 'Zinn_Cache_Pro_Promo', 'register' ) );
	call_user_func( array( 'Zinn_Cache_Pro_Promo', 'attach_footer_panel' ), 'zinn-cache-pro' );
}

add_action( 'plugins_loaded', __NAMESPACE__ . '\\load_promo' );

register_updater();
