<?php
/**
 * Helper functions.
 */
defined( 'ABSPATH' ) || die();

/**
 * Get elementor instance.
 *
 * @return object \Elementor\Plugin
 */
function booth_elementor() {
	return \Elementor\Plugin::instance();
}

/**
 * Check booth theme is activated or not.
 *
 * @return bool
 */
function is_booth_active() {
	$theme = wp_get_theme(); // gets the current theme
	return ( 'Booth' == $theme->name || 'Booth' == $theme->parent_theme );
}

// replace cf7 submit button with our button
remove_action( 'wpcf7_init', 'wpcf7_add_form_tag_submit' );
add_action( 'wpcf7_init', 'booth_elementor_select_cf7_button' );

if ( ! function_exists( 'booth_elementor_select_cf7_button' ) ) {
	function booth_elementor_select_cf7_button() {
		wpcf7_add_form_tag( 'submit', 'booth_elementor_select_cf7_button_handler' );
	}
}

if ( ! function_exists( 'booth_elementor_select_cf7_button_handler' ) ) {
	function booth_elementor_select_cf7_button_handler( $tag ) {
		$tag = new WPCF7_FormTag( $tag );
		$class = wpcf7_form_controls_class( $tag->type );

		$atts = array();
		$atts['class'] = $tag->get_class_option( $class );
		$atts['class'] .= ' qodef-btn qodef-btn-medium qodef-btn-solid';
		$atts['id'] = $tag->get_id_option();
		$atts['tabindex'] = $tag->get_option( 'tabindex', 'int', true );

		$value = isset( $tag->values[0] ) ? $tag->values[0] : '';
		if ( empty( $value ) ) {
			$value = esc_html__( 'Send', 'booth-elementor' );
		}

		$atts['type'] = 'submit';
		$atts = wpcf7_format_atts( $atts );

		$html = sprintf( '<button %1$s><span class="qodef-btn-text">%2$s</span></button>', $atts, $value );

		return $html;
	}
}

if ( ! function_exists( 'booth_elementor_button_widget_custom_styles' ) ) {

	function booth_elementor_button_widget_custom_styles() {
		$first_main_color = booth_select_options()->getOptionValue( 'first_color' );
		if ( ! empty( $first_main_color ) ) {
			echo booth_select_dynamic_css(
				'.elementor-element .elementor-button',
				array(
					'background-color' => $first_main_color
				)
			);
		}

		$second_main_color = booth_select_options()->getOptionValue( 'second_color' );
		if ( ! empty( $second_main_color ) ) {
			echo booth_select_dynamic_css(
				'.elementor-element .elementor-button:hover, .elementor-element .elementor-button:focus, .elementor-element .elementor-button:active',
				array(
					'background-color' => $second_main_color
				)
			);
		}
	}

	add_action( 'booth_select_action_style_dynamic', 'booth_elementor_button_widget_custom_styles' );
}
