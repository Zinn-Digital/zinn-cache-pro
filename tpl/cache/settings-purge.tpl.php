<?php
/**
 * Zinn® Cache Engine Purge Settings
 *
 * @package ZinnCachePro
 * @since 1.0.0
 */

namespace ZinnCachePro;

defined( 'WPINC' ) || exit;
?>

<h3 class="litespeed-title-short">
	<?php esc_html_e( 'Purge Settings', 'zinn-cache-pro' ); ?>
	<?php Doc::learn_more( 'https://docs.litespeedtech.com/lscache/lscwp/cache/#purge-tab' ); ?>
</h3>

<?php
$option_list = array(
	Base::O_PURGE_POST_ALL                     => esc_html__( 'All pages', 'zinn-cache-pro' ),
	Base::O_PURGE_POST_FRONTPAGE               => esc_html__( 'Front page', 'zinn-cache-pro' ),
	Base::O_PURGE_POST_HOMEPAGE                => esc_html__( 'Home page', 'zinn-cache-pro' ),
	Base::O_PURGE_POST_PAGES                   => esc_html__( 'Pages', 'zinn-cache-pro' ),
	Base::O_PURGE_POST_PAGES_WITH_RECENT_POSTS => esc_html__( 'All pages with Recent Posts Widget', 'zinn-cache-pro' ),
	Base::O_PURGE_POST_AUTHOR                  => esc_html__( 'Author archive', 'zinn-cache-pro' ),
	Base::O_PURGE_POST_POSTTYPE                => esc_html__( 'Post type archive', 'zinn-cache-pro' ),
	Base::O_PURGE_POST_YEAR                    => esc_html__( 'Yearly archive', 'zinn-cache-pro' ),
	Base::O_PURGE_POST_MONTH                   => esc_html__( 'Monthly archive', 'zinn-cache-pro' ),
	Base::O_PURGE_POST_DATE                    => esc_html__( 'Daily archive', 'zinn-cache-pro' ),
	Base::O_PURGE_POST_TERM                    => esc_html__( 'Term archive (include category, tag, and tax)', 'zinn-cache-pro' ),
);

// break line at these ids
$break_arr = array(
	Base::O_PURGE_POST_PAGES,
	Base::O_PURGE_POST_PAGES_WITH_RECENT_POSTS,
	Base::O_PURGE_POST_POSTTYPE,
	Base::O_PURGE_POST_DATE,
);
?>

<table class="wp-list-table striped litespeed-table"><tbody>

	<?php if ( ! $this->_is_multisite ) : ?>
		<?php require ZINN_CACHE_PRO_DIR . 'tpl/cache/settings_inc.purge_on_upgrade.tpl.php'; ?>
	<?php endif; ?>

	<tr>
		<th><?php esc_html_e( 'Auto Purge Rules For Publish/Update', 'zinn-cache-pro' ); ?></th>
		<td>
			<div class="litespeed-callout notice notice-warning inline">
				<h4><?php esc_html_e( 'Note', 'zinn-cache-pro' ); ?></h4>
				<p>
					<?php esc_html_e( 'Select "All" if there are dynamic widgets linked to posts on pages other than the front or home pages.', 'zinn-cache-pro' ); ?><br>
					<?php esc_html_e( 'Other checkboxes will be ignored.', 'zinn-cache-pro' ); ?><br>
					<?php esc_html_e( 'Select only the archive types that are currently used, the others can be left unchecked.', 'zinn-cache-pro' ); ?>
				</p>
			</div>
			<div class="litespeed-top20">
				<div class="litespeed-tick-wrapper">
					<?php
					foreach ( $option_list as $option_id => $cur_title ) {
						$this->build_checkbox( $option_id, $cur_title );
						if ( in_array( $option_id, $break_arr, true ) ) {
							echo '</div><div class="litespeed-tick-wrapper litespeed-top10">';
						}
					}
					?>
				</div>
			</div>
			<div class="litespeed-desc">
				<?php esc_html_e( 'Select which pages will be automatically purged when posts are published/updated.', 'zinn-cache-pro' ); ?>
			</div>
		</td>
	</tr>

	<tr>
		<th>
			<?php $option_id = Base::O_PURGE_STALE; ?>
			<?php $this->title( $option_id ); ?>
		</th>
		<td>
			<?php $this->build_switch( $option_id ); ?>
			<div class="litespeed-desc">
				<?php esc_html_e( 'If ON, the stale copy of a cached page will be shown to visitors until a new cache copy is available. Reduces the server load for following visits. If OFF, the page will be dynamically generated while visitors wait.', 'zinn-cache-pro' ); ?>
				<?php Doc::learn_more( 'https://docs.litespeedtech.com/lscache/lscwp/cache/#serve-stale' ); ?>
			</div>
			<div class="litespeed-callout notice notice-warning inline">
				<h4><?php esc_html_e( 'Note', 'zinn-cache-pro' ); ?></h4>
				<p>
					<?php esc_html_e( 'By design, this option may serve stale content. Do not enable this option, if that is not OK with you.', 'zinn-cache-pro' ); ?><br>
				</p>
			</div>
		</td>
	</tr>

	<tr>
		<th>
			<?php $option_id = Base::O_PURGE_TIMED_URLS; ?>
			<?php $this->title( $option_id ); ?>
		</th>
		<td>
			<?php $this->build_textarea( $option_id, 80 ); ?>
			<div class="litespeed-desc">
				<?php printf( esc_html__( 'The URLs here (one per line) will be purged automatically at the time set in the option "%s".', 'zinn-cache-pro' ), esc_html__( 'Scheduled Purge Time', 'zinn-cache-pro' ) ); ?><br>
				<?php printf( esc_html__( 'Both %1$s and %2$s are acceptable.', 'zinn-cache-pro' ), '<code>http://www.example.com/path/url.php</code>', '<code>/path/url.php</code>' ); ?>
				<?php Doc::one_per_line(); ?>
			</div>
			<div class="litespeed-desc">
				<?php printf( esc_html__( 'Wildcard %1$s supported (match zero or more characters). For example, to match %2$s and %3$s, use %4$s.', 'zinn-cache-pro' ), '<code>*</code>', '<code>/path/u-1.html</code>', '<code>/path/u-2.html</code>', '<code>/path/u-*.html</code>' ); ?>
			</div>
			<div class="litespeed-callout notice notice-warning inline">
				<h4><?php esc_html_e( 'Note', 'zinn-cache-pro' ); ?></h4>
				<p>
					<?php esc_html_e( 'For URLs with wildcards, there may be a delay in initiating scheduled purge.', 'zinn-cache-pro' ); ?><br>
					<?php Doc::learn_more( 'https://docs.litespeedtech.com/lscache/lscwp/cache/#scheduled-purge-urls' ); ?>
				</p>
			</div>
		</td>
	</tr>

	<tr>
		<th>
			<?php $option_id = Base::O_PURGE_TIMED_URLS_TIME; ?>
			<?php $this->title( $option_id ); ?>
		</th>
		<td>
			<?php $this->build_input( $option_id, null, null, 'time' ); ?>
			<div class="litespeed-desc">
				<?php printf( esc_html__( 'Specify the time to purge the "%s" list.', 'zinn-cache-pro' ), esc_html__( 'Scheduled Purge URLs', 'zinn-cache-pro' ) ); ?>
				<?php printf( esc_html__( 'Current server time is %s.', 'zinn-cache-pro' ), '<code>' . esc_html( gmdate( 'H:i:s', time() + ZINN_CACHE_PRO_TIME_OFFSET ) ) . '</code>' ); ?>
			</div>
		</td>
	</tr>

	<tr>
		<th>
			<?php $option_id = Base::O_PURGE_HOOK_ALL; ?>
			<?php $this->title( $option_id ); ?>
		</th>
		<td>
			<div class="litespeed-textarea-recommended">
				<div>
					<?php $this->build_textarea( $option_id, 50 ); ?>
				</div>
				<div>
					<?php $this->recommended( $option_id ); ?>
				</div>
			</div>
			<div class="litespeed-desc">
				<?php esc_html_e( 'A Purge All will be executed when WordPress runs these hooks.', 'zinn-cache-pro' ); ?>
				<?php Doc::learn_more( 'https://docs.litespeedtech.com/lscache/lscwp/cache/#purge-all-hooks' ); ?>
			</div>
		</td>
	</tr>

</tbody></table>
