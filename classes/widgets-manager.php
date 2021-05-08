<?php
namespace Booth_Elementor;

defined( 'ABSPATH' ) || die();

class Widgets_Manager {

	public static function init() {
		// Register Widget
		add_action( 'elementor/widgets/widgets_registered', [ __CLASS__, 'register' ] );
	}

	/**
	 * Include widgets files and register them
	 *
	 * @access public
	 */
	public static function register() {
		include_once( BOOTH_ELEMENTOR_DIR_PATH . 'base/widget-base.php' );

		foreach ( glob( BOOTH_ELEMENTOR_DIR_PATH . 'widgets/*', GLOB_ONLYDIR ) as $widget_path ) {
			$widget_key = basename( $widget_path );
			self::register_widget( $widget_key );
		}
	}

	protected static function register_widget( $widget_key ) {
		$widget_file = BOOTH_ELEMENTOR_DIR_PATH . 'widgets/' . $widget_key . '/widget.php';

		if ( is_readable( $widget_file ) ) {
			include_once( $widget_file );

			$widget_class = '\Booth_Elementor\Widget\\' . str_replace( '-', '_', $widget_key );

			if ( class_exists( $widget_class ) ) {
				booth_elementor()->widgets_manager->register_widget_type( new $widget_class );
			}
		}
	}
}
Widgets_Manager::init();
