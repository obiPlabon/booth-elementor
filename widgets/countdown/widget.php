<?php
namespace Booth_Elementor\Widget;


class Countdown extends Base {

	protected static $widget;

	public function __construct($data = array(), $args = null) {
		parent::__construct($data, $args);
		self::$widget = new Control_Ui($this);

		// add_action( 'elementor/frontend/before_enqueue_scripts', [ $this, 'scripts_enqueue' ] );
		// add_action( 'elementor/editor/after_enqueue_scripts', [ $this, 'scripts_enqueue' ] );
	}

    /**
     * Get widget title.
     *
     */
    public function get_title() {
        return __( 'Countdown', 'booth-elementor' );
    }

	public function get_keywords() {
		return ['booth','countdown','count'];
	}

	public function scripts_register() {
		wp_register_script( 'booth-jquery-plugin', BOOTH_ELEMENTOR_ASSETS . '/vendor/js/jquery.plugin.js', array( 'jquery','booth-select-modules' ), false, true );
		wp_register_script( 'booth-countdown', BOOTH_ELEMENTOR_ASSETS . '/vendor/js/jquery.countdown.min.js', array( 'jquery','booth-select-modules' ), false, true );
	}

	public function scripts_enqueue() {
		wp_enqueue_script( 'booth-jquery-plugin', BOOTH_ELEMENTOR_ASSETS . '/vendor/js/jquery.plugin.js', array( 'jquery','booth-select-modules' ), false, true );
		wp_enqueue_script( 'booth-countdown', BOOTH_ELEMENTOR_ASSETS . '/vendor/js/jquery.countdown.min.js', array( 'jquery','booth-select-modules' ), false, true );
	}

	public function get_script_depends() {

		$this->scripts_register();

		return [
			'booth-jquery-plugin',
			'booth-countdown'
		];
	}

	public function get_year() {
		return array(
			'2018' => '2018',
			'2019' => '2019',
			'2020' => '2020',
			'2021' => '2021',
			'2022' => '2022'
		);
	}

	public function get_month() {
		return array(
			'1' => esc_html__( 'January', 'booth-elementor' ),
			'2' => esc_html__( 'February', 'booth-elementor' ),
			'3' => esc_html__( 'March', 'booth-elementor' ),
			'4' => esc_html__( 'April', 'booth-elementor' ),
			'5' => esc_html__( 'May', 'booth-elementor' ),
			'6' => esc_html__( 'June', 'booth-elementor' ),
			'7' => esc_html__( 'July', 'booth-elementor' ),
			'8' => esc_html__( 'August', 'booth-elementor' ),
			'9' => esc_html__( 'September', 'booth-elementor' ),
			'10' => esc_html__( 'October', 'booth-elementor' ),
			'11' => esc_html__( 'November', 'booth-elementor' ),
			'12' => esc_html__( 'December', 'booth-elementor' ),
		);
	}

	public function get_day() {
		return array(
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
		);
	}

	public function get_hour() {
		return array(
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
			'24' => '24'
		);
	}

	public function get_minute() {
		return array(
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
			'25' => '25',
			'26' => '26',
			'27' => '27',
			'28' => '28',
			'29' => '29',
			'30' => '30',
			'31' => '31',
			'32' => '32',
			'33' => '33',
			'34' => '34',
			'35' => '35',
			'36' => '36',
			'37' => '37',
			'38' => '38',
			'39' => '39',
			'40' => '40',
			'41' => '41',
			'42' => '42',
			'43' => '43',
			'44' => '44',
			'45' => '45',
			'46' => '46',
			'47' => '47',
			'48' => '48',
			'49' => '49',
			'50' => '50',
			'51' => '51',
			'52' => '52',
			'53' => '53',
			'54' => '54',
			'55' => '55',
			'56' => '56',
			'57' => '57',
			'58' => '58',
			'59' => '59',
			'60' => '60',
		);
	}

    protected function register_content_controls() {

		self::$widget->__start('countdown_settings_content', __('Countdown','booth-elementor'));

		self::$widget->select_control( 'skin', __( 'Skin','booth-elementor'), '',
			[
				''=> __( 'Default', 'booth-elementor' ),
				'qodef-light-skin'=> __( 'Light', 'booth-elementor' ),
			]
		);

		self::$widget->select_control( 'year', __( 'Year','booth-elementor'), '',$this->get_year());

		self::$widget->select_control( 'month', __( 'Month','booth-elementor'), '',$this->get_month());

		self::$widget->select_control( 'day', __( 'Day','booth-elementor'), '',$this->get_day());
		self::$widget->select_control( 'hour', __( 'Hour','booth-elementor'), '',$this->get_hour());
		self::$widget->select_control( 'minute', __( 'Minute','booth-elementor'), '',$this->get_minute());


		self::$widget->text_control('month_label',__('Months Label','booth-elementor'),__('Months','booth-elementor'));
		self::$widget->text_control('day_label',__('Day Label','booth-elementor'),__('Days','booth-elementor'));
		self::$widget->text_control('hour_label',__('Hours Label','booth-elementor'),__('Hours','booth-elementor'));
		self::$widget->text_control('minute_label',__('Minutes Label','booth-elementor'),__('Minutes','booth-elementor'));
		self::$widget->text_control('second_label',__('Seconds Label','booth-elementor'),__('Seconds','booth-elementor'));

		self::$widget->number_control('digit_font_size',__('Digit Font Size (px)','booth-elementor'),'','','0','1000','1');
		self::$widget->number_control('label_font_size',__('Label Font Size(px)','booth-elementor'),'','','0','1000','1');

		// $range = [
		// 	'px' => [
		// 		'min' => 0,
		// 		'max' => 1000,
		// 		'step' => 1,
		// 	],
		// ];
		// self::$widget->slider_control('digit_font_size',__('Digit Font Size','booth-elementor'),[ 'px'],$range);
		// self::$widget->slider_control('label_font_size',__('Label Font Size','booth-elementor'),[ 'px'],$range);


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


		$id             = $this->get_id();
		$id             = mt_rand( 1000, 9999 );
		$holder_classes = $this->getHolderClasses( $settings );
		$data    = $this->getHolderData( $settings );

		$this->add_render_attribute( 'countdown', 'class', ['qodef-countdown',$holder_classes] );
		$this->add_render_attribute( 'countdown', 'id', 'countdown'.esc_attr( $id ) );
		foreach ($data as $key => $value) {
			$this->add_render_attribute( 'countdown', $key, $value );
		}
		?>
		<div <?php $this->print_render_attribute_string( 'countdown' ); ?>></div>
		<?php
	}

	private function getHolderClasses( $params ) {
		$holderClasses = array();

		$holderClasses[] = ! empty( $params['custom_class'] ) ? esc_attr( $params['custom_class'] ) : '';
		$holderClasses[] = ! empty( $params['skin'] ) ? $params['skin'] : '';

		return implode( ' ', $holderClasses );
	}

	private function getHolderData( $params ) {
		$holderData = array();

		$holderData['data-year']         = ! empty( $params['year'] ) ? $params['year'] : '';
		$holderData['data-month']        = ! empty( $params['month'] ) ? $params['month'] : '';
		$holderData['data-day']          = ! empty( $params['day'] ) ? $params['day'] : '';
		$holderData['data-hour']         = $params['hour'] !== '' ? $params['hour'] : '';
		$holderData['data-minute']       = $params['minute'] !== '' ? $params['minute'] : '';
		$holderData['data-month-label']  = ! empty( $params['month_label'] ) ? $params['month_label'] : esc_html__( 'Months', 'booth-elementor' );
		$holderData['data-day-label']    = ! empty( $params['day_label'] ) ? $params['day_label'] : esc_html__( 'Days', 'booth-elementor' );
		$holderData['data-hour-label']   = ! empty( $params['hour_label'] ) ? $params['hour_label'] : esc_html__( 'Hours', 'booth-elementor' );
		$holderData['data-minute-label'] = ! empty( $params['minute_label'] ) ? $params['minute_label'] : esc_html__( 'Minutes', 'booth-elementor' );
		$holderData['data-second-label'] = ! empty( $params['second_label'] ) ? $params['second_label'] : esc_html__( 'Seconds', 'booth-elementor' );
		$holderData['data-digit-size']   = ! empty( $params['digit_font_size'] ) ? $params['digit_font_size'] : '';
		$holderData['data-label-size']   = ! empty( $params['label_font_size'] ) ? $params['label_font_size'] : '';

		return $holderData;
	}

}
