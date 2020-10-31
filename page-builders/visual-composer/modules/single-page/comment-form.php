<?php 
add_action( 'vc_before_init', 'dtdr_sp_comment_form_vc_map' );

function dtdr_sp_comment_form_vc_map() {

	$listing_singular_label = apply_filters( 'listing_label', 'singular' );

	vc_map( array(
		"name" => esc_html__( 'Comment Form','dtdr-lite'),
		"base" => "dtdr_sp_comment_form",
		"icon" => "dtdr_sp_comment_form",
		"category" => DTDR_PB_MODULE_SINGLEPAGE_TITLE,
		"params" => array(

			// Form Title
			array(
				'type' => 'textfield',
				'heading' => esc_html__( 'Form Title','dtdr-lite'),
				'param_name' => 'form_title',
				'description' => esc_html__( 'If you wish you can provide form title here.','dtdr-lite'),
				'edit_field_class' => 'vc_column vc_col-sm-6'
			),

			// Form Comment Field Placeholder
			array(
				'type' => 'textfield',
				'heading' => esc_html__( 'Form Comment Field Placeholder','dtdr-lite'),
				'param_name' => 'form_comment_field_placeholder',
				'description' => esc_html__( 'If you wish you can provide form comment field placeholder here.','dtdr-lite'),
				'edit_field_class' => 'vc_column vc_col-sm-6'
			),

			// Form Submit Button Label
			array(
				'type' => 'textfield',
				'heading' => esc_html__( 'Form Submit Button Label','dtdr-lite'),
				'param_name' => 'form_submit_button_label',
				'description' => esc_html__( 'If you wish you can provide form submit button label here.','dtdr-lite'),
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