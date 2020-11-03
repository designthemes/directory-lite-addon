<?php
add_action( 'vc_before_init', 'dtdr_sf_price_range_field_vc_map' );

function dtdr_sf_price_range_field_vc_map() {

	$listing_singular_label = apply_filters( 'listing_label', 'singular' );

	vc_map( array(
		"name"     => esc_html__( 'Price Range','dtdr-lite'),
		"base"     => "dtdr_sf_price_range_field",
		"icon"     => "dtdr_sf_price_range_field",
		"category" => DTDR_PB_MODULE_SEARCHFORM_TITLE,
		"params"   => array(

			// Minimum Price
			array(
				'type'             => 'textfield',
				'heading'          => esc_html__( 'Minimum Price','dtdr-lite'),
				'param_name'       => 'min_price',
				'description'      => esc_html__( 'Set minimum price range.','dtdr-lite'),
				'edit_field_class' => 'vc_column vc_col-sm-6',
				'value'            => 1,
			),

			// Maximum Price
			array(
				'type'             => 'textfield',
				'heading'          => esc_html__( 'Maximum Price','dtdr-lite'),
				'param_name'       => 'max_price',
				'description'      => esc_html__( 'Set maximum price range.','dtdr-lite'),
				'edit_field_class' => 'vc_column vc_col-sm-6',
				'value'            => 100
			),

			// Ajax Load
			array(
				'type'        => 'dropdown',
				'heading'     => esc_html__('Ajax Load','dtdr-lite'),
				'description' => esc_html__('If you want to display the output in same page choose "True" here.','dtdr-lite'),
				'param_name'  => 'ajax_load',
				'value'       => array(
					esc_html__( 'False','dtdr-lite') => 'false',
					esc_html__( 'True','dtdr-lite')  => 'true',
				),
				'edit_field_class' => 'vc_column vc_col-sm-6'
			),

			// Class
			array(
				'type'        => 'textfield',
				'heading'     => esc_html__( 'Class','dtdr-lite'),
				'param_name'  => 'class',
				'description' => esc_html__( 'If you wish you can add additional class name here.','dtdr-lite'),
			),

		)
	) );
}
?>