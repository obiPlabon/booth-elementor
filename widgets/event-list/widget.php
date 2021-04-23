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

class Event_List extends Base {

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
    }

    /**
     * Get widget title.
     *
     */
    public function get_title() {
        return __( 'Event List', 'booth-elementor' );
    }

    public function get_keywords() {
        return ['booth', 'event-list', 'event', 'list'];
    }

    /**
     * Get a list of All Post Types
     *
     * @return array
     */
    public static function get_posts() {
        $args = [
            'post_status'    => 'publish',
            'post_type'      => 'events',
            'posts_per_page' => '-1',
        ];

        $posts = get_posts( $args );
        $options = [];
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
            'taxonomy'   => 'events_category',
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
			'events_settings_content',
			[
				'label' => __( 'Event List', 'booth-elementor' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'list_title',
			[
				'label' => __( 'Event List Title', 'booth-elementor' ),
				'type' => Controls_Manager::TEXT,
			]
		);

		$this->add_control(
			'number_of_events',
			[
				'label' => __( 'Number of Events', 'booth-elementor' ),
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
			'category',
			[
				'label' => __( 'One Category List', 'booth-elementor' ),
				'type' => Controls_Manager::SELECT2,
				'description' => __( 'Enter one category slug (leave empty for showing all categories)', 'booth-elementor' ),
				'default' => '',
				'options' => self::get_taxonomies(),
				'multiple' => false,
			]
		);

		$this->add_control(
			'selected_events',
			[
				'label' => __( 'Show Only Events with Listed IDs', 'booth-elementor' ),
				'type' => Controls_Manager::SELECT2,
				'description' => __( 'Enter events ids (leave empty for all)', 'booth-elementor' ),
				'default' => '',
				'options' => self::get_posts(),
				'multiple' => true,
			]
		);

		$this->add_control(
			'title_tag',
			[
				'label' => __( 'Title Tag', 'booth-elementor' ),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => booth_select_get_title_tag( true ),
			]
		);

		$this->add_control(
			'enable_button',
			[
				'label' => __( 'Enable Button', 'booth-elementor' ),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' =>  booth_select_get_yes_no_select_array('false', 'true'),
			]
		);

		$this->add_control(
			'show_time',
			[
				'label' => __( 'Show Event Time', 'booth-elementor' ),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' =>  booth_select_get_yes_no_select_array('false', 'true'),
			]
		);

		$this->add_control(
			'skin',
			[
				'label' => __( 'Event List Skin', 'booth-elementor' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'dark',
				'options' =>  [
					'light' => __( 'Light', 'booth-elementor' ),
					'dark' => __( 'Dark', 'booth-elementor' ),
				],
			]
		);

		$this->add_control(
			'pattern_background',
			[
				'label' => __( 'Enable Pattern Background', 'booth-elementor' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'yes',
				'options' =>  booth_select_get_yes_no_select_array('true', 'true'),
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

		$args = [
            'post_status'    => 'publish',
            'post_type'      => 'events',
            'posts_per_page' => $settings['number_of_events'],
            'orderby'        => $settings['orderby'],
            'order'          => $settings['order'],
        ];

        if ( !empty( $settings['category'] ) ) {
            $args['events_category'] = $settings['category'];
        }


        if ( !empty( $settings['selected_events'] ) ) {
            $args['post__in'] = $settings['selected_events'];
        }

        $query_results = new \WP_Query( $args );

        $holder_classes = $this->getHolderClasses( $settings );
		$title_tag = ! empty( $settings['title_tag'] ) ? $settings['title_tag'] : 'h5';

        ?>
			<div class="qodef-event-list-holder qodef-grid-list qodef-el-table <?php echo esc_attr( $holder_classes ); ?>">
				<div class="qodef-el-wrapper qodef-outer-space">
					<?php if(!empty($list_title)) : ?>
						<h3 class="qodef-el-main-title"><?php echo esc_html($list_title); ?></h3>
					<?php endif; ?>
					<?php
					if ( $query_results->have_posts() ):
						while ( $query_results->have_posts() ) : $query_results->the_post();
							?>
							<div class="qodef-el-item qodef-item-space">
								<div class="qodef-eli-inner">
									<div class="qodef-eli-content">
										<div class="qodef-eli-content-inner">
											<?php
												echo $this->info_markup( $settings,$title_tag );
											?>
										</div>
									</div>
								</div>
							</div>
							<?php
						endwhile;
					else:
						?>
							<p class="qodef-el-not-found"><?php esc_html_e( 'Sorry, no posts matched your criteria.', 'booth' ); ?></p>
						<?php
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
	private function getHolderClasses( $params ) {
		$holderClasses = array();

		$holderClasses[] = ! empty( $params['custom_class'] ) ? esc_attr( $params['custom_class'] ) : '';

		if( $params['enable_button'] === 'yes' ) {
			$holderClasses[] = 'qodef-el-has-button';
		}

		if( $params['skin'] === 'dark' ) {
			$holderClasses[] = 'qodef-el-dark-skin';
		}

		if( $params['pattern_background'] === 'yes' ) {
			$holderClasses[] = 'qodef-el-pattern-background';
		}

		return implode( ' ', $holderClasses );
	}

    /**
     * @param $params
     * @param $args
     * @return mixed
     */
    private function info_markup( $settings, $title_tag ) {
        $current_id = get_the_ID();
		$date_meta  = get_post_meta( $current_id, 'qodef_event_date_meta', true );
		$time_meta  = get_post_meta( $current_id, 'qodef_event_time_meta', true );
		$stage_meta = get_post_meta( $current_id, 'qodef_event_stage_meta', true );
		$custom_link_meta  = get_post_meta( $current_id, 'qodef_event_purchase_ticket_link_meta', true );

		if ( ! empty( $time_meta ) || ! empty( $stage_meta ) || ! empty( $custom_link_meta ) || ! empty( $date_meta ) ) { ?>
			<div class="qodef-eli-title-holder">
				<?php if ( ! empty( $date_meta ) ) { ?>
					<div class="qodef-eli-info-date">
						<span class="qodef-eli-info-label"><?php echo esc_html( date('j M', strtotime($date_meta)) ); ?></span>
					</div>
				<?php } ?>
				<<?php echo esc_attr( $title_tag ); ?> itemprop="name" class="qodef-eli-title">
				<a itemprop="url" href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
				</<?php echo esc_attr( $title_tag ); ?>>
			</div>
			<?php if ( ! empty( $time_meta ) && ( $settings['show_time'] === 'yes') ) { ?>
				<div class="qodef-eli-info-time">
					<span class="qodef-eli-info-label"><?php echo esc_html( $time_meta ); ?></span>
				</div>
			<?php } ?>
			<?php if ( ! empty( $stage_meta ) ) { ?>
				<div class="qodef-eli-info-stage">
					<span class="qodef-eli-info-label"><?php echo esc_html( $stage_meta ); ?></span>
				</div>
			<?php } ?>
			<?php if ( $settings['enable_button'] === 'yes') { ?>
				<div class="qodef-eli-info-button">
					<span class="qodef-eli-button">
						<?php echo booth_select_get_button_html(array(
							'link' => $custom_link_meta,
							'text' => 'buy tickets',
							'type' => 'solid',
							'size' => 'medium'
						)); ?>
					</span>
				</div>
		<?php
			}
		}
    }

}
