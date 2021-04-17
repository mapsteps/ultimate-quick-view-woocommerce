var HeatboxTab = (function ($) {
	function init() {
		$(document).on('click', '.heatbox-tab--nav-item a', onTabNavClick);
		window.addEventListener('load', checkTabState);
	}

	function onTabNavClick(e) {
		var hash = this.href.substring(this.href.indexOf('#') + 1);
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

	return {
		init: init
	}
})(jQuery);

HeatboxTab.init();