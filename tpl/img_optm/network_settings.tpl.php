<?php
/**
 * Zinn® Cache Pro Image Optimization Network Settings
 *
 * Manages network-wide image optimization settings for Zinn® Cache Pro.
 *
 * @package ZinnCachePro
 * @since 1.0.0
 */

namespace ZinnCachePro;

defined( 'WPINC' ) || exit;

$this->form_action( Router::ACTION_SAVE_SETTINGS_NETWORK );
?>

<h3 class="litespeed-title-short">
	<?php esc_html_e( 'Image Optimization Settings', 'zinn-cache-pro' ); ?>
	<?php Doc::learn_more( 'https://docs.litespeedtech.com/lscache/lscwp/imageopt/#image-optimization-settings-tab' ); ?>
</h3>

<table class="wp-list-table striped litespeed-table"><tbody>
	<?php require ZINN_CACHE_PRO_DIR . 'tpl/img_optm/settings.media_webp.tpl.php'; ?>

</tbody></table>

<?php
$this->form_end();