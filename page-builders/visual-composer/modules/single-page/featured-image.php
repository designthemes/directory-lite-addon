<?php 
add_action( 'vc_before_init', 'dtdr_sp_featured_image_vc_map' );

function dtdr_sp_featured_image_vc_map() {

	$listing_singular_label = apply_filters( 'listing_label', 'singular' );

	vc_map( array(
		"name" => esc_html__( 'Featured Image','dtdr-lite'),
		"base" => "dtdr_sp_featured_image",
		"icon" => "dtdr_sp_featured_image",
		"category" => DTDR_PB_MODULE_SINGLEPAGE_TITLE,
		"params" => array(

			// Listing Id
			array(
				'type' => 'textfield',
				'heading' => sprintf( esc_html__('%1$s Id','dtdr-lite'), $listing_singular_label ),
				'param_name' => 'listing_id',
				'description' => sprintf( esc_html__('Provide %1$s id for which you have to display featured image. No need to provide ID if it is used in %1$s single page.','dtdr-lite'), strtolower($listing_singular_label) ),
				'edit_field_class' => 'vc_column vc_col-sm-6',
				'admin_label' => true
			),

			// Thumbnail Sizes
			array(
				'type' => 'dropdown',
				'heading' => esc_html__('Thumbnail Sizes','dtdr-lite'),
				'param_name' => 'image_size',
				'value' => array(
					esc_html__('Thumbnail','dtdr-lite') => 'thumbnail',
					esc_html__('Medium','dtdr-lite') => 'medium',
					esc_html__('Medium Large','dtdr-lite') => 'medium_large',
					esc_html__('Large','dtdr-lite') => 'large',
					esc_html__('Full','dtdr-lite') => 'full',
				),
				'description' => esc_html__( 'Choose any of the above image sizes.','dtdr-lite'),
				'std' => 'full',
				'edit_field_class' => 'vc_column vc_col-sm-6',
				'admin_label' => true
			),

			// Class
			array (
				'type' => 'textfield',
				'heading' => esc_html__( 'Class','dtdr-lite'),
				'param_name' => 'class',
				'description' => esc_html__( 'If you wish you can add additional class name here.','dtdr-lite'),	
				'edit_field_class' => 'vc_column vc_col-sm-6'			
			)

		)
	) );
}
?>