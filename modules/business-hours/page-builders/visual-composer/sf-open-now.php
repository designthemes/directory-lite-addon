<?php
add_action( 'vc_before_init', 'dtdr_sf_open_now_field_vc_map' );

function dtdr_sf_open_now_field_vc_map() {

	vc_map( array(
		"name" => esc_html__( 'Open Now','dtdr-lite'),
		"base" => "dtdr_sf_open_now",
		"icon" => "dtdr_sf_open_now",
		"category" => DTDR_PB_MODULE_SEARCHFORM_TITLE,
		"params" => array(

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
			),

			// Class
			array(
				'type' => 'textfield',
				'heading' => esc_html__( 'Class','dtdr-lite'),
				'param_name' => 'class',
				'description' => esc_html__( 'If you wish you can add additional class name here.','dtdr-lite'),
			),

		)

	) );

}
?>