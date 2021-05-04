;(function($) {
	'use strict';

	$(window).on('elementor/frontend/init', function() {

		elementorFrontend.hooks.addAction( 'frontend/element_ready/booth-faq.default', function() {
			qodef.modules.accordions.qodefOnDocumentReady()
		} );

		console.log('working');

	});
}(jQuery));
