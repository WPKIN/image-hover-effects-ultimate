(function ($) {
	'use strict';

	function initOxiSwiper($scope) {
		$scope.find('.oxi-addons-container[data-swiper-config]').each(function () {
			var $container = $(this);
			var config = $container.data('swiper-config');

			if (!config || typeof config !== 'object') {
				return;
			}

			var $swiperRow = $container.find('.oxi-addons-row');
			if (!$swiperRow.length) {
				return;
			}

			// Wait for Swiper to be available
			if (typeof Swiper === 'undefined') {
				setTimeout(function () {
					initOxiSwiper($scope);
				}, 100);
				return;
			}

			// Destroy existing instance
			if ($swiperRow[0].swiper) {
				try {
					$swiperRow[0].swiper.destroy(true, true);
				} catch (e) {}
			}

			// Add swiper-slide class
			$swiperRow.find('.oxi-image-hover-style')
				.addClass('swiper-slide');

			var rtl = config._rtl || '';
			var pauseOnHover = config._pauseOnHover || false;
			var autoplayDelay = config.autoplay ? (config.autoplay.delay || 99999) : 99999;

			var swiperConfig = {
				direction: config.direction || 'horizontal',
				speed: config.speed || 500,
				effect: config.effect || 'slide',
				centeredSlides: config.centeredSlides || false,
				grabCursor: config.grabCursor || false,
				autoHeight: config.autoHeight || false,
				loop: config.loop || false,
				observer: true,
				observeParents: true,
				cubeEffect: config.cubeEffect || { shadow: false, slideShadows: false, shadowOffset: 0, shadowScale: 0 },
				autoplay: { delay: autoplayDelay },
				pagination: config.pagination || {},
				navigation: config.navigation || {},
				breakpoints: config.breakpoints || {}
			};

			if (rtl === 'rtl') {
				$swiperRow.attr('dir', 'rtl');
			} else {
				$swiperRow.removeAttr('dir');
			}

			try {
				var swiper = new Swiper($swiperRow[0], swiperConfig);

				if (autoplayDelay === 0) {
					swiper.autoplay.stop();
				}

				if (pauseOnHover) {
					$swiperRow
						.off('mouseenter.oxiCarousel mouseleave.oxiCarousel')
						.on('mouseenter.oxiCarousel', function () {
							swiper.autoplay.stop();
						})
						.on('mouseleave.oxiCarousel', function () {
							swiper.autoplay.start();
						});
				}
			} catch (e) {
				console.error('Swiper init error:', e);
			}
		});
	}

	// Initialize on document ready
	$(document).ready(function () {
		initOxiSwiper($('body'));
	});

	// Initialize on Elementor widget ready
	$(window).on('elementor/frontend/init', function () {
		elementorFrontend.hooks.addAction(
			'frontend/element_ready/iheu_image_hover/default',
			initOxiSwiper
		);
	});

})(jQuery);
