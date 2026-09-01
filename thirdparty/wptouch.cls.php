<?php
/**
 * The Third Party integration with the WPTouch Mobile plugin.
 *
 * Marks requests from mobile devices via WPTouch as mobile in Zinn® Cache Engine.
 *
 * @since 1.0.7
 * @package ZinnCachePro
 */

namespace ZinnCachePro\Thirdparty;

defined( 'WPINC' ) || exit();

/**
 * WPTouch integration for Zinn® Cache Engine.
 */
class WpTouch {

	/**
	 * Detects if WPTouch is installed.
	 *
	 * @since 1.0.7
	 * @return void
	 */
	public static function detect() {
		global $wptouch_pro;
		if ( isset( $wptouch_pro ) ) {
			add_action( 'zinn_cache_pro_control_finalize', __CLASS__ . '::set_control' );
		}
	}

	/**
	 * Check if the device is mobile. If so, set mobile.
	 *
	 * @since 1.0.7
	 * @return void
	 */
	public static function set_control() {
		global $wptouch_pro;
		if ( ! empty( $wptouch_pro->is_mobile_device ) ) {
			add_filter( 'zinn_cache_pro_is_mobile', '__return_true' );
		}
	}
}
