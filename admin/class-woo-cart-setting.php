<?php
class WooCartPopupSettings {

	// class constructor
	function __construct() {
		add_action( 'admin_menu', array($this, 'woo_cart_seeting_admin_menu' ) );
	}
	
	function woo_cart_seeting_admin_menu() {

		add_menu_page('Woo Cart Popup','Woo Cart Popup','manage_options','woo_cart_popup_settings_page',array($this, 'woo_cart_popup_settings_page' ),'dashicons-format-chat');
	}


	/**
	 * Plugin settings page
	 */
	function woo_cart_popup_settings_page() {

        if (isset($_POST['woo-cart-popup-display-at'])) {
                $value = $_POST['woo-cart-popup-display-at'];
                $display_at = !empty($value) ? $value : "right";
                update_option('woo-cart-popup-display-at', $display_at);

            }
        $get_display_at = get_option('woo-cart-popup-display-at');
		?>
		<div class="wrap">
			<h2>Woo Cart Popup Settings</h2>

			<div id="poststuff">
				<div id="post-body" class="metabox-holder columns-2">
					<div id="post-body-content">
						<div class="meta-box-sortables ui-sortable">
							<form method="post">
                                 <table>
                                  <tr valign="top">
                                  <th scope="row"><label for="woo-cart-popup-display-at">Popup Display At</label></th>
                                  <td><select id="woo-cart-popup-display-at" name="woo-cart-popup-display-at">
                                  		<?php $options = array("right" => "Right","left" => "Left");
                                  		foreach ($options as $key => $value) {
                                  			$selected = ($get_display_at == $key) ? "selected" : "";
                                  			echo '<option value="'.$key.'" '.$selected.'>'.$value.'</option>';
                                  		}
                                  		?>                                       
                                        </select></td>
                                  </tr>
                                  </table>
                                  <?php  submit_button(); ?>
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
new WooCartPopupSettings;