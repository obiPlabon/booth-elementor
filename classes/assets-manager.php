<?php
namespace Booth_Elementor;

defined( 'ABSPATH' ) || die();

class Assets_Manager {

	public static function init() {
		// Register Widget Styles & Scripts
		add_action( 'elementor/frontend/after_enqueue_styles', [ __CLASS__, 'enqueue_styles' ] );
		add_action( 'elementor/frontend/before_enqueue_scripts', [ __CLASS__, 'enqueue_scripts' ] );

		// Elementor preview scripts and styles
		add_action( 'elementor/preview/enqueue_scripts', [ __CLASS__, 'enqueue_preview_scripts' ] );
	}

	public static function enqueue_preview_scripts() {
		wp_enqueue_script(
			'booth-elementor-preview',
			BOOTH_ELEMENTOR_ASSETS . 'js/booth-elementor-preview.js',
			[],
			BOOTH_ELEMENTOR_VERSION,
			true
		);
	}

	/**
	 * Widget Style.
	 */
	public static function enqueue_styles() {
		wp_enqueue_style(
			'booth-elementor',
			BOOTH_ELEMENTOR_ASSETS . 'css/booth-elementor.css',
			null,
			BOOTH_ELEMENTOR_VERSION
		);
	}

	/**
	 * Widget Script.
	 */
	public static function enqueue_scripts() {
		wp_enqueue_script(
			'booth-elementor',
			BOOTH_ELEMENTOR_ASSETS . 'js/booth-elementor.js',
			[ 'jquery' ],
			BOOTH_ELEMENTOR_VERSION,
			true
		);

		/* wp_enqueue_script( 'booth-jquery-plugin',
			BOOTH_ELEMENTOR_ASSETS . '/vendor/js/jquery.plugin.js',
			array( 'jquery' ),
			BOOTH_ELEMENTOR_VERSION,
			true
		);
		wp_enqueue_script( 'booth-countdown',
			BOOTH_ELEMENTOR_ASSETS . '/vendor/js/jquery.countdown.min.js',
			array( 'jquery' ),
			BOOTH_ELEMENTOR_VERSION,
			true
		); */

		//Localize scripts
		wp_localize_script(
			'booth-elementor',
			'BoothElementorLocalize', [
				'ajax_url' => admin_url( 'admin-ajax.php' ),
				'nonce'    => wp_create_nonce( 'booth_elementor_nonce' ),
			]
		);
	}
}
Assets_Manager::init();
