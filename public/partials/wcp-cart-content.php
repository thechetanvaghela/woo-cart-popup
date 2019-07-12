<?php
if(WC()->cart->is_empty())
{ 
	?>
	<span class="wcp-cart-empty-msg"><?php esc_attr_e('Your cart is empty!','woo-cart-popup'); ?></span>
	<?php 
}
else
{ 
	echo '<div class="wcp-body row">';
	foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item )
	{

		$_product     = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
		$product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );
		if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_cart_item_visible', true, $cart_item, $cart_item_key ) )
		{
			//woocommerce product permalink
			$product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );	

			//woocommerce product thumbnail		
			$thumbnail = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key );
			
			//woocommerce product name
			$product_name =  apply_filters( 'woocommerce_cart_item_name', sprintf( '<a href="%s">%s</a>', esc_url( $product_permalink ), $_product->get_title() ), $cart_item, $cart_item_key );

			//woocommerce product price
			$product_price = apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key );

			//woocommerce product subtotal
			$product_subtotal = apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key );

			$attributes = '';
			//woocommerce Variation
			$attributes .= $_product->is_type('variable') || $_product->is_type('variation') ? wc_get_formatted_variation($_product) : '';
			// woocommerce Meta data
			if(version_compare( WC()->version , '3.3.0' , "<" )){
				$attributes .=  WC()->cart->get_item_data( $cart_item );
			}
			else{
				$attributes .=  wc_get_formatted_cart_item_data( $cart_item );
			}
			
			//woocommerce product bundal by
			$wcp_bundled_child  = isset($cart_item['bundled_by']);
		?>
			<div class="wcp-product  col-lg-12 col-md-12" id="wcp-product-<?php echo esc_attr($product_id); ?>" data-wcp="<?php echo esc_attr($cart_item_key); ?>">
				<div class="wcp-img-col col-lg-4 col-md-4">
					<a href="<?php echo esc_url($product_permalink); ?>" class="wcp-product-image"><?php echo $thumbnail; ?></a>
					
				</div>
				<div class="wcp-sum-col col-lg-8 col-md-8">
					<div class="wcp-product-name"><?php echo $product_name; ?></div>
					<?php echo $attributes ? $attributes : ''; ?> 
					<?php if(!$wcp_bundled_child): ?>
						<div class="wcp-price">
							<span><?php echo $cart_item['quantity']; ?></span> <span>X</span><span><?php echo $product_price; ?></span> 
							
								= <span><?php echo $product_subtotal; ?></span>
							
						</div>
					<?php endif; ?>
					<?php if(!$wcp_bundled_child): ?>
						<?php
						echo apply_filters( 'woocommerce_cart_item_remove_link', sprintf(
							'<a href="javascript:void(0);" class="wcp_remove_from_cart_button" aria-label="%s" data-product_id="%s" data-cart_item_key="%s" data-product_sku="%s">Remove</a>',
							__( 'Remove this item', 'woocommerce' ),
							esc_attr( $product_id ),
							esc_attr( $cart_item_key ),
							esc_attr( $_product->get_sku() )
						), $cart_item_key );
						?>
					<?php endif; ?>
				</div>
			</div>
		<?php 
		}
	}
	echo '</div>';

	$wcp_subtotal_txt 		=  __("Subtotal:",'woo-cart-popup'); //Subtotal Text
	$wcp_cart_txt 			=  __("View Cart",'woo-cart-popup'); //Cart Text
	$wcp_empty_cart_txt 	=  __("Empty Cart",'woo-cart-popup'); //Cart Text
	$wcp_chk_txt 			=  __("Checkout",'woo-cart-popup'); //Checkout Text
	?>
	
	<div class="wcp-footer">
		<div class="wcp-footer-part-one">
			<div class="wcp-subtotal">
				<span><?php esc_attr_e($wcp_subtotal_txt,'woo-cart-popup') ?></span> <?php echo WC()->cart->get_cart_subtotal(); ?>
			</div>
		</div>
		<div class="wcp-footer-part-two">

			<?php $hide_wcp_btns = WC()->cart->is_empty() ? 'style="display: none;"' : '';?>
			<div style="display: inline !important;">
				<?php if(!empty($wcp_cart_txt)): ?>
				<a href="<?php echo esc_url(wc_get_cart_url()); ?>" class="button wcp-cart btn" <?php esc_attr_e($hide_wcp_btns); ?>><?php echo esc_attr__($wcp_cart_txt,'woo-cart-popup'); ?></a>
				<?php endif; ?>
				<a href="javascript:void(0);" class="button wcp-cart-empty-btn btn"  <?php esc_attr_e($hide_wcp_btns); ?>><?php echo esc_attr__($wcp_empty_cart_txt,'woo-cart-popup'); ?></a>
			</div>

			<?php if(!empty($wcp_chk_txt)): ?>
			<a  href="<?php echo esc_url(wc_get_checkout_url()); ?>" class="button wcp-chkt btn" <?php esc_attr_e($hide_wcp_btns); ?>><?php echo esc_attr__($wcp_chk_txt,'woo-cart-popup'); ?></a>
			<?php endif; ?>		

		</div>
	</div>
	<?php
}
?>