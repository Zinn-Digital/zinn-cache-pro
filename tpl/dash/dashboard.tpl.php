<?php
/**
 * Zinn® Cache Engine Dashboard
 *
 * Displays the dashboard for Zinn® Cache Engine plugin, including cache status,
 * crawler status and optimization statistics.
 *
 * @package ZinnCachePro
 * @since 1.0.0
 */

namespace ZinnCachePro;

defined( 'WPINC' ) || exit;

$health_scores   = Health::cls()->scores();
$crawler_summary = Crawler::get_summary();

// Image related info
$img_optm_summary        = Img_Optm::get_summary();
$img_count               = Img_Optm::cls()->img_count();
$img_finished_percentage = 0;
if ( ! empty( $img_count['groups_all'] ) ) {
	$img_finished_percentage = 100 - floor( $img_count['groups_new'] * 100 / $img_count['groups_all'] );
}
if ( 100 === $img_finished_percentage && ! empty( $img_count['groups_new'] ) ) {
	$img_finished_percentage = 99;
}

$cloud_instance = Cloud::cls();
$cloud_instance->finish_qc_activation();

$cloud_summary           = Cloud::get_summary();
$css_summary             = CSS::get_summary();
$ucss_summary            = UCSS::get_summary();
$placeholder_summary     = Placeholder::get_summary();
$vpi_summary             = VPI::get_summary();
$ccss_count              = count( $this->load_queue( 'ccss' ) );
$ucss_count              = count( $this->load_queue( 'ucss' ) );
$placeholder_queue_count = count( $this->load_queue( 'lqip' ) );
$vpi_queue_count         = count( $this->load_queue( 'vpi' ) );
$can_page_load_time      = defined( 'ZINN_CACHE_PRO_SERVER_TYPE' ) && 'NONE' !== ZINN_CACHE_PRO_SERVER_TYPE;

?>

<div class="litespeed-dashboard">
	<?php if ( ! $cloud_instance->activated() && ! Admin_Display::has_qc_hide_banner() ) : ?>
		<div class="litespeed-dashboard-group">
			<div class="litespeed-flex-container">
				<div class="postbox litespeed-postbox litespeed-postbox-cache">
					<div class="inside">
						<h3 class="litespeed-title">
							<?php esc_html_e( 'Cache Status', 'zinn-cache-pro' ); ?>
							<a href="<?php echo esc_url( admin_url( 'admin.php?page=zinn-cache-pro-cache' ) ); ?>" class="litespeed-title-right-icon"><?php esc_html_e( 'More', 'zinn-cache-pro' ); ?></a>
						</h3>
						<?php
						$cache_list = array(
							Base::O_CACHE         => esc_html__( 'Public Cache', 'zinn-cache-pro' ),
							Base::O_CACHE_PRIV    => esc_html__( 'Private Cache', 'zinn-cache-pro' ),
							Base::O_OBJECT        => esc_html__( 'Object Cache', 'zinn-cache-pro' ),
							Base::O_CACHE_BROWSER => esc_html__( 'Browser Cache', 'zinn-cache-pro' ),
						);
						foreach ( $cache_list as $cache_option => $cache_title ) :
							?>
							<p>
								<?php if ( $this->conf( $cache_option ) ) : ?>
									<span class="litespeed-label-success litespeed-label-dashboard"><?php esc_html_e( 'ON', 'zinn-cache-pro' ); ?></span>
								<?php else : ?>
									<span class="litespeed-label-danger litespeed-label-dashboard"><?php esc_html_e( 'OFF', 'zinn-cache-pro' ); ?></span>
								<?php endif; ?>
								<?php echo esc_html( $cache_title ); ?>
							</p>
						<?php endforeach; ?>
					</div>
				</div>

				<div class="postbox litespeed-postbox litespeed-postbox-crawler">
					<div class="inside">
						<h3 class="litespeed-title">
							<?php esc_html_e( 'Crawler Status', 'zinn-cache-pro' ); ?>
							<a href="<?php echo esc_url( admin_url( 'admin.php?page=zinn-cache-pro-crawler' ) ); ?>" class="litespeed-title-right-icon"><?php esc_html_e( 'More', 'zinn-cache-pro' ); ?></a>
						</h3>
						<p>
							<code><?php echo esc_html( count( Crawler::cls()->list_crawlers() ) ); ?></code> <?php esc_html_e( 'Crawler(s)', 'zinn-cache-pro' ); ?>
						</p>
						<p>
							<?php esc_html_e( 'Currently active crawler', 'zinn-cache-pro' ); ?>: <code><?php echo esc_html( $crawler_summary['curr_crawler'] ); ?></code>
						</p>
						<?php if ( ! empty( $crawler_summary['curr_crawler_beginning_time'] ) ) : ?>
							<p>
								<span class="litespeed-bold"><?php esc_html_e( 'Current crawler started at', 'zinn-cache-pro' ); ?>:</span>
								<?php echo esc_html( Utility::readable_time( $crawler_summary['curr_crawler_beginning_time'] ) ); ?>
							</p>
						<?php endif; ?>
						<?php if ( ! empty( $crawler_summary['last_start_time'] ) ) : ?>
							<p class="litespeed-desc">
								<span class="litespeed-bold"><?php esc_html_e( 'Last interval', 'zinn-cache-pro' ); ?>:</span>
								<?php echo esc_html( Utility::readable_time( $crawler_summary['last_start_time'] ) ); ?>
							</p>
						<?php endif; ?>
						<?php if ( ! empty( $crawler_summary['end_reason'] ) ) : ?>
							<p class="litespeed-desc">
								<span class="litespeed-bold"><?php esc_html_e( 'Ended reason', 'zinn-cache-pro' ); ?>:</span>
								<?php echo esc_html( $crawler_summary['end_reason'] ); ?>
							</p>
						<?php endif; ?>
						<?php if ( ! empty( $crawler_summary['last_crawled'] ) ) : ?>
							<p class="litespeed-desc">
								<?php
								printf(
									esc_html__( '%1$s %2$d item(s)', 'zinn-cache-pro' ),
									'<span class="litespeed-bold">' . esc_html__( 'Last crawled:', 'zinn-cache-pro' ) . '</span>',
									esc_html( $crawler_summary['last_crawled'] )
								);
								?>
							</p>
						<?php endif; ?>
					</div>
				</div>

				<?php
				$news = $cloud_instance->load_qc_status_for_dash( 'news_dash_guest' );
				if ( ! empty( $news ) ) :
					?>
					<div class="postbox litespeed-postbox">
						<div class="inside litespeed-text-center">
							<h3 class="litespeed-title">
								<?php esc_html_e( 'News', 'zinn-cache-pro' ); ?>
							</h3>
							<div class="litespeed-top20">
								<?php echo wp_kses_post( $news ); ?>
							</div>
						</div>
					</div>
				<?php endif; ?>
			</div>
		</div>
	<?php endif; ?>

</div>