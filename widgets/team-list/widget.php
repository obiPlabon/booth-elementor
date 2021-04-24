<?php
namespace Booth_Elementor\Widget;

use Elementor\Controls_Manager;
class Team_List extends Base {

    /**
     * Get widget title.
     *
     */
    public function get_title() {
        return __( 'Team List', 'booth-elementor' );
    }

    public function get_keywords() {
        return ['booth', 'team-list', 'team', 'list'];
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

		$this->start_controls_section(
			'team_list_settings_content',
			[
				'label' => __( 'Team List', 'booth-elementor' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'team_member_layout',
			[
				'label' => __( 'Team Member Layout', 'booth-elementor' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'info-bellow',
				'options' => [
					'info-bellow' => __( 'Alternating', 'booth-elementor' ),
					'info-hover'  => __( 'Info on Hover', 'booth-elementor' ),
				],
			]
		);

		$this->add_control(
			'team_member_popup',
			[
				'label' => __( 'Team Member Popup', 'booth-elementor' ),
				'type' => Controls_Manager::SELECT,
				'description' => __( 'Enable this option to show additional info about team member in modal popup', 'booth-elementor' ),
				'default' => 'no',
				'options' => booth_select_get_yes_no_select_array( false, false ),
			]
		);

		$this->add_control(
			'number_of_columns',
			[
				'label' => __( 'Number of Columns', 'booth-elementor' ),
				'type' => Controls_Manager::SELECT,
				'description' => __( 'Default value is Three', 'booth-elementor' ),
				'default' => 'three',
				'options' => booth_select_get_number_of_columns_array( true ),
                'condition'   => [
                    'team_member_layout' => 'info-hover',
                ],
			]
		);

		$this->add_control(
			'number_of_columns_alternating',
			[
				'label' => __( 'Number of Columns', 'booth-elementor' ),
				'type' => Controls_Manager::SELECT,
				'description' => __( 'Default value is Three', 'booth-elementor' ),
				'default' => '',
				'options' => booth_select_get_number_of_columns_array( true, ['five', 'six'] ),
                'condition'   => [
                    'team_member_layout' => 'info-bellow',
                ],
			]
		);

		$this->add_control(
			'space_between_items',
			[
				'label' => __( 'Space Between Items', 'booth-elementor' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'normal',
				'options' => booth_select_get_space_between_items_array(),
			]
		);

		$this->add_control(
			'number_of_items',
			[
				'label' => __( 'Number of team members per page', 'booth-elementor' ),
				'description' => __( 'Set number of items for your team list. Enter -1 to show all.', 'booth-elementor' ),
				'type' => Controls_Manager::NUMBER,
				'min' => '-1',
				'max' => '1000',
				'step' => '1',
				'dynamic' => [
					'active' => false,
				],
			]
		);

        $this->add_control(
            'category',
            [
                'label'   => __( 'One-Category Team List', 'booth-elementor' ),
				'label_block' => true,
                'type'    => Controls_Manager::SELECT2,
                'description' => __( 'Select category item (leave empty for showing all categories)', 'booth-elementor' ),
                'default' => '',
                'options' => self::get_taxonomies(),
				'multiple' => false,
            ]
        );

        $this->add_control(
            'selected_members',
            [
                'label'   => __( 'Show Only Members with Listed IDs', 'booth-elementor' ),
				'label_block' => true,
                'type'    => Controls_Manager::SELECT2,
                'description' => __( 'Select post item (leave empty for all)', 'booth-elementor' ),
                'default' => '',
                'options' => self::get_posts(),
				'multiple' => true,
            ]
        );

		$this->add_control(
			'orderby',
			[
				'label' => __( 'Order By', 'booth-elementor' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'date',
				'options' => booth_select_get_query_order_by_array(),
			]
		);

		$this->add_control(
			'order',
			[
				'label' => __( 'Order', 'booth-elementor' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'ASC',
				'options' => booth_select_get_query_order_array(),
			]
		);

		$this->add_control(
			'team_member_name_color',
			[
				'label' => __( 'Team Member Name Color', 'booth-elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'condition' => [
                    'team_member_layout' => 'info-bellow',
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
