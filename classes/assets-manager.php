<?php
namespace Booth_Elementor;

class Assets_Manager {


	public static function init() {


		// add_action( 'wp_enqueue_scripts', [ __CLASS__, 'enqueue_scripts' ] );

		// Register Widget Styles & Scripts
		add_action( 'elementor/frontend/after_enqueue_styles', [ __CLASS__, 'enqueue_styles' ] );
		add_action( 'elementor/frontend/before_enqueue_scripts', [ __CLASS__, 'enqueue_scripts' ] );
	}

	/**
	 * Widget Style.
	 *
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
	 *
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
