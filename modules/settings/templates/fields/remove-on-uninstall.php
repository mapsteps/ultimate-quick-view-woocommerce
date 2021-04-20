<?php
/**
 * Remove on uninstall field.
 *
 * @package Ultimate_Quick_View
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );

return function () {

	$settings   = get_option( 'uquickview_settings' );
	$is_checked = isset( $settings['remove_on_uninstall'] ) ? 1 : 0;
	?>

	<label for="uquickview_settings[remove_on_uninstall]" class="label checkbox-label">
		&nbsp;
		<input type="checkbox" name="uquickview_settings[remove_on_uninstall]" id="uquickview_settings[remove_on_uninstall]" value="1" <?php checked( $is_checked, 1 ); ?>>
		<div class="indicator"></div>
	</label>

	<?php

};
