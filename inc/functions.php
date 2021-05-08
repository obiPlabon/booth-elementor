<?php
/**
 * Helper functions.
 */
defined( 'ABSPATH' ) || die();

// echo \Elementor\Plugin::$instance->frontend->get_builder_content_for_display( '2620' );

if (!function_exists('litipay_get_wysiwyg_output')) {
	function litipay_get_wysiwyg_output($meta_key) {
		global $wp_embed;

		$content = $wp_embed->autoembed($meta_key);
		$content = $wp_embed->run_shortcode($content);
		$content = do_shortcode($content);
		$content = wpautop($content);

		return $content;
	}
}

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


// if ( ! function_exists( 'booth_select_contact_form_map' ) ) {
// 	/**
// 	 * Map Contact Form 7 shortcode
// 	 * Hooks on vc_after_init action
// 	 */
// 	function booth_select_contact_form_map() {
// 		vc_add_param('contact-form-7', array(
// 			'type' => 'dropdown',
// 			'heading' => esc_html__('Style', 'booth'),
// 			'param_name' => 'html_class',
// 			'value' => array(
// 				esc_html__('Default', 'booth') => 'default',
// 				esc_html__('Custom Style 1', 'booth') => 'cf7_custom_style_1',
// 				esc_html__('Custom Style 2', 'booth') => 'cf7_custom_style_2',
// 				esc_html__('Custom Style 3', 'booth') => 'cf7_custom_style_3'
// 			),
// 			'description' => esc_html__('You can style each form element individually in Select Options > Contact Form 7', 'booth')
// 		));
// 	}

// 	add_action('vc_after_init', 'booth_select_contact_form_map');
// }

// replace cf7 submit button with our button
remove_action('wpcf7_init', 'wpcf7_add_form_tag_submit');
add_action('wpcf7_init', 'booth_elementor_select_cf7_button');

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
