<?php
/**
 * Add to cart from quick view mode.
 *
 * @package Ultimate_Quick_View
 */

namespace Ultimatequickview\QuickView\Ajax;

defined( 'ABSPATH' ) || die( "Can't access directly" );

/**
 * Class to setup ajax add to cart.
 */
class Add_To_Cart {	

	/**
	 * Handling the ajax add to cart.
	 *
	 * @see wp-content/plugins/woocommerce/includes/class-wc-form-handler.php
	 */
	public function ajax() {

		$quikview_settings         = get_option( 'uquickview_settings' );
		$woo_should_redirect       = get_option( 'woocommerce_cart_redirect_after_add' );
		$quickview_should_redirect = isset( $quikview_settings['woocommerce_cart_redirect_after_add'] ) ? true : false;

		// If product was successfully added to cart.
		if ( wc_notice_count( 'success' ) > 0 ) {
			$notices = wc_get_notices( 'success' );

			// If we're not going to redirect, then clear all wc notices.
			if ( 'yes' !== $woo_should_redirect || ! $quickview_should_redirect ) {
				wc_clear_notices();
			}

			wp_send_json_success( $notices );
		} else {
			$notice_notices = wc_get_notices( 'notice' );
			$error_notices  = wc_get_notices( 'error' );
			$notices        = array_merge( $error_notices, $error_notices );

			// If we're not going to redirect, then clear all wc notices.
			if ( 'yes' !== $woo_should_redirect || ! $quickview_should_redirect ) {
				wc_clear_notices();
			}

			wp_send_json_error( $notices, 401 );
		}

	}

}
