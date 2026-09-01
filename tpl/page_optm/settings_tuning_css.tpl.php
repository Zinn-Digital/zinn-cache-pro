<?php
/**
 * Zinn® Cache Engine Tuning CSS Settings
 *
 * Renders the Tuning CSS settings interface for Zinn® Cache Engine, allowing configuration of CSS exclusions and optimizations.
 *
 * @package ZinnCachePro
 * @since 1.0.0
 */

namespace ZinnCachePro;

defined( 'WPINC' ) || exit;

?>
<h3 class="litespeed-title-short">
	<?php esc_html_e( 'Tuning CSS Settings', 'zinn-cache-pro' ); ?>
	<?php Doc::learn_more( 'https://docs.litespeedtech.com/lscache/lscwp/pageopt/#tuning-css-settings-tab' ); ?>
</h3>

<table class="wp-list-table striped litespeed-table">
<tbody>
	<tr>
		<th>
			<?php $option_id = Base::O_OPTM_CSS_EXC; ?>
			<?php $this->title( $option_id ); ?>
		</th>
		<td>
			<?php $this->build_textarea( $option_id ); ?>
			<div class="litespeed-desc">
				<?php esc_html_e( 'Listed CSS files or inline CSS code will not be minified or combined.', 'zinn-cache-pro' ); ?>
				<?php Doc::full_or_partial_url(); ?>
				<?php Doc::one_per_line(); ?>
				<br /><font class="litespeed-success">
					<?php echo esc_html_e( 'API', 'zinn-cache-pro' ); ?>:
					<?php printf( esc_html__( 'Filter %s is supported.', 'zinn-cache-pro' ), '<code>zinn_cache_pro_optimize_css_excludes</code>' ); ?>
					<?php printf( esc_html__( 'Elements with attribute %s in html code will be excluded.', 'zinn-cache-pro' ), '<code>data-no-optimize="1"</code>' ); ?>
					<br /><?php echo esc_html_e( 'Predefined list will also be combined with the above settings', 'zinn-cache-pro' ); ?>: <a href="https://github.com/litespeedtech/lscache_wp/blob/dev/data/css_excludes.txt" target="_blank">https://github.com/litespeedtech/lscache_wp/blob/dev/data/css_excludes.txt</a>
				</font>
			</div>
		</td>
	</tr>

	<tr>
		<th>
			<?php $option_id = Base::O_OPTM_UCSS_FILE_EXC_INLINE; ?>
			<?php $this->title( $option_id ); ?>
		</th>
		<td>
			<?php $this->build_textarea( $option_id ); ?>
			<div class="litespeed-desc">
				<?php esc_html_e( 'Listed CSS files will be excluded from UCSS and saved to inline.', 'zinn-cache-pro' ); ?>
				<?php Doc::full_or_partial_url(); ?>
				<?php Doc::one_per_line(); ?>
			</div>
		</td>
	</tr>

	<tr>
		<th>
			<?php $option_id = Base::O_OPTM_UCSS_SELECTOR_WHITELIST; ?>
			<?php $this->title( $option_id ); ?>
		</th>
		<td>
			<?php $this->build_textarea( $option_id ); ?>
			<div class="litespeed-desc">
				<?php esc_html_e( 'List the CSS selectors whose styles should always be included in UCSS.', 'zinn-cache-pro' ); ?>
				<?php Doc::one_per_line(); ?>
				<?php Doc::learn_more( 'https://docs.litespeedtech.com/lscache/lscwp/pageopt/#ucss-selector-allowlist', esc_html__( 'Learn more', 'zinn-cache-pro' ) ); ?>.
				<br /><?php printf( esc_html__( 'Wildcard %s supported.', 'zinn-cache-pro' ), '<code>*</code>' ); ?>
				<div class="litespeed-callout notice notice-warning inline">
					<h4><?php esc_html_e( 'Note', 'zinn-cache-pro' ); ?></h4>
					<p>
						<?php esc_html_e( 'The selector must exist in the CSS. Parent classes in the HTML will not work.', 'zinn-cache-pro' ); ?>
					</p>
				</div>
				<font class="litespeed-success">
					<?php esc_html_e( 'Predefined list will also be combined w/ the above settings', 'zinn-cache-pro' ); ?>: <a href="https://github.com/litespeedtech/lscache_wp/blob/dev/data/ucss_whitelist.txt" target="_blank">https://github.com/litespeedtech/lscache_wp/blob/dev/data/ucss_whitelist.txt</a>
				</font>
			</div>
		</td>
	</tr>

	<tr>
		<th>
			<?php $option_id = Base::O_OPTM_UCSS_EXC; ?>
			<?php $this->title( $option_id ); ?>
		</th>
		<td>
			<?php $this->build_textarea( $option_id ); ?>
			<div class="litespeed-desc">
				<?php esc_html_e( 'Listed URI will not generate UCSS.', 'zinn-cache-pro' ); ?>
				<?php Doc::full_or_partial_url(); ?>
				<?php Doc::one_per_line(); ?>
				<br /><span class="litespeed-success">
					<?php esc_html_e( 'API', 'zinn-cache-pro' ); ?>:
					<?php printf( esc_html__( 'Filter %s is supported.', 'zinn-cache-pro' ), '<code>zinn_cache_pro_ucss_exc</code>' ); ?>
				</span>
				<br /><font class="litespeed-success"><?php esc_html_e( 'API', 'zinn-cache-pro' ); ?>: <?php printf( esc_html__( 'Use %1$s to generate one single UCSS for the pages which page type is %2$s while other page types still per URL.', 'zinn-cache-pro' ), "<code>add_filter( 'zinn_cache_pro_ucss_per_pagetype', function(){return get_post_type() == 'page';} );</code>", '<code>page</code>' ); ?></font>
				<br /><font class="litespeed-success"><?php esc_html_e( 'API', 'zinn-cache-pro' ); ?>: <?php printf( esc_html__( 'Use %1$s to bypass UCSS for the pages which page type is %2$s.', 'zinn-cache-pro' ), "<code>add_action( 'zinn_cache_pro_optm', function(){get_post_type() == 'page' && do_action( 'zinn_cache_pro_conf_force', 'optm-ucss', false );});</code>", '<code>page</code>' ); ?></font>
			</div>
		</td>
	</tr>

	<tr>
		<th>
			<?php $option_id = Base::O_OPTM_CCSS_SEP_POSTTYPE; ?>
			<?php $this->title( $option_id ); ?>
		</th>
		<td>
			<?php $this->build_textarea( $option_id ); ?>
			<div class="litespeed-desc">
				<?php esc_html_e( 'List post types where each item of that type should have its own CCSS generated.', 'zinn-cache-pro' ); ?>
				<?php printf( esc_html__( 'For example, if every Page on the site has different formatting, enter %s in the box. Separate critical CSS files will be stored for every Page on the site.', 'zinn-cache-pro' ), '<code>page</code>' ); ?>
				<?php Doc::learn_more( 'https://docs.litespeedtech.com/lscache/lscwp/pageopt/#separate-ccss-cache-post-types_1' ); ?>
			</div>
		</td>
	</tr>

	<tr>
		<th>
			<?php $option_id = Base::O_OPTM_CCSS_SEP_URI; ?>
			<?php $this->title( $option_id ); ?>
		</th>
		<td>
			<?php $this->build_textarea( $option_id ); ?>
			<div class="litespeed-desc">
				<?php esc_html_e( 'Separate critical CSS files will be generated for paths containing these strings.', 'zinn-cache-pro' ); ?>
				<?php $this->_uri_usage_example(); ?>
			</div>
		</td>
	</tr>

	<tr>
		<th>
			<?php $option_id = Base::O_OPTM_CCSS_SELECTOR_WHITELIST; ?>
			<?php $this->title( $option_id ); ?>
		</th>
		<td>
			<?php $this->build_textarea( $option_id ); ?>
			<div class="litespeed-desc">
				<?php esc_html_e( 'List the CSS selectors whose styles should always be included in CCSS.', 'zinn-cache-pro' ); ?>
				<?php Doc::one_per_line(); ?>
				<?php Doc::learn_more( 'https://docs.litespeedtech.com/lscache/lscwp/pageopt/#ccss-selector-allowlist', esc_html__( 'Learn more', 'zinn-cache-pro' ) ); ?>.
				<br /><?php printf( esc_html__( 'Wildcard %s supported.', 'zinn-cache-pro' ), '<code>*</code>' ); ?>
				<div class="litespeed-callout notice notice-warning inline">
					<h4><?php esc_html_e( 'Note', 'zinn-cache-pro' ); ?></h4>
					<p>
						<?php esc_html_e( 'Selectors must exist in the CSS. Parent classes in the HTML will not work.', 'zinn-cache-pro' ); ?>
					</p>
				</div>
				<font class="litespeed-success">
					<?php esc_html_e( 'Predefined list will also be combined w/ the above settings', 'zinn-cache-pro' ); ?>: <a href="https://github.com/litespeedtech/lscache_wp/blob/dev/data/ccss_whitelist.txt" target="_blank">https://github.com/litespeedtech/lscache_wp/blob/dev/data/ccss_whitelist.txt</a>
				</font>
			</div>
		</td>
	</tr>

	<tr>
		<th>
			<?php $option_id = Base::O_OPTM_CCSS_CON; ?>
			<?php $this->title( $option_id ); ?>
		</th>
		<td>
			<?php $this->build_textarea( $option_id ); ?>
			<div class="litespeed-desc">
				<?php printf( esc_html__( 'Specify critical CSS rules for above-the-fold content when enabling %s.', 'zinn-cache-pro' ), esc_html__( 'Load CSS Asynchronously', 'zinn-cache-pro' ) ); ?>
			</div>
		</td>
	</tr>

</tbody></table>