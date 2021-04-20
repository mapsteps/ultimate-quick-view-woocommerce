(function ($) {
	function init() {
		setupOppositeCheckboxes();
	}

	function setupOppositeCheckboxes() {
		var disableOnAll = document.querySelector('#uquickview_settings-disable');
		var disableOnMobile = document.querySelector('#uquickview_settings-disable_on_mobile');

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

	init();
})(jQuery);