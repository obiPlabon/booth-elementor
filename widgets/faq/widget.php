<?php
/**
 * Faq widget class.
 */
namespace Booth_Elementor\Widget;

defined( 'ABSPATH' ) || die();

use Elementor\Controls_Manager;
use Elementor\Repeater;

class Faq extends Base {

	public function get_title() {
		return __( 'Faq', 'booth-elementor' );
	}

	public function get_keywords() {
		return ['booth', 'faq', 'accordion', 'toogle'];
	}

	public function get_script_depends() {
		return ['jquery-ui-accordion'];
	}

	protected function register_content_controls() {

		$this->start_controls_section(
			'accordion_content',
			[
				'label' => __( 'Accordion', 'booth-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'style',
			[
				'label'   => __( 'Style', 'booth-elementor' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'accordion',
				'options' => [
					'accordion' => __( 'Accordion', 'booth-elementor' ),
					'toggle'    => __( 'Toggle', 'booth-elementor' ),
				],
			]
		);

		$this->add_control(
			'background_skin',
			[
				'label'   => __( 'Background Skin', 'booth-elementor' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'default',
				'options' => [
					'default' => __( 'Default', 'booth-elementor' ),
					'white'   => __( 'White', 'booth-elementor' ),
				],
			]
		);

		$repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'title',
			[
				'label'       => __( 'Title', 'booth-elementor' ),
				'label_block' => false,
				'type'        => Controls_Manager::TEXT,
				'default'     => __( 'Title', 'booth-elementor' ),
			]
		);

		$repeater->add_control(
			'title_tag',
			[
				'label'   => __( 'Title Tag', 'booth-elementor' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'h5',
				'options' => [
					'h1' => __( 'H1', 'booth-elementor' ),
					'h2' => __( 'H2', 'booth-elementor' ),
					'h2' => __( 'H2', 'booth-elementor' ),
					'h3' => __( 'H3', 'booth-elementor' ),
					'h4' => __( 'H4', 'booth-elementor' ),
					'h5' => __( 'H5', 'booth-elementor' ),
					'h6' => __( 'H6', 'booth-elementor' ),
					'p'  => __( 'p', 'booth-elementor' ),
				],
			]
		);

		$repeater->add_control(
			'desc',
			[
				'label'   => __( 'Content', 'booth-elementor' ),
				'type'    => Controls_Manager::WYSIWYG,
				'default' => __( 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Illum rem corrupti iusto facere animi eaque repellat nobis corporis tenetur alias perferendis non voluptatum, voluptates esse mollitia magnam asperiores fugiat necessitatibus.', 'booth-elementor' ),

			]
		);

		$this->add_control(
			'faq_list',
			[
				'label'         => __( 'Faq Item', 'booth-elementor' ),
				'type'          => Controls_Manager::REPEATER,
				'fields'        => $repeater->get_controls(),
				'show_label'    => false,
				'prevent_empty' => false,
				'default'       => [
					[
						'title' => __( 'Title #1', 'booth-elementor' ),
						'desc'  => __( 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Illum rem corrupti iusto facere animi eaque repellat nobis corporis tenetur alias perferendis non voluptatum, voluptates esse mollitia magnam asperiores fugiat necessitatibus.', 'booth-elementor' ),
					],
					[
						'title' => __( 'Title #2', 'booth-elementor' ),
						'desc'  => __( 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Illum rem corrupti iusto facere animi eaque repellat nobis corporis tenetur alias perferendis non voluptatum, voluptates esse mollitia magnam asperiores fugiat necessitatibus.', 'booth-elementor' ),
					],
				],
				'title_field'   => '{{{ title }}}',
			]
		);

		$this->add_control(
			'custom_class',
			[
				'label'       => __( 'Custom CSS Class', 'booth-elementor' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXT,
				'description' => __( 'Style particular content element differently - add a class name and refer to it in custom CSS', 'booth-elementor' ),
			]
		);

		$this->end_controls_section();

	}

	protected function register_style_controls() {

	}

	protected function render() {
		// return;
		$settings = $this->get_settings_for_display();
		$holder_classes = $this->getHolderClasses( $settings );
		?>
		<div class="qodef-accordion-holder <?php echo esc_attr( $holder_classes ); ?> clearfix">
			<?php foreach ( $settings['faq_list'] as $key => $value ): ?>
				<?php if ( $value['title'] ): ?>
					<<?php echo tag_escape( $value['title_tag'] ); ?> class="qodef-accordion-title">
						<span class="qodef-accordion-mark">
							<span class="qodef_icon_plus icon_plus"></span>
							<span class="qodef_icon_minus icon_close"></span>
						</span>
						<span class="qodef-tab-title"><?php esc_html_e( $value['title'] );?></span>
					</<?php echo tag_escape( $value['title_tag'] ); ?>>
				<?php endif;?>
				<?php if ( $value['desc'] ): ?>
					<div class="qodef-accordion-content">
						<div class="qodef-accordion-content-inner">
							<?php echo $this->parse_text_editor( $value['desc'] ); ?>
						</div>
					</div>
				<?php endif;?>
			<?php endforeach;?>
		</div>
		<?php
}

	/**
	 * @param $params
	 */
	private function getHolderClasses( $params ) {
		$holder_classes = ['qodef-ac-default'];

		$holder_classes[] = !empty( $params['custom_class'] ) ? esc_attr( $params['custom_class'] ) : '';

		$holder_classes[] = $params['style'] == 'toggle' ? 'qodef-toggle' : 'qodef-accordion';

		$holder_classes[] = !empty( $params['background_skin'] ) ? 'qodef-' . esc_attr( $params['background_skin'] ) . '-skin' : '';

		return implode( ' ', $holder_classes );
	}

}
