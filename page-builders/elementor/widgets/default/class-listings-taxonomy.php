<?php

namespace DTElementor\Widgets;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;

class DTDirectoryLiteDfListingsTaxonomy extends Widget_Base {

	public function get_categories() {
		return [ 'dtdr-default-widgets' ];
	}

	public function get_name() {
		return 'dtdr-widget-df-listings-taxonomy';
	}

	public function get_title() {
		$listing_plural_label = apply_filters( 'listing_label', 'plural' );
		return sprintf( esc_html__('%1$s Taxonomy','dtdr-lite'), $listing_plural_label );
	}

	public function get_style_depends() {
		return array ( 'dtdr-modules-default' );
	}

	public function get_script_depends() {
		return array ( 'dtdr-frontend' );
	}

	protected function _register_controls() {

		$listing_singular_label      = apply_filters( 'listing_label', 'singular' );
		$listing_plural_label        = apply_filters( 'listing_label', 'plural' );

		$taxonomies = apply_filters( 'dtdr_taxonomies', array () );

		$this->start_controls_section( 'listings_taxonomy_default_section', array(
			'label' => esc_html__( 'General','dtdr-lite'),
		) );

			$this->add_control( 'taxonomy', array(
				'label'       => esc_html__( 'Taxonomy','dtdr-lite'),
				'type'        => Controls_Manager::SELECT,
				'options'     => $taxonomies,
				'description' => esc_html__( 'Choose type of taxonomy you would like to display.','dtdr-lite'),
				'default'      => 'dtdr_listings_category',
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
				'description' => esc_html__( 'Choose type of taxonomy to display.','dtdr-lite'),
				'default'      => 'type1',
			) );

			$this->add_control( 'media_type', array(
				'label'       => esc_html__( 'Media Type','dtdr-lite'),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'image'      => esc_html__('Image','dtdr-lite'),
					'icon'       => esc_html__('Icon','dtdr-lite'),
					'icon_image' => esc_html__('Icon Image','dtdr-lite')
				),
				'description' => esc_html__( 'Choose whether to display image or icon.','dtdr-lite'),
				'condition'   => array( 'type' => array ('type1', 'type2', 'type3', 'type4') ),
				'default'      => 'image',
			) );

			$this->add_control( 'columns', array(
				'label'       => esc_html__( 'Columns','dtdr-lite'),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					''  => esc_html__('None','dtdr-lite'),
					1  => esc_html__('I Column','dtdr-lite'),
					2  => esc_html__('II Columns','dtdr-lite'),
					3  => esc_html__('III Columns','dtdr-lite')
				),
				'description' => esc_html__( 'Number of columns you like to display your taxonomies.','dtdr-lite'),
				'default'      => '',
			) );

			$this->add_control( 'include', array(
				'label'   => esc_html__( 'Include','dtdr-lite'),
				'type'    => Controls_Manager::TEXT,
				'description' => esc_html__( 'List of taxonomy ids separated by commas.','dtdr-lite'),
				'default' => ''
			) );

			$this->add_control( 'show_parent_items_alone', array(
				'label'       => esc_html__( 'Show Parent Items Alone','dtdr-lite'),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'false' => esc_html__('False','dtdr-lite'),
					'true'  => esc_html__('True','dtdr-lite'),
				),
				'description' => esc_html__( 'If you like to show parent items alone choose "True".','dtdr-lite'),
				'default'      => 'false'
			) );

			$this->add_control( 'child_of', array(
				'label'   => esc_html__( 'Child Of','dtdr-lite'),
				'type'    => Controls_Manager::TEXT,
				'description' => esc_html__( 'If you like to show child of any parent item, provide id of your taxonomy here.','dtdr-lite'),
				'condition'   => array( 'show_parent_items_alone' =>'false' ),
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

		$settings = $this->get_settings();
		$attributes = dtdirectorylite_elementor_instance()->dtdr_parse_shortcode_attrs( $settings );
		$output = do_shortcode('[dtdr_listings_taxonomy '.$attributes.' /]');

		echo $output;

	}

}