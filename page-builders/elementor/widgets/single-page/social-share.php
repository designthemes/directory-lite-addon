<?php

namespace DTElementor\Widgets;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;

class DTDirectoryLiteSpSocialShare extends Widget_Base {

	public function get_categories() {
		return [ 'dtdr-singlepage-widgets' ];
	}

	public function get_name() {
		return 'dtdr-widget-sp-social-share';
	}

	public function get_title() {
		return esc_html__( 'Social Share','dtdr-lite');
	}

	public function get_style_depends() {
		$file_handlers =  dtdr_dependent_files_instance()->dtdr_single_page_module_files( 'dtdr_sp_social_share' );
		return $file_handlers['css'];
	}

	public function get_script_depends() {
		$file_handlers =  dtdr_dependent_files_instance()->dtdr_single_page_module_files( 'dtdr_sp_social_share' );
		return $file_handlers['js'];
	}

	protected function _register_controls() {

		$listing_singular_label = apply_filters( 'listing_label', 'singular' );

		$this->start_controls_section( 'social_share_default_section', array(
			'label' => esc_html__( 'General','dtdr-lite'),
		) );

			$this->add_control( 'listing_id', array(
				'label'       => sprintf( esc_html__('%1$s Id','dtdr-lite'), $listing_singular_label ),
				'type'        => Controls_Manager::TEXT,
				'description' => sprintf( esc_html__('Provide %1$s id to display your item. No need to provide ID if it is used in %1$s single page.','dtdr-lite'), strtolower($listing_singular_label) ),
				'default'     => ''
			) );

			$this->add_control( 'show_facebook', array(
				'label'       => esc_html__( 'Show Facebook','dtdr-lite'),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'false' => esc_html__('False','dtdr-lite'),
					'true'  => esc_html__('True','dtdr-lite'),
				),
				'description' => esc_html__('Choose "True" if you like to show facebook share.','dtdr-lite'),
				'default'      => 'false'
			) );

			$this->add_control( 'show_delicious', array(
				'label'       => esc_html__( 'Show Delicious','dtdr-lite'),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'false' => esc_html__('False','dtdr-lite'),
					'true'  => esc_html__('True','dtdr-lite'),
				),
				'description' => esc_html__('Choose "True" if you like to show delicious share.','dtdr-lite'),
				'default'      => 'false'
			) );

			$this->add_control( 'show_digg', array(
				'label'       => esc_html__( 'Show Digg','dtdr-lite'),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'false' => esc_html__('False','dtdr-lite'),
					'true'  => esc_html__('True','dtdr-lite'),
				),
				'description' => esc_html__('Choose "True" if you like to show digg share.','dtdr-lite'),
				'default'      => 'false'
			) );

			$this->add_control( 'show_stumbleupon', array(
				'label'       => esc_html__( 'Show Stumble Upon','dtdr-lite'),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'false' => esc_html__('False','dtdr-lite'),
					'true'  => esc_html__('True','dtdr-lite'),
				),
				'description' => esc_html__('Choose "True" if you like to show stumble upon share.','dtdr-lite'),
				'default'      => 'false'
			) );

			$this->add_control( 'show_twitter', array(
				'label'       => esc_html__( 'Show Twitter','dtdr-lite'),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'false' => esc_html__('False','dtdr-lite'),
					'true'  => esc_html__('True','dtdr-lite'),
				),
				'description' => esc_html__('Choose "True" if you like to show twitter share.','dtdr-lite'),
				'default'      => 'false'
			) );

			$this->add_control( 'show_googleplus', array(
				'label'       => esc_html__( 'Show Google Plus','dtdr-lite'),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'false' => esc_html__('False','dtdr-lite'),
					'true'  => esc_html__('True','dtdr-lite'),
				),
				'description' => esc_html__('Choose "True" if you like to show google plus share.','dtdr-lite'),
				'default'      => 'false'
			) );

			$this->add_control( 'show_linkedin', array(
				'label'       => esc_html__( 'Show LinkedIn','dtdr-lite'),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'false' => esc_html__('False','dtdr-lite'),
					'true'  => esc_html__('True','dtdr-lite'),
				),
				'description' => esc_html__('Choose "True" if you like to show linkedin share.','dtdr-lite'),
				'default'      => 'false'
			) );

			$this->add_control( 'show_pinterest', array(
				'label'       => esc_html__( 'Show Pinterest','dtdr-lite'),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'false' => esc_html__('False','dtdr-lite'),
					'true'  => esc_html__('True','dtdr-lite'),
				),
				'description' => esc_html__('Choose "True" if you like to show pinterest share.','dtdr-lite'),
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
		echo do_shortcode('[dtdr_sp_social_share '.$attributes.' /]');
	}

}