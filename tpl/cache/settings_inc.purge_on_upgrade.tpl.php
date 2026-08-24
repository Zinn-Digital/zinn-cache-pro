<?php
/**
 * Zinn® Cache Pro Purge on Upgrade Setting
 *
 * Displays the purge on upgrade setting for Zinn® Cache Pro.
 *
 * @package ZinnCachePro
 * @since 1.0.0
 */

namespace ZinnCachePro;

defined( 'WPINC' ) || exit;
?>

<!-- build_setting_purge_on_upgrade -->
<tr>
	<th scope="row">
		<?php $option_id = Base::O_PURGE_ON_UPGRADE; ?>
		<?php $this->title( $option_id ); ?>
	</th>
	<td>
		<?php $this->build_switch( $option_id ); ?>
		<div class="litespeed-desc">
			<?php esc_html_e( 'When enabled, the cache will automatically purge when any plugin, theme or the WordPress core is upgraded.', 'zinn-cache-pro' ); ?>
		</div>
	</td>
</tr>