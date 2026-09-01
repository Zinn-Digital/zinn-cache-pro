<?php
/**
 * Zinn® Cache Engine General Settings
 *
 * Manages general settings interface for Zinn® Cache Engine.
 *
 * @package ZinnCachePro
 * @since 1.0.0
 */

namespace ZinnCachePro;

defined( 'WPINC' ) || exit;

$menu_list = array(
    'settings'        => esc_html__( 'General Settings', 'zinn-cache-pro' ),
);

if ( is_network_admin() ) {
    $menu_list = array(
        'network_settings' => esc_html__( 'General Settings', 'zinn-cache-pro' ),
    );
}

?>

<div class="wrap">
    <h1 class="litespeed-h1">
        <?php esc_html_e( 'Zinn® Cache Engine General Settings', 'zinn-cache-pro' ); ?>
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
        foreach ( $menu_list as $menu_key => $val ) {
            echo '<div data-zinn-cache-pro-layout="' . esc_attr( $menu_key ) . '">';
            require ZINN_CACHE_PRO_DIR . 'tpl/general/' . $menu_key . '.tpl.php';
            echo '</div>';
        }
        ?>
    </div>

</div>