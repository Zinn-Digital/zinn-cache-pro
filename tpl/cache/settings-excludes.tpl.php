<?php
/**
 * Zinn® Cache Pro Exclude Settings
 *
 * @package ZinnCachePro
 * @since 1.0.0
 */

namespace ZinnCachePro;

defined( 'WPINC' ) || exit;
?>

<h3 class="litespeed-title-short">
	<?php echo esc_html__( 'Exclude Settings', 'zinn-cache-pro' ); ?>
	<?php Doc::learn_more( 'https://docs.litespeedtech.com/lscache/lscwp/cache/#excludes-tab' ); ?>
</h3>

<table class="wp-list-table striped litespeed-table">
	<tbody>

		<tr>
			<th>
				<?php $option_id = Base::O_CACHE_EXC; ?>
				<?php $this->title( $option_id ); ?>
			</th>
			<td>
				<?php $this->build_textarea( $option_id ); ?>
				<div class="litespeed-desc">
					<?php echo esc_html__( 'Paths containing these strings will not be cached.', 'zinn-cache-pro' ); ?>
					<?php $this->_uri_usage_example(); ?>
					<br><?php echo esc_html__( 'Predefined list will also be combined w/ the above settings', 'zinn-cache-pro' ); ?>: <a href="https://github.com/litespeedtech/lscache_wp/blob/dev/data/cache_nocacheable.txt" target="_blank">https://github.com/litespeedtech/lscache_wp/blob/dev/data/cache_nocacheable.txt</a>
				</div>
			</td>
		</tr>

		<tr>
			<th>
				<?php $option_id = Base::O_CACHE_EXC_QS; ?>
				<?php $this->title( $option_id ); ?>
			</th>
			<td>
				<?php $this->build_textarea( $option_id ); ?>
				<div class="litespeed-desc">
					<?php echo esc_html__( 'Query strings containing these parameters will not be cached.', 'zinn-cache-pro' ); ?>
					<?php printf( esc_html__( 'For example, for %1$s, %2$s and %3$s can be used here.', 'zinn-cache-pro' ), '<code>?aa=bb&cc=dd</code>', '<code>aa</code>', '<code>cc</code>' ); ?>
					<?php Doc::one_per_line(); ?>
				</div>
			</td>
		</tr>

		<tr>
			<th>
				<?php $option_id = Base::O_CACHE_EXC_CAT; ?>
				<?php $this->title( $option_id ); ?>
			</th>
			<td>
				<?php
				$excludes_buf = '';
				if ( $this->conf( $option_id ) ) {
					$excludes_buf = implode( "\n", array_map( 'get_cat_name', $this->conf( $option_id ) ) );
				}
				$this->build_textarea( $option_id, false, $excludes_buf );
				?>
				<div class="litespeed-desc">
					<b><?php echo esc_html__( 'All categories are cached by default.', 'zinn-cache-pro' ); ?></b>
					<?php printf( esc_html__( 'To prevent %s from being cached, enter them here.', 'zinn-cache-pro' ), esc_html__( 'categories', 'zinn-cache-pro' ) ); ?>
					<?php Doc::one_per_line(); ?>
				</div>
				<div class="litespeed-callout notice notice-warning inline">
					<h4><?php echo esc_html__( 'NOTE', 'zinn-cache-pro' ); ?>:</h4>
					<ol>
						<li><?php echo esc_html__( 'If the category name is not found, the category will be removed from the list on save.', 'zinn-cache-pro' ); ?></li>
					</ol>
				</div>
			</td>
		</tr>

		<tr>
			<th>
				<?php $option_id = Base::O_CACHE_EXC_TAG; ?>
				<?php $this->title( $option_id ); ?>
			</th>
			<td>
				<?php
				$excludes_buf = '';
				if ( $this->conf( $option_id ) ) {
					$tag_names = array();
					foreach ( array_map( 'get_tag', $this->conf( $option_id ) ) as $curr_tag ) {
						$tag_names[] = $curr_tag->name;
					}
					if ( ! empty( $tag_names ) ) {
						$excludes_buf = implode( "\n", $tag_names );
					}
				}
				$this->build_textarea( $option_id, false, $excludes_buf );
				?>
				<div class="litespeed-desc">
					<b><?php echo esc_html__( 'All tags are cached by default.', 'zinn-cache-pro' ); ?></b>
					<?php printf( esc_html__( 'To prevent %s from being cached, enter them here.', 'zinn-cache-pro' ), esc_html__( 'tags', 'zinn-cache-pro' ) ); ?>
					<?php Doc::one_per_line(); ?>
				</div>
				<div class="litespeed-callout notice notice-warning inline">
					<h4><?php echo esc_html__( 'NOTE', 'zinn-cache-pro' ); ?>:</h4>
					<ol>
						<li><?php echo esc_html__( 'If the tag slug is not found, the tag will be removed from the list on save.', 'zinn-cache-pro' ); ?></li>
						<li>
						<?php
						printf(
							esc_html__( 'To exclude %1$s, insert %2$s.', 'zinn-cache-pro' ),
							'<code>http://www.example.com/tag/category/tag-slug/</code>',
							'<code>tag-slug</code>'
						);
						?>
						</li>
					</ol>
				</div>
			</td>
		</tr>

		<?php
		if ( ! $this->_is_multisite ) :
			require ZINN_CACHE_PRO_DIR . 'tpl/cache/settings_inc.exclude_cookies.tpl.php';
			require ZINN_CACHE_PRO_DIR . 'tpl/cache/settings_inc.exclude_useragent.tpl.php';
		endif;
		?>

		<tr>
			<th>
				<?php $option_id = Base::O_CACHE_EXC_ROLES; ?>
				<?php $this->title( $option_id ); ?>
			</th>
			<td>
				<div class="litespeed-desc">
					<?php echo esc_html__( 'Selected roles will be excluded from cache.', 'zinn-cache-pro' ); ?>
				</div>
				<div class="litespeed-tick-list">
					<?php foreach ( $roles as $curr_role => $curr_title ) : ?>
						<?php $this->build_checkbox( $option_id . '[]', esc_html( $curr_title ), Control::cls()->in_cache_exc_roles( $curr_role ), $curr_role ); ?>
					<?php endforeach; ?>
				</div>
			</td>
		</tr>

	</tbody>
</table>
