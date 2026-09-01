<?php
/**
 * Zinn® Cache Engine Debug Settings Interface
 *
 * Renders the debug settings interface for Zinn® Cache Engine, allowing users to configure debugging options and view the site with specific settings bypassed.
 *
 * @package ZinnCachePro
 * @since 1.0.0
 */

namespace ZinnCachePro;

defined( 'WPINC' ) || exit;

$this->form_action( $this->_is_network_admin ? Router::ACTION_SAVE_SETTINGS_NETWORK : false );
?>

<h3 class="litespeed-title-short">
	<?php esc_html_e( 'Debug Helpers', 'zinn-cache-pro' ); ?>
</h3>

<a href="<?php echo esc_url( home_url( '/' ) . '?' . Router::ACTION . '=before_optm' ); ?>" class="button button-success" target="_blank">
	<?php esc_html_e( 'View Site Before Optimization', 'zinn-cache-pro' ); ?>
</a>

<a href="<?php echo esc_url( home_url( '/' ) . '?' . Router::ACTION . '=' . Core::ACTION_QS_NOCACHE ); ?>" class="button button-success" target="_blank">
	<?php esc_html_e( 'View Site Before Cache', 'zinn-cache-pro' ); ?>
</a>


<?php
$temp_disabled_time = $this->conf( Base::DEBUG_TMP_DISABLE );
$temp_disabled      = Debug2::is_tmp_disable();
if ( !$temp_disabled ) {
?>
	<a href="<?php echo wp_kses_post( Utility::build_url(Router::ACTION_TMP_DISABLE, false, false, '_ori') ); ?>" class="button litespeed-btn-danger">
		<?php esc_html_e( 'Disable All Features for 24 Hours', 'zinn-cache-pro' ); ?>
	</a>
<?php
} else {
	$date = wp_date( get_option('date_format') . ' ' . get_option( 'time_format' ), $temp_disabled_time );
?>
	<a href="<?php echo wp_kses_post( Utility::build_url(Router::ACTION_TMP_DISABLE, false, false, '_ori') ); ?>" class="button litespeed-btn-warning">
		<?php esc_html_e( 'Remove `Disable All Feature` Flag Now', 'zinn-cache-pro' ); ?>
	</a>
	<div class="litespeed-callout notice notice-warning inline">
		<h4><?php esc_html_e( 'NOTICE', 'zinn-cache-pro' ); ?></h4>
		<p><?php echo wp_kses_post( sprintf ( __( 'Zinn® Cache Engine is temporarily disabled until: %s.', 'zinn-cache-pro' ), '<strong>' . $date . '</strong>' ) ); ?></p>
	</div>
<?php
}
?>

<h3 class="litespeed-title-short">
	<?php esc_html_e( 'Debug Settings', 'zinn-cache-pro' ); ?>
	<?php Doc::learn_more( 'https://docs.litespeedtech.com/lscache/lscwp/toolbox/#debug-settings-tab' ); ?>
</h3>

<table class="wp-list-table striped litespeed-table">
	<tbody>
		<tr>
			<th>
				<?php $option_id = Base::O_DEBUG_DISABLE_ALL; ?>
				<?php $this->title( $option_id ); ?>
			</th>
			<td>
				<?php $this->build_switch( $option_id ); ?>
				<div class="litespeed-desc">
					<?php esc_html_e( 'This will disable LSCache and all optimization features for debug purpose.', 'zinn-cache-pro' ); ?>
				</div>
			</td>
		</tr>

		<tr>
			<th>
				<?php $option_id = Base::O_DEBUG; ?>
				<?php $this->title( $option_id ); ?>
			</th>
			<td>
				<?php $this->build_switch( $option_id, array( esc_html__( 'OFF', 'zinn-cache-pro' ), esc_html__( 'ON', 'zinn-cache-pro' ), esc_html__( 'Admin IP Only', 'zinn-cache-pro' ) ) ); ?>
				<div class="litespeed-desc">
					<?php printf( esc_html__( 'Outputs to a series of files in the %s directory.', 'zinn-cache-pro' ), '<code>wp-content/litespeed/debug</code>' ); ?>
					<?php esc_html_e( 'To prevent filling up the disk, this setting should be OFF when everything is working.', 'zinn-cache-pro' ); ?>
					<?php esc_html_e( 'The Admin IP option will only output log messages on requests from admin IPs listed below.', 'zinn-cache-pro' ); ?>
				</div>
			</td>
		</tr>

		<tr>
			<th>
				<?php $option_id = Base::O_DEBUG_IPS; ?>
				<?php $this->title( $option_id ); ?>
			</th>
			<td>
				<?php $this->build_textarea( $option_id, 50 ); ?>
				<div class="litespeed-desc">
					<?php esc_html_e( 'Allows listed IPs (one per line) to perform certain actions from their browsers.', 'zinn-cache-pro' ); ?>
					<?php esc_html_e( 'Your IP', 'zinn-cache-pro' ); ?>: <code><?php echo esc_html( Router::get_ip() ); ?></code>
					<?php $this->_validate_ip( $option_id ); ?>
					<br />
					<?php
					Doc::learn_more(
						'https://docs.litespeedtech.com/lscache/lscwp/admin/#admin-ip-commands',
						esc_html__( 'More information about the available commands can be found here.', 'zinn-cache-pro' )
					);
					?>
				</div>
			</td>
		</tr>

		<tr>
			<th>
				<?php $option_id = Base::O_DEBUG_LEVEL; ?>
				<?php $this->title( $option_id ); ?>
			</th>
			<td>
				<?php $this->build_switch( $option_id, array( esc_html__( 'Basic', 'zinn-cache-pro' ), esc_html__( 'Advanced', 'zinn-cache-pro' ) ) ); ?>
				<div class="litespeed-desc">
					<?php esc_html_e( 'Advanced level will log more details.', 'zinn-cache-pro' ); ?>
				</div>
			</td>
		</tr>

		<tr>
			<th>
				<?php $option_id = Base::O_DEBUG_FILESIZE; ?>
				<?php $this->title( $option_id ); ?>
			</th>
			<td>
				<?php $this->build_input( $option_id, 'litespeed-input-short' ); ?> <?php esc_html_e( 'MB', 'zinn-cache-pro' ); ?>
				<div class="litespeed-desc">
					<?php esc_html_e( 'Specify the maximum size of the log file.', 'zinn-cache-pro' ); ?>
					<?php $this->recommended( $option_id ); ?>
					<?php $this->_validate_ttl( $option_id, 3, 3000 ); ?>
				</div>
			</td>
		</tr>

		<tr>
			<th>
				<?php $option_id = Base::O_DEBUG_COLLAPSE_QS; ?>
				<?php $this->title( $option_id ); ?>
			</th>
			<td>
				<?php $this->build_switch( $option_id ); ?>
				<div class="litespeed-desc">
					<?php esc_html_e( 'Shorten query strings in the debug log to improve readability.', 'zinn-cache-pro' ); ?>
				</div>
			</td>
		</tr>

		<tr>
			<th>
				<?php $option_id = Base::O_DEBUG_INC; ?>
				<?php $this->title( $option_id ); ?>
			</th>
			<td>
				<?php $this->build_textarea( $option_id ); ?>
				<div class="litespeed-desc">
					<?php esc_html_e( 'Only log listed pages.', 'zinn-cache-pro' ); ?>
					<?php $this->_uri_usage_example(); ?>
				</div>
			</td>
		</tr>

		<tr>
			<th>
				<?php $option_id = Base::O_DEBUG_EXC; ?>
				<?php $this->title( $option_id ); ?>
			</th>
			<td>
				<?php $this->build_textarea( $option_id ); ?>
				<div class="litespeed-desc">
					<?php esc_html_e( 'Prevent any debug log of listed pages.', 'zinn-cache-pro' ); ?>
					<?php $this->_uri_usage_example(); ?>
				</div>
			</td>
		</tr>

		<tr>
			<th>
				<?php $option_id = Base::O_DEBUG_EXC_STRINGS; ?>
				<?php $this->title( $option_id ); ?>
			</th>
			<td>
				<?php $this->build_textarea( $option_id ); ?>
				<div class="litespeed-desc">
					<?php esc_html_e( 'Prevent writing log entries that include listed strings.', 'zinn-cache-pro' ); ?>
					<?php Doc::one_per_line(); ?>
				</div>
			</td>
		</tr>
	</tbody>
</table>

<?php $this->form_end(); ?>