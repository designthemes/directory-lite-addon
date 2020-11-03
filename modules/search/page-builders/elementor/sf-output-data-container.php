<?php

namespace DTElementor\Widgets;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;

class DTDirectoryLiteSfOutputDataContainer extends Widget_Base {

	public function get_categories() {
		return [ 'dtdr-searchform-widgets' ];
	}

	public function get_name() {
		return 'dtdr-widget-sf-output-data-container';
	}

	public function get_title() {
		return esc_html__( 'Output Data Container','dtdr-lite');
	}

	public function get_style_depends() {
		return array ( 'dtdr-fields', 'dtdr-search-frontend');
	}

	public function get_script_depends() {
		return array ( 'dtdr-search-frontend');
	}

	public function dtdr_dynamic_register_controls() {

	}

	protected function _register_controls() {

		$listing_singular_label = apply_filters( 'listing_label', 'singular' );

		$this->start_controls_section( 'output_data_container_default_section', array(
			'label' => esc_html__( 'General','dtdr-lite'),
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
					'type7' => esc_html__('Type 7','dtdr-lite'),
					'type8' => esc_html__('Type 8','dtdr-lite'),
					'type9' => esc_html__('Type 9','dtdr-lite'),
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
                'default' => -1
            ) );

            $this->add_control( 'columns', array(
                'label'       => esc_html__( 'Columns','dtdr-lite'),
                'type'        => Controls_Manager::SELECT,
                'options'     => array(
                    1  => esc_html__('I Column','dtdr-lite'),
					2  => esc_html__('II Columns','dtdr-lite'),
					3  => esc_html__('III Columns','dtdr-lite')
                ),
				'description' => esc_html__( 'Number of columns you like to display your items.','dtdr-lite'),
				'condition'   => array( 'type' => array( 'type1', 'type2', 'type4', 'type6', 'type8') ),
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
                'default'      => 'false'
            ) );

			$this->add_control( 'excerpt_length', array(
				'label'   => esc_html__( 'Excerpt Length','dtdr-lite'),
				'type'    => Controls_Manager::TEXT,
				'description' => esc_html__( 'Provide excerpt length here.','dtdr-lite'),
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
				'default'      => '',
			) );

			$this->add_control( 'features_include', array(
				'label'       => esc_html__( 'Features Include','dtdr-lite'),
				'type'        => Controls_Manager::TEXT,
				'description' => esc_html__('Give features id separated by comma. Only 4 maximum number of features allowed.','dtdr-lite'),
				'default'      => '',
			) );

			$this->add_control( 'no_of_cat_to_display', array(
				'label'       => esc_html__( 'No. Of Categories to Display','dtdr-lite'),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
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

		$this->start_controls_section( 'output_data_container_filter_section', array(
			'label' => esc_html__( 'Filter Options','dtdr-lite'),
		) );

			$this->add_control( 'category_ids', array(
				'label'   => sprintf( esc_html__('%1$s Category Ids','dtdr-lite'), $listing_singular_label ),
				'type'    => Controls_Manager::TEXT,
				'description' => sprintf( esc_html__( 'Enter %1$s category ids separated by commas.','dtdr-lite'), $listing_singular_label ),
				'default' => ''
			) );

		$this->end_controls_section();

	}

	protected function render() {

		$settings   = $this->get_settings();
		$attributes = dtdirectorylite_elementor_instance()->dtdr_parse_shortcode_attrs( $settings );
		$output     = do_shortcode('[dtdr_sf_output_data_container '.$attributes.' /]');

		echo $output;

	}

}