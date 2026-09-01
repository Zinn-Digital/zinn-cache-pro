<?php
/**
 * Zinn® Cache Engine ESI Block Loader
 *
 * Loads the ESI block for Zinn® Cache Engine.
 *
 * @package ZinnCachePro
 * @since 1.0.0
 */

defined( 'WPINC' ) || exit;

\ZinnCachePro\ESI::cls()->load_esi_block();
