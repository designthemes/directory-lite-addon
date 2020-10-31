<?php

namespace DTElementor\Widgets;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;

class DTDirectoryLiteDfListingsMap extends Widget_Base {

	public function get_categories() {
		return [ 'dtdr-default-widgets' ];
	}

	public function get_name() {
		return 'dtdr-widget-df-listings-map';
	}

	public function get_title() {
		$listing_plural_label = apply_filters( 'listing_label', 'plural' );
		return sprintf( esc_html__('%1$s Map','dtdr-lite'), $listing_plural_label );
	}

	public function get_style_depends() {
		$file_handlers =  dtdr_dependent_files_instance()->dtdr_default_module_files( 'dtdr_listings_map' );
		return $file_handlers['css'];
	}

	public function get_script_depends() {
		$file_handlers =  dtdr_dependent_files_instance()->dtdr_default_module_files( 'dtdr_listings_map' );
		return $file_handlers['js'];
	}

	protected function _register_controls() {

		$listing_singular_label = apply_filters( 'listing_label', 'singular' );
		$contracttype_singular_label = apply_filters( 'contracttype_label', 'singular' );
		$contracttype_plural_label = apply_filters( 'contracttype_label', 'plural' );
		$seller_singular_label = apply_filters( 'seller_label', 'singular' );
		$incharge_singular_label = apply_filters( 'incharge_label', 'singular' );

		$countries_list = dtdr_countries_list(false);
		$countries_list = array('' => esc_html__('All','dtdr-lite')) + $countries_list;

		$this->start_controls_section( 'listings_map_default_section', array(
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
				'description' => esc_html__('Choose type of layout you like to display.','dtdr-lite'),
				'default'      => 'type1',
			) );

			$this->add_control( 'additional_info', array(
				'label'       => esc_html__( 'Additional Info','dtdr-lite'),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					''               => esc_html__('None','dtdr-lite'),
					'totalviews'     => esc_html__('Total Views','dtdr-lite'),
					'averageratings' => esc_html__('Average Ratings','dtdr-lite'),
					'categoryimage'  => esc_html__('Category Image','dtdr-lite'),
					'categoryicon'  => esc_html__('Category Icon','dtdr-lite')
				),
				'description' => esc_html__( 'Choose additional info that you like to display along with location marker. ','dtdr-lite'),
				'default'      => '',
			) );

			$this->add_control( 'category_background_color', array(
				'label'       => esc_html__( 'Background Color','dtdr-lite'),
				'type'        => Controls_Manager::COLOR,
				'description' => esc_html__( 'Select background color for your Category Icon. Icon will be taken from the category settings.','dtdr-lite'),
				'condition'   => array( 'additional_info' => array ('categoryimage', 'categoryicon') )
			) );

			$this->add_control( 'category_color', array(
				'label'       => esc_html__( 'Color','dtdr-lite'),
				'type'        => Controls_Manager::COLOR,
				'description' => esc_html__( 'Select background color for your Category Image / Icon. Image / Icon will be taken from the category settings.','dtdr-lite'),
				'condition'   => array( 'additional_info' => array ('categoryimage', 'categoryicon') )
			) );

			$this->add_control( 'zoom_level', array(
				'label'   => esc_html__( 'Zoom Level','dtdr-lite'),
				'type'    => Controls_Manager::TEXT,
				'description' => esc_html__( 'Add map zoom level here. This will overwrite the default map zoom level. Ex: ... 9, 10, 11...','dtdr-lite'),
				'default' => ''
			) );

			$this->add_control( 'map_type', array(
				'label'       => esc_html__( 'Map Type','dtdr-lite'),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					''          => esc_html__('Default','dtdr-lite'),
					'SATELLITE' => esc_html__('SATELLITE','dtdr-lite'),
					'HYBRID'    => esc_html__('HYBRID','dtdr-lite'),
					'TERRAIN'   => esc_html__('TERRAIN','dtdr-lite'),
					'ROADMAP'   => esc_html__('ROADMAP','dtdr-lite'),
				),
				'description' => esc_html__( 'Choose map type for this item.','dtdr-lite'),
				'default'      => '',
			) );

			$this->add_control( 'map_color', array(
				'label'       => esc_html__( 'Map Color','dtdr-lite'),
				'type'        => Controls_Manager::COLOR,
				'description' => esc_html__( 'Select color for your map. This will override the default map color.','dtdr-lite')
			) );

			$this->add_control( 'class', array(
				'label'   => esc_html__( 'Class','dtdr-lite'),
				'type'    => Controls_Manager::TEXT,
				'description' => esc_html__( 'If you wish you can add additional class name here.','dtdr-lite'),
				'default' => ''
			) );

		$this->end_controls_section();


		$this->start_controls_section( 'listings_map_filter_section', array(
			'label' => esc_html__( 'Filter Options','dtdr-lite'),
		) );

			$this->add_control( 'list_item_ids', array(
				'label'   => sprintf( esc_html__('%1$s Item Ids','dtdr-lite'), $listing_singular_label ),
				'type'    => Controls_Manager::TEXT,
				'description' => sprintf( esc_html__( 'Enter %1$s item ids separated by commas.','dtdr-lite'), $listing_singular_label ),
				'default' => ''
			) );

			$this->add_control( 'category_ids', array(
				'label'   => sprintf( esc_html__('%1$s Category Ids','dtdr-lite'), $listing_singular_label ),
				'type'    => Controls_Manager::TEXT,
				'description' => sprintf( esc_html__( 'Enter %1$s category ids separated by commas.','dtdr-lite'), $listing_singular_label ),
				'default' => ''
			) );

			$this->add_control( 'cities_ids', array(
				'label'   => sprintf( esc_html__('%1$s Cities Ids','dtdr-lite'), $listing_singular_label ),
				'type'    => Controls_Manager::TEXT,
				'description' => sprintf( esc_html__( 'Enter %1$s cities ids separated by commas.','dtdr-lite'), $listing_singular_label ),
				'default' => ''
			) );

			$this->add_control( 'neighborhoods_ids', array(
				'label'   => sprintf( esc_html__('%1$s Neighborhoods Ids','dtdr-lite'), $listing_singular_label ),
				'type'    => Controls_Manager::TEXT,
				'description' => sprintf( esc_html__( 'Enter %1$s neighborhoods ids separated by commas.','dtdr-lite'), $listing_singular_label ),
				'default' => ''
			) );

			$this->add_control( 'countiesstates_ids', array(
				'label'   => sprintf( esc_html__('%1$s Counties / States Ids','dtdr-lite'), $listing_singular_label ),
				'type'    => Controls_Manager::TEXT,
				'description' => sprintf( esc_html__( 'Enter %1$s counties / states ids separated by commas.','dtdr-lite'), $listing_singular_label ),
				'default' => ''
			) );

			$this->add_control( 'contracttypes_ids', array(
				'label'   => sprintf( esc_html__('%1$s %2$s','dtdr-lite'), $listing_singular_label, $contracttype_plural_label ),
				'type'    => Controls_Manager::TEXT,
				'description' => sprintf( esc_html__('Enter %1$s ids separated by commas','dtdr-lite'), $contracttype_plural_label ),
				'default' => ''
			) );

			$this->add_control( 'tag_ids', array(
				'label'   => sprintf( esc_html__('%1$s Tag Ids','dtdr-lite'), $listing_singular_label ),
				'type'    => Controls_Manager::TEXT,
				'description' => esc_html__( 'Enter tag ids separated by commas.','dtdr-lite'),
				'default' => ''
			) );

			$this->add_control( 'country_id', array(
				'label'   => esc_html__('Countries','dtdr-lite'),
				'type'        => Controls_Manager::SELECT,
				'options'     => $countries_list,
				'description' => esc_html__( 'Choose countries for which you like to display items.','dtdr-lite'),
				'default' => ''
			) );

			$this->add_control( 'seller_ids', array(
				'label'   => sprintf( esc_html__('%1$s %2$s Ids','dtdr-lite'), $listing_singular_label, $seller_singular_label ),
				'type'    => Controls_Manager::TEXT,
				'description' => sprintf( esc_html__('Enter %1$s ids separated by commas.','dtdr-lite'), strtolower($seller_singular_label) ),
				'default' => ''
			) );

			$this->add_control( 'incharge_ids', array(
				'label'   => sprintf( esc_html__('%1$s %2$s Ids','dtdr-lite'), $listing_singular_label, $incharge_singular_label ),
				'type'    => Controls_Manager::TEXT,
				'description' => sprintf( esc_html__('Enter %1$s ids separated by commas.','dtdr-lite'), strtolower($incharge_singular_label) ),
				'default' => ''
			) );

		$this->end_controls_section();

	}

	protected function render() {

		$settings = $this->get_settings();
		$attributes = dtdirectorylite_elementor_instance()->dtdr_parse_shortcode_attrs( $settings );
		$output = do_shortcode('[dtdr_listings_map '.$attributes.' /]');

		echo $output;

	}

}