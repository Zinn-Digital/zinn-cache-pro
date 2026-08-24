<?php
/**
 * The Third Party integration with the Perfmatters plugin.
 *
 * @since 4.4.5
 * @package ZinnCachePro
 * @subpackage LiteSpeed_Cache\Thirdparty
 */

namespace ZinnCachePro\Thirdparty;

defined('WPINC') || exit();

/**
 * Provides compatibility for the Perfmatters plugin.
 */
class Perfmatters {

	/**
	 * Preload Perfmatters integration.
	 *
	 * @since 4.4.5
	 * @return void
	 */
	public static function preload() {
		if (!defined('PERFMATTERS_VERSION')) {
			return;
		}

		if (is_admin()) {
			return;
		}

		if (has_action('shutdown', 'perfmatters_script_manager') !== false) {
			add_action('init', __CLASS__ . '::disable_zinn_cache_pro_esi', 4);
		}
	}

	/**
	 * Disable LiteSpeed ESI when Perfmatters Script Manager is active.
	 *
	 * @since 4.4.5
	 * @return void
	 */
	public static function disable_zinn_cache_pro_esi() {
		if (!defined('ZINN_CACHE_PRO_ESI_OFF')) {
			define('ZINN_CACHE_PRO_ESI_OFF', true);
		}
		do_action('zinn_cache_pro_debug', 'Disable ESI due to Perfmatters script manager');
	}
}
