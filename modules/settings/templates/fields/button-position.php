<?php
/**
 * Button position field.
 *
 * @package Ultimate_Woo_Quick_View
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );

return function () {

	$settings = get_option( 'uwquickview_settings' );
	$value    = isset( $settings['button_position'] ) ? $settings['button_position'] : 'woocommerce_before_shop_loop_item_title';
	$options  = array(
		'woocommerce_before_shop_loop_item_title' => __( 'Before product title', 'ultimate-woo-quick-view' ),
		'woocommerce_after_shop_loop_item_title'  => __( 'Before add to cart button', 'ultimate-woo-quick-view' ),
		'woocommerce_after_shop_loop_item_20'     => __( 'After add to cart button', 'ultimate-woo-quick-view' ),
	);
	?>

	<select name="uwquickview_settings[button_position]" id="uwquickview_settings-button_position" class="widefat">
		<?php foreach ( $options as $option_value => $option_text ) : ?>
			<option value="<?php echo esc_html( $option_value ); ?>" <?php selected( $value, $option_value ); ?>>
				<?php echo esc_html( $option_text ); ?>
			</option>
		<?php endforeach; ?>
	</select>

	<?php

};
