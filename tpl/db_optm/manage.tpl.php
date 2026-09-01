<?php
/**
 * Zinn® Cache Engine Database Optimization
 *
 * Manages database optimization options and displays table engine conversion tools.
 *
 * @package ZinnCachePro
 * @since 1.0.0
 */

namespace ZinnCachePro;

defined( 'WPINC' ) || exit;

$_panels = array(
    'all' => array(
        'title' => esc_html__( 'Clean All', 'zinn-cache-pro' ),
        'desc'  => '',
    ),
    'revision' => array(
        'title' => esc_html__( 'Post Revisions', 'zinn-cache-pro' ),
        'desc'  => esc_html__( 'Clean all post revisions', 'zinn-cache-pro' ),
    ),
    'orphaned_post_meta' => array(
        'title' => esc_html__( 'Orphaned Post Meta', 'zinn-cache-pro' ),
        'desc'  => esc_html__( 'Clean all orphaned post meta records', 'zinn-cache-pro' ),
    ),
    'auto_draft' => array(
        'title' => esc_html__( 'Auto Drafts', 'zinn-cache-pro' ),
        'desc'  => esc_html__( 'Clean all auto saved drafts', 'zinn-cache-pro' ),
    ),
    'trash_post' => array(
        'title' => esc_html__( 'Trashed Posts', 'zinn-cache-pro' ),
        'desc'  => esc_html__( 'Clean all trashed posts and pages', 'zinn-cache-pro' ),
    ),
    'spam_comment' => array(
        'title' => esc_html__( 'Spam Comments', 'zinn-cache-pro' ),
        'desc'  => esc_html__( 'Clean all spam comments', 'zinn-cache-pro' ),
    ),
    'trash_comment' => array(
        'title' => esc_html__( 'Trashed Comments', 'zinn-cache-pro' ),
        'desc'  => esc_html__( 'Clean all trashed comments', 'zinn-cache-pro' ),
    ),
    'trackback-pingback' => array(
        'title' => esc_html__( 'Trackbacks/Pingbacks', 'zinn-cache-pro' ),
        'desc'  => esc_html__( 'Clean all trackbacks and pingbacks', 'zinn-cache-pro' ),
    ),
    'expired_transient' => array(
        'title' => esc_html__( 'Expired Transients', 'zinn-cache-pro' ),
        'desc'  => esc_html__( 'Clean expired transient options', 'zinn-cache-pro' ),
    ),
    'all_transients' => array(
        'title' => esc_html__( 'All Transients', 'zinn-cache-pro' ),
        'desc'  => esc_html__( 'Clean all transient options', 'zinn-cache-pro' ),
    ),
    'optimize_tables' => array(
        'title' => esc_html__( 'Optimize Tables', 'zinn-cache-pro' ),
        'desc'  => esc_html__( 'Optimize all tables in your database', 'zinn-cache-pro' ),
    ),
);

$rev_max = $this->conf( Base::O_DB_OPTM_REVISIONS_MAX );
$rev_age = $this->conf( Base::O_DB_OPTM_REVISIONS_AGE );
if ( $rev_max || $rev_age ) {
    $_panels['revision']['desc'] = sprintf(
		esc_html__( 'Clean revisions older than %1$s day(s), excluding %2$s latest revisions', 'zinn-cache-pro' ),
		'<strong>' . esc_html( $rev_age ) . '</strong>',
		'<strong>' . esc_html( $rev_max ) . '</strong>'
	);
}

$total = 0;
foreach ( $_panels as $key => $v ) {
    if ( 'all' !== $key ) {
        $_panels[ $key ]['count'] = $this->cls( 'DB_Optm' )->db_count( $key );
        if ( ! in_array( $key, array( 'optimize_tables' ), true ) ) {
            $total += $_panels[ $key ]['count'];
        }
    }
    $_panels[ $key ]['link'] = Utility::build_url( Router::ACTION_DB_OPTM, $key );
}

$_panels['all']['count'] = $total;

$autoload_summary = DB_Optm::cls()->autoload_summary();

?>

<h3 class="litespeed-title">
    <?php esc_html_e( 'Database Optimizer', 'zinn-cache-pro' ); ?>
    <?php Doc::learn_more( 'https://docs.litespeedtech.com/lscache/lscwp/database/' ); ?>
</h3>

<div class="litespeed-panel-wrapper litespeed-cards-wrapper">

    <?php foreach ( $_panels as $key => $v ) : ?>
        <a href="<?php echo esc_url( $v['link'] ); ?>" class="litespeed-panel postbox">
            <section class="litespeed-panel-wrapper-icon">
                <span class="litespeed-panel-icon-<?php echo esc_attr( $key ); ?>"></span>
            </section>
            <section class="litespeed-panel-content">
                <div class="litespeed-h3">
                    <?php echo esc_html( $v['title'] ); ?>
                    <span class="litespeed-panel-counter<?php echo $v['count'] > 0 ? '-red' : ''; ?>">(<?php echo esc_html( $v['count'] ); ?><?php echo DB_Optm::hide_more() ? '+' : ''; ?>)</span>
                </div>
                <span class="litespeed-panel-para"><?php echo wp_kses_post( $v['desc'] ); ?></span>
            </section>
            <section class="litespeed-panel-wrapper-top-right">
                <span class="litespeed-panel-top-right-icon<?php echo $v['count'] > 0 ? '-cross' : '-tick'; ?>"></span>
            </section>
        </a>
    <?php endforeach; ?>

</div>

<h3 class="litespeed-title"><?php esc_html_e( 'Database Table Engine Converter', 'zinn-cache-pro' ); ?></h3>

<div class="litespeed-panel-wrapper">

    <table class="wp-list-table widefat striped">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col"><?php esc_html_e( 'Table', 'zinn-cache-pro' ); ?></th>
                <th scope="col"><?php esc_html_e( 'Engine', 'zinn-cache-pro' ); ?></th>
                <th scope="col"><?php esc_html_e( 'Tool', 'zinn-cache-pro' ); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php
            $list = DB_Optm::cls()->list_myisam();
            if ( ! empty( $list ) ) :
                foreach ( $list as $k => $v ) :
                    ?>
                    <tr>
                        <td><?php echo esc_html( $k + 1 ); ?></td>
                        <td><?php echo esc_html( $v->table_name ); ?></td>
                        <td><?php echo esc_html( $v->engine ); ?></td>
                        <td>
                            <a href="<?php echo esc_url( Utility::build_url( Router::ACTION_DB_OPTM, DB_Optm::TYPE_CONV_TB, false, false, array( 'zinn_cache_pro_tb' => $v->table_name ) ) ); ?>">
                                <?php esc_html_e( 'Convert to InnoDB', 'zinn-cache-pro' ); ?>
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else : ?>
                <tr>
                    <td colspan="4" class="litespeed-success litespeed-text-center">
                        <?php esc_html_e( 'We are good. No table uses MyISAM engine.', 'zinn-cache-pro' ); ?>
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

</div>

<style type="text/css">
    .litespeed-body .field-col {
        display: inline-block;
        vertical-align: top;
        margin-left: 20px;
        margin-right: 20px;
    }

    .litespeed-body .field-col:first-child {
        margin-left: 0;
    }
</style>

<h3 class="litespeed-title"><?php esc_html_e( 'Database Summary', 'zinn-cache-pro' ); ?></h3>
<div>
    <div class="field-col">
        <p>
        	<?php esc_html_e( 'Autoload size', 'zinn-cache-pro' ); ?>: <strong><?php echo esc_html( Utility::real_size( $autoload_summary->autoload_size ) ); ?></strong></p>
        <p><?php esc_html_e( 'Autoload entries', 'zinn-cache-pro' ); ?>: <strong><?php echo esc_html( $autoload_summary->autload_entries ); ?></strong></p>
    </div>

    <div class="field-col">
        <p><?php esc_html_e( 'Autoload top list', 'zinn-cache-pro' ); ?>:</p>
        <table class="wp-list-table widefat striped litespeed-width-auto litespeed-table-compact">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col"><?php esc_html_e( 'Option Name', 'zinn-cache-pro' ); ?></th>
                    <th scope="col"><?php esc_html_e( 'Autoload', 'zinn-cache-pro' ); ?></th>
                    <th scope="col"><?php esc_html_e( 'Size', 'zinn-cache-pro' ); ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ( $autoload_summary->autoload_toplist as $k => $v ) : ?>
                    <tr>
                        <td><?php echo esc_html( $k + 1 ); ?></td>
                        <td><?php echo esc_html( $v->option_name ); ?></td>
                        <td><?php echo esc_html( $v->autoload ); ?></td>
                        <td><?php echo esc_html( $v->option_value_length ); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>