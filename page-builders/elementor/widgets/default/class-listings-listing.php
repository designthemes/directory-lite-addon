<?php

namespace DTElementor\Widgets;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;

class DTDirectoryLiteDfListingsListing extends Widget_Base {

	public function get_categories() {
		return [ 'dtdr-default-widgets' ];
	}

	public function get_name() {
		return 'dtdr-widget-df-listings-listing';
	}

	public function get_title() {
		$listing_plural_label = apply_filters( 'listing_label', 'plural' );
		return sprintf( esc_html__('%1$s Listing','dtdr-lite'), $listing_plural_label );
	}

	public function get_style_depends() {
		return array ( 'swiper', 'dtdr-modules-listing', 'dtdr-modules-default' );
	}

	public function get_script_depends() {
		return array ( 'swiper', 'dtdr-frontend' );
	}

	public function dtdr_dynamic_register_controls() {
	}

	protected function _register_controls() {

		$listing_singular_label      = apply_filters( 'listing_label', 'singular' );
		$contracttype_singular_label = apply_filters( 'contracttype_label', 'singular' );
		$contracttype_plural_label   = apply_filters( 'contracttype_label', 'plural' );
		$seller_singular_label       = apply_filters( 'seller_label', 'singular' );
		$incharge_singular_label     = apply_filters( 'incharge_label', 'singular' );
		$amenity_singular_label      = apply_filters( 'amenity_label', 'singular' );
		$amenity_plural_label        = apply_filters( 'amenity_label', 'plural' );

		$this->start_controls_section( 'listings_listing_default_section', array(
			'label' => esc_html__( 'General','dtdr-lite'),
		) );

			$this->add_control( 'type', array(
				'label'       => esc_html__( 'Type','dtdr-lite'),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'type1'  => esc_html__('Type 1','dtdr-lite'),
					'type2'  => esc_html__('Type 2','dtdr-lite'),
					'type3'  => esc_html__('Type 3','dtdr-lite'),
					'type4'  => esc_html__('Type 4','dtdr-lite'),
					'type5'  => esc_html__('Type 5','dtdr-lite'),
					'type6'  => esc_html__('Type 6','dtdr-lite'),
					'type7'  => esc_html__('Type 7','dtdr-lite'),
					'type8'  => esc_html__('Type 8','dtdr-lite'),
					'type9'  => esc_html__('Type 9','dtdr-lite'),
					'type10' => esc_html__('Type 10','dtdr-lite')
				),
				'description' => esc_html__('Choose type of layout you like to display.','dtdr-lite'),
				'default'      => 'type1',
			) );

			$this->add_control( 'gallery', array(
				'label'       => esc_html__( 'Gallery','dtdr-lite'),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'featured_image'        => esc_html__('Featured Image','dtdr-lite'),
					'image_gallery'         => esc_html__('Image Gallery','dtdr-lite'),
					'gallery_with_featured' => esc_html__('Image Gallery With Featured Image','dtdr-lite'),
				),
				'description' => esc_html__( 'Choose how you like to display image gallery.','dtdr-lite'),
				'default'      => 'featured_image',
			) );

			$this->add_control( 'post_per_page', array(
				'label'   => esc_html__( 'Post Per Page','dtdr-lite'),
				'type'    => Controls_Manager::TEXT,
				'description' => esc_html__( 'Number of posts to show per page. Rest of the posts will be displayed in pagination.','dtdr-lite'),
				'default' => 4
			) );

			$this->add_control( 'columns', array(
				'label'       => esc_html__( 'Columns','dtdr-lite'),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					1  => esc_html__('I Column','dtdr-lite'),
					2  => esc_html__('II Columns','dtdr-lite'),
					3  => esc_html__('III Columns','dtdr-lite'),
					4  => esc_html__('IV Columns','dtdr-lite')
				),
				'description' => esc_html__( 'Number of columns you like to display your items.','dtdr-lite'),
				'condition'   => array( 'type' => array( 'type1', 'type2', 'type4', 'type6', 'type8', 'type10') ),
				'default'      => 1,
			) );

			$this->add_control( 'apply_isotope', array(
				'label'       => esc_html__( 'Apply Isotope','dtdr-lite'),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'false' => esc_html__('False','dtdr-lite'),
					'true'  => esc_html__('True','dtdr-lite'),
				),
				'description' => esc_html__('Choose true if you like to apply isotope for your items.  Isotope won\'t work along with Carousel.','dtdr-lite'),
				'default'      => 'true'
			) );

			$this->add_control( 'isotope_filter', array(
				'label'       => esc_html__( 'Isotope Filter','dtdr-lite'),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					''             => esc_html__( 'None','dtdr-lite'),
					'category'     => esc_html__( 'Category','dtdr-lite'),
					'contracttype' => sprintf( esc_html__('%1$s','dtdr-lite'), $contracttype_singular_label ),
				),
				'condition'   => array( 'apply_isotope' => 'true' ),
				'description' => esc_html__('Choose isotope filter you like to use.','dtdr-lite'),
				'default'      => ''
			) );

			$this->add_control( 'apply_child_of', array(
				'label'       => esc_html__( 'Apply Child Of','dtdr-lite'),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'false' => esc_html__('False','dtdr-lite'),
					'true'  => esc_html__('True','dtdr-lite'),
				),
				'condition'   => array( 'apply_isotope' => 'true' ),
				'description' => sprintf( esc_html__('If you wish to apply child of specified categories or %1$s in filters, choose "True". If no categories or %1$s specified in "Filter Options" this option won\'t work.','dtdr-lite'), strtolower($contracttype_plural_label) ),
				'default'      => 'false'
			) );

			$this->add_control( 'featured_items', array(
				'label'       => esc_html__( 'Featured Items','dtdr-lite'),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'false' => esc_html__('False','dtdr-lite'),
					'true'  => esc_html__('True','dtdr-lite'),
				),
				'description' => esc_html__('Choose true if you like to display featured items.','dtdr-lite'),
				'default'      => 'false'
			) );

			$this->add_control( 'excerpt_length', array(
				'label'   => esc_html__( 'Excerpt Length','dtdr-lite'),
				'type'    => Controls_Manager::TEXT,
				'description' => esc_html__( 'Provide excerpt length here.','dtdr-lite'),
				'condition'   => array( 'type' => array ( 'type1', 'type2', 'type3', 'type4', 'type5', 'type7', 'type8', 'type9', 'type10' ) ),
				'default' => 20
			) );

			$this->add_control( 'features_image_or_icon', array(
				'label'       => esc_html__( 'Features Image or Icon','dtdr-lite'),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					''      => esc_html__('None','dtdr-lite'),
					'image' => esc_html__('Image','dtdr-lite'),
					'icon'  => esc_html__('Icon','dtdr-lite')
				),
				'description' => esc_html__('Choose any of the option available to display features.','dtdr-lite'),
				'condition'   => array( 'type' => array ( 'type1', 'type2', 'type3', 'type4', 'type5', 'type6', 'type8', 'type9' ) ),
				'default'      => '',
			) );

			$this->add_control( 'features_include', array(
				'label'       => esc_html__( 'Features Include','dtdr-lite'),
				'type'        => Controls_Manager::TEXT,
				'description' => esc_html__('Give features id separated by comma. Only 4 maximum number of features allowed.','dtdr-lite'),
				'condition'   => array( 'type' => array ( 'type1', 'type2', 'type3', 'type4', 'type5', 'type6', 'type8', 'type9' ) ),
				'default'      => '',
			) );

			$this->add_control( 'no_of_cat_to_display', array(
				'label'       => esc_html__( 'No. Of Categories to Display','dtdr-lite'),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					0  => 0,
					1  => 1,
					2  => 2,
					3  => 3,
					4  => 4
				),
				'description' => esc_html__( 'Number of categories you like to display on your items.','dtdr-lite'),
				'default'      => 2,
			) );

			$this->add_control( 'apply_equal_height', array(
				'label'       => esc_html__( 'Apply Equal Height','dtdr-lite'),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'false' => esc_html__('False','dtdr-lite'),
					'true'  => esc_html__('True','dtdr-lite'),
				),
				'condition'   => array( 'apply_isotope' => 'false' ),
				'description' => esc_html__('Apply equal height for you items.','dtdr-lite'),
				'default'      => 'false'
			) );

			$this->add_control( 'apply_custom_height', array(
				'label'       => esc_html__( 'Apply Custom Height','dtdr-lite'),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'false' => esc_html__('False','dtdr-lite'),
					'true'  => esc_html__('True','dtdr-lite'),
				),
				'description' => esc_html__('Apply custom height for your entire section.','dtdr-lite'),
				'default'      => 'false'
			) );

			$this->add_responsive_control( 'height', array(
                'label' => esc_html__( 'Height','dtdr-lite'),
                'type' => Controls_Manager::TEXT,
				'description' => esc_html__( 'Provide height for your section in "px" here.','dtdr-lite'),
				'condition'   => array( 'apply_custom_height' => 'true' ),
                'devices' => array( 'desktop', 'tablet', 'mobile' ),
                'selectors' => array(
					'{{WRAPPER}} .dtdr-listing-output-data-container' => 'height: {{SIZE}}px;',
				),
			) );

			$this->add_control( 'sidebar_widget', array(
				'label'       => esc_html__( 'Sidebar Widget','dtdr-lite'),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'false' => esc_html__('False','dtdr-lite'),
					'true'  => esc_html__('True','dtdr-lite'),
				),
				'description' => sprintf( esc_html__('%1$s 1) If you wish to show these items in sidebar set this to "True". %2$s %1$s 2) This options is not applicable for "Type 3", "Type 5" and "Type 7". %2$s','dtdr-lite'), '<p>', '</p>' ),
				'default'      => 'false'
			) );

			$this->add_control( 'class', array(
				'label'   => esc_html__( 'Class','dtdr-lite'),
				'type'    => Controls_Manager::TEXT,
				'description' => esc_html__( 'If you wish you can add additional class name here.','dtdr-lite'),
				'default' => ''
			) );

		$this->end_controls_section();

		$this->dtdr_dynamic_register_controls();

		// From Location Module

		$dtdr_modules = dtdirectorylite_instance()->active_modules;
		if(is_array($dtdr_modules) && !empty($dtdr_modules)) {
			if(in_array('location', $dtdr_modules)) {

				$countries_list = dtdr_countries_list(false);
				$countries_list = array('' => esc_html__('All','dtdr-lite')) + $countries_list;

				$this->start_controls_section( 'listings_listing_location_default_section', array(
					'label' => esc_html__( 'Filter Options - Location','dtdr-lite'),
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

					$this->add_control( 'country_id', array(
						'label'   => esc_html__('Countries','dtdr-lite'),
						'type'        => Controls_Manager::SELECT,
						'options'     => $countries_list,
						'description' => esc_html__( 'Choose countries for which you like to display items.','dtdr-lite'),
						'default' => ''
					) );

				$this->end_controls_section();

			}
		}

		$this->start_controls_section( 'listings_listing_filter_section', array(
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

			$this->add_control( 'contracttypes_ids', array(
				'label'   => sprintf( esc_html__('%1$s %2$s','dtdr-lite'), $listing_singular_label, $contracttype_plural_label ),
				'type'    => Controls_Manager::TEXT,
				'description' => sprintf( esc_html__('Enter %1$s ids separated by commas','dtdr-lite'), $contracttype_plural_label ),
				'default' => ''
			) );

			$this->add_control( 'tag_ids', array(
				'label'   => sprintf( esc_html__('%1$s %2$s','dtdr-lite'), $listing_singular_label, $amenity_plural_label ),
				'type'    => Controls_Manager::TEXT,
				'description' => sprintf( esc_html__('Enter %1$s ids separated by commas','dtdr-lite'), $amenity_plural_label ),
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


		$this->start_controls_section( 'listings_listing_carousel_section', array(
			'label' => esc_html__( 'Carousel Options','dtdr-lite'),
		) );

			$this->add_control( 'enable_carousel', array(
				'label'       => esc_html__( 'Enable Carousel','dtdr-lite'),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'false' => esc_html__('False','dtdr-lite'),
					'true'  => esc_html__('True','dtdr-lite'),
				),
				'description' => esc_html__( 'If you wish you can enable carousel for your item listings. Carousel won\'t work along with "Isotope" & "Equal Height" option.','dtdr-lite'),
				'condition'   => array( 'apply_isotope' => 'false' ),
				'default'      => 'false'
			) );

			$this->add_control( 'carousel_effect', array(
				'label'       => esc_html__( 'Effect','dtdr-lite'),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'' => esc_html__('Default','dtdr-lite'),
					'fade'  => esc_html__('Fade','dtdr-lite'),
				),
				'description' => esc_html__( 'Choose effect for your carousel. Slides Per View has to be 1 for Fade effect.','dtdr-lite'),
				'condition'   => array( 'enable_carousel' => 'true' ),
				'default'      => ''
			) );

			$this->add_control( 'carousel_autoplay', array(
				'label'   => esc_html__( 'Auto Play','dtdr-lite'),
				'type'    => Controls_Manager::TEXT,
				'description' => esc_html__( 'Delay between transitions ( in ms ). Leave empty if you don\'t want to auto play.','dtdr-lite'),
				'condition'   => array( 'enable_carousel' => 'true' ),
				'default' => ''
			) );

			$this->add_control( 'carousel_slidesperview', array(
				'label'       => esc_html__( 'Slides Per View','dtdr-lite'),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					1 => 1,
					2 => 2,
					3 => 3,
					4 => 4,
				),
				'description' => sprintf( esc_html__('%1$s 1) Number slides of to show in view port. %2$s %1$s 2) 2,3,4 options not applicable for "type 3", "type 5", "type 7" and "type9". %2$s %1$s 3) If "Sidebar Widget" is set to "True", than "Slides Per View" will be set to "1". %2$s','dtdr-lite'), '<p>', '</p>' ),
				'condition'   => array( 'enable_carousel' => 'true' ),
				'default'      => 2
			) );

			$this->add_control( 'carousel_loopmode', array(
				'label'       => esc_html__( 'Enable Loop Mode','dtdr-lite'),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'false' => esc_html__('False','dtdr-lite'),
					'true'  => esc_html__('True','dtdr-lite'),
				),
				'description' => esc_html__( 'If you wish you can enable continous loop mode for your carousel.','dtdr-lite'),
				'condition'   => array( 'enable_carousel' => 'true' ),
				'default'      => 'false'
			) );

			$this->add_control( 'carousel_mousewheelcontrol', array(
				'label'       => esc_html__( 'Enable Mousewheel Control','dtdr-lite'),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'false' => esc_html__('False','dtdr-lite'),
					'true'  => esc_html__('True','dtdr-lite'),
				),
				'description' => esc_html__( 'If you wish you can enable mouse wheel control for your carousel.','dtdr-lite'),
				'condition'   => array( 'enable_carousel' => 'true' ),
				'default'      => 'false'
			) );

			$this->add_control( 'carousel_bulletpagination', array(
				'label'       => esc_html__('Enable Bullet Pagination','dtdr-lite'),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'false' => esc_html__('False','dtdr-lite'),
					'true'  => esc_html__('True','dtdr-lite'),
				),
				'description' => esc_html__( 'To enable bullet pagination.','dtdr-lite'),
				'condition'   => array( 'enable_carousel' => 'true' ),
				'default'      => 'false'
			) );

			$this->add_control( 'carousel_arrowpagination', array(
				'label'       => esc_html__( 'Enable Arrow Pagination','dtdr-lite'),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'false' => esc_html__('False','dtdr-lite'),
					'true'  => esc_html__('True','dtdr-lite'),
				),
				'description' => esc_html__( 'To enable arrow pagination.','dtdr-lite'),
				'condition'   => array( 'enable_carousel' => 'true' ),
				'default'      => 'false'
			) );

			$this->add_control( 'carousel_spacebetween', array(
				'label'   => esc_html__( 'Space Between Sliders','dtdr-lite'),
				'type'    => Controls_Manager::TEXT,
				'description' => esc_html__( 'Space between sliders can be given here.','dtdr-lite'),
				'condition'   => array( 'enable_carousel' => 'true' ),
				'default' => 30
			) );

		$this->end_controls_section();

	}

	protected function render() {

		$settings = $this->get_settings();
		$attributes = dtdirectorylite_elementor_instance()->dtdr_parse_shortcode_attrs( $settings );
		echo do_shortcode('[dtdr_listings_listing '.$attributes.' /]');
	}

}