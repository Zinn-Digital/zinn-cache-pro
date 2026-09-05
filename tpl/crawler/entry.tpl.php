<?php
/**
 * Zinn® Cache Engine Crawler Settings
 *
 * @package ZinnCachePro
 * @since 1.0.0
 */

namespace ZinnCachePro;

defined( 'WPINC' ) || exit;

$menu_list = [
	'summary'   => esc_html__( 'Summary', 'zinn-cache-pro' ),
	'map'       => esc_html__( 'Map', 'zinn-cache-pro' ),
	'blacklist' => esc_html__( 'Blocklist', 'zinn-cache-pro' ),
	'settings'  => esc_html__( 'Settings', 'zinn-cache-pro' ),
];
?>

<div class="wrap">
	<h1 class="litespeed-h1">
		<?php esc_html_e( 'Zinn® Cache Engine Crawler', 'zinn-cache-pro' ); ?>
	</h1>
	<span class="litespeed-desc">
		<?php echo esc_html( 'v' . \ZinnCachePro\Zinn\display_version() ); ?>
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
			require ZINN_CACHE_PRO_DIR . "tpl/crawler/$menu_key.tpl.php";
			echo '</div>';
		}
		?>
	</div>
</div>

<iframe name="litespeedHiddenIframe" src="" width="0" height="0" frameborder="0"></iframe>
