var HeatboxTab = (function ($) {
	var refererField = document.querySelector('[name="_wp_http_referer"]');

	function init() {
		$(document).on('click', '.heatbox-tab--nav-item a', onTabNavClick);
		window.addEventListener('load', checkTabState);
	}

	function onTabNavClick(e) {
		var hash = this.href.substring(this.href.indexOf('#') + 1);
		if (!hash) return;

		setRefererValue(hash);
	
		var tabLink = this;

		var tabMenuItems = this.parentNode.parentNode.querySelectorAll('.heatbox-tab--nav-item');

		tabMenuItems.forEach(function (tabMenuItem) {
			if (tabMenuItem === tabLink.parentNode) {
				tabMenuItem.classList.add('is-active');
			} else {
				tabMenuItem.classList.remove('is-active');
			}
		});

		var matchedTabContent = document.querySelector('.heatbox-tab--content [data-tab-id="' + hash + '"]');

		if (!matchedTabContent) return;

		var tabContents = matchedTabContent.parentNode.querySelectorAll('.heatbox-tab--content-item');

		tabContents.forEach(function (tabContent) {
			if (tabContent !== matchedTabContent) {
				tabContent.classList.remove('is-active');
			} else {
				tabContent.classList.add('is-active');
			}
		});
	}

	function checkTabState() {
		var hash = window.location.hash.substr(1);
		if (!hash) return;

		setRefererValue(hash);

		var matchedTabLink = document.querySelector('.heatbox-tab--nav-item a[href="#' + hash + '"]');
		var matchedTabContent = document.querySelector('.heatbox-tab--content [data-tab-id="' + hash + '"]');

		var tabMenuItems;

		if (matchedTabLink) {
			tabMenuItems = matchedTabLink.parentNode.parentNode.querySelectorAll('.heatbox-tab--nav-item');

			tabMenuItems.forEach(function (tabMenuItem) {
				if (tabMenuItem === matchedTabLink.parentNode) {
					tabMenuItem.classList.add('is-active');
				} else {
					tabMenuItem.classList.remove('is-active');
				}
			});
		}

		var tabContents;

		if (matchedTabContent) {
			tabContents = matchedTabContent.parentNode.querySelectorAll('.heatbox-tab--content-item');

			tabContents.forEach(function (tabContent) {
				if (tabContent === matchedTabContent) {
					tabContent.classList.add('is-active');
				} else {
					tabContent.classList.remove('is-active');
				}
			});
		}
	}

	function setRefererValue(hash) {
		if (!refererField) return;
		var url;

		if (refererField.value.includes('#')) {
			url = refererField.value.split('#');
			url = url[0];

			refererField.value = url + '#' + hash;
		} else {
			refererField.value = refererField.value + '#' + hash;
		}
	}

	return {
		init: init
	}
})(jQuery);

HeatboxTab.init();

HeatboxShowIf = (function ($) {
	function init() {
		var els = document.querySelectorAll('[data-show-if-field]');
		if (!els) return;
	
		els.forEach(function (el) {
			var field = document.querySelector('#' + el.dataset.showIfField);
			var value = el.dataset.showIfValue;
	
			checkValueState();
	
			field.addEventListener('change', checkValueState);
			
			function checkValueState() {
				if (field.value === value) {
					el.classList.remove('is-hidden');
				} else {
					el.classList.add('is-hidden');
				}
			}
		});
	}

	return {
		init: init
	};

})(jQuery);

HeatboxShowIf.init();