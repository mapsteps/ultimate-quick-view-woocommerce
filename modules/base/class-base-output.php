<?php
/**
 * Base module output.
 *
 * @package Ultimate_Quick_View
 */

namespace Ultimatequickview\Base;

defined( 'ABSPATH' ) || die( "Can't access directly" );

use Ultimatequickview\Vars;
use Ultimatequickview\Helpers\Array_Helper;

/**
 * Class to setup base output.
 */
class Base_Output {
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
}
