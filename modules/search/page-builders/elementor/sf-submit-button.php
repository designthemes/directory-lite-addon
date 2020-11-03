<?php

namespace DTElementor\Widgets;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;

class DTDirectoryLiteSfSubmitButton extends Widget_Base {

	public function get_categories() {
		return [ 'dtdr-searchform-widgets' ];
	}

	public function get_name() {
		return 'dtdr-widget-sf-submit-button';
	}

	public function get_title() {
		return esc_html__( 'Submit Button','dtdr-lite');
	}

	public function get_style_depends() {
		return array ( 'dtdr-fields', 'dtdr-search-frontend');
	}

	public function get_script_depends() {
		return array ( 'dtdr-search-frontend');
	}

	protected function _register_controls() {

		$this->start_controls_section( 'submit_button_default_section', array(
			'label' => esc_html__( 'General','dtdr-lite'),
		) );

			$this->add_control( 'output_type', array(
				'label'       => esc_html__( 'Output Type','dtdr-lite'),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					''              => esc_html__('Same Page - Ajax Load','dtdr-lite'),
					'separate-page' => esc_html__('Separate Page','dtdr-lite'),
				),
				'description' => esc_html__( 'Choose how you like to display search output.','dtdr-lite'),
				'default'      => ''
			) );

			$this->add_control( 'separate_page_url', array(
				'label'   => esc_html__( 'Separate Page URL','dtdr-lite'),
				'type'    => Controls_Manager::TEXT,
                'description' => esc_html__( 'Separate page url in which search content have to displayed. You have to create that page with search form shortcode.','dtdr-lite'),	
                'condition'   => array( 'output_type' => 'separate-page' ),
				'default' => ''
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
		$output     = do_shortcode('[dtdr_sf_submit_button '.$attributes.' /]');

		echo $output;

	}

}