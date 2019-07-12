<?php

/**
 * Fired during plugin activation
 *
 * @link       https://chetanvaghela.cf/
 * @since      1.0.0
 *
 * @package    Woo_Cart_Popup
 * @subpackage Woo_Cart_Popup/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Woo_Cart_Popup
 * @subpackage Woo_Cart_Popup/includes
 * @author     Chetan Vaghela <ckvaghela92@gmail.com>
 */
class Woo_Cart_Popup_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	
	public static function activate() {

		if ( !in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
				
				// Deactivate the plugin
				deactivate_plugins(__FILE__);
				
				// Throw an error in the wordpress admin console
				$error_message = __('Woo Cart Popup plugin requires <a href="http://wordpress.org/extend/plugins/woocommerce/" target="_blank">WooCommerce</a> plugin to be active!', 'woo-cart-popup');
				die($error_message);
				
			}
	}

}
