<?php
/**
 * Zinn® Cache Engine Crawler Sitemap List
 *
 * @package ZinnCachePro
 * @since 1.0.0
 */

namespace ZinnCachePro;

defined( 'WPINC' ) || exit;

$crawler_summary = Crawler::get_summary();
$__map           = Crawler_Map::cls();
$list            = $__map->list_map( 30 );
$count           = $__map->count_map();
$pagination      = Utility::pagination( $count, 30 );
$kw              = '';
if (! empty( $_POST['kw'] ) && ! empty( $_POST['_wpnonce'] )) {
	$nonce = sanitize_text_field(wp_unslash($_POST['_wpnonce']));
	if (wp_verify_nonce($nonce)) {
		$kw = sanitize_text_field(wp_unslash($_POST['kw']));
	}
}
?>

<p class="litespeed-right">
	<a href="<?php echo esc_url( Utility::build_url( Router::ACTION_CRAWLER, Crawler::TYPE_EMPTY ) ); ?>" class="button litespeed-btn-warning">
		<?php esc_html_e( 'Clean Crawler Map', 'zinn-cache-pro' ); ?>
	</a>
	<a href="<?php echo esc_url( Utility::build_url( Router::ACTION_CRAWLER, Crawler::TYPE_REFRESH_MAP ) ); ?>" class="button button-secondary">
		<?php esc_html_e( 'Refresh Crawler Map', 'zinn-cache-pro' ); ?>
	</a>
</p>

<p>
	<?php
	if ( ! empty( $crawler_summary['sitemap_time'] ) ) {
		printf(
			esc_html__( 'Generated at %s', 'zinn-cache-pro' ),
			esc_html( Utility::readable_time( $crawler_summary['sitemap_time'] ) )
		);
	}
	?>
</p>

<h3 class="litespeed-title">
	<?php esc_html_e( 'Sitemap List', 'zinn-cache-pro' ); ?>
	<?php Doc::learn_more( 'https://docs.litespeedtech.com/lscache/lscwp/crawler/#map-tab' ); ?>
</h3>

<?php echo esc_html__( 'Sitemap Total', 'zinn-cache-pro' ) . ': ' . esc_html( $count ); ?>

<div style="display: flex; justify-content: space-between;">
	<div style="margin-top:10px;">
		<form action="<?php echo esc_url( admin_url( 'admin.php?page=zinn-cache-pro-crawler' ) ); ?>" method="post">
		<?php wp_nonce_field(); ?>
			<input type="text" name="kw" value="<?php echo esc_attr( $kw ); ?>" placeholder="<?php esc_attr_e( 'URL Search', 'zinn-cache-pro' ); ?>" style="width: 600px;" />
		</form>
	</div>
	<div>
		<a style="padding-right:10px;" href="<?php echo esc_url( admin_url( 'admin.php?page=zinn-cache-pro-crawler&' . Router::TYPE . '=hit' ) ); ?>"><?php esc_html_e( 'Cache Hit', 'zinn-cache-pro' ); ?></a>
		<a style="padding-right:10px;" href="<?php echo esc_url( admin_url( 'admin.php?page=zinn-cache-pro-crawler&' . Router::TYPE . '=miss' ) ); ?>"><?php esc_html_e( 'Cache Miss', 'zinn-cache-pro' ); ?></a>
		<a style="padding-right:10px;" href="<?php echo esc_url( admin_url( 'admin.php?page=zinn-cache-pro-crawler&' . Router::TYPE . '=blacklisted' ) ); ?>"><?php esc_html_e( 'Blocklisted', 'zinn-cache-pro' ); ?></a>
	</div>
	<div>
		<?php echo wp_kses_post( $pagination ); ?>
	</div>
</div>

<div class="litespeed-table-responsive">
	<table class="wp-list-table widefat striped">
		<thead>
			<tr>
				<th scope="col">#</th>
				<th scope="col"><?php esc_html_e( 'URL', 'zinn-cache-pro' ); ?></th>
				<th scope="col"><?php esc_html_e( 'Crawler Status', 'zinn-cache-pro' ); ?></th>
				<th scope="col"><?php esc_html_e( 'Operation', 'zinn-cache-pro' ); ?></th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ( $list as $i => $v ) : ?>
				<tr>
					<td><?php echo esc_html( $i + 1 ); ?></td>
					<td><?php echo esc_html( $v['url'] ); ?></td>
					<td><?php echo wp_kses_post( Crawler::cls()->display_status( $v['res'], $v['reason'] ) ); ?></td>
					<td>
						<a href="<?php echo esc_url( Utility::build_url( Router::ACTION_CRAWLER, Crawler::TYPE_BLACKLIST_ADD, false, null, array( 'id' => $v['id'] ) ) ); ?>" class="button button-secondary">
							<?php esc_html_e( 'Add to Blocklist', 'zinn-cache-pro' ); ?>
						</a>
					</td>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
</div>

<?php echo wp_kses_post( $pagination ); ?>

<p>
	<i class="litespeed-dot litespeed-bg-success"></i> = <?php esc_html_e( 'Cache Hit', 'zinn-cache-pro' ); ?><br>
	<i class="litespeed-dot litespeed-bg-primary"></i> = <?php esc_html_e( 'Cache Miss', 'zinn-cache-pro' ); ?><br>
	<i class="litespeed-dot litespeed-bg-warning"></i> = <?php esc_html_e( 'Blocklisted due to not cacheable', 'zinn-cache-pro' ); ?><br>
	<i class="litespeed-dot litespeed-bg-danger"></i> = <?php esc_html_e( 'Blocklisted', 'zinn-cache-pro' ); ?><br>
</p>
