<?php
/**
 * Zinn® Cache Pro Media Excludes Settings
 *
 * Renders the media excludes settings interface for Zinn® Cache Pro, allowing configuration of exclusions for lazy loading and LQIP.
 *
 * @package ZinnCachePro
 * @since 1.0.0
 */

namespace ZinnCachePro;

defined( 'WPINC' ) || exit;
?>

<h3 class="litespeed-title-short">
	<?php esc_html_e( 'Media Excludes', 'zinn-cache-pro' ); ?>
	<?php Doc::learn_more( 'https://docs.litespeedtech.com/lscache/lscwp/pageopt/#media-excludes-tab' ); ?>
</h3>

<table class="wp-list-table striped litespeed-table"><tbody>

	<tr>
		<th>
			<?php $option_id = Base::O_MEDIA_LAZY_EXC; ?>
			<?php $this->title( $option_id ); ?>
		</th>
		<td>
			<?php $this->build_textarea( $option_id ); ?>
			<div class="litespeed-desc">
				<?php esc_html_e( 'Listed images will not be lazy loaded.', 'zinn-cache-pro' ); ?>
				<?php Doc::full_or_partial_url(); ?>
				<?php Doc::one_per_line(); ?>
				<br /><?php esc_html_e( 'Useful for above-the-fold images causing CLS (a Core Web Vitals metric).', 'zinn-cache-pro' ); ?>
				<br /><font class="litespeed-success">
					<?php esc_html_e( 'API', 'zinn-cache-pro' ); ?>:
					<?php printf( esc_html__( 'Filter %s is supported.', 'zinn-cache-pro' ), '<code>zinn_cache_pro_media_lazy_img_excludes</code>' ); ?>
					<?php printf( esc_html__( 'Elements with attribute %s in html code will be excluded.', 'zinn-cache-pro' ), '<code>data-no-lazy="1"</code>' ); ?>
				</font>
			</div>
		</td>
	</tr>

	<tr>
		<th>
			<?php $option_id = Base::O_MEDIA_LAZY_CLS_EXC; ?>
			<?php $this->title( $option_id ); ?>
		</th>
		<td>
			<div class="litespeed-textarea-recommended">
				<div>
					<?php $this->build_textarea( $option_id ); ?>
				</div>
				<div>
					<?php $this->recommended( $option_id ); ?>
				</div>
			</div>

			<div class="litespeed-desc">
				<?php esc_html_e( 'Images containing these class names will not be lazy loaded.', 'zinn-cache-pro' ); ?>
				<?php Doc::full_or_partial_url( true ); ?>
				<?php Doc::one_per_line(); ?>
			</div>
		</td>
	</tr>

	<tr>
		<th>
			<?php $option_id = Base::O_MEDIA_LAZY_PARENT_CLS_EXC; ?>
			<?php $this->title( $option_id ); ?>
		</th>
		<td>
			<?php $this->build_textarea( $option_id ); ?>
			<div class="litespeed-desc">
				<?php esc_html_e( 'Images having these parent class names will not be lazy loaded.', 'zinn-cache-pro' ); ?>
				<?php Doc::one_per_line(); ?>
			</div>
		</td>
	</tr>

	<tr>
		<th>
			<?php $option_id = Base::O_MEDIA_IFRAME_LAZY_CLS_EXC; ?>
			<?php $this->title( $option_id ); ?>
		</th>
		<td>
			<?php $this->build_textarea( $option_id ); ?>
			<div class="litespeed-desc">
				<?php esc_html_e( 'Iframes containing these class names will not be lazy loaded.', 'zinn-cache-pro' ); ?>
				<?php Doc::full_or_partial_url( true ); ?>
				<?php Doc::one_per_line(); ?>
			</div>
		</td>
	</tr>

	<tr>
		<th>
			<?php $option_id = Base::O_MEDIA_IFRAME_LAZY_PARENT_CLS_EXC; ?>
			<?php $this->title( $option_id ); ?>
		</th>
		<td>
			<?php $this->build_textarea( $option_id ); ?>
			<div class="litespeed-desc">
				<?php esc_html_e( 'Iframes having these parent class names will not be lazy loaded.', 'zinn-cache-pro' ); ?>
				<?php Doc::one_per_line(); ?>
			</div>
		</td>
	</tr>

	<tr>
		<th>
			<?php $option_id = Base::O_MEDIA_LAZY_URI_EXC; ?>
			<?php $this->title( $option_id ); ?>
		</th>
		<td>
			<?php $this->build_textarea( $option_id ); ?>
			<div class="litespeed-desc">
				<?php esc_html_e( 'Prevent any lazy load of listed pages.', 'zinn-cache-pro' ); ?>
				<?php $this->_uri_usage_example(); ?>
			</div>
		</td>
	</tr>

	<tr>
		<th>
			<?php $option_id = Base::O_MEDIA_LQIP_EXC; ?>
			<?php $this->title( $option_id ); ?>
		</th>
		<td>
			<?php $this->build_textarea( $option_id ); ?>
			<div class="litespeed-desc">
				<?php esc_html_e( 'These images will not generate LQIP.', 'zinn-cache-pro' ); ?>
				<?php Doc::full_or_partial_url(); ?>
			</div>
		</td>
	</tr>

</tbody></table>