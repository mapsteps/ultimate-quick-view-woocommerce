<?php
/**
 * Base module setup.
 *
 * @package Ultimate_Woo_Quick_View
 */

namespace Uwquickview\Base;

defined( 'ABSPATH' ) || die( "Can't access directly" );

use Uwquickview\Helpers\Array_Helper;
use Uwquickview\Helpers\Screen_Helper;

/**
 * Class to setup base module.
 */
class Base_Module {
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
