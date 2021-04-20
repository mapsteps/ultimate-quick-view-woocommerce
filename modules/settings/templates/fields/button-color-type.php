<?php
/**
 * Button color type field.
 *
 * @package Ultimate_Woo_Quick_View
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );

use Uwquickview\Vars;

/**
 * Outputting button color type field.
 *
 * @param Settings_Module $module The Settings_Module instance.
 */
return function ( $module ) {

	$defaults = $module->defaults;
	$settings = $module->settings;
	$values   = $module->values;
	?>

	<div class="uwquickview-inline-fields">
		<div class="uwquickview-field">
			<label for="uwquickview_settings-button_text_color" class="uwquickview-label">
				Text Color
			</label>
			<div class="uwquickview-control">
				<input type="text" name="uwquickview_settings[button_text_color]" id="uwquickview_settings-button_text_color" value="<?php echo esc_attr( $values['button_text_color'] ); ?>" class="color-picker" data-alpha-enabled="true" data-default-value="<?php echo esc_attr( $defaults['button_text_color'] ); ?>" data-alpha-custom-width="false" data-alpha-color-type="hex">
			</div>
		</div>
		<div class="uwquickview-field">
			<label for="uwquickview_settings-button_text_color" class="uwquickview-label">
				Text Hover
			</label>
			<div class="uwquickview-control">
				<input type="text" name="uwquickview_settings[button_text_accent_color]" id="uwquickview_settings-button_text_accent_color" value="<?php echo esc_attr( $values['button_text_accent_color'] ); ?>" class="color-picker" data-alpha-enabled="true" data-default-value="<?php echo esc_attr( $defaults['button_text_accent_color'] ); ?>" data-alpha-custom-width="false" data-alpha-color-type="hex">
			</div>
		</div>
		<div class="uwquickview-field">
			<label for="uwquickview_settings-button_bg_color" class="uwquickview-label">
				Background
			</label>
			<div class="uwquickview-control">
				<input type="text" name="uwquickview_settings[button_bg_color]" id="uwquickview_settings-button_bg_color" value="<?php echo esc_attr( $values['button_bg_color'] ); ?>" class="color-picker" data-alpha-enabled="true" data-default-value="<?php echo esc_attr( $defaults['button_bg_color'] ); ?>" data-alpha-custom-width="false" data-alpha-color-type="hex">
			</div>
		</div>
		<div class="uwquickview-field">
			<label for="uwquickview_settings-button_bg_color" class="uwquickview-label">
				Background Hover
			</label>
			<div class="uwquickview-control">
				<input type="text" name="uwquickview_settings[button_bg_accent_color]" id="uwquickview_settings-button_bg_accent_color" value="<?php echo esc_attr( $values['button_bg_accent_color'] ); ?>" class="color-picker" data-alpha-enabled="true" data-default-value="<?php echo esc_attr( $defaults['button_bg_accent_color'] ); ?>" data-alpha-custom-width="false" data-alpha-color-type="hex">
			</div>
		</div>
	</div>

	<?php

};
