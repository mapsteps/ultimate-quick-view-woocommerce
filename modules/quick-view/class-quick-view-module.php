<?php
/**
 * Quick view module setup.
 *
 * @package Woocommerce_Quick_View
 */

namespace Wooquickview\QuickView;

defined( 'ABSPATH' ) || die( "Can't access directly" );

use Wooquickview\Base\Base_Module;

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

		$this->url = WOOCOMMERCE_QUICK_VIEW_PLUGIN_URL . '/modules/quick-view';

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

		add_action( 'admin_menu', array( self::get_instance(), 'submenu_page' ), 20 );
		add_action( 'admin_init', array( self::get_instance(), 'add_settings' ) );

		add_action( 'admin_enqueue_scripts', array( self::get_instance(), 'admin_styles' ) );
		add_action( 'admin_enqueue_scripts', array( self::get_instance(), 'admin_scripts' ) );

		add_action( 'wp_enqueue_scripts', array( self::get_instance(), 'frontend_styles' ) );
		add_action( 'wp_enqueue_scripts', array( self::get_instance(), 'frontend_scripts' ) );

		$this->setup_ajax();

		// The module output.
		require_once __DIR__ . '/class-quick-view-output.php';
		Quick_View_Output::init();

	}

	/**
	 * Add submenu page.
	 */
	public function submenu_page() {

		add_submenu_page( 'woocommerce', __( 'Quick View', 'woocommerce-quick-view' ), __( 'Quick View', 'woocommerce-quick-view' ), apply_filters( 'wooquickview_settings_capability', 'manage_options' ), 'wooquickview_settings', array( $this, 'submenu_page_content' ) );

	}

	/**
	 * Submenu page content.
	 */
	public function submenu_page_content() {

		$template = require __DIR__ . '/templates/settings-template.php';
		$template();

	}

	/**
	 * Enqueue admin styles.
	 */
	public function admin_styles() {

		if ( ! $this->screen()->is_quick_view() ) {
			return;
		}

		wp_enqueue_style( 'heatbox', WOOCOMMERCE_QUICK_VIEW_PLUGIN_URL . '/assets/css/heatbox.css', array(), WOOCOMMERCE_QUICK_VIEW_PLUGIN_VERSION );
		wp_enqueue_style( 'wooquickview-admin', WOOCOMMERCE_QUICK_VIEW_PLUGIN_URL . '/assets/css/admin.css', array(), WOOCOMMERCE_QUICK_VIEW_PLUGIN_VERSION );
		wp_enqueue_style( 'wooquickview-quick-view', $this->url . '/assets/css/quick-view.css', array( 'wooquickview-admin' ), WOOCOMMERCE_QUICK_VIEW_PLUGIN_VERSION );

	}

	/**
	 * Setup ajax.
	 */
	public function setup_ajax() {

		require_once __DIR__ . '/ajax/class-get-product-quickview.php';
		require_once __DIR__ . '/ajax/class-add-to-cart.php';

		$get_quickview = new Ajax\Get_Product_Quickview();
		$add_to_cart   = new Ajax\Add_To_Cart();

		add_action( 'wp_ajax_wooquickview_get_product_quickview', array( $get_quickview, 'ajax' ) );
		add_action( 'wp_ajax_nopriv_wooquickview_get_product_quickview', array( $get_quickview, 'ajax' ) );

		add_action( 'wp_ajax_add_to_cart', array( $add_to_cart, 'ajax' ) );
		add_action( 'wp_ajax_nopriv_add_to_cart', array( $add_to_cart, 'ajax' ) );

	}

	/**
	 * Enqueue admin scripts.
	 */
	public function admin_scripts() {

		if ( ! $this->screen()->is_quick_view() ) {
			return;
		}

		wp_enqueue_script( 'wooquickview-quick-view', $this->url . '/assets/js/quick-view.js', array(), WOOCOMMERCE_QUICK_VIEW_PLUGIN_VERSION, true );

	}

	/**
	 * Enqueue frontend styles.
	 */
	public function frontend_styles() {

		wp_enqueue_style( 'wooquickview-quick-view', $this->url . '/assets/css/quick-view.css', array(), WOOCOMMERCE_QUICK_VIEW_PLUGIN_VERSION );

	}

	/**
	 * Enqueue frontend scripts.
	 */
	public function frontend_scripts() {

		wp_enqueue_script( 'wooquickview-quick-view', $this->url . '/assets/js/quick-view.js', array( 'jquery' ), WOOCOMMERCE_QUICK_VIEW_PLUGIN_VERSION, true );

		wp_localize_script(
			'wooquickview-quick-view',
			'wooquickviewObj',
			array(
				'loader'  => WOOCOMMERCE_QUICK_VIEW_PLUGIN_URL . '/assets/images/loader.gif',
				'ajaxurl' => admin_url( 'admin-ajax.php' ),
				'nonces'  => array(
					'getQuickview' => wp_create_nonce( 'wooquickview_get_product_quickview' ),
					'addToCart'    => wp_create_nonce( 'wooquickview_add_to_cart' ),
				),
			)
		);

	}

	/**
	 * Add settings.
	 */
	public function add_settings() {

		// Register setting.
		register_setting( 'wooquickview-settings-group', 'wooquickview_settings' );

		// General section.
		add_settings_section( 'wooquickview-general-section', __( 'General', 'woocommerce-quick-view' ), '', 'wooquickview-general-settings' );
		add_settings_section( 'wooquickview-misc-section', __( 'Misc.', 'woocommerce-quick-view' ), '', 'wooquickview-misc-settings' );

		// General fields.
		add_settings_field( 'some-setting', __( 'Some Setting', 'woocommerce-quick-view' ), array( $this, 'some_setting_field' ), 'wooquickview-general-settings', 'wooquickview-general-section' );

		// Misc fields.
		add_settings_field( 'remove-all-settings', __( 'Remove Data on Uninstall', 'woocommerce-quick-view' ), array( $this, 'remove_on_uninstall_field' ), 'wooquickview-misc-settings', 'wooquickview-misc-section' );

	}

	/**
	 * Some setting field.
	 */
	public function some_setting_field() {

		$field = require __DIR__ . '/templates/fields/some-setting.php';
		$field();

	}

	/**
	 * Remove settings on uninstall field.
	 */
	public function remove_on_uninstall_field() {

		$field = require __DIR__ . '/templates/fields/remove-on-uninstall.php';
		$field();

	}

}
