<?php
/**
 * Zinn® Cache Engine Network Cache Settings
 *
 * Displays the network cache control settings section for Zinn® Cache Engine.
 *
 * @package ZinnCachePro
 * @since 1.0.0
 */

namespace ZinnCachePro;

defined( 'WPINC' ) || exit;
?>

<h3 class="litespeed-title-short">
	<?php esc_html_e( 'Cache Control Settings', 'zinn-cache-pro' ); ?>
	<?php Doc::learn_more( 'https://docs.litespeedtech.com/lscache/lscwp/cache/' ); ?>
</h3>

<table class="wp-list-table striped litespeed-table">
	<tbody>
		<tr>
			<th><?php esc_html_e( 'Network Enable Cache', 'zinn-cache-pro' ); ?></th>
			<td>
				<?php $this->build_switch( Base::O_CACHE ); ?>
				<div class="litespeed-desc">
					<?php esc_html_e( 'Enabling Zinn® Cache Engine for WordPress here enables the cache for the network.', 'zinn-cache-pro' ); ?><br />
					<?php esc_html_e( 'It is STRONGLY recommended that the compatibility with other plugins on a single/few sites is tested first.', 'zinn-cache-pro' ); ?><br />
					<?php esc_html_e( 'This is to ensure compatibility prior to enabling the cache for all sites.', 'zinn-cache-pro' ); ?>
				</div>
			</td>
		</tr>

		<?php
		require ZINN_CACHE_PRO_DIR . 'tpl/cache/settings_inc.cache_mobile.tpl.php';
		require ZINN_CACHE_PRO_DIR . 'tpl/cache/settings_inc.cache_dropquery.tpl.php';
		?>
	</tbody>
</table>