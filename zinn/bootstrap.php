<?php
/**
 * Zinn integration layer for Zinn Cache Pro.
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
 * Stop wordpress.org from overwriting this fork with the upstream plugin.
 *
 * The fork's slug is `zinn-cache-pro`, which does not exist on wordpress.org, so the update
 * API will not match it today. That is a weak guarantee to bet 90,000 customer sites on: it
 * depends on a slug staying unclaimed on a public registry we do not control. The plugin
 * header also declares `Update URI: https://zinndigital.com`, which WordPress 5.8+ honours by
 * skipping the wordpress.org check entirely — this filter is the belt to that braces, and it
 * removes our plugin from the update payload rather than trying to answer it.
 *
 * If Zinn ever ships an update server for the deploy footprint (docs/33 §4), that is where it
 * hooks in — this function is the single, documented place the decision lives.
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
		if ( isset( $transient->{$bucket} ) && is_array( $transient->{$bucket} ) ) {
			unset( $transient->{$bucket}[ $basename ] );
		}
	}

	return $transient;
}

add_action( 'init', __NAMESPACE__ . '\\load_translations' );
add_filter( 'site_transient_update_plugins', __NAMESPACE__ . '\\block_dotorg_updates' );
