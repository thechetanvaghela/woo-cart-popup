<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://chetanvaghela.cf/
 * @since      1.0.0
 *
 * @package    Woo_Cart_Popup
 * @subpackage Woo_Cart_Popup/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Woo_Cart_Popup
 * @subpackage Woo_Cart_Popup/includes
 * @author     Chetan Vaghela <ckvaghela92@gmail.com>
 */
class Woo_Cart_Popup {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Woo_Cart_Popup_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		if ( defined( 'WOO_CART_POPUP_VERSION' ) ) {
			$this->version = WOO_CART_POPUP_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'woo-cart-popup';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

		//if(class_exists( 'WooCommerce' ))
		//{
			/**
			*	This action used to add content in footer.
			*/
			add_action('wp_footer', array($this,'add_woo_cart_popup_html_in_footer'));

			/**
			*	woocommerce ajax function.
			*/
			add_filter( 'woocommerce_add_to_cart_fragments', array($this,'woo_cart_popup_count_fragments'), 10, 1 );
		//}

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Woo_Cart_Popup_Loader. Orchestrates the hooks of the plugin.
	 * - Woo_Cart_Popup_i18n. Defines internationalization functionality.
	 * - Woo_Cart_Popup_Admin. Defines all hooks for the admin area.
	 * - Woo_Cart_Popup_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-woo-cart-popup-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-woo-cart-popup-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-woo-cart-popup-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-woo-cart-popup-public.php';

		$this->loader = new Woo_Cart_Popup_Loader();

	}

	/**
	 * add_woo_cart_popup_html_in_footer
	 * @since    1.0.0
	 */
	function add_woo_cart_popup_html_in_footer() {
		$get_display_at =  get_option('woo-cart-popup-display-at');
		$display_at =  !empty($get_display_at) ? $get_display_at : "right";
		?>
		<div class="woo-cart-popup-button-container">
			<a class="woo-cart-popup-btn" data-toggle="modal" data-target="#cart-widget-Modal"><img src="<?php echo plugin_dir_url( __FILE__ )?>/images/cart-btn-icon.png" alt="" /><div class="woo-cart-popup-count-container"><span class="woo-cart-popup-count"><?php echo WC()->cart->get_cart_contents_count(); ?></span></div></a>
		</div>
		<!-- Modal -->
		<div class="woo-cart-popup modal <?php echo $display_at; ?> fade" id="cart-widget-Modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2">
			<div class="modal-dialog" role="document">
				<div class="modal-content">

					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title" id="myModalLabel2">Your Cart <span class="woo-cart-popup-count">(<?php echo WC()->cart->get_cart_contents_count(); ?>)</span>
						</h4>
					</div>

					<div class="modal-body">
						<?php
						if ( is_active_sidebar( 'sidebar-woo-cart-popup' ) ) : 
								dynamic_sidebar( 'sidebar-woo-cart-popup' ); 
						 endif;
						?>
					</div>

				</div><!-- modal-content -->
			</div><!-- modal-dialog -->
		</div><!-- modal -->

		<?php

	}

	/**
	 * woo_cart_popup_count_fragments
	 * @since    1.0.0
	 */
	function woo_cart_popup_count_fragments( $fragments ) {
    
	    $fragments['span.woo-cart-popup-count'] = '<span class="woo-cart-popup-count">' . WC()->cart->get_cart_contents_count() . '</span>';
	    
	    return $fragments;
	    
	}


	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Woo_Cart_Popup_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Woo_Cart_Popup_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Woo_Cart_Popup_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );

	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Woo_Cart_Popup_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );

	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Woo_Cart_Popup_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}
