/**
 * Quick view functionality.
 * 
 * Used global objects:
 * - wooquickviewObj
 */
(function ($) {
	var popup = document.querySelector('.wooquickview-popup');
	var popupProduct = document.querySelector('#wooquickview-popup-product');
	if (!popup || !popupProduct) return;

	var state = {
		isRequesting: false
	};

	/**
	 * Init the plugin.
	 */
	function init() {
		setupPopup();
	}

	/**
	 * Setup the popup.
	 */
	function setupPopup() {
		$(document).on('click', '.wooquickview-view-button', loadQuickView);

		// Close popup by clicking on close button.
		$(document).on('click', '.wooquickview-close-popup', closeQuickViewPopup);

		// Close popup by clicking on the overlay.
		$(document).click(function (e) {
			var $target = $(e.target);

			if (
				!$target.closest('.wooquickview-popup-content').length &&
				$('.wooquickview-popup-content').is(":visible")) {
				closeQuickViewPopup();
			}
		});

		// Close popup by tapping the escape key.
		$(document).keyup(function (e) {
			if (e.keyCode == 27) {
				if ($('.wooquickview-popup-content').is(':visible')) {
					closeQuickViewPopup();
				}
			}
		});

		$(document).on('click', '.wooquickview-popup-content .product:not(.product-type-external) .single_add_to_cart_button', addToCart)
	}

	/**
	 * Load quick view output through ajax request.
	 */
	function loadQuickView(e) {
		e.preventDefault();

		if (state.isRequesting) return;
		state.isRequesting = true;

		var productId = this.dataset.productId;

		$(this).block({
			message: null,
			overlayCSS: {
				background: '#fff url(' + wooquickviewObj.loader + ') no-repeat center',
				opacity: 0.5,
				cursor: 'none'
			}
		});

		$.ajax({
			url: wooquickviewObj.ajaxurl,
			type: 'GET',
			dataType: 'json',
			data: {
				product_id: productId,
				action: 'wooquickview_get_product_quickview',
				nonce: wooquickviewObj.nonces.getQuickview,
			}
		}).done(function (r) {
			if (!r) {
				console.error('Invalid request');
				return;
			}

			if (!r.success) {
				console.error(r.data);
				return;
			}

			popupProduct.innerHTML = r.data;
			$(popup).stop().fadeIn(300);

			// Variation Form
			var variationForms = popupProduct.querySelectorAll('.variations_form');

			variationForms.forEach(function (form) {
				$(form).wc_variation_form();
				$(form).trigger('check_variations');
				$(form).trigger('reset_image');
			});


			if ('undefined' !== typeof $.fn.wc_product_gallery) {
				var productGalleries = popupProduct.querySelectorAll('.woocommerce-product-gallery');

				productGalleries.forEach(function (productGallery) {
					$(productGallery).wc_product_gallery();
				});
			}
		}).fail(function () {
			console.error('There is a problem with network/ server.');
		}).always(function () {
			$(this).unblock();
			state.isRequesting = false;
		});
	}

	function closeQuickViewPopup() {
		$(popup).stop().fadeOut('300');
		popupProduct.innerHTML = '';
	}

	/**
	 * Add product to cart through ajax request.
	 */
	function addToCart(e) {
		e.preventDefault();
		e.stopImmediatePropagation();

		if (state.isRequesting) return;
		state.isRequesting = true;

		// Add loading / spinner when the add to cart is triggered.
		$(this).block({
			message: null,
			overlayCSS: {
				background: '#fff url(' + wooquickviewObj.loader + ') no-repeat center',
				opacity: 0.5,
				cursor: 'none'
			}
		});

		var variationForm = $(this).parents('.variations_form');
		var variationBag = {};
		var isError = false;
		var	payload = {};
		var	quantity = $(this).parents('.cart').find('input[name="quantity"]').val();
		var isVariation = variationForm.length > 0;
		var productId = isVariation === true ? variationForm.data('product_id') : $(this).val();
		var variationId = variationForm.find('input[name="variation_id"]').val();
		var variations = variationForm.find('select[name^=attribute]');

		if (!variations.length) {
			variations = variationForm.find('[name^=attribute]:checked');
		}

		if (!variations.length) {
			variations = variationForm.find('input[name^=attribute]');
		}

		variations.each(function () {
			var $this = $(this);
			var attributeName = $this.attr('name');
			var attributevalue = $this.val();
			var index;
			var variationName;

			$this.removeClass('error');

			if (!attributevalue.length) {
				index = attributeName.lastIndexOf('_');
				variationName = attributeName.substring(index + 1);
				isError = true;

				$('.wpbf-woo-quick-view-modal-content select').each(function () {
					if (!$(this).val()) {
						$(this).addClass('select-error');
					}
				});
			} else {
				variationBag[attributeName] = attributevalue;
			}
		});

		// Stop if there is any error.
		if (isError) return;
		
		payload.action = 'wooquickview_add_to_cart';
		payload.nonce = wooquickviewObj.nonces.addToCart;
		payload.product_id = productId;
		payload.quantity = quantity;
		payload.is_variation = isVariation;

		if (isVariation) {
			payload.variations = variationBag;
			payload.variation_id = variationId;
		}

		$.ajax(
			{
				url: wooquickviewObj.ajaxurl,
				type: 'post',
				dataType: 'json',
				data: payload
			}
		).done(function (r) {
			if (!r) {
				console.error('Invalid request');
				return;
			}

			if (!r.success) {
				console.error(r.data);
				return;
			}

			$(document.body).trigger('wc_fragment_refresh');
			$(document.body).trigger('added_to_cart');
		}).fail(function () {
			console.error('There is a problem with network/ server.');
		}).always(function () {
			// Remove loader / spinner from add to cart button.
			$(this).unblock();
			closeQuickViewPopup();
			state.isRequesting = false;
		});
	}

	init();
})(jQuery);