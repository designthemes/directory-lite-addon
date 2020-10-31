<?php

namespace DTElementor\Widgets;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;

class DTDirectoryLiteDfLoginLogoutLinks extends Widget_Base {

	public function get_categories() {
		return [ 'dtdr-default-widgets' ];
	}

	public function get_name() {
		return 'dtdr-widget-df-login-logout-links';
	}

	public function get_title() {
		return esc_html__( 'Login / Logout Links','dtdr-lite');
	}

	public function get_style_depends() {
		return array ( 'dtdr-modules-default' );
	}

	public function get_script_depends() {
		return array ( 'dtdr-frontend' );
	}

	protected function _register_controls() {

		$this->start_controls_section( 'login_logout_links_default_section', array(
			'label' => esc_html__( 'General','dtdr-lite'),
		) );

			$this->add_control( 'class', array(
				'label'   => esc_html__( 'Class','dtdr-lite'),
				'type'    => Controls_Manager::TEXT,
				'description' => esc_html__( 'If you wish you can add additional class name here.','dtdr-lite'),
				'default' => ''
			) );

		$this->end_controls_section();
	}

	protected function render() {

		$settings = $this->get_settings();
		$attributes = dtdirectorylite_elementor_instance()->dtdr_parse_shortcode_attrs( $settings );
		$output = do_shortcode('[dtdr_login_logout_links '.$attributes.' /]');

		echo $output;

	}

}