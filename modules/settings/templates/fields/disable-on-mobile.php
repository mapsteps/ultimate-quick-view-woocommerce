<?php
/**
 * Field to disable quick view on mobile.
 *
 * @package Ultimate_Woo_Quick_View
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );

/**
 * Outputting "disable quick view on mobile" field.
 *
 * @param Settings_Module $module The Settings_Module instance.
 */
return function ( $module ) {

	$is_checked = isset( $this->settings['disable_on_mobile'] ) ? 1 : 0;
	?>

	<label for="uwquickview_settings-disable_on_mobile" class="label checkbox-label">
		&nbsp;
		<input type="checkbox" name="uwquickview_settings[disable_on_mobile]" id="uwquickview_settings-disable_on_mobile" value="1" <?php checked( $is_checked, 1 ); ?>>
		<div class="indicator"></div>
	</label>

	<?php

};
