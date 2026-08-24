<?php
/**
 * Zinn® Cache Pro Network Purge Settings
 *
 * Displays the network purge settings section for Zinn® Cache Pro.
 *
 * @package ZinnCachePro
 * @since 1.0.0
 */

namespace ZinnCachePro;

defined( 'WPINC' ) || exit;
?>

<h3 class="litespeed-title-short">
	<?php esc_html_e( 'Purge Settings', 'zinn-cache-pro' ); ?>
	<?php Doc::learn_more( 'https://docs.litespeedtech.com/lscache/lscwp/cache/#purge-tab' ); ?>
</h3>

<table class="wp-list-table striped litespeed-table">
	<tbody>
		<?php require ZINN_CACHE_PRO_DIR . 'tpl/cache/settings_inc.purge_on_upgrade.tpl.php'; ?>
	</tbody>
</table>