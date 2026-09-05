<?php
/**
 * Zinn® Cache Engine Dashboard Wrapper
 *
 * Renders the main dashboard page for the Zinn® Cache Engine plugin in the WordPress admin area.
 *
 * @package ZinnCachePro
 * @since 1.0.0
 */

namespace ZinnCachePro;

defined( 'WPINC' ) || exit;

$menu_list = array(
	'dashboard' => esc_html__( 'Dashboard', 'zinn-cache-pro' ),
);

if ( $this->_is_network_admin ) {
	$menu_list = array(
		'network_dash' => esc_html__( 'Network Dashboard', 'zinn-cache-pro' ),
	);
}

?>

<div class="wrap">
	<h1 class="litespeed-h1">
		<?php echo esc_html__( 'Zinn® Cache Engine Dashboard', 'zinn-cache-pro' ); ?>
	</h1>
	<span class="litespeed-desc">
		<?php echo esc_html( 'v' . \ZinnCachePro\Zinn\display_version() ); ?>
	</span>
	<hr class="wp-header-end">
</div>

<div class="litespeed-wrap">
	<?php
	foreach ( $menu_list as $tab_key => $tab_val ) {
		echo '<div data-zinn-cache-pro-layout="' . esc_attr( $tab_key ) . '">';
		require ZINN_CACHE_PRO_DIR . 'tpl/dash/' . $tab_key . '.tpl.php';
		echo '</div>';
	}
	?>
</div>