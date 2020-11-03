<?php

namespace DTElementor\Widgets;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;

class DTDirectoryLiteSpComments extends Widget_Base {

	public function get_categories() {
		return [ 'dtdr-singlepage-widgets' ];
	}

	public function get_name() {
		return 'dtdr-widget-sp-comments';
	}

	public function get_title() {
		return esc_html__( 'Comments','dtdr-lite');
	}

	public function get_style_depends() {
		return array ( 'dtdr-modules-singlepage' );
	}

	public function get_script_depends() {
		return array ( 'dtdr-modules-singlepage' );
	}

	protected function _register_controls() {

		$this->start_controls_section( 'comments_default_section', array(
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
		echo do_shortcode('[dtdr_sp_comments '.$attributes.' /]');

	}

}