<?php
/**
 * Quick view module output.
 *
 * @package Woocommerce_Quick_View
 */

namespace Wooquickview\QuickView;

defined( 'ABSPATH' ) || die( "Can't access directly" );

use Wooquickview\Base\Base_Output;

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

		$this->url = WOOCOMMERCE_QUICK_VIEW_PLUGIN_URL . '/modules/feature';

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
	 * Setup dashboard output.
	 */
	public function setup() {

		add_action( 'wooquickview_view_product_image', 'woocommerce_show_product_images' );
		add_action( 'wooquickview_product_summary', 'woocommerce_template_single_title' );

	}

}
