<?php
/**
 * Zinn® Cache Pro Browser Cache Settings
 *
 * Displays the browser cache settings section for Zinn® Cache Pro.
 *
 * @package ZinnCachePro
 * @since 1.0.0
 */

namespace ZinnCachePro;

defined( 'WPINC' ) || exit;
?>

<h3 class="litespeed-title-short">
	<?php esc_html_e( 'Browser Cache Settings', 'zinn-cache-pro' ); ?>
	<?php Doc::learn_more( 'https://docs.litespeedtech.com/lscache/lscwp/cache/#browser-tab' ); ?>
</h3>

<?php if ( 'ZINN_CACHE_PRO_SERVER_OLS' === ZINN_CACHE_PRO_SERVER_TYPE ) : ?>
	<div class="litespeed-callout notice notice-warning inline">
		<h4><?php esc_html_e( 'NOTICE:', 'zinn-cache-pro' ); ?></h4>
		<p>
			<?php esc_html_e( 'OpenLiteSpeed users please check this', 'zinn-cache-pro' ); ?>:
			<?php Doc::learn_more( 'https://openlitespeed.org/kb/how-to-set-up-custom-headers/', esc_html__( 'Setting Up Custom Headers', 'zinn-cache-pro' ) ); ?>
		</p>
	</div>
<?php endif; ?>

<table class="wp-list-table striped litespeed-table">
	<tbody>
		<tr>
			<th scope="row">
				<?php $option_id = Base::O_CACHE_BROWSER; ?>
				<?php $this->title( $option_id ); ?>
			</th>
			<td>
				<?php $this->build_switch( $option_id ); ?>
				<div class="litespeed-desc">
					<?php esc_html_e( "Browser caching stores static files locally in the user's browser. Turn on this setting to reduce repeated requests for static files.", 'zinn-cache-pro' ); ?><br>
					<?php Doc::notice_htaccess(); ?><br>
					<?php
					printf(
						/* translators: %s: Link tags */
						esc_html__( 'You can turn on browser caching in server admin too. %sLearn more about LiteSpeed browser cache settings%s.', 'zinn-cache-pro' ),
						'<a href="https://docs.litespeedtech.com/lscache/lscwp/cache/#how-to-set-it-up" target="_blank" rel="noopener">',
						'</a>'
					);
					?>
				</div>
			</td>
		</tr>

		<tr>
			<th scope="row">
				<?php $option_id = Base::O_CACHE_TTL_BROWSER; ?>
				<?php $this->title( $option_id ); ?>
			</th>
			<td>
				<?php $this->build_input( $option_id ); ?> <?php $this->readable_seconds(); ?>
				<div class="litespeed-desc">
					<?php esc_html_e( 'The amount of time, in seconds, that files will be stored in browser cache before expiring.', 'zinn-cache-pro' ); ?>
					<?php $this->recommended( $option_id ); ?>
					<?php $this->_validate_ttl( $option_id, 30 ); ?>
				</div>
			</td>
		</tr>
	</tbody>
</table>
