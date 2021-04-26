<?php
namespace Booth_Elementor;

class Widgets_Manager {


	public static function init() {

		// Register Widget
		add_action( 'elementor/widgets/widgets_registered', [ __CLASS__, 'register' ] );
	}


	/**
	 * Get the widgets map
	 *
	 * @return array
	 */
	public static function __widgets_map() {

		$map = [
			'test-addon',
			'faq',
			'countdown',
			'team-list',
			'testimonials',
			'event-list',
			'pricing-table',
			'button',
			'quote',
			'info-table',
			'call-to-action',
        ];

		return apply_filters( 'booth_elementor__widget_map', $map );
    }

	/**
	 * Include widgets files and register them
	 *
	 * @access public
	 */
	public static function register() {

        include_once( BOOTH_ELEMENTOR_DIR_PATH . 'base/control_ui.php' );
        include_once( BOOTH_ELEMENTOR_DIR_PATH . 'base/widget-base.php' );

		// foreach ( self::__widgets_map() as $widget_key => $data ) {}
		foreach ( self::__widgets_map() as $widget_key ) {

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
