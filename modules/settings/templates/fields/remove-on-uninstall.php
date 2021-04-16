<?php
/**
 * Remove on uninstall field.
 *
 * @package Ultimate_Woo_Quick_View
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );

return function () {

	$settings   = get_option( 'uwquickview_settings' );
	$is_checked = isset( $settings['remove_on_uninstall'] ) ? 1 : 0;
	?>

	<label for="uwquickview_settings[remove_on_uninstall]" class="label checkbox-label">
		&nbsp;
		<input type="checkbox" name="uwquickview_settings[remove_on_uninstall]" id="uwquickview_settings[remove_on_uninstall]" value="1" <?php checked( $is_checked, 1 ); ?>>
		<div class="indicator"></div>
	</label>

	<?php

};
