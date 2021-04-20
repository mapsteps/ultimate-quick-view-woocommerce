<?php
/**
 * Button text field.
 *
 * @package Ultimate_Quick_View
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );

/**
 * Outputting button colors field.
 *
 * @param Settings_Module $module The Settings_Module instance.
 */
return function ( $module ) {

	$defaults = $module->defaults;
	$values   = $module->values;
	?>

	<input type="text" name="uquickview_settings[button_text]" class="regular-text" value="<?php echo esc_attr( $values['button_text'] ); ?>" placeholder="<?php echo esc_attr( $defaults['button_text'] ); ?>" />

	<?php

};
