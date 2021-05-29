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
		$arr   = [ '-1' => __( 'Choose...', 'timetable' ) ];

		if ( ! empty( $lists ) ) {
			foreach ( $lists as $key => $val ) {
				$arr[ $key ] = $key;
			}
		}

		return $arr;
	}

	public static function get_events() {
		$settings = timetable_events_settings();
		$events   = get_posts( [
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
		LEFT  JOIN {$wpdb->posts} AS t2 ON t1.event_id = t2.ID
		WHERE t2.post_type                             = '" . $settings['slug'] . "'
		AND   t2.post_status                           = 'publish'
		AND category<>''
		ORDER BY category ASC";

		$categories = $wpdb->get_results( $query );

		$arr = [ '' => 'All' ];

		if ( ! empty( $categories ) ) {
			foreach ( $categories as $category ) {
				$arr[ $category->category ] = $category->category;
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
				'label'   => __( 'Hide \'All Events\' view', 'booth-elementor' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'0' => __( 'No', 'timetable' ),
					'1' => __( 'Yes', 'timetable' ),
				],
			]
		);

		$this->add_control(
			'hide_hours_column',
			[
				'label'   => __( 'Hide first (hours) column', 'booth-elementor' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'0' => __( 'No', 'timetable' ),
					'1' => __( 'Yes', 'timetable' ),
				],
			]
		);

		$this->add_control(
			'show_end_hour',
			[
				'label'   => __( 'Show end hour in first (hours) column', 'booth-elementor' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'0' => __( 'No', 'timetable' ),
					'1' => __( 'Yes', 'timetable' ),
				],
			]
		);

		$this->add_control(
			'event_layout',
			[
				'label'   => __( 'Event block layout', 'booth-elementor' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'1' => __( 'Type 1', 'timetable' ),
					'2' => __( 'Type 2', 'timetable' ),
					'3' => __( 'Type 3', 'timetable' ),
					'4' => __( 'Type 4', 'timetable' ),
					'5' => __( 'Type 5', 'timetable' ),
				],
			]
		);

		$this->add_control(
			'hide_empty',
			[
				'label'   => __( 'Hide empty rows', 'booth-elementor' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'0' => __( 'No', 'timetable' ),
					'1' => __( 'Yes', 'timetable' ),
				],
			]
		);

		$this->add_control(
			'disable_event_url',
			[
				'label'   => __( 'Disable event url', 'booth-elementor' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'0' => __( 'No', 'timetable' ),
					'1' => __( 'Yes', 'timetable' ),
				],
			]
		);

		$this->add_control(
			'text_align',
			[
				'label'   => __( 'Disable event url', 'booth-elementor' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'center' => __( 'Center', 'timetable' ),
					'left'   => __( 'Left', 'timetable'),
					'right'  => __( 'Right', 'timetable'),
				],
			]
		);

		$this->add_control(
			'html_id',
			[
				'label'       => __( 'Id', 'booth-elementor' ),
				'label_block' => false,
				'type'        => Controls_Manager::TEXT,
			]
		);

		$this->add_control(
			'row_height',
			[
				'label'       => __( 'Row height (in px)', 'booth-elementor' ),
				'label_block' => false,
				'type'        => Controls_Manager::TEXT,
			]
		);

		$this->add_control(
			'desktop_list_view',
			[
				'label'   => __( 'Display list view on desktop', 'booth-elementor' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'0' => __( 'No', 'timetable' ),
					'1' => __( 'Yes', 'timetable' ),
				],
			]
		);

		$this->add_control(
			'responsive',
			[
				'label'   => __( 'Responsive', 'booth-elementor' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'0' => __( 'No', 'timetable' ),
					'1' => __( 'Yes', 'timetable' ),
				],
			]
		);

		$this->add_control(
			'event_description_responsive',
			[
				'label'       => __( 'Event description in responsive mode', 'booth-elementor' ),
				'label_block' => true,
				'type'        => Controls_Manager::SELECT,
				'options'     => [
					'none'                            => __( 'None', 'timetable' ),
					'description-1'                   => __( 'Only Description 1', 'timetable' ),
					'description-2'                   => __( 'Only Description 2', 'timetable' ),
					'description-1-and-description-2' => __( 'Description 1 and Description 2', 'timetable' ),
				],
			]
		);

		$this->add_control(
			'collapse_event_hours_responsive',
			[
				'label'       => __( 'Collapse event hours in responsive mode', 'booth-elementor' ),
				'label_block' => true,
				'type'        => Controls_Manager::SELECT,
				'options'     => [
					"0" => __("No", "booth-elementor"),
					"1" => __("Yes", "booth-elementor"),
				],
			]
		);

		$this->add_control(
			'colors_responsive_mode',
			[
				'label'       => __( 'Use colors in responsive mode', 'booth-elementor' ),
				'label_block' => true,
				'type'        => Controls_Manager::SELECT,
				'options'     => [
					"0" => __("No", "booth-elementor"),
					"1" => __("Yes", "booth-elementor"),
				],
			]
		);

		$this->add_control(
			'export_to_pdf_button',
			[
				'label'       => __( 'Export to PDF button', 'booth-elementor' ),
				'label_block' => true,
				'type'        => Controls_Manager::SELECT,
				'options'     => [
					"0" => __("No", "booth-elementor"),
					"1" => __("Yes", "booth-elementor"),
				],
			]
		);

		$this->add_control(
			'generate_pdf_label',
			[
				'label'       => __( 'Generate PDF label', 'booth-elementor' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXT,
				'default'     => __( 'Generate PDF', 'booth-elementor' ),
			]
		);

		$this->add_control(
			'pdf_font',
			[
				'label'       => __( 'PDF Font', 'booth-elementor' ),
				'label_block' => true,
				'type'        => Controls_Manager::SELECT,
				'options'     => [
					"lato"       => __("Lato", "booth-elementor"),
					"dejavusans" => __("DejaVu Sans", "booth-elementor"),
				],
			]
		);

		$this->add_control(
			'box_bg_color',
			[
				'label'   => __( 'Timetable box background color', 'booth-elementor' ),
				'type'    => Controls_Manager::COLOR,
				'default' => '#00a27c',
			]
		);

		$this->add_control(
			'box_hover_bg_color',
			[
				'label'   => __( 'Timetable box hover background color', 'booth-elementor' ),
				'type'    => Controls_Manager::COLOR,
				'default' => '#1f736a',
			]
		);

		$this->add_control(
			'box_txt_color',
			[
				'label'   => __( 'Timetable box text color', 'booth-elementor' ),
				'type'    => Controls_Manager::COLOR,
				'default' => '#ffffff',
			]
		);

		$this->add_control(
			'box_hover_txt_color',
			[
				'label'   => __( 'Timetable box hover text color', 'booth-elementor' ),
				'type'    => Controls_Manager::COLOR,
				'default' => '#ffffff',
			]
		);

		$this->add_control(
			'box_hours_txt_color',
			[
				'label'   => __( 'Timetable box hours text color', 'booth-elementor' ),
				'type'    => Controls_Manager::COLOR,
				'default' => '#ffffff',
			]
		);

		$this->add_control(
			'box_hours_hover_txt_color',
			[
				'label'   => __( 'Timetable box hours hover text color', 'booth-elementor' ),
				'type'    => Controls_Manager::COLOR,
				'default' => '#ffffff',
			]
		);

		$this->add_control(
			'filter_color',
			[
				'label'   => __( 'Filter control background color', 'booth-elementor' ),
				'type'    => Controls_Manager::COLOR,
				'default' => '#00a27c',
			]
		);

		$this->add_control(
			'row1_color',
			[
				'label'   => __( 'Row 1 style background color', 'booth-elementor' ),
				'type'    => Controls_Manager::COLOR,
				'default' => '#f0f0f0',
			]
		);

		$this->add_control(
			'row2_color',
			[
				'label'   => __( 'Row 2 style background color', 'booth-elementor' ),
				'type'    => Controls_Manager::COLOR,
				'default' => '',
			]
		);

		$this->add_control(
			'generate_pdf_text_color',
			[
				'label'   => __( 'Generate PDF button text color', 'booth-elementor' ),
				'type'    => Controls_Manager::COLOR,
				'default' => '#ffffff',
			]
		);

		$this->add_control(
			'generate_pdf_bg_color',
			[
				'label'   => __( 'Generate PDF button background color', 'booth-elementor' ),
				'type'    => Controls_Manager::COLOR,
				'default' => '#00a27c',
			]
		);

		$this->add_control(
			'generate_pdf_hover_text_color',
			[
				'label'   => __( 'Generate PDF button hover text color', 'booth-elementor' ),
				'type'    => Controls_Manager::COLOR,
				'default' => '#ffffff',
			]
		);

		$this->add_control(
			'generate_pdf_hover_bg_color',
			[
				'label'   => __( 'Generate PDF button hover background color', 'booth-elementor' ),
				'type'    => Controls_Manager::COLOR,
				'default' => '#1f736a',
			]
		);

		$this->add_control(
			'booking_text_color',
			[
				'label'   => __( 'Booking button text color', 'booth-elementor' ),
				'type'    => Controls_Manager::COLOR,
				'default' => '#ffffff',
			]
		);

		$this->add_control(
			'booking_bg_color',
			[
				'label'   => __( 'Booking button background color', 'booth-elementor' ),
				'type'    => Controls_Manager::COLOR,
				'default' => '#05bb90',
			]
		);

		$this->add_control(
			'booking_hover_text_color',
			[
				'label'   => __( 'Booking button hover text color', 'booth-elementor' ),
				'type'    => Controls_Manager::COLOR,
				'default' => '#ffffff',
			]
		);

		$this->add_control(
			'booking_hover_bg_color',
			[
				'label'   => __( 'Booking button hover background color', 'booth-elementor' ),
				'type'    => Controls_Manager::COLOR,
				'default' => '#07b38a',
			]
		);

		$this->add_control(
			'booked_text_color',
			[
				'label'   => __( 'Booked button text color', 'booth-elementor' ),
				'type'    => Controls_Manager::COLOR,
				'default' => '#aaaaaa',
			]
		);

		$this->add_control(
			'booked_bg_color',
			[
				'label'   => __( 'Booked button background color', 'booth-elementor' ),
				'type'    => Controls_Manager::COLOR,
				'default' => '#eeeeee',
			]
		);

		$this->add_control(
			'unavailable_text_color',
			[
				'label'   => __( 'Unavailable button text color', 'booth-elementor' ),
				'type'    => Controls_Manager::COLOR,
				'default' => '#aaaaaa',
			]
		);

		$this->add_control(
			'unavailable_bg_color',
			[
				'label'   => __( 'Unavailable button background color', 'booth-elementor' ),
				'type'    => Controls_Manager::COLOR,
				'default' => '#eeeeee',
			]
		);

		$this->add_control(
			'available_slots_color',
			[
				'label'   => __( 'Available slots color', 'booth-elementor' ),
				'type'    => Controls_Manager::COLOR,
				'default' => '#ffd544',
			]
		);

		$this->add_control(
			'font_custom',
			[
				'label' => __( 'Table header font', 'booth-elementor' ),
				'type'  => Controls_Manager::TEXT,
			]
		);

		$this->add_control(
			'font',
			[
				'label'       => __( 'or choose Google font', 'booth-elementor' ),
				'label_block' => false,
				'type'        => Controls_Manager::FONT,
			]
		);

		$this->add_control(
			'font_subset',
			[
				'label'       => __( 'Google font subset', 'booth-elementor' ),
				'label_block' => true,
				'type'        => Controls_Manager::SELECT2,
				'options'     => [
					"",
					"arabic",
					"hebrew",
					"telugu",
					"cyrillic-ext",
					"cyrillic",
					"devanagari",
					"greek-ext",
					"greek",
					"vietnamese",
					"latin-ext",
					"latin",
					"khmer",
				],
				'condition' => [
					'font!' => ''
				],
			]
		);

		$this->add_control(
			'font_size',
			[
				'label' => __( 'Font size (in px)', 'booth-elementor' ),
				'type'  => Controls_Manager::TEXT,
			]
		);

		$this->add_control(
			'show_booking_button',
			[
				'label'       => __( 'Show booking button', 'booth-elementor' ),
				'label_block' => true,
				'type'        => Controls_Manager::SELECT,
				'options'     => [
					"no"       => __("No", "booth-elementor"),
					"always"   => __("Always", "booth-elementor"),
					"on_hover" => __("On hover", "booth-elementor"),
				],
			]
		);

		$this->add_control(
			'show_available_slots',
			[
				'label'       => __( 'Show available slots', 'booth-elementor' ),
				'label_block' => true,
				'type'        => Controls_Manager::SELECT,
				'options'     => [
					"no"     => __("No", "booth-elementor"),
					"always" => __("Always", "booth-elementor"),
				],
			]
		);

		$this->add_control(
			'available_slots_singular_label',
			[
				'label'       => __( 'Available slots singular label', 'booth-elementor' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXT,
				"default"     => "{number_available}/{number_total} slot available",
				'description' => __( "Specify text label for 'slot available' information (singular). Available placeholders: {number_available}, {number_taken}, {number_total}.", 'booth-elementor' ),
			]
		);

		$this->add_control(
			'available_slots_plural_label',
			[
				'label'       => __( 'Available slots plural label', 'booth-elementor' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXT,
				"default"     => "{number_available}/{number_total} slots available",
				'description' => __( "Specify text label for 'slots available' information (plural). Available placeholders: {number_available}, {number_taken}, {number_total}.", 'booth-elementor' ),
			]
		);

		$this->add_control(
			'default_booking_view',
			[
				'label'       => __( 'Default booking view', 'booth-elementor' ),
				'description' => __( 'Specify which booking view should be visible by default.', 'booth-elementor' ),
				'label_block' => true,
				'type'        => Controls_Manager::SELECT,
				'options'     => [
					"user"  => __("User", "booth-elementor"),
					"guest" => __("Guest", "booth-elementor"),
				],
			]
		);

		$this->add_control(
			'allow_user_booking',
			[
				'label'       => __( 'Allow user booking', 'booth-elementor' ),
				'description' => __( "Set to 'Yes' if you want to allow logged in users to make a booking.", 'booth-elementor' ),
				'label_block' => true,
				'type'        => Controls_Manager::SELECT,
				'options'     => [
					"yes" => __("Yes", "booth-elementor"),
					"no"  => __("No", "booth-elementor"),
				],
				'condition'     => [
					"default_booking_view" => 'guest'
				],
			]
		);

		$this->add_control(
			'allow_guest_booking',
			[
				'label'       => __( 'Allow guest booking', 'booth-elementor' ),
				'description' => __( "Set to 'Yes' if you want to allow guests to make a booking.", 'booth-elementor' ),
				'label_block' => true,
				'type'        => Controls_Manager::SELECT,
				'options'     => [
					"yes" => __("Yes", "booth-elementor"),
					"no"  => __("No", "booth-elementor"),
				],
			]
		);

		$this->add_control(
			'show_guest_name_field',
			[
				'label'       => __( 'Show guest name field', 'booth-elementor' ),
				'description' => __( "Set to 'Yes' if you want to show 'Name' field in guest booking form.", 'booth-elementor' ),
				'label_block' => true,
				'type'        => Controls_Manager::SELECT,
				'options'     => [
					"yes" => __("Yes", "booth-elementor"),
					"no"  => __("No", "booth-elementor"),
				],
				'condition'     => [
					"allow_guest_booking" => 'yes'
				],
			]
		);

		$this->add_control(
			'guest_name_field_required',
			[
				'label'       => __( 'Guest name field required', 'booth-elementor' ),
				'description' => __( "Set to 'Yes' if the 'Name' field should be required.", 'booth-elementor' ),
				'label_block' => true,
				'type'        => Controls_Manager::SELECT,
				'options'     => [
					"yes" => __("Yes", "booth-elementor"),
					"no"  => __("No", "booth-elementor"),
				],
				'condition'     => [
					"allow_guest_booking" => 'yes'
				],
			]
		);

		$this->add_control(
			'show_guest_phone_field',
			[
				'label'       => __( 'Show guest phone field', 'booth-elementor' ),
				'description' => __( "Set to 'Yes' if you want to show 'Phone' field in guest booking form.", 'booth-elementor' ),
				'label_block' => true,
				'type'        => Controls_Manager::SELECT,
				'options'     => [
					"yes" => __("Yes", "booth-elementor"),
					"no"  => __("No", "booth-elementor"),
				],
				'condition'     => [
					"allow_guest_booking" => 'yes'
				],
			]
		);

		$this->add_control(
			'guest_phone_field_required',
			[
				'label'       => __( 'Guest phone field required', 'booth-elementor' ),
				'description' => __( "Set to 'Yes' if the 'Phone' field should be required.", 'booth-elementor' ),
				'label_block' => true,
				'type'        => Controls_Manager::SELECT,
				'options'     => [
					"yes" => __("Yes", "booth-elementor"),
					"no"  => __("No", "booth-elementor"),
				],
				'condition'     => [
					"allow_guest_booking" => 'yes'
				],
			]
		);

		$this->add_control(
			'show_guest_message_field',
			[
				'label'       => __( 'Show guest message field', 'booth-elementor' ),
				'description' => __( "Set to 'Yes' if you want to show 'Message' field in guest booking form.", 'booth-elementor' ),
				'label_block' => true,
				'type'        => Controls_Manager::SELECT,
				'options'     => [
					"yes" => __("Yes", "booth-elementor"),
					"no"  => __("No", "booth-elementor"),
				],
				'condition'     => [
					"allow_guest_booking" => 'yes'
				],
			]
		);

		$this->add_control(
			'guest_message_field_required',
			[
				'label'       => __( 'Guest message field required', 'booth-elementor' ),
				'description' => __( "Set to 'Yes' if the 'Message' field should be required.", 'booth-elementor' ),
				'label_block' => true,
				'type'        => Controls_Manager::SELECT,
				'options'     => [
					"yes" => __("Yes", "booth-elementor"),
					"no"  => __("No", "booth-elementor"),
				],
				'condition'     => [
					"allow_guest_booking" => 'yes'
				],
			]
		);

		$this->add_control(
			'booking_label',
			[
				'label'       => __( 'Booking label', 'booth-elementor' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXT,
				'default'     => 'Book now',
			]
		);

		$this->add_control(
			'booked_label',
			[
				'label'       => __( 'Booked label', 'booth-elementor' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXT,
				'default'     => 'Booked',
			]
		);

		$this->add_control(
			'unavailable_label',
			[
				'label'       => __( 'Unavailable label', 'booth-elementor' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXT,
				'default'     => 'Unavailable',
			]
		);

		$this->add_control(
			'booking_popup_label',
			[
				'label'       => __( 'Popup booking label', 'booth-elementor' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXT,
				'default'     => 'Book now',
			]
		);

		$this->add_control(
			'login_popup_label',
			[
				'label'       => __( 'Popup login label', 'booth-elementor' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXT,
				'default'     => 'Log in',
			]
		);

		$this->add_control(
			'cancel_popup_label',
			[
				'label'       => __( 'Popup cancel label', 'booth-elementor' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXT,
				'default'     => 'Cancel',
			]
		);

		$this->add_control(
			'continue_popup_label',
			[
				'label'       => __( 'Popup continue label', 'booth-elementor' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXT,
				'default'     => 'Continue',
			]
		);

		$this->add_control(
			'terms_checkbox',
			[
				'label'       => __( 'Terms and conditions checkbox', 'booth-elementor' ),
				'description' => __( "Set to 'Yes' if you want to display 'Terms and conditions' checkbox.", 'booth-elementor' ),
				'label_block' => true,
				'type'        => Controls_Manager::SELECT,
				'options'     => [
					"yes" => __("Yes", "booth-elementor"),
					"no"  => __("No", "booth-elementor"),
				],
			]
		);

		$this->add_control(
			'terms_message',
			[
				'label'       => __( 'Terms and conditions message', 'booth-elementor' ),
				'description' => __( "Specify text for 'Terms and conditions' checkbox.", 'booth-elementor' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXT,
				'default'     => 'Please accept terms and conditions',
			]
		);

		$this->add_control(
			'booking_popup_message',
			[
				'label'       => __( 'Booking pop-up message', 'booth-elementor' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXTAREA,
				'default'     => defined( 'BOOKING_POPUP_MESSAGE' ) ? BOOKING_POPUP_MESSAGE : '',
				'description' => __( "Specify text that will appear in pop-up window. Available placeholders: {event_title} {column_title} {event_start} {event_end} {event_description_1} {event_description_2} {user_name} {user_email} {tt_btn_book} {tt_btn_cancel} {tt_btn_continue}", 'booth-elementor' ),
			]
		);

		$this->add_control(
			'booking_popup_thank_you_message',
			[
				'label'       => __( 'Booking pop-up thank you message', 'booth-elementor' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXTAREA,
				'default'     => defined( 'BOOKING_POPUP_THANK_YOU_MESSAGE' ) ? BOOKING_POPUP_THANK_YOU_MESSAGE : '',
				'description' => __( "Specify text that will appear in pop-up window. Available placeholders: {event_title} {column_title} {event_start} {event_end} {event_description_1} {event_description_2} {user_name} {user_email} {tt_btn_continue}", 'booth-elementor' ),
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
		$settings = $this->get_settings_for_display();
	}
}
