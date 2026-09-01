<?php
/**
 * Zinn® Cache Engine Advanced Settings
 *
 * Displays the advanced settings section for Zinn® Cache Engine.
 *
 * @package ZinnCachePro
 * @since 1.0.0
 */

namespace ZinnCachePro;

defined( 'WPINC' ) || exit;
?>

<h3 class="litespeed-title-short">
	<?php esc_html_e( 'Advanced Settings', 'zinn-cache-pro' ); ?>
	<?php Doc::learn_more( 'https://docs.litespeedtech.com/lscache/lscwp/cache/#advanced-tab' ); ?>
</h3>

<table class="wp-list-table striped litespeed-table">
	<tbody>
		<?php require ZINN_CACHE_PRO_DIR . 'tpl/cache/settings_inc.login_cookie.tpl.php'; ?>
	</tbody>
</table>