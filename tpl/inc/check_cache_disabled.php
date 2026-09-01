<?php
/**
 * Zinn® Cache Engine Warning Notice
 *
 * Displays warnings if Zinn® Cache Engine functionality is unavailable due to server or plugin configuration issues.
 *
 * @package ZinnCachePro
 * @since 1.0.0
 */

namespace ZinnCachePro;

defined( 'WPINC' ) || exit;

$reasons = array();

if ( ! defined( 'ZINN_CACHE_PRO_ALLOWED' ) ) {
    if ( defined( 'ZINN_CACHE_PRO_SERVER_TYPE' ) && ZINN_CACHE_PRO_SERVER_TYPE === 'NONE' ) {
        $reasons[] = array(
            'title' => esc_html__( 'To use the caching functions you must have a LiteSpeed web server or be using QUIC.cloud CDN.', 'zinn-cache-pro' ),
            'link'  => 'https://docs.litespeedtech.com/lscache/lscwp/faq/#why-do-the-cache-features-require-a-litespeed-server',
        );
    } else {
        $reasons[] = array(
            'title' => esc_html__( 'Please enable the LSCache Module at the server level, or ask your hosting provider.', 'zinn-cache-pro' ),
            'link'  => 'https://docs.litespeedtech.com/lscache/lscwp/#server-level-prerequisites',
        );
    }
} elseif ( ! defined( 'ZINN_CACHE_PRO_ON' ) ) {
    $reasons[] = array(
        'title' => esc_html__( 'Please enable Zinn® Cache Engine in the plugin settings.', 'zinn-cache-pro' ),
        'link'  => 'https://docs.litespeedtech.com/lscache/lscwp/cache/#enable-cache',
    );
}

if ( $reasons ) : ?>
    <div class="litespeed-callout notice notice-error inline">
        <h4><?php esc_html_e( 'WARNING', 'zinn-cache-pro' ); ?></h4>
        <p>
            <?php esc_html_e( 'LSCache caching functions on this page are currently unavailable!', 'zinn-cache-pro' ); ?>
        </p>
        <ul class="litespeed-list">
            <?php foreach ( $reasons as $reason ) : ?>
                <li>
                    <?php echo esc_html( $reason['title'] ); ?>
                    <a href="<?php echo esc_url( $reason['link'] ); ?>" target="_blank" class="litespeed-learn-more"><?php esc_html_e( 'Learn More', 'zinn-cache-pro' ); ?></a>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>
