<?php
/**
 * Some setting field.
 *
 * @package Ultimate_Woo_Quick_View
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );

return function () {

	$settings  = get_option( 'uwquickview_settings' );
	$something = isset( $settings['some_setting'] ) ? $settings['some_setting'] : '';
	?>

	<input type="text" name="uwquickview_settings[some_setting]" class="all-options" value="<?php echo esc_attr( $something ); ?>" placeholder="<?php _e( 'Something', 'ultimate-woo-quick-view' ); ?>" />

	<?php

};
