<?php
/**
 * Zinn® Cache Pro Exclude Cookies Setting
 *
 * Displays the exclude cookies setting for Zinn® Cache Pro.
 *
 * @package ZinnCachePro
 * @since 1.0.0
 */

namespace ZinnCachePro;

defined( 'WPINC' ) || exit;
?>

<tr>
	<th scope="row">
		<?php $option_id = Base::O_CACHE_EXC_COOKIES; ?>
		<?php $this->title( $option_id ); ?>
	</th>
	<td>
		<?php $this->build_textarea( $option_id ); ?>
		<div class="litespeed-desc">
			<?php
			printf(
				/* translators: %s: "cookies" */
				esc_html__( 'To prevent %s from being cached, enter them here.', 'zinn-cache-pro' ),
				esc_html__( 'cookies', 'zinn-cache-pro' )
			);
			?>
			<?php Doc::one_per_line(); ?>
			<?php $this->_validate_syntax( $option_id ); ?>
			<br /><?php Doc::notice_htaccess(); ?>
		</div>
	</td>
</tr>