<?php
namespace Booth_Elementor\Widget;

class Team_List extends Base {

    /**
     * @var mixed
     */
    protected static $widget;

    /**
     * @param array $data
     * @param $args
     */
    public function __construct( $data = [], $args = null ) {
        parent::__construct( $data, $args );
        self::$widget = new Control_Ui( $this );

        // add_action( 'elementor/frontend/before_enqueue_scripts', [ $this, 'scripts_enqueue' ] );
        // add_action( 'elementor/editor/after_enqueue_scripts', [ $this, 'scripts_enqueue' ] );
    }

    /**
     * Get widget title.
     *
     */
    public function get_title() {
        return __( 'Team List', 'booth-elementor' );
    }

    public function get_keywords() {
        return ['booth', 'team-list'];
    }

    public function scripts_register() {
        wp_register_script( 'booth-jquery-plugin', BOOTH_ELEMENTOR_ASSETS . '/vendor/js/jquery.plugin.js', [ 'jquery', 'booth-select-modules' ], false, true );
        wp_register_script( 'booth-countdown', BOOTH_ELEMENTOR_ASSETS . '/vendor/js/jquery.countdown.min.js', [ 'jquery', 'booth-select-modules' ], false, true );
    }

    public function scripts_enqueue() {
        wp_enqueue_script( 'booth-jquery-plugin', BOOTH_ELEMENTOR_ASSETS . '/vendor/js/jquery.plugin.js', [ 'jquery', 'booth-select-modules' ], false, true );
        wp_enqueue_script( 'booth-countdown', BOOTH_ELEMENTOR_ASSETS . '/vendor/js/jquery.countdown.min.js', [ 'jquery', 'booth-select-modules' ], false, true );
    }

    public function get_script_depends() {

        $this->scripts_register();

        return [
            'booth-jquery-plugin',
            'booth-countdown',
        ];
    }

    public function get_year() {
        return [
            '2018' => '2018',
            '2019' => '2019',
            '2020' => '2020',
            '2021' => '2021',
            '2022' => '2022',
        ];
    }

    public function get_month() {
        return [
            '1'  => esc_html__( 'January', 'booth-elementor' ),
            '2'  => esc_html__( 'February', 'booth-elementor' ),
            '3'  => esc_html__( 'March', 'booth-elementor' ),
            '4'  => esc_html__( 'April', 'booth-elementor' ),
            '5'  => esc_html__( 'May', 'booth-elementor' ),
            '6'  => esc_html__( 'June', 'booth-elementor' ),
            '7'  => esc_html__( 'July', 'booth-elementor' ),
            '8'  => esc_html__( 'August', 'booth-elementor' ),
            '9'  => esc_html__( 'September', 'booth-elementor' ),
            '10' => esc_html__( 'October', 'booth-elementor' ),
            '11' => esc_html__( 'November', 'booth-elementor' ),
            '12' => esc_html__( 'December', 'booth-elementor' ),
        ];
    }

    public function get_day() {
        return [
            '1'  => '1',
            '2'  => '2',
            '3'  => '3',
            '4'  => '4',
            '5'  => '5',
            '6'  => '6',
            '7'  => '7',
            '8'  => '8',
            '9'  => '9',
            '10' => '10',
            '11' => '11',
            '12' => '12',
            '13' => '13',
            '14' => '14',
            '15' => '15',
            '16' => '16',
            '17' => '17',
            '18' => '18',
            '19' => '19',
            '20' => '20',
            '21' => '21',
            '22' => '22',
            '23' => '23',
            '24' => '24',
            '25' => '25',
            '26' => '26',
            '27' => '27',
            '28' => '28',
            '29' => '29',
            '30' => '30',
            '31' => '31',
        ];
    }

    public function get_hour() {
        return [
            '0'  => '0',
            '1'  => '1',
            '2'  => '2',
            '3'  => '3',
            '4'  => '4',
            '5'  => '5',
            '6'  => '6',
            '7'  => '7',
            '8'  => '8',
            '9'  => '9',
            '10' => '10',
            '11' => '11',
            '12' => '12',
            '13' => '13',
            '14' => '14',
            '15' => '15',
            '16' => '16',
            '17' => '17',
            '18' => '18',
            '19' => '19',
            '20' => '20',
            '21' => '21',
            '22' => '22',
            '23' => '23',
            '24' => '24',
        ];
    }

    /**
     * Get a list of All Post Types
     *
     * @return array
     */
    public static function get_posts() {
        $args = [
            'post_status' => 'publish',
            'post_type'   => 'team-member',
            'posts_per_page'   => '-1',
        ];

        $posts = get_posts( $args );
        $options = [];
        // $options[$item->ID] = $item->post_title;
        foreach ( $posts as $key => $item ) {
            $options[$item->ID] = $item->post_title;
        }

        return $options;
    }

    /**
     * Get a list of Taxonomy
     *
     * @return array
     */
    public static function get_taxonomies() {
        $args = [
            'taxonomy'   => 'team-category',
            'hide_empty' => true,
        ];
        $terms = get_terms( $args );
        $options = [];
        foreach ( $terms as $key => $item ) {
            $options[$item->slug] = $item->name;
        }

        return $options;
    }

    protected function register_content_controls() {

        self::$widget->__start( 'team_list_settings_content', __( 'Team List', 'booth-elementor' ) );

        self::$widget->select_control( 'team_member_layout', __( 'Team Member Layout', 'booth-elementor' ), 'info-bellow',
            [
                'info-bellow' => __( 'Alternating', 'booth-elementor' ),
                'info-hover'  => __( 'Info on Hover', 'booth-elementor' ),
            ]
        );

        self::$widget->select_control( 'team_member_popup', __( 'Team Member Popup', 'booth-elementor' ), 'no', booth_select_get_yes_no_select_array( false, false ),
            [
                'description' => __( 'Enable this option to show additional info about team member in modal popup', 'booth-elementor' ),
            ]
        );

        self::$widget->select_control( 'number_of_columns', __( 'Number of Columns', 'booth-elementor' ), 'three',
            booth_select_get_number_of_columns_array( true ),
            [
                'description' => __( 'Default value is Three', 'booth-elementor' ),
                'condition'   => [
                    'team_member_layout' => 'info-hover',
                ],
            ]
        );

        self::$widget->select_control( 'number_of_columns_alternating', __( 'Number of Columns', 'booth-elementor' ), '',
            booth_select_get_number_of_columns_array( true, ['five', 'six'] ),
            [
                'description' => __( 'Default value is Three', 'booth-elementor' ),
                'condition'   => [
                    'team_member_layout' => 'info-bellow',
                ],
            ]
        );

        self::$widget->select_control( 'space_between_items', __( 'Space Between Items', 'booth-elementor' ), 'normal',
            booth_select_get_space_between_items_array()
        );

        self::$widget->number_control( 'number_of_items', __( 'Number of team members per page', 'booth-elementor' ), '-1', '', '-1', '1000', '1', false,
            [
                'description' => __( 'Set number of items for your team list. Enter -1 to show all.', 'booth-elementor' ),
            ]
        );

        self::$widget->select2_control( 'category', __( 'One-Category Team List', 'booth-elementor' ), '', self::get_taxonomies(), true,
            [
                'label_block' => true,
                'description' => __( 'Select category item (leave empty for showing all categories)', 'booth-elementor' ),
            ]
        );

        self::$widget->select2_control( 'selected_members', __( 'Show Only Members with Listed IDs', 'booth-elementor' ), '', self::get_posts(), true,
            [
                'label_block' => true,
                'description' => __( 'Select post item (leave empty for all)', 'booth-elementor' ),
            ]
        );

        self::$widget->select_control( 'orderby', __( 'Order By', 'booth-elementor' ), 'date', booth_select_get_query_order_by_array() );

        self::$widget->select_control( 'order', __( 'Order', 'booth-elementor' ), 'ASC', booth_select_get_query_order_array() );

        self::$widget->color_control( 'team_member_name_color', __( 'Team Member Name Color', 'booth-elementor' ), '', [],
            // [
            //     '{{WRAPPER}} .somethisn' => 'color: {{VALUE}}',
            // ],
            [
                'condition' => [
                    'team_member_layout' => 'info-bellow',
                ],
            ]
        );

        /* self::$widget->select_control( 'skin', __( 'Skin','booth-elementor'), '',
        [
        ''=> __( 'Default', 'booth-elementor' ),
        'qodef-light-skin'=> __( 'Light', 'booth-elementor' ),
        ]
        );
        self::$widget->select_control( 'month', __( 'Month','booth-elementor'), '',$this->get_month());

        self::$widget->select_control( 'day', __( 'Day','booth-elementor'), '',$this->get_day());
        self::$widget->select_control( 'hour', __( 'Hour','booth-elementor'), '',$this->get_hour());
        self::$widget->select_control( 'minute', __( 'Minute','booth-elementor'), '',$this->get_minute());

        self::$widget->text_control('day_label',__('Day Label','booth-elementor'),__('Days','booth-elementor'));
        self::$widget->text_control('hour_label',__('Hours Label','booth-elementor'),__('Hours','booth-elementor'));
        self::$widget->text_control('minute_label',__('Minutes Label','booth-elementor'),__('Minutes','booth-elementor'));
        self::$widget->text_control('second_label',__('Seconds Label','booth-elementor'),__('Seconds','booth-elementor'));

        self::$widget->number_control('digit_font_size',__('Digit Font Size (px)','booth-elementor'),'','','0','1000','1');
        self::$widget->number_control('label_font_size',__('Label Font Size(px)','booth-elementor'),'','','0','1000','1'); */

        // $range = [
        //     'px' => [
        //         'min' => 0,
        //         'max' => 1000,
        //         'step' => 1,
        //     ],
        // ];
        // self::$widget->slider_control('digit_font_size',__('Digit Font Size','booth-elementor'),[ 'px'],$range);
        // self::$widget->slider_control('label_font_size',__('Label Font Size','booth-elementor'),[ 'px'],$range);

        /* self::$widget->text_control('custom_class',__('Custom CSS Class','booth-elementor'),'','',false,
        [
        'label_block'=>true,
        'description'=>__('Style particular content element differently - add a class name and refer to it in custom CSS','booth-elementor')
        ]
        ); */

        self::$widget->__end();

    }

    protected function register_style_controls() {

    }

    /**
     * @return null
     */
    protected function render() {
        // return;
        $settings = $this->get_settings_for_display();

        if ( !empty( $settings['number_of_columns_alternating'] ) ) {
            $settings['number_of_columns'] = $settings['number_of_columns_alternating'];
        }

		$args = [
            'post_status'    => 'publish',
            'post_type'      => 'team-member',
            'posts_per_page' => $settings['number_of_items'],
            'orderby'        => $settings['orderby'],
            'order'          => $settings['order'],
        ];

        if ( !empty( $settings['category'] ) ) {
            $args['team-category'] = $settings['category'];
        }


        if ( !empty( $settings['selected_members'] ) ) {
            $args['orderby'] = 'post__in';
            $args['post__in'] = $settings['selected_members'];
        }

        $query_results = new \WP_Query( $args );

        $holder_classes = $this->getHolderClasses( $settings );
        $data_attrs = $this->getDataAttribute( $settings );

		$settings['this_object'] = $this;

        ?>

		<div class="qodef-team-list-holder qodef-grid-list qodef-disable-bottom-space <?php echo esc_attr($holder_classes); ?>" <?php echo booth_select_get_inline_attrs($data_attrs); ?>>
			<div class="qodef-tl-inner qodef-outer-space">
				<?php
					if($query_results->have_posts()):
						while ( $query_results->have_posts() ) : $query_results->the_post();
							$settings['member_id'] = get_the_ID();
							echo booth_select_execute_shortcode('qodef_team_member', $settings);
						endwhile;
					else:
						esc_html_e( 'Sorry, no posts matched your criteria.', 'booth-elementor' );
					endif;

					wp_reset_postdata();
				?>
			</div>
		</div>

		<?php
	}


    /**
     * @param $params
     */
    public function getHolderClasses( $params ) {
        $classes = [];

        $classes[] = !empty( $params['number_of_columns'] ) ? 'qodef-' . $params['number_of_columns'] . '-columns' : 'qodef-three-columns';

        $classes[] = !empty( $params['space_between_items'] ) ? 'qodef-' . $params['space_between_items'] . '-space' : 'qodef-normal-space';

        $classes[] = !empty( $params['team_member_popup'] ) && $params['team_member_popup'] === 'yes' ? 'qodef-team-popup' : '';

        return implode( ' ', $classes );
    }

    /**
     * @param $params
     * @param $args
     * @return mixed
     */
    private function getDataAttribute( $params ) {
        $data_attrs = [];

        $data_attrs['data-number-of-columns'] = !empty( $params['number_of_columns'] ) ? $params['number_of_columns'] : 'three';

        $data_attrs['data-enable-navigation'] = !empty( $params['slider_navigation'] ) ? $params['slider_navigation'] : '';

        $data_attrs['data-enable-pagination'] = !empty( $params['slider_pagination'] ) ? $params['slider_pagination'] : '';

        return $data_attrs;
    }

}
