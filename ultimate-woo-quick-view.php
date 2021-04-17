<?php
/**
 * Plugin Name: Ultimate Quick View for WooCommerce
 * Plugin URI: https://woocommercequickview.com
 * Description: A neat & clean Quick View plugin for WooCommerce.
 * Version: 1.0
 * Author: David Vongries
 * Author URI: https://mapsteps.com
 * Text Domain: ultimate-woo-quick-view
 *
 * @package Ultimate_Woo_Quick_View
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );

// Plugin constants.
define( 'ULTIMATE_WOO_QUICK_VIEW_PLUGIN_DIR', rtrim( plugin_dir_path( __FILE__ ), '/' ) );
define( 'ULTIMATE_WOO_QUICK_VIEW_PLUGIN_FILE', rtrim( ULTIMATE_WOO_QUICK_VIEW_PLUGIN_DIR . '/ultimate-woo-quick-view.php' ) );
define( 'ULTIMATE_WOO_QUICK_VIEW_PLUGIN_URL', rtrim( plugin_dir_url( __FILE__ ), '/' ) );
define( 'ULTIMATE_WOO_QUICK_VIEW_PLUGIN_VERSION', '1.0' );

// Helper classes.
require __DIR__ . '/helpers/class-array-helper.php';
require __DIR__ . '/helpers/class-screen-helper.php';

// Base module.
require __DIR__ . '/modules/base/class-base-module.php';
require __DIR__ . '/modules/base/class-base-output.php';

// Core classes.
require __DIR__ . '/class-vars.php';
require __DIR__ . '/class-setup.php';

Uwquickview\Setup::init();
