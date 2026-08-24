<?php
/**
 * Zinn® Cache Pro CSS Settings
 *
 * Renders the CSS optimization settings interface for Zinn® Cache Pro.
 *
 * @package ZinnCachePro
 * @since 1.0.0
 */

namespace ZinnCachePro;

defined( 'WPINC' ) || exit;

$__admin_display     = Admin_Display::cls();
$css_summary         = CSS::get_summary();
$ucss_summary        = UCSS::get_summary();
$closest_server_ucss = Cloud::get_summary( 'server.' . Cloud::SVC_UCSS );
$closest_server      = Cloud::get_summary( 'server.' . Cloud::SVC_CCSS );

$ccss_queue = $this->load_queue( 'ccss' );
$ucss_queue = $this->load_queue( 'ucss' );

$next_gen = '<code class="litespeed-success">' . $this->cls( 'Media' )->next_gen_image_title() . '</code>';

$ucss_service_hot = $this->cls( 'Cloud' )->service_hot( Cloud::SVC_UCSS );
$ccss_service_hot = $this->cls( 'Cloud' )->service_hot( Cloud::SVC_CCSS );
?>

<h3 class="litespeed-title-short">
	<?php esc_html_e( 'CSS Settings', 'zinn-cache-pro' ); ?>
	<?php Doc::learn_more( 'https://docs.litespeedtech.com/lscache/lscwp/pageopt/' ); ?>
</h3>

<table class="wp-list-table striped litespeed-table">
	<tbody>
		<tr>
			<th>
				<?php $option_id = Base::O_OPTM_CSS_MIN; ?>
				<?php $this->title( $option_id ); ?>
			</th>
			<td>
				<?php $this->build_switch( $option_id ); ?>
				<?php Doc::maybe_on_by_gm( $option_id ); ?>
				<div class="litespeed-desc">
					<?php esc_html_e( 'Minify CSS files and inline CSS code.', 'zinn-cache-pro' ); ?>
				</div>
			</td>
		</tr>

		<tr>
			<th>
				<?php $option_id = Base::O_OPTM_CSS_COMB; ?>
				<?php $this->title( $option_id ); ?>
			</th>
			<td>
				<?php $this->build_switch( $option_id ); ?>
				<?php Doc::maybe_on_by_gm( $option_id ); ?>
				<div class="litespeed-desc">
					<?php esc_html_e( 'Combine CSS files and inline CSS code.', 'zinn-cache-pro' ); ?>
					<a href="https://docs.litespeedtech.com/lscache/lscwp/ts-optimize/" target="_blank"><?php esc_html_e( 'How to Fix Problems Caused by CSS/JS Optimization.', 'zinn-cache-pro' ); ?></a>
				</div>
			</td>
		</tr>

		<tr>
			<th class="litespeed-padding-left">
				<?php $option_id = Base::O_OPTM_UCSS; ?>
				<?php $this->title( $option_id ); ?>
			</th>
			<td>
				<?php $this->build_switch( $option_id ); ?>
				<?php Doc::maybe_on_by_gm( $option_id ); ?>
				<div class="litespeed-desc">
					<?php if ( ! $this->cls( 'Cloud' )->activated() ) : ?>
						<div class="litespeed-callout notice notice-error inline">
							<h4><?php esc_html_e( 'WARNING', 'zinn-cache-pro' ); ?></h4>
							<?php echo wp_kses_post( Error::msg( 'qc_setup_required' ) ); ?>
						</div>
					<?php endif; ?>

					<?php esc_html_e( 'Use QUIC.cloud online service to generate unique CSS.', 'zinn-cache-pro' ); ?>
					<?php esc_html_e( 'This will drop the unused CSS on each page from the combined file.', 'zinn-cache-pro' ); ?>
					<?php Doc::learn_more( 'https://docs.litespeedtech.com/lscache/lscwp/pageopt/#generate-ucss' ); ?>
					<br /><?php esc_html_e( 'Automatic generation of unique CSS is in the background via a cron-based queue.', 'zinn-cache-pro' ); ?>
					<br />
					<font class="litespeed-success"><?php esc_html_e( 'API', 'zinn-cache-pro' ); ?>: <?php printf( esc_html__( 'Filter %s available for UCSS per page type generation.', 'zinn-cache-pro' ), '<code>add_filter( "zinn_cache_pro_ucss_per_pagetype", "__return_true" );</code>' ); ?></font>
					<?php $__admin_display->_check_overwritten( 'optm-ucss_per_pagetype' ); ?>

					<?php if ( $this->conf( Base::O_OPTM_UCSS ) && ! $this->conf( Base::O_OPTM_CSS_COMB ) ) : ?>
						<br />
						<font class="litespeed-warning">
							<?php printf( esc_html__( 'This option is bypassed because %1$s option is %2$s.', 'zinn-cache-pro' ), '<code>' . esc_html( Lang::title( Base::O_OPTM_CSS_COMB ) ) . '</code>', '<code>' . esc_html__( 'OFF', 'zinn-cache-pro' ) . '</code>' ); ?>
						</font>
					<?php endif; ?>
				</div>

				<div class="litespeed-desc litespeed-left20">
					<?php if ( $ucss_summary ) : ?>
						<?php if ( ! empty( $ucss_summary['last_request'] ) ) : ?>
							<p>
								<?php echo esc_html__( 'Last generated', 'zinn-cache-pro' ) . ': <code>' . esc_html( Utility::readable_time( $ucss_summary['last_request'] ) ) . '</code>'; ?>
							</p>
							<p>
								<?php echo esc_html__( 'Last requested cost', 'zinn-cache-pro' ) . ': <code>' . esc_html( $ucss_summary['last_spent'] ) . 's</code>'; ?>
							</p>
						<?php endif; ?>
					<?php endif; ?>

					<?php if ( $closest_server_ucss ) : ?>
						<a class="litespeed-redetect" href="<?php echo esc_url( Utility::build_url( Router::ACTION_CLOUD, Cloud::TYPE_REDETECT_CLOUD, false, null, array( 'svc' => Cloud::SVC_UCSS ) ) ); ?>" data-balloon-pos="up" data-balloon-break aria-label="<?php printf( esc_html__( 'Current closest Cloud server is %s. Click to redetect.', 'zinn-cache-pro' ), esc_html( $closest_server_ucss ) ); ?>" data-zinn-cache-pro-cfm="<?php esc_html_e( 'Are you sure you want to redetect the closest cloud server for this service?', 'zinn-cache-pro' ); ?>"><i class="litespeed-quic-icon"></i> <?php esc_html_e( 'Redetect', 'zinn-cache-pro' ); ?></a>
					<?php endif; ?>

					<?php if ( ! empty( $ucss_queue ) ) : ?>
						<div class="litespeed-callout notice notice-warning inline">
							<h4>
								<?php printf( esc_html__( 'URL list in %s queue waiting for cron', 'zinn-cache-pro' ), 'UCSS' ); ?> ( <?php echo esc_html( count( $ucss_queue ) ); ?> )
								<a href="<?php echo esc_url( Utility::build_url( Router::ACTION_UCSS, UCSS::TYPE_CLEAR_Q ) ); ?>" class="button litespeed-btn-warning litespeed-right"><?php esc_html_e( 'Clear', 'zinn-cache-pro' ); ?></a>
							</h4>
							<p>
								<?php
								$i = 0;
								foreach ( $ucss_queue as $queue_key => $queue_val ) :
									if ( $i++ > 20 ) :
										echo '...';
										break;
									endif;
									if ( ! is_array( $queue_val ) ) {
										continue;
									}
									if ( ! empty( $queue_val['_status'] ) ) {
										echo '<span class="litespeed-success">';
									}
									echo esc_html( $queue_val['url'] );
									if ( ! empty( $queue_val['_status'] ) ) {
										echo '</span>';
									}
									$pos = strpos( $queue_key, ' ' );
									if ( $pos ) {
										echo ' (' . esc_html__( 'Vary Group', 'zinn-cache-pro' ) . ':' . esc_html( substr( $queue_key, 0, $pos ) ) . ')';
									}
									if ( $queue_val['is_mobile'] ) {
										echo ' <span data-balloon-pos="up" aria-label="mobile">📱</span>';
									}
									if ( ! empty( $queue_val['is_webp'] ) ) {
										echo ' ' . wp_kses_post( $next_gen );
									}
									echo '<br />';
								endforeach;
								?>
							</p>
						</div>
						<?php if ( $ucss_service_hot ) : ?>
							<button class="button button-secondary" disabled>
								<?php printf( esc_html__( 'Run %s Queue Manually', 'zinn-cache-pro' ), 'UCSS' ); ?>
								- <?php printf( esc_html__( 'Available after %d second(s)', 'zinn-cache-pro' ), esc_html( $ucss_service_hot ) ); ?>
							</button>
						<?php else : ?>
							<a href="<?php echo esc_url( Utility::build_url( Router::ACTION_UCSS, UCSS::TYPE_GEN ) ); ?>" class="button litespeed-btn-success">
								<?php printf( esc_html__( 'Run %s Queue Manually', 'zinn-cache-pro' ), 'UCSS' ); ?>
							</a>
						<?php endif; ?>
						<?php Doc::queue_issues(); ?>
					<?php endif; ?>
				</div>
			</td>
		</tr>

		<tr>
			<th class="litespeed-padding-left">
				<?php $option_id = Base::O_OPTM_UCSS_INLINE; ?>
				<?php $this->title( $option_id ); ?>
			</th>
			<td>
				<?php $this->build_switch( $option_id ); ?>
				<?php Doc::maybe_on_by_gm( $option_id ); ?>
				<div class="litespeed-desc">
					<?php printf( esc_html__( 'Inline UCSS to reduce the extra CSS file loading. This option will not be automatically turned on for %1$s pages. To use it on %1$s pages, please set it to ON.', 'zinn-cache-pro' ), '<code>' . esc_html( Lang::title( Base::O_GUEST ) ) . '</code>' ); ?>
					<br />
					<font class="litespeed-info">
						<?php printf( esc_html__( 'This option will automatically bypass %s option.', 'zinn-cache-pro' ), '<code>' . esc_html( Lang::title( Base::O_OPTM_CSS_ASYNC ) ) . '</code>' ); ?>
					</font>
				</div>
			</td>
		</tr>

		<tr>
			<th>
				<?php $option_id = Base::O_OPTM_CSS_COMB_EXT_INL; ?>
				<?php $this->title( $option_id ); ?>
			</th>
			<td>
				<?php $this->build_switch( $option_id ); ?>
				<div class="litespeed-desc">
					<?php printf( esc_html__( 'Include external CSS and inline CSS in combined file when %1$s is also enabled. This option helps maintain the priorities of CSS, which should minimize potential errors caused by CSS Combine.', 'zinn-cache-pro' ), '<code>' . esc_html( Lang::title( Base::O_OPTM_CSS_COMB ) ) . '</code>' ); ?>
				</div>
			</td>
		</tr>

		<tr>
			<th>
				<?php $option_id = Base::O_OPTM_CSS_ASYNC; ?>
				<?php $this->title( $option_id ); ?>
			</th>
			<td>
				<?php $this->build_switch( $option_id ); ?>
				<?php Doc::maybe_on_by_gm( $option_id ); ?>
				<div class="litespeed-desc">
					<?php if ( ! $this->cls( 'Cloud' )->activated() ) : ?>
						<div class="litespeed-callout notice notice-error inline">
							<h4><?php esc_html_e( 'WARNING', 'zinn-cache-pro' ); ?></h4>
							<?php echo wp_kses_post( Error::msg( 'qc_setup_required' ) ); ?>
						</div>
					<?php endif; ?>
					<?php esc_html_e( 'Optimize CSS delivery.', 'zinn-cache-pro' ); ?>
					<?php esc_html_e( 'This can improve your speed score in services like Pingdom, GTmetrix and PageSpeed.', 'zinn-cache-pro' ); ?><br />
					<?php esc_html_e( 'Use QUIC.cloud online service to generate critical CSS and load remaining CSS asynchronously.', 'zinn-cache-pro' ); ?>
					<?php Doc::learn_more( 'https://docs.litespeedtech.com/lscache/lscwp/pageopt/#load-css-asynchronously' ); ?><br />
					<?php esc_html_e( 'Automatic generation of critical CSS is in the background via a cron-based queue.', 'zinn-cache-pro' ); ?><br />
					<?php printf( esc_html__( 'When this option is turned %s, it will also load Google Fonts asynchronously.', 'zinn-cache-pro' ), '<code>' . esc_html__( 'ON', 'zinn-cache-pro' ) . '</code>' ); ?>
					<br />
					<font class="litespeed-success">
						<?php esc_html_e( 'API', 'zinn-cache-pro' ); ?>:
						<?php printf( esc_html__( 'Elements with attribute %s in HTML code will be excluded.', 'zinn-cache-pro' ), '<code>data-no-async="1"</code>' ); ?>
					</font>

					<?php if ( $this->conf( Base::O_OPTM_CSS_ASYNC ) && $this->conf( Base::O_OPTM_CSS_COMB ) && $this->conf( Base::O_OPTM_UCSS ) && $this->conf( Base::O_OPTM_UCSS_INLINE ) ) : ?>
						<br />
						<font class="litespeed-warning">
							<?php printf( esc_html__( 'This option is bypassed due to %s option.', 'zinn-cache-pro' ), '<code>' . esc_html( Lang::title( Base::O_OPTM_UCSS_INLINE ) ) . '</code>' ); ?>
						</font>
					<?php endif; ?>
				</div>

				<div class="litespeed-desc litespeed-left20">
					<?php if ( $css_summary ) : ?>
						<?php if ( ! empty( $css_summary['last_request_ccss'] ) ) : ?>
							<p>
								<?php echo esc_html__( 'Last generated', 'zinn-cache-pro' ) . ': <code>' . esc_html( Utility::readable_time( $css_summary['last_request_ccss'] ) ) . '</code>'; ?>
							</p>
							<p>
								<?php echo esc_html__( 'Last requested cost', 'zinn-cache-pro' ) . ': <code>' . esc_html( $css_summary['last_spent_ccss'] ) . 's</code>'; ?>
							</p>
						<?php endif; ?>
					<?php endif; ?>

					<?php if ( $closest_server ) : ?>
						<a class="litespeed-redetect" href="<?php echo esc_url( Utility::build_url( Router::ACTION_CLOUD, Cloud::TYPE_REDETECT_CLOUD, false, null, array( 'svc' => Cloud::SVC_CCSS ) ) ); ?>" data-balloon-pos="up" data-balloon-break aria-label="<?php printf( esc_html__( 'Current closest Cloud server is %s. Click to redetect.', 'zinn-cache-pro' ), esc_html( $closest_server ) ); ?>" data-zinn-cache-pro-cfm="<?php esc_html_e( 'Are you sure you want to redetect the closest cloud server for this service?', 'zinn-cache-pro' ); ?>"><i class="litespeed-quic-icon"></i> <?php esc_html_e( 'Redetect', 'zinn-cache-pro' ); ?></a>
					<?php endif; ?>

					<?php if ( ! empty( $ccss_queue ) ) : ?>
						<div class="litespeed-callout notice notice-warning inline">
							<h4>
								<?php printf( esc_html__( 'URL list in %s queue waiting for cron', 'zinn-cache-pro' ), 'CCSS' ); ?> ( <?php echo esc_html( count( $ccss_queue ) ); ?> )
								<a href="<?php echo esc_url( Utility::build_url( Router::ACTION_CSS, CSS::TYPE_CLEAR_Q_CCSS ) ); ?>" class="button litespeed-btn-warning litespeed-right"><?php esc_html_e( 'Clear', 'zinn-cache-pro' ); ?></a>
							</h4>
							<p>
								<?php
								$i = 0;
								foreach ( $ccss_queue as $queue_key => $queue_val ) :
									if ( $i++ > 20 ) :
										echo '...';
										break;
									endif;
									if ( ! is_array( $queue_val ) ) {
										continue;
									}
									if ( ! empty( $queue_val['_status'] ) ) {
										echo '<span class="litespeed-success">';
									}
									echo esc_html( $queue_val['url'] );
									if ( ! empty( $queue_val['_status'] ) ) {
										echo '</span>';
									}
									$pos = strpos( $queue_key, ' ' );
									if ( $pos ) {
										echo ' (' . esc_html__( 'Vary Group', 'zinn-cache-pro' ) . ':' . esc_html( substr( $queue_key, 0, $pos ) ) . ')';
									}
									if ( $queue_val['is_mobile'] ) {
										echo ' <span data-balloon-pos="up" aria-label="mobile">📱</span>';
									}
									if ( ! empty( $queue_val['is_webp'] ) ) {
										echo ' ' . wp_kses_post( $next_gen );
									}
									echo '<br />';
								endforeach;
								?>
							</p>
						</div>
						<?php if ( $ccss_service_hot ) : ?>
							<button class="button button-secondary" disabled>
								<?php printf( esc_html__( 'Run %s Queue Manually', 'zinn-cache-pro' ), 'CCSS' ); ?>
								- <?php printf( esc_html__( 'Available after %d second(s)', 'zinn-cache-pro' ), esc_html( $ccss_service_hot ) ); ?>
							</button>
						<?php else : ?>
							<a href="<?php echo esc_url( Utility::build_url( Router::ACTION_CSS, CSS::TYPE_GEN_CCSS ) ); ?>" class="button litespeed-btn-success">
								<?php printf( esc_html__( 'Run %s Queue Manually', 'zinn-cache-pro' ), 'CCSS' ); ?>
							</a>
						<?php endif; ?>
						<?php Doc::queue_issues(); ?>
					<?php endif; ?>
				</div>
			</td>
		</tr>

		<tr>
			<th class="litespeed-padding-left">
				<?php $option_id = Base::O_OPTM_CCSS_PER_URL; ?>
				<?php $this->title( $option_id ); ?>
			</th>
			<td>
				<?php $this->build_switch( $option_id ); ?>
				<div class="litespeed-desc">
					<?php esc_html_e( 'Disable this option to generate CCSS per Post Type instead of per page. This can save significant CCSS quota, however it may result in incorrect CSS styling if your site uses a page builder.', 'zinn-cache-pro' ); ?>
				</div>
			</td>
		</tr>

		<tr>
			<th class="litespeed-padding-left">
				<?php $option_id = Base::O_OPTM_CSS_ASYNC_INLINE; ?>
				<?php $this->title( $option_id ); ?>
			</th>
			<td>
				<?php $this->build_switch( $option_id ); ?>
				<div class="litespeed-desc">
					<?php esc_html_e( 'This will inline the asynchronous CSS library to avoid render blocking.', 'zinn-cache-pro' ); ?>
				</div>
			</td>
		</tr>

		<tr>
			<th>
				<?php $option_id = Base::O_OPTM_CSS_FONT_DISPLAY; ?>
				<?php $this->title( $option_id ); ?>
			</th>
			<td>
				<?php $this->build_switch( $option_id, array( esc_html__( 'Default', 'zinn-cache-pro' ), 'Swap' ) ); ?>
				<div class="litespeed-desc">
					<?php printf( esc_html__( 'Set this to append %1$s to all %2$s rules before caching CSS to specify how fonts should be displayed while being downloaded.', 'zinn-cache-pro' ), '<code>font-display</code>', '<code>@font-face</code>' ); ?>
					<br /><?php printf( esc_html__( '%s is recommended.', 'zinn-cache-pro' ), '<code>' . esc_html__( 'Swap', 'zinn-cache-pro' ) . '</code>' ); ?>
				</div>
			</td>
		</tr>
	</tbody>
</table>