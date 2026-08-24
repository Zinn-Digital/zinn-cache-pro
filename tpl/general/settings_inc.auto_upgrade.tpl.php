<?php
/**
 * Zinn® Cache Pro Auto Upgrade Setting
 *
 * Manages the auto-upgrade setting for Zinn® Cache Pro.
 *
 * @package ZinnCachePro
 * @since 1.0.0
 */

namespace ZinnCachePro;

defined( 'WPINC' ) || exit;
?>

	<!-- build_setting_auto_upgrade -->
	<tr>
		<th>
			<?php $option_id = Base::O_AUTO_UPGRADE; ?>
			<?php $this->title( $option_id ); ?>
		</th>
		<td>
			<?php $this->build_switch( $option_id ); ?>
			<div class="litespeed-desc">
				<?php esc_html_e( 'Turn this option ON to have Zinn® Cache Pro updated automatically, whenever a new version is released. If OFF, update manually as usual.', 'zinn-cache-pro' ); ?>
			</div>
		</td>
	</tr>