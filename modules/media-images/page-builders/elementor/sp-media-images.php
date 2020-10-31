<?php

namespace DTElementor\Widgets;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;

class DTDirectoryLiteSpMediaImages extends Widget_Base {

	public function get_categories() {
		return [ 'dtdr-singlepage-widgets' ];
	}

	public function get_name() {
		return 'dtdr-widget-sp-media-images';
	}

	public function get_title() {
		return esc_html__( 'Media - Images','dtdr-lite');
	}

	public function get_style_depends() {
		return array ('dtdr-media-images-frontend');
	}

	public function get_script_depends() {
		return array ('dtdr-media-images-frontend');
	}

	protected function _register_controls() {

		$listing_singular_label = apply_filters( 'listing_label', 'singular' );

		$this->start_controls_section( 'media_images_default_section', array(
			'label' => esc_html__( 'General','dtdr-lite'),
		) );

			$this->add_control( 'listing_id', array(
				'label'       => sprintf( esc_html__('%1$s Id','dtdr-lite'), $listing_singular_label ),
				'type'        => Controls_Manager::TEXT,
				'description' => sprintf( esc_html__('Provide %1$s id to display your item. No need to provide ID if it is used in %1$s single page.','dtdr-lite'), strtolower($listing_singular_label) ),
				'default'     => ''
			) );

			$this->add_control( 'image_size', array(
				'label'       => esc_html__( 'Thumbnail Sizes','dtdr-lite'),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'thumbnail'    => esc_html__('Thumbnail','dtdr-lite'),
					'medium'       => esc_html__('Medium','dtdr-lite'),
					'medium_large' => esc_html__('Medium Large','dtdr-lite'),
					'large'        => esc_html__('Large','dtdr-lite'),
					'full'         => esc_html__('Full','dtdr-lite'),
				),
				'description' => esc_html__( 'Choose any of the above image sizes.','dtdr-lite'),
				'default'      => 'full',
			) );

			$this->add_control( 'show_image_description', array(
				'label'       => esc_html__( 'Show Image Description','dtdr-lite'),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'false' => esc_html__('False','dtdr-lite'),
					'true'  => esc_html__('True','dtdr-lite'),
				),
				'description' => esc_html__('Choose "True" if you like to show image description in carousel.','dtdr-lite'),
				'default'      => 'false'
			) );

			$this->add_control( 'include_featured_image', array(
				'label'       => esc_html__( 'Include Feature Image','dtdr-lite'),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'false' => esc_html__('False','dtdr-lite'),
					'true'  => esc_html__('True','dtdr-lite'),
				),
				'description' => esc_html__('Choose "True" if you like to include featured image in this gallery.','dtdr-lite'),
				'default'      => 'false'
			) );

			$this->add_control( 'class', array(
				'label'   => esc_html__( 'Class','dtdr-lite'),
				'type'    => Controls_Manager::TEXT,
				'description' => esc_html__( 'If you wish you can add additional class name here.','dtdr-lite'),
				'default' => ''
			) );

		$this->end_controls_section();


		$this->start_controls_section( 'media_images_carousel_section', array(
			'label' => esc_html__( 'Carousel Options','dtdr-lite'),
		) );

			$this->add_control( 'carousel_effect', array(
				'label'       => esc_html__( 'Effect','dtdr-lite'),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'' => esc_html__('Default','dtdr-lite'),
					'fade'  => esc_html__('Fade','dtdr-lite'),
				),
				'description' => esc_html__( 'Choose effect for your carousel. Slides Per View has to be 1 for Fade effect.','dtdr-lite'),
				'default'      => ''
			) );

			$this->add_control( 'carousel_autoplay', array(
				'label'   => esc_html__( 'Auto Play','dtdr-lite'),
				'type'    => Controls_Manager::TEXT,
				'description' => esc_html__( 'Delay between transitions ( in ms ). Leave empty if you don\'t want to auto play.','dtdr-lite'),
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
				'description' => esc_html__( 'Number slides of to show in view port.','dtdr-lite'),
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
				'default'      => 'false'
			) );

			$this->add_control( 'carousel_verticaldirection', array(
				'label'       => esc_html__('Enable Vertical Direction','dtdr-lite'),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'false' => esc_html__('False','dtdr-lite'),
					'true'  => esc_html__('True','dtdr-lite'),
				),
				'description' => esc_html__( 'To make your slides to navigate vertically.','dtdr-lite'),
				'default'      => 'false'
			) );

			$this->add_control( 'carousel_paginationtype', array(
				'label'       => esc_html__( 'Pagination Type','dtdr-lite'),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					''            => esc_html__('None','dtdr-lite'),
					'bullets'     => esc_html__('Bullets','dtdr-lite'),
					'fraction'    => esc_html__('Fraction','dtdr-lite'),
					'progressbar' => esc_html__('Progress Bar','dtdr-lite'),
					'scrollbar'   => esc_html__('Scroll Bar','dtdr-lite'),
					'thumbnail'   => esc_html__('Thumbnail','dtdr-lite')
				),
				'description' => esc_html__( 'Choose pagination type you like to use.','dtdr-lite'),
				'default'      => ''
			) );

			$this->add_control( 'carousel_numberofthumbnails', array(
				'label'       => esc_html__('Number of Thumbnails','dtdr-lite'),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					3 => 3,
					4 => 4,
					5 => 5,
					6 => 6,
				),
				'description' => esc_html__( 'Number of thumbnails to show.','dtdr-lite'),
				'condition'   => array( 'carousel_paginationtype' => 'thumbnail' ),
				'default'      => 3
			) );

			$this->add_control( 'carousel_arrowpagination', array(
				'label'       => esc_html__( 'Enable Arrow Pagination','dtdr-lite'),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'false' => esc_html__('False','dtdr-lite'),
					'true'  => esc_html__('True','dtdr-lite'),
				),
				'description' => esc_html__( 'To enable arrow pagination.','dtdr-lite'),
				'default'      => 'false'
			) );

			$this->add_control( 'carousel_arrowpagination_type', array(
				'label'       => esc_html__( 'Arrow Type','dtdr-lite'),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'type1' => esc_html__('Type 1','dtdr-lite'),
					'type2' => esc_html__('Type 2','dtdr-lite'),
				),
				'description' => esc_html__( 'Choose arrow pagination type for your carousel.','dtdr-lite'),
				'default'      => 'type1'
			) );

			$this->add_control( 'carousel_spacebetween', array(
				'label'   => esc_html__( 'Space Between Sliders','dtdr-lite'),
				'type'    => Controls_Manager::TEXT,
				'description' => esc_html__( 'Space between sliders can be given here.','dtdr-lite'),
				'default' => ''
			) );

		$this->end_controls_section();

	}

	protected function render() {

		$settings = $this->get_settings();
		$attributes = dtdirectorylite_elementor_instance()->dtdr_parse_shortcode_attrs( $settings );
		$output = do_shortcode('[dtdr_sp_media_images '.$attributes.' /]');

		echo $output;

	}

}