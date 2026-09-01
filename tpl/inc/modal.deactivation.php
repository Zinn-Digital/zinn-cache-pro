<?php
/**
 * Zinn® Cache Engine Deactivation Modal
 *
 * Renders the deactivation modal interface for Zinn® Cache Engine, allowing users to send reason of deactivation.
 *
 * @package ZinnCachePro
 * @since 7.3
 */

namespace ZinnCachePro;

defined( 'WPINC' ) || exit;

// Modal data
$_title = esc_html__('Deactivate Zinn® Cache Engine', 'zinn-cache-pro');
$_id    = 'litespeed-modal-deactivate';

$reasons = array(
	array(
		'value' => 'Temporary',
		'text' => esc_html__('The deactivation is temporary', 'zinn-cache-pro'),
		'id' => 'temp',
		'selected' => true,
	),
	array(
		'value' => 'Performance worse',
		'text' => esc_html__('Site performance is worse', 'zinn-cache-pro'),
		'id' => 'performance',
	),
	array(
		'value' => 'Plugin complicated',
		'text' => esc_html__('Plugin is too complicated', 'zinn-cache-pro'),
		'id' => 'complicated',
	),
	array(
		'value' => 'Other',
		'text' => esc_html__('Other', 'zinn-cache-pro'),
		'id' => 'other',
	),
);
?>
<div style="display: none">
    <div id="litespeed-deactivation" class="iziModal">
        <div id="litespeed-modal-deactivate">
            <form id="litespeed-deactivation-form" method="post">
                <p><?php esc_attr_e('Why are you deactivating the plugin?', 'zinn-cache-pro'); ?></p>
                <div class="deactivate-reason-wrapper">
                    <?php foreach ($reasons as $reason) : ?>
                    <label for="litespeed-deactivate-reason-<?php echo esc_attr( $reason['id'] ); ?>">
                        <input type="radio" id="litespeed-deactivate-reason-<?php echo esc_attr( $reason['id'] ); ?>" value="<?php echo esc_attr( $reason['value'] ); ?>"
                            <?php isset($reason['selected']) && $reason['selected'] ? ' checked="checked"' : ''; ?> name="litespeed-reason" />
                        <?php echo esc_html( $reason['text'] ); ?>
                    </label>
                    <?php endforeach; ?>
                </div>
                <div class="deactivate-clear-settings-wrapper">
                    <i style="font-size: 0.9em;">
                        <?php
                            esc_html_e('On uninstall, all plugin settings will be deleted.', 'zinn-cache-pro');
                        ?>
                    </i>
                    <br />
                    <i style="font-size: 0.9em;">

                        <?php
                            printf(
                                esc_html__('If you have used Image Optimization, please %sDestroy All Optimization Data%s first. NOTE: this does not remove your optimized images.', 'zinn-cache-pro'),
                                '<a href="admin.php?page=zinn-cache-pro-img_optm#litespeed-imageopt-destroy" target="_blank">',
                                '</a>'
                            );
                        ?>
                    </i>
                </div>
                <div class="deactivate-actions">
                    <input type="submit" id="litespeed-deactivation-form-submit" class="button button-primary" value="<?php esc_attr_e('Deactivate', 'zinn-cache-pro'); ?>" title="<?php esc_attr_e('Deactivate plugin', 'zinn-cache-pro'); ?>" />
                    <input type="button" id="litespeed-deactivation-form-cancel" class="button litespeed-btn-warning" value="<?php esc_attr_e('Cancel', 'zinn-cache-pro'); ?>" title="<?php esc_attr_e('Close popup', 'zinn-cache-pro'); ?>" />
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    (function ($) {
    'use strict';
        jQuery(document).ready(function () {
            var modalesc_attr_element = $('#litespeed-deactivation');
            var deactivateesc_attr_element = $('#deactivate-zinn-cache-pro');

            if (deactivateesc_attr_element.length > 0 && modalesc_attr_element.length > 0) {
                // Variables
                var modal_formElement = $('#litespeed-deactivation-form');

                deactivateesc_attr_element.on('click', function (e) {
                    e.preventDefault();
                    e.stopImmediatePropagation();
                    modal_formElement.attr('action', decodeURI($(this).attr('href')));
                    modalesc_attr_element.iziModal({
                        radius: '.5rem',
                        width: 550,
                        autoOpen: true,
                    });
                });

                $(document).on('submit', '#litespeed-deactivation-form', function (e) {
                    e.preventDefault();
                    $('#litespeed-deactivation-form-submit').attr('disabled', true);
                    $('#litespeed-deactivation-form')[0].submit();
                });
                $(document).on('click', '#litespeed-deactivation-form-cancel', function (e) {
                    modalesc_attr_element.iziModal('close');
                });
            }
        });
    })(jQuery);
</script>
