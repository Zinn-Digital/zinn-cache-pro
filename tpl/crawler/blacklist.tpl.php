<?php
/**
 * Zinn® Cache Engine Crawler Blocklist
 *
 * @package ZinnCachePro
 * @since 1.0.0
 */

namespace ZinnCachePro;

defined( 'WPINC' ) || exit;

$crawler_summary = Crawler::get_summary();
$__map           = Crawler_Map::cls();
$__admin_display = Admin_Display::cls();
$list            = $__map->list_blacklist( 30 );
$count           = $__map->count_blacklist();
$pagination      = Utility::pagination( $count, 30 );
?>

<p class="litespeed-right">
	<a href="<?php echo esc_url( Utility::build_url( Router::ACTION_CRAWLER, Crawler::TYPE_BLACKLIST_EMPTY ) ); ?>" class="button litespeed-btn-warning" data-zinn-cache-pro-cfm="<?php esc_attr_e( 'Are you sure to delete all existing blocklist items?', 'zinn-cache-pro' ); ?>">
		<?php esc_html_e( 'Empty blocklist', 'zinn-cache-pro' ); ?>
	</a>
</p>

<h3 class="litespeed-title">
	<?php esc_html_e( 'Blocklist', 'zinn-cache-pro' ); ?>
	<?php Doc::learn_more( 'https://docs.litespeedtech.com/lscache/lscwp/crawler/#blocklist-tab' ); ?>
</h3>

<?php echo esc_html__( 'Total', 'zinn-cache-pro' ) . ': ' . esc_html( $count ); ?>

<?php echo wp_kses_post( $pagination ); ?>

<div class="litespeed-table-responsive">
	<table class="wp-list-table widefat striped">
		<thead>
			<tr>
				<th scope="col">#</th>
				<th scope="col"><?php esc_html_e( 'URL', 'zinn-cache-pro' ); ?></th>
				<th scope="col"><?php esc_html_e( 'Status', 'zinn-cache-pro' ); ?></th>
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
					<a href="<?php echo esc_url( Utility::build_url( Router::ACTION_CRAWLER, Crawler::TYPE_BLACKLIST_DEL, false, null, array( 'id' => $v['id'] ) ) ); ?>" class="button button-secondary">
						<?php esc_html_e( 'Remove from Blocklist', 'zinn-cache-pro' ); ?>
					</a>
				</td>
			</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
</div>

<?php echo wp_kses_post( $pagination ); ?>

<p>
	<span class="litespeed-success">
		<?php
		printf(
			esc_html__( 'API: PHP Constant %s available to disable blocklist.', 'zinn-cache-pro' ),
			'<code>ZINN_CACHE_PRO_CRAWLER_DISABLE_BLOCKLIST</code>'
		);
		?>
	</span>
</p>
<p>
	<span class="litespeed-success">
		<?php
		printf(
			esc_html__( 'API: Filter %s available to disable blocklist.', 'zinn-cache-pro' ),
			'<code>add_filter( \'zinn_cache_pro_crawler_disable_blocklist\', \'__return_true\' );</code>'
		);
		?>
	</span>
</p>
<?php $__admin_display->_check_overwritten( 'crawler-blocklist' ); ?>
<p>
	<i class="litespeed-dot litespeed-bg-default"></i> = <?php esc_html_e( 'Not blocklisted', 'zinn-cache-pro' ); ?><br>
	<i class="litespeed-dot litespeed-bg-warning"></i> = <?php esc_html_e( 'Blocklisted due to not cacheable', 'zinn-cache-pro' ); ?><br>
	<i class="litespeed-dot litespeed-bg-danger"></i> = <?php esc_html_e( 'Blocklisted', 'zinn-cache-pro' ); ?><br>
</p>
