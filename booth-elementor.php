<?php
/*
Plugin Name: Booth Elementor
Plugin URI: https://example.com
Description: Booth Elementor plugin is a support plugin for Elementor WordPress plugin.
Author: booth
Version: 0.0.1
Author URI: booth-elementor
Text Domain: booth-elementor
 */
namespace Booth_Elementor;

defined( 'ABSPATH' ) || die();

define( 'BOOTH_ELEMENTOR_VERSION', '0.0.1' );
define( 'BOOTH_ELEMENTOR_MINIMUM_ELEMENTOR_VERSION', '3.0.0' );
define( 'BOOTH_ELEMENTOR_MINIMUM_PHP_VERSION', '5.4' );
define( 'BOOTH_ELEMENTOR_DIR_PATH', plugin_dir_path( __FILE__ ) );
define( 'BOOTH_ELEMENTOR_DIR_URL', plugin_dir_url( __FILE__ ) );
define( 'BOOTH_ELEMENTOR_ASSETS', trailingslashit( BOOTH_ELEMENTOR_DIR_URL . 'assets' ) );

/**
 * Main Booth Elementor Class
 *
 * The main class that initiates and runs the plugin.
 *
 *
 */
final class Booth_Elementor {

	/**
	 * Instance
	 *
	 */
	private static $_instance = null;

	/**
	 * Instance of this class
	 *
	 */
	public static function instance() {

		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}

		return self::$_instance;

	}

	/**
	 * Constructor
	 *
	 */
	public function __construct() {
		add_action( 'plugins_loaded', [$this, 'init'] );

	}

	/**
	 * Initialize the plugin
	 *
	 */
	public function init() {

		// Check if Elementor installed and activated
		if ( !did_action( 'elementor/loaded' ) ) {
			add_action( 'admin_notices', [$this, 'elementor_missing_notice'] );

			return;
		}

		// Check for required Elementor version
		if ( !version_compare( ELEMENTOR_VERSION, BOOTH_ELEMENTOR_MINIMUM_ELEMENTOR_VERSION, '>=' ) ) {
			add_action( 'admin_notices', [$this, 'minimum_elementor_version_notice'] );

			return;
		}

		// Check for required PHP version
		if ( version_compare( PHP_VERSION, BOOTH_ELEMENTOR_MINIMUM_PHP_VERSION, '<' ) ) {
			add_action( 'admin_notices', [$this, 'ha_required_php_version_missing_notice'] );

			return;
		}

		if ( !$this->is_booth_active() ) {
			add_action( 'admin_notices', [$this, 'theme_missing_notice'] );

			return;
		}

		// Lets roock
		if ( did_action( 'elementor/loaded' ) ) {
			$this->lets_go();
		}
	}

	/**
	 * Lets Goooooo
	 *
	 * @access public
	 */
	public function lets_go() {

		add_action( 'init', [$this, 'i18n'] );

		// Register category
		add_action( 'elementor/elements/categories_registered', [$this, 'register_category'] );

		$this->include_files();

		// Remove tgmpa admin notice
		add_action( 'admin_init', function() {
			global $tgmpa;

			remove_action( 'admin_notices', array( $tgmpa, 'notices' ) );
		} );
	}

	/**
	 * Load Textdomain
	 *
	 */
	public function i18n() {

		load_plugin_textdomain( 'booth-elementor' );

	}

	/**
	 * Include files
	 *
	 */
	public function include_files() {
		include_once BOOTH_ELEMENTOR_DIR_PATH . 'inc/functions.php';

		include_once BOOTH_ELEMENTOR_DIR_PATH . 'classes/widgets-manager.php';
		include_once BOOTH_ELEMENTOR_DIR_PATH . 'classes/assets-manager.php';
	}

	/**
	 * Add category
	 *
	 */
	public function register_category() {
		booth_elementor()->elements_manager->add_category(
			'booth_elementor_category',
			[
				'title' => __( 'Booth Elementor', 'happy-addons-pro' ),
				'icon'  => 'fa fa-smile-o',
			]
		);
	}

	/**
	 * Admin notice for Elementor installed or activated.
	 *
	 */
	public function elementor_missing_notice() {

		if ( isset( $_GET['activate'] ) ) {
			unset( $_GET['activate'] );
		}

		$notice = sprintf(
			esc_html__( '"%1$s" requires "%2$s" to be installed and activated.', 'booth-elementor' ),
			'<strong>' . esc_html__( 'Booth Elementor', 'booth-elementor' ) . '</strong>',
			'<strong>' . esc_html__( 'Elementor', 'booth-elementor' ) . '</strong>'
		);

		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $notice );

	}

	/**
	 * check theme booth active or not.
	 *
	 */
	public function is_booth_active() {
		$theme = wp_get_theme(); // gets the current theme
		if ( 'Booth' == $theme->name || ( !empty( $theme->parent_theme ) && 'Booth' == $theme->parent_theme ) ) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * Admin notice for minimum required Elementor version.
	 *
	 */
	public function minimum_elementor_version_notice() {

		if ( isset( $_GET['activate'] ) ) {
			unset( $_GET['activate'] );
		}

		$notice = sprintf(
			esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'booth-elementor' ),
			'<strong>' . esc_html__( 'Booth Elementor', 'booth-elementor' ) . '</strong>',
			'<strong>' . esc_html__( 'Elementor', 'booth-elementor' ) . '</strong>',
			BOOTH_ELEMENTOR_MINIMUM_ELEMENTOR_VERSION
		);

		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $notice );

	}

	/**
	 * Admin notice for minimum required php version.
	 *
	 */
	function php_version_missing_notice() {
		$notice = sprintf(
			/* translators: 1: Plugin name 2: PHP 3: Required PHP version */
			esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'booth-elementor' ),
			'<strong>' . esc_html__( 'Booth Elementor', 'booth-elementor' ) . '</strong>',
			'<strong>' . esc_html__( 'PHP', 'booth-elementor' ) . '</strong>',
			BOOTH_ELEMENTOR_MINIMUM_PHP_VERSION
		);

		printf( '<div class="notice notice-warning is-dismissible"><p style="padding: 13px 0">%1$s</p></div>', $notice );
	}

	/**
	 * Admin notice for install booth theme.
	 *
	 */
	function theme_missing_notice() {

		$notice = sprintf(
			esc_html__( '"%1$s" requires "%2$s" to be installed and activated.', 'booth-elementor' ),
			'<strong>' . esc_html__( 'Booth Elementor', 'booth-elementor' ) . '</strong>',
			'<strong>' . esc_html__( 'Booth Theme', 'booth-elementor' ) . '</strong>'
		);

		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $notice );
	}

}

Booth_Elementor::instance();
