<?php
add_action( 'vc_before_init', 'dtdr_sf_orderby_field_vc_map' );

function dtdr_sf_orderby_field_vc_map() {

	$listing_singular_label = apply_filters( 'listing_label', 'singular' );

	vc_map( array(
		"name" => esc_html__( 'Order By','dtdr-lite'),
		"base" => "dtdr_sf_orderby_field",
		"icon" => "dtdr_sf_orderby_field",
		"category" => DTDR_PB_MODULE_SEARCHFORM_TITLE,
		"params" => array(

			// Field Type
			array(
				'type' => 'dropdown',
				'heading' => esc_html__('Field Type','dtdr-lite'),
				'param_name' => 'field_type',
				'value' => array(
					esc_html__('List','dtdr-lite') => '',
					esc_html__('Dropdown','dtdr-lite') => 'dropdown',
				),
				'description' => esc_html__( 'Choose type of field you like to use.','dtdr-lite'),
				'std' => '',
				'edit_field_class' => 'vc_column vc_col-sm-6',
				'admin_label' => true
			),

			// Placeholder Text
			array(
				'type' => 'textfield',
				'heading' => esc_html__( 'Placeholder Text','dtdr-lite'),
				'param_name' => 'placeholder_text',
				'description' => esc_html__( 'You can provide your own text for placeholder of this item.','dtdr-lite'),
				'dependency' => array( 'element' => 'field_type', 'value' => 'dropdown'),
				'edit_field_class' => 'vc_column vc_col-sm-6'
			),

			// Alphabetical Order
			array(
				'type' => 'dropdown',
				'heading' => esc_html__('Alphabetical Order','dtdr-lite'),
				'description' => esc_html__('Choose "True" if you like to enable alphabetical order.','dtdr-lite'),
				'param_name' => 'alphabetical_order',
				'value' => array(
					esc_html__( 'False','dtdr-lite') => 'false',
					esc_html__( 'True','dtdr-lite') => 'true',
				),
				'std' => 'true',
				'edit_field_class' => 'vc_column vc_col-sm-6',
			),

			// Highest Rated Order
			array(
				'type' => 'dropdown',
				'heading' => esc_html__('Highest Rated Order','dtdr-lite'),
				'description' => esc_html__('Choose "True" if you like to enable highest rated order.','dtdr-lite'),
				'param_name' => 'highestrated_order',
				'value' => array(
					esc_html__( 'False','dtdr-lite') => 'false',
					esc_html__( 'True','dtdr-lite') => 'true',
				),
				'std' => 'true',
				'edit_field_class' => 'vc_column vc_col-sm-6',
			),

			// Most Reviewed Order
			array(
				'type' => 'dropdown',
				'heading' => esc_html__('Most Reviewed Order','dtdr-lite'),
				'description' => esc_html__('Choose "True" if you like to enable most reviewed order.','dtdr-lite'),
				'param_name' => 'mostreviewed_order',
				'value' => array(
					esc_html__( 'False','dtdr-lite') => 'false',
					esc_html__( 'True','dtdr-lite') => 'true',
				),
				'std' => 'true',
				'edit_field_class' => 'vc_column vc_col-sm-6',
			),

			// Most Viewed Order
			array(
				'type' => 'dropdown',
				'heading' => esc_html__('Most Viewed Order','dtdr-lite'),
				'description' => esc_html__('Choose "True" if you like to enable most viewed order.','dtdr-lite'),
				'param_name' => 'mostviewed_order',
				'value' => array(
					esc_html__( 'False','dtdr-lite') => 'false',
					esc_html__( 'True','dtdr-lite') => 'true',
				),
				'std' => 'true',
				'edit_field_class' => 'vc_column vc_col-sm-6',
			),

			// Ajax Load
			array(
				'type' => 'dropdown',
				'heading' => esc_html__('Ajax Load','dtdr-lite'),
				'description' => esc_html__('If you want to display the output in same page choose "True" here.','dtdr-lite'),
				'param_name' => 'ajax_load',
				'value' => array(
					esc_html__( 'False','dtdr-lite') => 'false',
					esc_html__( 'True','dtdr-lite') => 'true',
				),
				'edit_field_class' => 'vc_column vc_col-sm-6'
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