<?php
/**
 * Quick view module setup.
 *
 * @package Ultimate_Quick_View
 */

namespace Ultimatequickview\Settings;

defined( 'ABSPATH' ) || die( "Can't access directly" );

use Ultimatequickview\Vars;
use Ultimatequickview\Base\Base_Module;

/**
 * Class to setup quick view module.
 */
class Settings_Module extends Base_Module {

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

		$this->url = ULTIMATE_QUICK_VIEW_PLUGIN_URL . '/modules/settings';

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

		// The module output.
		require_once __DIR__ . '/class-settings-output.php';
		Settings_Output::init();

	}

	/**
	 * Add submenu page.
	 */
	public function submenu_page() {

		add_submenu_page( 'woocommerce', __( 'Quick View', 'ultimate-quick-view-woocommerce' ), __( 'Quick View', 'ultimate-quick-view-woocommerce' ), apply_filters( 'uquickview_settings_capability', 'manage_options' ), 'uquickview_settings', array( $this, 'submenu_page_content' ) );

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

		wp_enqueue_style( 'wp-color-picker' );
		wp_enqueue_style( 'heatbox', ULTIMATE_QUICK_VIEW_PLUGIN_URL . '/assets/css/heatbox.css', array(), ULTIMATE_QUICK_VIEW_PLUGIN_VERSION );
		wp_enqueue_style( 'uquickview-admin', ULTIMATE_QUICK_VIEW_PLUGIN_URL . '/assets/css/admin.css', array(), ULTIMATE_QUICK_VIEW_PLUGIN_VERSION );

	}

	/**
	 * Enqueue admin scripts.
	 */
	public function admin_scripts() {

		if ( ! $this->screen()->is_quick_view() ) {
			return;
		}

		wp_register_script( 'wp-color-picker-alpha', ULTIMATE_QUICK_VIEW_PLUGIN_URL . '/assets/js/wp-color-picker-alpha.min.js', array( 'wp-color-picker' ), '3.0.0', true );
		wp_add_inline_script(
			'wp-color-picker-alpha',
			'jQuery( function() { jQuery( ".color-picker" ).wpColorPicker(); } );'
		);
		wp_enqueue_script( 'wp-color-picker-alpha' );

		wp_enqueue_script( 'mapsteps-polyfills', ULTIMATE_QUICK_VIEW_PLUGIN_URL . '/assets/js/polyfills.js', array(), ULTIMATE_QUICK_VIEW_PLUGIN_VERSION, true );
		wp_enqueue_script( 'uquickview-admin', ULTIMATE_QUICK_VIEW_PLUGIN_URL . '/assets/js/admin.js', array( 'jquery', 'wp-color-picker-alpha', 'mapsteps-polyfills' ), ULTIMATE_QUICK_VIEW_PLUGIN_VERSION, true );
		wp_enqueue_script( 'uquickview-settings', $this->url . '/assets/js/settings.js', array( 'uquickview-admin' ), ULTIMATE_QUICK_VIEW_PLUGIN_VERSION, true );

	}

	/**
	 * Add settings.
	 */
	public function add_settings() {

		// Register settings.
		register_setting( 'uquickview-settings-group', 'uquickview_settings' );

		// Register sections.
		add_settings_section( 'uquickview-general-section', __( 'General Settings', 'ultimate-quick-view-woocommerce' ), '', 'uquickview-general-settings' );
		add_settings_section( 'uquickview-button-section', __( 'Quick View Button Settings', 'ultimate-quick-view-woocommerce' ), '', 'uquickview-button-settings' );
		add_settings_section( 'uquickview-popup-section', __( 'Popup Settings', 'ultimate-quick-view-woocommerce' ), '', 'uquickview-popup-settings' );
		add_settings_section( 'uquickview-custom-section', __( 'Custom Settings', 'ultimate-quick-view-woocommerce' ), '', 'uquickview-custom-settings' );

		// General fields.
		add_settings_field( 'disable', __( 'Disable Quick View', 'ultimate-quick-view-woocommerce' ), array( $this, 'disable_field' ), 'uquickview-general-settings', 'uquickview-general-section' );
		add_settings_field( 'disable-on-mobile', __( 'Disable Only on Mobile', 'ultimate-quick-view-woocommerce' ), array( $this, 'disable_on_mobile_field' ), 'uquickview-general-settings', 'uquickview-general-section' );
		add_settings_field( 'remove-all-settings', __( 'Remove Data on Uninstall', 'ultimate-quick-view-woocommerce' ), array( $this, 'remove_on_uninstall_field' ), 'uquickview-general-settings', 'uquickview-general-section' );

		// Button fields.
		add_settings_field( 'button-position', __( 'Button Position', 'ultimate-quick-view-woocommerce' ), array( $this, 'button_position_field' ), 'uquickview-button-settings', 'uquickview-button-section' );
		add_settings_field( 'button-text', __( 'Button Text', 'ultimate-quick-view-woocommerce' ), array( $this, 'button_text_field' ), 'uquickview-button-settings', 'uquickview-button-section' );
		add_settings_field( 'button-colors', __( 'Button Colors', 'ultimate-quick-view-woocommerce' ), array( $this, 'button_colors_field' ), 'uquickview-button-settings', 'uquickview-button-section' );
	}

	/**
	 * Some setting field.
	 */
	public function disable_field() {

		$field = require __DIR__ . '/templates/fields/disable.php';
		$field( $this );

	}

	/**
	 * Some setting field.
	 */
	public function disable_on_mobile_field() {

		$field = require __DIR__ . '/templates/fields/disable-on-mobile.php';
		$field( $this );

	}

	/**
	 * Remove data on uninstall field.
	 */
	public function remove_on_uninstall_field() {

		$field = require __DIR__ . '/templates/fields/remove-on-uninstall.php';
		$field();

	}

	/**
	 * Button position field.
	 */
	public function button_position_field() {

		$field = require __DIR__ . '/templates/fields/button-position.php';
		$field();

	}

	/**
	 * Button text field.
	 */
	public function button_text_field() {

		$field = require __DIR__ . '/templates/fields/button-text.php';
		$field( $this );

	}

	/**
	 * Button color field.
	 */
	public function button_colors_field() {

		$field = require __DIR__ . '/templates/fields/button-colors.php';
		$field( $this );

	}

}
