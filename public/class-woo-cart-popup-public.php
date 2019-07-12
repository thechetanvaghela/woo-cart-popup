<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://chetanvaghela.cf/
 * @since      1.0.0
 *
 * @package    Woo_Cart_Popup
 * @subpackage Woo_Cart_Popup/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Woo_Cart_Popup
 * @subpackage Woo_Cart_Popup/public
 * @author     Chetan Vaghela <ckvaghela92@gmail.com>
 */
class Woo_Cart_Popup_Public {

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
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name = "", $version ="" ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
	}

	
	/**
	 * Register the stylesheets for the public-facing side of the site.
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
		wp_enqueue_style( 'wp-chat-bootstrap-min', plugin_dir_url( __FILE__ ) . 'css/bootstrap.min.css',array(), '20190710' );
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/woo-cart-popup-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
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
		wp_enqueue_script( 'wp-chat-bootstrap-script',  plugin_dir_url( __FILE__ ) . 'js/bootstrap.min.js', array( 'jquery' ), '20190710', true );
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/woo-cart-popup-public.js', array( 'jquery' ), $this->version, true );
		wp_localize_script($this->plugin_name,'frontend_ajax_object',array('ajaxurl' => admin_url( 'admin-ajax.php'),'ajax_nonce' => wp_create_nonce('wcp_ajax_nonce'),));

	}
	/**
	 * add_woo_cart_popup_html_in_footer
	 * @since    1.0.0
	 */
	public function add_woo_cart_popup_html_in_footer() {
		$get_display_at =  esc_attr(get_option('woo-cart-popup-display-at'));
		$display_at =  !empty($get_display_at) ? $get_display_at : "right";
		?>
		<a class="woo-cart-popup-btn" data-toggle="modal" data-target="#wcp-cart-widget-Modal">
			<div class="woo-cart-popup-button-container <?php echo esc_attr($display_at);?>">
				<img src="<?php echo esc_url(plugin_dir_url( __FILE__ ).'images/cart-btn-icon.png');?>" alt="" /><div class="woo-cart-popup-count-container"><span class="woo-cart-popup-count"><?php echo WC()->cart->get_cart_contents_count(); ?></span></div>
			</div>
		</a>
		<!-- Modal -->
		<div class="woo-cart-popup modal <?php echo esc_attr($display_at); ?> fade" id="wcp-cart-widget-Modal" tabindex="-1" role="dialog" aria-labelledby="wcp-Modal-Label">
			<div class="modal-dialog" role="document">
				<div class="modal-content">

					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title" id="wcp-Modal-Label">Your Cart (<span class="woo-cart-popup-count"><?php echo WC()->cart->get_cart_contents_count(); ?></span>)
						</h4>
					</div>

					<div class="modal-body">
						<div class="wcp-container container">
							<?php do_action('wcp_content'); ?>
						</div>
					</div>

				</div><!-- modal-content -->
			</div><!-- modal-dialog -->
		</div><!-- modal -->

		<?php

	}

	public function wcp_get_cart_content(){
		//$cart_data 	= WC()->cart->get_cart(); 
		ob_start();
		wc_get_template('wcp-cart-content.php',$args = array(),'',WCP_PLUGIN_DIR.'public/partials/');
		return ob_get_clean();
	}

	/**
	 * woo_cart_popup_count_fragments
	 * @since    1.0.0
	 */
	public function woo_cart_popup_count_fragments( $fragments ) {
    	$wcp_content = $this->wcp_get_cart_content();

		//Cart content
		$fragments['div.wcp-container'] = '<div class="wcp-container">'.$wcp_content.'</div>';

	    $fragments['span.woo-cart-popup-count'] = '<span class="woo-cart-popup-count">' . WC()->cart->get_cart_contents_count() . '</span>';
	    
	    return $fragments;
	    
	}

	/**
	 * wcp_remove_item_from_cart
	 * @since    1.0.0
	 */
	public function wcp_remove_item_from_cart() {
		check_ajax_referer( 'wcp_ajax_nonce', 'wcp_security' );
	    $cart_item_key = sanitize_text_field($_POST['cart_item_key']);
	    if($cart_item_key){
	       WC()->cart->remove_cart_item($cart_item_key);
	       return true;
	    } 
	    return false;
	}

	/**
	 * wcp_empty_cart
	 * @since    1.0.0
	 */
	public function wcp_empty_cart() {
		   check_ajax_referer( 'wcp_ajax_nonce', 'wcp_security' );
	       WC()->cart->empty_cart();
	       return true;
	}

}
