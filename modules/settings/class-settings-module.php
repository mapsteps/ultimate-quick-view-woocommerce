<?php
/**
 * Quick view module setup.
 *
 * @package Ultimate_Woo_Quick_View
 */

namespace Uwquickview\Settings;

defined( 'ABSPATH' ) || die( "Can't access directly" );

use Uwquickview\Base\Base_Module;

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

		$this->url = ULTIMATE_WOO_QUICK_VIEW_PLUGIN_URL . '/modules/settings';

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

		add_submenu_page( 'woocommerce', __( 'Quick View', 'ultimate-woo-quick-view' ), __( 'Quick View', 'ultimate-woo-quick-view' ), apply_filters( 'uwquickview_settings_capability', 'manage_options' ), 'uwquickview_settings', array( $this, 'submenu_page_content' ) );

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
		wp_enqueue_style( 'heatbox', ULTIMATE_WOO_QUICK_VIEW_PLUGIN_URL . '/assets/css/heatbox.css', array(), ULTIMATE_WOO_QUICK_VIEW_PLUGIN_VERSION );
		wp_enqueue_style( 'uwquickview-admin', ULTIMATE_WOO_QUICK_VIEW_PLUGIN_URL . '/assets/css/admin.css', array(), ULTIMATE_WOO_QUICK_VIEW_PLUGIN_VERSION );

	}

	/**
	 * Enqueue admin scripts.
	 */
	public function admin_scripts() {

		if ( ! $this->screen()->is_quick_view() ) {
			return;
		}

		wp_register_script( 'wp-color-picker-alpha', ULTIMATE_WOO_QUICK_VIEW_PLUGIN_URL . '/assets/js/wp-color-picker-alpha.min.js', array( 'wp-color-picker' ), '3.0.0', true );
		wp_add_inline_script(
			'wp-color-picker-alpha',
			'jQuery( function() { jQuery( ".color-picker" ).wpColorPicker(); } );'
		);
		wp_enqueue_script( 'wp-color-picker-alpha' );

		wp_enqueue_script( 'mapsteps-polyfills', ULTIMATE_WOO_QUICK_VIEW_PLUGIN_URL . '/assets/js/polyfills.js', array(), ULTIMATE_WOO_QUICK_VIEW_PLUGIN_VERSION, true );
		wp_enqueue_script( 'uwquickview-admin', ULTIMATE_WOO_QUICK_VIEW_PLUGIN_URL . '/assets/js/admin.js', array( 'jquery', 'wp-color-picker-alpha', 'mapsteps-polyfills' ), ULTIMATE_WOO_QUICK_VIEW_PLUGIN_VERSION, true );
		wp_enqueue_script( 'uwquickview-settings', $this->url . '/assets/js/settings.js', array( 'uwquickview-admin' ), ULTIMATE_WOO_QUICK_VIEW_PLUGIN_VERSION, true );

	}

	/**
	 * Add settings.
	 */
	public function add_settings() {

		// Register settings.
		register_setting( 'uwquickview-settings-group', 'uwquickview_settings' );

		// Register sections.
		add_settings_section( 'uwquickview-general-section', __( 'General Settings', 'ultimate-woo-quick-view' ), '', 'uwquickview-general-settings' );
		add_settings_section( 'uwquickview-button-section', __( 'Quick View Button Settings', 'ultimate-woo-quick-view' ), '', 'uwquickview-button-settings' );
		add_settings_section( 'uwquickview-popup-section', __( 'Popup Settings', 'ultimate-woo-quick-view' ), '', 'uwquickview-popup-settings' );
		add_settings_section( 'uwquickview-custom-section', __( 'Custom Settings', 'ultimate-woo-quick-view' ), '', 'uwquickview-custom-settings' );

		// General fields.
		add_settings_field( 'disable', __( 'Disable Quick View', 'ultimate-woo-quick-view' ), array( $this, 'disable_field' ), 'uwquickview-general-settings', 'uwquickview-general-section' );
		add_settings_field( 'disable-on-mobile', __( 'Disable Only on Mobile', 'ultimate-woo-quick-view' ), array( $this, 'disable_on_mobile_field' ), 'uwquickview-general-settings', 'uwquickview-general-section' );
		add_settings_field( 'remove-all-settings', __( 'Remove Settings on Uninstall', 'ultimate-woo-quick-view' ), array( $this, 'remove_on_uninstall_field' ), 'uwquickview-general-settings', 'uwquickview-general-section' );

		// Button fields.
		add_settings_field( 'button-position', __( 'Button Position', 'ultimate-woo-quick-view' ), array( $this, 'button_position_field' ), 'uwquickview-button-settings', 'uwquickview-button-section' );
		add_settings_field( 'button-text', __( 'Button Text', 'ultimate-woo-quick-view' ), array( $this, 'button_text_field' ), 'uwquickview-button-settings', 'uwquickview-button-section' );
		add_settings_field( 'button-color-type', __( 'Button Color', 'ultimate-woo-quick-view' ), array( $this, 'button_color_type_field' ), 'uwquickview-button-settings', 'uwquickview-button-section' );
	}

	/**
	 * Some setting field.
	 */
	public function disable_field() {

		$field = require __DIR__ . '/templates/fields/disable.php';
		$field();

	}

	/**
	 * Some setting field.
	 */
	public function disable_on_mobile_field() {

		$field = require __DIR__ . '/templates/fields/disable-on-mobile.php';
		$field();

	}

	/**
	 * Remove settings on uninstall field.
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
		$field();

	}

	/**
	 * Button color type field.
	 */
	public function button_color_type_field() {

		$field = require __DIR__ . '/templates/fields/button-color-type.php';
		$field();

	}

}
