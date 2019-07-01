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


		add_action( 'widgets_init', array($this,  'woo_cart_popup_widgets_init' ));
		add_action( 'admin_init', array($this,  'woo_cart_popup_insert_widget_in_sidebar' ));

		add_action( 'admin_notices', array( $this, 'wc_requirement_notice' ) );

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

		//require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-woo-cart-popup-widgets.php';

	}

	public function woo_cart_popup_widgets_init() {


			register_sidebar( array(
				'name'          => esc_html__( 'Woo Cart Popup', 'woocommerce' ),
				'id'            => 'sidebar-woo-cart-popup',
				'description'   => esc_html__( 'Add widgets here.', 'woocommerce' ),
				'before_widget' => '<section id="%1$s" class="widget %2$s">',
				'after_widget'  => '</section>',
				'before_title'  => '<h2 class="widget-title">',
				'after_title'   => '</h2>',
			) );
			/*$active_sidebars = get_option( 'sidebars_widgets' ); //get all sidebars and widgets
			$widget_options = get_option( 'woocommerce_widget_cart' );
			$widget_options[1] = array( 'option1' => 'value', 'option2' => 'value2' );
			if(isset($active_sidebars['sidebar-woo-cart-popup']) && empty($active_sidebars['sidebar-woo-cart-popup'])) { //check if sidebar exists and it is empty

			    $active_sidebars['sidebar-woo-cart-popup'] = array('woocommerce_widget_cart'); //add a widget to sidebar
			    update_option('woocommerce_widget_cart', $widget_options); //update widget default options
			    update_option('sidebars_widgets', $active_sidebars); //update sidebars
			}*/

	}

	function woo_cart_popup_insert_widget_in_sidebar() {
		// Retrieve sidebars, widgets and their instances
		$widget_id = "woocommerce_widget_cart";
		$sidebar = "sidebar-woo-cart-popup";
		$sidebars_widgets = get_option( 'sidebars_widgets', array() );
		$widget_instances = get_option( 'widget_' . $widget_id, array() );
		// Retrieve the key of the next widget instance
		$numeric_keys = array_filter( array_keys( $widget_instances ), 'is_int' );
		$next_key = $numeric_keys ? max( $numeric_keys ) + 1 : 2;
		// Add this widget to the sidebar
		if ( ! isset( $sidebars_widgets[ $sidebar ] ) ) {
			$sidebars_widgets[ $sidebar ] = array();
		}
		$sidebars_widgets[ $sidebar ][] = $widget_id . '-' . $next_key;
		// Add the new widget instance
		$widget_instances[ $next_key ] = $widget_data;

		if(isset($sidebars_widgets['sidebar-woo-cart-popup']) && empty($sidebars_widgets['sidebar-woo-cart-popup'])) {
			// Store updated sidebars, widgets and their instances
			update_option( 'sidebars_widgets', $sidebars_widgets );
			update_option( 'widget_' . $widget_id, $widget_instances );
		}
	}

	public function wc_requirement_notice() {
				
		if ( ! $this->is_wc_active() ) {
			
			$class = 'notice notice-error';
			
			$text    = esc_html__( 'WooCommerce', 'woocommerce' );
			$link    = esc_url( add_query_arg( array(
				                                   'tab'       => 'plugin-information',
				                                   'plugin'    => 'woocommerce',
				                                   'TB_iframe' => 'true',
				                                   'width'     => '640',
				                                   'height'    => '500',
			                                   ), admin_url( 'plugin-install.php' ) ) );
			$message = wp_kses( __( "<strong>WooCommerce Cart Popup</strong> is an add-on of ", 'woocommerce' ), array( 'strong' => array() ) );
			
			printf( '<div class="%1$s"><p>%2$s <a class="thickbox open-plugin-details-modal" href="%3$s"><strong>%4$s</strong></a></p></div>', $class, $message, $link, $text );
		}
	}

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