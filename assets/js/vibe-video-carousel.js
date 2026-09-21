( function () {
	function registerPanoramaEffect() {
		if ( window.G12VibePanoramaEffect ) {
			return window.G12VibePanoramaEffect;
		}

		window.G12VibePanoramaEffect = function ( params ) {
			var swiper = params.swiper;
			var extendParams = params.extendParams;
			var on = params.on;

			extendParams( {
				panoramaEffect: {
					depth: 200,
					rotate: 30
				}
			} );

			on( 'beforeInit', function () {
				if ( swiper.params.effect !== 'panorama' ) {
					return;
				}

				swiper.classNames.push( swiper.params.containerModifierClass + 'panorama' );
				swiper.classNames.push( swiper.params.containerModifierClass + '3d' );

				var settings = {
					watchSlidesProgress: true
				};

				Object.assign( swiper.params, settings );
				Object.assign( swiper.originalParams, settings );
			} );

			on( 'progress', function () {
				if ( swiper.params.effect !== 'panorama' ) {
					return;
				}

				var sizes = swiper.slidesSizesGrid;
				var depth = swiper.params.panoramaEffect.depth || 200;
				var rotate = swiper.params.panoramaEffect.rotate || 30;
				var rotateHalf = rotate * Math.PI / 180 / 2;
				var progressFactor = 1 / ( 180 / rotate );

				swiper.slides.forEach( function ( slide, index ) {
					var progress = slide.progress;
					var width = sizes[ index ];
					var adjusted = progress + ( swiper.params.centeredSlides ? 0 : 0.5 * ( swiper.params.slidesPerView - 1 ) );
					var curve = 1 - Math.cos( adjusted * progressFactor * Math.PI );
					var translate = adjusted * ( width / 3 ) * curve + 'px';
					var rotation = adjusted * rotate;
					var z = 0.5 * width / Math.sin( rotateHalf ) * curve - depth + 'px';

					if ( swiper.params.direction === 'horizontal' ) {
						slide.style.transform = 'translateX(' + translate + ') translateZ(' + z + ') rotateY(' + rotation + 'deg)';
					} else {
						slide.style.transform = 'translateY(' + translate + ') translateZ(' + z + ') rotateX(' + ( -rotation ) + 'deg)';
					}
				} );
			} );

			on( 'setTransition', function ( swiperInstance, duration ) {
				if ( swiper.params.effect !== 'panorama' ) {
					return;
				}

				swiper.slides.forEach( function ( slide ) {
					slide.style.transitionDuration = duration + 'ms';
				} );
			} );
		};

		return window.G12VibePanoramaEffect;
	}

	function getActiveSlide( swiper ) {
		if ( ! swiper || ! swiper.slides || ! swiper.slides[ swiper.activeIndex ] ) {
			return null;
		}

		return swiper.slides[ swiper.activeIndex ];
	}

	function getActiveVideo( swiper ) {
		var activeSlide = getActiveSlide( swiper );

		return activeSlide ? activeSlide.querySelector( '.g12-vibe-video-media' ) : null;
	}

	function loadVideo( video ) {
		var source;

		if ( ! video || video.dataset.g12VideoLoaded === '1' ) {
			return;
		}

		source = video.querySelector( 'source[data-src]' );

		if ( source ) {
			source.src = source.dataset.src;
			video.load();
		}

		video.dataset.g12VideoLoaded = '1';
	}

	function primeVideoFrame( video ) {
		if ( ! video || video.dataset.whFramePrimed === '1' ) {
			return;
		}

		loadVideo( video );
		video.dataset.whFramePrimed = '1';

		video.addEventListener( 'loadedmetadata', function () {
			if ( video.dataset.whFrameSeeked === '1' ) {
				return;
			}

			video.dataset.whFrameSeeked = '1';

			try {
				if ( Number.isFinite( video.duration ) && video.duration > 0.2 ) {
					video.currentTime = 0.1;
				}
			} catch ( error ) {}
		}, { once: true } );

		video.addEventListener( 'loadeddata', function () {
			var slide = video.closest( '.swiper-slide' );

			if ( slide && ! slide.classList.contains( 'swiper-slide-active' ) ) {
				video.muted = true;
				video.setAttribute( 'muted', 'muted' );
				video.pause();
			}
		} );
	}

	function loadCarouselVideos( swiper ) {
		if ( ! swiper || ! swiper.slides ) {
			return;
		}

		swiper.slides.forEach( function ( slide ) {
			var video = slide.querySelector( '.g12-vibe-video-media' );

			if ( video ) {
				primeVideoFrame( video );
				video.muted = true;
				video.setAttribute( 'muted', 'muted' );

				if ( ! slide.classList.contains( 'swiper-slide-active' ) ) {
					video.pause();
				}
			}
		} );
	}

	function shouldEnableAudio( video ) {
		var slide;
		var carousel;

		if ( ! video ) {
			return false;
		}

		carousel = video.closest( '.g12-vibe-video-swiper' );
		slide = video.closest( '.swiper-slide' );
		return video.dataset.g12Audio === '1' && carousel && carousel.dataset.g12VibeMuted !== '1' && slide && slide.classList.contains( 'swiper-slide-active' );
	}

	function syncVideoAudio( video ) {
		var enableAudio = shouldEnableAudio( video );

		video.muted = ! enableAudio;

		if ( enableAudio ) {
			video.removeAttribute( 'muted' );
		} else {
			video.setAttribute( 'muted', 'muted' );
		}
	}

	function updateMuteButtons( carousel ) {
		var isMuted;

		if ( ! carousel ) {
			return;
		}

		isMuted = carousel.dataset.g12VibeMuted === '1';

		carousel.querySelectorAll( '.g12-vibe-video-mute' ).forEach( function ( button ) {
			var slide = button.closest( '.swiper-slide' );
			var activeSlide = carousel.querySelector( '.swiper-slide-active' );
			var mutedIcon = button.querySelector( '.g12-vibe-video-icon-muted' );
			var unmutedIcon = button.querySelector( '.g12-vibe-video-icon-unmuted' );
			var isActive = activeSlide ? slide === activeSlide : slide === carousel.querySelector( '.g12-vibe-video-slide' );

			button.hidden = ! isActive;
			button.setAttribute( 'aria-pressed', isMuted ? 'false' : 'true' );
			button.setAttribute( 'aria-label', isMuted ? 'Unmute video' : 'Mute video' );

			if ( mutedIcon ) {
				mutedIcon.hidden = ! isMuted;
			}

			if ( unmutedIcon ) {
				unmutedIcon.hidden = isMuted;
			}
		} );
	}

	function bindMuteControl( carousel ) {
		if ( ! carousel || carousel.dataset.g12VibeMuteBound === '1' ) {
			return;
		}

		carousel.dataset.g12VibeMuteBound = '1';

		if ( typeof carousel.dataset.g12VibeMuted === 'undefined' ) {
			carousel.dataset.g12VibeMuted = '1';
		}

		carousel.addEventListener( 'click', function ( event ) {
			var muteButton = event.target.closest( '.g12-vibe-video-mute' );
			var video;
			var isMuted;

			if ( ! muteButton || ! carousel.contains( muteButton ) ) {
				return;
			}

			event.preventDefault();
			event.stopPropagation();

			carousel.dataset.g12VibeMuted = carousel.dataset.g12VibeMuted === '1' ? '0' : '1';
			isMuted = carousel.dataset.g12VibeMuted === '1';

			if ( carousel.g12VibeSwiper ) {
				playOnlyActiveVideo( carousel.g12VibeSwiper );
				return;
			}

			video = muteButton.closest( '.g12-vibe-video-slide' ).querySelector( '.g12-vibe-video-media' );

			if ( video ) {
				loadVideo( video );
				video.muted = isMuted;

				if ( isMuted ) {
					video.setAttribute( 'muted', 'muted' );
				} else {
					video.removeAttribute( 'muted' );
				}

				video.play().catch( function () {} );
			}

			updateMuteButtons( carousel );
		} );
	}

	function syncCarouselAudio( swiper ) {
		var activeSlide = getActiveSlide( swiper );
		var carousel = swiper && swiper.el ? swiper.el : null;

		if ( ! swiper || ! swiper.slides ) {
			return;
		}

		swiper.slides.forEach( function ( slide ) {
			var video = slide.querySelector( '.g12-vibe-video-media' );

			if ( video ) {
				primeVideoFrame( video );

				if ( slide !== activeSlide ) {
					video.muted = true;
					video.setAttribute( 'muted', 'muted' );
				}

				syncVideoAudio( video );
			}
		} );

		updateMuteButtons( carousel );
	}

	function playVideo( video ) {
		if ( ! video ) {
			return;
		}

		loadVideo( video );
		syncVideoAudio( video );

		var playPromise = video.play();

		if ( playPromise && typeof playPromise.catch === 'function' ) {
			playPromise.catch( function () {
				if ( shouldEnableAudio( video ) ) {
					video.muted = true;
					video.setAttribute( 'muted', 'muted' );
					video.play().catch( function () {} );
				}
			} );
		}
	}

	function stopNonActiveVideos( swiper ) {
		var activeSlide = getActiveSlide( swiper );

		swiper.slides.forEach( function ( slide ) {
			var video = slide.querySelector( '.g12-vibe-video-media' );

			if ( video && slide !== activeSlide ) {
				primeVideoFrame( video );
				video.muted = true;
				video.setAttribute( 'muted', 'muted' );
				video.pause();
			}
		} );
	}

	function playOnlyActiveVideo( swiper ) {
		var activeVideo;

		if ( ! swiper || ! swiper.slides ) {
			return;
		}

		loadCarouselVideos( swiper );
		stopNonActiveVideos( swiper );
		syncCarouselAudio( swiper );

		activeVideo = getActiveVideo( swiper );

		if ( activeVideo ) {
			playVideo( activeVideo );
		}
	}

	function initCarousel( carousel ) {
		var pagination;
		var options;
		var SwiperFactory;
		var result;

		if ( ! carousel ) {
			return;
		}

		bindMuteControl( carousel );

		if ( carousel.dataset.g12VibeReady === '1' || carousel.dataset.g12VibeReady === 'pending' ) {
			return;
		}

		carousel.dataset.g12VibeReady = 'pending';
		carousel.dataset.g12VibeMuted = '1';
		pagination = carousel.querySelector( '.g12-vibe-video-pagination' );

		options = {
			modules: [ registerPanoramaEffect() ],
			effect: 'panorama',
			slidesPerView: 1,
			spaceBetween: 20,
			loop: true,
			loopAdditionalSlides: 1,
			centeredSlides: true,
			grabCursor: true,
			touchStartPreventDefault: false,
			preventClicks: false,
			preventClicksPropagation: false,
			pagination: {
				el: pagination,
				clickable: true,
				dynamicBullets: true,
				dynamicMainBullets: 1
			},
			panoramaEffect: {
				depth: -150,
				rotate: -45
			},
			breakpoints: {
				480: {
					slidesPerView: 1,
					spaceBetween: 8,
					panoramaEffect: {
						rotate: -35,
						depth: -150
					}
				},
				640: {
					slidesPerView: 1,
					spaceBetween: 12,
					panoramaEffect: {
						rotate: -30,
						depth: -150
					}
				},
				1024: {
					slidesPerView: 3,
					spaceBetween: 15,
					panoramaEffect: {
						rotate: -10,
						depth: -100
					}
				},
				1200: {
					slidesPerView: 3,
					spaceBetween: 20,
					panoramaEffect: {
						rotate: -10,
						depth: -100
					}
				}
			},
			on: {
				init: function () {
					playOnlyActiveVideo( this );
				},
				slideChange: function () {
					playOnlyActiveVideo( this );
				},
				slideChangeTransitionEnd: function () {
					playOnlyActiveVideo( this );
				}
			}
		};

		function finishInit( swiperInstance ) {
			if ( ! swiperInstance ) {
				carousel.dataset.g12VibeReady = '0';
				return;
			}

			carousel.dataset.g12VibeReady = '1';
			carousel.g12VibeSwiper = swiperInstance;

			window.requestAnimationFrame( function () {
				playOnlyActiveVideo( swiperInstance );
			} );

			window.setTimeout( function () {
				playOnlyActiveVideo( swiperInstance );
			}, 350 );

			carousel.addEventListener( 'pointerdown', function () {
				playOnlyActiveVideo( swiperInstance );
			} );

			carousel.addEventListener( 'pointerup', function () {
				window.setTimeout( function () {
					playOnlyActiveVideo( swiperInstance );
				}, 150 );
			} );

			if ( 'IntersectionObserver' in window ) {
				var videoObserver = new IntersectionObserver( function ( entries ) {
					entries.forEach( function ( entry ) {
						if ( entry.isIntersecting ) {
							primeVideoFrame( entry.target );
							playOnlyActiveVideo( swiperInstance );
						} else {
							entry.target.muted = true;
							entry.target.setAttribute( 'muted', 'muted' );
							entry.target.pause();
						}
					} );
				}, { threshold: 0.1 } );

				carousel.querySelectorAll( '.lazy-vibe-video, .g12-vibe-video-media' ).forEach( function ( video ) {
					videoObserver.observe( video );
				} );
			}
		}

		function failInit() {
			carousel.dataset.g12VibeReady = '0';
		}

		SwiperFactory = window.elementorFrontend && window.elementorFrontend.utils && window.elementorFrontend.utils.swiper;

		if ( SwiperFactory ) {
			try {
				result = new SwiperFactory( carousel, options );

				if ( result && typeof result.then === 'function' ) {
					result.then( finishInit ).catch( failInit );
				} else {
					finishInit( result );
				}
			} catch ( error ) {
				failInit();
			}
		} else if ( window.Swiper ) {
			try {
				finishInit( new window.Swiper( carousel, options ) );
			} catch ( error ) {
				failInit();
			}
		} else {
			failInit();
		}
	}

	function initAllCarousels() {
		document.querySelectorAll( '.g12-vibe-video-swiper' ).forEach( initCarousel );
	}

	if ( document.readyState === 'loading' ) {
		document.addEventListener( 'DOMContentLoaded', initAllCarousels );
	} else {
		initAllCarousels();
	}

	if ( window.elementorFrontend && window.elementorFrontend.hooks ) {
		window.elementorFrontend.hooks.addAction( 'frontend/element_ready/g12_vibe_video_carousel.default', function ( scope ) {
			scope[0].querySelectorAll( '.g12-vibe-video-swiper' ).forEach( function ( carousel ) {
				initCarousel( carousel );
			} );
		} );
	}
}() );
