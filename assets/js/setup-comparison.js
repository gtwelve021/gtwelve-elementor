(function () {
	'use strict';

	function initComparison(shell) {
		var viewport;
		var scrollbar;
		var thumb;
		var resizeFrame = null;
		var dragStartX = 0;
		var dragStartScroll = 0;
		var dragging = false;

		if (!shell || shell.dataset.g12SetupComparisonReady === 'true') {
			return;
		}

		viewport = shell.querySelector('[data-g12-setup-comparison-viewport]');
		scrollbar = shell.querySelector('[data-g12-setup-comparison-scrollbar]');
		thumb = shell.querySelector('[data-g12-setup-comparison-thumb]');

		if (!viewport || !scrollbar || !thumb) {
			return;
		}

		shell.dataset.g12SetupComparisonReady = 'true';

		function update() {
			var hasOverflow = viewport.scrollWidth > viewport.clientWidth + 1;
			var trackWidth;
			var thumbWidth;
			var maxThumbTravel;
			var maxScroll;

			shell.classList.toggle('has-horizontal-overflow', hasOverflow);

			if (!hasOverflow) {
				thumb.style.width = '100%';
				thumb.style.transform = 'translate3d(0, 0, 0)';
				resizeFrame = null;
				return;
			}

			trackWidth = scrollbar.clientWidth;
			thumbWidth = Math.max(64, trackWidth * (viewport.clientWidth / viewport.scrollWidth));
			maxThumbTravel = Math.max(0, trackWidth - thumbWidth);
			maxScroll = Math.max(1, viewport.scrollWidth - viewport.clientWidth);

			thumb.style.width = thumbWidth + 'px';
			thumb.style.transform = 'translate3d(' + (viewport.scrollLeft / maxScroll) * maxThumbTravel + 'px, 0, 0)';
			resizeFrame = null;
		}

		function requestUpdate() {
			if (resizeFrame === null) {
				resizeFrame = window.requestAnimationFrame(update);
			}
		}

		function stopDragging() {
			dragging = false;
			thumb.classList.remove('is-dragging');
		}

		viewport.addEventListener('scroll', requestUpdate, { passive: true });

		thumb.addEventListener('pointerdown', function (event) {
			dragging = true;
			dragStartX = event.clientX;
			dragStartScroll = viewport.scrollLeft;
			thumb.classList.add('is-dragging');
			thumb.setPointerCapture(event.pointerId);
			event.preventDefault();
		});

		thumb.addEventListener('pointermove', function (event) {
			var trackTravel;
			var contentTravel;

			if (!dragging) {
				return;
			}

			trackTravel = Math.max(1, scrollbar.clientWidth - thumb.offsetWidth);
			contentTravel = Math.max(0, viewport.scrollWidth - viewport.clientWidth);
			viewport.scrollLeft = dragStartScroll + ((event.clientX - dragStartX) / trackTravel) * contentTravel;
		});

		thumb.addEventListener('pointerup', stopDragging);
		thumb.addEventListener('pointercancel', stopDragging);

		scrollbar.addEventListener('pointerdown', function (event) {
			var rect;
			var ratio;

			if (event.target === thumb) {
				return;
			}

			rect = scrollbar.getBoundingClientRect();
			ratio = Math.max(0, Math.min(1, (event.clientX - rect.left) / rect.width));
			viewport.scrollTo({ left: ratio * (viewport.scrollWidth - viewport.clientWidth), behavior: 'smooth' });
		});

		if (window.ResizeObserver) {
			new ResizeObserver(requestUpdate).observe(viewport);
		} else {
			window.addEventListener('resize', requestUpdate);
		}

		requestUpdate();
	}

	function init(scope) {
		var root = scope && scope.querySelectorAll ? scope : document;

		if (root.matches && root.matches('[data-g12-setup-comparison]')) {
			initComparison(root);
		}

		root.querySelectorAll('[data-g12-setup-comparison]').forEach(initComparison);
	}

	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', function () { init(document); });
	} else {
		init(document);
	}

	if (window.elementorFrontend && window.elementorFrontend.hooks) {
		window.elementorFrontend.hooks.addAction('frontend/element_ready/g12_setup_comparison.default', function ($scope) {
			init($scope[0]);
		});
	}
}());
