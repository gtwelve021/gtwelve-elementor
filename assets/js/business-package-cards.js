(function () {
	'use strict';

	function initWidget(widget) {
		var viewport = widget.querySelector('[data-g12-package-viewport]');
		var slider = widget.querySelector('[data-g12-package-slider]');
		var sliderWrap = widget.querySelector('[data-g12-package-slider-wrap]');
		var frame = 0;

		if (!viewport || !slider || widget.dataset.g12PackageCardsReady === 'true') {
			return;
		}

		widget.dataset.g12PackageCardsReady = 'true';

		function getMaxScroll() {
			return Math.max(0, viewport.scrollWidth - viewport.clientWidth);
		}

		function updateSlider() {
			var maxScroll = getMaxScroll();
			var maxValue = Number(slider.max || 500);

			if (sliderWrap) {
				sliderWrap.hidden = maxScroll < 1;
			}

			slider.value = maxScroll ? Math.round((viewport.scrollLeft / maxScroll) * maxValue) : 0;
		}

		function updateViewport() {
			var maxValue = Number(slider.max || 500);
			var ratio = maxValue ? Number(slider.value) / maxValue : 0;

			viewport.scrollLeft = getMaxScroll() * ratio;
		}

		slider.addEventListener('input', updateViewport);
		viewport.addEventListener('scroll', function () {
			window.cancelAnimationFrame(frame);
			frame = window.requestAnimationFrame(updateSlider);
		});

		if ('ResizeObserver' in window) {
			new window.ResizeObserver(updateSlider).observe(viewport);
		} else {
			window.addEventListener('resize', updateSlider);
		}

		updateSlider();
	}

	function init(root) {
		var widgets = root.querySelectorAll('[data-g12-package-cards]');

		widgets.forEach(initWidget);
	}

	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', function () {
			init(document);
		});
	} else {
		init(document);
	}

	window.addEventListener('load', function () {
		init(document);
	});

	if (
		window.elementorFrontend &&
		window.elementorFrontend.hooks &&
		typeof window.elementorFrontend.hooks.addAction === 'function' &&
		window.jQuery
	) {
		window.elementorFrontend.hooks.addAction('frontend/element_ready/g12_business_package_cards.default', function ($scope) {
			init($scope[0]);
		});
	}
}());
