<?php
/**
 * Plugin Name: Quick View Ultimate for Woocommerce
 * Plugin URI: https://woocommercequickview.com
 * Description: A neat & clean Quick View plugin for WooCommerce.
 * Version: 1.0
 * Author: David Vongries
 * Author URI: https://mapsteps.com
 * Text Domain: woocommerce-quick-view
 *
 * @package Woocommerce_Quick_View
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );

// Plugin constants.
define( 'QUICK_VIEW_ULTIMATE_PLUGIN_DIR', rtrim( plugin_dir_path( __FILE__ ), '/' ) );
define( 'QUICK_VIEW_ULTIMATE_PLUGIN_URL', rtrim( plugin_dir_url( __FILE__ ), '/' ) );
define( 'QUICK_VIEW_ULTIMATE_PLUGIN_VERSION', '1.0' );

// Helper classes.
require __DIR__ . '/helpers/class-array-helper.php';
require __DIR__ . '/helpers/class-screen-helper.php';

// Base module.
require __DIR__ . '/modules/base/class-base-module.php';
require __DIR__ . '/modules/base/class-base-output.php';

// Core classes.
require __DIR__ . '/class-vars.php';
require __DIR__ . '/class-setup.php';

Wooquickview\Setup::init();
