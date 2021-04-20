<?php
/**
 * Button colors field.
 *
 * @package Ultimate_Quick_View
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );

/**
 * Outputting button colors field.
 *
 * @param Settings_Module $module The Settings_Module instance.
 */
return function ( $module ) {

	$defaults = $module->defaults;
	$values   = $module->values;
	?>

	<div class="uquickview-inline-fields">
		<div class="uquickview-field">
			<label for="uquickview_settings-button_text_color" class="uquickview-label">
				Text Color
			</label>
			<div class="uquickview-control">
				<input type="text" name="uquickview_settings[button_text_color]" id="uquickview_settings-button_text_color" value="<?php echo esc_attr( $values['button_text_color'] ); ?>" class="color-picker" data-alpha-enabled="true" data-default-value="<?php echo esc_attr( $defaults['button_text_color'] ); ?>" data-alpha-custom-width="false" data-alpha-color-type="hex">
			</div>
		</div>
		<div class="uquickview-field">
			<label for="uquickview_settings-button_text_color" class="uquickview-label">
				Text Hover
			</label>
			<div class="uquickview-control">
				<input type="text" name="uquickview_settings[button_text_accent_color]" id="uquickview_settings-button_text_accent_color" value="<?php echo esc_attr( $values['button_text_accent_color'] ); ?>" class="color-picker" data-alpha-enabled="true" data-default-value="<?php echo esc_attr( $defaults['button_text_accent_color'] ); ?>" data-alpha-custom-width="false" data-alpha-color-type="hex">
			</div>
		</div>
		<div class="uquickview-field">
			<label for="uquickview_settings-button_bg_color" class="uquickview-label">
				Background
			</label>
			<div class="uquickview-control">
				<input type="text" name="uquickview_settings[button_bg_color]" id="uquickview_settings-button_bg_color" value="<?php echo esc_attr( $values['button_bg_color'] ); ?>" class="color-picker" data-alpha-enabled="true" data-default-value="<?php echo esc_attr( $defaults['button_bg_color'] ); ?>" data-alpha-custom-width="false" data-alpha-color-type="hex">
			</div>
		</div>
		<div class="uquickview-field">
			<label for="uquickview_settings-button_bg_color" class="uquickview-label">
				Background Hover
			</label>
			<div class="uquickview-control">
				<input type="text" name="uquickview_settings[button_bg_accent_color]" id="uquickview_settings-button_bg_accent_color" value="<?php echo esc_attr( $values['button_bg_accent_color'] ); ?>" class="color-picker" data-alpha-enabled="true" data-default-value="<?php echo esc_attr( $defaults['button_bg_accent_color'] ); ?>" data-alpha-custom-width="false" data-alpha-color-type="hex">
			</div>
		</div>
	</div>

	<?php

};
