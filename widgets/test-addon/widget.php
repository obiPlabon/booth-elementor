<?php
namespace Booth_Elementor\Widget;


class Test_Addon extends Base {


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

		$this->__start_section('test_widget_content', 'Content', 'content');

		$this->add_text_control('test_text','Text Field','Test Text','placeholder');

		$this->add_switcher_control('switcher_test','Hide Button','yes','haa','naa', 'yes');

		$this->__end_section();

    }

    protected function register_style_controls() {

		$this->__start_section('test_widget_style','Widget Style','style');

		$this->add_color_control('text_color','Text Color','',[
			'{{WRAPPER}} .test-text' => 'color: {{VALUE}}',
		]);

		$this->__end_section();

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
