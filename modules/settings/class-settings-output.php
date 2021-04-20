<?php
/**
 * Settings module output.
 *
 * @package Ultimate_Quick_View
 */

namespace Ultimatequickview\Settings;

defined( 'ABSPATH' ) || die( "Can't access directly" );

use Ultimatequickview\Base\Base_Output;

/**
 * Class to setup dashboard output.
 */
class Settings_Output extends Base_Output {

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

		// Work in progress.
	}

}
