<?php
/**
 * Quick view module output.
 *
 * @package Ultimate_Quick_View
 */

namespace Ultimatequickview\QuickView;

defined( 'ABSPATH' ) || die( "Can't access directly" );

use Ultimatequickview\Base\Base_Output;

/**
 * Class to setup dashboard output.
 */
class Quick_View_Output extends Base_Output {

	/**
	 * The class instance.
	 *
	 * @var object
	 */
	public static $instance;

	/**
	 * The current module url.
	 *
	 * @var string
	 */
	public $url;

	/**
	 * Module constructor.
	 */
	public function __construct() {

		parent::__construct();

		$this->url = ULTIMATE_QUICK_VIEW_PLUGIN_URL . '/modules/feature';

	}

	/**
	 * Get instance of the class.
	 */
	public static function get_instance() {

		if ( null === self::$instance ) {
			self::$instance = new self();
		}

		return self::$instance;

	}

	/**
	 * Init the class setup.
	 */
	public static function init() {

		$class = new self();
		$class->setup();

	}

	/**
	 * Setup quick view output.
	 */
	public function setup() {

		$hook_name     = 'woocommerce_before_shop_loop_item_title';
		$hook_priority = 20;

		if ( isset( $this->settings['button_position'] ) ) {
			$button_position = $this->settings['button_position'];
			$exploded_values = explode( '_', $button_position );
			$last_partial    = end( $exploded_values );

			if ( is_numeric( $last_partial ) ) {
				$hook_name     = str_ireplace( '_' . $last_partial, '', $button_position );
				$hook_priority = absint( $last_partial );
			}
		}

		// Add quick view button.
		add_action( $hook_name, array( self::get_instance(), 'add_quick_view_button' ), $hook_priority );

		add_action( 'wp_head', array( self::get_instance(), 'print_styles' ), 20 );

		add_action( 'wp_footer', array( self::get_instance(), 'popup_output' ) );

		$this->build_quickview_content();

	}

	/**
	 * Add quick view button to products.
	 *
	 * @param int $product_id The product id.
	 */
	public function add_quick_view_button( $product_id = 0 ) {

		global $product;

		$product_id = $product->get_id();
		?>

		<!-- Start quick view button -->
		<button id="uquickview_product_id_<?php echo absint( $product_id ); ?>" class="button uquickview-button uquickview-view-button" data-product-id="<?php echo absint( $product_id ); ?>" aria-hidden="true">
			<?php
			echo esc_attr( apply_filters( 'uquickview_button_text', $this->values['button_text'] ) );
			?>
		</button>
		<!-- End of quick view button -->

		<?php

	}

	/**
	 * Print quick view styles.
	 */
	public function print_styles() {

		echo '<style>';
		ob_start();

		$css_output = require __DIR__ . '/inc/quick-view.css.php';
		$css_output( $this );

		$css = ob_get_clean();

		echo apply_filters( 'uquickview_styles', $css );
		echo '</style>';

	}

	/**
	 * Construct quick view popup.
	 */
	public function popup_output() {

		// Load necessary scripts.
		$this->enqueue_scripts();
		?>

		<div class="uquickview-popup">
			<span class="uquickview-close-popup"></span>

			<div class="uquickview-popup-content">
				<div id="uquickview-popup-product" class="woocommerce single-product"></div>
			</div>
		</div>

		<?php
	}

	/**
	 * Enqueue necessary styles & scripts.
	 */
	public function enqueue_scripts() {

		/**
		 * Enable Zoom for profuct image.
		 * Enable Auto Change Image for products with mutiple images, when product variation is selected.
		 */
		wp_enqueue_script( 'wc-add-to-cart-variation' );

		if ( version_compare( WC()->version, '3.0.0', '>=' ) ) {

			if ( current_theme_supports( 'wc-product-gallery-zoom' ) ) {
				wp_enqueue_script( 'zoom' );
			}

			if ( current_theme_supports( 'wc-product-gallery-lightbox' ) ) {

				wp_enqueue_script( 'photoswipe-ui-default' );
				wp_enqueue_style( 'photoswipe-default-skin' );

				if ( has_action( 'wp_footer', 'woocommerce_photoswipe' ) === false ) {
					add_action( 'wp_footer', 'woocommerce_photoswipe', 15 );
				}
			}

			wp_enqueue_script( 'wc-single-product' );

		}

	}

	/**
	 * Construct quick view content.
	 */
	public function build_quickview_content() {

		// Product's image.
		add_action( 'uquickview_product_image', 'woocommerce_show_product_images' );

		// Product's title.
		add_action( 'uquickview_product_summary', 'woocommerce_template_single_title' );

		// Product's rating.
		add_action( 'uquickview_product_summary', 'woocommerce_template_single_rating' );

		// Product's price.
		add_action( 'uquickview_product_summary', 'woocommerce_template_single_price' );

		// Product's excerpt.
		add_action( 'uquickview_product_summary', 'woocommerce_template_single_excerpt' );

		// Quantity & add to cart button.
		add_action( 'uquickview_product_summary', 'woocommerce_template_single_add_to_cart' );

		// Product's meta.
		add_action( 'uquickview_product_summary', 'woocommerce_template_single_meta' );

	}

}
