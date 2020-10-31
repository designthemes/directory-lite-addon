<?php
add_action( 'vc_before_init', 'dtdr_sp_post_date_vc_map' );

function dtdr_sp_post_date_vc_map() {

	$listing_singular_label = apply_filters( 'listing_label', 'singular' );

	vc_map( array(
		"name" => esc_html__( 'Post Date','dtdr-lite'),
		"base" => "dtdr_sp_post_date",
		"icon" => "dtdr_sp_post_date",
		"category" => DTDR_PB_MODULE_SINGLEPAGE_TITLE,
		"params" => array(

			// Listing Id
			array(
				'type' => 'textfield',
				'heading' => sprintf( esc_html__('%1$s Id','dtdr-lite'), $listing_singular_label ),
				'param_name' => 'listing_id',
				'description' => sprintf( esc_html__('Provide %1$s id for which you have to display dates. No need to provide ID if it is used in %1$s single page.','dtdr-lite'), strtolower($listing_singular_label) ),
				'admin_label' => true
			),

			// Type
			array(
				'type' => 'dropdown',
				'heading' => esc_html__('Type','dtdr-lite'),
				'param_name' => 'type',
				'value' => array(
					esc_html__('Type 1','dtdr-lite') => 'type1',
					esc_html__('Type 2','dtdr-lite') => 'type2',
					esc_html__('Type 3','dtdr-lite') => 'type3',
					esc_html__('Type 4','dtdr-lite') => 'type4'
				),
				'description' => esc_html__( 'Choose any of the available type.','dtdr-lite'),
				'edit_field_class' => 'vc_column vc_col-sm-6',
				'admin_label' => true,
				'admintype_label' => 'type1'
			),

			// Include Post Time
			array(
				'type' => 'dropdown',
				'heading' => esc_html__('Include Post Time','dtdr-lite'),
				'description' => esc_html__('Choose "True" if you like to display post time along with date.','dtdr-lite'),
				'param_name' => 'include_posttime',
				'value' => array(
					esc_html__( 'False','dtdr-lite') => 'false',
					esc_html__( 'True','dtdr-lite') => 'true',
				),
				'edit_field_class' => 'vc_column vc_col-sm-6',
			),

			// With Label
			array(
				'type' => 'dropdown',
				'heading' => esc_html__('With Label','dtdr-lite'),
				'description' => esc_html__('Choose "True" if you like to display label along with date.','dtdr-lite'),
				'param_name' => 'with_label',
				'value' => array(
					esc_html__( 'False','dtdr-lite') => 'false',
					esc_html__( 'True','dtdr-lite') => 'true',
				),
				'edit_field_class' => 'vc_column vc_col-sm-6',
			),

			// With Icon
			array(
				'type' => 'dropdown',
				'heading' => esc_html__('With Icon','dtdr-lite'),
				'description' => esc_html__('Choose "True" if you like to display icon along with date.','dtdr-lite'),
				'param_name' => 'with_icon',
				'value' => array(
					esc_html__( 'False','dtdr-lite') => 'false',
					esc_html__( 'True','dtdr-lite') => 'true',
				),
				'edit_field_class' => 'vc_column vc_col-sm-6',
			),

			// Class
			array(
				'type' => 'textfield',
				'heading' => esc_html__( 'Class','dtdr-lite'),
				'param_name' => 'class',
				'description' => esc_html__( 'If you wish you can add additional class name here.','dtdr-lite'),
				'edit_field_class' => 'vc_column vc_col-sm-6',
			),

		)
	) );
}
?>