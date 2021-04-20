<?php
/**
 * Setup Ultimate Quick View plugin.
 *
 * @package Ultimate_Quick_View
 */

namespace Ultimatequickview;

defined( 'ABSPATH' ) || die( "Can't access directly" );

use Ultimatequickview\Vars;

/**
 * Class to setup Ultimate Quick View plugin.
 */
class Setup {
	/**
	 * Init the class setup.
	 */
	public static function init() {

		$class = new Setup();

		add_action( 'plugins_loaded', array( $class, 'setup' ) );

	}

	/**
	 * Setup the class.
	 */
	public function setup() {

		// This plugin depends on WooCommerce, so let's check if it's active.
		if ( ! class_exists( 'WooCommerce' ) ) {

			// Stop if WooCommerce is not installed or not active.
			return;

		}

		$this->set_data();

		add_filter( 'plugin_action_links_' . plugin_basename( ULTIMATE_QUICK_VIEW_PLUGIN_FILE ), array( $this, 'plugin_action_links' ) );
		add_filter( 'admin_body_class', array( $this, 'admin_body_class' ) );

		$this->load_modules();

		register_deactivation_hook( plugin_basename( ULTIMATE_QUICK_VIEW_PLUGIN_FILE ), array( $this, 'deactivation' ), 20 );

	}

	/**
	 * Provide data for the plugin.
	 * This is optimal strategy to only get_option once across modules.
	 */
	public function set_data() {

		$defaults = array(
			'button_text'              => __( 'Quick View', 'ultimate-quick-view-woocommerce' ),
			'button_text_color'        => '',
			'button_text_accent_color' => '',
			'button_bg_color'          => '',
			'button_bg_accent_color'   => '',
		);
		$settings = get_option( 'uquickview_settings', array() );
		$values   = wp_parse_args( $settings, $defaults );

		Vars::set( 'default_settings', $defaults );
		Vars::set( 'settings', $settings );
		Vars::set( 'values', $values );

	}

	/**
	 * Add action links displayed in plugins page.
	 *
	 * @param array $links The action links array.
	 * @return array The modified action links array.
	 */
	public function plugin_action_links( $links ) {

		$settings = array( '<a href="' . admin_url( 'admin.php?page=uquickview_settings' ) . '">' . __( 'Settings', 'ultimate-quick-view-woocommerce' ) . '</a>' );

		return array_merge( $settings, $links );

	}

	/**
	 * Admin body class.
	 *
	 * @param string $classes The existing body classes.
	 * @return string The body classes.
	 */
	public function admin_body_class( $classes ) {

		$screens = array(
			'woocommerce_page_uquickview_settings',
		);

		$screen = get_current_screen();

		if ( ! in_array( $screen->id, $screens, true ) ) {
			return $classes;
		}

		$classes .= ' heatbox-admin has-header';

		return $classes;

	}

	/**
	 * Load Woocommerce Quick View modules.
	 */
	public function load_modules() {

		$modules = array();

		$modules['Ultimatequickview\\QuickView\\Quick_View_Module'] = __DIR__ . '/modules/quick-view/class-quick-view-module.php';
		$modules['Ultimatequickview\\Settings\\Settings_Module']    = __DIR__ . '/modules/settings/class-settings-module.php';

		$modules = apply_filters( 'uquickview_modules', $modules );

		foreach ( $modules as $class => $file ) {
			$splits      = explode( '/', $file );
			$module_name = $splits[ count( $splits ) - 2 ];
			$filter_name = str_ireplace( '-', '_', $module_name );
			$filter_name = 'uquickview_' . $filter_name;

			// We have a filter here uquickview_$module_name to allow us to prevent loading modules under certain circumstances.
			if ( apply_filters( $filter_name, true ) ) {

				require_once $file;
				$module = new $class();
				$module->setup();

			}
		}

	}

	/**
	 * Plugin deactivation.
	 */
	public function deactivation() {

		$settings = get_option( 'uquickview_settings' );

		$remove_on_uninstall = isset( $settings['remove_on_uninstall'] ) ? true : false;
		$remove_on_uninstall = apply_filters( 'uquickview_clean_uninstall', $remove_on_uninstall );

		if ( $remove_on_uninstall ) {

			delete_option( 'uquickview_settings' );

		}

	}
}
