<?php
add_action( 'vc_before_init', 'dtdr_sp_contact_details_vc_map' );

function dtdr_sp_contact_details_vc_map() {

	$listing_singular_label = apply_filters( 'listing_label', 'singular' );
	$seller_singular_label = apply_filters( 'seller_label', 'singular' );

	vc_map( array(
		"name" => esc_html__( 'Contact Details','dtdr-lite'),
		"base" => "dtdr_sp_contact_details",
		"icon" => "dtdr_sp_contact_details",
		"category" => DTDR_PB_MODULE_SINGLEPAGE_TITLE,
		"params" => array(

			// Listing Id
			array(
				'type' => 'textfield',
				'heading' => sprintf( esc_html__('%1$s Id','dtdr-lite'), $listing_singular_label ),
				'param_name' => 'listing_id',
				'description' => sprintf( esc_html__('Provide %1$s id for which you have to display contact details. No need to provide ID if it is used in %1$s single page.','dtdr-lite'), strtolower($listing_singular_label) ),
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
					esc_html__('Type 2','dtdr-lite') => 'type2'
				),
				'description' => esc_html__( 'Choose any of the available type.','dtdr-lite'),
				'edit_field_class' => 'vc_column vc_col-sm-6',
				'admin_label' => true,
				'std' => 'type1'
			),

			// Contact Details
			array(
				'type' => 'dropdown',
				'heading' => esc_html__('Contact Details','dtdr-lite'),
				'description' => esc_html__('Contact details that you like to display.','dtdr-lite'),
				'param_name' => 'contact_details',
				'value' => array(
					sprintf( esc_html__('%1$s','dtdr-lite'), $listing_singular_label ) => 'list',
					esc_html__( 'Author','dtdr-lite') => 'author',
				),
				'std' => 'list',
				'edit_field_class' => 'vc_column vc_col-sm-6'
			),

			// Include Address
			array(
				'type' => 'dropdown',
				'heading' => esc_html__('Include Address','dtdr-lite'),
				'description' => esc_html__('Choose "True" if you like to show address in this shortcode.','dtdr-lite'),
				'param_name' => 'include_address',
				'value' => array(
					esc_html__( 'False','dtdr-lite') => 'false',
					esc_html__( 'True','dtdr-lite') => 'true',
				),
				'edit_field_class' => 'vc_column vc_col-sm-6'
			),

			// Include Email
			array(
				'type' => 'dropdown',
				'heading' => esc_html__('Include Email','dtdr-lite'),
				'description' => esc_html__('Choose "True" if you like to show email id in this shortcode.','dtdr-lite'),
				'param_name' => 'include_email',
				'value' => array(
					esc_html__( 'False','dtdr-lite') => 'false',
					esc_html__( 'True','dtdr-lite') => 'true',
				),
				'edit_field_class' => 'vc_column vc_col-sm-6'
			),

			// Include Phone
			array(
				'type' => 'dropdown',
				'heading' => esc_html__('Include Phone','dtdr-lite'),
				'description' => esc_html__('Choose "True" if you like to show phone in this shortcode.','dtdr-lite'),
				'param_name' => 'include_phone',
				'value' => array(
					esc_html__( 'False','dtdr-lite') => 'false',
					esc_html__( 'True','dtdr-lite') => 'true',
				),
				'edit_field_class' => 'vc_column vc_col-sm-6'
			),

			// Include Mobile
			array(
				'type' => 'dropdown',
				'heading' => esc_html__('Include Mobile','dtdr-lite'),
				'description' => esc_html__('Choose "True" if you like to show mobile in this shortcode.','dtdr-lite'),
				'param_name' => 'include_mobile',
				'value' => array(
					esc_html__( 'False','dtdr-lite') => 'false',
					esc_html__( 'True','dtdr-lite') => 'true',
				),
				'edit_field_class' => 'vc_column vc_col-sm-6'
			),

			// Include Skype
			array(
				'type' => 'dropdown',
				'heading' => esc_html__('Include Skype','dtdr-lite'),
				'description' => esc_html__('Choose "True" if you like to show skype in this shortcode.','dtdr-lite'),
				'param_name' => 'include_skype',
				'value' => array(
					esc_html__( 'False','dtdr-lite') => 'false',
					esc_html__( 'True','dtdr-lite') => 'true',
				),
				'edit_field_class' => 'vc_column vc_col-sm-6'
			),

			// Include Website
			array(
				'type' => 'dropdown',
				'heading' => esc_html__('Include Website','dtdr-lite'),
				'description' => esc_html__('Choose "True" if you like to show website in this shortcode.','dtdr-lite'),
				'param_name' => 'include_website',
				'value' => array(
					esc_html__( 'False','dtdr-lite') => 'false',
					esc_html__( 'True','dtdr-lite') => 'true',
				),
				'edit_field_class' => 'vc_column vc_col-sm-6'
			),


			// Show Direction Link
			array(
				'type' => 'dropdown',
				'heading' => esc_html__('Show Direction Link','dtdr-lite'),
				'description' => esc_html__('Choose "True" if you like to show direction link along with address.','dtdr-lite'),
				'param_name' => 'show_direction_link',
				'value' => array(
					esc_html__( 'False','dtdr-lite') => 'false',
					esc_html__( 'True','dtdr-lite') => 'true',
				),
				'edit_field_class' => 'vc_column vc_col-sm-6'
			),

			// Requires Buyer Packages
			array(
				'type' => 'dropdown',
				'heading' => esc_html__('Requires Buyer Packages','dtdr-lite'),
				'description' => esc_html__('Choose "True" if it required to have buyer package. Contact details will be displayed only when buyer purchased the packages.','dtdr-lite'),
				'param_name' => 'requires_buyer_packages',
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