<?php
/**
 * Base module setup.
 *
 * @package Ultimate_Woo_Quick_View
 */

namespace Uwquickview\Base;

defined( 'ABSPATH' ) || die( "Can't access directly" );

use Uwquickview\Vars;
use Uwquickview\Helpers\Array_Helper;
use Uwquickview\Helpers\Screen_Helper;

/**
 * Class to setup base module.
 */
class Base_Module {
	/**
	 * The default settings.
	 *
	 * @var array
	 */
	public $defaults;

	/**
	 * The saved settings.
	 *
	 * @var array
	 */
	public $settings;

	/**
	 * The parsed settings values.
	 *
	 * @var array
	 */
	public $values;

	/**
	 * Module constructor.
	 */
	public function __construct() {

		$this->defaults = Vars::get( 'default_settings' );
		$this->settings = Vars::get( 'settings' );
		$this->values   = Vars::get( 'values' );

	}

	/**
	 * Array helper.
	 *
	 * @return object Instance of array helper.
	 */
	public function array() {

		return new Array_Helper();

	}

	/**
	 * Screen helper.
	 *
	 * @return object Instance of array helper.
	 */
	public function screen() {

		return new Screen_Helper();

	}
}
