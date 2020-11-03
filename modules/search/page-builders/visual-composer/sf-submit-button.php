<?php 
add_action( 'vc_before_init', 'dtdr_sf_submit_button_vc_map' );

function dtdr_sf_submit_button_vc_map() {

	$listing_singular_label = apply_filters( 'listing_label', 'singular' );

	vc_map( array(
		"name"     => esc_html__( 'Submit Button','dtdr-lite'),
		"base"     => "dtdr_sf_submit_button",
		"icon"     => "dtdr_sf_submit_button",
		"category" => DTDR_PB_MODULE_SEARCHFORM_TITLE,
		"params"   => array(

			// Output Type
			array(
				'type' => 'dropdown',
				'heading' => esc_html__('Output Type','dtdr-lite'),
				'param_name' => 'output_type',
				'value' => array(
					esc_html__('Same Page - Ajax Load','dtdr-lite') => '',
					esc_html__('Separate Page','dtdr-lite') => 'separate-page',
				),
				'description' => esc_html__( 'Choose how you like to display search output.','dtdr-lite'),
				'std' => '',
				'edit_field_class' => 'vc_column vc_col-sm-6',
				'admin_label' => true			
			),		

			// Separate Page URL
			array(
				'type'             => 'textfield',
				'heading'          => esc_html__( 'Separate Page URL','dtdr-lite'),
				'param_name'       => 'separate_page_url',
				'description'      => esc_html__( 'Separate page url in which search content have to displayed. You have to create that page with search form shortcode.','dtdr-lite'),
				'dependency'       => array( 'element' => 'output_type', 'value' => 'separate-page'),
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

		)
	) );
}
?>