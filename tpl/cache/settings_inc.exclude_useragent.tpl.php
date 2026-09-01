<?php
/**
 * Zinn® Cache Engine Exclude User Agents Setting
 *
 * Displays the exclude user agents setting for Zinn® Cache Engine.
 *
 * @package ZinnCachePro
 * @since 1.0.0
 */

namespace ZinnCachePro;

defined( 'WPINC' ) || exit;
?>

<tr>
	<th scope="row">
		<?php $option_id = Base::O_CACHE_EXC_USERAGENTS; ?>
		<?php $this->title( $option_id ); ?>
	</th>
	<td>
		<?php $this->build_textarea( $option_id ); ?>
		<div class="litespeed-desc">
			<?php
			printf(
				/* translators: %s: "user agents" */
				esc_html__( 'To prevent %s from being cached, enter them here.', 'zinn-cache-pro' ),
				esc_html__( 'user agents', 'zinn-cache-pro' )
			);
			?>
			<?php Doc::one_per_line(); ?>
			<?php $this->_validate_syntax( $option_id ); ?>
			<br /><?php Doc::notice_htaccess(); ?>
		</div>
	</td>
</tr>