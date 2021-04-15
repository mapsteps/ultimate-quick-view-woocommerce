<?php
/**
 * Base module output.
 *
 * @package Woocommerce_Quick_View
 */

namespace Wooquickview\Base;

defined( 'ABSPATH' ) || die( "Can't access directly" );

use Wooquickview\Helpers\Array_Helper;

/**
 * Class to setup base output.
 */
class Base_Output {
	/**
	 * Array helper.
	 *
	 * @return object Instance of array helper.
	 */
	public function array() {

		return new Array_Helper();

	}
}
