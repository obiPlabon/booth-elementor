<?php
namespace Booth_Elementor\Widget;

use Elementor\Controls_Manager;
class Section_Title extends Base {

    /**
     * Get widget title.
     *
     */
    public function get_title() {
        return __( 'Section Title', 'booth-elementor' );
    }

    public function get_keywords() {
        return ['booth', 'section-title', 'section', 'title'];
    }

    protected function register_content_controls() {

        $this->genereal_controls();
        $this->title_controls();
        $this->text_controls();
        $this->button_controls();

    }

    protected function genereal_controls() {
		$this->start_controls_section(
			'general_content_section',
			[
				'label' => __( 'General', 'booth-elementor' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'title_type',
			[
				'label' => __( 'Type', 'booth-elementor' ),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					'' => __( 'Default', 'booth-elementor' ),
					'highlighted'  => __( 'Highlighted', 'booth-elementor' ),
				],
			]
		);

		$this->add_control(
			'position',
			[
				'label' => __( 'Horizontal Position', 'booth-elementor' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'center',
				'options' => [
					'' => __( 'Default', 'booth-elementor' ),
					'left'  => __( 'Left', 'booth-elementor' ),
					'center'  => __( 'Center', 'booth-elementor' ),
					'right'  => __( 'Right', 'booth-elementor' ),
				],
			]
		);

		$this->add_control(
			'holder_padding',
			[
				'label' => __( 'Holder Side Padding (px or %)', 'booth-elementor' ),
				'label_block'=>true,
				'type' => Controls_Manager::TEXT,
			]
		);

		$this->add_control(
			'enable_animation',
			[
				'label' => __( 'Enable Section Title Animation', 'booth-elementor' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'no',
				'options' => booth_select_get_yes_no_select_array( false, true ),
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

    protected function title_controls() {
		$this->start_controls_section(
			'title_content_section',
			[
				'label' => __( 'Title', 'booth-elementor' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'title',
			[
				'label' => __( 'Title', 'booth-elementor' ),
				'label_block'=>true,
				'type' => Controls_Manager::TEXT,
				'default' => 'Section Title',
			]
		);

		$this->add_control(
			'title_tag',
			[
				'label' => __( 'Title Tag', 'booth-elementor' ),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => booth_select_get_title_tag( true ),
                'condition'   => [
                    'title!' => '',
                ],
			]
		);

		$this->add_control(
			'title_font_size',
			[
				'label' => __( 'Title Font Size (px)', 'booth-elementor' ),
				'label_block'=>true,
				'type' => Controls_Manager::TEXT,
                'condition'   => [
                    'title!' => '',
                ],
			]
		);

		$this->add_control(
			'title_color',
			[
				'label' => __( 'Title Color', 'booth-elementor' ),
				'label_block'=> false,
				'type' => Controls_Manager::COLOR,
                'condition'   => [
                    'title!' => '',
                ],
			]
		);

		$this->add_control(
			'title_break_words',
			[
				'label' => __( 'Position of Line Break', 'booth-elementor' ),
				'label_block'=>true,
				'description' => __( 'Enter the position of the word after which you would like to create a line break (e.g. if you would like the line break after the 3rd word, you would enter "3"', 'booth-elementor' ),
				'type' => Controls_Manager::TEXT,
                'condition'   => [
                    'title!' => '',
                ],
			]
		);

		$this->add_control(
			'square_color',
			[
				'label' => __( 'Square Color', 'booth-elementor' ),
				'label_block'=> false,
				'type' => Controls_Manager::COLOR,
				'default' => '#ec40ff',
                'condition'   => [
                    'title_type' => '',
                ],
			]
		);

		$this->add_control(
			'highlight_color',
			[
				'label' => __( 'Highlight Color', 'booth-elementor' ),
				'label_block'=> false,
				'type' => Controls_Manager::COLOR,
				'default' => '#ec40ff',
                'condition'   => [
                    'title_type' => 'highlighted',
                ],
			]
		);

		$this->add_control(
			'disable_break_words',
			[
				'label' => __( 'Title Tag', 'booth-elementor' ),
				'type' => Controls_Manager::SELECT,
				'description' => __( 'Disable Line Break for Smaller Screens', 'booth-elementor' ),
				'default' => '',
				'options' => booth_select_get_yes_no_select_array( false ),
                'condition'   => [
                    'title!' => '',
                ],
			]
		);

		$this->end_controls_section();

    }

    protected function text_controls() {
		$this->start_controls_section(
			'text_content_section',
			[
				'label' => __( 'Text', 'booth-elementor' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'text',
			[
				'label' => __( 'Text', 'booth-elementor' ),
				'label_block'=>true,
				'type' => Controls_Manager::TEXTAREA,
				'default' => 'Lorem ipsum, dolor sit amet consectetur adipisicing elit. Repellat rem aliquid, dolor quo voluptates magnam ea porro, hic voluptas ipsa eos unde dolorem cupiditate laborum quis tempore. Dignissimos, praesentium dolorum?',
			]
		);

		$this->add_control(
			'text_tag',
			[
				'label' => __( 'Text Tag', 'booth-elementor' ),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => booth_select_get_title_tag( true ),
                'condition'   => [
                    'text!' => '',
                ],
			]
		);

		$this->add_control(
			'text_color',
			[
				'label' => __( 'Text Color', 'booth-elementor' ),
				'label_block'=> false,
				'type' => Controls_Manager::COLOR,
                'condition'   => [
                    'text!' => '',
                ],
			]
		);

		$this->add_control(
			'text_font_size',
			[
				'label' => __( 'Text Font Size (px)', 'booth-elementor' ),
				'label_block'=>true,
				'type' => Controls_Manager::TEXT,
                'condition'   => [
                    'text!' => '',
                ],
			]
		);

		$this->add_control(
			'text_line_height',
			[
				'label' => __( 'Text Line Height (px)', 'booth-elementor' ),
				'label_block'=>true,
				'type' => Controls_Manager::TEXT,
                'condition'   => [
                    'text!' => '',
                ],
			]
		);

		$this->add_control(
			'text_font_weight',
			[
				'label' => __( 'Text Font Weight', 'booth-elementor' ),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => booth_select_get_font_weight_array( true ),
                'condition'   => [
                    'text!' => '',
                ],
			]
		);

		$this->add_control(
			'text_margin',
			[
				'label' => __( 'Text Top Margin (px)', 'booth-elementor' ),
				'label_block'=>true,
				'type' => Controls_Manager::TEXT,
                'condition'   => [
                    'text!' => '',
                ],
			]
		);

		$this->end_controls_section();

    }

    protected function button_controls() {
		$this->start_controls_section(
			'button_content_section',
			[
				'label' => __( 'Button', 'booth-elementor' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);
		$this->add_control(
			'button_text',
			[
				'label' => __( 'Button Text', 'booth-elementor' ),
				'label_block'=>true,
				'type' => Controls_Manager::TEXT,
			]
		);

		$this->add_control(
			'button_link',
			[
				'label' => __( 'Button Link', 'booth-elementor' ),
				'label_block'=>true,
				'type' => Controls_Manager::TEXT,
                // 'condition'   => [
                //     'button_text!' => '',
                // ],
			]
		);

		$this->add_control(
			'button_target',
			[
				'label' => __( 'Button Link Target', 'booth-elementor' ),
				'type' => Controls_Manager::SELECT,
				'default' => '_self',
				'options' => booth_select_get_link_target_array(),
			]
		);

		$this->add_control(
			'button_color',
			[
				'label' => __( 'Button Color', 'booth-elementor' ),
				'label_block'=> false,
				'type' => Controls_Manager::COLOR,
			]
		);

		$this->add_control(
			'button_hover_color',
			[
				'label' => __( 'Button Hover Color', 'booth-elementor' ),
				'label_block'=> false,
				'type' => Controls_Manager::COLOR,
			]
		);

		$this->add_control(
			'button_top_margin',
			[
				'label' => __( 'Button Top Margin (px)', 'booth-elementor' ),
				'label_block'=>true,
				'type' => Controls_Manager::TEXT,
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


        $holder_classes = $this->getHolderClasses( $settings );
		$holder_styles     = $this->getHolderStyles( $settings );

		$title_type        = $settings['title_type'];
		$title             = $this->getModifiedTitle( $settings );
		$title_tag         = ! empty( $settings['title_tag'] ) ? $settings['title_tag'] : 'h2';
		$title_styles      = $this->getTitleStyles( $settings );

		$text        	   = $settings['text'];
		$text_tag          = ! empty( $settings['text_tag'] ) ? $settings['text_tag'] : 'p';
		$text_styles       = $this->getTextStyles( $settings );
		$button_parameters = $this->getButtonParameters( $settings );
		$square_style      = ! empty( $settings['square_color'] ) ? $settings['square_style'] = 'background-color:'.$settings['square_color'] : '';

        ?>

			<div class="qodef-section-title-holder <?php echo esc_attr( $holder_classes ); ?>" <?php echo booth_select_get_inline_style( $holder_styles ); ?>>
				<div class="qodef-st-inner">
					<?php if ( ! empty( $title ) ) { ?>
					<div class="qodef-st-title-holder">
						<<?php echo esc_attr( $title_tag ); ?> class="qodef-st-title" <?php echo booth_select_get_inline_style( $title_styles ); ?>>
						<?php if ( $title_type !== 'highlighted') { ?>
							<span class="qodef-st-text-with-square">
								<span class="qodef-st-square" <?php booth_select_inline_style($square_style); ?>></span>
								<span class="qodef-st-first-letter"><?php echo substr($title, 0,1);?></span>
							</span>
							<span class="qodef-st-title-text"><?php echo wp_kses( substr($title, 1), array( 'br' => true, 'span' => array( 'class' => true ) ) ); ?>
							</span>
						<?php } else {
							echo wp_kses( $title, array( 'br' => true, 'span' => array( 'class' => true ) ) );
						}
						?>
					</<?php echo esc_attr( $title_tag ); ?>>
					</div>
					<?php } ?>
					<?php if ( ! empty( $text ) ) { ?>
						<<?php echo esc_attr( $text_tag ); ?> class="qodef-st-text" <?php echo booth_select_get_inline_style( $text_styles ); ?>>
							<?php echo wp_kses( $text, array( 'br' => true ) ); ?>
						</<?php echo esc_attr( $text_tag ); ?>>
					<?php } ?>
					<?php if ( ! empty( $button_parameters ) ) { ?>
						<div class="qodef-st-button"><?php echo booth_select_get_button_html( $button_parameters ); ?></div>
					<?php } ?>
				</div>
			</div>

		<?php
	}


	private function getHolderClasses( $params ) {
		$holderClasses = array();

		$holderClasses[] = ! empty( $params['custom_class'] ) ? esc_attr( $params['custom_class'] ) : '';
		$holderClasses[] = $params['disable_break_words'] === 'yes' ? 'qodef-st-disable-title-break' : '';
		$holderClasses[] = $params['title_type'] === 'highlighted' ? 'qodef-section-title-highlighted' : '';
		$holderClasses[] = $params['enable_animation'] === 'yes' ? 'qodef-section-title-animated' : '';

		return implode( ' ', $holderClasses );
	}

	private function getHolderStyles( $params ) {
		$styles = array();

		if ( ! empty( $params['holder_padding'] ) ) {
			$styles[] = 'padding: 0 ' . $params['holder_padding'];
		}

		if ( ! empty( $params['position'] ) ) {
			$styles[] = 'text-align: ' . $params['position'];
		}

		return implode( ';', $styles );
	}

	private function getModifiedTitle( $params ) {
		$title             = $params['title'];
		$title_break_words = str_replace( ' ', '', $params['title_break_words'] );

		if ( ! empty( $title ) ) {
			$split_title = explode( ' ', $title );

			if ( ! empty( $title_break_words ) ) {
				if ( ! empty( $split_title[ $title_break_words - 1 ] ) ) {
					$split_title[ $title_break_words - 1 ] = $split_title[ $title_break_words - 1 ] . '<br />';
				}
			}

			$title = implode( ' ', $split_title );
		}

		return $title;
	}

	private function getTitleStyles( $params ) {
		$styles = array();

		if ( ! empty( $params['title_color'] ) ) {
			$styles[] = 'color: ' . $params['title_color'];
		}

		if ( ! empty( $params['title_font_size'] ) ) {
			$styles[] = 'font-size: ' . booth_select_filter_px( $params['title_font_size'] ) . 'px';
		}

		if (! empty( $params['highlight_color'] ) && $params['title_type'] === 'highlighted') {
			$styles[] = 'background-color: ' . $params['highlight_color'];
		}

		return implode( ';', $styles );
	}

	private function getTextStyles( $params ) {
		$styles = array();

		if ( ! empty( $params['text_color'] ) ) {
			$styles[] = 'color: ' . $params['text_color'];
		}

		if ( ! empty( $params['text_font_size'] ) ) {
			$styles[] = 'font-size: ' . booth_select_filter_px( $params['text_font_size'] ) . 'px';
		}

		if ( ! empty( $params['text_line_height'] ) ) {
			$styles[] = 'line-height: ' . booth_select_filter_px( $params['text_line_height'] ) . 'px';
		}

		if ( ! empty( $params['text_font_weight'] ) ) {
			$styles[] = 'font-weight: ' . $params['text_font_weight'];
		}

		if ( $params['text_margin'] !== '' ) {
			$styles[] = 'margin-top: ' . booth_select_filter_px( $params['text_margin'] ) . 'px';
		}

		return implode( ';', $styles );
	}

	private function getButtonParameters( $params ) {
		$button_params = array();

		if ( ! empty( $params['button_text'] ) ) {
			$button_params['text'] = $params['button_text'];
			$button_params['type'] = 'simple';
			$button_params['link'] = ! empty( $params['button_link'] ) ? $params['button_link'] : '#';
			$button_params['target'] = ! empty( $params['button_target'] ) ? $params['button_target'] : '_self';

			if ( ! empty( $params['button_color'] ) ) {
				$button_params['color'] = $params['button_color'];
			}

			if ( ! empty( $params['button_hover_color'] ) ) {
				$button_params['hover_color'] = $params['button_hover_color'];
			}

			if ( $params['button_top_margin'] !== '' ) {
				$button_params['margin'] = intval( $params['button_top_margin'] ) . 'px 0 0';
			}
		}

		return $button_params;
	}

}
