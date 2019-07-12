(function( $ ) {
	'use strict';


	jQuery(document).on('click', '.wcp_remove_from_cart_button', function(e) {
	    e.preventDefault();
	    var _this_product = $(this).data('product_id');
	    $.ajax({
	        type: "POST",
	        url: frontend_ajax_object.ajaxurl,
	        data: {
	                action: 'wcp_remove_item_from_cart', 
	                wcp_security : frontend_ajax_object.ajax_nonce,
	               'cart_item_key': String($(this).data('cart_item_key'))
	               },
	         success: function(data){
	         	$( document.body ).trigger( 'wc_fragment_refresh' );
                //jQuery("#wcp-product-"+_this_product).remove();
                cuteHide(jQuery("#wcp-product-"+_this_product));
             }
	    });
	});

	function cuteHide(el) {
	  el.animate({opacity: '0'}, 150, function(){
	    el.animate({height: '0px'}, 150, function(){
	      el.remove();
	    });
	  });
	}

	jQuery(document).on('click', '.wcp-cart-empty-btn', function(e) {
	    e.preventDefault();
	    var r = confirm("Are you Sure?");
		if (r == true) {
		    $.ajax({
		        type: "POST",
		        url: frontend_ajax_object.ajaxurl,
		        data: {
		                action: 'wcp_empty_cart', 
		                wcp_security : frontend_ajax_object.ajax_nonce,
		               },
		         success: function(data){
		         	$( document.body ).trigger( 'wc_fragment_refresh' );
	                //jQuery("#wcp-product-"+_this_product).remove();
	             }
		    });
	    } 
	});

	/**
	 * All of the code for your public-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */

})( jQuery );
