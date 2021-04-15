<?php
/**
 * Some setting field.
 *
 * @package Woocommerce_Quick_View
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );

return function () {

	$settings  = get_option( 'wooquickview_settings' );
	$something = isset( $settings['some_setting'] ) ? $settings['some_setting'] : '';
	?>

	<input type="text" name="wooquickview_settings[some_setting]" class="all-options" value="<?php echo esc_attr( $something ); ?>" placeholder="<?php _e( 'Something', 'woocommerce-quick-view' ); ?>" />

	<?php

};
