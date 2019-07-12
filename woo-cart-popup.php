<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://chetanvaghela.cf/
 * @since             1.0.0
 * @package           Woo_Cart_Popup
 *
 * @wordpress-plugin
 * Plugin Name:       Woo Cart Popup
 * Plugin URI:        http://chetanvaghela.cf/blog/woo-cart-popup
 * Description:       Woo Cart Popup displays all added product items to cart in a popup.
 * Version:           1.0.0
 * Author:            Chetan Vaghela
 * Author URI:        https://chetanvaghela.cf/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       woo-cart-popup
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * plugin_dir_path
 */
define( 'WOO_CART_POPUP_VERSION', '1.0.0' );
define( 'WCP_PLUGIN_DIR', plugin_dir_path(__FILE__) );


/**
* deactivate plugin on deactivation of woocommerce
*/
add_action( 'deactivated_plugin','wcp_detect_plugin_deactivation',99,2 );
function wcp_detect_plugin_deactivation( $plugin, $network_activation ) {
    if ($plugin=="woocommerce/woocommerce.php")
    {
    	add_action('update_option_active_plugins', 'deactivate_wcp_plugin_itself');    
    }
}
function deactivate_wcp_plugin_itself(){
  	deactivate_plugins( plugin_basename( __FILE__ ) );
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-woo-cart-popup-activator.php
 */
function activate_woo_cart_popup() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-woo-cart-popup-activator.php';
	Woo_Cart_Popup_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-woo-cart-popup-deactivator.php
 */
function deactivate_woo_cart_popup() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-woo-cart-popup-deactivator.php';
	Woo_Cart_Popup_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_woo_cart_popup' );
register_deactivation_hook( __FILE__, 'deactivate_woo_cart_popup' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-woo-cart-popup.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_woo_cart_popup() {

	$plugin = new Woo_Cart_Popup();
	$plugin->run();

}
run_woo_cart_popup();