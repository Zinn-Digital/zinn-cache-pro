<?php
/**
 * Zinn® Cache Pro ESI Block Loader
 *
 * Loads the ESI block for Zinn® Cache Pro.
 *
 * @package ZinnCachePro
 * @since 1.0.0
 */

defined( 'WPINC' ) || exit;

\ZinnCachePro\ESI::cls()->load_esi_block();
