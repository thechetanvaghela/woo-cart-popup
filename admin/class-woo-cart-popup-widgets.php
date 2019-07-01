<?php
function wpb_load_widget() {
    register_widget( 'woo_cart_popup_widget' );
}
add_action( 'widgets_init', 'wpb_load_widget' );
// Creating the widget 
class woo_cart_popup_widget extends WP_Widget {
 
	public function __construct() {
/*
		$this->widget_cssclass    = 'woocommerce widget-woo-cart-popup';
		$this->widget_description = __( 'Display the customer shopping cart Popup.', 'woocommerce' );
		$this->widget_id          = 'woo_cart_popup_widget';
		$this->widget_name        = __( 'Woo Cart Popup', 'woocommerce' );
		$this->settings           = array(
			'title'         => array(
				'type'  => 'text',
				'std'   => __( 'Woo Cart Popup', 'woocommerce' ),
				'label' => __( 'Title', 'woocommerce' ),
			),
			'hide_if_empty' => array(
				'type'  => 'checkbox',
				'std'   => 0,
				'label' => __( 'Hide if cart is empty', 'woocommerce' ),
			),
		);

		//if ( is_customize_preview() ) {
			wp_enqueue_script( 'wc-cart-fragments' );
		//}

		parent::__construct();	*/	

		parent::__construct(	 
		// Base ID of your widget
		'woo_cart_popup_widget', 	 
		// Widget name will appear in UI
		__('Woo Cart Popup', 'woocommerce'), 
	 		// Widget description
		array( 'description' => __( 'Display the customer shopping cart Popup.', 'woocommerce' ), ) 
		);
	}
	 
	/**
	 * Output widget.
	 *
	 * @see WP_Widget
	 *
	 * @param array $args     Arguments.
	 * @param array $instance Widget instance.
	 */
	public function widget( $args, $instance ) {
		if ( apply_filters( 'woocommerce_widget_cart_is_hidden', is_cart() || is_checkout() ) ) {
			return;
		}

		$hide_if_empty = empty( $instance['hide_if_empty'] ) ? 0 : 1;

		if ( ! isset( $instance['title'] ) ) {
			$instance['title'] = __( 'Cart', 'woocommerce' );
		}

		$this->widget_start( $args, $instance );

		if ( $hide_if_empty ) {
			echo '<div class="hide_cart_widget_if_empty">';
		}

		// Insert cart widget placeholder - code in woocommerce.js will update this on page load.
		echo '<div class="widget_shopping_cart_content"></div>';

		if ( $hide_if_empty ) {
			echo '</div>';
		}

		$this->widget_end( $args );
	}
} // Class woo_cart_popup_widget ends here