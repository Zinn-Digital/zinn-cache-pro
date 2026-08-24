<?php
/**
 * Zinn® Cache Pro Configuration Presets
 *
 * Renders the configuration presets interface for Zinn® Cache Pro, including standard presets and import/export functionality.
 *
 * @package ZinnCachePro
 * @since 1.0.0
 */

namespace ZinnCachePro;

defined( 'WPINC' ) || exit;

$menu_list = array(
	'standard'      => esc_html__( 'Standard Presets', 'zinn-cache-pro' ),
	'import_export' => esc_html__( 'Import / Export', 'zinn-cache-pro' ),
);
?>

<div class="wrap">
	<h1 class="litespeed-h1">
		<?php esc_html_e( 'Zinn® Cache Pro Configuration Presets', 'zinn-cache-pro' ); ?>
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
		<?php
		foreach ( $menu_list as $curr_tab => $val ) :
			?>
			<div data-zinn-cache-pro-layout="<?php echo esc_attr( $curr_tab ); ?>">
				<?php
				if ( 'import_export' === $curr_tab ) {
					require ZINN_CACHE_PRO_DIR . "tpl/toolbox/$curr_tab.tpl.php";
				} else {
					require ZINN_CACHE_PRO_DIR . "tpl/presets/$curr_tab.tpl.php";
				}
				?>
			</div>
			<?php
		endforeach;
		?>
	</div>
</div>