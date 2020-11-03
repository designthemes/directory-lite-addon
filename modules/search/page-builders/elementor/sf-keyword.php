<?php

namespace DTElementor\Widgets;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;

class DTDirectoryLiteSfKeyword extends Widget_Base {

	public function get_categories() {
		return [ 'dtdr-searchform-widgets' ];
	}

	public function get_name() {
		return 'dtdr-widget-sf-keyword';
	}

	public function get_title() {
		return esc_html__( 'Keyword','dtdr-lite');
	}

	public function get_style_depends() {
		return array ( 'dtdr-fields', 'dtdr-search-frontend');
	}

	public function get_script_depends() {
		return array ( 'dtdr-search-frontend');
	}

	protected function _register_controls() {

		$this->start_controls_section( 'keyword_default_section', array(
			'label' => esc_html__( 'General','dtdr-lite'),
		) );

			$this->add_control( 'placeholder_text', array(
				'label'       => esc_html__( 'Placeholder Text','dtdr-lite'),
				'type'        => Controls_Manager::TEXT,
				'description' => esc_html__( 'You can provide your own text for placeholder of this item.','dtdr-lite'),
				'default'     => ''
			) );

			$this->add_control( 'ajax_load', array(
				'label'       => esc_html__( 'Ajax Load','dtdr-lite'),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'false' => esc_html__('False','dtdr-lite'),
					'true'  => esc_html__('True','dtdr-lite'),
				),
				'description' => esc_html__('If you want to display the output in same page choose "True" here.','dtdr-lite'),
				'default'      => 'false'
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

		$settings   = $this->get_settings();
		$attributes = dtdirectorylite_elementor_instance()->dtdr_parse_shortcode_attrs( $settings );
		$output     = do_shortcode('[dtdr_sf_keyword_field '.$attributes.' /]');

		echo $output;

	}

}