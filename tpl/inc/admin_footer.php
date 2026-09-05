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

$wiki = '<a href="https://docs.litespeedtech.com/lscache/lscwp/" target="_blank" rel="noopener noreferrer">'
	. esc_html__( 'Read the upstream Zinn® Cache Engine documentation', 'zinn-cache-pro' ) . '</a>';

$forum = '<a href="https://zinndigital.com/support" target="_blank" rel="noopener noreferrer">'
	. esc_html__( 'Zinn Digital® support', 'zinn-cache-pro' ) . '</a>';

$guide = '<a href="https://zinndigital.com/wordpress-plugins/zinn-cache-pro" target="_blank" rel="noopener noreferrer">'
	. esc_html__( 'Zinn® Cache Engine user guide', 'zinn-cache-pro' ) . '</a>';

$footer_text = $wiki . ' | ' . $forum . ' | ' . $guide;
