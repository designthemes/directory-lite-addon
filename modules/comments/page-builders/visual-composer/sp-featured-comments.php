<?php
add_action( 'vc_before_init', 'dtdr_sp_featured_comments_vc_map' );

function dtdr_sp_featured_comments_vc_map() {

	vc_map( array(
		"name" => esc_html__( 'Comments - Featured','dtdr-lite'),
		"base" => "dtdr_sp_featured_comments",
		"icon" => "dtdr_sp_featured_comments",
		"category" => DTDR_PB_MODULE_SINGLEPAGE_TITLE,
		"params" => array(

			// Enable Title
			array(
				'type' => 'dropdown',
				'heading' => esc_html__('Enable Title','dtdr-lite'),
				'param_name' => 'enable_title',
				'value' => array(
							esc_html__('False','dtdr-lite') => 'false',
							esc_html__('True','dtdr-lite') => 'true',
						),
				'edit_field_class' => 'vc_column vc_col-sm-6',
				'std' => 'false'
			),

			// Enable Rating
			array(
				'type' => 'dropdown',
				'heading' => esc_html__('Enable Rating','dtdr-lite'),
				'param_name' => 'enable_rating',
				'value' => array(
							esc_html__('False','dtdr-lite') => 'false',
							esc_html__('True','dtdr-lite') => 'true',
						),
				'edit_field_class' => 'vc_column vc_col-sm-6',
				'std' => 'false'
			),

			// Enable Media
			array(
				'type' => 'dropdown',
				'heading' => esc_html__('Enable Media','dtdr-lite'),
				'param_name' => 'enable_media',
				'value' => array(
							esc_html__('False','dtdr-lite') => 'false',
							esc_html__('True','dtdr-lite') => 'true',
						),
				'edit_field_class' => 'vc_column vc_col-sm-6',
				'std' => 'false'
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