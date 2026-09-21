(function () {
	'use strict';

	function init(scope) {
		var root = scope && scope.querySelectorAll ? scope : document;

		root.querySelectorAll('[data-g12-video-slider]').forEach(function (widget) {
			initVideoSlider(widget);
		});
	}

	function initVideoSlider(widget) {
		var slider = widget.querySelector('.g12-video-slider-widget__slider');

		if (!slider || slider.dataset.videoSliderReady === 'true') {
			return;
		}

		var slides = Array.prototype.slice.call(slider.querySelectorAll('.g12-video-slider-widget__slide'));
		var dots = Array.prototype.slice.call(slider.querySelectorAll('.g12-video-slider-widget__dot'));
		var prevButton = slider.querySelector('.g12-video-slider-widget__nav--prev');
		var nextButton = slider.querySelector('.g12-video-slider-widget__nav--next');
		var autoplayDelay = parseInt(slider.getAttribute('data-autoplay'), 10) || 6000;
		var hasMultipleSlides = slides.length > 1;
		var current = slides.findIndex(function (slide) {
			return slide.classList.contains('is-active');
		});
		var autoplayId = null;
		var isVideoPlaying = false;

		if (!slides.length) {
			return;
		}

		slider.dataset.videoSliderReady = 'true';

		if (current < 0) {
			current = 0;
		}

		function applySlideStates() {
			slides.forEach(function (slide, index) {
				var video;

				slide.classList.remove('is-active', 'is-next', 'is-next-2', 'is-next-3');

				if (index === current) {
					slide.classList.add('is-active');
					return;
				}

				slide.classList.remove('is-playing');
				video = slide.querySelector('video');
				if (video) {
					safePause(video);
					video.muted = true;
					try {
						video.currentTime = 0;
					} catch (error) {
						/* ignore */
					}
				}
			});

			if (hasMultipleSlides) {
				slides[(current + 1) % slides.length].classList.add('is-next');

				if (slides.length > 2) {
					slides[(current + 2) % slides.length].classList.add('is-next-2');
				}

				if (slides.length > 3) {
					slides[(current + 3) % slides.length].classList.add('is-next-3');
				}
			}

			dots.forEach(function (dot, index) {
				dot.classList.toggle('is-active', index === current);
			});
		}

		function setActive(nextIndex) {
			if (nextIndex === current || nextIndex < 0 || nextIndex >= slides.length) {
				return;
			}

			current = nextIndex;
			applySlideStates();
		}

		function goNext() {
			setActive((current + 1) % slides.length);
		}

		function goPrev() {
			setActive((current - 1 + slides.length) % slides.length);
		}

		function startAutoplay() {
			if (!hasMultipleSlides || isVideoPlaying) {
				return;
			}

			stopAutoplay();
			autoplayId = window.setInterval(goNext, autoplayDelay);
		}

		function stopAutoplay() {
			if (autoplayId) {
				window.clearInterval(autoplayId);
				autoplayId = null;
			}
		}

		if (prevButton) {
			prevButton.addEventListener('click', function () {
				goPrev();
				if (!isVideoPlaying) {
					startAutoplay();
				}
			});
		}

		if (nextButton) {
			nextButton.addEventListener('click', function () {
				goNext();
				if (!isVideoPlaying) {
					startAutoplay();
				}
			});
		}

		dots.forEach(function (dot) {
			dot.addEventListener('click', function () {
				var target = parseInt(dot.getAttribute('data-slide'), 10);

				if (!Number.isNaN(target)) {
					setActive(target);
					if (!isVideoPlaying) {
						startAutoplay();
					}
				}
			});
		});

		slider.addEventListener('mouseenter', stopAutoplay);
		slider.addEventListener('mouseleave', function () {
			if (!isVideoPlaying) {
				startAutoplay();
			}
		});

		widget.addEventListener('click', function (event) {
			var button = event.target.closest('.g12-video-slider-widget__play');
			var slide;
			var video;
			var isPlaying;
			var playPromise;

			if (!button || !slider.contains(button)) {
				return;
			}

			slide = button.closest('.g12-video-slider-widget__slide');
			video = slide ? slide.querySelector('video') : null;
			if (!video) {
				return;
			}

			isPlaying = slide.classList.contains('is-playing') && !video.paused;

			if (isPlaying) {
				safePause(video);
				video.muted = true;
				slide.classList.remove('is-playing');
				button.setAttribute('aria-label', button.getAttribute('data-play-label') || 'Play video');
				isVideoPlaying = false;
				startAutoplay();
				return;
			}

			stopAutoplay();
			video.muted = false;
			slide.classList.add('is-playing');
			playPromise = video.play();

			if (playPromise && typeof playPromise.catch === 'function') {
				playPromise.catch(function () {
					slide.classList.remove('is-playing');
					isVideoPlaying = false;
				});
			}

			button.setAttribute('aria-label', button.getAttribute('data-pause-label') || 'Pause video');
			isVideoPlaying = true;
		});

		slides.forEach(function (slide) {
			var video = slide.querySelector('video');

			if (!video) {
				return;
			}

			video.addEventListener('ended', function () {
				var button;

				if (!slide.classList.contains('is-active')) {
					return;
				}

				slide.classList.remove('is-playing');
				video.muted = true;
				try {
					video.currentTime = 0;
				} catch (error) {
					/* ignore */
				}

				button = slide.querySelector('.g12-video-slider-widget__play');
				if (button) {
					button.setAttribute('aria-label', button.getAttribute('data-play-label') || 'Play video');
				}

				isVideoPlaying = false;
				goNext();
				startAutoplay();
			});
		});

		applySlideStates();
		startAutoplay();
	}

	function safePause(video) {
		try {
			video.pause();
		} catch (error) {
			/* ignore */
		}
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
		window.elementorFrontend.hooks.addAction('frontend/element_ready/g12_video_slider.default', function ($scope) {
			init($scope[0]);
		});
	}
}());
