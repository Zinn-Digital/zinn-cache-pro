<?php
/**
 * Zinn® Cache Pro Setting Tip
 *
 * Displays a notice to inform users about additional Zinn® Cache Pro settings.
 *
 * @package ZinnCachePro
 * @since 1.0.0
 */

namespace ZinnCachePro;

defined( 'WPINC' ) || exit;

global $pagenow;
if ( 'options-general.php' !== $pagenow ) {
	return;
}
?>

<div class="litespeed-callout notice notice-success inline">
	<h4><?php esc_html_e( 'NOTE', 'zinn-cache-pro' ); ?></h4>
	<p>
		<?php
		printf(
			/* translators: %s: Zinn® Cache Pro menu label */
			esc_html__( 'More settings available under %s menu', 'zinn-cache-pro' ),
			'<code>' . esc_html__( 'Zinn® Cache Pro', 'zinn-cache-pro' ) . '</code>'
		);
		?>
	</p>
</div>