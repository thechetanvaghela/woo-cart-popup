<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://chetanvaghela.cf/
 * @since      1.0.0
 *
 * @package    Woo_Cart_Popup
 * @subpackage Woo_Cart_Popup/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Woo_Cart_Popup
 * @subpackage Woo_Cart_Popup/admin
 * @author     Chetan Vaghela <ckvaghela92@gmail.com>
 */
class Woo_Cart_Popup_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name; 

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name ="", $version="" ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		$this->load_required_files();
	}

	/**
	 * Load the required dependencies files for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - ChatAdmin_class. create admin menu page of the plugin.
	 * - ChatMessage_List. Defines WP_List_Table functionality.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_required_files() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-woo-cart-setting.php';

	}

	/**
	*	wcp_detect_plugin_deactivation
	*   deactivate plugin if woocommerce being deactivate
	*/
	/*public function wcp_detect_plugin_deactivation( $plugin, $network_activation ) {
	    if ($plugin=="woocommerce/woocommerce.php")
	    {
	        deactivate_plugins("woo-cart-popup/woo-cart-popup.php");

	    }
	}*/

	/**
	*  wcp_wc_requirement_notice
	*  Display Woocommerce plugin requre notice
	*/
	public function wcp_wc_requirement_notice() {
				
		if ( ! $this->is_wc_active() ) {
			
			$class = 'notice notice-error';
			
			$text    = esc_html__( 'WooCommerce', 'woo-cart-popup' );
			$link    = esc_url( add_query_arg( array(
				                                   'tab'       => 'plugin-information',
				                                   'plugin'    => 'woocommerce',
				                                   'TB_iframe' => 'true',
				                                   'width'     => '640',
				                                   'height'    => '500',
			                                   ), admin_url( 'plugin-install.php' ) ) );
			$message = wp_kses( __( "<strong>Woo Cart Popup</strong> requires WooCommerce to be installed and active. Please Install/Active ", 'woo-cart-popup' ), array( 'strong' => array() ) );
			
			printf( '<div class="%1$s"><p>%2$s <a class="thickbox open-plugin-details-modal" href="%3$s"><strong>%4$s</strong></a></p></div>', $class, $message, $link, $text );
		}
	}

	/**
	*  is_wc_active
	*  check Woocommerce plugin is active or not
	*/
	public function is_wc_active() {
		return class_exists( 'WooCommerce' );
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Woo_Cart_Popup_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Woo_Cart_Popup_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/woo-cart-popup-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Woo_Cart_Popup_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Woo_Cart_Popup_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/woo-cart-popup-admin.js', array( 'jquery' ), $this->version, false );

	}

}
new Woo_Cart_Popup_Admin;