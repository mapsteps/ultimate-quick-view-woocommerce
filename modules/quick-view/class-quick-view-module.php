<?php
/**
 * Quick view module setup.
 *
 * @package Ultimate_Quick_View
 */

namespace Ultimatequickview\QuickView;

defined( 'ABSPATH' ) || die( "Can't access directly" );

use Ultimatequickview\Base\Base_Module;

/**
 * Class to setup quick view module.
 */
class Quick_View_Module extends Base_Module {

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

		$this->url = ULTIMATE_QUICK_VIEW_PLUGIN_URL . '/modules/quick-view';

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
	 * Setup tool module.
	 */
	public function setup() {

		$is_disabled = isset( $this->settings['disable'] ) ? true : false;

		if ( $is_disabled ) {
			return;
		}

		add_action( 'wp_enqueue_scripts', array( self::get_instance(), 'frontend_styles' ), 20 );
		add_action( 'wp_enqueue_scripts', array( self::get_instance(), 'frontend_scripts' ) );

		// Prevent redirection inside `uquickview_add_to_cart` ajax request.
		add_filter( 'wp_redirect', array( self::get_instance(), 'prevent_redirection' ), 20, 2 );

		$this->setup_ajax();

		// The module output.
		require_once __DIR__ . '/class-quick-view-output.php';
		Quick_View_Output::init();

	}

	/**
	 * Setup ajax.
	 */
	public function setup_ajax() {

		require_once __DIR__ . '/ajax/class-get-product-quickview.php';
		require_once __DIR__ . '/ajax/class-add-to-cart.php';

		$get_quickview = new Ajax\Get_Product_Quickview();
		$add_to_cart   = new Ajax\Add_To_Cart();

		add_action( 'wp_ajax_uquickview_get_product_quickview', array( $get_quickview, 'ajax' ) );
		add_action( 'wp_ajax_nopriv_uquickview_get_product_quickview', array( $get_quickview, 'ajax' ) );

		add_action( 'wp_ajax_uquickview_add_to_cart', array( $add_to_cart, 'ajax' ) );
		add_action( 'wp_ajax_nopriv_uquickview_add_to_cart', array( $add_to_cart, 'ajax' ) );

	}

	/**
	 * Prevent redirection inside `uquickview_add_to_cart` ajax request.
	 *
	 * @param string $location The existing redirection url.
	 * @param int    $status The redirection http status.
	 *
	 * @return string The modified redirection url.
	 */
	public function prevent_redirection( $location, $status ) {

		if ( ! wp_doing_ajax() || ! isset( $_POST['action'] ) || 'uquickview_add_to_cart' !== $_POST['action'] ) {
			return $location;
		}

		return false;

	}

	/**
	 * Enqueue frontend styles.
	 */
	public function frontend_styles() {

		wp_enqueue_style( 'uquickview-quick-view', $this->url . '/assets/css/quick-view.css', array(), ULTIMATE_QUICK_VIEW_PLUGIN_VERSION );

	}

	/**
	 * Enqueue frontend scripts.
	 */
	public function frontend_scripts() {

		wp_enqueue_script( 'uquickview-quick-view', $this->url . '/assets/js/quick-view.js', array( 'jquery' ), ULTIMATE_QUICK_VIEW_PLUGIN_VERSION, true );

		wp_add_inline_script(
			'uquickview-quick-view',
			'var uquickviewObj = {ajaxurl: "' . esc_url( admin_url( 'admin-ajax.php' ) ) . '", cart_redirect_after_add: ' . ( isset( $this->settings['cart_redirect_after_add'] ) ? 'true' : 'false' ) . '};',
			'before'
		);

	}

}
