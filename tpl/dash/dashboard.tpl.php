<?php
/**
 * Zinn® Cache Engine Dashboard
 *
 * Displays the dashboard for Zinn® Cache Engine plugin, including cache status,
 * crawler status, QUIC.cloud service usage, and optimization statistics.
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

	<div class="litespeed-dashboard-qc">

		<div class="litespeed-dashboard-qc-enable">
			<div class="litespeed-dashboard-header">
				<h3 class="litespeed-dashboard-title litespeed-dashboard-title--w-btn">
					<span class="litespeed-right10"><?php esc_html_e( 'QUIC.cloud Service Usage Statistics', 'zinn-cache-pro' ); ?></span>
					<a href="<?php echo esc_url( Utility::build_url( Router::ACTION_CLOUD, Cloud::TYPE_SYNC_USAGE ) ); ?>" class="button button-secondary button-small">
						<span class="dashicons dashicons-update"></span> <?php esc_html_e( 'Refresh Usage', 'zinn-cache-pro' ); ?>
						<span class="screen-reader-text"><?php esc_html_e( 'Sync data from Cloud', 'zinn-cache-pro' ); ?></span>
					</a>
				</h3>
				<hr>
				<a href="https://docs.litespeedtech.com/lscache/lscwp/dashboard/#usage-statistics" target="_blank" class="litespeed-learn-more"><?php esc_html_e( 'Learn More', 'zinn-cache-pro' ); ?></a>
			</div>

			<?php if ( ! $cloud_instance->activated() && Admin_Display::has_qc_hide_banner() ) : ?>
				<p class="litespeed-desc litespeed-margin-top-remove">
					<?php
					printf(
						esc_html__( 'The features below are provided by %s', 'zinn-cache-pro' ),
						'<a href="https://quic.cloud" target="_blank">QUIC.cloud</a>'
					);
					?>
				</p>
			<?php endif; ?>

			<div class="litespeed-dashboard-stats-wrapper">
				<?php
				$cat_list = array(
					'img_optm'  => esc_html__( 'Image Optimization', 'zinn-cache-pro' ),
					'page_optm' => esc_html__( 'Page Optimization', 'zinn-cache-pro' ),
					'cdn'       => esc_html__( 'CDN Bandwidth', 'zinn-cache-pro' ),
					'lqip'      => esc_html__( 'Low Quality Image Placeholder', 'zinn-cache-pro' ),
				);

				foreach ( $cat_list as $svc => $svc_title ) :
					$finished_percentage = 0;
					$total_used          = '-';
					$used                = '-';
					$quota               = '-';
					$pag_used            = '-';
					$pag_total           = '-';
					$pag_width           = 0;
					$percentage_bg       = 'success';
					$pag_txt_color       = '';
					$usage               = false;

					if ( ! empty( $cloud_summary[ 'usage.' . $svc ] ) ) {
						$usage               = $cloud_summary[ 'usage.' . $svc ];
						$finished_percentage = floor( $usage['used'] * 100 / $usage['quota'] );
						$used                = (int) $usage['used'];
						$quota               = (int) $usage['quota'];
						$pag_used            = ! empty( $usage['pag_used'] ) ? (int) $usage['pag_used'] : 0;
						$pag_bal             = ! empty( $usage['pag_bal'] ) ? (int) $usage['pag_bal'] : 0;
						$pag_total           = $pag_used + $pag_bal;
						if ( ! empty( $usage['total_used'] ) ) {
							$total_used = (int) $usage['total_used'];
						}

						if ( $pag_total ) {
							$pag_width = round( $pag_used / $pag_total * 100 ) . '%';
						}

						if ( $finished_percentage > 85 ) {
							$percentage_bg = 'warning';
							if ( $finished_percentage > 95 ) {
								$percentage_bg = 'danger';
								if ( $pag_bal ) {
									$percentage_bg = 'warning';
									$pag_txt_color = 'litespeed-success';
								}
							}
						}
					}
					?>
					<div class="postbox litespeed-postbox">
						<div class="inside">
							<h3 class="litespeed-title"><?php echo esc_html( $svc_title ); ?></h3>
							<div class="litespeed-flex-container">
								<div class="litespeed-icon-vertical-middle litespeed-pie-<?php echo esc_attr( $percentage_bg ); ?>">
									<?php echo wp_kses( GUI::pie( $finished_percentage, 60, false ), GUI::allowed_svg_tags() ); ?>
								</div>
								<div>
									<div class="litespeed-dashboard-stats">
										<h3><?php echo 'img_optm' === $svc ? esc_html__( 'Fast Queue Usage', 'zinn-cache-pro' ) : esc_html__( 'Usage', 'zinn-cache-pro' ); ?></h3>
										<p>
											<strong><?php echo esc_html( $used ); ?></strong>
											<?php if ( $used !== $quota ) : ?>
												<span class="litespeed-desc"> / <?php echo esc_html( $quota ); ?></span>
											<?php endif; ?>
										</p>
									</div>
								</div>
							</div>
							<?php if ( $pag_total > 0 ) : ?>
								<p class="litespeed-dashboard-stats-payg <?php echo esc_attr( $pag_txt_color ); ?>">
									<?php esc_html_e( 'PAYG Balance', 'zinn-cache-pro' ); ?>: <strong><?php echo esc_html( $pag_bal ); ?></strong>
									<button class="litespeed-info-button" data-balloon-pos="up" aria-label="<?php echo esc_attr( sprintf( esc_html__( 'PAYG used this month: %s. PAYG balance and usage not included in above quota calculation.', 'zinn-cache-pro' ), $pag_used ) ); ?>">
										<span class="dashicons dashicons-info"></span>
										<span class="screen-reader-text"><?php esc_html_e( 'Pay as You Go Usage Statistics', 'zinn-cache-pro' ); ?></span>
									</button>
								</p>
							<?php endif; ?>
							<?php if ( 'page_optm' === $svc && ! empty( $usage['sub_svc'] ) ) : ?>
								<p class="litespeed-dashboard-stats-total">
									<?php
									$i = 0;
									foreach ( $usage['sub_svc'] as $sub_svc => $sub_usage ) :
										?>
										<span class="<?php echo $i++ > 0 ? 'litespeed-left10' : ''; ?>">
											<?php echo esc_html( strtoupper( $sub_svc ) ); ?>: <strong><?php echo (int) $sub_usage; ?></strong>
										</span>
									<?php endforeach; ?>
								</p>
							<?php endif; ?>
							<?php if ( 'img_optm' === $svc ) : ?>
								<p class="litespeed-dashboard-stats-total">
									<?php esc_html_e( 'Total Usage', 'zinn-cache-pro' ); ?>: <strong><?php echo esc_html( $total_used ); ?> / ∞</strong>
									<button class="litespeed-info-button" data-balloon-pos="up" aria-label="<?php esc_attr_e( 'Total images optimized in this month', 'zinn-cache-pro' ); ?>">
										<span class="dashicons dashicons-info"></span>
									</button>
								</p>
								<div class="clear"></div>
							<?php endif; ?>
							<?php if ( isset( $usage['remaining_daily_quota'] ) && $usage['remaining_daily_quota'] >= 0 && isset( $usage['daily_quota'] ) && $usage['daily_quota'] >= 0 ) : ?>
								<p class="litespeed-dashboard-stats-total">
									<?php esc_html_e( 'Remaining Daily Quota', 'zinn-cache-pro' ); ?>: <strong><?php echo esc_html( $usage['remaining_daily_quota'] ); ?> / <?php echo esc_html( $usage['daily_quota'] ); ?></strong>
								</p>
								<div class="clear"></div>
							<?php endif; ?>
						</div>
					</div>
				<?php endforeach; ?>
				<?php if ( ! empty( $cloud_summary['partner'] ) ) : ?>
					<div class="litespeed-postbox litespeed-postbox-partner">
						<div class="inside">
							<h3 class="litespeed-title"><?php esc_html_e( 'Partner Benefits Provided by', 'zinn-cache-pro' ); ?></h3>
							<div>
								<?php if ( ! empty( $cloud_summary['partner']['logo'] ) ) : ?>
									<?php if ( ! empty( $cloud_summary['partner']['url'] ) ) : ?>
										<a href="<?php echo esc_url( $cloud_summary['partner']['url'] ); ?>" target="_blank">
											<img src="<?php echo esc_url( $cloud_summary['partner']['logo'] ); ?>" alt="<?php echo esc_attr( $cloud_summary['partner']['name'] ); ?>">
										</a>
									<?php else : ?>
										<img src="<?php echo esc_url( $cloud_summary['partner']['logo'] ); ?>" alt="<?php echo esc_attr( $cloud_summary['partner']['name'] ); ?>">
									<?php endif; ?>
								<?php elseif ( ! empty( $cloud_summary['partner']['name'] ) ) : ?>
									<?php if ( ! empty( $cloud_summary['partner']['url'] ) ) : ?>
										<a href="<?php echo esc_url( $cloud_summary['partner']['url'] ); ?>" target="_blank">
											<span class="postbox-partner-name"><?php echo esc_html( $cloud_summary['partner']['name'] ); ?></span>
										</a>
									<?php else : ?>
										<span class="postbox-partner-name"><?php echo esc_html( $cloud_summary['partner']['name'] ); ?></span>
									<?php endif; ?>
								<?php endif; ?>
							</div>
						</div>
					</div>
				<?php endif; ?>
			</div>

			<p class="litespeed-right litespeed-qc-dashboard-link">
				<?php
				if ( ! empty( $cloud_summary['partner'] ) && ! empty( $cloud_summary['partner']['login_title'] ) && ! empty( $cloud_summary['partner']['login_link'] ) ) :
					Doc::learn_more( $cloud_summary['partner']['login_link'], $cloud_summary['partner']['login_title'], true, 'button litespeed-btn-warning' );
				elseif ( ! empty( $cloud_summary['partner'] ) && ! empty( $cloud_summary['partner']['disable_qc_login'] ) ) :
					// Skip rendering any link or button.
					echo '';
				else :
					if ( ! $cloud_instance->activated() ) :
						Doc::learn_more(
							Utility::build_url( Router::ACTION_CLOUD, Cloud::TYPE_ACTIVATE ),
							esc_html__( 'Enable QUIC.cloud Services', 'zinn-cache-pro' ),
							true,
							'button litespeed-btn-warning'
						);
					elseif ( ! empty( $cloud_summary['qc_activated'] ) && 'anonymous' !== $cloud_summary['qc_activated'] ) :
						?>
						<a href="<?php echo esc_url( $cloud_instance->qc_link() ); ?>" class="litespeed-link-with-icon" target="qc">
							<?php esc_html_e( 'Go to QUIC.cloud dashboard', 'zinn-cache-pro' ); ?> <span class="dashicons dashicons-external"></span>
						</a>
					<?php else : ?>
						<?php
						Doc::learn_more(
							Utility::build_url( Router::ACTION_CLOUD, Cloud::TYPE_LINK ),
							esc_html__( 'Link to QUIC.cloud', 'zinn-cache-pro' ),
							true,
							'button litespeed-btn-warning'
						);
						?>
					<?php endif; ?>
				<?php endif; ?>
			</p>

			<div class="litespeed-dashboard-group">
				<hr>
				<div class="litespeed-flex-container">
					<div class="postbox litespeed-postbox litespeed-postbox-pagetime">
						<div class="inside">
							<h3 class="litespeed-title">
								<?php esc_html_e( 'Page Load Time', 'zinn-cache-pro' ); ?>
								<?php if ( $can_page_load_time ) : ?>
									<?php $closest_server = Cloud::get_summary( 'server.' . Cloud::SVC_HEALTH ); ?>
									<?php if ( $closest_server ) : ?>
										<a href="<?php echo esc_url( Utility::build_url( Router::ACTION_CLOUD, Cloud::TYPE_REDETECT_CLOUD, false, null, array( 'svc' => Cloud::SVC_HEALTH ) ) ); ?>"
											data-balloon-pos="up"
											data-balloon-break
											aria-label="<?php echo esc_attr( sprintf( esc_html__( 'Current closest Cloud server is %s. Click to redetect.', 'zinn-cache-pro' ), esc_html( $closest_server ) ) ); ?>"
											data-zinn-cache-pro-cfm="<?php esc_attr_e( 'Are you sure you want to redetect the closest cloud server for this service?', 'zinn-cache-pro' ); ?>"
											class="litespeed-title-right-icon">
											<i class='litespeed-quic-icon'></i> <small><?php esc_html_e( 'Redetect', 'zinn-cache-pro' ); ?></small>
										</a>
									<?php endif; ?>
								<?php endif; ?>
							</h3>
							<div>
								<div class="litespeed-flex-container">
									<?php if ( $can_page_load_time && ! empty( $health_scores['speed_before'] ) ) : ?>
										<div class="litespeed-score-col">
											<p class="litespeed-text-grey">
												<?php esc_html_e( 'Before', 'zinn-cache-pro' ); ?>
											</p>
											<div class="litespeed-text-md litespeed-text-grey">
												<?php echo esc_html( $health_scores['speed_before'] ); ?><span class="litespeed-text-large">s</span>
											</div>
										</div>
										<div class="litespeed-score-col">
											<p class="litespeed-text-grey">
												<?php esc_html_e( 'After', 'zinn-cache-pro' ); ?>
											</p>
											<div class="litespeed-text-md litespeed-text-success">
												<?php echo esc_html( $health_scores['speed_after'] ); ?><span class="litespeed-text-large">s</span>
											</div>
										</div>
										<div class="litespeed-score-col litespeed-score-col--imp">
											<p class="litespeed-text-grey" style="white-space: nowrap;">
												<?php esc_html_e( 'Improved by', 'zinn-cache-pro' ); ?>
											</p>
											<div class="litespeed-text-jumbo litespeed-text-success">
												<?php echo esc_html( $health_scores['speed_improved'] ); ?><span class="litespeed-text-large">%</span>
											</div>
										</div>
									<?php else : ?>
										<div>
											<p><?php esc_html_e( 'You must be using one of the following products in order to measure Page Load Time:', 'zinn-cache-pro' ); ?></p>
											<a href="https://www.litespeedtech.com/products/litespeed-web-server" target="_blank"><?php esc_html_e( 'LiteSpeed Web Server', 'zinn-cache-pro' ); ?></a>
											<br />
											<a href="https://openlitespeed.org/" target="_blank"><?php esc_html_e( 'OpenLiteSpeed Web Server', 'zinn-cache-pro' ); ?></a>
											<br />
											<a href="https://www.litespeedtech.com/products/litespeed-web-adc" target="_blank"><?php esc_html_e( 'LiteSpeed Web ADC', 'zinn-cache-pro' ); ?></a>
											<br />
											<a href="https://quic.cloud" target="_blank"><?php esc_html_e( 'QUIC.cloud CDN', 'zinn-cache-pro' ); ?></a>
										</div>
									<?php endif; ?>
								</div>
							</div>
						</div>
						<?php if ( $can_page_load_time ) : ?>
							<div class="inside litespeed-postbox-footer litespeed-postbox-footer--compact">
								<?php if ( ! empty( $cloud_summary['last_request.health-speed'] ) ) : ?>
									<span class="litespeed-right10">
										<?php
										printf(
											esc_html__( 'Requested: %s ago', 'zinn-cache-pro' ),
											'<span data-balloon-pos="up" aria-label="' . esc_attr( Utility::readable_time( $cloud_summary['last_request.health-speed'] ) ) . '">' . esc_html( human_time_diff( $cloud_summary['last_request.health-speed'] ) ) . '</span>'
										);
										?>
									</span>
								<?php endif; ?>
								<a href="<?php echo esc_url( Utility::build_url( Router::ACTION_HEALTH, Health::TYPE_SPEED ) ); ?>" class="button button-secondary button-small">
									<span class="dashicons dashicons-update"></span>
									<?php esc_html_e( 'Refresh', 'zinn-cache-pro' ); ?>
									<span class="screen-reader-text"><?php esc_html_e( 'Refresh page load time', 'zinn-cache-pro' ); ?></span>
								</a>
							</div>
						<?php endif; ?>
					</div>

					<div class="postbox litespeed-postbox litespeed-postbox-pagespeed">
						<div class="inside">
							<h3 class="litespeed-title">
								<?php esc_html_e( 'PageSpeed Score', 'zinn-cache-pro' ); ?>
								<?php $guest_option = Base::O_GUEST; ?>
								<a href="<?php echo esc_url( admin_url( 'admin.php?page=zinn-cache-pro-general#settings' ) ); ?>" class="litespeed-title-right-icon"><?php echo esc_html( Lang::title( $guest_option ) ); ?></a>
								<?php if ( $this->conf( $guest_option ) ) : ?>
									<span class="litespeed-label-success litespeed-label-dashboard"><?php esc_html_e( 'ON', 'zinn-cache-pro' ); ?></span>
								<?php else : ?>
									<span class="litespeed-label-danger litespeed-label-dashboard"><?php esc_html_e( 'OFF', 'zinn-cache-pro' ); ?></span>
								<?php endif; ?>
							</h3>
							<div>
								<div class="litespeed-margin-bottom20">
									<div class="litespeed-row-flex" style="margin-left: -10px;">
										<?php if ( ! empty( $health_scores['score_before'] ) ) : ?>
											<div class="litespeed-width-1-3 litespeed-padding-space litespeed-margin-x5">
												<p class="litespeed-text-grey litespeed-text-center">
													<?php esc_html_e( 'Before', 'zinn-cache-pro' ); ?>
												</p>
												<div class="litespeed-promo-score">
													<?php echo wp_kses( GUI::pie( $health_scores['score_before'], 45, false, true, 'litespeed-pie-' . esc_attr( GUI::cls()->get_cls_of_pagescore( $health_scores['score_before'] ) ) ), GUI::allowed_svg_tags() ); ?>
												</div>
											</div>
											<div class="litespeed-width-1-3 litespeed-padding-space litespeed-margin-x5">
												<p class="litespeed-text-grey litespeed-text-center">
													<?php esc_html_e( 'After', 'zinn-cache-pro' ); ?>
												</p>
												<div class="litespeed-promo-score">
													<?php echo wp_kses( GUI::pie( $health_scores['score_after'], 45, false, true, 'litespeed-pie-' . esc_attr( GUI::cls()->get_cls_of_pagescore( $health_scores['score_after'] ) ) ), GUI::allowed_svg_tags() ); ?>
												</div>
											</div>
											<div class="litespeed-width-1-3 litespeed-padding-space litespeed-margin-x5">
												<p class="litespeed-text-grey" style="white-space: nowrap;">
													<?php esc_html_e( 'Improved by', 'zinn-cache-pro' ); ?>
												</p>
												<div class="litespeed-postbox-score-improve litespeed-text-fern">
													<?php echo esc_html( $health_scores['score_improved'] ); ?><span class="litespeed-text-large">%</span>
												</div>
											</div>
										<?php endif; ?>
									</div>
								</div>
							</div>
						</div>
						<div class="inside litespeed-postbox-footer litespeed-postbox-footer--compact">
							<?php if ( ! empty( $cloud_summary['last_request.health-score'] ) ) : ?>
								<span class="litespeed-right10">
									<?php
									printf(
										esc_html__( 'Requested: %s ago', 'zinn-cache-pro' ),
										'<span data-balloon-pos="up" aria-label="' . esc_attr( Utility::readable_time( $cloud_summary['last_request.health-score'] ) ) . '">' . esc_html( human_time_diff( $cloud_summary['last_request.health-score'] ) ) . '</span>'
									);
									?>
								</span>
							<?php endif; ?>
							<a href="<?php echo esc_url( Utility::build_url( Router::ACTION_HEALTH, Health::TYPE_SCORE ) ); ?>" class="button button-secondary button-small">
								<span class="dashicons dashicons-update"></span>
								<?php esc_html_e( 'Refresh', 'zinn-cache-pro' ); ?>
								<span class="screen-reader-text"><?php esc_html_e( 'Refresh page score', 'zinn-cache-pro' ); ?></span>
							</a>
						</div>
					</div>

					<div class="postbox litespeed-postbox litespeed-postbox-double litespeed-postbox-imgopt">
						<div class="inside">
							<h3 class="litespeed-title">
								<?php esc_html_e( 'Image Optimization Summary', 'zinn-cache-pro' ); ?>
								<a href="<?php echo esc_url( admin_url( 'admin.php?page=zinn-cache-pro-img_optm' ) ); ?>" class="litespeed-title-right-icon"><?php esc_html_e( 'More', 'zinn-cache-pro' ); ?></a>
							</h3>
							<div class="litespeed-postbox-double-content">
								<div class="litespeed-postbox-double-col">
									<div class="litespeed-flex-container">
										<div class="litespeed-icon-vertical-middle">
											<?php echo wp_kses( GUI::pie( $img_finished_percentage, 70, true ), GUI::allowed_svg_tags() ); ?>
										</div>
										<div>
											<div class="litespeed-dashboard-stats">
												<a data-zinn-cache-pro-onlyonce class="button button-primary"
													<?php if ( ! empty( $img_count['groups_new'] ) || ! empty( $img_count[ 'groups.' . Img_Optm::STATUS_RAW ] ) ) : ?>
														href="<?php echo esc_url( Utility::build_url( Router::ACTION_IMG_OPTM, Img_Optm::TYPE_NEW_REQ ) ); ?>"
													<?php else : ?>
														href="javascript:;" disabled
													<?php endif; ?>>
													<span class="dashicons dashicons-images-alt2"></span><?php esc_html_e( 'Send Optimization Request', 'zinn-cache-pro' ); ?>
												</a>
											</div>
										</div>
									</div>
									<p>
										<?php esc_html_e( 'Total Reduction', 'zinn-cache-pro' ); ?>: <code><?php echo isset( $img_optm_summary['reduced'] ) ? esc_html( Utility::real_size( $img_optm_summary['reduced'] ) ) : '-'; ?></code>
									</p>
									<p>
										<?php esc_html_e( 'Images Pulled', 'zinn-cache-pro' ); ?>: <code><?php echo isset( $img_optm_summary['img_taken'] ) ? esc_html( $img_optm_summary['img_taken'] ) : '-'; ?></code>
									</p>
								</div>
								<div class="litespeed-postbox-double-col">
									<?php if ( ! empty( $img_count[ 'group.' . Img_Optm::STATUS_REQUESTED ] ) ) : ?>
										<p class="litespeed-success">
											<?php esc_html_e( 'Images requested', 'zinn-cache-pro' ); ?>:
											<code>
												<?php echo esc_html( Admin_Display::print_plural( $img_count[ 'group.' . Img_Optm::STATUS_REQUESTED ] ) ); ?>
												(<?php echo esc_html( Admin_Display::print_plural( $img_count[ 'img.' . Img_Optm::STATUS_REQUESTED ], 'image' ) ); ?>)
											</code>
										</p>
									<?php endif; ?>
									<?php if ( ! empty( $img_count[ 'group.' . Img_Optm::STATUS_NOTIFIED ] ) ) : ?>
										<p class="litespeed-success">
											<?php esc_html_e( 'Images notified to pull', 'zinn-cache-pro' ); ?>:
											<code>
												<?php echo esc_html( Admin_Display::print_plural( $img_count[ 'group.' . Img_Optm::STATUS_NOTIFIED ] ) ); ?>
												(<?php echo esc_html( Admin_Display::print_plural( $img_count[ 'img.' . Img_Optm::STATUS_NOTIFIED ], 'image' ) ); ?>)
											</code>
										</p>
									<?php endif; ?>
									<p>
										<?php esc_html_e( 'Last Request', 'zinn-cache-pro' ); ?>: <code><?php echo ! empty( $img_optm_summary['last_requested'] ) ? esc_html( Utility::readable_time( $img_optm_summary['last_requested'] ) ) : '-'; ?></code>
									</p>
									<p>
										<?php esc_html_e( 'Last Pull', 'zinn-cache-pro' ); ?>: <code><?php echo ! empty( $img_optm_summary['last_pull'] ) ? esc_html( Utility::readable_time( $img_optm_summary['last_pull'] ) ) : '-'; ?></code>
									</p>
									<?php
									$opt_list = array(
										Base::O_IMG_OPTM_AUTO => Lang::title( Base::O_IMG_OPTM_AUTO ),
									);
									foreach ( $opt_list as $opt_id => $opt_title ) :
										?>
										<p>
											<?php if ( $this->conf( $opt_id ) ) : ?>
												<span class="litespeed-label-success litespeed-label-dashboard"><?php esc_html_e( 'ON', 'zinn-cache-pro' ); ?></span>
											<?php else : ?>
												<span class="litespeed-label-danger litespeed-label-dashboard"><?php esc_html_e( 'OFF', 'zinn-cache-pro' ); ?></span>
											<?php endif; ?>
											<a href="<?php echo esc_url( admin_url( 'admin.php?page=zinn-cache-pro-img_optm#settings' ) ); ?>"><?php echo esc_html( $opt_title ); ?></a>
										</p>
									<?php endforeach; ?>
								</div>
							</div>
						</div>
					</div>

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

					<div class="postbox litespeed-postbox litespeed-postbox-ccss">
						<div class="inside">
							<h3 class="litespeed-title">
								<?php esc_html_e( 'Critical CSS', 'zinn-cache-pro' ); ?>
								<a href="<?php echo esc_url( admin_url( 'admin.php?page=zinn-cache-pro-page_optm#settings_css' ) ); ?>" class="litespeed-title-right-icon"><?php esc_html_e( 'More', 'zinn-cache-pro' ); ?></a>
							</h3>
							<?php if ( ! empty( $css_summary['last_request_ccss'] ) ) : ?>
								<p>
									<?php
									printf(
										esc_html__( 'Last generated: %s', 'zinn-cache-pro' ),
										'<code>' . esc_html( Utility::readable_time( $css_summary['last_request_ccss'] ) ) . '</code>'
									);
									?>
								</p>
								<p>
									<?php
									printf(
										esc_html__( 'Time to execute previous request: %s', 'zinn-cache-pro' ),
										'<code>' . esc_html( $css_summary['last_spent_ccss'] ) . 's</code>'
									);
									?>
								</p>
							<?php endif; ?>
							<p>
								<?php esc_html_e( 'Requests in queue', 'zinn-cache-pro' ); ?>: <code><?php echo ! empty( $ccss_count ) ? esc_html( $ccss_count ) : '-'; ?></code>
								<a href="<?php echo ! empty( $ccss_count ) ? esc_url( Utility::build_url( Router::ACTION_CSS, CSS::TYPE_GEN_CCSS ) ) : 'javascript:;'; ?>"
									class="button button-secondary button-small <?php echo empty( $ccss_count ) ? 'disabled' : ''; ?>">
									<?php esc_html_e( 'Force cron', 'zinn-cache-pro' ); ?>
								</a>
							</p>
						</div>
						<?php if ( ! empty( $cloud_summary['last_request.ccss'] ) ) : ?>
							<div class="inside litespeed-postbox-footer litespeed-postbox-footer--compact">
								<?php
								printf(
									esc_html__( 'Last requested: %s', 'zinn-cache-pro' ),
									esc_html( Utility::readable_time( $cloud_summary['last_request.ccss'] ) )
								);
								?>
							</div>
						<?php endif; ?>
					</div>

					<div class="postbox litespeed-postbox litespeed-postbox-ucss">
						<div class="inside">
							<h3 class="litespeed-title">
								<?php esc_html_e( 'Unique CSS', 'zinn-cache-pro' ); ?>
								<a href="<?php echo esc_url( admin_url( 'admin.php?page=zinn-cache-pro-page_optm#settings_css' ) ); ?>" class="litespeed-title-right-icon"><?php esc_html_e( 'More', 'zinn-cache-pro' ); ?></a>
							</h3>
							<?php if ( ! empty( $ucss_summary['last_request'] ) ) : ?>
								<p>
									<?php
									printf(
										esc_html__( 'Last generated: %s', 'zinn-cache-pro' ),
										'<code>' . esc_html( Utility::readable_time( $ucss_summary['last_request'] ) ) . '</code>'
									);
									?>
								</p>
								<p>
									<?php
									printf(
										esc_html__( 'Time to execute previous request: %s', 'zinn-cache-pro' ),
										'<code>' . esc_html( $ucss_summary['last_spent'] ) . 's</code>'
									);
									?>
								</p>
							<?php endif; ?>
							<p>
								<?php esc_html_e( 'Requests in queue', 'zinn-cache-pro' ); ?>: <code><?php echo ! empty( $ucss_count ) ? esc_html( $ucss_count ) : '-'; ?></code>
								<a href="<?php echo ! empty( $ucss_count ) ? esc_url( Utility::build_url( Router::ACTION_UCSS, UCSS::TYPE_GEN ) ) : 'javascript:;'; ?>"
									class="button button-secondary button-small <?php echo empty( $ucss_count ) ? 'disabled' : ''; ?>">
									<?php esc_html_e( 'Force cron', 'zinn-cache-pro' ); ?>
								</a>
							</p>
						</div>
						<?php if ( ! empty( $cloud_summary['last_request.ucss'] ) ) : ?>
							<div class="inside litespeed-postbox-footer litespeed-postbox-footer--compact">
								<?php
								printf(
									esc_html__( 'Last requested: %s', 'zinn-cache-pro' ),
									esc_html( Utility::readable_time( $cloud_summary['last_request.ucss'] ) )
								);
								?>
							</div>
						<?php endif; ?>
					</div>

					<div class="postbox litespeed-postbox litespeed-postbox-lqip">
						<div class="inside">
							<h3 class="litespeed-title">
								<?php esc_html_e( 'Low Quality Image Placeholder', 'zinn-cache-pro' ); ?>
								<a href="<?php echo esc_url( admin_url( 'admin.php?page=zinn-cache-pro-page_optm#settings_media' ) ); ?>" class="litespeed-title-right-icon"><?php esc_html_e( 'More', 'zinn-cache-pro' ); ?></a>
							</h3>
							<?php if ( ! empty( $placeholder_summary['last_request'] ) ) : ?>
								<p>
									<?php
									printf(
										esc_html__( 'Last generated: %s', 'zinn-cache-pro' ),
										'<code>' . esc_html( Utility::readable_time( $placeholder_summary['last_request'] ) ) . '</code>'
									);
									?>
								</p>
								<p>
									<?php
									printf(
										esc_html__( 'Time to execute previous request: %s', 'zinn-cache-pro' ),
										'<code>' . esc_html( $placeholder_summary['last_spent'] ) . 's</code>'
									);
									?>
								</p>
							<?php endif; ?>
							<p>
								<?php esc_html_e( 'Requests in queue', 'zinn-cache-pro' ); ?>: <code><?php echo ! empty( $placeholder_queue_count ) ? esc_html( $placeholder_queue_count ) : '-'; ?></code>
								<a href="<?php echo ! empty( $placeholder_queue_count ) ? esc_url( Utility::build_url( Router::ACTION_PLACEHOLDER, Placeholder::TYPE_GENERATE ) ) : 'javascript:;'; ?>"
									class="button button-secondary button-small <?php echo empty( $placeholder_queue_count ) ? 'disabled' : ''; ?>">
									<?php esc_html_e( 'Force cron', 'zinn-cache-pro' ); ?>
								</a>
							</p>
						</div>
						<?php if ( ! empty( $cloud_summary['last_request.lqip'] ) ) : ?>
							<div class="inside litespeed-postbox-footer litespeed-postbox-footer--compact">
								<?php
								printf(
									esc_html__( 'Last requested: %s', 'zinn-cache-pro' ),
									esc_html( Utility::readable_time( $cloud_summary['last_request.lqip'] ) )
								);
								?>
							</div>
						<?php endif; ?>
					</div>

					<div class="postbox litespeed-postbox litespeed-postbox-vpi">
						<div class="inside">
							<h3 class="litespeed-title">
								<?php esc_html_e( 'Viewport Image', 'zinn-cache-pro' ); ?> (VPI)
								<a href="<?php echo esc_url( admin_url( 'admin.php?page=zinn-cache-pro-page_optm#settings_vpi' ) ); ?>" class="litespeed-title-right-icon"><?php esc_html_e( 'More', 'zinn-cache-pro' ); ?></a>
							</h3>
							<?php if ( ! empty( $vpi_summary['last_request'] ) ) : ?>
								<p>
									<?php
									printf(
										esc_html__( 'Last generated: %s', 'zinn-cache-pro' ),
										'<code>' . esc_html( Utility::readable_time( $vpi_summary['last_request'] ) ) . '</code>'
									);
									?>
								</p>
								<p>
									<?php
									printf(
										esc_html__( 'Time to execute previous request: %s', 'zinn-cache-pro' ),
										'<code>' . esc_html( $vpi_summary['last_spent'] ) . 's</code>'
									);
									?>
								</p>
							<?php endif; ?>
							<p>
								<?php esc_html_e( 'Requests in queue', 'zinn-cache-pro' ); ?>: <code><?php echo ! empty( $vpi_queue_count ) ? esc_html( $vpi_queue_count ) : '-'; ?></code>
								<a href="<?php echo ! empty( $vpi_queue_count ) ? esc_url( Utility::build_url( Router::ACTION_VPI, VPI::TYPE_GEN ) ) : 'javascript:;'; ?>"
									class="button button-secondary button-small <?php echo empty( $vpi_queue_count ) ? 'disabled' : ''; ?>">
									<?php esc_html_e( 'Force cron', 'zinn-cache-pro' ); ?>
								</a>
							</p>
						</div>
						<?php if ( ! empty( $cloud_summary['last_request.vpi'] ) ) : ?>
							<div class="inside litespeed-postbox-footer litespeed-postbox-footer--compact">
								<?php
								printf(
									esc_html__( 'Last requested: %s', 'zinn-cache-pro' ),
									esc_html( Utility::readable_time( $cloud_summary['last_request.vpi'] ) )
								);
								?>
							</div>
						<?php endif; ?>
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

					<div class="postbox litespeed-postbox litespeed-postbox-quiccloud <?php echo empty( $cloud_summary['qc_activated'] ) || 'cdn' !== $cloud_summary['qc_activated'] ? 'litespeed-postbox--quiccloud' : ''; ?>">
						<div class="inside">
							<h3 class="litespeed-title litespeed-dashboard-title--w-btn">
								<span class="litespeed-quic-icon"></span><?php esc_html_e( 'QUIC.cloud CDN', 'zinn-cache-pro' ); ?>
								<?php if ( empty( $cloud_summary['qc_activated'] ) || 'cdn' !== $cloud_summary['qc_activated'] ) : ?>
									<a href="https://quic.cloud/" class="litespeed-title-right-icon" target="_blank"><?php esc_html_e( 'Learn More', 'zinn-cache-pro' ); ?></a>
								<?php else : ?>
									<a href="<?php echo esc_url( admin_url( 'admin.php?page=zinn-cache-pro-cdn' ) ); ?>" class="litespeed-title-right-icon"><?php esc_html_e( 'More', 'zinn-cache-pro' ); ?></a>
								<?php endif; ?>
							</h3>
							<?php if ( empty( $cloud_summary['qc_activated'] ) || 'cdn' !== $cloud_summary['qc_activated'] ) : ?>
								<div class="litespeed-text-center litespeed-empty-space-medium">
									<p class="litespeed-margin-bottom20">
										<?php
										Doc::learn_more(
											esc_url( Utility::build_url( Router::ACTION_CLOUD, $cloud_instance->activated() ? Cloud::TYPE_ENABLE_CDN : Cloud::TYPE_ACTIVATE ) ),
											'<span class="dashicons dashicons-saved"></span>' . esc_html__( 'Enable QUIC.cloud CDN', 'zinn-cache-pro' ),
											true,
											'button button-primary litespeed-button-cta'
										);
										?>
									</p>
									<p class="litespeed-margin-bottom10 litespeed-top20 litespeed-text-md">
										<strong class="litespeed-qc-text-gradient"><?php esc_html_e( 'Best available WordPress performance', 'zinn-cache-pro' ); ?></strong>
									</p>
									<p class="litespeed-margin-bottom20 litespeed-margin-top-remove">
										<?php
										printf(
											esc_html__( 'Globally fast TTFB, easy setup, and %s!', 'zinn-cache-pro' ),
											'<a href="https://quic.cloud/" target="_blank">' . esc_html__( 'more', 'zinn-cache-pro' ) . '</a>'
										);
										?>
									</p>
								</div>
							<?php else : ?>
								<?php echo wp_kses_post( $cloud_instance->load_qc_status_for_dash( 'cdn_dash_mini' ) ); ?>
							<?php endif; ?>
						</div>
						<?php if ( $cloud_instance->activated() ) : ?>
							<div class="inside litespeed-postbox-footer litespeed-postbox-footer--compact">
								<a href="<?php echo esc_url( Utility::build_url( Router::ACTION_CLOUD, Cloud::TYPE_SYNC_STATUS ) ); ?>"
									class="button button-<?php echo 'cdn' !== $cloud_summary['qc_activated'] ? 'link' : 'secondary'; ?> button-small">
									<?php if ( 'cdn' === $cloud_summary['qc_activated'] ) : ?>
										<span class="dashicons dashicons-update"></span>
									<?php endif; ?>
									<?php esc_html_e( 'Refresh Status', 'zinn-cache-pro' ); ?>
									<span class="screen-reader-text"><?php esc_html_e( 'Refresh QUIC.cloud status', 'zinn-cache-pro' ); ?></span>
								</a>
							</div>
						<?php endif; ?>
					</div>

					<?php
					$promo_mini = $cloud_instance->load_qc_status_for_dash( 'promo_mini' );
					if ( $promo_mini ) :
						echo wp_kses_post( $promo_mini );
					endif;
					?>

					<?php if ( $cloud_instance->activated() ) : ?>
						<?php
						$news = $cloud_instance->load_qc_status_for_dash( 'news_dash' );
						if ( $news ) :
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
					<?php endif; ?>
				</div>
			</div>
		</div>
	</div>
</div>