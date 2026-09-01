<?php
/**
 * Zinn® Cache Engine Network Exclude Settings
 *
 * Displays the network exclude settings section for Zinn® Cache Engine.
 *
 * @package ZinnCachePro
 * @since 1.0.0
 */

namespace ZinnCachePro;

defined( 'WPINC' ) || exit;
?>

<h3 class="litespeed-title-short">
	<?php esc_html_e( 'Exclude Settings', 'zinn-cache-pro' ); ?>
	<?php Doc::learn_more( 'https://docs.litespeedtech.com/lscache/lscwp/cache/#excludes-tab' ); ?>
</h3>

<table class="wp-list-table striped litespeed-table">
	<tbody>
		<?php
		// Cookie
		require ZINN_CACHE_PRO_DIR . 'tpl/cache/settings_inc.exclude_cookies.tpl.php';

		// User Agent
		require ZINN_CACHE_PRO_DIR . 'tpl/cache/settings_inc.exclude_useragent.tpl.php';
		?>
	</tbody>
</table>