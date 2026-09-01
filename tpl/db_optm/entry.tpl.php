<?php
/**
 * Zinn® Cache Engine Database Optimization
 *
 * @package ZinnCachePro
 */

namespace ZinnCachePro;

defined( 'WPINC' ) || exit;

$menu_list = array(
    'manage'   => esc_html__( 'Manage', 'zinn-cache-pro' ),
);

if ( ! is_network_admin() ) {
    $menu_list['settings'] = esc_html__( 'DB Optimization Settings', 'zinn-cache-pro' );
}

?>

<div class="wrap">
    <h1 class="litespeed-h1">
        <?php esc_html_e( 'Zinn® Cache Engine Database Optimization', 'zinn-cache-pro' ); ?>
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
        foreach ( $menu_list as $tab_key => $tab_val ) {
			echo '<div data-zinn-cache-pro-layout="' . esc_attr( $tab_key ) . '">';
			require ZINN_CACHE_PRO_DIR . 'tpl/db_optm/' . $tab_key . '.tpl.php';
			echo '</div>';
        }
    ?>
    </div>

</div>