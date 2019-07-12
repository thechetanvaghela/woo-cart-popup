<?php
class WooCartPopupSettings {

	// class constructor
	function __construct() {
		add_action( 'admin_menu', array($this, 'woo_cart_seeting_admin_menu' ) );
	}
	
	function woo_cart_seeting_admin_menu() {

		add_menu_page('Woo Cart Popup','Woo Cart Popup','manage_options','woo_cart_popup_settings_page',array($this, 'woo_cart_popup_settings_page' ),'dashicons-cart');
	}
	/**
	 * Plugin settings page
	 */
	function woo_cart_popup_settings_page() {
		$form_msg = $postion_value = $display_at = $get_display_at = $selected = "";
		$options = array();
		if ( current_user_can('manage_options') ) {
	        if (isset($_POST['wcp-popup-form-settings'])) {
	        	if ( ! isset( $_POST['woo_cart_popup_setting_field_nonce'] ) || ! wp_verify_nonce( $_POST['woo_cart_popup_setting_field_nonce'], 'woo_cart_popup_setting_action_nonce' ) ) {
				    $form_msg = '<b style="color:red;">Sorry, your nonce did not verify.</b>';
				   //exit;
				} else {
		        	if (isset($_POST['woo-cart-popup-display-at'])) {
		                $postion_value = sanitize_text_field($_POST['woo-cart-popup-display-at']);
		                $display_at = !empty($postion_value) ? $postion_value : "right";
		                update_option('woo-cart-popup-display-at', $display_at);
		                $form_msg = '<b style="color:green;">Settings Saved.</b>';
	            	}
	         	}
	    	}
		}

        $get_display_at = esc_attr(get_option('woo-cart-popup-display-at'));
		?>
		<div class="wrap">
			<h2><?php esc_html_e('Woo Cart Popup Settings','woo-cart-popup'); ?></h2>
			<div id="wcp-setting-container">
				<div id="wcp-body">
					<div id="wcp-body-content">
						<div class="">
							<br/><?php echo $form_msg; ?><hr/><br/>
							<form method="post">
                                 <table>
                                  <tr valign="top">
                                  <th scope="row"><label for="woo-cart-popup-display-at"><?php _e('Woo Cart Popup Display Position At : ','woo-cart-popup'); ?></label></th>
                                  <td>
                                  		<select id="woo-cart-popup-display-at" name="woo-cart-popup-display-at">
	                                  		<?php $options = array("right" => "Right","left" => "Left","center" => "Center");
	                                  		foreach ($options as $key => $value) {
	                                  			$selected = ($get_display_at == $key) ? "selected" : "";
	                                  			echo '<option value="'.esc_attr($key).'" '.$selected.'>'.__(esc_attr($value) ,'woo-cart-popup').'</option>';
	                                  		}
	                                  		?>                                       
                                        </select>
                                    </td>
                                  </tr>
                                  </table>
                                  <?php wp_nonce_field( 'woo_cart_popup_setting_action_nonce', 'woo_cart_popup_setting_field_nonce' ); ?>
                                  <?php  submit_button( 'Save Settings', 'primary', 'wcp-popup-form-settings'  ); ?>
							</form>
						</div>
					</div>
				</div>
				<br class="clear">
			</div>
		</div>
	<?php
	}

}
/* check woocommerce is active or not*/
if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
	new WooCartPopupSettings;
}