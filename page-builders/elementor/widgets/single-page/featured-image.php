<?php

namespace DTElementor\Widgets;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;

class DTDirectoryLiteSpFeaturedImage extends Widget_Base {

	public function get_categories() {
		return [ 'dtdr-singlepage-widgets' ];
	}

	public function get_name() {
		return 'dtdr-widget-sp-featured-image';
	}

	public function get_title() {
		return esc_html__( 'Featured Image','dtdr-lite');
	}

	public function get_style_depends() {
		return array ( 'dtdr-modules-singlepage' );
	}

	public function get_script_depends() {
		return array ( 'dtdr-modules-singlepage' );
	}

	protected function _register_controls() {

		$listing_singular_label = apply_filters( 'listing_label', 'singular' );

		$this->start_controls_section( 'featured_image_default_section', array(
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
		echo do_shortcode('[dtdr_sp_featured_image '.$attributes.' /]');
	}

}