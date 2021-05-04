<?php
/**
 * Countdown widget class.
 */
namespace Booth_Elementor\Widget;

defined( 'ABSPATH' ) || die();

use Elementor\Controls_Manager;

class Countdown extends Base {

	public function get_title() {
		return __( 'Countdown', 'booth-elementor' );
	}

	public function get_keywords() {
		return array( 'booth', 'countdown', 'count' );
	}

	public function scripts_register() {
		wp_register_script( 'booth-jquery-plugin', BOOTH_ELEMENTOR_ASSETS . '/vendor/js/jquery.plugin.js', array( 'jquery', 'booth-select-modules' ), BOOTH_ELEMENTOR_VERSION, true );
		wp_register_script( 'booth-countdown', BOOTH_ELEMENTOR_ASSETS . '/vendor/js/jquery.countdown.min.js', array( 'jquery', 'booth-select-modules' ), BOOTH_ELEMENTOR_VERSION, true );
	}

	public function get_script_depends() {
		$this->scripts_register();

		return array(
			'booth-jquery-plugin',
			'booth-countdown',
		);
	}

	public static function get_years() {
		return array(
			'2018' => '2018',
			'2019' => '2019',
			'2020' => '2020',
			'2021' => '2021',
			'2022' => '2022',
		);
	}

	public static function get_months() {
		return array(
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
		);
	}

	public static function get_days() {
		$dates = range( 1, 31 );
		return array_combine( $dates, $dates );
	}

	public static function get_hours() {
		$hours = range( 0, 24 );
		return array_combine( $hours, $hours );
	}

	public static function get_minutes() {
		$minutes = range( 0, 60 );
		return array_combine( $minutes, $minutes );
	}

	protected function register_content_controls() {
		$this->start_controls_section(
			'countdown_settings_content',
			array(
				'label' => __( 'Countdown', 'booth-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			'skin',
			array(
				'label'   => __( 'Skin', 'booth-elementor' ),
				'type'    => Controls_Manager::SELECT,
				'default' => '',
				'options' => array(
					''                 => __( 'Default', 'booth-elementor' ),
					'qodef-light-skin' => __( 'Light', 'booth-elementor' ),
				),
			)
		);

		$this->add_control(
			'year',
			array(
				'label'   => __( 'Year', 'booth-elementor' ),
				'type'    => Controls_Manager::SELECT,
				'default' => '',
				'options' => self::get_years(),
			)
		);

		$this->add_control(
			'month',
			array(
				'label'   => __( 'Month', 'booth-elementor' ),
				'type'    => Controls_Manager::SELECT,
				'default' => '',
				'options' => self::get_months(),
			)
		);

		$this->add_control(
			'day',
			array(
				'label'   => __( 'Day', 'booth-elementor' ),
				'type'    => Controls_Manager::SELECT,
				'default' => '',
				'options' => self::get_days(),
			)
		);

		$this->add_control(
			'hour',
			array(
				'label'   => __( 'Hour', 'booth-elementor' ),
				'type'    => Controls_Manager::SELECT,
				'default' => '',
				'options' => self::get_hours(),
			)
		);

		$this->add_control(
			'minute',
			array(
				'label'   => __( 'Minute', 'booth-elementor' ),
				'type'    => Controls_Manager::SELECT,
				'default' => '',
				'options' => self::get_minutes(),
			)
		);

		$this->add_control(
			'month_label',
			array(
				'label'   => __( 'Months Label', 'booth-elementor' ),
				'type'    => Controls_Manager::TEXT,
				'default' => 'Months',
			)
		);

		$this->add_control(
			'day_label',
			array(
				'label'   => __( 'Day Label', 'booth-elementor' ),
				'type'    => Controls_Manager::TEXT,
				'default' => 'Day',
			)
		);

		$this->add_control(
			'hour_label',
			array(
				'label'   => __( 'Hours Label', 'booth-elementor' ),
				'type'    => Controls_Manager::TEXT,
				'default' => 'Hours',
			)
		);

		$this->add_control(
			'minute_label',
			array(
				'label'   => __( 'Minutes Label', 'booth-elementor' ),
				'type'    => Controls_Manager::TEXT,
				'default' => 'Minutes',
			)
		);

		$this->add_control(
			'second_label',
			array(
				'label'   => __( 'Seconds Label', 'booth-elementor' ),
				'type'    => Controls_Manager::TEXT,
				'default' => 'Seconds',
			)
		);

		$this->add_control(
			'digit_font_size',
			array(
				'label'   => __( 'Digit Font Size (px)', 'booth-elementor' ),
				'type'    => Controls_Manager::NUMBER,
				'min'     => '0',
				'max'     => '1000',
				'step'    => '1',
				'dynamic' => array(
					'active' => false,
				),
			)
		);

		$this->add_control(
			'label_font_size',
			array(
				'label'   => __( 'Label Font Size (px)', 'booth-elementor' ),
				'type'    => Controls_Manager::NUMBER,
				'min'     => '0',
				'max'     => '1000',
				'step'    => '1',
				'dynamic' => array(
					'active' => false,
				),
			)
		);

		$this->add_control(
			'custom_class',
			array(
				'label'       => __( 'Custom CSS Class', 'booth-elementor' ),
				'label_block' => true,
				'type'        => Controls_Manager::TEXT,
				'description' => __( 'Style particular content element differently - add a class name and refer to it in custom CSS', 'booth-elementor' ),
			)
		);

		$this->end_controls_section();
	}

	protected function register_style_controls() {}

	protected function render() {
		// return;

		$settings = $this->get_settings_for_display();

		$id             = $this->get_id();
		$id             = wp_rand( 1000, 9999 );
		$holder_classes = $this->getHolderClasses( $settings );
		$data           = $this->getHolderData( $settings );

		$this->add_render_attribute( 'countdown', 'class', array( 'qodef-countdown', $holder_classes ) );
		$this->add_render_attribute( 'countdown', 'id', 'countdown' . esc_attr( $id ) );
		foreach ( $data as $key => $value ) {
			$this->add_render_attribute( 'countdown', $key, $value );
		}
		?>
		<div <?php $this->print_render_attribute_string( 'countdown' ); ?>></div>
		<?php
	}

	/**
	 * @param $params
	 */
	private function getHolderClasses( $params ) {
		$holder_classes = array();

		$holder_classes[] = ! empty( $params['custom_class'] ) ? esc_attr( $params['custom_class'] ) : '';
		$holder_classes[] = ! empty( $params['skin'] ) ? $params['skin'] : '';

		return implode( ' ', $holder_classes );
	}

	/**
	 * @param $params
	 * @return mixed
	 */
	private function getHolderData( $params ) {
		$holder_data = array();

		$holder_data['data-year']         = ! empty( $params['year'] ) ? $params['year'] : '';
		$holder_data['data-month']        = ! empty( $params['month'] ) ? $params['month'] : '';
		$holder_data['data-day']          = ! empty( $params['day'] ) ? $params['day'] : '';
		$holder_data['data-hour']         = '' !== $params['hour'] ? $params['hour'] : '';
		$holder_data['data-minute']       = '' !== $params['minute'] ? $params['minute'] : '';
		$holder_data['data-month-label']  = ! empty( $params['month_label'] ) ? $params['month_label'] : esc_html__( 'Months', 'booth-elementor' );
		$holder_data['data-day-label']    = ! empty( $params['day_label'] ) ? $params['day_label'] : esc_html__( 'Days', 'booth-elementor' );
		$holder_data['data-hour-label']   = ! empty( $params['hour_label'] ) ? $params['hour_label'] : esc_html__( 'Hours', 'booth-elementor' );
		$holder_data['data-minute-label'] = ! empty( $params['minute_label'] ) ? $params['minute_label'] : esc_html__( 'Minutes', 'booth-elementor' );
		$holder_data['data-second-label'] = ! empty( $params['second_label'] ) ? $params['second_label'] : esc_html__( 'Seconds', 'booth-elementor' );
		$holder_data['data-digit-size']   = ! empty( $params['digit_font_size'] ) ? $params['digit_font_size'] : '';
		$holder_data['data-label-size']   = ! empty( $params['label_font_size'] ) ? $params['label_font_size'] : '';

		return $holder_data;
	}
}
