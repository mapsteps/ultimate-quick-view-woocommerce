<?php
/**
 * Remove on uninstall field.
 *
 * @package Woocommerce_Quick_View
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );

return function () {

	$settings   = get_option( 'wooquickview_settings' );
	$is_checked = isset( $settings['remove_on_uninstall'] ) ? 1 : 0;
	?>

	<label for="wooquickview_settings[remove_on_uninstall]" class="label checkbox-label">
		&nbsp;
		<input type="checkbox" name="wooquickview_settings[remove_on_uninstall]" id="wooquickview_settings[remove_on_uninstall]" value="1" <?php checked( $is_checked, 1 ); ?>>
		<div class="indicator"></div>
	</label>

	<?php

};
