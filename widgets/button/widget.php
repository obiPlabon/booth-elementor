<?php
/**
 * Button widget class.
 */
namespace Booth_Elementor\Widget;

defined( 'ABSPATH' ) || die();

use Elementor\Controls_Manager;

class Button extends Base {

    /**
     * Get widget title.
     *
     */
    public function get_title() {
        return __( 'Button', 'booth-elementor' );
    }

    public function get_keywords() {
        return ['booth', 'button'];
    }

    protected function register_content_controls() {

        $this->__register_price_table_controls();
        $this->__register_price_table_item_controls();

    }

    protected function __register_price_table_controls() {
        $this->start_controls_section(
            'booth_button_settings_content',
            [
                'label' => __( 'Button', 'booth-elementor' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'type',
            [
                'label'   => __( 'Type', 'booth-elementor' ),
                'type'    => Controls_Manager::SELECT,
                'default' => 'solid',
                'options' => [
                    'solid'   => __( 'Solid', 'booth-elementor' ),
                    'outline' => __( 'Outline', 'booth-elementor' ),
                    'simple'  => __( 'Simple', 'booth-elementor' ),
                ],
            ]
        );

        $this->add_control(
            'size',
            [
                'label'   => __( 'Size', 'booth-elementor' ),
                'type'    => Controls_Manager::SELECT,
                'default' => '',
                'options' => [
                    ''       => __( 'Default', 'booth-elementor' ),
                    'small'  => __( 'Small', 'booth-elementor' ),
                    'medium' => __( 'Medium', 'booth-elementor' ),
                    'large'  => __( 'Large', 'booth-elementor' ),
                    'huge'   => __( 'Huge', 'booth-elementor' ),
                ],
            ]
        );

        $this->add_control(
            'text',
            [
                'label'       => __( 'Text', 'booth-elementor' ),
                'label_block' => false,
                'type'        => Controls_Manager::TEXT,
                'default'     => 'Button Text',
            ]
        );

        $this->add_control(
            'link',
            [
                'label' => __( 'Button Link', 'booth-elementor' ),
                'type'  => Controls_Manager::TEXT,

            ]
        );

        $this->add_control(
            'target',
            [
                'label'   => __( 'Link Target', 'booth-elementor' ),
                'type'    => Controls_Manager::SELECT,
                'default' => '_self',
                'options' => booth_select_get_link_target_array(),
            ]
        );

        $this->add_control(
            'icon',
            [
                'label'                  => __( 'Icon', 'booth-elementor' ),
                'label_block'            => false,
                'type'                   => Controls_Manager::ICONS,
                'default'                => [
                    'value'   => 'fas fa-star',
                    'library' => 'solid',
                ],
                'skin'                   => 'inline',
                'exclude_inline_options' => ['svg'],
                'condition' => [
                    'type' => 'solid', // solid outline
                ],
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

    protected function __register_price_table_item_controls() {
        $this->start_controls_section(
            'button_design_option_content',
            [
                'label' => __( 'Design Options', 'booth-elementor' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'color',
            [
                'label' => __( 'Color', 'booth-elementor' ),
                'type'  => Controls_Manager::COLOR,

            ]
        );

        $this->add_control(
            'hover_color',
            [
                'label' => __( 'Hover Color', 'booth-elementor' ),
                'type'  => Controls_Manager::COLOR,

            ]
        );

        $this->add_control(
            'background_color',
            [
                'label'     => __( 'Background Color', 'booth-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'condition' => [
                    'type' => 'solid', // solid outline
                ],

            ]
        );

        $this->add_control(
            'hover_background_color',
            [
                'label'     => __( 'Hover Background Color', 'booth-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'condition' => [
                    'type!' => 'simple', // solid outline
                ],

            ]
        );

        $this->add_control(
            'simple_hover_background_color',
            [
                'label'     => __( 'Hover Background Color', 'booth-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'condition' => [
                    'type' => 'simple', // solid outline
                ],

            ]
        );

        $this->add_control(
            'border_color',
            [
                'label'     => __( 'Border Color', 'booth-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'condition' => [
                    'type!' => 'simple', // solid outline
                ],

            ]
        );

        $this->add_control(
            'hover_border_color',
            [
                'label'     => __( 'Hover Border Color', 'booth-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'condition' => [
                    'type!' => 'simple', // solid outline
                ],

            ]
        );

        $this->add_control(
            'icon_background_color',
            [
                'label'     => __( 'Icon Background Color', 'booth-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'condition' => [
                    'type' => 'solid', // solid outline
                ],

            ]
        );

        $this->add_control(
            'icon_hover_background_color',
            [
                'label'     => __( 'Icon Hover Background Color', 'booth-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'condition' => [
                    'type!' => 'simple', // solid outline
                ],
            ]
        );

        $this->add_control(
            'font_size',
            [
                'label' => __( 'Font Size (px)', 'booth-elementor' ),
                'type'  => Controls_Manager::TEXT,
                'input_type'  => 'number',
            ]
        );

        $this->add_control(
            'font_weight',
            [
                'label'   => __( 'Font Weight', 'booth-elementor' ),
                'type'    => Controls_Manager::SELECT,
                'default' => '',
                'options' => booth_select_get_font_weight_array( true ),
            ]
        );

        $this->add_control(
            'text_transform',
            [
                'label'   => __( 'Text Transform', 'booth-elementor' ),
                'type'    => Controls_Manager::SELECT,
                'default' => '',
                'options' => booth_select_get_text_transform_array( true ),
            ]
        );

        $this->add_control(
            'margin',
            [
                'label'       => __( 'Margin', 'booth-elementor' ),
                'type'        => Controls_Manager::TEXT,
                'description' => __( 'Insert margin in format: top right bottom left (e.g. 10px 5px 10px 5px)', 'booth-elementor' ),

            ]
        );

        $this->add_control(
            'padding',
            [
                'label'       => __( 'Button Padding', 'booth-elementor' ),
                'type'        => Controls_Manager::TEXT,
                'description' => __( 'Insert margin in format: top right bottom left (e.g. 10px 5px 10px 5px)', 'booth-elementor' ),
                'condition'   => [
                    'type!' => 'simple', // solid outline
                ],

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

        // $size = ! empty( $settings['size'] ) ? $settings['size'] : 'medium';
        $type = !empty( $settings['type'] ) ? $settings['type'] : 'solid';

        $link = !empty( $settings['link'] ) ? $settings['link'] : '#';
        $target = !empty( $settings['target'] ) ? $settings['target'] : '_self';

        $button_classes = $this->getButtonClasses( $settings );
        $button_custom_attrs = !empty( $settings['custom_attrs'] ) ? [] : [];
        $button_styles = $this->getButtonStyles( $settings );
        $button_data = $this->getButtonDataAttr( $settings );
        $button_icon_styles = $this->getButtonIconStyles( $settings );
        $button_icon_data = $this->getButtonIconDataAttr( $settings );
        $simple_hover_bg_color = !empty( $settings['simple_hover_background_color'] ) ? 'background-color:' . $settings['simple_hover_background_color'] : '';

        ?>
			<a itemprop="url" href="<?php echo esc_url( $link ); ?>" target="<?php echo esc_attr( $target ); ?>" <?php booth_select_inline_style( $button_styles );?> <?php booth_select_class_attribute( $button_classes );?> <?php echo booth_select_get_inline_attrs( $button_data ); ?> <?php echo booth_select_get_inline_attrs( $button_custom_attrs ); ?>>
				<span class="qodef-button-holder">
					<?php if ( $type === 'simple' ): ?>
						<span class="qodef-btn-left-line" <?php booth_select_inline_style( $simple_hover_bg_color );?>></span>
					<?php endif;?>
					<span class="qodef-btn-text"><?php echo esc_html( $settings['text'] ); ?></span>
					<?php if ( !empty( $settings['icon'] ) ): ?>
						<span class="qodef-btn-icon-holder" <?php booth_select_inline_style( $button_icon_styles );?> <?php echo booth_select_get_inline_attrs( $button_icon_data ); ?>>
							<?php \Elementor\Icons_Manager::render_icon( $settings['icon'], ['aria-hidden' => 'true'] );?>
						</span>
					<?php endif;?>
				</span>
			</a>
		<?php
}

    /**
     * @param $params
     * @return mixed
     */
    private function getButtonStyles( $params ) {
        $styles = [];

        if ( !empty( $params['color'] ) ) {
            $styles[] = 'color: ' . $params['color'];
        }

        if ( !empty( $params['background_color'] ) && $params['type'] !== 'outline' ) {
            $styles[] = 'background-color: ' . $params['background_color'];
        }

        if ( !empty( $params['border_color'] ) ) {
            $styles[] = 'border: 1px solid' . $params['border_color'];
        }

        if ( !empty( $params['font_size'] ) ) {
            $styles[] = 'font-size: ' . booth_select_filter_px( $params['font_size'] ) . 'px';
        }

        if ( !empty( $params['font_weight'] ) && $params['font_weight'] !== '' ) {
            $styles[] = 'font-weight: ' . $params['font_weight'];
        }

        if ( !empty( $params['text_transform'] ) ) {
            $styles[] = 'text-transform: ' . $params['text_transform'];
        }

        if ( !empty( $params['margin'] ) ) {
            $styles[] = 'margin: ' . $params['margin'];
        }

        if ( !empty( $params['padding'] ) ) {
            $styles[] = 'padding: ' . $params['padding'];
        }

        return $styles;
    }

    /**
     * @param $params
     * @return mixed
     */
    private function getButtonDataAttr( $params ) {
        $data = [];

        if ( !empty( $params['hover_color'] ) ) {
            $data['data-hover-color'] = $params['hover_color'];
        }

        if ( !empty( $params['hover_background_color'] ) ) {
            $data['data-hover-bg-color'] = $params['hover_background_color'];
        }

        if ( !empty( $params['hover_border_color'] ) ) {
            $data['data-hover-border-color'] = $params['hover_border_color'];
        }

        return $data;
    }

    /**
     * @param $params
     * @return mixed
     */
    private function getButtonClasses( $params ) {
        $buttonClasses = [
            'qodef-btn',
            'qodef-btn-' . $params['size'],
            'qodef-btn-' . $params['type'],
        ];

        if ( !empty( $params['hover_background_color'] ) ) {
            $buttonClasses[] = 'qodef-btn-custom-hover-bg';
        }

        if ( !empty( $params['hover_border_color'] ) ) {
            $buttonClasses[] = 'qodef-btn-custom-border-hover';
        }

        if ( !empty( $params['hover_color'] ) ) {
            $buttonClasses[] = 'qodef-btn-custom-hover-color';
        }

        if ( !empty( $params['icon'] ) ) {
            $buttonClasses[] = 'qodef-btn-icon';
        }

        if ( !empty( $params['custom_class'] ) ) {
            $buttonClasses[] = esc_attr( $params['custom_class'] );
        }

        return $buttonClasses;
    }

    /**
     * @param $params
     * @return mixed
     */
    private function getButtonIconStyles( $params ) {
        $styles = [];

        if ( !empty( $params['color'] ) ) {
            $styles[] = 'color: ' . $params['color'];
        }

        if ( !empty( $params['font_size'] ) ) {
            $styles[] = 'font-size: ' . booth_select_filter_px( $params['font_size'] ) . 'px';
        }

        if ( !empty( $params['icon_background_color'] ) ) {
            $styles[] = 'background-color: ' . $params['icon_background_color'];
        }

        return $styles;
    }

    /**
     * @param $params
     * @return mixed
     */
    private function getButtonIconDataAttr( $params ) {
        $data = [];

        if ( !empty( $params['icon_hover_background_color'] ) ) {
            $data['data-icon-hover-bg-color'] = $params['icon_hover_background_color'];
        }

        return $data;
    }

}
