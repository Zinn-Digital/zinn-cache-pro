<?php
/**
 * Zinn® Cache Engine Database Login Cookie Notice
 *
 * Displays a notice about mismatched login cookies for Zinn® Cache Engine.
 *
 * @package ZinnCachePro
 * @since 1.0.0
 */

namespace ZinnCachePro;

defined('WPINC') || exit();

$err =
	esc_html__('NOTICE: Database login cookie did not match your login cookie.', 'zinn-cache-pro') .
	' ' .
	esc_html__('If the login cookie was recently changed in the settings, please log out and back in.', 'zinn-cache-pro') .
	' ' .
	sprintf(
		esc_html__('If not, please verify the setting in the %sAdvanced tab%s.', 'zinn-cache-pro'),
		"<a href='" . esc_url(admin_url('admin.php?page=zinn-cache-pro-cache#advanced')) . '">',
		'</a>'
	);

if (ZINN_CACHE_PRO_SERVER_TYPE === 'ZINN_CACHE_PRO_SERVER_OLS') {
	$err .= ' ' . esc_html__('If using OpenLiteSpeed, the server must be restarted once for the changes to take effect.', 'zinn-cache-pro');
}

self::add_notice(self::NOTICE_YELLOW, $err);
