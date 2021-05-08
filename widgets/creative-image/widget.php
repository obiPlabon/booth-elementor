<?php
/**
 * Creative image widget class.
 */
namespace Booth_Elementor\Widget;

defined( 'ABSPATH' ) || die();

use Elementor\Controls_Manager;
use Elementor\Group_Control_Image_Size;
use Elementor\Utils;

class Creative_Image extends Base {

    /**
     * Get widget title.
     */
    public function get_title() {
        return __( 'Creative Image', 'booth-elementor' );
    }

    public function get_keywords() {
        return [ 'booth', 'creative-image', 'creative', 'image' ];
    }

    protected function register_content_controls() {
        $this->start_controls_section(
            'booth_creative_image_content',
            [
                'label' => __( 'Creative Image', 'booth-elementor' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'style',
            [
                'label'   => __( 'Style', 'booth-elementor' ),
                'type'    => Controls_Manager::SELECT,
                'default' => 'style-1',
                'options' => [
                    'style-1' => __( 'Style 1', 'booth-elementor' ),
                    'style-2' => __( 'Style 2', 'booth-elementor' ),
                    'style-3' => __( 'Style 3', 'booth-elementor' ),
                ],
            ]
        );

        $this->add_control(
            'image',
            [
                'label'       => __( 'Image', 'booth-elementor' ),
                'type'        => Controls_Manager::MEDIA,
                // 'default' => [
                //     'url' => Utils::get_placeholder_image_src(),
                // ],
                // 'description' => __( 'Upload an image for Call to Action background', 'booth-elementor' ),
            ]
        );

        $this->add_control(
            'link',
            [
                'label' => __( 'Link', 'booth-elementor' ),
                'type' => Controls_Manager::URL,
                'placeholder' => 'https://example.com',
                // 'dynamic' => [
                //     'active' => true,
				// ],
				'default' => [
					'url' => '#',
				],
            ]
        );

        $this->add_control(
            'name',
            [
                'label'       => __( 'Name', 'booth-elementor' ),
                'label_block' => true,
                'type'        => Controls_Manager::TEXT,
                'default'     => 'Malene Kruse',
				'condition' => [
					'style!' => 'style-3',
				]
            ]
        );

        $this->add_control(
            'position',
            [
                'label'       => __( 'Position', 'booth-elementor' ),
                'label_block' => true,
                'type'        => Controls_Manager::TEXT,
                'default'     => 'Photographer',
				'condition' => [
					'style!' => 'style-3',
				]
            ]
        );

		$this->add_control(
			'content_position',
			[
				'label' => __( 'Content Position', 'plugin-domain' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'top' => [
						'title' => __( 'Top', 'plugin-domain' ),
						'icon' => 'eicon-v-align-top',
					],
					'bottom' => [
						'title' => __( 'Bottom', 'plugin-domain' ),
						'icon' => 'eicon-v-align-bottom',
					],
				],
				'default' => 'bottom',
				'toggle' => false,
                'selectors_dictionary' => [
                    'top' => 'order: -1;',
                    'bottom' => '',
                ],
				'selectors' => [
					'{{WRAPPER}} .creative-image-info' => '{{VALUE}}',
				],
				'conditions' => [
					'terms' => [
						[
							'relation' => 'or',
							'terms' => [
								[
									'name' => 'name',
									'operator' => '!=',
									'value' => '',
								],
								[
									'name' => 'position',
									'operator' => '!=',
									'value' => '',
								],
							],
						],
						[
							'terms' => [
								[
									'name' => 'style',
									'value' => 'style-1',
								],
							],
						]
					]
				],
			]
		);

        $this->add_control(
            'badge_text',
            [
                'label'       => __( 'Badge Text', 'booth-elementor' ),
                'label_block' => true,
                'type'        => Controls_Manager::TEXT,
                'default'     => '2003',
				'condition' => [
					'style' => 'style-3',
				]
            ]
        );

		$this->add_control(
			'badge_position',
			[
				'label' => __( 'Badge Position', 'plugin-domain' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => __( 'Left', 'plugin-domain' ),
						'icon' => 'eicon-h-align-left',
					],
					'right' => [
						'title' => __( 'Right', 'plugin-domain' ),
						'icon' => 'eicon-h-align-right',
					],
				],
				'default' => 'left',
				'toggle' => false,
                // 'selectors_dictionary' => [
                //     'top' => 'order: -1;',
                //     'bottom' => '',
                // ],
				// 'selectors' => [
				// 	'{{WRAPPER}} .creative-image-info' => '{{VALUE}}',
				// ],
				'condition' => [
					'style' => 'style-3',
				]
			]
		);

        $this->end_controls_section();

    }

    protected function register_style_controls() {
        $this->start_controls_section(
            'booth_creative_image_style',
            [
                'label' => __( 'Style', 'booth-elementor' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

		$this->add_control(
			'image_btm_margin',
			[
				'label' => __( 'Image Space', 'booth-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .creative-image-wrap .creative-image' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'style' => 'style-1',
				],
				'separator' => 'after',
			]
		);

		$this->add_control(
			'name_heading',
			[
				'label' => __( 'Name', 'booth-elementor' ),
				'type' => Controls_Manager::HEADING,
				'condition' => [
					'style!' => 'style-3',
				]
			]
		);

		$this->add_control(
			'name_btm_margin',
			[
				'label' => __( 'Name Space', 'booth-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .creative-image-wrap .creative-image-name' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'style!' => 'style-3',
				]
			]
		);

		$this->add_control(
			'name_font_size',
			[
				'label' => __( 'Font Size', 'booth-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 500,
						'step' => 1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .creative-image-wrap .creative-image-name' => 'font-size: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'style!' => 'style-3',
				]
			]
		);

		$this->add_control(
			'name_color',
			[
				'label' => __( 'Name Color', 'booth-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .creative-image-wrap .creative-image-name' => 'color: {{VALUE}}',
				],
				'condition' => [
					'style!' => 'style-3',
				]
			]
		);

		$this->add_control(
			'position_heading',
			[
				'label' => __( 'Position', 'booth-elementor' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
					'style!' => 'style-3',
				]
			]
		);

		$this->add_control(
			'position_btm_margin',
			[
				'label' => __( 'Position Space', 'booth-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 0,
				],
				'selectors' => [
					'{{WRAPPER}} .creative-image-wrap .creative-image-position' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'style!' => 'style-3',
				]
			]
		);

		$this->add_control(
			'position_font_size',
			[
				'label' => __( 'Font Size', 'booth-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 500,
						'step' => 1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .creative-image-wrap .creative-image-position' => 'font-size: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'style!' => 'style-3',
				]
			]
		);

		$this->add_control(
			'position_color',
			[
				'label' => __( 'Position Color', 'booth-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .creative-image-wrap .creative-image-position' => 'color: {{VALUE}}',
				],
				'condition' => [
					'style!' => 'style-3',
				]
			]
		);

		$this->add_control(
			'animation_heading',
			[
				'label' => __( 'Animation', 'booth-elementor' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
					'style!' => 'style-3',
				]
			]
		);

		$this->add_control(
			'animation_color',
			[
				'label' => __( 'Animation Color', 'booth-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .creative-image-wrap' => '--booth-animation-color: {{VALUE}}',
				],
				'condition' => [
					'style!' => 'style-3',
				]
			]
		);

		/* Style 3 */
		$this->add_control(
			'badge_heading',
			[
				'label' => __( 'Badge', 'booth-elementor' ),
				'type' => Controls_Manager::HEADING,
				// 'separator' => 'before',
				'condition' => [
					'style' => 'style-3',
				]
			]
		);

		$this->add_control(
			'badge_width',
			[
				'label' => __( 'Width', 'booth-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 500,
						'step' => 1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .creative-image-wrap .creative-image-badge' => 'width: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'style' => 'style-3',
				]
			]
		);

		$this->add_control(
			'badge_height',
			[
				'label' => __( 'Height', 'booth-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 500,
						'step' => 1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .creative-image-wrap .creative-image-badge' => 'height: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'style' => 'style-3',
				]
			]
		);

		$this->add_control(
			'badge_font_size',
			[
				'label' => __( 'Font Size', 'booth-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 500,
						'step' => 1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .creative-image-wrap .creative-image-badge-title' => 'font-size: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'style' => 'style-3',
				]
			]
		);

		$this->add_control(
			'badge_color',
			[
				'label' => __( 'Color', 'booth-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .creative-image-wrap .creative-image-badge-title' => 'color: {{VALUE}}',
				],
				'condition' => [
					'style' => 'style-3',
				]
			]
		);

		$this->add_control(
			'badge_area_color',
			[
				'label' => __( 'Background', 'booth-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .creative-image-wrap' => '--booth-badge-color: {{VALUE}}',
				],
				'condition' => [
					'style' => 'style-3',
				]
			]
		);

		$this->end_controls_section();

	}

    protected function render() {
        // return;

        $settings = $this->get_settings_for_display();

		if (empty($settings['image']['id'])) {
			return;
		}

		// echo '<pre>';
		// var_dump($settings['link']);
		// echo '</pre>';

		$this->add_render_attribute( 'creative_image', 'class', [ 'creative-image-wrap', 'creative-image-'.$settings['style'] ] );

		if ( ! empty( $settings['link']['url'] ) ){
			$this->add_link_attributes( 'link', $settings['link'] );
		}

        ?>
		<div <?php $this->print_render_attribute_string( 'creative_image' ); ?>>
			<div class="creative-image-wrap-inner">

				<div class="creative-image">

					<?php if ( ! empty( $settings['link']['url'] ) ): ?>
						<a <?php $this->print_render_attribute_string( 'link' ); ?>>
					<?php endif; ?>

					<?php echo wp_get_attachment_image( $settings['image']['id'], 'full' ); ?>

					<?php
						if ( 'style-2'== $settings['style'] && (! empty( $settings['name'] ) || ! empty( $settings['position'] )) ):
							$this->render_info($settings);
						endif;
					?>

					<?php
						if ( 'style-3'== $settings['style'] ):
							$this->render_banner($settings);
						endif;
					?>

					<?php if ( 'style-3' != $settings['style'] ): ?>
						<div class="creative-image-pattern-hover">
							<span></span>
							<span></span>
							<span></span>
							<span></span>
							<span></span>
							<span></span>
						</div>
					<?php endif; ?>

					<?php if ( ! empty( $settings['link']['url'] ) ): ?>
						</a>
					<?php endif; ?>
				</div>

				<?php
					if ( 'style-1'== $settings['style'] && (! empty( $settings['name'] ) || ! empty( $settings['position'] )) ):
						$this->render_info($settings);
					endif;
				?>

			</div>
		</div>
		<?php
	}

	public function render_info($settings) {
		?>
		<div class="creative-image-info">

			<?php if ( ! empty( $settings['name'] ) ): ?>
			<div class="creative-image-title-holder">
				<h4 class="creative-image-name">
					<?php if ( 'style-1'== $settings['style'] && ! empty( $settings['link']['url'] ) ): ?>
						<a <?php $this->print_render_attribute_string( 'link' ); ?>>
					<?php endif; ?>
						<?php echo esc_html( $settings['name'] ); ?>
					<?php if ( 'style-1'== $settings['style'] && ! empty( $settings['link']['url'] ) ): ?>
						</a>
					<?php endif; ?>
				</h4>
			</div>
			<?php endif; ?>

			<?php if ( ! empty( $settings['position'] ) ): ?>
			<h6 class="creative-image-position"><?php echo esc_html( $settings['position'] ); ?></h6>
			<?php endif; ?>

		</div>
		<?php
	}

	public function render_banner($settings) {
		if( empty($settings['badge_text']) ){
			return;
		}
		?>
		<div class="creative-image-badge creative-image-badge-<?php echo esc_attr( $settings['badge_position'] ); ?>">
			<div class="creative-image-badge-inner">
				<div class="creative-image-badge-text">
					<h5 class="creative-image-badge-title"><?php echo esc_html( $settings['badge_text'] ); ?></h5>
				</div>
			</div>
		</div>
		<?php
	}

}
