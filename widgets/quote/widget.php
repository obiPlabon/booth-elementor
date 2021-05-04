<?php
/**
 * Quote widget class.
 */
namespace Booth_Elementor\Widget;

defined('ABSPATH' ) || die();

use Elementor\Controls_Manager;

class Quote extends Base {

	public function get_title() {
		return __( 'Quote', 'booth-elementor' );
	}

	public function get_keywords() {
		return ['booth', 'quote'];
	}

	protected function register_content_controls() {
		$this->start_controls_section(
			'booth_quote_settings_content',
			[
				'label' => __( 'Quote', 'booth-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'skin',
			[
				'label'   => __( 'Skin', 'booth-elementor' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'dark-skin',
				'options' => [
					'dark-skin'      => __( 'Default', 'booth-elementor' ),
					'light-skin' => __( 'Light', 'booth-elementor' ),
				],
				'prefix_class' => 'qodef-',
				// qodef-light-skin
			]
		);

		$this->add_control(
			'text',
			[
				'label' => __( 'Content', 'booth-elementor' ),
				'label_block'            => true,
				'type'  => Controls_Manager::WYSIWYG,
				// 'type'  => Controls_Manager::TEXTAREA,
				'default' => 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aliquam lorem ante, dapibus in, viverra quis, feugiat a, tellus viverra nulla.
				',
			]
		);

		$this->end_controls_section();
	}

	protected function register_style_controls() {

	}

	/**
	 * @return null
	 */
	protected function render() {
		// return;
		$settings = $this->get_settings_for_display();
		if( empty($settings['text']) ){
			return;
		}
		?>
		<blockquote><?php echo $this->parse_text_editor( $settings['text'] ); ?></blockquote>
		<?php
	}

}
