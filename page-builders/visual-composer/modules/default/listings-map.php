<?php
add_action( 'vc_before_init', 'dtdr_listings_map_vc_map' );

function dtdr_listings_map_vc_map() {

	$listing_singular_label = apply_filters( 'listing_label', 'singular' );
	$listing_plural_label = apply_filters( 'listing_label', 'plural' );
	$contracttype_plural_label = apply_filters( 'contracttype_label', 'plural' );
	$seller_singular_label = apply_filters( 'seller_label', 'singular' );
	$incharge_singular_label = apply_filters( 'incharge_label', 'singular' );

	$countries_list = dtdr_countries_list(false);
	$countries_list = array_flip($countries_list);

	$countries_list = array(esc_html__('All','dtdr-lite') => '') + $countries_list;

	vc_map( array(
		"name" => sprintf( esc_html__('%1$s Map','dtdr-lite'), $listing_plural_label ),
		"base" => "dtdr_listings_map",
		"icon" => "dtdr_listings_map",
		"category" => DTDR_PB_MODULE_DEFAULT_TITLE,
		"params" => array_merge (

						array(

							// Type
							array(
								'type' => 'dropdown',
								'heading' => esc_html__('Type','dtdr-lite'),
								'param_name' => 'type',
								'value' => array(
									esc_html__( 'Type 1','dtdr-lite') => 'type1',
									esc_html__( 'Type 2','dtdr-lite') => 'type2',
									esc_html__( 'Type 3','dtdr-lite') => 'type3'
								),
								'description' => esc_html__('Choose type of layout you like to display.','dtdr-lite'),
								'edit_field_class' => 'vc_column vc_col-sm-6',
							),

							// Additional Info
							array (
								'type' => 'dropdown',
								'heading' => esc_html__('Additional Info','dtdr-lite'),
								'param_name' => 'additional_info',
								'value' => array(
									esc_html__('None','dtdr-lite') => '',
									esc_html__('Total Views','dtdr-lite') => 'totalviews',
									esc_html__('Average Ratings','dtdr-lite') => 'averageratings',
									esc_html__('Category Image','dtdr-lite') => 'categoryimage',
									esc_html__('Category Icon','dtdr-lite') => 'categoryicon'
								),
								'description' => esc_html__( 'Choose additional info that you like to display along with location marker.','dtdr-lite'),
								'std' => '',
								'edit_field_class' => 'vc_column vc_col-sm-6',
								'admin_label' => true
							),

							// Background Color
				      		array(
				      			'type' => 'colorpicker',
				      			'heading' => esc_html__( 'Background Color','dtdr-lite'),
				      			'param_name' => 'category_background_color',
								'dependency' => array( 'element' => 'additional_info', 'value' => array ('categoryimage', 'categoryicon') ),
				      			'description' => esc_html__( 'Select background color for your Category Icon. Icon will be taken from the category settings.','dtdr-lite'),
				      			'edit_field_class' => 'vc_column vc_col-sm-6',
				      		),

							// Color
				      		array(
				      			'type' => 'colorpicker',
				      			'heading' => esc_html__( 'Color','dtdr-lite'),
				      			'param_name' => 'category_color',
								'dependency' => array( 'element' => 'additional_info', 'value' => array ('categoryimage', 'categoryicon') ),
				      			'description' => esc_html__( 'Select icon color for your Category Image / Icon. Image / Icon will be taken from the category settings.','dtdr-lite'),
				      			'edit_field_class' => 'vc_column vc_col-sm-6',
				      		),

							// Zoom Level
							array(
								'type' => 'textfield',
								'heading' => esc_html__( 'Zoom Level','dtdr-lite'),
								'param_name' => 'zoom_level',
								'description' => esc_html__( 'Add map zoom level here. This will overwrite the default map zoom level. Ex: ... 9, 10, 11...','dtdr-lite'),
								'edit_field_class' => 'vc_column vc_col-sm-6',
							),

							// Map Type
							array (
								'type' => 'dropdown',
								'heading' => esc_html__('Map Type','dtdr-lite'),
								'param_name' => 'map_type',
								'value' => array(
									esc_html__('Default','dtdr-lite') => '',
									esc_html__('SATELLITE','dtdr-lite') => 'SATELLITE',
									esc_html__('HYBRID','dtdr-lite') => 'HYBRID',
									esc_html__('TERRAIN','dtdr-lite') => 'TERRAIN',
									esc_html__('ROADMAP','dtdr-lite') => 'ROADMAP',
								),
								'description' => esc_html__( 'Choose map type for this item.','dtdr-lite'),
								'edit_field_class' => 'vc_column vc_col-sm-6',
							),

							// Map Color
				      		array(
				      			'type' => 'colorpicker',
				      			'heading' => esc_html__( 'Map Color','dtdr-lite'),
				      			'param_name' => 'map_color',
				      			'description' => esc_html__( 'Select color for your map. This will override the default map color.','dtdr-lite'),
				      			'edit_field_class' => 'vc_column vc_col-sm-6',
				      		),

							// Class
							array (
								'type' => 'textfield',
								'heading' => esc_html__( 'Class','dtdr-lite'),
								'param_name' => 'class',
								'description' => esc_html__( 'If you wish you can add additional class name here.','dtdr-lite'),
							),


							// Filter Options

							// Listing Item Ids
							array(
								'type' => 'textfield',
								'heading' => sprintf( esc_html__('%1$s Item Ids','dtdr-lite'), $listing_singular_label ),
								'param_name' => 'list_item_ids',
								'value' => '',
								'description' => sprintf( esc_html__( 'Enter %1$s item ids separated by commas.','dtdr-lite'), $listing_singular_label ),
								'edit_field_class' => 'vc_column vc_col-sm-6',
								'group' => 'Filters',
								'std' => ''
							),

							// Category Ids
							array(
								'type' => 'textfield',
								'heading' => sprintf( esc_html__('%1$s Category Ids','dtdr-lite'), $listing_singular_label ),
								'param_name' => 'category_ids',
								'value' => '',
								'description' => esc_html__( 'Enter category ids separated by comma.','dtdr-lite'),
								'edit_field_class' => 'vc_column vc_col-sm-6',
								'group' => 'Filters',
								'std' => ''
							),

							// Cities Ids
							array(
								'type' => 'textfield',
								'heading' => sprintf( esc_html__('%1$s Cities Ids','dtdr-lite'), $listing_singular_label ),
								'param_name' => 'cities_ids',
								'value' => '',
								'description' => esc_html__( 'Enter cities ids separated by comma.','dtdr-lite'),
								'edit_field_class' => 'vc_column vc_col-sm-6',
								'group' => 'Filters',
								'std' => ''
							),

							// Neighborhoods Ids
							array(
								'type' => 'textfield',
								'heading' => sprintf( esc_html__('%1$s Neighborhoods Ids','dtdr-lite'), $listing_singular_label ),
								'param_name' => 'neighborhoods_ids',
								'value' => '',
								'description' => esc_html__( 'Enter neighborhoods ids separated by commas.','dtdr-lite'),
								'edit_field_class' => 'vc_column vc_col-sm-6',
								'group' => 'Filters',
								'std' => ''
							),

							// Counties / States Ids
							array(
								'type' => 'textfield',
								'heading' => sprintf( esc_html__('%1$s Counties / States Ids','dtdr-lite'), $listing_singular_label ),
								'param_name' => 'countiesstates_ids',
								'value' => '',
								'description' => esc_html__( 'Enter countiesstates ids separated by commas.','dtdr-lite'),
								'edit_field_class' => 'vc_column vc_col-sm-6',
								'group' => 'Filters',
								'std' => ''
							),

							// Contract Types Ids
							array(
								'type' => 'textfield',
								'heading' => sprintf( esc_html__('%1$s %2$s','dtdr-lite'), $listing_singular_label, $contracttype_plural_label ),
								'param_name' => 'contracttypes_ids',
								'value' => '',
								'description' => esc_html__( 'Enter contract types ids separated by commas.','dtdr-lite'),
								'edit_field_class' => 'vc_column vc_col-sm-6',
								'group' => 'Filters',
								'std' => ''
							),

							// Tag Ids
							array(
								'type' => 'textfield',
								'heading' => sprintf( esc_html__('%1$s Tag Ids','dtdr-lite'), $listing_singular_label ),
								'param_name' => 'tag_ids',
								'value' => '',
								'description' => esc_html__( 'Enter tag ids separated by comma.','dtdr-lite'),
								'edit_field_class' => 'vc_column vc_col-sm-6',
								'group' => 'Filters',
								'std' => ''
							),

							// Countries
							array(
								'type' => 'dropdown',
								'heading' => esc_html__('Countries','dtdr-lite'),
								'param_name' => 'country_id',
								'value' => $countries_list,
								'description' => esc_html__( 'Choose countries for which you like to display items.','dtdr-lite'),
								'edit_field_class' => 'vc_column vc_col-sm-6',
								'group' => 'Filters',
								'std' => ''
							),

							// Seller Ids
							array(
								'type' => 'textfield',
								'heading' => sprintf( esc_html__('%1$s %2$s Ids','dtdr-lite'), $listing_singular_label, $seller_singular_label ),
								'param_name' => 'seller_ids',
								'value' => '',
								'description' => sprintf( esc_html__('Enter %1$s ids separated by commas.','dtdr-lite'), strtolower($seller_singular_label) ),
								'edit_field_class' => 'vc_column vc_col-sm-6',
								'group' => 'Filters',
								'std' => ''
							),

							// Incharge Ids
							array(
								'type' => 'textfield',
								'heading' => sprintf( esc_html__('%1$s %2$s Ids','dtdr-lite'), $listing_singular_label, $incharge_singular_label ),
								'param_name' => 'incharge_ids',
								'value' => '',
								'description' => esc_html__( 'Enter incharge ids separated by commas.','dtdr-lite'),
								'edit_field_class' => 'vc_column vc_col-sm-6',
								'group' => 'Filters',
								'std' => ''
							),

						)

					)


	) );
}
?>