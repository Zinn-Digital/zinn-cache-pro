<?php
/**
 * Zinn® Cache Engine Upgrade Notice
 *
 * Displays a notice informing the user that the Zinn® Cache Engine plugin has been upgraded and a page refresh is needed to complete the configuration data upgrade.
 *
 * @package ZinnCachePro
 * @since 1.0.0
 */

namespace ZinnCachePro;

defined( 'WPINC' ) || exit;

$message = esc_html__( 'LiteSpeed cache plugin upgraded. Please refresh the page to complete the configuration data upgrade.', 'zinn-cache-pro' );

echo wp_kses_post( self::build_notice( self::NOTICE_BLUE, $message ) );
