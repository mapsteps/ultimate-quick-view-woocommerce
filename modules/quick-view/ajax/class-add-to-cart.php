<?php
/**
 * Add to cart from quick view mode.
 *
 * @package Ultimate_Quick_View
 */

namespace Ultimatequickview\QuickView\Ajax;

defined( 'ABSPATH' ) || die( "Can't access directly" );

use WC_Product_Data_Store_CPT;
use WC_Product;

/**
 * Class to setup add to cart.
 */
class Add_To_Cart {

	/**
	 * Targetted product id.
	 *
	 * @var int
	 */
	private $product_id;

	/**
	 * The requested quantity.
	 *
	 * @var int
	 */
	private $quantity;

	/**
	 * Whether or not the requested product is product variation.
	 *
	 * @var int
	 */
	private $is_variation;

	/**
	 * The product's attributes (if it's a variation).
	 *
	 * @var int
	 */
	private $attributes;

	/**
	 * Get menu & submenu.
	 */
	public function ajax() {

		$nonce = isset( $_POST['nonce'] ) ? sanitize_text_field( $_POST['nonce'] ) : '';

		if ( ! wp_verify_nonce( $nonce, 'uquickview_add_to_cart' ) ) {
			wp_send_json_error( __( 'Invalid token', 'ultimate-quick-view-woocommerce' ), 401 );
		}

		if ( ! isset( $_POST['product_id'] ) || ! $_POST['product_id'] ) {
			wp_send_json_error( __( 'Product id is required', 'ultimate-quick-view-woocommerce' ), 401 );
		}

		$this->product_id = absint( $_POST['product_id'] );

		if ( ! get_post( $this->product_id ) ) {
			wp_send_json_error( __( "Product doesn't exist", 'ultimate-quick-view-woocommerce' ), 401 );
		}

		$this->quantity     = absint( $_POST['quantity'] );
		$this->is_variation = isset( $_POST['is_variation'] ) ? absint( $_POST['is_variation'] ) : 0;
		$this->attributes   = isset( $_POST['attributes'] ) ? $_POST['attributes'] : array();

		foreach ( $this->attributes as $attribute_key => $attribute_value ) {
			$this->attributes[ $attribute_key ] = sanitize_text_field( $attribute_value );
		}

		$this->save();

	}

	/**
	 * Add to cart.
	 */
	public function save() {

		try {

			$response = array(
				'message'    => __( 'Product has been added to cart', 'ultimate-quick-view-woocommerce' ),
				'product_id' => $this->product_id,
				'quantity'   => $this->quantity,
			);

			if ( $this->is_variation ) {

				$variation_id = $this->find_matching_product_variation_id( $this->product_id, $this->attributes );

				$response['attributes']   = $this->attributes;
				$response['variation_id'] = $variation_id;

				WC()->cart->add_to_cart( $this->product_id, $this->quantity, $variation_id, $this->attributes );

			} else {

				WC()->cart->add_to_cart( $this->product_id, $this->quantity );

			}

			wp_send_json_success( $response );
		} catch ( \Exception $e ) {
			wp_send_json_error( __( 'Something went wrong', 'ultimate-quick-view-woocommerce' ), 500 );
		}

	}

	/**
	 * Find matching product variation.
	 *
	 * @param int   $product_id The product ID.
	 * @param array $attributes The attributes.
	 *
	 * @return int Matching variation ID or 0.
	 */
	public function find_matching_product_variation_id( $product_id, $attributes ) {

		return ( new WC_Product_Data_Store_CPT() )->find_matching_product_variation(
			new WC_Product( $product_id ),
			$attributes
		);

	}

}
