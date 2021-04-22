(function($) {
	'use strict';
	var button = {};
	qodef.modules.button = button;
	button.qodefButton = qodefButton;
	button.qodefOnDocumentReady = qodefOnDocumentReady;
	$(document).ready(qodefOnDocumentReady);
	/*
	 All functions to be called on $(document).ready() should be in this function
	 */
	function qodefOnDocumentReady() {
		qodefButton().init();
	}
	/**
	 * Button object that initializes whole button functionality
	 * @type {Function}
	 */
	var qodefButton = function() {
		//all buttons on the page
		var buttons = $('.qodef-btn');
		/**
		 * Initializes button hover color
		 * @param button current button
		 */
		var buttonHoverColor = function(button) {
			if(typeof button.data('hover-color') !== 'undefined') {
				var changeButtonColor = function(event) {
					event.data.button.css('color', event.data.color);
				};
				var originalColor = button.css('color');
				var hoverColor = button.data('hover-color');
				button.on('mouseenter', { button: button, color: hoverColor }, changeButtonColor);
				button.on('mouseleave', { button: button, color: originalColor }, changeButtonColor);
			}
		};
		/**
		 * Initializes button hover background color
		 * @param button current button
		 */
		var buttonHoverBgColor = function(button) {
			if(typeof button.data('hover-bg-color') !== 'undefined' && !button.hasClass('qodef-btn-stripe')) {
				var changeButtonBg = function(event) {
					event.data.button.css('background-color', event.data.color);
				};
				var originalBgColor = button.css('background-color');
				var hoverBgColor = button.data('hover-bg-color');
				button.on('mouseenter', { button: button, color: hoverBgColor }, changeButtonBg);
				button.on('mouseleave', { button: button, color: originalBgColor }, changeButtonBg);
			}
			
			var iconHolder = button.find('.qodef-btn-icon-holder');
			
			if(typeof iconHolder.data('icon-hover-bg-color') !== 'undefined' && !button.hasClass('qodef-btn-stripe')) {
				var originalIconBgColor = iconHolder.css('background-color');
				var hoverIconBgColor = iconHolder.data('icon-hover-bg-color');
				
				
				button.mouseenter(function() {
					iconHolder.css({
						"background-color": hoverIconBgColor,
						transition: 'background-color 0.2s ease-in-out'
					});
				});
				
				button.mouseleave(function() {
					iconHolder.css({
						"background-color": originalIconBgColor,
						transition: 'background-color 0.2s ease-in-out'
					});
				});
			}
			
		};
		/**
		 * Initializes button border color
		 * @param button
		 */
		var buttonHoverBorderColor = function(button) {
			if(typeof button.data('hover-border-color') !== 'undefined') {
				var changeBorderColor = function(event) {
					event.data.button.css('border-color', event.data.color);
				};
				var originalBorderColor = button.css('borderTopColor'); //take one of the four sides
				var hoverBorderColor = button.data('hover-border-color');
				button.on('mouseenter', { button: button, color: hoverBorderColor }, changeBorderColor);
				button.on('mouseleave', { button: button, color: originalBorderColor }, changeBorderColor);
			}
		};

		var buttonStripe = function() {
			var buttons = $('.qodef-btn-solid, .qodef-btn-outline');
			buttons.addClass('qodef-btn-stripe');
		}

		var buttonStripeAnimation = function(button) {
			if (button.hasClass('qodef-btn-stripe')) {
				button.append('<div class="qodef-btn-bg-holder"></div>')
				if(typeof button.data('hover-bg-color') !== 'undefined') {
					var hoverBgColor = button.data('hover-bg-color');
					button.find('.qodef-btn-bg-holder').css('background-color', hoverBgColor);
				}
			}
		}

		return {
			init: function() {
				if(buttons.length) {
					buttonStripe();

					buttons.each(function() {
						buttonStripeAnimation($(this));
						buttonHoverColor($(this));
						buttonHoverBgColor($(this));
						buttonHoverBorderColor($(this));
					});
				}
			}
		};
	};
})(jQuery);