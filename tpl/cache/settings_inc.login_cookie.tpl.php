<?php
/**
 * Zinn® Cache Pro Login Cookie and Vary Cookies Settings
 *
 * Displays the login cookie and vary cookies settings for Zinn® Cache Pro.
 *
 * @package ZinnCachePro
 * @since 1.0.0
 */

namespace ZinnCachePro;

defined( 'WPINC' ) || exit;
?>

<tr>
	<th scope="row">
		<?php $option_id = Base::O_CACHE_LOGIN_COOKIE; ?>
		<?php $this->title( $option_id ); ?>
	</th>
	<td>
		<?php $this->build_input( $option_id ); ?>
		<?php $this->_validate_syntax( $option_id ); ?>
		<div class="litespeed-desc">
			<?php
			esc_html_e( 'SYNTAX: alphanumeric and "_". No spaces and case sensitive. MUST BE UNIQUE FROM OTHER WEB APPLICATIONS.', 'zinn-cache-pro' );
			?>
			<br />
			<?php
			printf(
				/* translators: %s: Default login cookie name */
				esc_html__( 'The default login cookie is %s.', 'zinn-cache-pro' ),
				'<code>_lscache_vary</code>'
			);
			?>
			<?php esc_html_e( 'The server will determine if the user is logged in based on the existence of this cookie.', 'zinn-cache-pro' ); ?>
			<?php esc_html_e( 'This setting is useful for those that have multiple web applications for the same domain.', 'zinn-cache-pro' ); ?>
			<?php esc_html_e( 'If every web application uses the same cookie, the server may confuse whether a user is logged in or not.', 'zinn-cache-pro' ); ?>
			<?php esc_html_e( 'The cookie set here will be used for this WordPress installation.', 'zinn-cache-pro' ); ?>
			<br />
			<?php esc_html_e( 'Example use case:', 'zinn-cache-pro' ); ?><br />
			<?php
			printf(
				/* translators: %s: Example domain */
				esc_html__( 'There is a WordPress installed for %s.', 'zinn-cache-pro' ),
				'<u>www.example.com</u>'
			);
			?>
			<br />
			<?php
			printf(
				/* translators: %s: Example subdomain */
				esc_html__( 'Then another WordPress is installed (NOT MULTISITE) at %s', 'zinn-cache-pro' ),
				'<u>www.example.com/blog/</u>'
			);
			?>
			<?php esc_html_e( 'The cache needs to distinguish who is logged into which WordPress site in order to cache correctly.', 'zinn-cache-pro' ); ?><br />
			<?php Doc::notice_htaccess(); ?>
		</div>

		<?php if ( preg_match( '#[^\w\-]#', $this->conf( $option_id ) ) ) : ?>
			<div class="litespeed-callout notice notice-error inline">
				<p>❌ <?php esc_html_e( 'Invalid login cookie. Invalid characters found.', 'zinn-cache-pro' ); ?></p>
			</div>
		<?php endif; ?>

		<?php
		if ( defined( 'ZINN_CACHE_PRO_ON' ) && $this->conf( $option_id ) ) {
			$cookie_rule = '';
			try {
				$cookie_rule = Htaccess::cls()->current_login_cookie();
			} catch ( \Exception $e ) {
				?>
				<div class="litespeed-callout notice notice-error inline">
					<p><?php echo esc_html( $e->getMessage() ); ?></p>
				</div>
				<?php
			}

			$cookie_arr = explode( ',', $cookie_rule );
			if ( ! in_array( $this->conf( $option_id ), $cookie_arr, true ) ) {
				?>
				<div class="litespeed-callout notice notice-warning inline">
					<p><?php esc_html_e( 'WARNING: The .htaccess login cookie and Database login cookie do not match.', 'zinn-cache-pro' ); ?></p>
				</div>
				<?php
			}
		}
		?>
	</td>
</tr>

<tr>
	<th scope="row">
		<?php $option_id = Base::O_CACHE_VARY_COOKIES; ?>
		<?php $this->title( $option_id ); ?>
	</th>
	<td>
		<?php $this->build_textarea( $option_id, 50 ); ?>
		<?php $this->_validate_syntax( $option_id ); ?>
		<div class="litespeed-desc">
			<?php esc_html_e( 'SYNTAX: alphanumeric and "_". No spaces and case sensitive.', 'zinn-cache-pro' ); ?>
			<br />
			<?php esc_html_e( 'You can list the 3rd party vary cookies here.', 'zinn-cache-pro' ); ?>
			<br />
			<?php Doc::notice_htaccess(); ?>
		</div>
	</td>
</tr>