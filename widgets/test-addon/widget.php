<?php
namespace Booth_Elementor\Widget;


class Test_Addon extends Base {

	protected static $widget;

	public function __construct($data = array(), $args = null) {
		parent::__construct($data, $args);
		self::$widget = new Control_Ui($this);
	}
    /**
     * Get widget title.
     *
     */
    public function get_title() {
        return __( 'Test Addon', 'plugin-name' );
    }

	public function get_keywords() {
		return ['test'];
	}



    protected function register_content_controls() {

		self::$widget->__start('test_widget_content', 'Content', 'content');

		self::$widget->text_control('test_text','Text Field','Test Text','placeholder');

		// self::$widget->switcher_control('switcher_test','Hide Button','yes','haa','naa', 'yes');

		self::$widget->__end();

    }

    protected function register_style_controls() {

		self::$widget->__start('test_widget_style','Widget Style','style');

		self::$widget->color_control('text_color','Text Color','',[
			'{{WRAPPER}} .test-text' => 'color: {{VALUE}}',
		]);

		self::$widget->__end();

	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		$text_text = sprintf('
							<h2 class="test-text">%s</h2>',
							esc_html( $settings['test_text'] )
					 );
		echo $text_text;
	}

}
