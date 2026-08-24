<?php
/**
 * Plugin Name:       Zinn® Cache Pro
 * Plugin URI:        https://zinndigital.com
 * Description:       High-performance server-side caching for the Zinn Digital® hosting platform: full-page cache, object cache, database optimisation and CSS/JS optimisation. A GPLv3 fork of the LiteSpeed Cache plugin; requires a LiteSpeed or OpenLiteSpeed server with the LSCache module for full-page caching.
 * Version:           1.0.0
 * Author:            Neil Lock — CEO, Zinn Digital® Ltd
 * Author URI:        https://zinndigital.com
 * License:           GPL-3.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-3.0.html
 * Text Domain:       zinn-cache-pro
 * Domain Path:       /languages
 * Requires at least: 6.6
 * Requires PHP:      8.2
 * Update URI:        https://zinndigital.com
 *
 * @package ZinnCachePro
 *
 * Copyright (C) 2015-2026 LiteSpeed Technologies, Inc.
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 * Zinn Cache Pro is a modified version of LiteSpeed Cache 7.8.1 by LiteSpeed Technologies, Inc.
 * Modified by Zinn Digital® Ltd (Neil Lock, CEO). First modified release: 2026-07-24.
 * The modifications are itemised in CHANGES-FROM-UPSTREAM.md; third-party components and their
 * licences are listed in THIRD-PARTY-NOTICES.md.
 *
 * LiteSpeed, LSCache, OpenLiteSpeed and QUIC.cloud are trademarks of LiteSpeed Technologies, Inc.
 * Zinn Cache Pro is an independent fork and is not affiliated with, endorsed by, or supported by
 * LiteSpeed Technologies, Inc.
 */

defined( 'WPINC' ) || exit();

if ( defined( 'ZINN_CACHE_PRO_V' ) ) {
	return;
}

! defined( 'ZINN_CACHE_PRO_V' ) && define( 'ZINN_CACHE_PRO_V', '7.8.1' );

! defined( 'ZINN_CACHE_PRO_CONTENT_DIR' ) && define( 'ZINN_CACHE_PRO_CONTENT_DIR', WP_CONTENT_DIR );
! defined( 'ZINN_CACHE_PRO_DIR' ) && define( 'ZINN_CACHE_PRO_DIR', __DIR__ . '/' ); // Full absolute path '/var/www/html/***/wp-content/plugins/zinn-cache-pro/' or MU
! defined( 'ZINN_CACHE_PRO_BASENAME' ) && define( 'ZINN_CACHE_PRO_BASENAME', 'zinn-cache-pro/zinn-cache-pro.php' ); // ZINN_CACHE_PRO_BASENAME='zinn-cache-pro/zinn-cache-pro.php'

/**
 * This needs to be before activation because admin-rules.class.php need const `ZINN_CACHE_PRO_CONTENT_FOLDER`
 * This also needs to be before cfg.cls init because default cdn_included_dir needs `ZINN_CACHE_PRO_CONTENT_FOLDER`
 *
 * @since  5.2 Auto correct protocol for CONTENT URL
 */
$wp_content_url = WP_CONTENT_URL;
$site_url       = site_url( '/' );
if ( 'http:' === substr( $wp_content_url, 0, 5 ) && 'https' === substr( $site_url, 0, 5 ) ) {
	$wp_content_url = str_replace( 'http://', 'https://', $wp_content_url );
}
! defined( 'ZINN_CACHE_PRO_CONTENT_FOLDER' ) && define( 'ZINN_CACHE_PRO_CONTENT_FOLDER', str_replace( $site_url, '', $wp_content_url ) ); // `wp-content`
unset( $site_url );
! defined( 'ZINN_CACHE_PRO_PLUGIN_URL' ) && define( 'ZINN_CACHE_PRO_PLUGIN_URL', plugin_dir_url( __FILE__ ) ); // Full URL path '//example.com/wp-content/plugins/zinn-cache-pro/'

/**
 * Static cache files consts
 *
 * @since  3.0
 */
! defined( 'ZINN_CACHE_PRO_DATA_FOLDER' ) && define( 'ZINN_CACHE_PRO_DATA_FOLDER', 'zinn-cache-pro' );
! defined( 'ZINN_CACHE_PRO_STATIC_URL' ) && define( 'ZINN_CACHE_PRO_STATIC_URL', $wp_content_url . '/' . ZINN_CACHE_PRO_DATA_FOLDER ); // Full static cache folder URL '//example.com/wp-content/litespeed'
unset( $wp_content_url );
! defined( 'ZINN_CACHE_PRO_STATIC_DIR' ) && define( 'ZINN_CACHE_PRO_STATIC_DIR', ZINN_CACHE_PRO_CONTENT_DIR . '/' . ZINN_CACHE_PRO_DATA_FOLDER ); // Full static cache folder path '/var/www/html/***/wp-content/litespeed'

! defined( 'ZINN_CACHE_PRO_TIME_OFFSET' ) && define( 'ZINN_CACHE_PRO_TIME_OFFSET', get_option( 'gmt_offset' ) * 60 * 60 );

// Placeholder for lazyload img
! defined( 'ZINN_CACHE_PRO_PLACEHOLDER' ) && define( 'ZINN_CACHE_PRO_PLACEHOLDER', 'data:image/gif;base64,R0lGODdhAQABAPAAAMPDwwAAACwAAAAAAQABAAACAkQBADs=' );

// Auto register LiteSpeed classes
require_once ZINN_CACHE_PRO_DIR . 'autoload.php';

// Define CLI
if ( ( defined( 'WP_CLI' ) && constant('WP_CLI') ) || 'cli' === PHP_SAPI ) {
	! defined( 'ZINN_CACHE_PRO_CLI' ) && define( 'ZINN_CACHE_PRO_CLI', true );

	// Register CLI cmd
	if ( method_exists( 'WP_CLI', 'add_command' ) ) {
		WP_CLI::add_command( 'zinn-cache-pro-option', 'ZinnCachePro\CLI\Option' );
		WP_CLI::add_command( 'zinn-cache-pro-purge', 'ZinnCachePro\CLI\Purge' );
		WP_CLI::add_command( 'zinn-cache-pro-image', 'ZinnCachePro\CLI\Image' );
		WP_CLI::add_command( 'zinn-cache-pro-debug', 'ZinnCachePro\CLI\Debug' );
		WP_CLI::add_command( 'zinn-cache-pro-presets', 'ZinnCachePro\CLI\Presets' );
		WP_CLI::add_command( 'zinn-cache-pro-crawler', 'ZinnCachePro\CLI\Crawler' );
		WP_CLI::add_command( 'zinn-cache-pro-database', 'ZinnCachePro\CLI\Database' );
	}
}

// Server type
if ( ! defined( 'ZINN_CACHE_PRO_SERVER_TYPE' ) ) {
	$http_x_lscache  = isset( $_SERVER['HTTP_X_LSCACHE'] ) ? sanitize_text_field( wp_unslash( $_SERVER['HTTP_X_LSCACHE'] ) ) : '';
	$lsws_edition    = isset( $_SERVER['LSWS_EDITION'] ) ? sanitize_text_field( wp_unslash( $_SERVER['LSWS_EDITION'] ) ) : '';
	$server_software = isset( $_SERVER['SERVER_SOFTWARE'] ) ? sanitize_text_field( wp_unslash( $_SERVER['SERVER_SOFTWARE'] ) ) : '';

	if ( $http_x_lscache ) {
		define( 'ZINN_CACHE_PRO_SERVER_TYPE', 'ZINN_CACHE_PRO_SERVER_ADC' );
	} elseif ( 0 === strpos( $lsws_edition, 'Openlitespeed' ) ) {
		define( 'ZINN_CACHE_PRO_SERVER_TYPE', 'ZINN_CACHE_PRO_SERVER_OLS' );
	} elseif ( 'LiteSpeed' === $server_software ) {
		define( 'ZINN_CACHE_PRO_SERVER_TYPE', 'ZINN_CACHE_PRO_SERVER_ENT' );
	} else {
		define( 'ZINN_CACHE_PRO_SERVER_TYPE', 'NONE' );
	}
}

// Checks if caching is allowed via server variable
if ( ! empty( $_SERVER['X-LSCACHE'] ) || 'ZINN_CACHE_PRO_SERVER_ADC' === ZINN_CACHE_PRO_SERVER_TYPE || defined( 'ZINN_CACHE_PRO_CLI' ) ) {
	! defined( 'ZINN_CACHE_PRO_ALLOWED' ) && define( 'ZINN_CACHE_PRO_ALLOWED', true );
}

// ESI const definition
if ( ! defined( 'ZINN_CACHE_PRO_ESI_SUPPORT' ) ) {
	define( 'ZINN_CACHE_PRO_ESI_SUPPORT', ZINN_CACHE_PRO_SERVER_TYPE !== 'ZINN_CACHE_PRO_SERVER_OLS' );
}

if ( ! defined( 'ZINN_CACHE_PRO_TAG_PREFIX' ) ) {
	define( 'ZINN_CACHE_PRO_TAG_PREFIX', substr( md5( ZINN_CACHE_PRO_DIR ), -3 ) );
}

if ( ! function_exists( 'zinn_cache_pro_exception_handler' ) ) {
	/**
	 * Handle exception
	 *
	 * @param int    $errno   Error number.
	 * @param string $errstr  Error string.
	 * @param string $errfile Error file.
	 * @param int    $errline Error line.
	 * @throws \ErrorException When an error is encountered.
	 */
	function zinn_cache_pro_exception_handler( $errno, $errstr, $errfile, $errline ) {
		throw new \ErrorException(
			esc_html( $errstr ),
			0,
			absint( $errno ),
			esc_html( $errfile ),
			absint( $errline )
		);
	}
}

if ( ! function_exists( 'zinn_cache_pro_define_nonce_func' ) ) {
	/**
	 * Overwrite the WP nonce funcs outside of LiteSpeed namespace
	 *
	 * @since  3.0
	 */
	function zinn_cache_pro_define_nonce_func() {
		/**
		 * If the nonce is in none_actions filter, convert it to ESI
		 *
		 * @param mixed $action Action name or -1.
		 * @return string
		 */
		function wp_create_nonce( $action = -1 ) {
			if ( ! defined( 'ZINN_CACHE_PRO_DISABLE_ALL' ) || ! ZINN_CACHE_PRO_DISABLE_ALL ) {
				$control = \ZinnCachePro\ESI::cls()->is_nonce_action( $action );
				if ( null !== $control ) {
					$params = array(
						'action' => $action,
					);
					return \ZinnCachePro\ESI::cls()->sub_esi_block( 'nonce', 'wp_create_nonce ' . $action, $params, $control, true, true, true );
				}
			}

			return wp_create_nonce_zinn_cache_pro_esi( $action );
		}

		/**
		 * Ori WP wp_create_nonce
		 *
		 * @param mixed $action Action name or -1.
		 * @return string
		 */
		function wp_create_nonce_zinn_cache_pro_esi( $action = -1 ) {
			$uid = get_current_user_id();
			if ( ! $uid ) {
				/** This filter is documented in wp-includes/pluggable.php */
				$uid = apply_filters( 'nonce_user_logged_out', $uid, $action );
			}

			$token = wp_get_session_token();
			$i     = wp_nonce_tick();

			return substr( wp_hash( $i . '|' . $action . '|' . $uid . '|' . $token, 'nonce' ), -12, 10 );
		}
	}
}

if ( ! function_exists( 'run_zinn_cache_pro' ) ) {
	/**
	 * Begins execution of the plugin.
	 *
	 * @since    1.0.0
	 */
	function run_zinn_cache_pro() {
		// Check minimum PHP requirements, which is 8.2 at the moment.
		if ( version_compare( PHP_VERSION, '8.2.0', '<' ) ) {
			return;
		}

		// Check minimum WP requirements, which is 6.6 at the moment.
		if ( version_compare( $GLOBALS['wp_version'], '6.6', '<' ) ) {
			return;
		}

		\ZinnCachePro\Core::cls();
	}

	run_zinn_cache_pro();
}

/*
 * Zinn integration layer — added by this fork, not present upstream.
 *
 * Loaded last, after upstream has finished bootstrapping, so it cannot change how the cache
 * engine starts. It registers the bundled-translation loader (upstream never calls
 * load_plugin_textdomain at all, because as a wordpress.org plugin it relies on language packs
 * a fork will never receive) and keeps wordpress.org from overwriting this plugin.
 */
require_once __DIR__ . '/zinn/bootstrap.php';
