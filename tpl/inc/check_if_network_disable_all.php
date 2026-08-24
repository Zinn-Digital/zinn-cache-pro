<?php
/**
 * Zinn® Cache Pro Network Primary Site Configuration Warning
 *
 * Displays a warning notice on subsite admin pages when the network admin has enforced primary site configurations.
 *
 * @package ZinnCachePro
 * @since 1.0.0
 */

namespace ZinnCachePro;

defined( 'WPINC' ) || exit;

if ( ! is_multisite() ) {
    return;
}

if ( get_current_blog_id() === BLOG_ID_CURRENT_SITE ) {
    return;
}

if ( ! $this->network_conf( Base::NETWORK_O_USE_PRIMARY ) ) {
    return;
}
?>
<div class="litespeed-callout notice notice-error inline">
    <h4><?php esc_html_e( 'WARNING', 'zinn-cache-pro' ); ?></h4>
    <p>
        <?php esc_html_e( 'The network admin selected use primary site configs for all subsites.', 'zinn-cache-pro' ); ?>
        <?php esc_html_e( 'The following options are selected, but are not editable in this settings page.', 'zinn-cache-pro' ); ?>
    </p>
</div>