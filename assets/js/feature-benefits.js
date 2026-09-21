(function () {
	'use strict';

	function initSlider(root) {
		if (!root || root.dataset.g12FeatureBenefitsReady === 'true') return;
		root.dataset.g12FeatureBenefitsReady = 'true';

		function currentGap() {
			return Math.max(0, parseFloat(window.getComputedStyle(root).getPropertyValue('--g12-feature-benefits-gap')) || 0);
		}

		var options = {
			slidesPerView: 1,
			spaceBetween: currentGap(),
			speed: Math.max(100, Number(root.dataset.speed) || 500),
			loop: root.dataset.loop === 'yes' && root.querySelectorAll('.swiper-slide').length > 3,
			grabCursor: true,
			watchOverflow: true,
			breakpoints: { 768: { slidesPerView: 2 }, 1025: { slidesPerView: 3 } }
		};

		if (root.querySelector('.g12-feature-benefits__pagination')) {
			options.pagination = { el: root.querySelector('.g12-feature-benefits__pagination'), clickable: true };
		}

		if (root.dataset.autoplay === 'yes') {
			options.autoplay = {
				delay: Math.max(1000, Number(root.dataset.delay) || 3500),
				disableOnInteraction: false,
				pauseOnMouseEnter: root.dataset.pauseHover === 'yes'
			};
		}

		var SwiperFactory = window.elementorFrontend && window.elementorFrontend.utils && window.elementorFrontend.utils.swiper;
		if (SwiperFactory) {
			var result = new SwiperFactory(root, options);
			if (result && typeof result.then === 'function') {
				result.then(function (instance) {
					window.addEventListener('resize', function () { instance.params.spaceBetween = currentGap(); instance.update(); });
				}).catch(function () { root.dataset.g12FeatureBenefitsReady = 'false'; });
			}
		} else if (window.Swiper) {
			var instance = new window.Swiper(root, options);
			window.addEventListener('resize', function () { instance.params.spaceBetween = currentGap(); instance.update(); });
		} else {
			root.dataset.g12FeatureBenefitsReady = 'false';
		}
	}

	function boot(scope) {
		(scope || document).querySelectorAll('[data-g12-feature-benefits]').forEach(initSlider);
	}

	if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', function () { boot(document); });
	else boot(document);

	if (window.elementorFrontend && window.elementorFrontend.hooks && window.jQuery) {
		window.elementorFrontend.hooks.addAction('frontend/element_ready/g12_feature_benefits.default', function ($scope) { boot($scope[0]); });
	}
}());
