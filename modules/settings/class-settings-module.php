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

		wp_enqueue_style( 'heatbox', ULTIMATE_WOO_QUICK_VIEW_PLUGIN_URL . '/assets/css/heatbox.css', array(), ULTIMATE_WOO_QUICK_VIEW_PLUGIN_VERSION );
		wp_enqueue_style( 'wooquickview-admin', ULTIMATE_WOO_QUICK_VIEW_PLUGIN_URL . '/assets/css/admin.css', array(), ULTIMATE_WOO_QUICK_VIEW_PLUGIN_VERSION );

	}

	/**
	 * Enqueue admin scripts.
	 */
	public function admin_scripts() {

		if ( ! $this->screen()->is_quick_view() ) {
			return;
		}

		wp_enqueue_script( 'wooquickview-admin', ULTIMATE_WOO_QUICK_VIEW_PLUGIN_URL . '/assets/js/admin.js', array(), ULTIMATE_WOO_QUICK_VIEW_PLUGIN_VERSION, true );

	}

	/**
	 * Add settings.
	 */
	public function add_settings() {

		// Register setting.
		register_setting( 'wooquickview-settings-group', 'uwquickview_settings' );

		// General section.
		add_settings_section( 'wooquickview-general-section', __( 'General', 'ultimate-woo-quick-view' ), '', 'wooquickview-general-settings' );
		add_settings_section( 'wooquickview-misc-section', __( 'Misc.', 'ultimate-woo-quick-view' ), '', 'wooquickview-misc-settings' );

		// General fields.
		add_settings_field( 'some-setting', __( 'Some Setting', 'ultimate-woo-quick-view' ), array( $this, 'some_setting_field' ), 'wooquickview-general-settings', 'wooquickview-general-section' );

		// Misc fields.
		add_settings_field( 'remove-all-settings', __( 'Remove Data on Uninstall', 'ultimate-woo-quick-view' ), array( $this, 'remove_on_uninstall_field' ), 'wooquickview-misc-settings', 'wooquickview-misc-section' );

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
