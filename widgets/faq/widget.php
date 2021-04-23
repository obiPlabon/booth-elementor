<?php
namespace Booth_Elementor\Widget;


class Faq extends Base {

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
        return __( 'Faq', 'booth-elementor' );
    }

	public function get_keywords() {
		return ['booth', 'faq'];
	}

	public function get_script_depends() {
		return [ 'jquery-ui-accordion' ];
	}

    protected function register_content_controls() {

		self::$widget->__start('accordion_settings_content', __('Accordion','booth-elementor'));

		self::$widget->select_control( 'style', __('Style','booth-elementor'), 'accordion',
			[
				'accordion'=> __( 'Accordion', 'booth-elementor' ),
				'toggle'=> __( 'Toggle', 'booth-elementor' ),
			]
		);

		self::$widget->select_control( 'background_skin', __( 'Background Skin','booth-elementor'), 'default',
			[
				'default'=> __( 'Default', 'booth-elementor' ),
				'white'=> __( 'White', 'booth-elementor' ),
			]
		);


		self::$widget->switcher_control('switcher_test','Button');

		$repeater = self::$widget->create_repeater();

		$repeater->text_control('title',__('Title','booth-elementor'));


		$repeater->select_control( 'title_tag', __( 'Title Tag','booth-elementor'), 'h5',
			[
				'h1'=> __( 'H1', 'booth-elementor' ),
				'h2'=> __( 'H2', 'booth-elementor' ),
				'h2'=> __( 'H2', 'booth-elementor' ),
				'h3'=> __( 'H3', 'booth-elementor' ),
				'h4'=> __( 'H4', 'booth-elementor' ),
				'h5'=> __( 'H5', 'booth-elementor' ),
				'h6'=> __( 'H6', 'booth-elementor' ),
				'p'=> __( 'p', 'booth-elementor' ),
			]
		);

		$repeater->wysiwyg_control('desc',__('Content','booth-elementor'));

		$repeater_default = [
			'default' => [
				[
					'title' => __( 'Title #1', 'booth-elementor' ),
					'desc' => __( 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Illum rem corrupti iusto facere animi eaque repellat nobis corporis tenetur alias perferendis non voluptatum, voluptates esse mollitia magnam asperiores fugiat necessitatibus.', 'booth-elementor' ),
				],
				[
					'title' => __( 'Title #2', 'plugin-domain' ),
					'desc' => __( 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Illum rem corrupti iusto facere animi eaque repellat nobis corporis tenetur alias perferendis non voluptatum, voluptates esse mollitia magnam asperiores fugiat necessitatibus.', 'plugin-domain' ),
				],
			],
		];

		self::$widget->repater_control($repeater,'faq_list','title',$repeater_default);

		self::$widget->text_control('custom_class',__('Custom CSS Class','booth-elementor'),'','',false,
			[
			'label_block'=>true,
			'description'=>__('Style particular content element differently - add a class name and refer to it in custom CSS','booth-elementor')
			]
		);

		self::$widget->__end();

    }

    protected function register_style_controls() {

	}

	protected function render() {
		// return;
		$settings = $this->get_settings_for_display();
		$holder_classes = $this->getHolderClasses( $settings );
		?>
		<div class="qodef-accordion-holder <?php echo esc_attr($holder_classes); ?> clearfix">
			<?php foreach ($settings['faq_list'] as $key => $value) : ?>
				<?php if($value['title']):?>
					<<?php echo tag_escape($value['title_tag']); ?> class="qodef-accordion-title">
						<span class="qodef-accordion-mark">
							<span class="qodef_icon_plus icon_plus"></span>
							<span class="qodef_icon_minus icon_close"></span>
						</span>
						<span class="qodef-tab-title"><?php esc_html_e($value['title']); ?></span>
					</<?php echo tag_escape($value['title_tag']); ?>>
				<?php endif;?>
				<?php if( $value['desc']):?>
					<div class="qodef-accordion-content">
						<div class="qodef-accordion-content-inner">
							<?php echo $this->parse_text_editor( $value['desc'] ); ?>
						</div>
					</div>
				<?php endif;?>
			<?php endforeach; ?>
		</div>
		<?php
	}

	private function getHolderClasses( $params ) {
		$holder_classes = ['qodef-ac-default' ];

		$holder_classes[] = ! empty( $params['custom_class'] ) ? esc_attr( $params['custom_class'] ) : '';

		$holder_classes[] = $params['style'] == 'toggle' ? 'qodef-toggle' : 'qodef-accordion';

		$holder_classes[] = ! empty( $params['background_skin'] ) ? 'qodef-' . esc_attr( $params['background_skin'] ) . '-skin' : '';

		return implode( ' ', $holder_classes );
	}

}
