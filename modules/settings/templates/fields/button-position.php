<?php
/**
 * Button position field.
 *
 * @package Ultimate_Quick_View
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );

return function () {

	$settings = get_option( 'uquickview_settings' );
	$value    = isset( $settings['button_position'] ) ? $settings['button_position'] : 'woocommerce_before_shop_loop_item_title';
	$options  = array(
		'woocommerce_before_shop_loop_item_title' => __( 'Under product image', 'ultimate-quick-view-woocommerce' ),
		'woocommerce_after_shop_loop_item_9'      => __( 'Before "Add to cart" button', 'ultimate-quick-view-woocommerce' ),
		'woocommerce_after_shop_loop_item_20'     => __( 'After "Add to cart" button', 'ultimate-quick-view-woocommerce' ),
	);
	?>

	<select name="uquickview_settings[button_position]" id="uquickview_settings-button_position" class="regular-text">
		<?php foreach ( $options as $option_value => $option_text ) : ?>
			<option value="<?php echo esc_html( $option_value ); ?>" <?php selected( $value, $option_value ); ?>>
				<?php echo esc_html( $option_text ); ?>
			</option>
		<?php endforeach; ?>
	</select>

	<?php

};
