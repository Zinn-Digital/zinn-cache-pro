<?php
/**
 * Zinn® Cache Engine – WooCommerce settings template.
 *
 * Renders the WooCommerce integration settings within the Zinn® Cache Engine admin.
 *
 * @package ZinnCachePro\Thirdparty
 */

namespace ZinnCachePro\Thirdparty;

defined( 'WPINC' ) || exit;

use ZinnCachePro\Doc;
?>
<div data-zinn-cache-pro-layout="woocommerce">

	<h3 class="litespeed-title-short">
		<?php esc_html_e( 'WooCommerce Settings', 'zinn-cache-pro' ); ?>
		<?php Doc::learn_more( 'https://docs.litespeedtech.com/lscache/lscwp/cache/#woocommerce-tab' ); ?>
	</h3>

	<div class="litespeed-callout notice notice-warning inline">
		<h4><?php esc_html_e( 'NOTICE:', 'zinn-cache-pro' ); ?></h4>
		<p><?php esc_html_e( 'After verifying that the cache works in general, please test the cart.', 'zinn-cache-pro' ); ?></p>
		<p>
			<?php
			printf(
				/* translators: %s: link attributes */
				esc_html__( 'To test the cart, visit the %sFAQ%s.', 'zinn-cache-pro' ),
				'<a href="https://docs.litespeedtech.com/lscache/lscwp/installation/#non-cacheable-pages" target="_blank">',
				'</a>'
			);
			?>
		</p>
		<p><?php esc_html_e( 'By default, the My Account, Checkout, and Cart pages are automatically excluded from caching. Misconfiguration of page associations in WooCommerce settings may cause some pages to be erroneously excluded.', 'zinn-cache-pro' ); ?></p>
	</div>

	<table class="wp-list-table striped litespeed-table">
		<tbody>
			<tr>
				<th>
					<?php $setting_id = self::O_UPDATE_INTERVAL; ?>
					<?php esc_html_e( 'Product Update Interval', 'zinn-cache-pro' ); ?>
				</th>
				<td>
					<?php
					$options = [
						self::O_PQS_CS  => esc_html__( 'Purge product on changes to the quantity or stock status.', 'zinn-cache-pro' ) . ' ' . esc_html__( 'Purge categories only when stock status changes.', 'zinn-cache-pro' ),
						self::O_PS_CS   => esc_html__( 'Purge product and categories only when the stock status changes.', 'zinn-cache-pro' ),
						self::O_PS_CN   => esc_html__( 'Purge product only when the stock status changes.', 'zinn-cache-pro' ) . ' ' . esc_html__( 'Do not purge categories on changes to the quantity or stock status.', 'zinn-cache-pro' ),
						self::O_PQS_CQS => esc_html__( 'Always purge both product and categories on changes to the quantity or stock status.', 'zinn-cache-pro' ),
					];
					$conf    = (int) apply_filters( 'zinn_cache_pro_conf', $setting_id );
					do_action( 'zinn_cache_pro_setting_enroll', $setting_id );
					foreach ( $options as $k => $v ) :
						$input_id = 'conf_' . $setting_id . '_' . $k;
						?>
						<div class="litespeed-radio-row">
							<input
								type="radio"
								autocomplete="off"
								name="<?php echo esc_attr( (string) $setting_id ); ?>"
								id="<?php echo esc_attr( $input_id ); ?>"
								value="<?php echo esc_attr( (string) $k ); ?>"
								<?php echo checked( $conf, (int) $k, false ); ?>
							/>
							<label for="<?php echo esc_attr( $input_id ); ?>"><?php echo esc_html( $v ); ?></label>
						</div>
					<?php endforeach; ?>
					<div class="litespeed-desc">
						<?php esc_html_e( 'Determines how changes in product quantity and product stock status affect product pages and their associated category pages.', 'zinn-cache-pro' ); ?>
					</div>
				</td>
			</tr>

			<tr>
				<th>
					<?php $setting_id = self::O_CART_VARY; ?>
					<?php esc_html_e( 'Vary for Mini Cart', 'zinn-cache-pro' ); ?>
				</th>
				<td>
					<?php
					$conf = (int) apply_filters( 'zinn_cache_pro_conf', $setting_id );
					$this->cls( 'Admin_Display' )->build_switch( $setting_id );
					?>
					<div class="litespeed-desc">
						<?php esc_html_e( 'Generate a separate vary cache copy for the mini cart when the cart is not empty.', 'zinn-cache-pro' ); ?>
						<?php esc_html_e( 'If your theme does not use JS to update the mini cart, you must enable this option to display the correct cart contents.', 'zinn-cache-pro' ); ?>
						<br /><?php Doc::notice_htaccess(); ?>
					</div>
				</td>
			</tr>

		</tbody>
	</table>
</div>
