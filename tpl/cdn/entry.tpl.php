<?php
/**
 * Zinn® Cache Pro CDN Settings
 *
 * @package ZinnCachePro
 * @since 1.0.0
 */

namespace ZinnCachePro;

defined( 'WPINC' ) || exit;

$menu_list = array(
	'cf'    => esc_html__( 'Cloudflare', 'zinn-cache-pro' ),
	'other' => esc_html__( 'Other Static CDN', 'zinn-cache-pro' ),
);
?>

<div class="wrap">
	<h1 class="litespeed-h1">
		<?php esc_html_e( 'Zinn® Cache Pro CDN', 'zinn-cache-pro' ); ?>
	</h1>
	<span class="litespeed-desc">
		<?php echo esc_html( 'v' . Core::VER ); ?>
	</span>
	<hr class="wp-header-end">
</div>

<div class="litespeed-wrap">
	<h2 class="litespeed-header nav-tab-wrapper">
		<?php GUI::display_tab_list( $menu_list ); ?>
	</h2>

	<div class="litespeed-body">
		<?php
		foreach ( $menu_list as $menu_key => $menu_value ) {
			printf(
				'<div data-zinn-cache-pro-layout="%s">',
				esc_attr( $menu_key )
			);
			require ZINN_CACHE_PRO_DIR . "tpl/cdn/$menu_key.tpl.php";
			echo '</div>';
		}
		?>
	</div>
</div>
