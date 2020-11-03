<?php
add_action( 'vc_before_init', 'dtdr_listings_listing_vc_map' );

function dtdr_listings_listing_vc_map() {

	$listing_singular_label      = apply_filters( 'listing_label', 'singular' );
	$listing_plural_label        = apply_filters( 'listing_label', 'plural' );
	$contracttype_singular_label = apply_filters( 'contracttype_label', 'singular' );
	$contracttype_plural_label   = apply_filters( 'contracttype_label', 'plural' );
	$seller_singular_label       = apply_filters( 'seller_label', 'singular' );
	$incharge_singular_label     = apply_filters( 'incharge_label', 'singular' );
	$amenity_singular_label      = apply_filters( 'amenity_label', 'singular' );
	$amenity_plural_label        = apply_filters( 'amenity_label', 'plural' );


	$dtdr_listings_listing_vc_map_module_args = apply_filters('dtdr_listings_listing_vc_map_module_args', array ());

	// From Location Module

	$dtdr_location_city_args = $dtdr_location_neighborhoods_args = $dtdr_location_countiesstates_args = $dtdr_location_countries_args = array ();
	$dtdr_modules = dtdirectorylite_instance()->active_modules;
	if(is_array($dtdr_modules) && !empty($dtdr_modules)) {
		if(in_array('location', $dtdr_modules)) {

			$countries_list = dtdr_countries_list(false);
			$countries_list = array_flip($countries_list);

			$countries_list = array(esc_html__('All','dtdr-lite') => '') + $countries_list;

			// Cities Ids
			$dtdr_location_city_args = array(
				'type'             => 'textfield',
				'heading'          => sprintf( esc_html__('%1$s Cities Ids','dtdr-lite'), $listing_singular_label ),
				'param_name'       => 'cities_ids',
				'value'            => '',
				'description'      => esc_html__( 'Enter cities ids separated by commas.','dtdr-lite'),
				'edit_field_class' => 'vc_column vc_col-sm-6',
				'group'            => 'Filters - Location',
				'std'              => ''
			);

			// Neighborhoods Ids
			$dtdr_location_neighborhoods_args = array(
				'type'             => 'textfield',
				'heading'          => sprintf( esc_html__('%1$s Neighborhoods Ids','dtdr-lite'), $listing_singular_label ),
				'param_name'       => 'neighborhoods_ids',
				'value'            => '',
				'description'      => esc_html__( 'Enter neighborhoods ids separated by commas.','dtdr-lite'),
				'edit_field_class' => 'vc_column vc_col-sm-6',
				'group'            => 'Filters - Location',
				'std'              => ''
			);

			// Counties / States Ids
			$dtdr_location_countiesstates_args = array(
				'type'             => 'textfield',
				'heading'          => sprintf( esc_html__('%1$s Counties / States Ids','dtdr-lite'), $listing_singular_label ),
				'param_name'       => 'countiesstates_ids',
				'value'            => '',
				'description'      => esc_html__( 'Enter counties / states ids separated by commas.','dtdr-lite'),
				'edit_field_class' => 'vc_column vc_col-sm-6',
				'group'            => 'Filters - Location',
				'std'              => ''
			);

			// Countries
			$dtdr_location_countries_args = array(
				'type'             => 'dropdown',
				'heading'          => esc_html__('Countries','dtdr-lite'),
				'param_name'       => 'country_id',
				'value'            => $countries_list,
				'description'      => esc_html__( 'Choose countries for which you like to display items.','dtdr-lite'),
				'edit_field_class' => 'vc_column vc_col-sm-6',
				'group'            => 'Filters - Location',
				'std'              => ''
			);

		}
	}

	vc_map( array(
		"name"     => sprintf( esc_html__('%1$s Listing','dtdr-lite'), $listing_plural_label ),
		"base"     => "dtdr_listings_listing",
		"icon"     => "dtdr_listings_listing",
		"category" => DTDR_PB_MODULE_DEFAULT_TITLE,
		"params"   => array(

						// Default Options
							// Type
							array(
								'type'       => 'dropdown',
								'heading'    => esc_html__('Type','dtdr-lite'),
								'param_name' => 'type',
								'value'      => array(
									esc_html__( 'Type 1','dtdr-lite')  => 'type1',
									esc_html__( 'Type 2','dtdr-lite')  => 'type2',
									esc_html__( 'Type 3','dtdr-lite')  => 'type3',
									esc_html__( 'Type 4','dtdr-lite')  => 'type4',
									esc_html__( 'Type 5','dtdr-lite')  => 'type5',
									esc_html__( 'Type 6','dtdr-lite')  => 'type6',
									esc_html__( 'Type 7','dtdr-lite')  => 'type7',
									esc_html__( 'Type 8','dtdr-lite')  => 'type8',
									esc_html__( 'Type 9','dtdr-lite')  => 'type9',
									esc_html__( 'Type 10','dtdr-lite') => 'type10'
								),
								'description'      => esc_html__('Choose type of layout you like to display.','dtdr-lite'),
								'edit_field_class' => 'vc_column vc_col-sm-6',
								'std'              => 'type1',
							),

							// Gallery
							array (
								'type'       => 'dropdown',
								'heading'    => esc_html__('Gallery','dtdr-lite'),
								'param_name' => 'gallery',
								'value'      => array(
									esc_html__('Featured Image','dtdr-lite')                    => 'featured_image',
									esc_html__('Image Gallery','dtdr-lite')                     => 'image_gallery',
									esc_html__('Image Gallery With Featured Image','dtdr-lite') => 'gallery_with_featured',
								),
								'description'      => esc_html__( 'Choose how you like to display image gallery.','dtdr-lite'),
								'edit_field_class' => 'vc_column vc_col-sm-6',
								'std'              => 'featured_image',
							),

							// Post Per Page
							array(
								'type'             => 'textfield',
								'heading'          => esc_html__( 'Post Per Page','dtdr-lite'),
								'param_name'       => 'post_per_page',
								'description'      => esc_html__( 'Number of posts to show per page. Rest of the posts will be displayed in pagination.','dtdr-lite'),
								'edit_field_class' => 'vc_column vc_col-sm-6',
							),

							// Columns
							array(
								'type'       => 'dropdown',
								'heading'    => esc_html__('Columns','dtdr-lite'),
								'param_name' => 'columns',
								'value'      => array(
									esc_html__('I Column','dtdr-lite')    => 1,
									esc_html__('II Columns','dtdr-lite')  => 2,
									esc_html__('III Columns','dtdr-lite') => 3,
									esc_html__('IV Columns','dtdr-lite')  => 4
								),
								'description'      => esc_html__( 'Number of columns you like to display your items.','dtdr-lite'),
								'edit_field_class' => 'vc_column vc_col-sm-6',
								'dependency'       => array( 'element' => 'type', 'value' => array( 'type1', 'type2', 'type4', 'type6', 'type8', 'type10')),
								'std'              => 1
							),

							// Apply Isotope
							array(
								'type'       => 'dropdown',
								'heading'    => esc_html__('Apply Isotope','dtdr-lite'),
								'param_name' => 'apply_isotope',
								'value'      => array(
									esc_html__( 'False','dtdr-lite') => 'false',
									esc_html__( 'True','dtdr-lite')  => 'true',
								),
								'std'              => 'true',
								'description'      => esc_html__('Choose true if you like to apply isotope for your items.','dtdr-lite'),
								'edit_field_class' => 'vc_column vc_col-sm-6',
							),

							// Isotope Filter
							array(
								'type'       => 'dropdown',
								'heading'    => esc_html__('Isotope Filter','dtdr-lite'),
								'param_name' => 'isotope_filter',
								'value'      => array(
									esc_html__( 'None','dtdr-lite')                                            => '',
									esc_html__( 'Category','dtdr-lite')                                        => 'category',
									sprintf   ( esc_html__('%1$s','dtdr-lite'), $contracttype_singular_label ) => 'contracttype',
								),
								'std'              => '',
								'description'      => esc_html__('Choose isotope filter you like to use.','dtdr-lite'),
								'dependency'       => array( 'element' => 'apply_isotope', 'value' =>'true' ),
								'edit_field_class' => 'vc_column vc_col-sm-6',
							),

							// Apply Child Of
							array(
								'type'       => 'dropdown',
								'heading'    => esc_html__('Apply Child Of','dtdr-lite'),
								'param_name' => 'apply_child_of',
								'value'      => array(
									esc_html__( 'False','dtdr-lite') => 'false',
									esc_html__( 'True','dtdr-lite')  => 'true',
								),
								'std'              => 'false',
								'description'      => sprintf( esc_html__('If you wish to apply child of specified categories or %1$s in filters, choose "True". If no categories or %1$s specified in "Filter Options" this option won\'t work.','dtdr-lite'), strtolower($contracttype_plural_label) ),
								'dependency'       => array( 'element' => 'apply_isotope', 'value' =>'true' ),
								'edit_field_class' => 'vc_column vc_col-sm-6',
							),

							// Featured Items
							array(
								'type'       => 'dropdown',
								'heading'    => esc_html__('Featured Items','dtdr-lite'),
								'param_name' => 'featured_items',
								'value'      => array(
									esc_html__( 'False','dtdr-lite') => 'false',
									esc_html__( 'True','dtdr-lite')  => 'true',
								),
								'description'      => esc_html__('Choose true if you like to display featured items.','dtdr-lite'),
								'edit_field_class' => 'vc_column vc_col-sm-6',
							),

							// Excerpt Length
							array(
								'type'             => 'textfield',
								'heading'          => esc_html__( 'Excerpt Length','dtdr-lite'),
								'param_name'       => 'excerpt_length',
								'description'      => esc_html__( 'Provide excerpt length here.','dtdr-lite'),
								'dependency'       => array( 'element' => 'type', 'value' => array ( 'type1', 'type2', 'type3', 'type4', 'type5', 'type7', 'type8', 'type9', 'type10' )),
								'edit_field_class' => 'vc_column vc_col-sm-6',
								'std'              => 20
							),

							// Features Image or Icon
							array(
								'type'       => 'dropdown',
								'heading'    => esc_html__('Features Image or Icon','dtdr-lite'),
								'param_name' => 'features_image_or_icon',
								'value'      => array(
									esc_html__( 'None','dtdr-lite')  => '',
									esc_html__( 'Image','dtdr-lite') => 'image',
									esc_html__( 'Icon','dtdr-lite')  => 'icon'
								),
								'description'      => esc_html__('Choose any of the option available to display features.','dtdr-lite'),
								'dependency'       => array( 'element' => 'type', 'value' => array ( 'type1', 'type2', 'type3', 'type4', 'type5', 'type6', 'type8', 'type9' )),
								'edit_field_class' => 'vc_column vc_col-sm-6',
								'std'              => '',
							),

							// Features Include
							array(
								'type'             => 'dropdown',
								'heading'          => esc_html__('Features Include','dtdr-lite'),
								'param_name'       => 'features_include',
								'description'      => esc_html__('Give features id separated by comma. Only 4 maximum number of features allowed.','dtdr-lite'),
								'std'              => '',
								'dependency'       => array( 'element' => 'type', 'value' => array ( 'type1', 'type2', 'type3', 'type4', 'type5', 'type6', 'type8', 'type9' )),
								'edit_field_class' => 'vc_column vc_col-sm-6',
							),

							// No. Of Categories to Display
							array(
								'type'       => 'dropdown',
								'heading'    => esc_html__('No. Of Categories to Display','dtdr-lite'),
								'param_name' => 'no_of_cat_to_display',
								'value'      => array(
									0 => 0,
									1 => 1,
									2 => 2,
									3 => 3,
									4 => 4
								),
								'description'      => esc_html__( 'Number of categories you like to display on your items.','dtdr-lite'),
								'edit_field_class' => 'vc_column vc_col-sm-6',
								'std'              => 2
							),

							// Apply Equal Height
							array(
								'type'       => 'dropdown',
								'heading'    => esc_html__('Apply Equal Height','dtdr-lite'),
								'param_name' => 'apply_equal_height',
								'value'      => array(
									esc_html__( 'False','dtdr-lite') => 'false',
									esc_html__( 'True','dtdr-lite')  => 'true',
								),
								'description'      => esc_html__('Apply equal height for you items.','dtdr-lite'),
								'std'              => 'false',
								'dependency'       => array( 'element' => 'apply_isotope', 'value' =>'false' ),
								'edit_field_class' => 'vc_column vc_col-sm-6',
							),

							// Apply Custom Height
							array(
								'type'       => 'dropdown',
								'heading'    => esc_html__('Apply Custom Height','dtdr-lite'),
								'param_name' => 'apply_custom_height',
								'value'      => array(
									esc_html__( 'False','dtdr-lite') => 'false',
									esc_html__( 'True','dtdr-lite')  => 'true',
								),
								'description' => esc_html__('Apply custom height for your entire section.','dtdr-lite'),
								'std' => 'false',
								'edit_field_class' => 'vc_column vc_col-sm-6',
							),

							// Height
							array (
								'type' => 'textfield',
								'heading' => esc_html__( 'Height','dtdr-lite'),
								'param_name' => 'vc_height',
								'description' => esc_html__( 'Provide height for your section in "px" here.','dtdr-lite'),
								'dependency' => array( 'element' => 'apply_custom_height', 'value' =>'true' ),
								'edit_field_class' => 'vc_column vc_col-sm-6'
							),

							// Sidebar Widget
							array(
								'type' => 'dropdown',
								'heading' => esc_html__('Sidebar Widget','dtdr-lite'),
								'param_name' => 'sidebar_widget',
								'value' => array(
									esc_html__( 'False','dtdr-lite') => 'false',
									esc_html__( 'True','dtdr-lite') => 'true',
								),
								'description' => esc_html__('If you wish to show these items in sidebar set this to "True". This options is not applicable for "Type 3", "Type 5" and "Type 7"','dtdr-lite'),
								'std' => 'false',
								'edit_field_class' => 'vc_column vc_col-sm-6',
							),

							// Class
							array (
								'type' => 'textfield',
								'heading' => esc_html__( 'Class','dtdr-lite'),
								'param_name' => 'class',
								'description' => esc_html__( 'If you wish you can add additional class name here.','dtdr-lite'),
								'edit_field_class' => 'vc_column vc_col-sm-6',
							),

						// Module Options

							$dtdr_listings_listing_vc_map_module_args,

						// Filter Location Options

							$dtdr_location_city_args,
							$dtdr_location_neighborhoods_args,
							$dtdr_location_countiesstates_args,
							$dtdr_location_countries_args,

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
								'description' => esc_html__( 'Enter category ids separated by commas.','dtdr-lite'),
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
								'description' => sprintf( esc_html__('Enter %1$s ids separated by commas','dtdr-lite'), $contracttype_plural_label ),
								'edit_field_class' => 'vc_column vc_col-sm-6',
								'group' => 'Filters',
								'std' => ''
							),

							// Tag Ids
							array(
								'type' => 'textfield',
								'heading' => sprintf( esc_html__('%1$s %2$s','dtdr-lite'), $listing_singular_label, $amenity_plural_label ),
								'param_name' => 'tag_ids',
								'value' => '',
								'description' => sprintf( esc_html__('Enter %1$s ids separated by commas','dtdr-lite'), $amenity_plural_label ),
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
								'description' => sprintf( esc_html__('Enter %1$s ids separated by commas.','dtdr-lite'), strtolower($incharge_singular_label) ),
								'edit_field_class' => 'vc_column vc_col-sm-6',
								'group' => 'Filters',
								'std' => ''
							),

						// Carousel Options

							// Enable Carousel
							array(
								'type' => 'dropdown',
								'heading' => esc_html__('Enable Carousel','dtdr-lite'),
								'param_name' => 'enable_carousel',
								'value' => array(
											esc_html__('False','dtdr-lite') => '',
											esc_html__('True','dtdr-lite') => 'true',
										),
								'description' => esc_html__( 'If you wish you can enable carousel for your item listings. Carousel won\'t work along with "Isotope" & "Equal Height" option.','dtdr-lite'),
								'group' => 'Carousel',
								'dependency' => array( 'element' => 'apply_isotope', 'value' => 'false'),
								'std' => ''
							),

							// Effect
							array(
								'type' => 'dropdown',
								'heading' => esc_html__('Effect','dtdr-lite'),
								'param_name' => 'carousel_effect',
								'value' => array(
											esc_html__('Default','dtdr-lite') => '',
											esc_html__('Fade','dtdr-lite') => 'fade',
										),
								'description' => esc_html__( 'Choose effect for your carousel. Slides Per View has to be 1 for Fade effect.','dtdr-lite'),
								'group' => 'Carousel',
								'edit_field_class' => 'vc_column vc_col-sm-6',
								'dependency' => array( 'element' => 'enable_carousel', 'value' => 'true'),
								'std' => ''
							),

							// Auto Play
							array(
								'type' => 'textfield',
								'heading' => esc_html__('Auto Play','dtdr-lite'),
								'param_name' => 'carousel_autoplay',
								'description' => esc_html__( 'Delay between transitions ( in ms ). Leave empty if you don\'t want to auto play.','dtdr-lite'),
								'group' => 'Carousel',
								'edit_field_class' => 'vc_column vc_col-sm-6',
								'dependency' => array( 'element' => 'enable_carousel', 'value' => 'true'),
							),

							// Slides Per View
							array(
								'type' => 'dropdown',
								'heading' => esc_html__('Slides Per View','dtdr-lite'),
								'param_name' => 'carousel_slidesperview',
								'value' => array(
											1 => 1,
											2 => 2,
											3 => 3,
											4 => 4,
										),
								'description' => esc_html__( 'Number slides of to show in view port. 2,3,4 options not applicable for "type 3", "type 5", "type 7" and "type9". If "Sidebar Widget" is set to "True", than "Slides Per View" will be set to "1".','dtdr-lite'),
								'group' => 'Carousel',
								'edit_field_class' => 'vc_column vc_col-sm-6',
								'dependency' => array( 'element' => 'enable_carousel', 'value' => 'true'),
								'std' => 2
							),

							// Enable loop mode
							array(
								'type' => 'dropdown',
								'heading' => esc_html__('Enable Loop Mode','dtdr-lite'),
								'param_name' => 'carousel_loopmode',
								'value' => array(
									esc_html__('False','dtdr-lite') => 'false',
									esc_html__('True','dtdr-lite') => 'true',
								),
								'description' => esc_html__( 'If you wish you can enable continous loop mode for your carousel.','dtdr-lite'),
								'group' => 'Carousel',
								'edit_field_class' => 'vc_column vc_col-sm-6',
								'dependency' => array( 'element' => 'enable_carousel', 'value' => 'true'),
								'std' => ''
							),

							// Enable mousewheel control
							array(
								'type' => 'dropdown',
								'heading' => esc_html__('Enable Mousewheel Control','dtdr-lite'),
								'param_name' => 'carousel_mousewheelcontrol',
								'value' => array(
									esc_html__('False','dtdr-lite') => 'false',
									esc_html__('True','dtdr-lite') => 'true',
								),
								'description' => esc_html__( 'If you wish you can enable mouse wheel control for your carousel.','dtdr-lite'),
								'group' => 'Carousel',
								'edit_field_class' => 'vc_column vc_col-sm-6',
								'dependency' => array( 'element' => 'enable_carousel', 'value' => 'true'),
								'std' => ''
							),

							// Enable Bullet Pagination
							array(
								'type' => 'dropdown',
								'heading' => esc_html__('Enable Bullet Pagination','dtdr-lite'),
								'param_name' => 'carousel_bulletpagination',
								'value' => array(
									esc_html__('False','dtdr-lite') => 'false',
									esc_html__('True','dtdr-lite') => 'true',
								),
								'description' => esc_html__( 'To enable bullet pagination.','dtdr-lite'),
								'group' => 'Carousel',
								'edit_field_class' => 'vc_column vc_col-sm-6',
								'dependency' => array( 'element' => 'enable_carousel', 'value' => 'true'),
								'std' => ''
							),

							// Enable Arrow Pagination
							array(
								'type' => 'dropdown',
								'heading' => esc_html__('Enable Arrow Pagination','dtdr-lite'),
								'param_name' => 'carousel_arrowpagination',
								'value' => array(
									esc_html__('False','dtdr-lite') => 'false',
									esc_html__('True','dtdr-lite') => 'true',
								),
								'description' => esc_html__( 'To enable arrow pagination.','dtdr-lite'),
								'group' => 'Carousel',
								'edit_field_class' => 'vc_column vc_col-sm-6',
								'dependency' => array( 'element' => 'enable_carousel', 'value' => 'true'),
								'std' => ''
							),

							// Space Between Sliders
							array(
								'type' => 'textfield',
								'heading' => esc_html__('Space Between Sliders','dtdr-lite'),
								'param_name' => 'carousel_spacebetween',
								'description' => esc_html__( 'Space between sliders can be given here.','dtdr-lite'),
								'group' => 'Carousel',
								'edit_field_class' => 'vc_column vc_col-sm-6',
								'dependency' => array( 'element' => 'enable_carousel', 'value' => 'true'),
								'std' => 30
							)

					)

	) );
}
?>