<?php

namespace DTElementor\Widgets;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;

class DTDirectoryLiteSpFeaturedComments extends Widget_Base {

	public function get_categories() {
		return [ 'dtdr-singlepage-widgets' ];
	}

	public function get_name() {
		return 'dtdr-widget-sp-featured-comments';
	}

	public function get_title() {
		return esc_html__( 'Comments - Featured','dtdr-lite');
	}

	public function get_style_depends() {
		return array ('dtdr-comments-frontend');
	}

	public function get_script_depends() {
		return array ('dtdr-comments-common', 'dtdr-comments-frontend');
	}

	protected function _register_controls() {

		$this->start_controls_section( 'featured_comments_default_section', array(
			'label' => esc_html__( 'General','dtdr-lite'),
		) );

			$this->add_control( 'enable_title', array(
				'label'       => esc_html__( 'Enable Title','dtdr-lite'),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'false' => esc_html__('False','dtdr-lite'),
					'true'  => esc_html__('True','dtdr-lite'),
				),
				'default'      => 'false'
			) );

			$this->add_control( 'enable_rating', array(
				'label'       => esc_html__( 'Enable Rating','dtdr-lite'),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'false' => esc_html__('False','dtdr-lite'),
					'true'  => esc_html__('True','dtdr-lite'),
				),
				'default'      => 'false'
			) );

			$this->add_control( 'enable_media', array(
				'label'       => esc_html__( 'Enable Media','dtdr-lite'),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'false' => esc_html__('False','dtdr-lite'),
					'true'  => esc_html__('True','dtdr-lite'),
				),
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

		$settings = $this->get_settings();
		$attributes = dtdirectorylite_elementor_instance()->dtdr_parse_shortcode_attrs( $settings );
		$output = do_shortcode('[dtdr_sp_featured_comments '.$attributes.' /]');

		echo $output;

	}

}