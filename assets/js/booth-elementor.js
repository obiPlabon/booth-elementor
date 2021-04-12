;(function ($) {
	"use strict";

	$(window).on("elementor/frontend/init", function() {

		/* var LpCarouselSettings = elementorModules.frontend.handlers.Base.extend({
			onInit: function () {
				elementorModules.frontend.handlers.Base.prototype.onInit.apply(this, arguments);
				this.run();
			},

			getDefaultSettings: function() {
				return {
					selectors: {
						container: '.lpjs-slick'
					},
					arrows: true,
					dots: false,
					checkVisible: false,
					infinite: true,
					slidesToShow: 1,
					rows: 0,
					prevArrow: '<button type="button" class="slick-prev"><i class="fa fa-chevron-left"></i></button>',
					nextArrow: '<button type="button" class="slick-next"><i class="fa fa-chevron-right"></i></button>',
					// appendArrows:  '.lpjs-slick',
				}
			},

			getDefaultElements: function () {
				var selectors = this.getSettings('selectors');
				//console.log(selectors);
				return {
					$container: this.findElement(selectors.container)
				};
			},

			onElementChange: function() {
				this.elements.$container.slick('unslick');
				this.run();
			},

			getReadySettings: function() {
				var settings = {
					infinite: !! this.getElementSettings('loop'),
					autoplay: !! this.getElementSettings('autoplay'),
					autoplaySpeed: this.getElementSettings('autoplay_speed'),
					speed: this.getElementSettings('animation_speed'),
					centerMode: !! this.getElementSettings('center'),
					vertical: !! this.getElementSettings('vertical'),
					slidesToScroll: 1,
				};

				if( 'arrow' === this.getElementSettings('navigation') && this.getSettings('appendArrows') ){
					settings.appendArrows =  this.getSettings('appendArrows');
				}

				if( this.getSettings('adaptiveHeight') ){
					settings.adaptiveHeight =  this.getSettings('adaptiveHeight');
				}

				switch (this.getElementSettings('navigation')) {
					case 'arrow':
						settings.arrows = true;
						break;
					case 'dots':
						settings.dots = true;
						break;
					case 'both':
						settings.arrows = true;
						settings.dots = true;
						break;
				}

				settings.slidesToShow = parseInt( this.getElementSettings('slides_to_show') ) || 1;
				settings.responsive = [
					{
						breakpoint: elementorFrontend.config.breakpoints.lg,
						settings: {
							slidesToShow: (parseInt(this.getElementSettings('slides_to_show_tablet')) || settings.slidesToShow),
						}
					},
					{
						breakpoint: elementorFrontend.config.breakpoints.md,
						settings: {
							slidesToShow: (parseInt(this.getElementSettings('slides_to_show_mobile')) || parseInt(this.getElementSettings('slides_to_show_tablet'))) || settings.slidesToShow,
						}
					}
				];

				// console.log(this.getSettings('appendArrows'));
				// console.log(settings);

				var $readySettings = $.extend({}, this.getDefaultSettings(), settings);

				//console.log($readySettings);
				return $readySettings;
			},

			run: function() {
				this.elements.$container.slick(this.getReadySettings());
			}
		}); */

		// Slider
		/* elementorFrontend.hooks.addAction(
			'frontend/element_ready/lp-carousel.default',
			function ($scope) {
				elementorFrontend.elementsHandler.addHandler(LpCarouselSettings, {
					$element: $scope,
					selectors: {
						container: '.lp-tst-carousel-container',
					},
					appendArrows:  $scope.find('.lp-tst-carousel-nav'),
					adaptiveHeight:  true,
				});
			}
		); */

		/* elementorFrontend.hooks.addAction(
			'frontend/element_ready/lp-carousel-2.default',
			function ($scope) {
				elementorFrontend.elementsHandler.addHandler(LpCarouselSettings, {
					$element: $scope,
					selectors: {
						container: '.lp-tst-carousel-2-container',
					},
					appendArrows:  $scope.find('.lp-tst-carousel-2-nav'),
					adaptiveHeight:  true,
				});
			}
		); */


		// elementorFrontend.hooks.addAction(
		// 	"frontend/element_ready/litipay-addons.default",
		// 	Canvas
		// );
	});

})(jQuery);
