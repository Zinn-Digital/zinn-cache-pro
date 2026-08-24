<?php
/**
 * The Third Party integration with AMP plugin.
 *
 * @since      2.9.8.6
 * @package ZinnCachePro
 * @subpackage LiteSpeed_Cache/thirdparty
 */

namespace ZinnCachePro\Thirdparty;

defined( 'WPINC' ) || exit;

/**
 * Integration helpers for AMP-compatible behaviour.
 *
 * Disables optimization features on AMP endpoints provided by popular AMP
 * plugins to ensure valid AMP output (no injected JS/lazy/CSS async, etc).
 */
class AMP {

	/**
	 * Maybe mark current request as AMP and disable conflicting optimizations.
	 *
	 * @since 4.2
	 *
	 * @param string $amp_function Callback/function name that returns whether current request is AMP.
	 * @return void
	 */
	private static function _maybe_amp( $amp_function ) {
		if ( is_admin() ) {
			return;
		}
		// phpcs:ignore WordPress.Security.NonceVerification.Recommended
		if ( ! isset( $_GET['amp'] ) && ( ! function_exists( $amp_function ) || ! $amp_function() ) ) {
			return;
		}

		do_action( 'zinn_cache_pro_debug', '[3rd] ❌ AMP disabled page optm/lazy' );

		defined( 'ZINN_CACHE_PRO_NO_PAGEOPTM' ) || define( 'ZINN_CACHE_PRO_NO_PAGEOPTM', true );
		defined( 'ZINN_CACHE_PRO_NO_LAZY' ) || define( 'ZINN_CACHE_PRO_NO_LAZY', true );
		defined( 'ZINN_CACHE_PRO_NO_OPTM' ) || define( 'ZINN_CACHE_PRO_NO_OPTM', true );
		// defined( 'ZINN_CACHE_PRO_GUEST' ) || define( 'ZINN_CACHE_PRO_GUEST', false );
	}

	/**
	 * Ampforwp_is_amp_endpoint() from Accelerated Mobile Pages.
	 *
	 * @since 4.2
	 * @return void
	 */
	public static function maybe_acc_mob_pages() {
		self::_maybe_amp( 'ampforwp_is_amp_endpoint' );
	}

	/**
	 * Google AMP fix.
	 *
	 * @since 4.2.0.1
	 * @return void
	 */
	public static function maybe_google_amp() {
		self::_maybe_amp( 'amp_is_request' );
	}

	/**
	 * Preload hooks to detect AMP requests and turn off conflicting features.
	 *
	 * CSS async will affect AMP result and Lazyload injects JS libraries which
	 * AMP does not allow. Ensure those are disabled early on AMP endpoints.
	 *
	 * @since 2.9.8.6
	 * @access public
	 * @return void
	 */
	public static function preload() {
		add_action( 'wp', __CLASS__ . '::maybe_acc_mob_pages' );
		add_action( 'wp', __CLASS__ . '::maybe_google_amp' );

		// amp_is_request() from AMP.
		// self::maybe_amp( 'amp_is_request' );
		// add_filter( 'zinn_cache_pro_can_optm', '__return_false' );
		// do_action( 'zinn_cache_pro_conf_force', API::O_OPTM_CSS_ASYNC, false );
		// do_action( 'zinn_cache_pro_conf_force', API::O_MEDIA_LAZY, false );
		// do_action( 'zinn_cache_pro_conf_force', API::O_MEDIA_IFRAME_LAZY, false );
	}
}
