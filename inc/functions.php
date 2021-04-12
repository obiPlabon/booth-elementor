<?php


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

function booth_elementor() {
	return \Elementor\Plugin::instance();
}
