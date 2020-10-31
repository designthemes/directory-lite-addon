<?php
add_action( 'vc_before_init', 'dtdr_sp_social_links_vc_map' );

function dtdr_sp_social_links_vc_map() {

	$listing_singular_label = apply_filters( 'listing_label', 'singular' );
	$seller_singular_label = apply_filters( 'seller_label', 'singular' );

	vc_map( array(
		"name" => esc_html__( 'Social Links','dtdr-lite'),
		"base" => "dtdr_sp_social_links",
		"icon" => "dtdr_sp_social_links",
		"category" => DTDR_PB_MODULE_SINGLEPAGE_TITLE,
		"params" => array(

			// Listing Id
			array(
				'type' => 'textfield',
				'heading' => sprintf( esc_html__('%1$s Id','dtdr-lite'), $listing_singular_label ),
				'param_name' => 'listing_id',
				'description' => sprintf( esc_html__('Provide %1$s id for which you have to display social links. No need to provide ID if it is used in %1$s single page.','dtdr-lite'), strtolower($listing_singular_label) ),
				'edit_field_class' => 'vc_column vc_col-sm-6',
				'admin_label' => true
			),

			// Social Links
			array(
				'type' => 'dropdown',
				'heading' => esc_html__('Social Links','dtdr-lite'),
				'description' => esc_html__('Social Links that you like to display.','dtdr-lite'),
				'param_name' => 'social_links',
				'value' => array(
					sprintf( esc_html__('%1$s','dtdr-lite'), $listing_singular_label ) => 'list',
					sprintf( esc_html__('%1$s','dtdr-lite'), $seller_singular_label ) => 'seller',
				),
				'std' => 'list',
				'edit_field_class' => 'vc_column vc_col-sm-6'
			),

			// Type
			array(
				'type' => 'dropdown',
				'heading' => esc_html__('Type','dtdr-lite'),
				'param_name' => 'type',
				'value' => array(
					esc_html__('Default','dtdr-lite') => '',
					esc_html__('Type 1','dtdr-lite') => 'type1',
					esc_html__('Type 2','dtdr-lite') => 'type2',
					esc_html__('Type 3','dtdr-lite') => 'type3',
					esc_html__('Type 4','dtdr-lite') => 'type4',
					esc_html__('Type 5','dtdr-lite') => 'type5',
					esc_html__('Type 6','dtdr-lite') => 'type6',
					esc_html__('Type 7','dtdr-lite') => 'type7',
					esc_html__('Type 8','dtdr-lite') => 'type8'
				),
				'description' => esc_html__( 'Choose any of the available type.','dtdr-lite'),
				'edit_field_class' => 'vc_column vc_col-sm-6',
				'admin_label' => true,
				'std' => ''
			),

			// Class
			array(
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