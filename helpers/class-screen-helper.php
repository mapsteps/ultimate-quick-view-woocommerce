<?php
/**
 * Screen helper.
 *
 * @package Ultimate_Woo_Quick_View
 */

namespace Uwquickview\Helpers;

defined( 'ABSPATH' ) || die( "Can't access directly" );

/**
 * Class to setup screen helper.
 */
class Screen_Helper {
	/**
	 * Check if current screen is quick view settings page.
	 *
	 * @return boolean
	 */
	public function is_quick_view() {

		$current_screen = get_current_screen();
		return ( 'woocommerce_page_uwquickview_settings' === $current_screen->id ? true : false );

	}
}
