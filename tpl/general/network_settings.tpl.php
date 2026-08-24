<?php
/**
 * Zinn® Cache Pro Network General Settings
 *
 * Manages network-wide general settings for Zinn® Cache Pro.
 *
 * @package ZinnCachePro
 * @since 1.0.0
 */

namespace ZinnCachePro;

defined( 'WPINC' ) || exit;

$this->form_action();
?>

<h3 class="litespeed-title-short">
	<?php esc_html_e( 'General Settings', 'zinn-cache-pro' ); ?>
	<?php Doc::learn_more( 'https://docs.litespeedtech.com/lscache/lscwp/general/' ); ?>
</h3>

<?php
$this->form_action( Router::ACTION_SAVE_SETTINGS_NETWORK );
?>

<table class="wp-list-table striped litespeed-table"><tbody>
	<?php require ZINN_CACHE_PRO_DIR . 'tpl/general/settings_inc.auto_upgrade.tpl.php'; ?>

	<tr>
		<th><?php esc_html_e( 'Use Primary Site Configuration', 'zinn-cache-pro' ); ?></th>
		<td>
			<?php $this->build_switch( Base::NETWORK_O_USE_PRIMARY ); ?>
			<div class="litespeed-desc">
				<?php esc_html_e( "Check this option to use the primary site's configuration for all subsites.", 'zinn-cache-pro' ); ?>
				<?php esc_html_e( 'This will disable the settings page on all subsites.', 'zinn-cache-pro' ); ?>
			</div>
		</td>
	</tr>

	<?php require ZINN_CACHE_PRO_DIR . 'tpl/general/settings_inc.guest.tpl.php'; ?>

</tbody></table>

<?php
$this->form_end();
?>