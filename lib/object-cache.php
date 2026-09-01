<?php
// phpcs:ignoreFile

/**
 * Plugin Name:       Zinn® Cache Engine - Object Cache (Drop-in)
 * Plugin URI:        https://zinndigital.com
 * Description:       Persistent object caching (Redis/Memcached) for the Zinn Digital® hosting platform.
 * Author:            Neil Lock — CEO, Zinn Digital® Ltd
 * Author URI:        https://zinndigital.com
 * License:           GPL-3.0-or-later
 *
 * Part of Zinn Cache Engine, a modified version of Zinn® Cache Engine 7.8.1.
 * Copyright (C) 2015-2026 LiteSpeed Technologies, Inc.
 * Modified by Zinn Digital® Ltd (Neil Lock, CEO); first modified release 2026-07-24.
 */

defined( 'WPINC' ) || exit;
/**
 * LiteSpeed Object Cache
 *
 * @since  1.8
 */

! defined( 'ZINN_CACHE_PRO_OBJECT_CACHE' ) && define( 'ZINN_CACHE_PRO_OBJECT_CACHE', true );

// Initialize const `ZINN_CACHE_PRO_DIR` and locate LSCWP plugin folder
$lscwp_dir = ( defined( 'WP_PLUGIN_DIR' ) ? WP_PLUGIN_DIR : WP_CONTENT_DIR . '/plugins' ) . '/zinn-cache-pro/';

// Use plugin as higher priority than MU plugin
if ( ! file_exists( $lscwp_dir . 'zinn-cache-pro.php' ) ) {
	// Check if is mu plugin or not
	$lscwp_dir = ( defined( 'WPMU_PLUGIN_DIR' ) ? WPMU_PLUGIN_DIR : WP_CONTENT_DIR . '/mu-plugins' ) . '/zinn-cache-pro/';
	if ( ! file_exists( $lscwp_dir . 'zinn-cache-pro.php' ) ) {
		$lscwp_dir = '';
	}
}

$data_file = WP_CONTENT_DIR . '/.zinn_cache_pro_conf.dat';
$lib_file  = $lscwp_dir . 'src/object.lib.php';

// Can't find LSCWP location, terminate object cache process
if ( ! $lscwp_dir || ! file_exists( $data_file ) || ( ! file_exists( $lib_file ) ) ) {
	if ( ! is_admin() ) { // Bypass object cache for frontend
		require_once ABSPATH . WPINC . '/cache.php';
	} else {
		$err = 'Can NOT find LSCWP path for object cache initialization in ' . __FILE__;
		error_log( $err );
		add_action(
			is_network_admin() ? 'network_admin_notices' : 'admin_notices',
			function () use ( &$err ) {
				echo $err;
			}
		);
	}
} elseif ( ! ZINN_CACHE_PRO_OBJECT_CACHE ) {
	// Disable cache
		wp_using_ext_object_cache( false );
}
	// Init object cache & LSCWP
elseif ( file_exists( $lib_file ) ) {
	require_once $lib_file;
}
