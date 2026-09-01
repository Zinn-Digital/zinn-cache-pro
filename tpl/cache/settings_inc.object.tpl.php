<?php
/**
 * Zinn® Cache Engine Object Cache Settings
 *
 * Displays the object cache settings section for Zinn® Cache Engine.
 *
 * @package ZinnCachePro
 * @since 1.0.0
 */

namespace ZinnCachePro;

defined( 'WPINC' ) || exit;

$lang_enabled  = '<span class="litespeed-success">' . esc_html__( 'Enabled', 'zinn-cache-pro' ) . '</span>';
$lang_disabled = '<span class="litespeed-warning">' . esc_html__( 'Disabled', 'zinn-cache-pro' ) . '</span>';

$mem_enabled   = class_exists( 'Memcached' ) ? $lang_enabled : $lang_disabled;
$redis_enabled = class_exists( 'Redis' ) ? $lang_enabled : $lang_disabled;

$mem_conn = $this->cls( 'Object_Cache' )->test_connection();
if ( null === $mem_conn ) {
	$mem_conn_desc = '<span class="litespeed-desc">' . esc_html__( 'Not Available', 'zinn-cache-pro' ) . '</span>';
} elseif ( $mem_conn ) {
	$mem_conn_desc = '<span class="litespeed-success">' . esc_html__( 'Passed', 'zinn-cache-pro' ) . '</span>';
} else {
	$severity      = $this->conf( Base::O_OBJECT, true ) ? 'danger' : 'warning';
	$mem_conn_desc = '<span class="litespeed-' . esc_attr( $severity ) . '">' . esc_html__( 'Failed', 'zinn-cache-pro' ) . '</span>';
}
?>

<h3 class="litespeed-title-short">
	<?php esc_html_e( 'Object Cache Settings', 'zinn-cache-pro' ); ?>
	<?php Doc::learn_more( 'https://docs.litespeedtech.com/lscache/lscwp/cache/#object-tab' ); ?>
</h3>

<table class="wp-list-table striped litespeed-table">
	<tbody>
		<tr>
			<th scope="row">
				<?php $option_id = Base::O_OBJECT; ?>
				<?php $this->title( $option_id ); ?>
			</th>
			<td>
				<?php $this->build_switch( $option_id ); ?>
				<div class="litespeed-desc">
					<?php esc_html_e( 'Use external object cache functionality.', 'zinn-cache-pro' ); ?>
					<?php Doc::learn_more( 'https://docs.litespeedtech.com/lscache/lscwp/admin/#memcached-lsmcd-and-redis-object-cache-support-in-lscwp' ); ?>
				</div>
				<div class="litespeed-block">
					<div class="litespeed-col-auto">
						<h4><?php esc_html_e( 'Status', 'zinn-cache-pro' ); ?></h4>
					</div>
					<div class="litespeed-col-auto">
						<?php
						printf(
							/* translators: %s: Object cache name */
							esc_html__( '%s Extension', 'zinn-cache-pro' ),
							'Memcached'
						);
						?>
						: <?php echo wp_kses_post( $mem_enabled ); ?><br>
						<?php
						printf(
							/* translators: %s: Object cache name */
							esc_html__( '%s Extension', 'zinn-cache-pro' ),
							'Redis'
						);
						?>
						: <?php echo wp_kses_post( $redis_enabled ); ?><br>
						<?php esc_html_e( 'Connection Test', 'zinn-cache-pro' ); ?>: <?php echo wp_kses_post( $mem_conn_desc ); ?>
						<?php Doc::learn_more( 'https://docs.litespeedtech.com/lscache/lscwp/admin/#how-to-debug' ); ?>
					</div>
				</div>
			</td>
		</tr>

		<tr>
			<th scope="row">
				<?php $option_id = Base::O_OBJECT_KIND; ?>
				<?php $this->title( $option_id ); ?>
			</th>
			<td>
				<?php $this->build_switch( $option_id, array( 'Memcached', 'Redis' ) ); ?>
			</td>
		</tr>

		<tr>
			<th scope="row">
				<?php $option_id = Base::O_OBJECT_HOST; ?>
				<?php $this->title( $option_id ); ?>
			</th>
			<td>
				<?php $this->build_input( $option_id ); ?>
				<div class="litespeed-desc">
					<?php
					printf(
						/* translators: %s: Object cache name */
						esc_html__( 'Your %s Hostname or IP address.', 'zinn-cache-pro' ),
						'Memcached/<a href="https://docs.litespeedtech.com/products/lsmcd/" target="_blank" rel="noopener">LSMCD</a>/Redis'
					);
					?>
					<br>
					<?php
					printf(
						/* translators: %1$s: Socket name, %2$s: Host field title, %3$s: Example socket path */
						esc_html__( 'If you are using a %1$s socket, %2$s should be set to %3$s', 'zinn-cache-pro' ),
						'UNIX',
						esc_html( Lang::title( $option_id ) ),
						'<code>/path/to/memcached.sock</code>'
					);
					?>
				</div>
			</td>
		</tr>

		<tr>
			<th scope="row">
				<?php $option_id = Base::O_OBJECT_PORT; ?>
				<?php $this->title( $option_id ); ?>
			</th>
			<td>
				<?php $this->build_input( $option_id, 'litespeed-input-short2' ); ?>
				<div class="litespeed-desc">
					<?php
					printf(
						/* translators: %1$s: Object cache name, %2$s: Port number */
						esc_html__( 'Default port for %1$s is %2$s.', 'zinn-cache-pro' ),
						'Memcached',
						'<code>11211</code>'
					);
					?>
					<br>
					<?php
					printf(
						/* translators: %1$s: Object cache name, %2$s: Port number */
						esc_html__( 'Default port for %1$s is %2$s.', 'zinn-cache-pro' ),
						'Redis',
						'<code>6379</code>'
					);
					?>
					<br>
					<?php
					printf(
						/* translators: %1$s: Socket name, %2$s: Port field title, %3$s: Port value */
						esc_html__( 'If you are using a %1$s socket, %2$s should be set to %3$s', 'zinn-cache-pro' ),
						'UNIX',
						esc_html( Lang::title( $option_id ) ),
						'<code>0</code>'
					);
					?>
				</div>
			</td>
		</tr>

		<tr>
			<th scope="row">
				<?php $option_id = Base::O_OBJECT_LIFE; ?>
				<?php $this->title( $option_id ); ?>
			</th>
			<td>
				<?php $this->build_input( $option_id, 'litespeed-input-short2' ); ?> <?php esc_html_e( 'seconds', 'zinn-cache-pro' ); ?>
				<div class="litespeed-desc">
					<?php esc_html_e( 'Default TTL for cached objects.', 'zinn-cache-pro' ); ?>
				</div>
			</td>
		</tr>

		<tr>
			<th scope="row">
				<?php $option_id = Base::O_OBJECT_USER; ?>
				<?php $this->title( $option_id ); ?>
			</th>
			<td>
				<?php $this->build_input( $option_id ); ?>
				<div class="litespeed-desc">
					<?php
					printf(
						/* translators: %s: SASL */
						esc_html__( 'Only available when %s is installed.', 'zinn-cache-pro' ),
						'SASL'
					);
					?>
				</div>
			</td>
		</tr>

		<tr>
			<th scope="row">
				<?php $option_id = Base::O_OBJECT_PSWD; ?>
				<?php $this->title( $option_id ); ?>
			</th>
			<td>
				<?php $this->build_input( $option_id ); ?>
				<div class="litespeed-desc">
					<?php esc_html_e( 'Specify the password used when connecting.', 'zinn-cache-pro' ); ?>
				</div>
			</td>
		</tr>

		<tr>
			<th scope="row">
				<?php $option_id = Base::O_OBJECT_DB_ID; ?>
				<?php $this->title( $option_id ); ?>
			</th>
			<td>
				<?php $this->build_input( $option_id, 'litespeed-input-short' ); ?>
				<div class="litespeed-desc">
					<?php esc_html_e( 'Database to be used', 'zinn-cache-pro' ); ?>
				</div>
			</td>
		</tr>

		<tr>
			<th scope="row">
				<?php $option_id = Base::O_OBJECT_GLOBAL_GROUPS; ?>
				<?php $this->title( $option_id ); ?>
			</th>
			<td>
				<?php $this->build_textarea( $option_id, 30 ); ?>
				<div class="litespeed-desc">
					<?php esc_html_e( 'Groups cached at the network level.', 'zinn-cache-pro' ); ?>
					<?php Doc::one_per_line(); ?>
				</div>
			</td>
		</tr>

		<tr>
			<th scope="row">
				<?php $option_id = Base::O_OBJECT_NON_PERSISTENT_GROUPS; ?>
				<?php $this->title( $option_id ); ?>
			</th>
			<td>
				<?php $this->build_textarea( $option_id, 30 ); ?>
				<div class="litespeed-desc">
					<?php Doc::one_per_line(); ?>
				</div>
			</td>
		</tr>

		<tr>
			<th scope="row">
				<?php $option_id = Base::O_OBJECT_PERSISTENT; ?>
				<?php $this->title( $option_id ); ?>
			</th>
			<td>
				<?php $this->build_switch( $option_id ); ?>
				<div class="litespeed-desc">
					<?php esc_html_e( 'Use keep-alive connections to speed up cache operations.', 'zinn-cache-pro' ); ?>
				</div>
			</td>
		</tr>

		<tr>
			<th scope="row">
				<?php $option_id = Base::O_OBJECT_ADMIN; ?>
				<?php $this->title( $option_id ); ?>
			</th>
			<td>
				<?php $this->build_switch( $option_id ); ?>
				<div class="litespeed-desc">
					<?php esc_html_e( 'Improve wp-admin speed through caching. (May encounter expired data)', 'zinn-cache-pro' ); ?>
				</div>
			</td>
		</tr>

	</tbody>
</table>

<script>
jQuery(document).ready(function($) {
	// Auto-fill port based on object cache type
	$('input[name="object-kind"]').on('change', function() {
		var portInput = $('#input_objectport');
		var selectedKind = $(this).val();

		// Memcached (0) -> 11211, Redis (1) -> 6379
		if (selectedKind === '0') {
			portInput.val('11211');
		} else if (selectedKind === '1') {
			portInput.val('6379');
		}
	});
});
</script>
