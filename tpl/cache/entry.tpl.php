<?php
/**
 * Zinn® Cache Pro Settings
 *
 * Displays the cache settings page with tabbed navigation for Zinn® Cache Pro.
 *
 * @package ZinnCachePro
 * @since 1.0.0
 */

namespace ZinnCachePro;

defined( 'WPINC' ) || exit;

if ( $this->_is_network_admin ) {
	$menu_list = array(
		'cache'    => __( 'Cache', 'zinn-cache-pro' ),
		'purge'    => __( 'Purge', 'zinn-cache-pro' ),
		'excludes' => __( 'Excludes', 'zinn-cache-pro' ),
		'object'   => __( 'Object', 'zinn-cache-pro' ),
		'browser'  => __( 'Browser', 'zinn-cache-pro' ),
		'advanced' => __( 'Advanced', 'zinn-cache-pro' ),
	);
?>

<div class="wrap">
	<h1 class="litespeed-h1">
		<?php esc_html_e( 'Zinn® Cache Pro Network Cache Settings', 'zinn-cache-pro' ); ?>
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
		<?php $this->cache_disabled_warning(); ?>

		<?php
		$this->form_action( Router::ACTION_SAVE_SETTINGS_NETWORK );

		foreach ( $menu_list as $k => $val ) {
			$k_escaped = esc_attr( $k );
			?>
			<div data-zinn-cache-pro-layout="<?php echo esc_html( $k_escaped ); ?>">
			<?php
			require ZINN_CACHE_PRO_DIR . "tpl/cache/network_settings-$k.tpl.php";
			?>
			</div>
			<?php
		}

		$this->form_end();
		?>
	</div>
</div>
<?php
	return;
}

$menu_list = array(
	'cache'    => __( 'Cache', 'zinn-cache-pro' ),
	'ttl'      => __( 'TTL', 'zinn-cache-pro' ),
	'purge'    => __( 'Purge', 'zinn-cache-pro' ),
	'excludes' => __( 'Excludes', 'zinn-cache-pro' ),
	'esi'      => __( 'ESI', 'zinn-cache-pro' ),
);

if ( ! $this->_is_multisite ) {
	$menu_list['object']  = __( 'Object', 'zinn-cache-pro' );
	$menu_list['browser'] = __( 'Browser', 'zinn-cache-pro' );
}

$menu_list['advanced'] = __( 'Advanced', 'zinn-cache-pro' );

/**
 * Generate roles for setting usage
 *
 * @since 1.6.2
 */
global $wp_roles;
$wp_orig_roles = $wp_roles;
if ( ! isset( $wp_roles ) ) {
	$wp_orig_roles = new \WP_Roles();
}

$roles = array();
foreach ( $wp_orig_roles->roles as $k => $v ) {
	$roles[ $k ] = $v['name'];
}
ksort( $roles );
?>

<div class="wrap">
	<h1 class="litespeed-h1">
		<?php esc_html_e( 'Zinn® Cache Pro Settings', 'zinn-cache-pro' ); ?>
	</h1>
	<span class="litespeed-desc">
		<?php echo esc_html( 'v' . Core::VER ); ?>
	</span>
	<hr class="wp-header-end">
</div>
<div class="litespeed-wrap">
	<h2 class="litespeed-header nav-tab-wrapper">
		<?php
		$i             = 1;
		$accesskey_set = array();
		foreach ( $menu_list as $k => $val ) {
			$accesskey = '';
			if ( $i <= 9 ) {
				$accesskey = $i;
			} else {
				$tmp = strtoupper( substr( $k, 0, 1 ) );
				if ( ! in_array( $tmp, $accesskey_set, true ) ) {
					$accesskey_set[] = $tmp;
					$accesskey       = esc_attr( $tmp );
				}
			}
			printf('<a class="litespeed-tab nav-tab" href="#%1$s" data-zinn-cache-pro-tab="%1$s" litespeed-accesskey="%2$s">%3$s</a>', esc_attr( $k ), esc_attr($accesskey), esc_html( $val ));
			++$i;
		}
		do_action( 'zinn_cache_pro_settings_tab', 'cache' );
		?>
	</h2>

	<div class="litespeed-body">
		<?php $this->cache_disabled_warning(); ?>

		<?php
		$this->form_action();

		require ZINN_CACHE_PRO_DIR . 'tpl/inc/check_if_network_disable_all.php';
		require ZINN_CACHE_PRO_DIR . 'tpl/cache/more_settings_tip.tpl.php';

		foreach ( $menu_list as $k => $val ) {
			echo '<div data-zinn-cache-pro-layout="' . esc_attr( $k ) . '">';
			require ZINN_CACHE_PRO_DIR . "tpl/cache/settings-$k.tpl.php";
			echo '</div>';
		}

		do_action( 'zinn_cache_pro_settings_content', 'cache' );

		$this->form_end();
		?>
	</div>
</div>