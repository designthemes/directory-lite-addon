<?php
add_action( 'vc_before_init', 'dtdr_sp_media_images_vc_map' );

function dtdr_sp_media_images_vc_map() {

	$listing_singular_label = apply_filters( 'listing_label', 'singular' );

	vc_map( array(
		"name"     => esc_html__( 'Media - Images','dtdr-lite'),
		"base"     => "dtdr_sp_media_images",
		"icon"     => "dtdr_sp_media_images",
		"category" => DTDR_PB_MODULE_SINGLEPAGE_TITLE,
		"params"   => array(

			// Listing Id
			array(
				'type'             => 'textfield',
				'heading'          => sprintf( esc_html__('%1$s Id','dtdr-lite'), $listing_singular_label ),
				'param_name'       => 'listing_id',
				'description'      => sprintf( esc_html__('Provide %1$s id for which you have to display featured image. No need to provide ID if it is used in %1$s single page.','dtdr-lite'), strtolower($listing_singular_label) ),
				'edit_field_class' => 'vc_column vc_col-sm-6',
				'admin_label'      => true
			),

			// Thumbnail Sizes
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__('Thumbnail Sizes','dtdr-lite'),
				'param_name' => 'image_size',
				'value'      => array(
					esc_html__('Thumbnail','dtdr-lite')    => 'thumbnail',
					esc_html__('Medium','dtdr-lite')       => 'medium',
					esc_html__('Medium Large','dtdr-lite') => 'medium_large',
					esc_html__('Large','dtdr-lite')        => 'large',
					esc_html__('Full','dtdr-lite')         => 'full',
				),
				'description'      => esc_html__( 'Choose any of the above image sizes.','dtdr-lite'),
				'std'              => 'full',
				'edit_field_class' => 'vc_column vc_col-sm-6',
				'admin_label'      => true
			),

			// Show Image Description
			array(
				'type'        => 'dropdown',
				'heading'     => esc_html__('Show Image Description','dtdr-lite'),
				'description' => esc_html__('Choose "True" if you like to show image description in carousel.','dtdr-lite'),
				'param_name'  => 'show_image_description',
				'value'       => array(
					esc_html__( 'False','dtdr-lite') => 'false',
					esc_html__( 'True','dtdr-lite')  => 'true',
				),
				'edit_field_class' => 'vc_column vc_col-sm-6'
			),

			// Include Feature Image
			array(
				'type'        => 'dropdown',
				'heading'     => esc_html__('Include Feature Image','dtdr-lite'),
				'description' => esc_html__('Choose "True" if you like to include featured image in this gallery.','dtdr-lite'),
				'param_name'  => 'include_featured_image',
				'value'       => array(
					esc_html__( 'False','dtdr-lite') => 'false',
					esc_html__( 'True','dtdr-lite')  => 'true',
				),
				'edit_field_class' => 'vc_column vc_col-sm-6'
			),

			// Class
			array(
				'type'             => 'textfield',
				'heading'          => esc_html__( 'Class','dtdr-lite'),
				'param_name'       => 'class',
				'description'      => esc_html__( 'If you wish you can add additional class name here.','dtdr-lite'),
				'edit_field_class' => 'vc_column vc_col-sm-6'
			),

			/* Carousel Tab */

			// Effect
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__('Effect','dtdr-lite'),
				'param_name' => 'carousel_effect',
				'value'      => array(
					esc_html__('Default','dtdr-lite') => '',
					esc_html__('Fade','dtdr-lite')    => 'fade',
				),
				'description'      => esc_html__( 'Choose effect for your carousel. Slides Per View has to be 1 for Fade effect.','dtdr-lite'),
				'edit_field_class' => 'vc_column vc_col-sm-6',
				'group'            => 'Carousel',
				'std'              => ''
			),

			// Auto Play
			array(
				'type'             => 'textfield',
				'heading'          => esc_html__('Auto Play','dtdr-lite'),
				'param_name'       => 'carousel_autoplay',
				'description'      => esc_html__( 'Delay between transitions ( in ms ). Leave empty if you don\'t want to auto play.','dtdr-lite'),
				'edit_field_class' => 'vc_column vc_col-sm-6',
				'group'            => 'Carousel',
			),

			// Slides Per View
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__('Slides Per View','dtdr-lite'),
				'param_name' => 'carousel_slidesperview',
				'value'      => array(
					1 => 1,
					2 => 2,
					3 => 3,
					4 => 4,
				),
				'description'      => esc_html__( 'Number slides of to show in view port.','dtdr-lite'),
				'edit_field_class' => 'vc_column vc_col-sm-6',
				'group'            => 'Carousel',
				'std'              => ''
			),

			// Enable loop mode
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__('Enable Loop Mode','dtdr-lite'),
				'param_name' => 'carousel_loopmode',
				'value'      => array(
					esc_html__('False','dtdr-lite') => 'false',
					esc_html__('True','dtdr-lite')  => 'true',
				),
				'description'      => esc_html__( 'If you wish you can enable continous loop mode for your carousel.','dtdr-lite'),
				'edit_field_class' => 'vc_column vc_col-sm-6',
				'group'            => 'Carousel',
				'std'              => ''
			),

			// Enable mousewheel control
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__('Enable Mousewheel Control','dtdr-lite'),
				'param_name' => 'carousel_mousewheelcontrol',
				'value'      => array(
					esc_html__('False','dtdr-lite') => 'false',
					esc_html__('True','dtdr-lite')  => 'true',
				),
				'description'      => esc_html__( 'If you wish you can enable mouse wheel control for your carousel.','dtdr-lite'),
				'edit_field_class' => 'vc_column vc_col-sm-6',
				'group'            => 'Carousel',
				'std'              => ''
			),

			// Enable vertical direction
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__('Enable Vertical Direction','dtdr-lite'),
				'param_name' => 'carousel_verticaldirection',
				'value'      => array(
					esc_html__('False','dtdr-lite') => 'false',
					esc_html__('True','dtdr-lite')  => 'true',
				),
				'description'      => esc_html__( 'To make your slides to navigate vertically.','dtdr-lite'),
				'edit_field_class' => 'vc_column vc_col-sm-6',
				'group'            => 'Carousel',
				'std'              => ''
			),

			// Pagination Type
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__('Pagination Type','dtdr-lite'),
				'param_name' => 'carousel_paginationtype',
				'value'      => array(
					esc_html__('None','dtdr-lite')         => '',
					esc_html__('Bullets','dtdr-lite')      => 'bullets',
					esc_html__('Fraction','dtdr-lite')     => 'fraction',
					esc_html__('Progress Bar','dtdr-lite') => 'progressbar',
					esc_html__('Scroll Bar','dtdr-lite')   => 'scrollbar',
					esc_html__('Thumbnail','dtdr-lite')    => 'thumbnail'
				),
				'description'      => esc_html__( 'Choose pagination type you like to use.','dtdr-lite'),
				'edit_field_class' => 'vc_column vc_col-sm-6',
				'group'            => 'Carousel',
				'std'              => ''
			),

			// Number of Thumbnails
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__('Number of Thumbnails','dtdr-lite'),
				'param_name' => 'carousel_numberofthumbnails',
				'value'      => array(
					3 => 3,
					4 => 4,
					5 => 5,
					6 => 6,
				),
				'description'      => esc_html__( 'Number of thumbnails to show.','dtdr-lite'),
				'edit_field_class' => 'vc_column vc_col-sm-6',
				'dependency'       => array( 'element' => 'carousel_paginationtype', 'value' =>'thumbnail' ),
				'group'            => 'Carousel',
				'std'              => 3
			),

			// Enable Arrow Pagination
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__('Enable Arrow Pagination','dtdr-lite'),
				'param_name' => 'carousel_arrowpagination',
				'value'      => array(
					esc_html__('False','dtdr-lite') => 'false',
					esc_html__('True','dtdr-lite')  => 'true',
				),
				'description'      => esc_html__( 'To enable arrow pagination.','dtdr-lite'),
				'edit_field_class' => 'vc_column vc_col-sm-6',
				'group'            => 'Carousel',
				'std'              => ''
			),

			// Arrow Type
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__('Arrow Type','dtdr-lite'),
				'param_name' => 'carousel_arrowpagination_type',
				'value'      => array(
					esc_html__('Type 1','dtdr-lite') => 'type1',
					esc_html__('Type 2','dtdr-lite') => 'type2',
				),
				'description'      => esc_html__( 'Choose arrow pagination type for your carousel.','dtdr-lite'),
				'edit_field_class' => 'vc_column vc_col-sm-6',
				'group'            => 'Carousel',
				'std'              => 'type1'
			),

			// Space Between Sliders
			array(
				'type'             => 'textfield',
				'heading'          => esc_html__('Space Between Sliders','dtdr-lite'),
				'param_name'       => 'carousel_spacebetween',
				'description'      => esc_html__( 'Space between sliders can be given here.','dtdr-lite'),
				'edit_field_class' => 'vc_column vc_col-sm-6',
				'group'            => 'Carousel',
			),

		)
	) );
}
?>