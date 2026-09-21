(function () {
	'use strict';

	function initVerticalSlider(widget) {
		var viewport;
		var track;
		var originalSlides;
		var allSlides;
		var dots;
		var current = 0;
		var timer = null;
		var pointerStartY = null;
		var reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
		var autoplay;
		var autoplayDelay;
		var pauseOnHover;
		var interactionPaused = false;
		var resizeFrame = null;

		if (!widget || widget.dataset.g12QuoteSliderReady === 'true') {
			return;
		}

		viewport = widget.querySelector('[data-g12-quote-viewport]');
		track = widget.querySelector('[data-g12-quote-track]');
		originalSlides = Array.prototype.slice.call(widget.querySelectorAll('[data-g12-quote-slide]'));
		dots = Array.prototype.slice.call(widget.querySelectorAll('[data-g12-quote-dot]'));

		if (!viewport || !track || !originalSlides.length) {
			return;
		}

		widget.dataset.g12QuoteSliderReady = 'true';
		autoplay = widget.getAttribute('data-autoplay') === 'yes';
		autoplayDelay = Math.max(1000, Number(widget.getAttribute('data-autoplay-delay')) || 3500);
		pauseOnHover = widget.getAttribute('data-pause-hover') === 'yes';

		if (originalSlides.length > 1) {
			originalSlides.forEach(function (slide) {
				var clone = slide.cloneNode(true);

				clone.setAttribute('data-g12-quote-clone', '');
				clone.setAttribute('aria-hidden', 'true');
				track.appendChild(clone);
			});
		}

		allSlides = Array.prototype.slice.call(track.querySelectorAll('[data-g12-quote-slide]'));

		function getVisibleCount() {
			var value = parseInt(window.getComputedStyle(widget).getPropertyValue('--g12-quote-cards-visible'), 10);

			if (!value || value < 1) {
				value = 1;
			}

			return Math.min(value, originalSlides.length);
		}

		function setTrackPosition(index, immediate) {
			var activeSlide = allSlides[index];
			var previousTransition;

			if (!activeSlide) {
				return;
			}

			if (immediate || reduceMotion) {
				previousTransition = track.style.transition;
				track.style.transition = 'none';
			}

			track.style.transform = 'translate3d(0, -' + activeSlide.offsetTop + 'px, 0)';

			if (immediate || reduceMotion) {
				window.requestAnimationFrame(function () {
					track.style.transition = previousTransition || '';
				});
			}
		}

		function updateViewportHeight() {
			var visibleCount = getVisibleCount();
			var firstSlide = allSlides[current];
			var lastSlide = allSlides[current + visibleCount - 1];
			var height;

			if (!firstSlide || !lastSlide) {
				return;
			}

			height = (lastSlide.offsetTop + lastSlide.offsetHeight) - firstSlide.offsetTop;

			if (height > 0) {
				viewport.style.height = height + 'px';
			}
		}

		function updateAccessibility() {
			var visibleCount = getVisibleCount();
			var logicalCurrent = current % originalSlides.length;

			allSlides.forEach(function (slide, slideIndex) {
				var visible = slideIndex >= current && slideIndex < current + visibleCount;

				slide.setAttribute('aria-hidden', visible ? 'false' : 'true');
			});

			dots.forEach(function (dot, dotIndex) {
				var active = dotIndex === logicalCurrent;

				dot.classList.toggle('is-active', active);
				dot.setAttribute('aria-current', active ? 'true' : 'false');
			});
		}

		function setActive(index, immediate) {
			current = index;
			setTrackPosition(current, immediate);
			updateViewportHeight();
			updateAccessibility();
		}

		function next() {
			setActive(current + 1, false);
		}

		function previous() {
			if (current === 0 && originalSlides.length > 1) {
				setActive(originalSlides.length, true);
				window.requestAnimationFrame(function () {
					setActive(originalSlides.length - 1, false);
				});
				return;
			}

			setActive(Math.max(0, current - 1), false);
		}

		function measure() {
			if (resizeFrame) {
				window.cancelAnimationFrame(resizeFrame);
			}

			resizeFrame = window.requestAnimationFrame(function () {
				updateViewportHeight();
				setTrackPosition(current, true);
				updateAccessibility();
				resizeFrame = null;
			});
		}

		function stopAutoplay() {
			if (timer) {
				window.clearInterval(timer);
				timer = null;
			}
		}

		function startAutoplay() {
			stopAutoplay();

			if (!autoplay || reduceMotion || interactionPaused || originalSlides.length < 2) {
				return;
			}

			timer = window.setInterval(next, autoplayDelay);
		}

		track.addEventListener('transitionend', function (event) {
			if (event.target !== track || event.propertyName !== 'transform') {
				return;
			}

			if (current >= originalSlides.length) {
				setActive(0, true);
			}
		});

		dots.forEach(function (dot) {
			dot.addEventListener('click', function () {
				setActive(Number(dot.getAttribute('data-g12-quote-dot')) || 0, false);
				startAutoplay();
			});
		});

		if (pauseOnHover) {
			widget.addEventListener('mouseenter', function () {
				interactionPaused = true;
				stopAutoplay();
			});
			widget.addEventListener('mouseleave', function () {
				interactionPaused = false;
				startAutoplay();
			});
			widget.addEventListener('focusin', function () {
				interactionPaused = true;
				stopAutoplay();
			});
			widget.addEventListener('focusout', function (event) {
				if (event.relatedTarget && widget.contains(event.relatedTarget)) {
					return;
				}

				interactionPaused = false;
				startAutoplay();
			});
		}

		viewport.addEventListener('pointerdown', function (event) {
			pointerStartY = event.clientY;
		});

		viewport.addEventListener('pointerup', function (event) {
			var distance;

			if (pointerStartY === null) {
				return;
			}

			distance = event.clientY - pointerStartY;
			pointerStartY = null;

			if (Math.abs(distance) < 30) {
				return;
			}

			if (distance < 0) {
				next();
			} else {
				previous();
			}

			startAutoplay();
		});

		viewport.addEventListener('pointercancel', function () {
			pointerStartY = null;
		});

		if (window.ResizeObserver) {
			new ResizeObserver(measure).observe(widget);
		} else {
			window.addEventListener('resize', measure);
		}

		setActive(0, true);
		startAutoplay();
	}

	function init(scope) {
		var root = scope && scope.querySelectorAll ? scope : document;

		root.querySelectorAll('[data-g12-testimonial-vertical-slider]').forEach(initVerticalSlider);
	}

	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', function () {
			init(document);
		});
	} else {
		init(document);
	}

	if (
		window.elementorFrontend &&
		window.elementorFrontend.hooks &&
		typeof window.elementorFrontend.hooks.addAction === 'function' &&
		window.jQuery
	) {
		window.elementorFrontend.hooks.addAction('frontend/element_ready/g12_testimonial_quote_cards.default', function ($scope) {
			init($scope[0]);
		});
	}
}());
