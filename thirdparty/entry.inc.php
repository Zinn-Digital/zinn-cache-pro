<?php
/**
 * The registry for Third Party Plugins Integration files.
 *
 * This file is only used to include the integration files/classes.
 * This works as an entry point for the initial add_action for the
 * detect function.
 *
 * It is not required to add all integration files here, this just provides
 * a common place for plugin authors to append their file to.
 *
 * @package ZinnCachePro
 * @subpackage LiteSpeed_Cache/thirdparty
 */

defined('WPINC') || exit();

$third_cls = array(
	'Aelia_CurrencySwitcher',
	'Autoptimize',
	'Avada',
	'BBPress',
	'Beaver_Builder',
	'Caldera_Forms',
	'Divi_Theme_Builder',
	'Facetwp',
	'LiteSpeed_Check',
	'Theme_My_Login',
	'User_Switching',
	'WCML',
	'WooCommerce',
	'WC_PDF_Product_Vouchers',
	'Woo_Paypal',
	'Wp_Polls',
	'WP_PostRatings',
	'Wpdiscuz',
	'WPLister',
	'WPML',
	'WpTouch',
	'Yith_Wishlist',
);

foreach ($third_cls as $cls) {
	add_action('zinn_cache_pro_load_thirdparty', 'ZinnCachePro\Thirdparty\\' . $cls . '::detect');
}

// Preload needed for certain thirdparty
add_action('zinn_cache_pro_init', 'ZinnCachePro\Thirdparty\Divi_Theme_Builder::preload');
add_action('zinn_cache_pro_init', 'ZinnCachePro\Thirdparty\WooCommerce::preload');
add_action('zinn_cache_pro_init', 'ZinnCachePro\Thirdparty\NextGenGallery::preload');
add_action('zinn_cache_pro_init', 'ZinnCachePro\Thirdparty\AMP::preload');
add_action('zinn_cache_pro_init', 'ZinnCachePro\Thirdparty\Elementor::preload');
add_action('zinn_cache_pro_init', 'ZinnCachePro\Thirdparty\Gravity_Forms::preload');
add_action('zinn_cache_pro_init', 'ZinnCachePro\Thirdparty\Perfmatters::preload');
