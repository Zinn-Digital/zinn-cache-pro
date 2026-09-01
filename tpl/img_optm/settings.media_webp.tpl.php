<?php
/**
 * Zinn® Cache Engine Image Optimization WebP/AVIF Setting
 *
 * Manages the WebP and AVIF optimization settings for Zinn® Cache Engine.
 *
 * @package ZinnCachePro
 * @since 1.0.0
 */

namespace ZinnCachePro;

defined( 'WPINC' ) || exit;
?>

<tr>
	<th>
		<?php $option_id = Base::O_IMG_OPTM_WEBP; ?>
		<?php $this->title( $option_id ); ?>
	</th>
	<td>
		<?php $this->build_switch( $option_id, array( esc_html__( 'OFF', 'zinn-cache-pro' ), 'WebP', 'AVIF' ) ); ?>
		<?php Doc::maybe_on_by_gm( $option_id ); ?>
		<div class="litespeed-desc">
			<?php esc_html_e( 'Request WebP/AVIF versions of original images when doing optimization.', 'zinn-cache-pro' ); ?>
			<?php printf( esc_html__( 'Significantly improve load time by replacing images with their optimized %s versions.', 'zinn-cache-pro' ), '.webp/.avif' ); ?>
			<br /><?php Doc::notice_htaccess(); ?>
			<br /><?php Doc::crawler_affected(); ?>
			<br />
			<font class="litespeed-warning">
				⚠️ <?php printf( esc_html__( '%1$s is a %2$s paid feature.', 'zinn-cache-pro' ), 'AVIF', 'QUIC.cloud' ); ?></font>
			<br />
			<font class="litespeed-warning">
				⚠️ <?php printf( esc_html__( 'When switching formats, please %1$s or %2$s to apply this new choice to previously optimized images.', 'zinn-cache-pro' ), esc_html__( 'Destroy All Optimization Data', 'zinn-cache-pro' ), esc_html__( 'Soft Reset Optimization Counter', 'zinn-cache-pro' ) ); ?></font>
			<?php Doc::learn_more( 'https://docs.litespeedtech.com/lscache/lscwp/imageopt/#soft-reset-optimization-counter' ); ?>
		</div>
	</td>
</tr>