<?php
namespace Booth_Elementor\Widget;

use Elementor\Widget_Base;


defined( 'ABSPATH' ) || die();

abstract class Base extends Widget_Base {

	// protected static $widget;

	// public function __construct($data = array(), $args = null) {
	// 	parent::__construct($data, $args);
	// 	self::$widget = new Control_Ui($this);
	// }

	public function get_name() {
        /**
         * Automatically generate widget name from class
         *
         * Card will be card
         * Blog_Card will be blog-card
         */
        $name = str_replace( strtolower(__NAMESPACE__), '', strtolower($this->get_class_name()) );
        $name = str_replace( '_', '-', $name );
        $name = ltrim( $name, '\\' );
        return 'booth-' . $name;
    }

	/**
     * Get widget icon.
     *
     * Retrieve oEmbed widget icon.
     *
     * @access public
     *
     * @return string Widget icon.
     */
    public function get_icon() {
        return 'eicon-circle';
    }

    /**
     * Get widget categories.
	 *
     * @access public
     *
     * @return array Widget categories.
     */
    public function get_categories() {
        return [ 'booth_elementor_category' ];
    }

    /**
     * Override from addon to add custom wrapper class.
     *
     * @return string
     */
    protected function get_custom_wrapper_class() {
        return '';
    }

    /**
     * Overriding default function to add custom html class.
     *
     * @return string
     */
    public function get_html_wrapper_class() {
        $html_class = parent::get_html_wrapper_class();
        $html_class .= ' booth-elementor';
        $html_class .= ' ' . $this->get_name();
        $html_class .= ' ' . $this->get_custom_wrapper_class();
        return rtrim( $html_class );
    }

    /**
     * Register widget controls
     */
    protected function _register_controls() {
        do_action( 'booth_elementor_start_register_controls', $this );

        $this->register_content_controls();

        $this->register_style_controls();

        do_action( 'booth_elementor_end_register_controls', $this );
	}

    /**
     * Register content controls
     *
     * @return void
     */
    abstract protected function register_content_controls();

    /**
     * Register style controls
     *
     * @return void
     */
    abstract protected function register_style_controls();

	protected function parse_text_editor( $content ) {
		/** This filter is documented in wp-includes/widgets/class-wp-widget-text.php */
		$content = apply_filters( 'widget_text', $content, $this->get_settings() );

		$content = shortcode_unautop( $content );
		$content = do_shortcode( $content );
		$content = wptexturize( $content );

		if ( $GLOBALS['wp_embed'] instanceof \WP_Embed ) {
			$content = $GLOBALS['wp_embed']->autoembed( $content );
		}

		return $content;
	}

}
