<?php
/**
 * Quick view styles based on saved settings.
 *
 * @package Ultimate_Quick_View
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );

/**
 * Outputting quick view styles.
 *
 * @param Quick_View_Output $module_output The Quick_View_Output instance.
 */
return function ( $module_output ) {

	$settings = $module_output->settings;
	$values   = $module_output->values;
	?>

	.product a.uquickview-button,
	.product button.uquickview-button {
		<?php if ( $values['button_text_color'] ) : ?>
			color: <?php echo esc_attr( $values['button_text_color'] ); ?>;
		<?php endif; ?>

		<?php if ( $values['button_bg_color'] ) : ?>
			background-color: <?php echo esc_attr( $values['button_bg_color'] ); ?>;
		<?php endif; ?>
	}

	.product a.uquickview-button:hover,
	.product button.uquickview-button:hover {
		<?php if ( $values['button_text_accent_color'] ) : ?>
			color: <?php echo esc_attr( $values['button_text_accent_color'] ); ?>;
		<?php endif; ?>

		<?php if ( $values['button_bg_accent_color'] ) : ?>
			background-color: <?php echo esc_attr( $values['button_bg_accent_color'] ); ?>;
		<?php endif; ?>
	}

	@media screen and (max-width: 767px) {
		<?php if ( isset( $settings['disable_on_mobile'] ) ) : ?>
			.product a.uquickview-button,
			.product button.uquickview-button {
				display: none;
			}
		<?php endif; ?>
	}

	<?php
};
