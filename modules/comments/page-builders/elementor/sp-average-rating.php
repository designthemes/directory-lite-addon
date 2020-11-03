<?php

namespace DTElementor\Widgets;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;

class DTDirectoryLiteSpAverageRating extends Widget_Base {

	public function get_categories() {
		return [ 'dtdr-singlepage-widgets' ];
	}

	public function get_name() {
		return 'dtdr-widget-sp-average-rating';
	}

	public function get_title() {
		return esc_html__( 'Average Rating','dtdr-lite');
	}

	public function get_style_depends() {
		return array ('dtdr-comments-frontend');
	}

	public function get_script_depends() {
		return array ();
	}

	protected function _register_controls() {

		$listing_singular_label = apply_filters( 'listing_label', 'singular' );

		$this->start_controls_section( 'average_rating_default_section', array(
			'label' => esc_html__( 'General','dtdr-lite'),
		) );

			$this->add_control( 'listing_id', array(
				'label'       => sprintf( esc_html__('%1$s Id','dtdr-lite'), $listing_singular_label ),
				'type'        => Controls_Manager::TEXT,
				'description' => sprintf( esc_html__('Provide %1$s id to display your item. No need to provide ID if it is used in %1$s single page.','dtdr-lite'), strtolower($listing_singular_label) ),
				'default'     => ''
			) );

			$this->add_control( 'display', array(
				'label'           => esc_html__( 'Display','dtdr-lite'),
				'type'            => Controls_Manager::SELECT,
				'options'         => array(
					'both'           => esc_html__('Both','dtdr-lite'),
					'star-rating'    => esc_html__('Star Rating','dtdr-lite'),
					'overall-rating' => esc_html__('Overall Rating','dtdr-lite'),
				),
				'description'     => esc_html__( 'Choose type of content to display.','dtdr-lite'),
				'default'         => 'both',
			) );

			$this->add_control( 'type', array(
				'label'       => esc_html__( 'Type','dtdr-lite'),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'type1' => esc_html__('Type 1','dtdr-lite'),
					'type2' => esc_html__('Type 2','dtdr-lite'),
					'type3' => esc_html__('Type 3','dtdr-lite')
				),
				'description' => esc_html__( 'Choose any of the available type.','dtdr-lite'),
				'default'      => 'type1',
			) );

			$this->add_control( 'class', array(
				'label'       => esc_html__( 'Class','dtdr-lite'),
				'type'        => Controls_Manager::TEXT,
				'description' => esc_html__( 'If you wish you can add additional class name here.','dtdr-lite'),
				'default'     => ''
			) );

		$this->end_controls_section();
	}

	protected function render() {

		$settings   = $this->get_settings();
		$attributes = dtdirectorylite_elementor_instance()->dtdr_parse_shortcode_attrs( $settings );
		$output     = do_shortcode('[dtdr_sp_average_rating '.$attributes.' /]');

		echo $output;

	}

}