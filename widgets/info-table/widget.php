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

class Info_Table extends Base {

    /**
     * Get widget title.
     *
     */
    public function get_title() {
        return __( 'Info Table', 'booth-elementor' );
    }

    public function get_keywords() {
        return ['booth', 'info-table'];
    }

    protected function register_content_controls() {

        $this->__register_info_table_controls();
        $this->__register_info_table_item_controls();

    }

    protected function __register_info_table_controls() {
		$this->start_controls_section(
			'booth_info_table_content',
			[
				'label' => __( 'Info Table', 'booth-elementor' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'skin',
			[
				'label' => __( 'Choose a skin for Info Table', 'booth-elementor' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'light',
				'options' =>  [
					'light' => __( 'Light Skin', 'booth-elementor' ),
					'dark' => __( 'Dark Skin', 'booth-elementor' ),
				],
			]
		);

		$this->add_control(
			'label_width',
			[
				'label' => __( 'Label Width', 'booth-elementor' ),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' =>  [
					'' => __( 'Fixed Width', 'booth-elementor' ),
					'auto_width' => __( 'Auto Width', 'booth-elementor' ),
				],
			]
		);

        $this->end_controls_section();

	}

    protected function __register_info_table_item_controls() {
		$this->start_controls_section(
			'booth_info_table_item_content',
			[
				'label' => __( 'Info Table Item', 'booth-elementor' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'label',
			[
				'label' => __( 'Label', 'booth-elementor' ),
				'label_block'=>true,
				'type' => Controls_Manager::TEXT,
				'default' =>  __( 'EMAIL:', 'booth-elementor' ),
			]
		);

		$repeater->add_control(
			'link',
			[
				'label' => __( 'Link', 'booth-elementor' ),
				'label_block'=>true,
				'type' => Controls_Manager::TEXT,
			]
		);

		$repeater->add_control(
			'link_text',
			[
				'label' => __( 'Link Text', 'booth-elementor' ),
				'label_block'=>true,
				'type' => Controls_Manager::TEXT,
				'condition' => [
                    'link!' => '',
                ],
			]
		);

		$repeater->add_control(
			'target',
			[
				'label' => __( 'Target', 'booth-elementor' ),
				'type' => Controls_Manager::SELECT,
				'default' => '_self',
				'options' =>  booth_select_get_link_target_array(),
				'condition' => [
                    'link!' => '',
                ],
			]
		);

		$this->add_control(
			'info_list',
			[
				'label' => __( 'Info Table Item', 'booth-elementor' ),
				'type' => Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'show_label' => false,
				'prevent_empty' => false,
				'default' => [
					[
						'label' => __( 'Email:', 'booth-elementor' ),
						'link' => '#',
						'link_text' => 'Email Text'
					],
					[
						'label' => __( 'Twitter:', 'booth-elementor' ),
						'link' => '#',
						'link_text' => 'Twitter Text'
					],
				],
				'title_field' => '{{{ label }}}',
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

		$holder_classes = $this->getHolderClass( $settings );

        ?>

			<div class="qodef-info-table <?php echo esc_attr($holder_classes); ?>">
				<?php
					if($settings['info_list']):
						foreach ($settings['info_list'] as $key => $item) :
							$this->info_table_item( $item );
						endforeach;
					endif;
				?>
			</div>


		<?php
	}

	private function getHolderClass( $params ) {
		$holderClasses = array();

		if( $params['skin'] === 'light' ) {
			$holderClasses[] = 'qodef-it-light-skin';
		}

		if( $params['label_width'] === 'auto_width' ) {
			$holderClasses[] = 'qodef-it-label-auto-width';
		}

		return implode( ' ', $holderClasses );
	}

	private function info_table_item( $item ) {
		?>
			<div class="qodef-info-table-item">
				<?php if( ! empty($item['label']) ): ?>
					<span class="qodef-it-label"><?php echo esc_html($item['label']); ?></span>
				<?php endif; ?>
				<?php if( ! empty($item['link_text']) ): ?>
					<a class="qodef-it-link" itemprop="url" href="<?php echo esc_url($item['link']); ?>" target="<?php echo esc_attr($item['target']); ?>"><span><?php echo esc_html($item['link_text']); ?></span></a>
				<?php endif; ?>
			</div>
		<?php
	}

}
