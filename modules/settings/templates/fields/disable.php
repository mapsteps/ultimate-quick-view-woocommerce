<?php
/**
 * Field to disable quick view.
 *
 * @package Ultimate_Woo_Quick_View
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );

return function () {

	$settings   = get_option( 'uwquickview_settings' );
	$is_checked = isset( $settings['disable'] ) ? 1 : 0;
	?>

	<label for="uwquickview_settings[disable]" class="label checkbox-label">
		&nbsp;
		<input type="checkbox" name="uwquickview_settings[disable]" id="uwquickview_settings[disable]" value="1" <?php checked( $is_checked, 1 ); ?>>
		<div class="indicator"></div>
	</label>

	<?php

};
