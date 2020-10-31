<?php
add_action( 'vc_before_init', 'dtdr_sp_features_vc_map' );

function dtdr_sp_features_vc_map() {

	$listing_singular_label = apply_filters( 'listing_label', 'singular' );

	vc_map( array(
		"name" => esc_html__( 'Features','dtdr-lite'),
		"base" => "dtdr_sp_features",
		"icon" => "dtdr_sp_features",
		"category" => DTDR_PB_MODULE_SINGLEPAGE_TITLE,
		"params" => array(

			// Listing Id
			array(
				'type' => 'textfield',
				'heading' => sprintf( esc_html__('%1$s Id','dtdr-lite'), $listing_singular_label ),
				'param_name' => 'listing_id',
				'description' => sprintf( esc_html__('Provide %1$s id for which you have to display features. No need to provide ID if it is used in %1$s single page.','dtdr-lite'), strtolower($listing_singular_label) ),
				'edit_field_class' => 'vc_column vc_col-sm-6',
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
					esc_html__('Type 4','dtdr-lite') => 'type4',
					esc_html__('Type 5','dtdr-lite') => 'type5',
					esc_html__('Type 6','dtdr-lite') => 'type6',
					esc_html__('Type 7','dtdr-lite') => 'type7'
				),
				'description' => esc_html__( 'Choose any of the available type.','dtdr-lite'),
				'edit_field_class' => 'vc_column vc_col-sm-6',
				'admin_label' => true,
				'std' => 'type1'
			),

			// Include
			array(
				'type' => 'textfield',
				'heading' => esc_html__( 'Include','dtdr-lite'),
				'param_name' => 'include',
				'description' => esc_html__( 'If you like, you can include only certain items. Leave empty if you like to display all.','dtdr-lite'),
				'edit_field_class' => 'vc_column vc_col-sm-6'
			),

			// Columns
			array(
				'type' => 'dropdown',
				'heading' => esc_html__('Columns','dtdr-lite'),
				'param_name' => 'columns',
				'value' => array(
							esc_html__('No Column','dtdr-lite') => -1,
							esc_html__('I Column','dtdr-lite') => 1,
							esc_html__('II Columns','dtdr-lite') => 2,
							esc_html__('III Columns','dtdr-lite') => 3,
							esc_html__('IV Columns','dtdr-lite') => 4,
						),
				'description' => esc_html__( 'Number of columns you like to display your features.','dtdr-lite'),
				'edit_field_class' => 'vc_column vc_col-sm-6',
				'std' => 4
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