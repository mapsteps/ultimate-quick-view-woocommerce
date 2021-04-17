<?php
/**
 * Field to disable quick view on mobile.
 *
 * @package Ultimate_Woo_Quick_View
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );

return function () {

	$settings   = get_option( 'uwquickview_settings' );
	$is_checked = isset( $settings['disable_on_mobile'] ) ? 1 : 0;
	?>

	<label for="uwquickview_settings-disable_on_mobile" class="label checkbox-label">
		&nbsp;
		<input type="checkbox" name="uwquickview_settings[disable_on_mobile]" id="uwquickview_settings-disable_on_mobile" value="1" <?php checked( $is_checked, 1 ); ?>>
		<div class="indicator"></div>
	</label>

	<?php

};
