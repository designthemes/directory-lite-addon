<?php
add_action( 'vc_before_init', 'dtdr_listings_taxonomy_vc_map' );

function dtdr_listings_taxonomy_vc_map() {

	$listing_singular_label      = apply_filters( 'listing_label', 'singular' );
	$listing_plural_label        = apply_filters( 'listing_label', 'plural' );

	$taxonomies = apply_filters( 'dtdr_taxonomies', array () );
	$taxonomies = array_flip($taxonomies);

	vc_map( array(
		"name" => sprintf( esc_html__('%1$s Taxonomy','dtdr-lite'), $listing_plural_label ),
		"base" => "dtdr_listings_taxonomy",
		"icon" => "dtdr_listings_taxonomy",
		"category" => DTDR_PB_MODULE_DEFAULT_TITLE,
		"params" => array(

			// Taxonomy
			array(
				'type' => 'dropdown',
				'heading' => esc_html__('Taxonomy','dtdr-lite'),
				'param_name' => 'taxonomy',
				'value' => $taxonomies,
				'description' => esc_html__( 'Choose type of taxonomy you would like to display.','dtdr-lite'),
				'std' => 'dtdr_listings_category',
				'edit_field_class' => 'vc_column vc_col-sm-6',
				'admin_label' => true
			),

			// Type
			array(
				'type' => 'dropdown',
				'heading' => esc_html__('Type','dtdr-lite'),
				'param_name' => 'type',
				'value' => array(
					esc_html__('Type 1','dtdr-lite')  => 'type1',
					esc_html__('Type 2','dtdr-lite')  => 'type2',
					esc_html__('Type 3','dtdr-lite')  => 'type3',
					esc_html__('Type 4','dtdr-lite')  => 'type4',
					esc_html__('Type 5','dtdr-lite')  => 'type5',
					esc_html__('Type 6','dtdr-lite')  => 'type6',
					esc_html__('Type 7','dtdr-lite')  => 'type7',
				),
				'description' => esc_html__( 'Choose type of taxonomy to display.','dtdr-lite'),
				'std' => 'type1',
				'edit_field_class' => 'vc_column vc_col-sm-6',
				'admin_label' => true
			),

			// Image or Icon
			array(
				'type' => 'dropdown',
				'heading' => esc_html__('Media Type','dtdr-lite'),
				'param_name' => 'media_type',
				'value' => array(
					esc_html__('Image','dtdr-lite')      => 'image',
					esc_html__('Icon','dtdr-lite')       => 'icon',
					esc_html__('Icon Image','dtdr-lite') => 'icon_image'
				),
				'description' => esc_html__( 'Choose whether to display image or icon.','dtdr-lite'),
				'std' => 'image',
				'dependency' => array( 'element' => 'type', 'value' => array ('type1', 'type2', 'type3', 'type4') ),
				'edit_field_class' => 'vc_column vc_col-sm-6',
				'admin_label' => true
			),

			// Columns
			array(
				'type' => 'dropdown',
				'heading' => esc_html__('Columns','dtdr-lite'),
				'param_name' => 'columns',
				'value' => array(
							esc_html__('None','dtdr-lite') => '' ,
							esc_html__('I Column','dtdr-lite') => 1 ,
							esc_html__('II Columns','dtdr-lite') => 2 ,
							esc_html__('III Columns','dtdr-lite') => 3,
						),
				'description' => esc_html__( 'Number of columns you like to display your taxonomies.','dtdr-lite'),
				'edit_field_class' => 'vc_column vc_col-sm-6',
				'std' => ''
			),

			// Include
			array(
				'type' => 'textfield',
				'heading' => esc_html__( 'Include','dtdr-lite'),
				'param_name' => 'include',
				'description' => esc_html__( 'List of taxonomy ids separated by commas.','dtdr-lite'),
				'edit_field_class' => 'vc_column vc_col-sm-6',
			),

			// Show Parent Items Alone
			array(
				'type' => 'dropdown',
				'heading' => esc_html__('Show Parent Items Alone','dtdr-lite'),
				'param_name' => 'show_parent_items_alone',
				'value' => array(
					esc_html__( 'False','dtdr-lite') => 'false',
					esc_html__( 'True','dtdr-lite') => 'true',
				),
				'description' => esc_html__( 'If you like to show parent items alone choose "True".','dtdr-lite'),
				'std' => 'false',
				'edit_field_class' => 'vc_column vc_col-sm-6',
			),

			// Child Of
			array(
				'type' => 'textfield',
				'heading' => esc_html__( 'Child Of','dtdr-lite'),
				'param_name' => 'child_of',
				'description' => esc_html__( 'If you like to show child of any parent item, provide id of your taxonomy here.','dtdr-lite'),
				'dependency' => array( 'element' => 'show_parent_items_alone', 'value' => 'false' ),
				'edit_field_class' => 'vc_column vc_col-sm-6',
			),

			// Class
			array(
				'type' => 'textfield',
				'heading' => esc_html__( 'Class','dtdr-lite'),
				'param_name' => 'class',
				'description' => esc_html__( 'If you wish you can add additional class name here.','dtdr-lite'),
				'edit_field_class' => 'vc_column vc_col-sm-6',
			),

		)
	) );
}
?>