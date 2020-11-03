<?php

namespace DTElementor\Widgets;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;

class DTDirectoryLiteSpDates extends Widget_Base {

	public function get_categories() {
		return [ 'dtdr-singlepage-widgets' ];
	}

	public function get_name() {
		return 'dtdr-widget-sp-dates';
	}

	public function get_title() {
		return esc_html__( 'Dates','dtdr-lite');
	}

	public function get_style_depends() {
		$file_handlers =  dtdr_dependent_files_instance()->dtdr_single_page_module_files( 'dtdr_sp_post_dates' );
		return $file_handlers['css'];
	}

	public function get_script_depends() {
		$file_handlers =  dtdr_dependent_files_instance()->dtdr_single_page_module_files( 'dtdr_sp_post_dates' );
		return $file_handlers['js'];
	}

	protected function _register_controls() {

		$listing_singular_label = apply_filters( 'listing_label', 'singular' );

		$this->start_controls_section( 'dates_default_section', array(
			'label' => esc_html__( 'General','dtdr-lite'),
		) );

			$this->add_control( 'listing_id', array(
				'label'       => sprintf( esc_html__('%1$s Id','dtdr-lite'), $listing_singular_label ),
				'type'        => Controls_Manager::TEXT,
				'description' => sprintf( esc_html__('Provide %1$s id to display your item. No need to provide ID if it is used in %1$s single page.','dtdr-lite'), strtolower($listing_singular_label) ),
				'default'     => ''
			) );

			$this->add_control( 'include_startdate', array(
				'label'       => esc_html__( 'Include Start Date','dtdr-lite'),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'false' => esc_html__('False','dtdr-lite'),
					'true'  => esc_html__('True','dtdr-lite'),
				),
				'description' => esc_html__('Choose "True" if you like to display start date in this shortcode. If "Merge Date" option is chosen "Start Date" will be included automatically.','dtdr-lite'),
				'default'      => 'false'
			) );

			$this->add_control( 'include_enddate', array(
				'label'       => esc_html__( 'Include End Date','dtdr-lite'),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'false' => esc_html__('False','dtdr-lite'),
					'true'  => esc_html__('True','dtdr-lite'),
				),
				'description' => esc_html__('Choose "True" if you like to display start date in this shortcode. If "Merge Date" option is chosen "End Date" will be included automatically.','dtdr-lite'),
				'default'      => 'false'
			) );

			$this->add_control( 'include_starttime', array(
				'label'       => esc_html__( 'Include Start Time','dtdr-lite'),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'false' => esc_html__('False','dtdr-lite'),
					'true'  => esc_html__('True','dtdr-lite'),
				),
				'description' => esc_html__('Choose "True" if you like to display start time along with date.','dtdr-lite'),
				'default'      => 'false'
			) );

			$this->add_control( 'include_endtime', array(
				'label'       => esc_html__( 'Include End Time','dtdr-lite'),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'false' => esc_html__('False','dtdr-lite'),
					'true'  => esc_html__('True','dtdr-lite'),
				),
				'description' => esc_html__('Choose "True" if you like to display end time along with date.','dtdr-lite'),
				'default'      => 'false'
			) );

			$this->add_control( 'include_postdate', array(
				'label'       => esc_html__( 'Include Post Date','dtdr-lite'),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'false' => esc_html__('False','dtdr-lite'),
					'true'  => esc_html__('True','dtdr-lite'),
				),
				'description' => esc_html__('Choose "True" if you like to display post date in this shortcode.','dtdr-lite'),
				'default'      => 'false'
			) );

			$this->add_control( 'include_posttime', array(
				'label'       => esc_html__( 'Include Post Time','dtdr-lite'),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'false' => esc_html__('False','dtdr-lite'),
					'true'  => esc_html__('True','dtdr-lite'),
				),
				'description' => esc_html__('Choose "True" if you like to display post time along with date.','dtdr-lite'),
				'default'      => 'false'
			) );

			$this->add_control( 'with_label', array(
				'label'       => esc_html__( 'With Label','dtdr-lite'),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'false' => esc_html__('False','dtdr-lite'),
					'true'  => esc_html__('True','dtdr-lite'),
				),
				'description' => esc_html__('Choose "True" if you like to display label along with date.','dtdr-lite'),
				'default'      => 'false'
			) );

			$this->add_control( 'with_icon', array(
				'label'       => esc_html__( 'With Icon','dtdr-lite'),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'false' => esc_html__('False','dtdr-lite'),
					'true'  => esc_html__('True','dtdr-lite'),
				),
				'description' => esc_html__('Choose "True" if you like to display icon along with date.','dtdr-lite'),
				'default'      => 'false'
			) );

			$this->add_control( 'merge_dates', array(
				'label'       => esc_html__( 'Merge Dates','dtdr-lite'),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'false' => esc_html__('False','dtdr-lite'),
					'true'  => esc_html__('True','dtdr-lite'),
				),
				'description' => esc_html__('Choose "True" if you like to merge start and end dates.','dtdr-lite'),
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
		echo do_shortcode('[dtdr_sp_post_dates '.$attributes.' /]');
	}

}