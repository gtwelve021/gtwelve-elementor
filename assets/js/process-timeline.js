(function () {
	'use strict';

	function initTimeline(widget) {
		var rail;
		var progress;
		var items;
		var frame = null;

		if (!widget || widget.dataset.g12ProcessTimelineReady === 'true') {
			return;
		}

		rail = widget.querySelector('.g12-process-timeline__rail');
		progress = widget.querySelector('[data-g12-timeline-progress]');
		items = Array.prototype.slice.call(widget.querySelectorAll('[data-g12-timeline-item]'));

		if (!rail || !progress || !items.length) {
			return;
		}

		widget.dataset.g12ProcessTimelineReady = 'true';

		function update() {
			var viewportMarker = window.innerHeight * 0.55;
			var railRect = rail.getBoundingClientRect();
			var atPageEnd = window.scrollY + window.innerHeight >= document.documentElement.scrollHeight - 2;
			var height = atPageEnd ? railRect.height : Math.max(0, Math.min(railRect.height, viewportMarker - railRect.top));

			progress.style.height = height + 'px';
			items.forEach(function (item) {
				var node = item.querySelector('.g12-process-timeline__node');
				var nodeRect = node ? node.getBoundingClientRect() : item.getBoundingClientRect();

				item.classList.toggle('is-active', atPageEnd || nodeRect.top + (nodeRect.height / 2) <= viewportMarker);
			});

			frame = null;
		}

		function requestUpdate() {
			if (frame === null) {
				frame = window.requestAnimationFrame(update);
			}
		}

		window.addEventListener('scroll', requestUpdate, { passive: true });
		window.addEventListener('resize', requestUpdate);

		if (window.ResizeObserver) {
			new ResizeObserver(requestUpdate).observe(widget);
		}

		requestUpdate();
	}

	function init(scope) {
		var root = scope && scope.querySelectorAll ? scope : document;

		if (root.matches && root.matches('[data-g12-process-timeline]')) {
			initTimeline(root);
		}

		root.querySelectorAll('[data-g12-process-timeline]').forEach(initTimeline);
	}

	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', function () { init(document); });
	} else {
		init(document);
	}

	if (window.elementorFrontend && window.elementorFrontend.hooks) {
		window.elementorFrontend.hooks.addAction('frontend/element_ready/g12_process_timeline.default', function ($scope) {
			init($scope[0]);
		});
	}
}());
