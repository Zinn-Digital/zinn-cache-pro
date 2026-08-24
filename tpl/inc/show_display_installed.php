<?php
/**
 * Zinn® Cache Pro Installation Notice
 *
 * Displays a notice informing users that the Zinn® Cache Pro plugin was installed by the server admin.
 *
 * @package ZinnCachePro
 * @since 1.0.0
 */

namespace ZinnCachePro;

defined( 'WPINC' ) || exit;

$buf  = sprintf(
	'<h3>%s</h3>
	<p>%s</p>
	<p>%s</p>
	<p>%s</p>
	<p>%s</p>
	<p>%s</p>
	<ul>
		<li>%s</li>
		<li>%s</li>
	</ul>',
	esc_html__( 'Zinn® Cache Pro plugin is installed!', 'zinn-cache-pro' ),
	esc_html__( 'This message indicates that the plugin was installed by the server admin.', 'zinn-cache-pro' ),
	esc_html__( 'The Zinn® Cache Pro plugin is used to cache pages - a simple way to improve the performance of the site.', 'zinn-cache-pro' ),
	esc_html__( 'However, there is no way of knowing all the possible customizations that were implemented.', 'zinn-cache-pro' ),
	esc_html__( 'For that reason, please test the site to make sure everything still functions properly.', 'zinn-cache-pro' ),
	esc_html__( 'Examples of test cases include:', 'zinn-cache-pro' ),
	esc_html__( 'Visit the site while logged out.', 'zinn-cache-pro' ),
	esc_html__( 'Create a post, make sure the front page is accurate.', 'zinn-cache-pro' )
);
$buf .= sprintf(
	/* translators: %s: Link tags */
	esc_html__( 'If there are any questions, the team is always happy to answer any questions on the %ssupport forum%s.', 'zinn-cache-pro' ),
	'<a href="https://wordpress.org/support/plugin/zinn-cache-pro" rel="noopener noreferrer" target="_blank">',
	'</a>'
);
$buf .= '<p>' . esc_html__( 'If you would rather not move at litespeed, you can deactivate this plugin.', 'zinn-cache-pro' ) . '</p>';

self::add_notice( self::NOTICE_BLUE . ' lscwp-whm-notice', $buf );
