<?php
/**
 * Button color type field.
 *
 * @package Ultimate_Woo_Quick_View
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );

return function () {

	$settings = get_option( 'uwquickview_settings' );
	$value    = isset( $settings['button_color_type'] ) ? $settings['button_color_type'] : 'default';
	?>

	<select name="uwquickview_settings[button_color_type]" id="uwquickview_settings-button_color_type" class="regular-text">
		<option value="default" <?php selected( $value, 'default' ); ?>>
			<?php _e( 'Default to theme', 'ultimate-woo-quick-view' ); ?>
		</option>
		<option value="custom" <?php selected( $value, 'custom' ); ?>>
			<?php _e( 'Select custom color', 'ultimate-woo-quick-view' ); ?>
		</option>
	</select>

	<?php

};
