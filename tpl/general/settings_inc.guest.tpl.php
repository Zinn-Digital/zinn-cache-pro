<?php
/**
 * Zinn® Cache Engine Guest Mode Setting
 *
 * Manages the Guest Mode setting for Zinn® Cache Engine.
 *
 * @package ZinnCachePro
 * @since 1.0.0
 */

namespace ZinnCachePro;

defined( 'WPINC' ) || exit;

$guest_update_url = wp_parse_url( ZINN_CACHE_PRO_PLUGIN_URL . GUI::PHP_GUEST, PHP_URL_PATH );

?>
	<tr>
		<th>
			<?php $option_id = Base::O_GUEST; ?>
			<?php $this->title( $option_id ); ?>
		</th>
		<td>
			<?php $this->build_switch( $option_id ); ?>
			<div class="litespeed-desc">
				<?php esc_html_e( "Guest Mode provides an always cacheable landing page for an automated guest's first time visit, and then attempts to update cache varies via AJAX.", 'zinn-cache-pro' ); ?>
				<?php esc_html_e( 'This option can help to correct the cache vary for certain advanced mobile or tablet visitors.', 'zinn-cache-pro' ); ?>
				<?php Doc::learn_more( 'https://docs.litespeedtech.com/lscache/lscwp/general/#guest-mode' ); ?>
				<br /><?php Doc::notice_htaccess(); ?>
				<br /><?php Doc::crawler_affected(); ?>
			</div>
			<?php if ( $this->conf( $option_id ) ) : ?>
				<div class="litespeed-desc">
					<?php esc_html_e( 'Guest Mode testing result', 'zinn-cache-pro' ); ?>:
					<font id='zinn_cache_pro_gm_status'><?php esc_html_e( 'Testing', 'zinn-cache-pro' ); ?>...</font>
				</div>
				<div class="litespeed-desc">
					<?php esc_html_e( 'Guest Mode IP/UA sync status', 'zinn-cache-pro' ); ?>:
					<font id='zinn_cache_pro_gm_sync_status'><?php esc_html_e( 'Syncing', 'zinn-cache-pro' ); ?>...</font>
				</div>
				<script>
					(function ($) {
						jQuery(document).ready(function () {
							$.post( '<?php echo $guest_update_url; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>', function(data){
								if ( data === '[]' || data === '{"reload":"yes"}' ) {
									$('#zinn_cache_pro_gm_status').html('<font class="litespeed-success"><?php esc_html_e( 'Guest Mode passed testing.', 'zinn-cache-pro' ); ?></font>');
								}
								else {
									$('#zinn_cache_pro_gm_status').html('<font class="litespeed-danger"><?php esc_html_e( 'Guest Mode failed to test.', 'zinn-cache-pro' ); ?></font>');
								}
							}).fail( function(){
								$('#zinn_cache_pro_gm_status').html('<font class="litespeed-danger"><?php esc_html_e( 'Guest Mode failed to test.', 'zinn-cache-pro' ); ?></font>');
							});

							// Sync Guest Mode IP/UA lists
							$.ajax({
								url: '<?php echo esc_url( rest_url( 'zinn-cache-pro/v1/guest/sync' ) ); ?>',
								dataType: 'json',
								beforeSend: function(xhr) {
									xhr.setRequestHeader('X-WP-Nonce', '<?php echo esc_js( wp_create_nonce( 'wp_rest' ) ); ?>');
								},
								success: function(data) {
									if (data && data.success) {
										$('#zinn_cache_pro_gm_sync_status').html('<font class="litespeed-success"><?php esc_html_e( 'Synced successfully.', 'zinn-cache-pro' ); ?></font>');
									} else {
										$('#zinn_cache_pro_gm_sync_status').html('<font class="litespeed-warning"><?php esc_html_e( 'Sync failed.', 'zinn-cache-pro' ); ?></font>');
									}
								},
								error: function() {
									$('#zinn_cache_pro_gm_sync_status').html('<font class="litespeed-warning"><?php esc_html_e( 'Sync failed.', 'zinn-cache-pro' ); ?></font>');
								}
							});
						});
					})(jQuery);
				</script>
			<?php endif; ?>
		</td>
	</tr>