<?php
/**
 * Base module setup.
 *
 * @package Woocommerce_Quick_View
 */

namespace Wooquickview\Base;

defined( 'ABSPATH' ) || die( "Can't access directly" );

use Wooquickview\Helpers\Array_Helper;
use Wooquickview\Helpers\Screen_Helper;

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
