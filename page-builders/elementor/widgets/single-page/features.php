<?php

namespace DTElementor\Widgets;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;

class DTDirectoryLiteSpFeatures extends Widget_Base {

	public function get_categories() {
		return [ 'dtdr-singlepage-widgets' ];
	}

	public function get_name() {
		return 'dtdr-widget-sp-features';
	}

	public function get_title() {
		return esc_html__( 'Features','dtdr-lite');
	}

	public function get_style_depends() {
		return array ( 'dtdr-modules-singlepage' );
	}

	public function get_script_depends() {
		return array ( 'dtdr-modules-singlepage' );
	}

	protected function _register_controls() {

		$listing_singular_label = apply_filters( 'listing_label', 'singular' );
		$seller_plural_label    = apply_filters( 'seller_label', 'plural' );

		$this->start_controls_section( 'features_default_section', array(
			'label' => esc_html__( 'General','dtdr-lite'),
		) );

			$this->add_control( 'listing_id', array(
				'label'       => sprintf( esc_html__('%1$s Id','dtdr-lite'), $listing_singular_label ),
				'type'        => Controls_Manager::TEXT,
				'description' => sprintf( esc_html__('Provide %1$s id to display your item. No need to provide ID if it is used in %1$s single page.','dtdr-lite'), strtolower($listing_singular_label) ),
				'default'     => ''
			) );

			$this->add_control( 'type', array(
				'label'       => esc_html__( 'Type','dtdr-lite'),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'type1' => esc_html__('Type 1','dtdr-lite'),
					'type2' => esc_html__('Type 2','dtdr-lite'),
					'type3' => esc_html__('Type 3','dtdr-lite'),
					'type4' => esc_html__('Type 4','dtdr-lite'),
					'type5' => esc_html__('Type 5','dtdr-lite'),
					'type6' => esc_html__('Type 6','dtdr-lite'),
					'type7' => esc_html__('Type 7','dtdr-lite')
				),
				'description' => esc_html__( 'Choose any of the available type.','dtdr-lite'),
				'default'      => 'type1',
			) );

			$this->add_control( 'include', array(
				'label'   => esc_html__( 'Include','dtdr-lite'),
				'type'    => Controls_Manager::TEXT,
				'description' => esc_html__( 'If you like, you can include only certain items. Leave empty if you like to display all.','dtdr-lite'),
				'default' => ''
			) );

			$this->add_control( 'columns', array(
				'label'       => esc_html__( 'Columns','dtdr-lite'),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					-1  => esc_html__('No Column','dtdr-lite'),
					1  => esc_html__('I Column','dtdr-lite'),
					2  => esc_html__('II Columns','dtdr-lite'),
					3  => esc_html__('III Columns','dtdr-lite'),
					4  => esc_html__('IV Columns','dtdr-lite'),
				),
				'description' => sprintf( esc_html__( 'Number of columns you like to display your %1$s.','dtdr-lite'), strtolower($seller_plural_label) ),
				'default'      => 4,
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
		echo do_shortcode('[dtdr_sp_features '.$attributes.' /]');
	}

}