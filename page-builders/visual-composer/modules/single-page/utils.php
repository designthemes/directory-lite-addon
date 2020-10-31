<?php
add_action( 'vc_before_init', 'dtdr_sp_utils_vc_map' );

function dtdr_sp_utils_vc_map() {

	$listing_singular_label      = apply_filters( 'listing_label', 'singular' );
	$contracttype_singular_label = apply_filters( 'contracttype_label', 'singular' );
	$seller_singular_label       = apply_filters( 'seller_label', 'singular' );
	$amenity_singular_label      = apply_filters( 'amenity_label', 'singular' );

	vc_map( array(
		"name" => esc_html__( 'Utils','dtdr-lite'),
		"base" => "dtdr_sp_utils",
		"icon" => "dtdr_sp_utils",
		"category" => DTDR_PB_MODULE_SINGLEPAGE_TITLE,
		"params" => array(

			// Listing Id
			array(
				'type' => 'textfield',
				'heading' => sprintf( esc_html__('%1$s Id','dtdr-lite'), $listing_singular_label ),
				'param_name' => 'listing_id',
				'description' => sprintf( esc_html__('Provide %1$s id for which you have to display favourites, share,... No need to provide ID if it is used in %1$s single page.','dtdr-lite'), strtolower($listing_singular_label) ),
				'admin_label' => true
			),

			// Show Title
			array(
				'type' => 'dropdown',
				'heading' => esc_html__('Show Title','dtdr-lite'),
				'description' => esc_html__('Choose "True" if you like to show title.','dtdr-lite'),
				'param_name' => 'show_title',
				'value' => array(
					esc_html__( 'False','dtdr-lite') => 'false',
					esc_html__( 'True','dtdr-lite') => 'true',
				),
				'edit_field_class' => 'vc_column vc_col-sm-6',
			),

			// Show Favourite
			array(
				'type' => 'dropdown',
				'heading' => esc_html__('Show Favourite','dtdr-lite'),
				'description' => esc_html__('Choose "True" if you like to show favourite option.','dtdr-lite'),
				'param_name' => 'show_favourite',
				'value' => array(
					esc_html__( 'False','dtdr-lite') => 'false',
					esc_html__( 'True','dtdr-lite') => 'true',
				),
				'edit_field_class' => 'vc_column vc_col-sm-6',
			),

			// Show Page View
			array(
				'type' => 'dropdown',
				'heading' => esc_html__('Show Page View','dtdr-lite'),
				'description' => esc_html__('Choose "True" if you like to show page view.','dtdr-lite'),
				'param_name' => 'show_pageview',
				'value' => array(
					esc_html__( 'False','dtdr-lite') => 'false',
					esc_html__( 'True','dtdr-lite') => 'true',
				),
				'edit_field_class' => 'vc_column vc_col-sm-6',
			),

			// Show Print
			array(
				'type' => 'dropdown',
				'heading' => esc_html__('Show Print','dtdr-lite'),
				'description' => esc_html__('Choose "True" if you like to show print option.','dtdr-lite'),
				'param_name' => 'show_print',
				'value' => array(
					esc_html__( 'False','dtdr-lite') => 'false',
					esc_html__( 'True','dtdr-lite') => 'true',
				),
				'edit_field_class' => 'vc_column vc_col-sm-6',
			),

			// Show Social Share
			array(
				'type' => 'dropdown',
				'heading' => esc_html__('Show Social Share','dtdr-lite'),
				'description' => esc_html__('Choose "True" if you like to show social share option.','dtdr-lite'),
				'param_name' => 'show_socialshare',
				'value' => array(
					esc_html__( 'False','dtdr-lite') => 'false',
					esc_html__( 'True','dtdr-lite') => 'true',
				),
				'edit_field_class' => 'vc_column vc_col-sm-6',
			),

			// Show Average Rating
			array(
				'type' => 'dropdown',
				'heading' => esc_html__('Show Average Rating','dtdr-lite'),
				'description' => esc_html__('Choose "True" if you like to show average rating.','dtdr-lite'),
				'param_name' => 'show_averagerating',
				'value' => array(
					esc_html__( 'False','dtdr-lite') => 'false',
					esc_html__( 'True','dtdr-lite') => 'true',
				),
				'edit_field_class' => 'vc_column vc_col-sm-6',
			),

			// Show Featured Item
			array(
				'type' => 'dropdown',
				'heading' => esc_html__('Show Featured Item','dtdr-lite'),
				'description' => esc_html__('Choose "True" if you like to show featured item.','dtdr-lite'),
				'param_name' => 'show_featured',
				'value' => array(
					esc_html__( 'False','dtdr-lite') => 'false',
					esc_html__( 'True','dtdr-lite') => 'true',
				),
				'edit_field_class' => 'vc_column vc_col-sm-6',
			),

			// Show Categories
			array(
				'type' => 'dropdown',
				'heading' => esc_html__('Show Categories','dtdr-lite'),
				'description' => esc_html__('Choose "True" if you like to show categories.','dtdr-lite'),
				'param_name' => 'show_categories',
				'value' => array(
					esc_html__( 'False','dtdr-lite') => 'false',
					esc_html__( 'True','dtdr-lite') => 'true',
				),
				'edit_field_class' => 'vc_column vc_col-sm-6',
			),

			// Show Cities
			array(
				'type' => 'dropdown',
				'heading' => esc_html__('Show Cities','dtdr-lite'),
				'description' => esc_html__('Choose "True" if you like to show cities.','dtdr-lite'),
				'param_name' => 'show_cities',
				'value' => array(
					esc_html__( 'False','dtdr-lite') => 'false',
					esc_html__( 'True','dtdr-lite') => 'true',
				),
				'edit_field_class' => 'vc_column vc_col-sm-6',
			),

			// Show Neighborhoods
			array(
				'type' => 'dropdown',
				'heading' => esc_html__('Show Neighborhoods','dtdr-lite'),
				'description' => esc_html__('Choose "True" if you like to show neighborhoods.','dtdr-lite'),
				'param_name' => 'show_neighborhoods',
				'value' => array(
					esc_html__( 'False','dtdr-lite') => 'false',
					esc_html__( 'True','dtdr-lite') => 'true',
				),
				'edit_field_class' => 'vc_column vc_col-sm-6',
			),

			// Show County / State
			array(
				'type' => 'dropdown',
				'heading' => esc_html__('Show County / State','dtdr-lite'),
				'description' => esc_html__('Choose "True" if you like to show county / state.','dtdr-lite'),
				'param_name' => 'show_countystate',
				'value' => array(
					esc_html__( 'False','dtdr-lite') => 'false',
					esc_html__( 'True','dtdr-lite') => 'true',
				),
				'edit_field_class' => 'vc_column vc_col-sm-6',
			),

			// Show Contract Type
			array(
				'type' => 'dropdown',
				'heading' => sprintf( esc_html__('Show %1$s','dtdr-lite'), $contracttype_singular_label ),
				'description' =>sprintf( esc_html__('Choose "True" if you like to show %1$s','dtdr-lite'), strtolower($contracttype_singular_label) ),
				'param_name' => 'show_contracttype',
				'value' => array(
					esc_html__( 'False','dtdr-lite') => 'false',
					esc_html__( 'True','dtdr-lite') => 'true',
				),
				'edit_field_class' => 'vc_column vc_col-sm-6',
			),

			// Show Amenity
			array(
				'type' => 'dropdown',
				'heading' => sprintf( esc_html__('Show %1$s','dtdr-lite'), $amenity_singular_label ),
				'description' =>sprintf( esc_html__('Choose "True" if you like to show %1$s','dtdr-lite'), strtolower($amenity_singular_label) ),
				'param_name' => 'show_amenity',
				'value' => array(
					esc_html__( 'False','dtdr-lite') => 'false',
					esc_html__( 'True','dtdr-lite') => 'true',
				),
				'edit_field_class' => 'vc_column vc_col-sm-6',
			),

			// Show Price
			array(
				'type' => 'dropdown',
				'heading' => esc_html__('Show Price','dtdr-lite'),
				'description' => esc_html__('Choose "True" if you like to show price.','dtdr-lite'),
				'param_name' => 'show_price',
				'value' => array(
					esc_html__( 'False','dtdr-lite') => 'false',
					esc_html__( 'True','dtdr-lite') => 'true',
				),
				'edit_field_class' => 'vc_column vc_col-sm-6',
			),

			// Show Address
			array(
				'type' => 'dropdown',
				'heading' => esc_html__('Show Address','dtdr-lite'),
				'description' => esc_html__('Choose "True" if you like to show address.','dtdr-lite'),
				'param_name' => 'show_address',
				'value' => array(
					esc_html__( 'False','dtdr-lite') => 'false',
					esc_html__( 'True','dtdr-lite') => 'true',
				),
				'edit_field_class' => 'vc_column vc_col-sm-6',
			),

			// Show Contact Details
			array(
				'type' => 'dropdown',
				'heading' => esc_html__('Show Contact Details','dtdr-lite'),
				'description' => esc_html__('Contact details that you like to display.','dtdr-lite'),
				'param_name' => 'show_contactdetails',
				'value' => array(
					esc_html__( 'None','dtdr-lite') => '',
					sprintf( esc_html__('%1$s','dtdr-lite'), $listing_singular_label ) => 'list',
					sprintf( esc_html__('%1$s','dtdr-lite'), $seller_singular_label ) => 'seller',
				),
				'edit_field_class' => 'vc_column vc_col-sm-6',
			),

			// Show Contact Details - On Request
			array(
				'type' => 'dropdown',
				'heading' => esc_html__('Show Contact Details - On Request','dtdr-lite'),
				'description' => esc_html__('Choose "True" if you like to show contact details on request.','dtdr-lite'),
				'param_name' => 'show_contactdetails_onrequest',
				'value' => array(
					esc_html__( 'False','dtdr-lite') => 'false',
					esc_html__( 'True','dtdr-lite') => 'true',
				),
				'edit_field_class' => 'vc_column vc_col-sm-6',
			),

			// Show Start Date
			array(
				'type' => 'dropdown',
				'heading' => esc_html__('Show Start Date','dtdr-lite'),
				'description' => esc_html__('Choose "True" if you like to show start date.','dtdr-lite'),
				'param_name' => 'show_startdate',
				'value' => array(
					esc_html__( 'False','dtdr-lite') => 'false',
					esc_html__( 'True','dtdr-lite') => 'true',
				),
				'edit_field_class' => 'vc_column vc_col-sm-6',
			),

			// Show End Date
			array(
				'type' => 'dropdown',
				'heading' => esc_html__('Show End Date','dtdr-lite'),
				'description' => esc_html__('Choose "True" if you like to show end date.','dtdr-lite'),
				'param_name' => 'show_enddate',
				'value' => array(
					esc_html__( 'False','dtdr-lite') => 'false',
					esc_html__( 'True','dtdr-lite') => 'true',
				),
				'edit_field_class' => 'vc_column vc_col-sm-6',
			),

			// Show Posted Date
			array(
				'type' => 'dropdown',
				'heading' => esc_html__('Show Posted Date','dtdr-lite'),
				'description' => esc_html__('Choose "True" if you like to show posted date.','dtdr-lite'),
				'param_name' => 'show_posteddate',
				'value' => array(
					esc_html__( 'False','dtdr-lite') => 'false',
					esc_html__( 'True','dtdr-lite') => 'true',
				),
				'edit_field_class' => 'vc_column vc_col-sm-6',
			),

			// Show Merged Date
			array(
				'type' => 'dropdown',
				'heading' => esc_html__('Show Merged Dates','dtdr-lite'),
				'description' => esc_html__('Choose "True" if you like to show merged date.','dtdr-lite'),
				'param_name' => 'show_mergeddates',
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
			),

		)
	) );
}
?>