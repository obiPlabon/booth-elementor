<?php
/**
 * Contact form 7 widget class.
 */
namespace Booth_Elementor\Widget;

defined( 'ABSPATH' ) || die();

use Elementor\Controls_Manager;

class CF7 extends Base {

	public function get_title() {
		return __( 'Contact Form', 'booth-elementor' );
	}

	public function get_keywords() {
		return ['booth', 'contact', 'form'];
	}

	protected function register_content_controls() {
		if ( ! defined( 'WPCF7_VERSION' ) ) {
			$this->start_controls_section(
				'_cf7_warning',
				[
					'label' => __( 'Warning!', 'booth-elementor' ),
					'tab' => Controls_Manager::TAB_CONTENT,
				]
			);

			$this->add_control(
				'_cf7_warning_content',
				[
					'type' => Controls_Manager::RAW_HTML,
					'raw' => sprintf(
						__( 'Hey, looks like %1$s is missing in your site. Please click on the link below and install/activate %1$s. Make sure to refresh this page after installation or activation.', 'booth-elementor' ),
						'<a href="'.esc_url( admin_url( 'plugin-install.php?s=Contact+Form+7&tab=search&type=term' ) )
						.'" target="_blank" rel="noopener">Contact Form 7</a>'
					),
					'content_classes' => 'elementor-panel-alert elementor-panel-alert-danger',
				]
			);

			$this->add_control(
				'_cf7_install',
				[
					'type' => Controls_Manager::RAW_HTML,
					'raw' => '<a href="'.esc_url( admin_url( 'plugin-install.php?s=Contact+Form+7&tab=search&type=term' ) ).'" target="_blank" rel="noopener">Click to install or activate Contact Form 7</a>',
				]
			);

			$this->end_controls_section();
			return;
		}

		$cf7 = get_posts( 'post_type="wpcf7_contact_form"&numberposts=-1' );

		$contact_forms = array();
		if ( $cf7 ) {
			$contact_forms = wp_list_pluck( $cf7, 'post_title', 'ID' );
		} else {
			$contact_forms[] = esc_html__( 'No contact forms found', 'js_composer' );
		}

		$this->start_controls_section(
			'_cf7_content',
			[
				'label' => __( 'Contact Form 7', 'booth-elementor' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'form_id',
			[
				'label'   => __( 'Select Form', 'booth-elementor' ),
				'type'    => Controls_Manager::SELECT,
				'options' => $contact_forms,
			]
		);

		$this->add_control(
			'html_class',
			[
				'label'   => __( 'Select Form', 'booth-elementor' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'default'            => esc_html__('Default', 'booth'),
					'cf7_custom_style_1' => esc_html__('Custom Style 1', 'booth'),
					'cf7_custom_style_2' => esc_html__('Custom Style 2', 'booth'),
					'cf7_custom_style_3' => esc_html__('Custom Style 3', 'booth'),
				]
			]
		);

		$this->end_controls_section();
	}

	protected function register_style_controls() {}

	protected function render() {
		$settings = $this->get_settings_for_display();

		if ( ! empty( $settings['form_id'] ) && function_exists( 'wpcf7_contact_form_tag_func' ) ) {
			echo wpcf7_contact_form_tag_func( [
				'id' => $settings['form_id'],
				'html_class' => $settings['html_class']
			], null, 'contact-form-7' );
		} elseif ( current_user_can( 'edit_posts' ) ) {
			echo '<p>Form is missing or invalid id.</p>';
		}
	}
}
