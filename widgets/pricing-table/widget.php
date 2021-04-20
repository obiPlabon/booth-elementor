<?php
namespace Booth_Elementor\Widget;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Image_Size;
use Elementor\Repeater;
use Elementor\Utils;
use Elementor\Group_Control_Typography;
use Elementor\Core\Schemes\Typography;

use \Elementor\Group_Control_Background;
use \Elementor\Group_Control_Border;
use \Elementor\Group_Control_Box_Shadow;

class Pricing_Table extends Base {


    /**
     * Get widget title.
     *
     */
    public function get_title() {
        return __( 'Pricing Table', 'booth-elementor' );
    }

    public function get_keywords() {
        return ['booth', 'pricing-table', 'pricing', 'table', 'price'];
    }


    protected function register_content_controls() {

        $this->__register_price_table_controls();
        $this->__register_price_table_item_controls();

    }

    protected function __register_price_table_controls() {
		$this->start_controls_section(
			'booth_pricing_table_settings_content',
			[
				'label' => __( 'Pricing Table', 'booth-elementor' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		/* $this->add_control(
			'number_of_columns',
			[
				'label' => __( 'Number of Columns', 'booth-elementor' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'two',
				'options' => booth_select_get_number_of_columns_array( true ),
			]
		);

		$this->add_control(
			'space_between_items',
			[
				'label' => __( 'Space Between Items', 'booth-elementor' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'normal',
				'options' => booth_select_get_space_between_items_array() ,
			]
		); */

		$this->add_control(
			'skin',
			[
				'label' => __( 'Skin', 'booth-elementor' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'qodef-pt-background',
				'options' =>  [
					'qodef-pt-background' => __( 'Background', 'booth-elementor' ),
					'qodef-pt-transparent' => __( 'Transparent', 'booth-elementor' ),
					'qodef-pt-pattern' => __( 'Pattern', 'booth-elementor' ),
				],
			]
		);

        $this->end_controls_section();

	}

    protected function __register_price_table_item_controls() {
		$this->start_controls_section(
			'booth_pricing_table_item_content',
			[
				'label' => __( 'Pricing Table Item', 'booth-elementor' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'set_active_item',
			[
				'label' => __( 'Set Item As Active', 'booth-elementor' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'no',
				'options' =>  booth_select_get_yes_no_select_array( false ),
			]
		);

		$this->add_control(
			'content_background_color',
			[
				'label' => __( 'Content Background Color', 'booth-elementor' ),
				'description' => __( 'This will be applied only for Background type', 'booth-elementor' ),
				'type' => Controls_Manager::COLOR,

			]
		);

		$this->add_control(
			'title',
			[
				'label' => __( 'Title', 'booth-elementor' ),
				'label_block'=>true,
				'type' => Controls_Manager::TEXT,
				'default' =>  __( 'Basic Plan', 'booth-elementor' ),
			]
		);

		$this->add_control(
			'title_color',
			[
				'label' => __( 'Title Color', 'booth-elementor' ),
				'type' => Controls_Manager::COLOR,
				'condition' => [
                    'title!' => '',
                ],

			]
		);

		$this->add_control(
			'price',
			[
				'label' => __( 'Price', 'booth-elementor' ),
				'type' => Controls_Manager::TEXT,
				'default' =>  '100',
				// 'input_type' =>  'number',

			]
		);

		$this->add_control(
			'price_color',
			[
				'label' => __( 'Price Color', 'booth-elementor' ),
				'type' => Controls_Manager::COLOR,
				'condition' => [
                    'price!' => '',
                ],

			]
		);

		$this->add_control(
			'currency',
			[
				'label' => __( 'Currency', 'booth-elementor' ),
				'type' => Controls_Manager::TEXT,
				'default' =>  '$',
				'description' =>  __( 'Default mark is $', 'booth-elementor' ),

			]
		);

		$this->add_control(
			'currency_color',
			[
				'label' => __( 'Currency Color', 'booth-elementor' ),
				'type' => Controls_Manager::COLOR,
				'condition' => [
                    'currency!' => '',
                ],

			]
		);

		$this->add_control(
			'price_period',
			[
				'label' => __( 'Price Period', 'booth-elementor' ),
				'type' => Controls_Manager::TEXT,
				'default' => 'monthly',
				'description' => __( 'Default label is monthly', 'booth-elementor' ),

			]
		);

		$this->add_control(
			'price_period_color',
			[
				'label' => __( 'Price Period Color', 'booth-elementor' ),
				'type' => Controls_Manager::COLOR,
				'condition' => [
                    'price_period!' => '',
                ],

			]
		);

		$this->add_control(
			'button_text',
			[
				'label' => __( 'Button Text', 'booth-elementor' ),
				'type' => Controls_Manager::TEXT,
				'default' => 'Buy Ticket',

			]
		);

		$this->add_control(
			'link',
			[
				'label' => __( 'Button Link', 'booth-elementor' ),
				'type' => Controls_Manager::TEXT,
				'condition' => [
                    'button_text!' => '',
                ],

			]
		);

		$this->add_control(
			'target',
			[
				'label' => __( 'Link Target', 'booth-elementor' ),
				'type' => Controls_Manager::SELECT,
				'default' => '_self',
				'options' =>  booth_select_get_link_target_array(),
				'condition' => [
                    'link!' => '',
                ],
			]
		);

		/* $this->add_control(
			'button_link',
			[
				'label' => __( 'Button Link', 'booth-elementor' ),
				'type' => Controls_Manager::URL,
				'placeholder' => __( 'https://your-link.com', 'booth-elementor' ),
				'show_external' => true,
				'default' => [
					'url' => '',
					'is_external' => true,
					'nofollow' => true,
				],
			]
		); */

		$this->add_control(
			'button_type',
			[
				'label' => __( 'Button Type', 'booth-elementor' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'solid',
				'options' =>  [
					'solid'   => __( 'Solid', 'booth-elementor' ),
					'outline' => __( 'Outline', 'booth-elementor' ),
					'simple'  => __( 'Simple', 'booth-elementor' ),
				],
				'condition' => [
                    'button_text!' => '',
                ],
			]
		);

		$this->add_control(
			'button_text_color',
			[
				'label' => __( 'Button Text Color', 'booth-elementor' ),
				'type' => Controls_Manager::COLOR,
				'condition' => [
                    'button_text!' => '',
                ],

			]
		);

		$this->add_control(
			'content',
			[
				'label' => __( 'Content', 'booth-elementor' ),
				'type' => Controls_Manager::WYSIWYG,
				'default' => '<ul>
								<li>content content content</li>
								<li>content content content</li>
								<li>content content content</li>
							</ul>',

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
    protected function register_style_controls() {

    }

    /**
     * @return null
     */
    protected function render() {
        // return;
        $settings = $this->get_settings_for_display();

		$holder_class = $this->getHolderClasses( $settings );

        ?>
			<div class="qodef-pricing-tables qodef-grid-list qodef-disable-bottom-space clearfix  <?php echo esc_attr( $holder_class ); ?>">
				<div class="qodef-pt-wrapper qodef-outer-space">

					<?php $this->render_item( $settings ); ?>

				</div>
			</div>
		<?php
	}

	/**
     * @return null
     */
    protected function render_item($settings) {

		$currency	= $settings['currency'];
		$price	= $settings['price'];
		$title	= $settings['title'];
		$price_period	= $settings['price_period'];
		$content	= $settings['content'];
		$link	= $settings['link'];
		$target	= $settings['target'];
		$button_text_color	= $settings['button_text_color'];

		$holder_classes      = $this->getInnerHolderClasses( $settings );
		$holder_styles       = $this->getHolderStyles( $settings );
		$title_styles        = $this->getTitleStyles( $settings );
		$price_styles        = $this->getPriceStyles( $settings );
		$currency_styles     = $this->getCurrencyStyles( $settings );
		$price_period_styles = $this->getPricePeriodStyles( $settings );
		$button_type         = ! empty( $settings['button_type'] ) ? $settings['button_type'] : 'outline';

		?>
				<div class="qodef-price-table qodef-item-space <?php echo esc_attr($holder_classes); ?>">
					<div class="qodef-pt-inner" <?php echo booth_select_get_inline_style($holder_styles); ?>>
						<ul>
							<li class="qodef-pt-prices">
								<sup class="qodef-pt-value" <?php echo booth_select_get_inline_style($currency_styles); ?>><?php echo esc_html($currency); ?></sup>
								<span class="qodef-pt-price" <?php echo booth_select_get_inline_style($price_styles); ?>><?php echo esc_html($price); ?></span>

							</li>
							<li class="qodef-pt-title-holder">
								<h5 class="qodef-pt-title" <?php echo booth_select_get_inline_style($title_styles); ?>><?php echo esc_html($title); ?></h5>
								<span class="qodef-pt-mark" <?php echo booth_select_get_inline_style($price_period_styles); ?>><?php echo esc_html($price_period); ?></span>
							</li>
							<li class="qodef-pt-content">
								<?php echo $this->parse_text_editor( $content ); ?>
							</li>
							<?php
							if(!empty($button_text)) { ?>
								<li class="qodef-pt-button">
									<?php echo booth_select_get_button_html(array(
										'link'     => $link,
										'target'   => $target,
										'text'     => $button_text,
										'type'     => $button_type,
										'color'    => $button_text_color,
										'size'     => 'medium'
									)); ?>
								</li>
							<?php } ?>
						</ul>
					</div>
				</div>
		<?php


	}


    /**
     * @param $params
     */
	private function getHolderClasses( $params ) {
		$holderClasses = array();

		// $holderClasses[] = ! empty( $params['number_of_columns'] ) ? 'qodef-' . $params['number_of_columns'] . '-columns' : 'qodef-three-columns';
		// $holderClasses[] = ! empty( $params['space_between_items'] ) ? 'qodef-' . $params['space_between_items'] . '-space' : 'qodef-normal-space';
		$holderClasses[] = ! empty( $params['skin'] ) ? $params['skin'] : '';

		return implode( ' ', $holderClasses );
	}

    private function getInnerHolderClasses( $params ) {
		$holderClasses = array();

		$holderClasses[] = ! empty( $params['custom_class'] ) ? esc_attr( $params['custom_class'] ) : '';
		$holderClasses[] = $params['set_active_item'] === 'yes' ? 'qodef-pt-active-item' : '';

		return implode( ' ', $holderClasses );
	}

	private function getHolderStyles( $params ) {
		$itemStyle = array();

		if ( ! empty( $params['content_background_color'] ) ) {
			$itemStyle[] = 'background-color: ' . $params['content_background_color'];
		}

		return implode( ';', $itemStyle );
	}

	private function getTitleStyles( $params ) {
		$itemStyle = array();

		if ( ! empty( $params['title_color'] ) ) {
			$itemStyle[] = 'color: ' . $params['title_color'];
		}

		return implode( ';', $itemStyle );
	}

	private function getPriceStyles( $params ) {
		$itemStyle = array();

		if ( ! empty( $params['price_color'] ) ) {
			$itemStyle[] = 'color: ' . $params['price_color'];
		}

		return implode( ';', $itemStyle );
	}

	private function getCurrencyStyles( $params ) {
		$itemStyle = array();

		if ( ! empty( $params['currency_color'] ) ) {
			$itemStyle[] = 'color: ' . $params['currency_color'];
		}

		return implode( ';', $itemStyle );
	}

	private function getPricePeriodStyles( $params ) {
		$itemStyle = array();

		if ( ! empty( $params['price_period_color'] ) ) {
			$itemStyle[] = 'color: ' . $params['price_period_color'];
		}

		return implode( ';', $itemStyle );
	}

}
