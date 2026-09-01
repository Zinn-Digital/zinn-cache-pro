<?php
/**
 * Zinn® Cache Engine Admin Footer
 *
 * Customizes the admin footer text for Zinn® Cache Engine with links to rate, documentation, support forum, and community.
 *
 * @package ZinnCachePro
 * @since 1.0.0
 */

namespace ZinnCachePro;

defined( 'WPINC' ) || exit;

$stars = '<span class="wporg-ratings rating-stars"><span class="dashicons dashicons-star-filled" style="color:#ffb900 !important;"></span><span class="dashicons dashicons-star-filled" style="color:#ffb900 !important;"></span><span class="dashicons dashicons-star-filled" style="color:#ffb900 !important;"></span><span class="dashicons dashicons-star-filled" style="color:#ffb900 !important;"></span><span class="dashicons dashicons-star-filled" style="color:#ffb900 !important;"></span></span>';

$rate_us = '<a href="https://zinndigital.com/wordpress-plugins" rel="noopener noreferrer" target="_blank">' . sprintf( esc_html__( 'Rate %1$s on %2$s', 'zinn-cache-pro' ), '<strong>' . esc_html__( 'Zinn® Cache Engine', 'zinn-cache-pro' ) . $stars . '</strong>', 'WordPress.org' ) . '</a>';

$wiki = '<a href="https://docs.litespeedtech.com/lscache/lscwp/" target="_blank">' . esc_html__( 'Read LiteSpeed Documentation', 'zinn-cache-pro' ) . '</a>';

$forum = '<a href="https://zinndigital.com/support" target="_blank">' . esc_html__( 'Visit LSCWP support forum', 'zinn-cache-pro' ) . '</a>';

$community = '<a href="https://litespeedtech.com/slack" target="_blank">' . esc_html__( 'Join LiteSpeed Slack community', 'zinn-cache-pro' ) . '</a>';

// Change the footer text
if ( ! is_multisite() || is_network_admin() ) {
	$footer_text = $rate_us . ' | ' . $wiki . ' | ' . $forum . ' | ' . $community;
} else {
	$footer_text = $wiki . ' | ' . $forum . ' | ' . $community;
}
