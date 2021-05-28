<?php
/**
 * Timetable widget class.
 *
 * @see app/public/wp-content/plugins/timetable/shortcode-timetable.php
 */
namespace Booth_Elementor\Widget;

defined( 'ABSPATH' ) || die();

use Elementor\Controls_Manager;

class TimeTable extends Base {

	public function get_title() {
		return __( 'Timetable', 'booth-elementor' );
	}

	public function get_keywords() {
		return ['booth', 'time', 'table', 'event', 'schedule'];
	}

	protected function register_content_controls() {
		$this->__register_timetable_controls();
		// $this->__register_price_table_item_controls();
	}

	public static function get_shortcode_ids() {
		$lists = get_option( 'timetable_shortcodes_list' );
		$arr = [ '-1' => __( 'Choose...', 'timetable' ) ];

		if ( ! empty( $lists ) ) {
			foreach ( $lists as $key => $val ) {
				$arr[ $key ] = $key;
			}
		}

		return $arr;
	}

	public static function get_events() {
		$settings = timetable_events_settings();
		$events = get_posts( [
			'nopaging'       => true,
			'order'          => 'ASC',
			'orderby'        => 'title',
			'post_type'      => $settings['slug'],
			'posts_per_page' => -1,
		] );

		$arr = [ '' => 'All' ];

		if ( ! empty( $events ) ) {
			foreach( $events as $event ) {
				$arr[ urldecode( $event->post_name ) ] = $event->post_title . ' (id:' . $event->ID . ')';
			}
		}

		return $arr;
	}

	public static function get_event_categories() {
		$categories = get_terms( [
			'taxonomy' => 'events_category',
			'orderby'  => 'name',
			'order'    => 'ASC',
		] );

		$arr = [ '' => 'All' ];

		if ( ! is_wp_error( $categories ) && ! empty( $categories ) ) {
			foreach ( $categories as $category ) {
				$arr[ urldecode( $category->slug ) ] = $category->name;
			}
		}

		return $arr;
	}

	public static function get_event_hour_categories() {
		global $wpdb;

		$settings = timetable_events_settings();

		$query = "SELECT distinct(category) AS category FROM " . $wpdb->prefix . "event_hours AS t1
		LEFT JOIN {$wpdb->posts} AS t2 ON t1.event_id=t2.ID
		WHERE t2.post_type='" . $settings['slug'] . "'
		AND t2.post_status='publish'
		AND category<>''
		ORDER BY category ASC";

		$categories = $wpdb->get_results( $query );

		$arr = [ '' => 'All' ];

		if ( ! empty( $categories ) ) {
			foreach ( $categories as $category ) {
				$arr[ $category->category ] =  $category->category;
			}
		}

		return $arr;
	}

	public static function get_event_week_days() {
		$weekdays = get_posts( [
			'posts_per_page' => -1,
			'nopaging'       => true,
			'orderby'        => 'menu_order',
			'order'          => 'ASC',
			'post_type'      => 'timetable_weekdays'
		] );

		$arr = [ '' => 'All' ];

		if ( ! empty( $weekdays ) ) {
			foreach ( $weekdays as $weekday ) {
				$arr[ urldecode( $weekday->post_name ) ] = $weekday->post_title . ' (id:' . $weekday->ID . ')';
			}
		}

		return $arr;
	}

	protected function __register_timetable_controls() {
		$this->start_controls_section(
			'_booth_timetable',
			[
				'label' => __( 'Timetable', 'booth-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'shortcode_id',
			[
				'label'       => __( 'Shortcode Id', 'booth-elementor' ),
				'label_block' => true,
				'type'        => Controls_Manager::SELECT,
				'options'     => self::get_shortcode_ids(),
			]
		);

		$this->add_control(
			'event',
			[
				'label'       => __( 'Events', 'booth-elementor' ),
				'label_block' => true,
				'type'        => Controls_Manager::SELECT2,
				'multiple'    => true,
				'options'     => self::get_events(),
			]
		);

		$this->add_control(
			'event_category',
			[
				'label'       => __( 'Event Categories', 'booth-elementor' ),
				'label_block' => true,
				'type'        => Controls_Manager::SELECT2,
				'multiple'    => true,
				'options'     => self::get_event_categories(),
			]
		);

		$this->add_control(
			'hour_category',
			[
				'label'       => __( 'Hour Categories', 'booth-elementor' ),
				'label_block' => true,
				'type'        => Controls_Manager::SELECT2,
				'multiple'    => true,
				'options'     => self::get_event_hour_categories(),
			]
		);

		$this->add_control(
			'columns',
			[
				'label'       => __( 'Columns', 'booth-elementor' ),
				'label_block' => true,
				'type'        => Controls_Manager::SELECT2,
				'multiple'    => true,
				'options'     => self::get_event_week_days(),
			]
		);

		$this->add_control(
			'measure',
			[
				'label'       => __( 'Hour Measure', 'booth-elementor' ),
				'type'        => Controls_Manager::SELECT,
				'label_block' => true,
				'options'     => [
					'1'    => __( 'Hour (1h)', 'timetable' ),
					'0.5'  => __( 'Half Hour (30min)', 'timetable' ),
					'0.25' => __( 'Quarter Hour (15min)', 'timetable' ),
				],
			]
		);

		$this->add_control(
			'filter_style',
			[
				'label'       => __( 'Filter Style', 'booth-elementor' ),
				'label_block' => true,
				'type'        => Controls_Manager::SELECT,
				'options'     => [
					'dropdown_list' => __( 'Dropdown list', 'timetable' ),
					'tabs'          => __( 'Tabs', 'timetable' ),
				],
			]
		);

		$this->add_control(
			'filter_kind',
			[
				'label'       => __( 'Filter Kind', 'booth-elementor' ),
				'label_block' => true,
				'type'        => Controls_Manager::SELECT,
				'options'     => [
					'event'                    => __( 'By event', 'timetable' ),
					'event_category'           => __( 'By event category', 'timetable' ),
					'event_and_event_category' => __( 'By event and event category', 'timetable' ),
				],
			]
		);

		$this->add_control(
			'filter_label',
			[
				'label'       => __( 'Filter Label', 'booth-elementor' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXT,
				'default'     => 'All Events',
			]
		);

		$this->add_control(
			'filter_label_2',
			[
				'label'       => __( 'Filter Label 2', 'booth-elementor' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXT,
				'default'     => 'All Events Categories',
				'condition'   => [
					'filter_kind' => 'event_and_event_category'
				]
			]
		);

		$this->add_control(
			'select_time',
			[
				'label'       => __( 'Select Time Format', 'booth-elementor' ),
				'label_block' => true,
				'type'        => Controls_Manager::SELECT,
				'options'     => [
					'H.i'   => __( '09.03 (H.i)', 'timetable' ),
					'H:i'   => __( '09:03 (H:i)', 'timetable' ),
					'g:i a' => __( '9:03 am (g:i a)', 'timetable' ),
					'g:i A' => __( '9:03 AM (g:i A)', 'timetable' ),
				],
			]
		);

		$this->add_control(
			'time_format',
			[
				'label'       => __( 'Time Format', 'booth-elementor' ),
				'label_block' => false,
				'type'        => Controls_Manager::TEXT,
				'default'     => 'H.i',
			]
		);

		$this->add_control(
			'hide_all_events_view',
			[
				'label'       => __( 'Hide \'All Events\' view', 'booth-elementor' ),
				'label_block' => true,
				'type'        => Controls_Manager::SELECT,
				'options'     => [
					'0' => __( 'No', 'timetable' ),
					'1' => __( 'Yes', 'timetable' ),
				],
			]
		);

		$this->add_control(
			'hide_all_events_view',
			[
				'label'       => __( 'Hide \'All Events\' view', 'booth-elementor' ),
				'label_block' => true,
				'type'        => Controls_Manager::SELECT,
				'options'     => [
					'0' => __( 'No', 'timetable' ),
					'1' => __( 'Yes', 'timetable' ),
				],
			]
		);

		/**
		 * TODO: Have to add more controls here
		 */

		$this->end_controls_section();
	}

	protected function register_style_controls() {
	}

	/**
	 * @return null
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();
	}
}
