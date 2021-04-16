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

	var $popup = $(popup);

	var state = {
		isRequesting: false
	};

	var loading = {}
	var speed = 300;

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
		document.addEventListener('click', function (e) {
			if (e.target.classList.contains('wooquickview-popup') && $popup.is(":visible")) {
				closeQuickViewPopup();
			}
		});

		// Close popup by tapping the escape key.
		document.addEventListener('keyup', function (e) {
			if (e.key !== 'Escape' && e.key !== 'Esc' && e.keyCode !== 27) return;
			if ($popup.is(':visible')) closeQuickViewPopup();
		});

		$(document).on('click', '.wooquickview-popup-content .product:not(.product-type-external) .single_add_to_cart_button', addToCart);
	}

	loading.start = function (button) {
		button.classList.add('is-loading');
	};

	loading.stop = function (button) {
		button.classList.remove('is-loading');
	};

	/**
	 * Load quick view output through ajax request.
	 */
	function loadQuickView(e) {
		e.preventDefault();

		if (state.isRequesting) return;
		state.isRequesting = true;

		var productId = this.dataset.productId;
		var button = this;

		loading.start(this);

		$.ajax({
			url: wooquickviewObj.ajaxurl,
			type: 'GET',
			dataType: 'json',
			data: {
				product_id: productId,
				action: 'uwquickview_get_product_quickview',
				nonce: wooquickviewObj.nonces.getQuickview,
			}
		}).done(function (r) {
			popupProduct.innerHTML = r.data;

			openQuickViewPopup();

			var addToCartButton = popupProduct.querySelector('.single_add_to_cart_button');
			if (addToCartButton) addToCartButton.classList.add('wooquickview-button');

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
		}).fail(function (jqXHR) {
			console.error(buildErrorMsg(jqXHR));
		}).always(function () {
			loading.stop(button);
			state.isRequesting = false;
		});
	}

	function openQuickViewPopup() {
		$popup.css({ display: 'flex' }).stop().animate({
			opacity: 1
		}, speed);
	}

	function closeQuickViewPopup() {
		$popup.stop().animate({
			opacity: 0
		}, speed, function () {
			popupProduct.innerHTML = '';
			popup.style.display = 'none';
		});
	}

	/**
	 * Add product to cart through ajax request.
	 */
	function addToCart(e) {
		e.preventDefault();
		e.stopImmediatePropagation();

		if (state.isRequesting) return;
		state.isRequesting = true;

		var button = this;

		loading.start(this);

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
		
		payload.action = 'uwquickview_add_to_cart';
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
			$(document.body).trigger('wc_fragment_refresh');

			var $defaultAddToCartButton = $('.product .add_to_cart_button[data-product_id="' + productId + '"]');

			$(document.body).trigger('added_to_cart', [{}, '', $defaultAddToCartButton]);
		}).fail(function (jqXHR) {
			console.error(buildErrorMsg(jqXHR));
		}).always(function () {
			loading.stop(button);
			closeQuickViewPopup();
			state.isRequesting = false;
		});
	}

	function buildErrorMsg(jqXHR) {
		var msg = 'Error ' + jqXHR.status.toString() + ' (' + jqXHR.statusText + ')';
		msg = jqXHR.responseJSON.data ? msg + ': ' + jqXHR.responseJSON.data : msg;

		return msg;
	}

	init();
})(jQuery);