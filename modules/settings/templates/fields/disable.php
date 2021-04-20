<?php
/**
 * Field to disable quick view.
 *
 * @package Ultimate_Woo_Quick_View
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );

/**
 * Outputting disable quick view field.
 *
 * @param Settings_Module $module The Settings_Module instance.
 */
return function ( $module ) {

	$is_checked = isset( $module->settings['disable'] ) ? 1 : 0;
	?>

	<label for="uwquickview_settings-disable" class="label checkbox-label">
		&nbsp;
		<input type="checkbox" name="uwquickview_settings[disable]" id="uwquickview_settings-disable" value="1" <?php checked( $is_checked, 1 ); ?>>
		<div class="indicator"></div>
	</label>

	<?php

};
