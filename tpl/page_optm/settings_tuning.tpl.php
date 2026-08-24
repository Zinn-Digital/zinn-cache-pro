<?php
/**
 * Zinn® Cache Pro Tuning Settings
 *
 * Renders the tuning settings interface for Zinn® Cache Pro, allowing configuration of optimization exclusions and role-based settings.
 *
 * @package ZinnCachePro
 * @since 1.0.0
 */

namespace ZinnCachePro;

defined( 'WPINC' ) || exit;

global $wp_roles;
$wp_orig_roles = $wp_roles;
if ( ! isset( $wp_roles ) ) {
	$wp_orig_roles = new \WP_Roles();
}

$roles = array();
foreach ( $wp_orig_roles->roles as $k => $v ) {
	$roles[ $k ] = $v['name'];
}
ksort( $roles );

?>
<h3 class="litespeed-title-short">
	<?php esc_html_e( 'Tuning Settings', 'zinn-cache-pro' ); ?>
	<?php Doc::learn_more( 'https://docs.litespeedtech.com/lscache/lscwp/pageopt/#tuning-settings-tab' ); ?>
</h3>

<table class="wp-list-table striped litespeed-table">
	<tbody>
		<tr>
			<th>
				<?php $option_id = Base::O_OPTM_JS_DELAY_INC; ?>
				<?php $this->title( $option_id ); ?>
			</th>
			<td>
				<?php $this->build_textarea( $option_id ); ?>
				<div class="litespeed-desc">
					<?php esc_html_e( 'Listed JS files or inline JS code will be delayed.', 'zinn-cache-pro' ); ?>
					<?php Doc::full_or_partial_url(); ?>
					<?php Doc::one_per_line(); ?>
					<br />
					<font class="litespeed-success">
						<?php esc_html_e( 'API', 'zinn-cache-pro' ); ?>:
						<?php printf( esc_html__( 'Filter %s is supported.', 'zinn-cache-pro' ), '<code>zinn_cache_pro_optm_js_delay_inc</code>' ); ?>
					</font>
				</div>
			</td>
		</tr>

		<tr>
			<th>
				<?php $option_id = Base::O_OPTM_JS_EXC; ?>
				<?php $this->title( $option_id ); ?>
			</th>
			<td>
				<?php $this->build_textarea( $option_id ); ?>
				<div class="litespeed-desc">
					<?php esc_html_e( 'Listed JS files or inline JS code will not be minified or combined.', 'zinn-cache-pro' ); ?>
					<?php Doc::full_or_partial_url(); ?>
					<?php Doc::one_per_line(); ?>
					<br />
					<font class="litespeed-success">
						<?php esc_html_e( 'API', 'zinn-cache-pro' ); ?>:
						<?php printf( esc_html__( 'Filter %s is supported.', 'zinn-cache-pro' ), '<code>zinn_cache_pro_optimize_js_excludes</code>' ); ?>
						<?php printf( esc_html__( 'Elements with attribute %s in html code will be excluded.', 'zinn-cache-pro' ), '<code>data-no-optimize="1"</code>' ); ?>
						<br /><?php esc_html_e( 'Predefined list will also be combined with the above settings.', 'zinn-cache-pro' ); ?>: <a href="https://github.com/litespeedtech/lscache_wp/blob/dev/data/js_excludes.txt" target="_blank">https://github.com/litespeedtech/lscache_wp/blob/dev/data/js_excludes.txt</a>
					</font>
				</div>
			</td>
		</tr>

		<tr>
			<th>
				<?php $option_id = Base::O_OPTM_JS_DEFER_EXC; ?>
				<?php $this->title( $option_id ); ?>
			</th>
			<td>
				<?php $this->build_textarea( $option_id ); ?>
				<div class="litespeed-desc">
					<?php esc_html_e( 'Listed JS files or inline JS code will not be deferred or delayed.', 'zinn-cache-pro' ); ?>
					<?php Doc::full_or_partial_url(); ?>
					<?php Doc::one_per_line(); ?>
					<br /><span class="litespeed-success">
						<?php esc_html_e( 'API', 'zinn-cache-pro' ); ?>:
						<?php printf( esc_html__( 'Filter %s is supported.', 'zinn-cache-pro' ), '<code>zinn_cache_pro_optm_js_defer_exc</code>' ); ?>
						<?php printf( esc_html__( 'Elements with attribute %s in html code will be excluded.', 'zinn-cache-pro' ), '<code>data-no-defer="1"</code>' ); ?>
						<br /><?php esc_html_e( 'Predefined list will also be combined with the above settings.', 'zinn-cache-pro' ); ?>: <a href="https://github.com/litespeedtech/lscache_wp/blob/dev/data/js_defer_excludes.txt" target="_blank">https://github.com/litespeedtech/lscache_wp/blob/dev/data/js_defer_excludes.txt</a>
					</span>
				</div>
			</td>
		</tr>

		<tr>
			<th>
				<?php $option_id = Base::O_OPTM_GM_JS_EXC; ?>
				<?php $this->title( $option_id ); ?>
			</th>
			<td>
				<?php $this->build_textarea( $option_id ); ?>
				<div class="litespeed-desc">
					<?php printf( esc_html__( 'Listed JS files or inline JS code will not be optimized by %s.', 'zinn-cache-pro' ), '<code>' . esc_html( Lang::title( Base::O_GUEST ) ) . '</code>' ); ?>
					<?php Doc::full_or_partial_url(); ?>
					<?php Doc::one_per_line(); ?>
					<br /><span class="litespeed-success">
						<?php esc_html_e( 'API', 'zinn-cache-pro' ); ?>:
						<?php printf( esc_html__( 'Filter %s is supported.', 'zinn-cache-pro' ), '<code>zinn_cache_pro_optm_gm_js_exc</code>' ); ?>
						<?php printf( esc_html__( 'Elements with attribute %s in html code will be excluded.', 'zinn-cache-pro' ), '<code>data-no-defer="1"</code>' ); ?>
					</span>
				</div>
			</td>
		</tr>

		<tr>
			<th>
				<?php $option_id = Base::O_OPTM_EXC; ?>
				<?php $this->title( $option_id ); ?>
			</th>
			<td>
				<?php $this->build_textarea( $option_id ); ?>
				<div class="litespeed-desc">
					<?php esc_html_e( 'Prevent any optimization of listed pages.', 'zinn-cache-pro' ); ?>
					<?php $this->_uri_usage_example(); ?>
					<br /><span class="litespeed-success">
						<?php esc_html_e( 'API', 'zinn-cache-pro' ); ?>:
						<?php printf( esc_html__( 'Filter %s is supported.', 'zinn-cache-pro' ), '<code>zinn_cache_pro_optm_uri_exc</code>' ); ?>
					</span>
				</div>
			</td>
		</tr>

		<tr>
			<th>
				<?php $option_id = Base::O_OPTM_GUEST_ONLY; ?>
				<?php $this->title( $option_id ); ?>
			</th>
			<td>
				<?php $this->build_switch( $option_id ); ?>
				<div class="litespeed-desc">
					<?php esc_html_e( 'Only optimize pages for guest (not logged in) visitors. If turned this OFF, CSS/JS/CCSS files will be doubled by each user group.', 'zinn-cache-pro' ); ?>
				</div>
			</td>
		</tr>

		<tr>
			<th>
				<?php $option_id = Base::O_OPTM_EXC_ROLES; ?>
				<?php $this->title( $option_id ); ?>
			</th>
			<td>
				<div class="litespeed-desc">
					<?php esc_html_e( 'Selected roles will be excluded from all optimizations.', 'zinn-cache-pro' ); ?>
				</div>
				<div class="litespeed-tick-list">
					<?php
					foreach ( $roles as $role_id => $role_title ) {
						$this->build_checkbox( $option_id . '[]', $role_title, $this->cls( 'Conf' )->in_optm_exc_roles( $role_id ), $role_id );
					}
					?>
				</div>
			</td>
		</tr>

	</tbody>
</table>