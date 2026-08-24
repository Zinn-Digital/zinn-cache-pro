<?php
/**
 * Zinn® Cache Pro Toolbox
 *
 * Renders the toolbox interface for Zinn® Cache Pro, providing access to various administrative tools and settings.
 *
 * @package ZinnCachePro
 * @since 1.0.0
 */

namespace ZinnCachePro;

defined( 'WPINC' ) || exit;

$menu_list = array(
	'purge' => esc_html__( 'Purge', 'zinn-cache-pro' ),
);

if ( ! $this->_is_network_admin ) {
	$menu_list['import_export'] = esc_html__( 'Import / Export', 'zinn-cache-pro' );
}

if ( ! $this->_is_multisite || $this->_is_network_admin ) {
	$menu_list['edit_htaccess'] = esc_html__( 'View .htaccess', 'zinn-cache-pro' );
}

if ( ! $this->_is_network_admin ) {
	$menu_list['heartbeat'] = esc_html__( 'Heartbeat', 'zinn-cache-pro' );
}

if ( ! $this->_is_multisite || $this->_is_network_admin ) {
	$menu_list['settings-debug'] = esc_html__( 'Debug Settings', 'zinn-cache-pro' );
	$menu_list['log_viewer']     = esc_html__( 'Log View', 'zinn-cache-pro' );
}
?>

<div class="wrap">
	<h1 class="litespeed-h1">
		<?php esc_html_e( 'Zinn® Cache Pro Toolbox', 'zinn-cache-pro' ); ?>
	</h1>
	<span class="litespeed-desc">
		v<?php echo esc_html( Core::VER ); ?>
	</span>
	<hr class="wp-header-end">
</div>

<div class="litespeed-wrap">
	<h2 class="litespeed-header nav-tab-wrapper">
		<?php GUI::display_tab_list( $menu_list ); ?>
	</h2>

	<div class="litespeed-body">
		<?php foreach ( $menu_list as $curr_tab => $val ) : ?>
			<div data-zinn-cache-pro-layout="<?php echo esc_attr( $curr_tab ); ?>">
				<?php require ZINN_CACHE_PRO_DIR . "tpl/toolbox/$curr_tab.tpl.php"; ?>
			</div>
		<?php endforeach; ?>
	</div>
</div>