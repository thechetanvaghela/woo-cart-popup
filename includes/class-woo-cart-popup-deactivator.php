<?php

/**
 * Fired during plugin deactivation
 *
 * @link       https://chetanvaghela.cf/
 * @since      1.0.0
 *
 * @package    Woo_Cart_Popup
 * @subpackage Woo_Cart_Popup/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    Woo_Cart_Popup
 * @subpackage Woo_Cart_Popup/includes
 * @author     Chetan Vaghela <ckvaghela92@gmail.com>
 */
class Woo_Cart_Popup_Deactivator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function deactivate() {
		add_action( 'admin_notices', array($this,'wcp_deactivation_notice') );
	}

	public function wcp_deactivation_notice() {
				
		$class = 'notice notice-error';
		
		$text    = esc_html__( 'WooCommerce', 'woo-cart-popup' );
		$link    = esc_url( add_query_arg( array(
			                                   'tab'       => 'plugin-information',
			                                   'plugin'    => 'woocommerce',
			                                   'TB_iframe' => 'true',
			                                   'width'     => '640',
			                                   'height'    => '500',
		                                   ), admin_url( 'plugin-install.php' ) ) );
		$message = wp_kses( __( "<strong>Woo Cart Popup</strong> plugin was deactivate due to deactivation of WooCommerce. Please Install/Active ", 'woo-cart-popup' ), array( 'strong' => array() ) );
		
		printf( '<div class="%1$s"><p>%2$s <a class="thickbox open-plugin-details-modal" href="%3$s"><strong>%4$s</strong></a></p></div>', $class, $message, $link, $text );
		
	}

}
