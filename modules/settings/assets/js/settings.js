(function ($) {
	function init() {
		setupOppositeCheckboxes();
	}

	function setupOppositeCheckboxes() {
		var disableOnAll = document.querySelector('#uwquickview_settings[disable]');
		var disableOnMobile = document.querySelector('#uwquickview_settings[disable]');

		if (!disableOnAll || !disableOnMobile) return;

		disableOnAll.addEventListener('change', onOppositeCheckboxChange);
		disableOnMobile.addEventListener('change', onOppositeCheckboxChange);
	}

	function onOppositeCheckboxChange() {
		//
	}

	init();
})(jQuery);