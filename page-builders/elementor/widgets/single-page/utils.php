<?php

namespace DTElementor\Widgets;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;

class DTDirectoryLiteSpUtils extends Widget_Base {

	public function get_categories() {
		return [ 'dtdr-singlepage-widgets' ];
	}

	public function get_name() {
		return 'dtdr-widget-sp-utils';
	}

	public function get_title() {
		return esc_html__( 'Utils','dtdr-lite');
	}

	public function get_style_depends() {
		return array ( 'dtdr-modules-singlepage' );
	}

	public function get_script_depends() {
		return array ( 'dtdr-modules-singlepage' );
	}

	protected function _register_controls() {

		$listing_singular_label      = apply_filters( 'listing_label', 'singular' );
		$contracttype_singular_label = apply_filters( 'contracttype_label', 'singular' );
		$seller_singular_label       = apply_filters( 'seller_label', 'singular' );
		$amenity_singular_label      = apply_filters( 'amenity_label', 'singular' );

		$this->start_controls_section( 'utils_default_section', array(
			'label' => esc_html__( 'General','dtdr-lite'),
		) );

			$this->add_control( 'listing_id', array(
				'label'       => sprintf( esc_html__('%1$s Id','dtdr-lite'), $listing_singular_label ),
				'type'        => Controls_Manager::TEXT,
				'description' => sprintf( esc_html__('Provide %1$s id to display your item. No need to provide ID if it is used in %1$s single page.','dtdr-lite'), strtolower($listing_singular_label) ),
				'default'     => ''
			) );

			$this->add_control( 'show_title', array(
				'label'       => esc_html__( 'Show Title','dtdr-lite'),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'false' => esc_html__('False','dtdr-lite'),
					'true'  => esc_html__('True','dtdr-lite'),
				),
				'description' => esc_html__('Choose "True" if you like to show title.','dtdr-lite'),
				'default'      => 'false'
			) );

			$this->add_control( 'show_favourite', array(
				'label'       => esc_html__( 'Show Favourite','dtdr-lite'),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'false' => esc_html__('False','dtdr-lite'),
					'true'  => esc_html__('True','dtdr-lite'),
				),
				'description' => esc_html__('Choose "True" if you like to show favourite option.','dtdr-lite'),
				'default'      => 'false'
			) );

			$this->add_control( 'show_pageview', array(
				'label'       => esc_html__( 'Show Page View','dtdr-lite'),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'false' => esc_html__('False','dtdr-lite'),
					'true'  => esc_html__('True','dtdr-lite'),
				),
				'description' => esc_html__('Choose "True" if you like to show page view.','dtdr-lite'),
				'default'      => 'false'
			) );

			$this->add_control( 'show_print', array(
				'label'       => esc_html__( 'Show Print','dtdr-lite'),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'false' => esc_html__('False','dtdr-lite'),
					'true'  => esc_html__('True','dtdr-lite'),
				),
				'description' => esc_html__('Choose "True" if you like to show print option.','dtdr-lite'),
				'default'      => 'false'
			) );

			$this->add_control( 'show_socialshare', array(
				'label'       => esc_html__( 'Show Social Share','dtdr-lite'),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'false' => esc_html__('False','dtdr-lite'),
					'true'  => esc_html__('True','dtdr-lite'),
				),
				'description' =>  esc_html__('Choose "True" if you like to show social share option.','dtdr-lite'),
				'default'      => 'false'
			) );

			$this->add_control( 'show_averagerating', array(
				'label'       => esc_html__( 'Show Average Rating','dtdr-lite'),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'false' => esc_html__('False','dtdr-lite'),
					'true'  => esc_html__('True','dtdr-lite'),
				),
				'description' => esc_html__('Choose "True" if you like to show average rating.','dtdr-lite'),
				'default'      => 'false'
			) );

			$this->add_control( 'show_featured', array(
				'label'       => esc_html__( 'Show Featured Item','dtdr-lite'),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'false' => esc_html__('False','dtdr-lite'),
					'true'  => esc_html__('True','dtdr-lite'),
				),
				'description' => esc_html__('Choose "True" if you like to show featured item.','dtdr-lite'),
				'default'      => 'false'
			) );

			$this->add_control( 'show_categories', array(
				'label'       => esc_html__( 'Show Categories','dtdr-lite'),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'false' => esc_html__('False','dtdr-lite'),
					'true'  => esc_html__('True','dtdr-lite'),
				),
				'description' => esc_html__('Choose "True" if you like to show categories.','dtdr-lite'),
				'default'      => 'false'
			) );

			$this->add_control( 'show_cities', array(
				'label'       => esc_html__( 'Show Cities','dtdr-lite'),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'false' => esc_html__('False','dtdr-lite'),
					'true'  => esc_html__('True','dtdr-lite'),
				),
				'description' => esc_html__('Choose "True" if you like to show cities.','dtdr-lite'),
				'default'      => 'false'
			) );

			$this->add_control( 'show_neighborhoods', array(
				'label'       => esc_html__( 'Show Neighborhoods','dtdr-lite'),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'false' => esc_html__('False','dtdr-lite'),
					'true'  => esc_html__('True','dtdr-lite'),
				),
				'description' => esc_html__('Choose "True" if you like to show neighborhoods.','dtdr-lite'),
				'default'      => 'false'
			) );

			$this->add_control( 'show_countystate', array(
				'label'       => esc_html__( 'Show County / State','dtdr-lite'),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'false' => esc_html__('False','dtdr-lite'),
					'true'  => esc_html__('True','dtdr-lite'),
				),
				'description' => esc_html__('Choose "True" if you like to show county / state.','dtdr-lite'),
				'default'      => 'false'
			) );

			$this->add_control( 'show_contracttype', array(
				'label'       => sprintf( esc_html__('Show %1$s','dtdr-lite'), $contracttype_singular_label ),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'false' => esc_html__('False','dtdr-lite'),
					'true'  => esc_html__('True','dtdr-lite'),
				),
				'description' => sprintf( esc_html__('Choose "True" if you like to show %1$s','dtdr-lite'), strtolower($contracttype_singular_label) ),
				'default'      => 'false'
			) );

			$this->add_control( 'show_amenity', array(
				'label'       => sprintf( esc_html__('Show %1$s','dtdr-lite'), $amenity_singular_label ),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'false' => esc_html__('False','dtdr-lite'),
					'true'  => esc_html__('True','dtdr-lite'),
				),
				'description' => sprintf( esc_html__('Choose "True" if you like to show %1$s','dtdr-lite'), strtolower($amenity_singular_label) ),
				'default'      => 'false'
			) );

			$this->add_control( 'show_price', array(
				'label'       => esc_html__( 'Show Price','dtdr-lite'),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'false' => esc_html__('False','dtdr-lite'),
					'true'  => esc_html__('True','dtdr-lite'),
				),
				'description' => esc_html__('Choose "True" if you like to show price.','dtdr-lite'),
				'default'      => 'false'
			) );

			$this->add_control( 'show_address', array(
				'label'       => esc_html__( 'Show Address','dtdr-lite'),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'false' => esc_html__('False','dtdr-lite'),
					'true'  => esc_html__('True','dtdr-lite'),
				),
				'description' => esc_html__('Choose "True" if you like to show address.','dtdr-lite'),
				'default'      => 'false'
			) );

			$this->add_control( 'show_contactdetails', array(
				'label'       => esc_html__( 'Show Contact Details','dtdr-lite'),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					''       => esc_html__( 'None','dtdr-lite'),
					'list'   => sprintf( esc_html__('%1$s','dtdr-lite'), $listing_singular_label ),
					'seller' => sprintf( esc_html__('%1$s','dtdr-lite'), $seller_singular_label )
				),
				'description' => esc_html__('Contact details that you like to display.','dtdr-lite'),
				'default'      => ''
			) );

			$this->add_control( 'show_contactdetails_onrequest', array(
				'label'       => esc_html__( 'Show Contact Details - On Request','dtdr-lite'),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'false' => esc_html__('False','dtdr-lite'),
					'true'  => esc_html__('True','dtdr-lite'),
				),
				'description' => esc_html__('Choose "True" if you like to show contact details on request.','dtdr-lite'),
				'default'      => 'false'
			) );

			$this->add_control( 'show_startdate', array(
				'label'       => esc_html__( 'Show Start Date','dtdr-lite'),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'false' => esc_html__('False','dtdr-lite'),
					'true'  => esc_html__('True','dtdr-lite'),
				),
				'description' => esc_html__('Choose "True" if you like to show start date.','dtdr-lite'),
				'default'      => 'false'
			) );

			$this->add_control( 'show_enddate', array(
				'label'       => esc_html__( 'Show End Date','dtdr-lite'),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'false' => esc_html__('False','dtdr-lite'),
					'true'  => esc_html__('True','dtdr-lite'),
				),
				'description' => esc_html__('Choose "True" if you like to show end date.','dtdr-lite'),
				'default'      => 'false'
			) );

			$this->add_control( 'show_posteddate', array(
				'label'       => esc_html__( 'Show Posted Date','dtdr-lite'),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'false' => esc_html__('False','dtdr-lite'),
					'true'  => esc_html__('True','dtdr-lite'),
				),
				'description' => esc_html__('Choose "True" if you like to show posted date.','dtdr-lite'),
				'default'      => 'false'
			) );

			$this->add_control( 'show_mergeddates', array(
				'label'       => esc_html__( 'Show Merged Date','dtdr-lite'),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'false' => esc_html__('False','dtdr-lite'),
					'true'  => esc_html__('True','dtdr-lite'),
				),
				'description' => esc_html__('Choose "True" if you like to show merged date.','dtdr-lite'),
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
		$output = do_shortcode('[dtdr_sp_utils '.$attributes.' /]');

		echo $output;

	}

}