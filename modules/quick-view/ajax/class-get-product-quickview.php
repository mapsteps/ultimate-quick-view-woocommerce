<?php
/**
 * Get product output for quick view.
 *
 * @package Ultimate_Woo_Quick_View
 */

namespace Uwquickview\QuickView\Ajax;

defined( 'ABSPATH' ) || die( "Can't access directly" );

/**
 * Class to get menu & submenu.
 */
class Get_Product_Quickview {

	/**
	 * Targetted product id.
	 *
	 * @var int
	 */
	private $product_id;

	/**
	 * Get menu & submenu.
	 */
	public function ajax() {

		$nonce = isset( $_GET['nonce'] ) ? sanitize_text_field( $_GET['nonce'] ) : '';

		if ( ! wp_verify_nonce( $nonce, 'uwquickview_get_product_quickview' ) ) {
			wp_send_json_error( __( 'Invalid token', 'ultimate-woo-quick-view' ), 401 );
		}

		if ( ! isset( $_GET['product_id'] ) || ! $_GET['product_id'] ) {
			wp_send_json_error( __( 'Product id is required', 'ultimate-woo-quick-view' ), 401 );
		}

		$this->product_id = absint( $_GET['product_id'] );

		if ( ! get_post( $this->product_id ) ) {
			wp_send_json_error( __( "Product doesn't exist", 'ultimate-woo-quick-view' ), 401 );
		}

		$this->get_output();

	}

	/**
	 * Manually load menu & submenu.
	 */
	public function get_output() {

		// Set the main wp query for the product.
		wp( 'p=' . $this->product_id . '&post_type=product' );

		// Remove product thumbnails gallery.
		remove_action( 'woocommerce_product_thumbnails', 'woocommerce_show_product_thumbnails', 20 );

		ob_start();

		while ( have_posts() ) :
			the_post();
			?>

			<div class="product">
				<div id="product-<?php the_ID(); ?>" <?php post_class( 'product' ); ?>>
					<?php do_action( 'uwquickview_product_image' ); ?>
					<div class="summary entry-summary">
						<div class="summary-content">
							<?php do_action( 'uwquickview_product_summary' ); ?>
						</div>
					</div>
				</div>
			</div>

			<?php
		endwhile;

		$output = ob_get_clean();

		wp_send_json_success( $output );

	}

}
