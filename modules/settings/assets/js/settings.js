(function ($) {
	function init() {
		setupOppositeCheckboxes();
		adjustRefererField();
	}

	function setupOppositeCheckboxes() {
		var disableOnAll = document.querySelector('#uwquickview_settings-disable');
		var disableOnMobile = document.querySelector('#uwquickview_settings-disable_on_mobile');

		if (!disableOnAll || !disableOnMobile) return;

		disableOnAll.addEventListener('change', onOppositeCheckboxChange);
		disableOnMobile.addEventListener('change', onOppositeCheckboxChange);

		function onOppositeCheckboxChange() {
			if (this.id === disableOnAll.id) {
				disableOnMobile.checked = this.checked ? false : disableOnMobile.checked;
			} else if (this.id === disableOnMobile.id) {
				disableOnAll.checked = this.checked ? false : disableOnAll.checked;
			}
		}
	}

	function adjustRefererField() {
		var field = document.querySelector('[name="_wp_http_referer"]');
		if (!field) return;
		
		$(document).on('click', '.heatbox-tab--nav-item a', onTabNavClick);
		window.addEventListener('load', checkTabState);
		
		function onTabNavClick() {
			var hash = this.href.substring(this.href.indexOf('#') + 1);
			if (!hash) return;
			
			setRefererValue(hash);
		}

		function checkTabState() {
			var hash = window.location.hash.substr(1);
			if (!hash) return;

			setRefererValue(hash);
		}

		function setRefererValue(hash) {
			var url;

			if (field.value.includes('#')) {
				url = field.value.split('#');
				url = url[0];

				field.value = url + '#' + hash;
			} else {
				field.value = field.value + '#' + hash;
			}
		}
	}

	init();
})(jQuery);