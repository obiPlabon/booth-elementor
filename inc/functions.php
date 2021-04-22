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
