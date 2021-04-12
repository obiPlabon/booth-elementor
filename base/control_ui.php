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

trait Control_Ui {

	/**
	 * extend extra control option
	 *
	 * @param array $arguments
	 * @param array $extra
	 * @return void
	 */
    private function extend_arguments( $arguments, $extra ) {
        return array_merge( $arguments, $extra );
    }

	/**
	 * add control
	 *
	 * @param string $id
	 * @param array $arguments
	 * @param boolean $responsive
	 * @return void
	 */
    private function add_control_args( $id = '', $arguments = [], $responsive = false ) {
        if ($responsive) {
            $this->add_responsive_control(
                $id,
                $arguments
            );
        } else {
            $this->add_control(
                $id,
                $arguments
            );
        }
    }

	/**
	 * add group control
	 *
	 * @param object $type
	 * @param array $arguments
	 * @return void
	 */
    private function add_group_control_args( $type, $arguments ) {
        $this->add_group_control(
            $type,
            $arguments
        );
	}

	/**
	 * start control section
	 *
	 * @param string $id
	 * @param string $label
	 * @param object $tab
	 * @return void
	 */
    public function __start( $id, $label, $tab_name = 'content' ) {
		$tab = [
			'content' => Controls_Manager::TAB_CONTENT,
			'style' => Controls_Manager::TAB_STYLE,
		];
        $this->start_controls_section(
            $id,
            [
                'label' => $label,
				'tab' => $tab[ $tab_name ],
            ]
        );
	}



    public function __end() {
        return $this->end_controls_section();
    }

    /* Controls */
    public function text_control( $id, $label, $default = '', $placeholder = '', $dynamic = true, $extra = [] ) {
        $arguments = $this->extend_arguments([
            'label' => $label,
            'type' => Controls_Manager::TEXT,
            'default' => $default,
            'placeholder' => $placeholder,
            'dynamic' => [
                'active' => $dynamic,
            ],
        ], $extra);
        $this->add_control_args($id, $arguments);
    }

    public function textarea_control( $id, $label, $default = '', $placeholder = '', $dynamic = true, $extra = [] ) {
        $arguments = $this->extend_arguments([
            'label' => $label,
            'label_block' => true,
            'type' => Controls_Manager::TEXTAREA,
            'default' => $default,
            'placeholder' => $placeholder,
            'dynamic' => [
                'active' => $dynamic,
            ],
        ], $extra);
        $this->add_control_args($id, $arguments);
    }

    public function wysiwyg_control( $id, $label, $default = '', $placeholder = '', $dynamic = true, $extra = [] ) {
        $arguments = $this->extend_arguments([
            'label' => $label,
            'label_block' => true,
            'type' => Controls_Manager::WYSIWYG,
            'default' => $default,
            'placeholder' => $placeholder,
            'dynamic' => [
                'active' => $dynamic,
            ],
		], $extra);
		$this->add_control_args($id, $arguments);
	}

    public function number_control($id, $label, $default = '', $placeholder = '', $min = '0',  $max = '100', $step = '1', $dynamic = true, $extra = [] ) {
        $arguments = $this->extend_arguments([
            'label' => $label,
            'type' => Controls_Manager::NUMBER,
            'default' => $default,
			'placeholder' => $placeholder,
			'min' => $min,
			'max' => $max,
			'step' => $step,
            'dynamic' => [
                'active' => $dynamic,
            ],
		], $extra);
		$this->add_control_args($id, $arguments);
	}

    public function url_control($id, $label, $default = [ 'url' => '', 'is_external' => true, 'nofollow' => true ], $placeholder = '', $dynamic = true, $extra = []) {
        $arguments = $this->extend_arguments([
            'label' => $label,
            'type' => Controls_Manager::URL,
            'default' => $default,
			'placeholder' => $placeholder,
			'show_external' => true,
            'dynamic' => [
                'active' => $dynamic,
            ],
		], $extra);
		$this->add_control_args($id, $arguments);
	}

    public function media_control( $id, $label, $default = [], $dynamic = true, $extra = [] ) {
        $arguments = $this->extend_arguments([
            'type' => Controls_Manager::MEDIA,
            'label' => $label,
            'default' => $default ? $default : [ 'url' => Utils::get_placeholder_image_src() ],
            'dynamic' => [
                'active' => $dynamic,
            ],
        ], $extra);
        $this->add_control_args($id, $arguments);
    }

    public function gallery_control( $id, $label, $default = [], $dynamic = true, $extra = [] ) {
        $arguments = $this->extend_arguments([
            'type' => Controls_Manager::GALLERY,
            'label' => $label,
            'default' => $default,
            'dynamic' => [
                'active' => $dynamic,
            ],
        ], $extra);
        $this->add_control_args($id, $arguments);
	}

    public function hidden_control( $id, $label, $default = '', $extra = [] ) {
        $arguments = $this->extend_arguments([
            'type' => Controls_Manager::HIDDEN,
            'label' => $label,
			'default' => $default,
        ], $extra);
		$this->add_control_args($id, $arguments);
	}

    public function switcher_control($id, $label, $default = 'yes', $label_on = '', $label_off = '', $return_value = 'yes', $extra = []) {
        $arguments = $this->extend_arguments([
            'label'        => $label,
            'type'         => Controls_Manager::SWITCHER,
			'default'      => $default,
			'label_on' => $label_on,
			'label_off' => $label_off,
            'return_value' => $return_value,
        ], $extra);
        $this->add_control_args($id, $arguments);
    }

    public function popover_toggle_control($id, $label, $default = 'yes', $label_on = '', $label_off = '', $return_value = 'yes', $extra = []) {
        $arguments = $this->extend_arguments([
            'label'        => $label,
            'type'         => Controls_Manager::POPOVER_TOGGLE,
			'default'      => $default,
			'label_on' => $label_on,
			'label_off' => $label_off,
            'return_value' => $return_value,
        ], $extra);
		$this->add_control_args($id, $arguments);
	}

    public function select_control($id, $label, $default = '', $options = [], $extra = []) {
        $arguments = $this->extend_arguments([
            'label' => $label,
            'type' => Controls_Manager::SELECT,
            'default' => $default,
            'options' => $options,
        ], $extra);
        $this->add_control_args($id, $arguments);
    }

    public function select2_control($id, $label, $default = '', $options = [], $multiple = false, $extra = []) {
        $arguments = $this->extend_arguments([
            'label' => $label,
            'type' => Controls_Manager::SELECT2,
            'default' => $default,
            'options' => $options,
            'multiple' => $multiple,
        ], $extra);
        $this->add_control_args($id, $arguments);
    }

    public function choose_control($id, $label, $default = '', $options = [], $toggle = false, $selectors = [], $extra = []) {
		$default_option = [
			'left' => [
				'title' => __( 'Left', 'happy-elementor-addons' ),
				'icon' => 'fa fa-align-left',
			],
			'center' => [
				'title' => __( 'Center', 'happy-elementor-addons' ),
				'icon' => 'fa fa-align-center',
			],
			'right' => [
				'title' => __( 'Right', 'happy-elementor-addons' ),
				'icon' => 'fa fa-align-right',
			],
		];
        $arguments = $this->extend_arguments([
            'label' => $label,
            'type' => Controls_Manager::CHOOSE,
            'default' => $default,
            'options' => $options ? $options : $default_option,
            'toggle' => $toggle,
			'selectors' => $selectors,
			'prefix_class' => ''
        ], $extra);
        $this->add_control_args($id, $arguments);
	}

	public function color_control($id, $label, $default = '', $selectors = [], $extra=[]) {
        $arguments = $this->extend_arguments([
            'label' => $label,
            'type' => Controls_Manager::COLOR,
			'default' => $default,
			'selectors' => $selectors,
        ], $extra);
        $this->add_control_args($id, $arguments);
    }

	public function icon_control($id, $label, $default = 'fa fa-facebook', $options = [], $include = [], $exclude = [], $extra=[]) {
        $arguments = $this->extend_arguments([
            'label' => $label,
            'type' => Controls_Manager::ICON,
			'default' => $default,
			'options' => $options,
			'include' => $include,
			'exclude' => $exclude,
        ], $extra);
		$this->add_control_args($id, $arguments);
    }

	public function icons_control($id, $label, $default = [ 'value' => 'fas fa-star', 'library' => 'solid'], $recommended = [], $skin = 'media', $extra=[]) {
        $arguments = $this->extend_arguments([
            'label' => $label,
            'type' => Controls_Manager::ICONS,
			'default' => $default,
			'recommended' => $recommended,
			'skin' => $skin,
        ], $extra);
		$this->add_control_args($id, $arguments);
    }

	public function date_control($id, $label, $default = '', $picker_options = ['enableTime' => true,'minuteIncrement' => '1'], $extra=[]) {
        $arguments = $this->extend_arguments([
            'label' => $label,
            'type' => Controls_Manager::DATE_TIME,
			'default' => $default ? $default : date('Y-m-d HH:ii', current_time('timestamp', 0)),
			'picker_options' => $picker_options,
        ], $extra);
		$this->add_control_args($id, $arguments);
    }

	public function animation_control($id, $label, $default = '', $prefix_class = 'animated ', $extra=[]) {
        $arguments = $this->extend_arguments([
            'label' => $label,
            'type' => Controls_Manager::ANIMATION,
			'default' => $default,
			'prefix_class' => $prefix_class,
        ], $extra);
		$this->add_control_args($id, $arguments);
    }

	public function hover_animation_control($id, $label, $default = '', $prefix_class = 'elementor-animation-', $extra=[]) {
        $arguments = $this->extend_arguments([
            'label' => $label,
            'type' => Controls_Manager::HOVER_ANIMATION,
			'default' => $default,
			'prefix_class' => $prefix_class,
        ], $extra);
		$this->add_control_args($id, $arguments);
    }

    public function repater_control($repeater, $id, $title = '', $extra = []) {
        $arguments = $this->extend_arguments([
            'show_label' => false,
            'type' => Controls_Manager::REPEATER,
            'fields' => $repeater->get_controls(),
            'title_field' => '<# print(title || "EasyGrid Item"); #>',
        ], $extra);
        $this->add_control_args($id, $arguments);
    }

    public function image_size_control($name, $label = '', $default = '', $label_block = true, $extra = []) {
        $arguments = $this->extend_arguments([
            'label' => $label,
            'label_block' => $label_block,
            'name' => $name,
            'default' => $default,
        ], $extra);
        $this->add_group_control_args(Group_Control_Image_Size::get_type(), $arguments);
    }

    public function slider_control($id, $label, $size_units = [], $range = [], $default = [], $label_block = true, $extra = []) {
        $arguments = $this->extend_arguments([
            'label' => $label,
            'label_block' => $label_block,
            'type' => Controls_Manager::SLIDER,
            'size_units' => $size_units,
            'range' => $range,
            'default' => $default,
        ], $extra);
        $this->add_control_args($id, $arguments, true);
    }


    public function typography_control($name, $label = '', $label_block = true, $extra = []) {
        $arguments = $this->extend_arguments([
            'label' => $label,
            'label_block' => $label_block,
            'name' => $name,
            'scheme' => Typography::TYPOGRAPHY_1,
        ], $extra);
        $this->add_group_control_args(Group_Control_Typography::get_type(), $arguments);
    }
    /* End Controls */

}
