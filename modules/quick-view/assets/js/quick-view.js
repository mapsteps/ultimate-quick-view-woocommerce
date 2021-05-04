/**
 * Quick view functionality.
 * 
 * Used global objects:
 * - uquickviewObj
 */
(function ($) {
	if (!wc_add_to_cart_params || !uquickviewObj) return;

	var popup = document.querySelector('.uquickview-popup');
	var popupProduct = document.querySelector('#uquickview-popup-product');
	if (!popup || !popupProduct) return;

	var $popup = $(popup);

	var state = {
		isRequesting: false
	};

	var speed = 300;
	var loading = {};
	var ajax = {};

	ajax.addToCart = {};

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
		$(document).on('click', '.uquickview-view-button', ajax.loadQuickView);

		// Close popup by clicking on close button.
		$(document).on('click', '.uquickview-close-popup', closeQuickViewPopup);

		// Close popup by clicking on the overlay.
		document.addEventListener('click', function (e) {
			if (e.target.classList.contains('uquickview-popup') && $popup.is(":visible")) {
				closeQuickViewPopup();
			}
		});

		// Close popup by tapping the escape key.
		document.addEventListener('keyup', function (e) {
			if (e.key !== 'Escape' && e.key !== 'Esc') return;
			if ($popup.is(':visible')) closeQuickViewPopup();
		});

		$(document).on('click', '.uquickview-popup-content .product:not(.product-type-external) .single_add_to_cart_button', addToCart);
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
	ajax.loadQuickView = function (e) {
		e.preventDefault();

		if (state.isRequesting) return;
		state.isRequesting = true;

		var productId = this.dataset.productId;
		var button = this;

		loading.start(button);

		$.ajax({
			url: uquickviewObj.ajaxurl,
			type: 'GET',
			cache: false,
			dataType: 'json',
			data: {
				product_id: productId,
				action: 'uquickview_get_product_quickview'
			}
		}).done(function (r) {
			popupProduct.innerHTML = r.data;

			openQuickViewPopup();

			var addToCartButton = popupProduct.querySelector('.single_add_to_cart_button');
			if (addToCartButton) addToCartButton.classList.add('uquickview-button');

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
	 * Ajax add to cart functionality.
	 *
	 * @see wp-content/plugins/woocommerce/includes/class-wc-ajax.php
	 * @see wp-content/plugins/woocommerce/includes/class-wc-form-handler.php
	 */
	function addToCart(e) {
		e.preventDefault();

		var product = document.querySelector('#uquickview-popup-product .type-product');
		var isVariable = product.classList.contains('product-type-variable');
		var isGrouped = product.classList.contains('product-type-grouped');

		// If this is variable or grouped product type.
		if (isVariable || isGrouped) {

			ajax.addToCart.advancedProduct(product);
			return;

		}

		// If this is a simple product type.
		ajax.addToCart.simpleProduct(product);
	}

	/**
	 * Add to cart for variable / grouped product type.
	 * 
	 * This function uses our `add_to_cart` ajax handler in woocommerce-quick-view.php file.
	 * However, our handler is only about preparing the response & adjusting wc notices.
	 *
	 * The core functionality is using Woocommerce's default `add_to_cart_action` function
	 * inside  class-wc-form-handler.php file.
	 * 
	 * The `add_to_cart_action` is hooked into `wp_loaded` by Woocommerce.
	 *
	 * @see wp-content/plugins/woocommerce/includes/class-wc-form-handler.php
	 * @see wp-content/plugins/page-builder-framework-premium-add-on/inc/integration/woocommerce/woocommerce-quick-view.php
	 *
	 * @param HTMLElement product The product area inside quick view modal.
	 */
	ajax.addToCart.advancedProduct = function (product) {
		if (state.isRequesting) return;
		state.isRequesting = true;

		var button = product.querySelector('.single_add_to_cart_button');
		loading.start(button);

		var cartForm = product.querySelector('form.cart');
		var addToCartField = cartForm.querySelector('[name="add-to-cart"]');
		var qtyField = cartForm.querySelector('[name="quantity"]');

		var isVariable = product.classList.contains('product-type-variable');
		var isGrouped = product.classList.contains('product-type-grouped');

		var productId = addToCartField.value;

		/**
		 * The submission payload format.
		 * 
		 * Below are the payload format for variable and grouped products.
		 * The value of `add-to-cart` (by Woocommerce) is product_id.
		 * 
		 * Variable product:
		 * {
		 * 		add-to-cart: 200,
		 * 		product_id: 200,
		 * 		quantity: 1,
		 * 		variation_id: 100,
		 * 		attribute_sample: sampleValue,
		 * 		attribute_another: anotherValue,
		 * 		attribute_more: moreValue
		 * }
		 * 
		 * Grouped product (doesn't require `product_id`):
		 * {
		 * 		add-to-cart: 200,
		 * 		quantity: {
		 * 			205: 1,
		 * 			206: 2,
		 * 			207: 1
		 * 		}
		 * }
		 */
		var payload = {};

		payload.action = 'uquickview_add_to_cart';
		payload['add-to-cart'] = productId;

		var groupItems;

		// If current product is a grouped products.
		if (isGrouped) {
			groupItems = cartForm.querySelectorAll('.woocommerce-grouped-product-list-item');
			payload.quantity = {};

			groupItems.forEach(function (productItem) {
				var productId = productItem.id.replace('product-', '');
				var qtyField = productItem.querySelector('input.qty');

				payload.quantity[productId] = qtyField ? qtyField.value : 0;
			});
		} else {
			payload.product_id = productId;
			payload.quantity = qtyField ? qtyField.value : 0;
		}

		var variationFields;
		var variationIdField;

		// If current product is a variable product.
		if (isVariable) {
			variationIdField = cartForm.querySelector('[name="variation_id"]');
			variationFields = cartForm.querySelectorAll('.variations .value select[data-attribute_name]');

			payload.variation_id = variationIdField ? variationIdField.value : 0;

			variationFields.forEach(function (field) {
				payload[field.name] = field.value;
			});
		}

		$.ajax({
			url: uquickviewObj.ajaxurl,
			type: 'post',
			dataType: 'json',
			data: payload
		}).done(function (response) {
			if (!response) return;

			// Redirect to cart option when necessary.
			if (wc_add_to_cart_params.cart_redirect_after_add === 'yes' && uquickviewObj.cart_redirect_after_add) {
				window.location = wc_add_to_cart_params.cart_url;
				return;
			}

			var $defaultAddToCartButton;

			if (isGrouped) {
				$defaultAddToCartButton = $('.product .product_type_grouped[data-product_id="' + productId + '"]');
			} else {
				$defaultAddToCartButton = $('.product .add_to_cart_button[data-product_id="' + productId + '"]');
			}

			// Trigger event so themes can refresh other areas.
			$(document.body).trigger('wc_fragment_refresh');
			$(document.body).trigger('added_to_cart', [{}, '', $defaultAddToCartButton]);
		}).fail(function (jqXHR) {
			console.error(buildErrorMsg(jqXHR));
		}).always(function () {
			loading.stop(button);
			closeQuickViewPopup();
			state.isRequesting = false;
		});
	}

	/**
	 * Add to cart for simple product type.
	 *
	 * This function uses Woocommerce's default ajax `add_to_cart` handler.
	 * The handler is `add_to_cart` function inside class-wc-ajax.php file.
	 * 
	 * @see wp-content/plugins/woocommerce/assets/js/frontend/add-to-cart.js
	 * @see wp-content/plugins/woocommerce/includes/class-wc-ajax.php
	 * 
	 * @param HTMLElement product The product area inside quick view modal.
	 */
	ajax.addToCart.simpleProduct = function (product) {
		if (state.isRequesting) return;
		state.isRequesting = true;

		var button = product.querySelector('.single_add_to_cart_button');
		loading.start(button);

		var cartForm = product.querySelector('form.cart');
		var addToCartField = cartForm.querySelector('[name="add-to-cart"]');
		var qtyField = cartForm.querySelector('[name="quantity"]');

		var productId = addToCartField.value;

		/**
		 * Simple product type payload format:
		 * {
		 * 		product_id: 200,
		 * 		quantity: 1
		 * }
		 */
		$.ajax({
			url: wc_add_to_cart_params.wc_ajax_url.toString().replace('%%endpoint%%', 'add_to_cart'),
			type: 'post',
			dataType: 'json',
			data: {
				product_id: productId,
				quantity: qtyField.value
			}
		}).done(function (response) {
			if (!response) return;

			if (response.error && response.product_url) {
				window.location = response.product_url;
				return;
			}

			// Redirect to cart option when necessary.
			if (wc_add_to_cart_params.cart_redirect_after_add === 'yes' && uquickviewObj.cart_redirect_after_add) {
				window.location = wc_add_to_cart_params.cart_url;
				return;
			}

			var $defaultAddToCartButton = $('.product .add_to_cart_button[data-product_id="' + productId + '"]');

			// Trigger event so themes can refresh other areas.
			$(document.body).trigger('added_to_cart', [response.fragments, response.cart_hash, $defaultAddToCartButton]);
		}).fail(function (jqXHR) {
			console.error(buildErrorMsg(jqXHR));
		}).always(function () {
			loading.stop(button);
			closeQuickViewPopup();
			state.isRequesting = false;
		});
	};

	function buildErrorMsg(jqXHR) {
		var msg = 'Error ' + jqXHR.status.toString() + ' (' + jqXHR.statusText + ')';
		msg = jqXHR.responseJSON && jqXHR.responseJSON.data ? msg + ': ' + jqXHR.responseJSON.data : msg;

		return msg;
	}

	init();
})(jQuery);