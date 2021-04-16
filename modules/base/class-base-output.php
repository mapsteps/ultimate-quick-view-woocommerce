<?php
/**
 * Base module output.
 *
 * @package Ultimate_Woo_Quick_View
 */

namespace Uwquickview\Base;

defined( 'ABSPATH' ) || die( "Can't access directly" );

use Uwquickview\Helpers\Array_Helper;

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
