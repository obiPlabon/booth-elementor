;(function($) {
	'use strict';

	$(window).on('elementor/frontend/init', function() {

		elementorFrontend.hooks.addAction('frontend/element_ready/booth-faq.default', function() {
			qodef.modules.accordions.qodefInitAccordions();
		});

		elementorFrontend.hooks.addAction('frontend/element_ready/booth-countdown.default', function() {
			qodef.modules.countdown.qodefInitCountdown();
		});

		elementorFrontend.hooks.addAction('frontend/element_ready/booth-testimonials.default', function() {
			qodef.modules.common.qodefOwlSlider();
			qodef.modules.common.qodefOnWindowLoad();
		});
	});
}(jQuery));
