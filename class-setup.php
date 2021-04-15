<?php
/**
 * Setup Woocommerce Quick View plugin.
 *
 * @package Woocommerce_Quick_View
 */

namespace Wooquickview;

defined( 'ABSPATH' ) || die( "Can't access directly" );

/**
 * Class to setup Woocommerce Quick View plugin.
 */
class Setup {
	/**
	 * Init the class setup.
	 */
	public static function init() {

		$instance = new Setup();

		add_action( 'plugins_loaded', array( $instance, 'setup' ) );

	}

	/**
	 * Setup the class.
	 */
	public function setup() {

		// This plugin depends on Woocommerce, so let's check if it's active.
		if ( ! class_exists( 'WooCommerce' ) ) {

			// Stop if Woocommerce is not installed or not active.
			return;

		}

		$this->load_modules();

		register_deactivation_hook( plugin_basename( __FILE__ ), array( $this, 'deactivation' ), 20 );

	}

	/**
	 * Load Woocommerce Quick View modules.
	 */
	public function load_modules() {

		$modules['Wooquickview\\QuickView\\Quick_View_Module'] = __DIR__ . '/modules/quick-view/class-quick-view-module.php';

		$modules = apply_filters( 'wooquickview_modules', $modules );

		foreach ( $modules as $class => $file ) {
			$splits      = explode( '/', $file );
			$module_name = $splits[ count( $splits ) - 2 ];
			$filter_name = str_ireplace( '-', '_', $module_name );
			$filter_name = 'wooquickview_' . $filter_name;

			// We have a filter here wooquickview_$module_name to allow us to prevent loading modules under certain circumstances.
			if ( apply_filters( $filter_name, true ) ) {

				require_once $file;
				$module = new $class();
				$module->setup();

			}
		}

	}
}
