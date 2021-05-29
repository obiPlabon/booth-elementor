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

	protected function register_content_controls() {
		$this->start_controls_section(
			'_booth_timetable',
			[
				'label' => __( 'Timetable', 'booth-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		if ( function_exists( 'tt_timetable' ) ) {
			$this->add_control(
				'shortcode_id',
				[
					'label'       => __( 'Select Shortcode ID', 'booth-elementor' ),
					'label_block' => true,
					'description' => '<a href="' . admin_url( '?page=timetable_admin' ) . '" target="_blank">Create shortcode configuration from here</a> and once done then refresh this page to get the latest.',
					'type'        => Controls_Manager::SELECT,
					'options'     => self::get_shortcode_ids(),
				]
			);
		}

		$this->end_controls_section();
	}

	protected function register_style_controls() {
	}

	/**
	 * @return null
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();

		echo tt_timetable( array( 'shortcode_id' => $settings['shortcode_id'] ), '' );
	}
}
