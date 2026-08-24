<?php
/**
 * The Third Party integration with WooCommerce PayPal Checkout Gateway.
 *
 * @ref https://wordpress.org/plugins/woocommerce-gateway-paypal-express-checkout/
 *
 * @since 3.0
 * @package ZinnCachePro
 * @subpackage LiteSpeed_Cache\Thirdparty
 */

namespace ZinnCachePro\Thirdparty;

defined('WPINC') || exit();

/**
 * Provides compatibility with WooCommerce PayPal Checkout.
 */
class Woo_Paypal {

	/**
	 * Detect if WooCommerce PayPal Checkout is active and register nonces.
	 *
	 * @since 3.0
	 * @access public
	 * @return void
	 */
	public static function detect() {
		if (!defined('WC_GATEWAY_PPEC_VERSION')) {
			return;
		}

		do_action('zinn_cache_pro_nonce', '_wc_ppec_update_shipping_costs_nonce private');
		do_action('zinn_cache_pro_nonce', '_wc_ppec_start_checkout_nonce private');
		do_action('zinn_cache_pro_nonce', '_wc_ppec_generate_cart_nonce private');
	}
}
