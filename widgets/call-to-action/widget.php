<?php
/**
 * Call to action widget class.
 */
namespace Booth_Elementor\Widget;

defined( 'ABSPATH' ) || die();

use Elementor\Controls_Manager;

class Call_To_Action extends Base {

	/**
	 * Get widget title.
	 */
	public function get_title() {
		return __( 'Call To Action', 'booth-elementor' );
	}

	public function get_keywords() {
		return array( 'booth', 'call-to-action', 'call', 'cta' );
	}


    protected function register_content_controls() {

        $this->__register_cta_content_controls();
        $this->__register_cta_button_controls();

    }

    protected function __register_cta_content_controls() {
		$this->start_controls_section(
			'booth_cta_content',
			[
				'label' => __( 'Call To Action', 'booth-elementor' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'background_image',
			[
				'label' => __( 'Bakcground Image', 'booth-elementor' ),
				'type' => Controls_Manager::MEDIA,
				'description' => esc_html__( 'Upload an image for Call to Action background', 'booth-elementor' ),
			]
		);

		$this->add_control(
			'content_in_grid',
			[
				'label' => __( 'Set Content In Grid', 'booth-elementor' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'no',
				'options' => booth_select_get_yes_no_select_array( false ),
			]
		);

		$this->add_control(
			'alignment',
			[
				'label' => __( 'Alignment', 'booth-elementor' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'center',
				'options' =>  [
					'left'  => __( 'Left', 'booth-elementor' ),
					'center'  => __( 'Center', 'booth-elementor' ),
					'right'  => __( 'Right', 'booth-elementor' ),
					'button_right'  => __( 'Text - Left, Buttton - Right', 'booth-elementor' ) ,
				],
			]
		);

		$this->add_control(
			'text_in_box',
			[
				'label' => __( 'Set Text in Box', 'booth-elementor' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'yes',
				'options' => booth_select_get_yes_no_select_array( false ),
			]
		);

		$this->add_control(
			'text_box_color',
			[
				'label' => __( 'Text Box Color', 'booth-elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#000000',
				'condition' => [
                    'text_in_box' => 'yes',
                ],
			]
		);

		$this->add_control(
			'content',
			[
				'label' => __( 'Content', 'booth-elementor' ),
				'type' => Controls_Manager::WYSIWYG,
				'default' => 'I am test text for Call to Action shortcode content',

			]
		);

		$this->add_control(
			'custom_class',
			[
				'label' => __( 'Custom CSS Class', 'booth-elementor' ),
				'label_block'=>true,
				'type' => Controls_Manager::TEXT,
				'description' => __( 'Style particular content element differently - add a class name and refer to it in custom CSS', 'booth-elementor' ),
			]
		);

        $this->end_controls_section();

	}

    protected function __register_cta_button_controls() {
		$this->start_controls_section(
			'booth_cta_button_content',
			[
				'label' => __( 'Button', 'booth-elementor' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'button_text',
			[
				'label' => __( 'Button Text', 'booth-elementor' ),
				'type' => Controls_Manager::TEXT,
				'default' => 'Button Text',
			]
		);

		$this->add_control(
			'button_link',
			[
				'label' => __( 'Button Link', 'booth-elementor' ),
				'type' => Controls_Manager::TEXT,
				'default' => '',
			]
		);

		$this->add_control(
			'button_target',
			[
				'label' => __( 'Button Link Target', 'booth-elementor' ),
				'type' => Controls_Manager::SELECT,
				'default' => '_self',
				'options' =>  booth_select_get_link_target_array(),
			]
		);

		$this->add_control(
			'button_type',
			[
				'label' => __( 'Button Type', 'booth-elementor' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'solid',
				'options' =>  [
					'solid' => __( 'Solid', 'booth-core' ),
					'outline' => __( 'Outline', 'booth-core' ),
				],
			]
		);

		$this->add_control(
			'button_size',
			[
				'label' => __( 'Button Size', 'booth-elementor' ),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' =>  [
					'' => __( 'Default', 'booth-core' ),
					'small'  => __( 'Small', 'booth-core' ),
					'medium' => __( 'Medium', 'booth-core' ),
					'large'  => __( 'Large', 'booth-core' ),
				],
				// 'condition' => [
                //     'button_type' => 'yes',
                // ],
			]
		);

		$this->add_control(
			'button_color',
			[
				'label' => __( 'Button Color', 'booth-elementor' ),
				'type' => Controls_Manager::COLOR,
			]
		);

		$this->add_control(
			'button_hover_color',
			[
				'label' => __( 'Button Hover Color', 'booth-elementor' ),
				'type' => Controls_Manager::COLOR,
			]
		);

		$this->add_control(
			'button_background_color',
			[
				'label' => __( 'Button Background Color', 'booth-elementor' ),
				'type' => Controls_Manager::COLOR,
				'condition' => [
                    'button_type' => 'solid',
                ],
			]
		);

		$this->add_control(
			'button_hover_background_color',
			[
				'label' => __( 'Button Hover Background Color', 'booth-elementor' ),
				'type' => Controls_Manager::COLOR,
			]
		);

		$this->add_control(
			'button_border_color',
			[
				'label' => __( 'Button Border Color', 'booth-elementor' ),
				'type' => Controls_Manager::COLOR,
			]
		);

		$this->add_control(
			'button_hover_border_color',
			[
				'label' => __( 'Button Hover Border Color', 'booth-elementor' ),
				'type' => Controls_Manager::COLOR,
			]
		);

		$this->end_controls_section();
	}

	protected function register_style_controls() {}

	protected function render() {
		// return;

		$settings = $this->get_settings_for_display();

		$content = $settings['content'];

		$holder_classes = $this->getHolderClasses( $settings );
		$inner_classes        = $this->getInnerClasses( $settings );
		$button_holder_styles = $this->getButtonHolderStyles( $settings );
		$button_parameters    = $this->getButtonParameters( $settings );
		$background_image_styles = $this->getImageBackgroundStyles( $settings );
		$text_box_styles         = $this->getTextBoxStyles( $settings );

		?>
		<div class="qodef-call-to-action-holder <?php echo esc_attr($holder_classes); ?>">
			<div class="qodef-cta-inner <?php echo esc_attr($inner_classes); ?>" <?php booth_select_inline_style($background_image_styles); ?>>
				<div class="qodef-cta-text-holder" <?php booth_select_inline_style($text_box_styles); ?>>
					<div class="qodef-cta-text"><?php echo $this->parse_text_editor( $content ); ?></div>
				</div>
				<div class="qodef-cta-button-holder" <?php echo booth_select_get_inline_style($button_holder_styles); ?>>
					<div class="qodef-cta-button"><?php echo booth_select_get_button_html($button_parameters); ?></div>
				</div>
			</div>
		</div>
		<?php
	}



	private function getHolderClasses( $params ) {
		$holderClasses = array();

		$holderClasses[] = ! empty( $params['custom_class'] ) ? esc_attr( $params['custom_class'] ) : '';
		$holderClasses[] = $params['content_in_grid'] === 'yes' ? 'qodef-content-in-grid' : '';

		if($params['alignment'] === 'left') {
			$holderClasses[] = 'qodef-cta-left';
		} elseif ($params['alignment'] === 'center') {
			$holderClasses[] = 'qodef-cta-center';
		} elseif ($params['alignment'] === 'right') {
			$holderClasses[] = 'qodef-cta-right';
		} elseif ($params['alignment'] === 'button_right') {
			$holderClasses[] = 'qodef-cta-text-left-btn-right';
		}

		if ( ! empty($params['text_box_color']) && $params['text_in_box'] === 'yes' ) {
			$holderClasses[] = 'qodef-cta-text-in-box';
		}

		return implode( ' ', $holderClasses );
	}

	private function getInnerClasses( $params ) {
		$innerClasses = array();

		$innerClasses[] = $params['content_in_grid'] === 'yes' ? 'qodef-grid' : '';

		return implode( ' ', $innerClasses );
	}

	private function getImageBackgroundStyles( $params ) {
		$styles = array();

		if ( ! empty( $params['background_image'] ) ) {
			$image_src = wp_get_attachment_image_src( $params['background_image']['id'], 'full' );

			if ( is_array( $image_src ) ) {
				$image_src = $image_src[0];
			}

			$styles[] = 'background-image: url(' . $image_src . ')';
		}

		return implode( ';', $styles );
	}

	private function getTextBoxStyles( $params ) {
		$styles = array();

		if ( ! empty($params['text_box_color']) && $params['text_in_box'] === 'yes' ) {
			$styles[] = 'background-color:'.$params['text_box_color'];
		}

		return implode( ';', $styles );
	}

	private function getButtonHolderStyles( $params ) {
		$styles = array();

		if ( ! empty( $params['button_top_margin'] ) ) {
			$styles[] = 'margin-top: ' . booth_select_filter_px( $params['button_top_margin'] ) . 'px';
		}

		return implode( ';', $styles );
	}

	private function getButtonParameters( $params ) {
		$button_params_array = array();

		if ( ! empty( $params['button_text'] ) ) {
			$button_params_array['text'] = $params['button_text'];
		}

		if ( ! empty( $params['button_type'] ) ) {
			$button_params_array['type'] = $params['button_type'];
		}

		if ( ! empty( $params['button_size'] ) ) {
			$button_params_array['size'] = $params['button_size'];
		}

		if ( ! empty( $params['button_link'] ) ) {
			$button_params_array['link'] = $params['button_link'];
		}

		$button_params_array['target'] = ! empty( $params['button_target'] ) ? $params['button_target'] : '_self';

		if ( ! empty( $params['button_color'] ) ) {
			$button_params_array['color'] = $params['button_color'];
		}

		if ( ! empty( $params['button_hover_color'] ) ) {
			$button_params_array['hover_color'] = $params['button_hover_color'];
		}

		if ( ! empty( $params['button_background_color'] ) ) {
			$button_params_array['background_color'] = $params['button_background_color'];
		}

		if ( ! empty( $params['button_hover_background_color'] ) ) {
			$button_params_array['hover_background_color'] = $params['button_hover_background_color'];
		}

		if ( ! empty( $params['button_border_color'] ) ) {
			$button_params_array['border_color'] = $params['button_border_color'];
		}

		if ( ! empty( $params['button_hover_border_color'] ) ) {
			$button_params_array['hover_border_color'] = $params['button_hover_border_color'];
		}

		return $button_params_array;
	}
}
