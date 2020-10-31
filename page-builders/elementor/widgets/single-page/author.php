<?php

namespace DTElementor\Widgets;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;

class DTDirectoryLiteSpAuthor extends Widget_Base {

	public function get_categories() {
		return [ 'dtdr-singlepage-widgets' ];
	}

	public function get_name() {
		return 'dtdr-widget-sp-author';
	}

	public function get_title() {
		return esc_html__( 'Author Details','dtdr-lite');
	}

	public function get_style_depends() {
		return array ( 'swiper', 'dtdr-modules-singlepage' );
	}

	public function get_script_depends() {
		return array ( 'swiper', 'dtdr-modules-singlepage' );
	}

	protected function _register_controls() {

		$listing_singular_label = apply_filters( 'listing_label', 'singular' );
		$incharge_plural_label = apply_filters( 'incharge_label', 'plural' );

		$this->start_controls_section( 'author_default_section', array(
			'label' => esc_html__( 'General','dtdr-lite'),
		) );

			$this->add_control( 'listing_id', array(
				'label'       => sprintf( esc_html__('%1$s Id','dtdr-lite'), $listing_singular_label ),
				'type'        => Controls_Manager::TEXT,
				'description' => sprintf( esc_html__('Provide %1$s id to display your item. No need to provide ID if it is used in %1$s single page.','dtdr-lite'), strtolower($listing_singular_label) ),
				'default'     => ''
			) );

			$this->add_control( 'content_type', array(
				'label'       => esc_html__( 'Content Type','dtdr-lite'),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'author'             => esc_html__( 'Post Author','dtdr-lite'),
					'incharges_included' => sprintf( esc_html__('%1$s Included','dtdr-lite'), $incharge_plural_label ),
					'both'               => esc_html__( 'Both','dtdr-lite')
				),
				'description' => esc_html__('Contact type that you like to display.','dtdr-lite'),
				'default'      => 'author'
			) );

			$this->add_control( 'columns', array(
				'label'       => esc_html__( 'Columns','dtdr-lite'),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					1  => esc_html__('I Column','dtdr-lite'),
					2  => esc_html__('II Columns','dtdr-lite')
				),
				'description' => sprintf( esc_html__( 'Number of columns you like to display your %1$s.','dtdr-lite'), strtolower($seller_plural_label) ),
				'default'      => 1,
			) );

			$this->add_control( 'class', array(
				'label'   => esc_html__( 'Class','dtdr-lite'),
				'type'    => Controls_Manager::TEXT,
				'description' => esc_html__( 'If you wish you can add additional class name here.','dtdr-lite'),
				'default' => ''
			) );

		$this->end_controls_section();


		$this->start_controls_section( 'authorcarousel_section', array(
			'label' => esc_html__( 'Carousel Options','dtdr-lite'),
		) );

			$this->add_control( 'enable_carousel', array(
				'label'       => esc_html__( 'Enable Carousel','dtdr-lite'),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'false' => esc_html__('False','dtdr-lite'),
					'true'  => esc_html__('True','dtdr-lite'),
				),
				'description' => esc_html__( 'If you wish you can enable carousel for your item listings.','dtdr-lite'),
				'default'      => 'false'
			) );

			$this->add_control( 'carousel_pagination', array(
				'label'       => esc_html__( 'Carousel Pagination','dtdr-lite'),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					''        => esc_html__('None','dtdr-lite'),
					'bullets' => esc_html__('Bullets','dtdr-lite'),
					'arrows'  => esc_html__('Arrows','dtdr-lite'),
				),
				'description' => esc_html__( 'Choose one of the available paginations.','dtdr-lite'),
				'condition'   => array( 'enable_carousel' => 'true' ),
				'default'      => ''
			) );

			$this->add_control( 'carousel_pagination_type', array(
				'label'       => esc_html__( 'Carousel Pagination Type','dtdr-lite'),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'type1' => esc_html__('Type 1','dtdr-lite'),
					'type2' => esc_html__('Type 2','dtdr-lite')
				),
				'description' =>  esc_html__( 'Choose one of the available pagination design types.','dtdr-lite'),
				'condition'   => array( 'enable_carousel' => 'true' ),
				'default'      => 'type1'
			) );

			$this->add_control( 'carousel_spacebetween', array(
				'label'   => esc_html__( 'Space Between Sliders','dtdr-lite'),
				'type'    => Controls_Manager::TEXT,
				'description' => esc_html__( 'Space between sliders can be given here.','dtdr-lite'),
				'condition'   => array( 'enable_carousel' => 'true' ),
				'default' => 20
			) );

		$this->end_controls_section();


	}

	protected function render() {

		$settings = $this->get_settings();
		$attributes = dtdirectorylite_elementor_instance()->dtdr_parse_shortcode_attrs( $settings );
		$output = do_shortcode('[dtdr_sp_author '.$attributes.' /]');

		echo $output;

	}

}