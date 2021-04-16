<?php
namespace Booth_Elementor\Widget;

class Testimonials extends Base {

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
        return __( 'Testimonials', 'booth-elementor' );
    }

    public function get_keywords() {
        return ['booth', 'testimonials'];
    }

    public function get_script_depends() {
        return [
            'owl-carousel',
        ];
    }

    /**
     * Get a list of All Post Types
     *
     * @return array
     */
    public static function get_posts() {
        $args = [
            'post_status'    => 'publish',
            'post_type'      => 'team-member',
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
            'taxonomy'   => 'testimonials-category',
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

        self::$widget->__start( 'testimonials_settings_content', __( 'Testimonials', 'booth-elementor' ) );

        self::$widget->select_control( 'type', __( 'Type', 'booth-elementor' ), 'standard',
            [
                'standard' => __( 'Standard', 'booth-elementor' ),
                'carousel' => __( 'Carousel', 'booth-elementor' ),
            ]
        );

        self::$widget->select_control( 'skin', __( 'Skin', 'booth-elementor' ), 'light',
            [
                ''      => __( 'Default', 'booth-elementor' ),
                'light' => __( 'Light', 'booth-elementor' ),
            ]
        );

        self::$widget->select_control( 'pattern', __( 'Enable Pattern Background', 'booth-elementor' ), 'no', booth_select_get_yes_no_select_array( false, false ),
            [
                'condition' => [
                    'type' => 'carousel',
                ],
            ]
        );

        self::$widget->number_control( 'number', __( 'Number of Testimonials', 'booth-elementor' ), '3', '', '1', '1000', '1', false );

        self::$widget->select2_control( 'category', __( 'Category', 'booth-elementor' ), '', self::get_taxonomies(), true,
            [
                'label_block' => true,
                'description' => __( 'Enter one category slug (leave empty for showing all categories)', 'booth-elementor' ),
            ]
        );

		self::$widget->__end();


		self::$widget->__start( 'slider_settings_content', __( 'Slider Settings', 'booth-elementor' ) );

        self::$widget->select_control( 'number_of_visible_items', __( 'Number Of Visible Items', 'booth-elementor' ), '1',
            [
                '1' => __( 'One', 'booth-elementor' ),
                '2' => __( 'Two', 'booth-elementor' ),
                '3' => __( 'Three', 'booth-elementor' ),
                '4' => __( 'Four', 'booth-elementor' ),
            ],
            [
                'condition' => [
                    'type' => 'carousel',
                ],
            ]
        );

        self::$widget->select_control( 'slider_loop', __( 'Enable Slider Loop', 'booth-elementor' ), 'yes', booth_select_get_yes_no_select_array( false, true ) );

        self::$widget->select_control( 'slider_autoplay', __( 'Enable Slider Loop', 'booth-elementor' ), 'yes', booth_select_get_yes_no_select_array( false, true ) );

        self::$widget->number_control( 'slider_speed', __( 'Slide Duration', 'booth-elementor' ), '5000', '', '1', '1000000', '100', false,
            [
				'description' => __( 'Default value is 5000 (ms)', 'booth-elementor' ),
            ]
        );

        self::$widget->number_control( 'slider_speed_animation', __( 'Slide Animation Duration', 'booth-elementor' ), '600', '', '1', '1000000', '100', false,
            [
				'description' => __( 'Speed of slide animation in milliseconds. Default value is 600.', 'booth-elementor' ),
            ]
        );

        self::$widget->select_control( 'slider_navigation', __( 'Enable Slider Navigation Arrows', 'booth-elementor' ), 'yes', booth_select_get_yes_no_select_array( false, true ),
			[
				'condition' => [
					'type' => 'standard',
				],
			]
		);

        self::$widget->select_control( 'slider_pagination', __( 'Enable Slider Pagination', 'booth-elementor' ), 'yes', booth_select_get_yes_no_select_array( false, true ) );

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

        $args = [
            'post_status'    => 'publish',
            'post_type'      => 'testimonials',
            'orderby'        => 'date',
            'order'          => 'DESC',
            'posts_per_page' => $settings['number'],
        ];

        if ( $settings['category'] != '' ) {
            $args['testimonials-category'] = $settings['category'];
        }


        $type = !empty( $settings['type'] ) ? $settings['type'] : 'standard';

        $holder_classes = $this->getHolderClasses( $settings );

        $query_results = new \WP_Query( $args );

        $data_attr = $this->getSliderData( $settings );

		if ( 'standard' === $type ) {
            $this->standard( $holder_classes, $query_results, $data_attr );
        }else{
            $this->carousel( $holder_classes, $query_results, $data_attr );
		}

	}

    /**
     * @param $params
     */
    private function getHolderClasses( $params ) {
        $holderClasses = [];

        $holderClasses[] = 'qodef-testimonials-' . $params['type'];
        $holderClasses[] = !empty( $params['skin'] ) ? 'qodef-testimonials-' . $params['skin'] : '';

        if ( !empty( $params['pattern'] ) && $params['pattern'] === 'yes' ) {
            $holderClasses[] = 'qodef-testimonials-pattern-background';
        }

        return implode( ' ', $holderClasses );
    }

    /**
     * @param $params
     * @return mixed
     */
    private function getSliderData( $params ) {
        $slider_data = [];

        $slider_data['data-number-of-items'] = !empty( $params['number_of_visible_items'] ) && in_array( $params['type'], [ 'carousel' ] ) ? $params['number_of_visible_items'] : '1';
        $slider_data['data-enable-loop'] = !empty( $params['slider_loop'] ) ? $params['slider_loop'] : '';
        $slider_data['data-enable-autoplay'] = !empty( $params['slider_autoplay'] ) ? $params['slider_autoplay'] : '';
        $slider_data['data-slider-speed'] = !empty( $params['slider_speed'] ) ? $params['slider_speed'] : '3000';
        $slider_data['data-slider-speed-animation'] = !empty( $params['slider_speed_animation'] ) ? $params['slider_speed_animation'] : '600';
        $slider_data['data-enable-navigation'] = !empty( $params['slider_navigation'] ) ? $params['slider_navigation'] : '';
        $slider_data['data-enable-pagination'] = !empty( $params['slider_pagination'] ) ? $params['slider_pagination'] : '';
        $slider_data['data-slider-margin'] = in_array( $params['type'], [ 'carousel' ] ) ? 40 : '';

        return $slider_data;
    }

    /**
	 * standard markup
	 *
	 * @param [type] $holder_classes
	 * @param [type] $query_results
	 * @param [type] $data_attr
	 * @return void
	 */
    private function standard( $holder_classes, $query_results, $data_attr ) {
		?>
		<div class="qodef-testimonials-holder clearfix <?php echo esc_attr($holder_classes); ?>">
			<div class="qodef-testimonials qodef-owl-slider" <?php echo booth_select_get_inline_attrs( $data_attr ) ?>>

			<?php if ( $query_results->have_posts() ):
				while ( $query_results->have_posts() ) : $query_results->the_post();
					$current_id = get_the_ID();
					$text     = get_post_meta( $current_id, 'qodef_testimonial_text', true );
					$author   = get_post_meta( $current_id, 'qodef_testimonial_author', true );
					$position = get_post_meta( $current_id, 'qodef_testimonial_author_position', true );
					$quote_image  = get_the_post_thumbnail($current_id, array(94, 94));
			?>

					<div class="qodef-testimonial-content" id="qodef-testimonials-<?php echo esc_attr( $current_id ) ?>">
						<?php if(!empty($quote_image)) : ?>
							<div class="qodef-testimonial-quote">
								<?php echo $quote_image; ?>
							</div>
						<?php endif; ?>
						<div class="qodef-testimonial-text-holder">
							<?php if ( ! empty( $text ) ) { ?>
								<p class="qodef-testimonial-text"><?php echo esc_html( $text ); ?></p>
							<?php } ?>
							<?php if ( ! empty( $author ) ) { ?>
								<h4 class="qodef-testimonial-author">
									<span class="qodef-testimonials-author-name"><?php echo esc_html( $author ); ?></span>
									<?php if ( ! empty( $position ) ) { ?>
										<span class="qodef-testimonials-author-job"><?php echo esc_html( $position ); ?></span>
									<?php } ?>
								</h4>
							<?php } ?>
						</div>
					</div>

			<?php
				endwhile;
			else:
				echo esc_html__( 'Sorry, no posts matched your criteria.', 'booth-core' );
			endif;

			wp_reset_postdata();
			?>

			</div>
		</div>
		<?php
    }

    /**
	 * carousel markup
	 *
	 * @param [type] $holder_classes
	 * @param [type] $query_results
	 * @param [type] $data_attr
	 * @return void
	 */
    private function carousel( $holder_classes, $query_results, $data_attr ) {
		?>
		<div class="qodef-testimonials-holder clearfix <?php echo esc_attr($holder_classes); ?>">
			<div class="qodef-testimonials qodef-owl-slider qodef-testimonials-main" <?php echo booth_select_get_inline_attrs( $data_attr ) ?>>

				<?php if ( $query_results->have_posts() ):
					while ( $query_results->have_posts() ) : $query_results->the_post();

						$current_id = get_the_ID();
						$title    = get_post_meta( $current_id, 'qodef_testimonial_title', true );
						$text     = get_post_meta( $current_id, 'qodef_testimonial_text', true );
						$author   = get_post_meta( $current_id, 'qodef_testimonial_author', true );
						$position = get_post_meta( $current_id, 'qodef_testimonial_author_position', true );
						$rating_stars  = get_post_meta( $current_id, 'qodef_testimonial_rating_stars', true );
						$image_top = get_post_meta( $current_id, 'qodef_testimonial_top_image', true );
						?>

						<div class="qodef-testimonial-content" id="qodef-testimonials-<?php echo esc_attr( $current_id ) ?>">
							<?php if ( ! empty( $image_top ) ) { ?>
								<div class="qodef-testimonial-image-top" style="background-image: url('<?php echo esc_url($image_top); ?>')"></div>
							<?php } ?>
							<div class="qodef-testimonial-text-holder">
								<div class="qodef-testimonial-text-holder-inner">
									<?php if ( ! empty( $title ) ) { ?>
										<h3 itemprop="name" class="qodef-testimonial-title entry-title"><?php echo esc_html( $title ); ?></h3>
									<?php } ?>

									<?php if ( ! empty( $rating_stars ) ) : ?>
										<div class="qodef-testimonial-rating-stars">
											<?php for ($i = 0; $i < intval($rating_stars); $i++) : ?>
												<i class="fas fa-star" aria-hidden="true"></i>
											<?php endfor; ?>
										</div>
									<?php endif; ?>

									<?php if ( ! empty( $text ) ) { ?>
										<p class="qodef-testimonial-text"><?php echo esc_html( $text ); ?></p>
									<?php } ?>
									<?php if ( ! empty( $author ) ) { ?>
										<h4 class="qodef-testimonial-author">
											<span class="qodef-testimonials-author-name"><?php echo esc_html( $author ); ?></span>
											<?php if ( ! empty( $position ) ) { ?>
												<span class="qodef-testimonials-author-job"><?php echo esc_html( $position ); ?></span>
											<?php } ?>
										</h4>
									<?php } ?>
								</div>
							</div>
						</div>

						<?php
					endwhile;
				else:
					echo esc_html__( 'Sorry, no posts matched your criteria.', 'booth-core' );
				endif;

				wp_reset_postdata();
				?>

			</div>
		</div>
		<?php
    }

}
