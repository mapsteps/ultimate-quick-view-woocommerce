<?php
/**
 * Button text field.
 *
 * @package Ultimate_Woo_Quick_View
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );

return function () {

	$settings = get_option( 'uwquickview_settings' );
	$default  = __( 'Quick View', 'ultimate-woo-quick-view' );
	$value    = isset( $settings['button_text'] ) ? $settings['button_text'] : $default;
	?>

	<input type="text" name="uwquickview_settings[button_text]" class="all-options" value="<?php echo esc_attr( $value ); ?>" placeholder="<?php echo esc_attr( $default ); ?>" />

	<?php

};
