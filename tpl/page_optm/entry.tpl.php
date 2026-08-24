<?php
/**
 * Zinn® Cache Pro Page Optimization Interface
 *
 * Renders the page optimization settings interface for Zinn® Cache Pro with tabbed navigation.
 *
 * @package ZinnCachePro
 * @since 1.0.0
 */

namespace ZinnCachePro;

defined( 'WPINC' ) || exit;

$menu_list = array(
	'settings_css'          => esc_html__( 'CSS Settings', 'zinn-cache-pro' ),
	'settings_js'           => esc_html__( 'JS Settings', 'zinn-cache-pro' ),
	'settings_html'         => esc_html__( 'HTML Settings', 'zinn-cache-pro' ),
	'settings_media'        => esc_html__( 'Media Settings', 'zinn-cache-pro' ),
	'settings_vpi'          => esc_html__( 'VPI', 'zinn-cache-pro' ),
	'settings_media_exc'    => esc_html__( 'Media Excludes', 'zinn-cache-pro' ),
	'settings_localization' => esc_html__( 'Localization', 'zinn-cache-pro' ),
	'settings_tuning'       => esc_html__( 'Tuning', 'zinn-cache-pro' ),
	'settings_tuning_css'   => esc_html__( 'Tuning', 'zinn-cache-pro' ) . ' - CSS',
);

?>

<div class="wrap">
	<h1 class="litespeed-h1">
		<?php esc_html_e( 'Zinn® Cache Pro Page Optimization', 'zinn-cache-pro' ); ?>
	</h1>
	<span class="litespeed-desc">
		v<?php echo esc_html( Core::VER ); ?>
	</span>
	<hr class="wp-header-end">
</div>

<div class="litespeed-wrap">

	<div class="litespeed-callout notice notice-warning inline">
		<h4><?php esc_html_e( 'NOTICE', 'zinn-cache-pro' ); ?></h4>
		<p><?php esc_html_e( 'Please test thoroughly when enabling any option in this list. After changing Minify/Combine settings, please do a Purge All action.', 'zinn-cache-pro' ); ?></p>
	</div>

	<h2 class="litespeed-header nav-tab-wrapper">
		<?php GUI::display_tab_list( $menu_list ); ?>
	</h2>

	<div class="litespeed-body">
	<?php
		$this->form_action();

		// Include all tpl for faster UE
		foreach ( $menu_list as $tab_key => $tab_val ) {
			?>
			<div data-zinn-cache-pro-layout='<?php echo esc_attr( $tab_key ); ?>'>
				<?php require ZINN_CACHE_PRO_DIR . 'tpl/page_optm/' . $tab_key . '.tpl.php'; ?>
			</div>
			<?php
		}

		$this->form_end();
	?>
	</div>

</div>