<?php 
add_action( 'vc_before_init', 'dtdr_login_logout_links_vc_map' );

function dtdr_login_logout_links_vc_map() {
	vc_map( array(
		"name" => esc_html__( 'Login / Logout Links','dtdr-lite'),
		"base" => "dtdr_login_logout_links",
		"icon" => "dtdr_login_logout_links",
		"category" => DTDR_PB_MODULE_DEFAULT_TITLE,
		"params" => array(

			// Class
			array(
				'type' => 'textfield',
				'heading' => esc_html__( 'Class','dtdr-lite'),
				'param_name' => 'class',
				'description' => esc_html__( 'If you wish you can add additional class name here.','dtdr-lite'),
				'admin_label' => true
			),

		)
	) );
}
?>