<?php

namespace DTElementor\Widgets;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;

class DTDirectoryLiteDfSellers extends Widget_Base {

	public function get_categories() {
		return [ 'dtdr-default-widgets' ];
	}

	public function get_name() {
		return 'dtdr-widget-df-sellers';
	}

	public function get_title() {
		return esc_html__( 'Sellers Listing','dtdr-lite');
	}

	public function get_style_depends() {
		return array ( 'dtdr-modules-default' );
	}

	public function get_script_depends() {
		return array ( 'dtdr-frontend' );
	}

	protected function _register_controls() {

		$seller_plural_label = apply_filters( 'seller_label', 'plural' );
		$seller_singular_label = apply_filters( 'seller_label', 'singular' );

		$this->start_controls_section( 'sellers_default_section', array(
			'label' => esc_html__( 'General','dtdr-lite'),
		) );

			$this->add_control( 'type', array(
				'label'       => esc_html__( 'Type','dtdr-lite'),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'type1' => esc_html__('Type 1','dtdr-lite'),
					'type2' => esc_html__('Type 2','dtdr-lite'),
					'type3' => esc_html__('Type 3','dtdr-lite')
				),
				'description' => sprintf( esc_html__( 'Choose the type that you like to display for your %1$s.','dtdr-lite'), $seller_plural_label),
				'default'      => 'type1',
			) );

			$this->add_control( 'columns', array(
				'label'       => esc_html__( 'Columns','dtdr-lite'),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'' => esc_html__('None','dtdr-lite'),
					1  => esc_html__('I Column','dtdr-lite'),
					2  => esc_html__('II Columns','dtdr-lite'),
					3  => esc_html__('III Columns','dtdr-lite')
				),
				'description' => sprintf( esc_html__( 'Number of columns you like to display your %1$s.','dtdr-lite'), strtolower($seller_plural_label) ),
				'default'      => '',
			) );

			$this->add_control( 'include', array(
				'label'   => esc_html__( 'Include','dtdr-lite'),
				'type'    => Controls_Manager::TEXT,
				'description' => sprintf( esc_html__( 'List of %1$s ids separated by commas.','dtdr-lite'), strtolower($seller_singular_label) ),
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

		echo do_shortcode('[dtdr_sellers '.$attributes.' /]');
	}

}