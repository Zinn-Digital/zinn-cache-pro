<?php
/**
 * Zinn® Cache Pro Standard Presets
 *
 * Renders the standard presets interface for Zinn® Cache Pro, allowing users to apply predefined configuration presets.
 *
 * @package ZinnCachePro
 * @since 1.0.0
 */

namespace ZinnCachePro;

defined( 'WPINC' ) || exit;

$presets = array(
	'essentials' => array(
		'title'  => esc_html__( 'Essentials', 'zinn-cache-pro' ),
		'body'   => array(
			esc_html__( 'Default Cache', 'zinn-cache-pro' ),
			esc_html__( 'Higher TTL', 'zinn-cache-pro' ),
			esc_html__( 'Browser Cache', 'zinn-cache-pro' ),
		),
		'footer' => array(
			esc_html__( 'This no-risk preset is appropriate for all websites. Good for new users, simple websites, or cache-oriented development.', 'zinn-cache-pro' ),
			esc_html__( 'A QUIC.cloud connection is not required to use this preset. Only basic caching features are enabled.', 'zinn-cache-pro' ),
		),
	),
	'basic' => array(
		'title'  => esc_html__( 'Basic', 'zinn-cache-pro' ),
		'body'   => array(
			esc_html__( 'Everything in Essentials, Plus', 'zinn-cache-pro' ),
			esc_html__( 'Image Optimization', 'zinn-cache-pro' ),
			esc_html__( 'Mobile Cache', 'zinn-cache-pro' ),
		),
		'footer' => array(
			esc_html__( 'This low-risk preset introduces basic optimizations for speed and user experience. Appropriate for enthusiastic beginners.', 'zinn-cache-pro' ),
			esc_html__( 'A QUIC.cloud connection is required to use this preset. Includes optimizations known to improve site score in page speed measurement tools.', 'zinn-cache-pro' ),
		),
	),
	'advanced' => array(
		'title'  => esc_html__( 'Advanced (Recommended)', 'zinn-cache-pro' ),
		'body'   => array(
			esc_html__( 'Everything in Basic, Plus', 'zinn-cache-pro' ),
			esc_html__( 'Guest Mode and Guest Optimization', 'zinn-cache-pro' ),
			esc_html__( 'CSS, JS and HTML Minification', 'zinn-cache-pro' ),
			esc_html__( 'Font Display Optimization', 'zinn-cache-pro' ),
			esc_html__( 'JS Defer for both external and inline JS', 'zinn-cache-pro' ),
			esc_html__( 'DNS Prefetch for static files', 'zinn-cache-pro' ),
			esc_html__( 'Gravatar Cache', 'zinn-cache-pro' ),
			esc_html__( 'Remove Query Strings from Static Files', 'zinn-cache-pro' ),
			esc_html__( 'Remove WordPress Emoji', 'zinn-cache-pro' ),
			esc_html__( 'Remove Noscript Tags', 'zinn-cache-pro' ),
		),
		'footer' => array(
			esc_html__( 'This preset is good for most websites, and is unlikely to cause conflicts. Any CSS or JS conflicts may be resolved with Page Optimization > Tuning tools.', 'zinn-cache-pro' ),
			esc_html__( 'A QUIC.cloud connection is required to use this preset. Includes many optimizations known to improve page speed scores.', 'zinn-cache-pro' ),
		),
	),
	'aggressive' => array(
		'title'  => esc_html__( 'Aggressive', 'zinn-cache-pro' ),
		'body'   => array(
			esc_html__( 'Everything in Advanced, Plus', 'zinn-cache-pro' ),
			esc_html__( 'CSS & JS Combine', 'zinn-cache-pro' ),
			esc_html__( 'Asynchronous CSS Loading with Critical CSS', 'zinn-cache-pro' ),
			esc_html__( 'Removed Unused CSS for Users', 'zinn-cache-pro' ),
			esc_html__( 'Lazy Load for Iframes', 'zinn-cache-pro' ),
		),
		'footer' => array(
			esc_html__( 'This preset might work out of the box for some websites, but be sure to test! Some CSS or JS exclusions may be necessary in Page Optimization > Tuning.', 'zinn-cache-pro' ),
			esc_html__( 'A QUIC.cloud connection is required to use this preset. Includes many optimizations known to improve page speed scores.', 'zinn-cache-pro' ),
		),
	),
	'extreme' => array(
		'title'  => esc_html__( 'Extreme', 'zinn-cache-pro' ),
		'body'   => array(
			esc_html__( 'Everything in Aggressive, Plus', 'zinn-cache-pro' ),
			esc_html__( 'Lazy Load for Images', 'zinn-cache-pro' ),
			esc_html__( 'Viewport Image Generation', 'zinn-cache-pro' ),
			esc_html__( 'JS Delayed', 'zinn-cache-pro' ),
			esc_html__( 'Inline JS added to Combine', 'zinn-cache-pro' ),
			esc_html__( 'Inline CSS added to Combine', 'zinn-cache-pro' ),
		),
		'footer' => array(
			esc_html__( 'This preset almost certainly will require testing and exclusions for some CSS, JS and Lazy Loaded images. Pay special attention to logos, or HTML-based slider images.', 'zinn-cache-pro' ),
			esc_html__( 'A QUIC.cloud connection is required to use this preset. Enables the maximum level of optimizations for improved page speed scores.', 'zinn-cache-pro' ),
		),
	),
);
?>

<h3 class="litespeed-title-short">
	<?php esc_html_e( 'Zinn® Cache Pro Standard Presets', 'zinn-cache-pro' ); ?>
	<?php Doc::learn_more( 'https://docs.litespeedtech.com/lscache/lscwp/presets/#standard-tab' ); ?>
</h3>

<p><?php esc_html_e( 'Use an official LiteSpeed-designed Preset to configure your site in one click. Try no-risk caching essentials, extreme optimization, or something in between.', 'zinn-cache-pro' ); ?></p>

<div class="litespeed-comparison-cards">
	<?php
	foreach ( array_keys( $presets ) as $name ) :
		$curr_title   = $presets[ $name ]['title'];
		$recommend    = 'advanced' === $name;
		$card_class   = $recommend ? 'litespeed-comparison-card-rec' : '';
		$button_class = $recommend ? 'button-primary' : 'button-secondary';
		?>
		<div class="litespeed-comparison-card postbox <?php echo esc_attr( $card_class ); ?>">
			<div class="litespeed-card-content">
				<div class="litespeed-card-header">
					<h3 class="litespeed-h3">
						<?php echo esc_html( $curr_title ); ?>
					</h3>
				</div>
				<div class="litespeed-card-body">
					<ul>
						<?php foreach ( $presets[ $name ]['body'] as $line ) : ?>
							<li><?php echo esc_html( $line ); ?></li>
						<?php endforeach; ?>
					</ul>
				</div>
				<div class="litespeed-card-footer">
					<h4><?php esc_html_e( 'Who should use this preset?', 'zinn-cache-pro' ); ?></h4>
					<?php foreach ( $presets[ $name ]['footer'] as $line ) : ?>
						<p><?php echo esc_html( $line ); ?></p>
					<?php endforeach; ?>
				</div>
			</div>
			<div class="litespeed-card-action">
				<a
					href="<?php echo esc_url( Utility::build_url( Router::ACTION_PRESET, Preset::TYPE_APPLY, false, null, array( 'preset' => $name ) ) ); ?>"
					class="button <?php echo esc_attr( $button_class ); ?>"
					data-zinn-cache-pro-cfm="<?php echo esc_attr( sprintf( __( 'This will back up your current settings and replace them with the %1$s preset settings. Do you want to continue?', 'zinn-cache-pro' ), $curr_title ) ); ?>"
				>
					<?php esc_html_e( 'Apply Preset', 'zinn-cache-pro' ); ?>
				</a>
			</div>
		</div>
	<?php endforeach; ?>
</div>

<?php
$summary = Preset::get_summary();
$backups = array();
foreach ( Preset::get_backups() as $backup ) {
	$backup = explode( '-', $backup );
	if ( empty( $backup[1] ) ) {
		continue;
	}
	$timestamp  = $backup[1];
	$time       = trim( Utility::readable_time( $timestamp ) );
	$name       = empty( $backup[3] ) ? null : $backup[3];
	$curr_title = empty( $presets[ $name ]['title'] ) ? $name : $presets[ $name ]['title'];
	$curr_title = null === $curr_title ? esc_html__( 'unknown', 'zinn-cache-pro' ) : $curr_title;
	$backups[]  = array(
		'timestamp' => $timestamp,
		'time'      => $time,
		'title'     => $curr_title,
	);
}

if ( ! empty( $summary['preset'] ) || ! empty( $backups ) ) :
	?>
	<h3 class="litespeed-title-short">
		<?php esc_html_e( 'History', 'zinn-cache-pro' ); ?>
	</h3>
<?php endif; ?>

<?php if ( ! empty( $summary['preset'] ) ) : ?>
	<p>
		<?php
		$name = strtolower( $summary['preset'] );
		$time = trim( Utility::readable_time( $summary['preset_timestamp'] ) );
		if ( 'error' === $name ) {
			printf( esc_html__( 'Error: Failed to apply the settings %1$s', 'zinn-cache-pro' ), esc_html( $time ) );
		} elseif ( 'backup' === $name ) {
			printf( esc_html__( 'Restored backup settings %1$s', 'zinn-cache-pro' ), esc_html( $time ) );
		} else {
			printf(
				esc_html__( 'Applied the %1$s preset %2$s', 'zinn-cache-pro' ),
				'<strong>' . esc_html( $presets[ $name ]['title'] ) . '</strong>',
				esc_html( $time )
			);
		}
		?>
	</p>
<?php endif; ?>

<?php foreach ( $backups as $backup ) : ?>
	<p>
		<?php printf( esc_html__( 'Backup created %1$s before applying the %2$s preset', 'zinn-cache-pro' ), esc_html( $backup['time'] ), esc_html( $backup['title'] ) ); ?>
		<a
			href="<?php echo esc_url( Utility::build_url( Router::ACTION_PRESET, Preset::TYPE_RESTORE, false, null, array( 'timestamp' => $backup['timestamp'] ) ) ); ?>"
			class="litespeed-left10"
			data-zinn-cache-pro-cfm="<?php echo esc_attr( sprintf( __( 'This will restore the backup settings created %1$s before applying the %2$s preset. Any changes made since then will be lost. Do you want to continue?', 'zinn-cache-pro' ), $backup['time'], $backup['title'] ) ); ?>"
		>
			<?php esc_html_e( 'Restore Settings', 'zinn-cache-pro' ); ?>
		</a>
	</p>
<?php endforeach; ?>