(function () {
	'use strict';

	function setCardOpen(card, open) {
		var toggle = card.querySelector('.interactive-tile-carousel__card-toggle');
		var cover = card.querySelector('.interactive-tile-carousel__card-cover');

		card.classList.toggle('interactive-tile-carousel__card--open', open);

		if (toggle) {
			toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
		}

		if (cover) {
			if (open) {
				cover.removeAttribute('tabindex');
			} else {
				cover.setAttribute('tabindex', '-1');
			}
		}
	}

	function smoothScrollTo(element, targetLeft, duration) {
		var startLeft = element.scrollLeft;
		var distance = targetLeft - startLeft;
		var startTime = window.performance.now();
		var maxScroll = Math.max(0, element.scrollWidth - element.clientWidth);
		var target = Math.max(0, Math.min(targetLeft, maxScroll));
		var animationFrame;

		if (element.__tileCarouselScrollFrame) {
			window.cancelAnimationFrame(element.__tileCarouselScrollFrame);
		}

		function easeOutCubic(progress) {
			return 1 - Math.pow(1 - progress, 3);
		}

		function tick(now) {
			var elapsed = now - startTime;
			var progress = Math.min(elapsed / duration, 1);

			element.scrollLeft = startLeft + ((target - startLeft) * easeOutCubic(progress));

			if (progress < 1) {
				animationFrame = window.requestAnimationFrame(tick);
				element.__tileCarouselScrollFrame = animationFrame;
			} else {
				element.scrollLeft = target;
				element.__tileCarouselScrollFrame = null;
			}
		}

		if (Math.abs(distance) < 1 || window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
			element.scrollLeft = target;
			return;
		}

		animationFrame = window.requestAnimationFrame(tick);
		element.__tileCarouselScrollFrame = animationFrame;
	}

	function initCards(root) {
		root.querySelectorAll('.interactive-tile-carousel__card').forEach(function (card) {
			if (card.dataset.tileCarouselCardReady === 'true') {
				return;
			}

			var toggle = card.querySelector('.interactive-tile-carousel__card-toggle');
			card.dataset.tileCarouselCardReady = 'true';

			card.addEventListener('pointerenter', function () {
				setCardOpen(card, true);
			});

			card.addEventListener('pointerleave', function () {
				setCardOpen(card, false);
			});

			card.addEventListener('focusin', function () {
				setCardOpen(card, true);
			});

			card.addEventListener('focusout', function () {
				setCardOpen(card, false);
			});

			if (toggle) {
				toggle.addEventListener('click', function () {
					setCardOpen(card, !card.classList.contains('interactive-tile-carousel__card--open'));
				});
			}
		});
	}

	function initDesktopCarousel(widget) {
		var container = widget.querySelector('.interactive-tile-carousel__desktop-cards');

		if (!container) {
			return;
		}

		if (container.dataset.tileCarouselReady === 'true') {
			ensureDesktopCarouselLayout(container);
			return;
		}

		var isDown = false;
		var isDragging = false;
		var startX = 0;
		var startScroll = 0;
		container.dataset.tileCarouselReady = 'true';

		ensureDesktopCarouselLayout(container);

		function getStep() {
			var card = container.querySelector('.interactive-tile-carousel__card');
			var styles = window.getComputedStyle(container);
			var gap = parseFloat(styles.gap || styles.columnGap) || 0;

			return card ? card.getBoundingClientRect().width + gap : container.clientWidth;
		}

		function canScroll() {
			return container.scrollWidth > container.clientWidth + 4;
		}

		function ensureScrollable() {
			ensureDesktopCarouselLayout(container);
		}

		function getNearestCardOffset() {
			var cards = Array.prototype.slice.call(container.querySelectorAll('.interactive-tile-carousel__card'));
			var scrollLeft = container.scrollLeft;
			var closestOffset = 0;
			var closestDistance = Infinity;

			cards.forEach(function (card) {
				var distance = Math.abs(card.offsetLeft - scrollLeft);

				if (distance < closestDistance) {
					closestDistance = distance;
					closestOffset = card.offsetLeft;
				}
			});

			return closestOffset;
		}

		function snapToNearestCard() {
			if (!canScroll()) {
				return;
			}

			smoothScrollTo(container, getNearestCardOffset(), 420);
		}

		container.addEventListener('pointerdown', function (event) {
			if (!canScroll() || event.button && event.button !== 0) {
				return;
			}

			if (container.__tileCarouselScrollFrame) {
				window.cancelAnimationFrame(container.__tileCarouselScrollFrame);
				container.__tileCarouselScrollFrame = null;
			}

			isDown = true;
			isDragging = false;
			startX = event.clientX;
			startScroll = container.scrollLeft;
			container.classList.add('is-dragging');
			container.setPointerCapture(event.pointerId);
		});

		container.addEventListener('pointermove', function (event) {
			var delta;

			if (!isDown) {
				return;
			}

			delta = event.clientX - startX;

			if (Math.abs(delta) > 4) {
				isDragging = true;
			}

			container.scrollLeft = startScroll - delta;
		});

		container.addEventListener('pointerup', function (event) {
			if (!isDown) {
				return;
			}

			isDown = false;
			container.classList.remove('is-dragging');
			container.releasePointerCapture(event.pointerId);
			snapToNearestCard();
		});

		container.addEventListener('pointercancel', function () {
			isDown = false;
			container.classList.remove('is-dragging');
			snapToNearestCard();
		});

		container.addEventListener('click', function (event) {
			if (isDragging) {
				event.preventDefault();
				event.stopPropagation();
				isDragging = false;
			}
		}, true);

		window.addEventListener('resize', function () {
			ensureScrollable();
			snapToNearestCard();
		});

		ensureScrollable();
	}

	function initMobileGridSlider(widget) {
		var viewport = widget.querySelector('.interactive-tile-carousel__mobile-viewport');
		var slider = widget.querySelector('.interactive-tile-carousel__slider');
		var updating = false;

		if (!viewport || !slider || slider.dataset.tileCarouselSliderReady === 'true') {
			return;
		}

		slider.dataset.tileCarouselSliderReady = 'true';

		function getMaxScroll() {
			return Math.max(0, viewport.scrollWidth - viewport.clientWidth);
		}

		function syncSlider() {
			var maxScroll = getMaxScroll();
			var ratio = maxScroll ? viewport.scrollLeft / maxScroll : 0;

			if (updating) {
				return;
			}

			slider.value = Math.round(ratio * Number(slider.max || 500));
		}

		function syncViewport() {
			var maxScroll = getMaxScroll();
			var maxValue = Number(slider.max || 500);
			var ratio = maxValue ? Number(slider.value) / maxValue : 0;

			updating = true;
			smoothScrollTo(viewport, maxScroll * ratio, 260);
			window.setTimeout(function () {
				updating = false;
			}, 280);
		}

		slider.addEventListener('input', syncViewport);
		viewport.addEventListener('scroll', function () {
			window.requestAnimationFrame(syncSlider);
		});
		window.addEventListener('resize', syncSlider);
		syncSlider();
	}

	function initSeeMore(root) {
		root.querySelectorAll('[data-expandable-content]').forEach(function (widget) {
			var button = widget.querySelector('[data-expandable-content-toggle]');
			var content = widget.querySelector('[data-expandable-content-panel]');
			var text = widget.querySelector('[data-open-text][data-close-text]');
			var reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
			var transitionId = 0;

			if (!button || !content || widget.dataset.expandableContentReady === 'true') {
				return;
			}

			widget.dataset.expandableContentReady = 'true';

			function setButtonText(isOpen) {
				var openText = text ? text.getAttribute('data-open-text') : '';
				var closeText = text ? text.getAttribute('data-close-text') : '';

				if (text) {
					text.textContent = isOpen ? closeText : openText;
				}
			}

			function finishPanelState(isOpen) {
				content.style.height = isOpen ? 'auto' : '0px';
				content.setAttribute('aria-hidden', isOpen ? 'false' : 'true');

				if (!isOpen) {
					content.setAttribute('hidden', '');
				}
			}

			function setPanelOpen(isOpen) {
				var startHeight;
				var endHeight;
				var currentTransitionId = transitionId + 1;

				transitionId = currentTransitionId;

				widget.classList.toggle('is-open', isOpen);
				button.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
				setButtonText(isOpen);

				if (reduceMotion) {
					if (isOpen) {
						content.removeAttribute('hidden');
					}
					finishPanelState(isOpen);
					return;
				}

				content.removeAttribute('hidden');
				content.style.overflow = 'hidden';
				content.style.height = isOpen ? '0px' : content.scrollHeight + 'px';

				startHeight = content.offsetHeight;
				endHeight = isOpen ? content.scrollHeight : 0;
				content.style.height = startHeight + 'px';

				window.requestAnimationFrame(function () {
					content.style.height = endHeight + 'px';
				});

				content.addEventListener('transitionend', function onTransitionEnd(event) {
					if (event.target !== content || event.propertyName !== 'height') {
						return;
					}

					content.removeEventListener('transitionend', onTransitionEnd);
					if (transitionId !== currentTransitionId) {
						return;
					}
					finishPanelState(isOpen);
				});
			}

			if (widget.classList.contains('is-open')) {
				content.removeAttribute('hidden');
				content.style.height = 'auto';
				content.setAttribute('aria-hidden', 'false');
				setButtonText(true);
			} else {
				content.setAttribute('hidden', '');
				content.style.height = '0px';
				content.setAttribute('aria-hidden', 'true');
				setButtonText(false);
			}

			button.addEventListener('click', function () {
				var isOpen = !widget.classList.contains('is-open');

				setPanelOpen(isOpen);
			});
		});
	}

	function initReferralCalculators(root) {
		root.querySelectorAll('[data-referral-earnings-calculator]').forEach(function (widget) {
			if (widget.dataset.referralCalculatorReady === 'true') {
				updateReferralCalculator(widget);
				return;
			}

			widget.dataset.referralCalculatorReady = 'true';

			widget.querySelectorAll('[data-referral-range]').forEach(function (range) {
				range.addEventListener('input', function () {
					updateReferralCalculator(widget);
				});
			});

			updateReferralCalculator(widget);
		});
	}

	function initReviewGrids(root) {
		root.querySelectorAll('[data-review-grid]').forEach(function (widget) {
			var moreButton = widget.querySelector('[data-review-grid-more]');

			if (!moreButton || moreButton.dataset.reviewGridMoreReady === 'true') {
				return;
			}

			moreButton.dataset.reviewGridMoreReady = 'true';
			moreButton.addEventListener('click', function () {
				var expanded = widget.classList.toggle('is-expanded');
				var label = expanded ? moreButton.getAttribute('data-less-label') : moreButton.getAttribute('data-more-label');

				if (label) {
					moreButton.textContent = label;
				}
			});
		});
	}

	function initTeamFeatureStrips(root) {
		root.querySelectorAll('[data-team-feature-strip]').forEach(function (widget) {
			var viewport = widget.querySelector('[data-team-feature-viewport]');
			var prevButton = widget.querySelector('[data-team-feature-prev]');
			var nextButton = widget.querySelector('[data-team-feature-next]');
			var slides = Array.prototype.slice.call(widget.querySelectorAll('[data-team-feature-slide]'));
			var current = 0;

			if (!viewport || !slides.length || widget.dataset.teamFeatureReady === 'true') {
				return;
			}

			widget.dataset.teamFeatureReady = 'true';

			function getSlideLeft(index) {
				var slide = slides[index];
				var slideRect;
				var viewportRect;

				if (!slide) {
					return 0;
				}

				slideRect = slide.getBoundingClientRect();
				viewportRect = viewport.getBoundingClientRect();

				return viewport.scrollLeft + slideRect.left - viewportRect.left;
			}

			function setActive(index) {
				current = (index + slides.length) % slides.length;
				smoothScrollTo(viewport, getSlideLeft(current), 260);
			}

			if (prevButton) {
				prevButton.addEventListener('click', function (event) {
					event.preventDefault();
					event.stopPropagation();
					setActive(current - 1);
				});
			}

			if (nextButton) {
				nextButton.addEventListener('click', function (event) {
					event.preventDefault();
					event.stopPropagation();
					setActive(current + 1);
				});
			}

			viewport.addEventListener('scroll', function () {
				window.requestAnimationFrame(function () {
					var closestIndex = 0;
					var closestDistance = Infinity;

				slides.forEach(function (slide, index) {
					var distance = Math.abs(getSlideLeft(index) - viewport.scrollLeft);

						if (distance < closestDistance) {
							closestDistance = distance;
							closestIndex = index;
						}
					});

					current = closestIndex;
				});
			});

			window.addEventListener('resize', function () {
				setActive(current);
			});
		});
	}

	function formatReferralNumber(number) {
		return Math.round(number).toLocaleString('en-US');
	}

	function updateReferralSlider(range) {
		var min = Number(range.min || 0);
		var max = Number(range.max || 100);
		var value = Number(range.value || 0);
		var percent = max > min ? ((value - min) / (max - min)) * 100 : 0;
		var accent = window.getComputedStyle(range).getPropertyValue('--referral-calc-accent') || '#d6a456';

		range.style.background = 'linear-gradient(to right, ' + accent + ' 0%, ' + accent + ' ' + percent + '%, #e5e7eb ' + percent + '%, #e5e7eb 100%)';
	}

	function updateReferralCalculator(widget) {
		var monthlyTotal = 0;
		var referralTotal = 0;

		widget.querySelectorAll('.referral-earnings-calculator__service').forEach(function (service) {
			var range = service.querySelector('[data-referral-range]');
			var countNode = service.querySelector('[data-service-count]');
			var totalNode = service.querySelector('[data-service-total]');
			var rate = Number(service.getAttribute('data-rate') || 0);
			var count = range ? Number(range.value || 0) : 0;
			var serviceTotal = count * rate;

			referralTotal += count;
			monthlyTotal += serviceTotal;

			if (countNode) {
				countNode.textContent = formatReferralNumber(count);
			}

			if (totalNode) {
				totalNode.textContent = formatReferralNumber(serviceTotal);
			}

			if (range) {
				updateReferralSlider(range);
			}
		});

		var average = referralTotal ? monthlyTotal / referralTotal : 0;
		var cta = widget.querySelector('[data-referral-cta]');
		var ctaTemplate = widget.getAttribute('data-cta-template') || '';

		setReferralText(widget, '[data-monthly-total]', monthlyTotal);
		setReferralText(widget, '[data-total-referrals]', referralTotal);
		setReferralText(widget, '[data-annual-total]', monthlyTotal * 12);
		setReferralText(widget, '[data-average-referral]', average);

		if (cta && ctaTemplate) {
			cta.textContent = ctaTemplate.replace('{monthly}', formatReferralNumber(monthlyTotal));
		}
	}

	function setReferralText(widget, selector, value) {
		var node = widget.querySelector(selector);

		if (node) {
			node.textContent = formatReferralNumber(value);
		}
	}

	function ensureDesktopCarouselLayout(container) {
		container.style.display = 'flex';
		container.style.flexWrap = 'nowrap';
		container.style.overflowX = 'auto';
		container.style.overflowY = 'hidden';
	}

	function init(scope) {
		var root = scope && scope.querySelectorAll ? scope : document;

		root.querySelectorAll('[data-interactive-tile-carousel]').forEach(function (widget) {
			initCards(widget);
			initDesktopCarousel(widget);
			initMobileGridSlider(widget);
		});

		initSeeMore(root);
		initReferralCalculators(root);
		initReviewGrids(root);
		initTeamFeatureStrips(root);
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
		window.elementorFrontend.hooks.addAction('frontend/element_ready/g12_tile_grid_v2.default', function ($scope) {
			init($scope[0]);
		});

		window.elementorFrontend.hooks.addAction('frontend/element_ready/g12_see_more.default', function ($scope) {
			init($scope[0]);
		});

		window.elementorFrontend.hooks.addAction('frontend/element_ready/g12_referral_earnings_calculator.default', function ($scope) {
			init($scope[0]);
		});

		window.elementorFrontend.hooks.addAction('frontend/element_ready/g12_review_grid.default', function ($scope) {
			init($scope[0]);
		});

		window.elementorFrontend.hooks.addAction('frontend/element_ready/g12_team_feature_strip.default', function ($scope) {
			init($scope[0]);
		});
	}
}());
