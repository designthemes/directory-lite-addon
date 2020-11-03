<?php

function dtdr_settings_permalink_content() {

	$listing_singular_label = apply_filters( 'listing_label', 'singular' );
	$seller_singular_label  = apply_filters( 'seller_label', 'singular' );

	$output = '';

	$output .= '<form name="formOptionSettings" class="formOptionSettings" method="post">';

		$output .= '<div class="dtdr-settings-options-holder">';
			$output .= '<div class="dtdr-column dtdr-one-fifth first">';
				$output .= '<label>'.sprintf( esc_html__( '%1$s Slug','dtdr-lite'), $listing_singular_label ).'</label>';
			$output .= '</div>';
			$output .= '<div class="dtdr-column dtdr-four-fifth">';
	            $listing_slug = dtdr_option('permalink','listing-slug');
	            $output .= '<input id="listing-slug" name="dtdr[permalink][listing-slug]" type="text" value="'.esc_attr( $listing_slug ).'" />';
	            $output .= '<div class="dtdr-note">'.esc_html__('Do not use characters not allowed in links. Use, eg. listing After change go to Settings > Permalinks and click Save changes.','dtdr-lite').'</div>';
			$output .= '</div>';
		$output .= '</div>';

		$output .= '<div class="dtdr-settings-options-holder">';
			$output .= '<div class="dtdr-column dtdr-one-fifth first">';
				$output .= '<label>'.sprintf( esc_html__( '%1$s Category Slug','dtdr-lite'), $listing_singular_label ).'</label>';
			$output .= '</div>';
			$output .= '<div class="dtdr-column dtdr-four-fifth">';
	            $dtdr_listings_category_slug = dtdr_option('permalink','listing-category-slug');
	            $output .= '<input id="listing-category-slug" name="dtdr[permalink][listing-category-slug]" type="text" value="'.esc_attr( $dtdr_listings_category_slug ).'" />';
	            $output .= '<div class="dtdr-note">'.esc_html__('Do not use characters not allowed in links. Use, eg. listing-category After change go to Settings > Permalinks and click Save changes.','dtdr-lite').'</div>';
			$output .= '</div>';
		$output .= '</div>';

		$output .= '<div class="dtdr-settings-options-holder">';
			$output .= '<div class="dtdr-column dtdr-one-fifth first">';
				$output .= '<label>'.sprintf( esc_html__( '%1$s Contract Type Slug','dtdr-lite'), $listing_singular_label ).'</label>';
			$output .= '</div>';
			$output .= '<div class="dtdr-column dtdr-four-fifth">';
	            $dtdr_listings_contracttype_slug = dtdr_option('permalink','listing-contracttype-slug');
	            $output .= '<input id="listing-contracttype-slug" name="dtdr[permalink][listing-contracttype-slug]" type="text" value="'.esc_attr( $dtdr_listings_contracttype_slug ).'" />';
	            $output .= '<div class="dtdr-note">'.esc_html__('Do not use characters not allowed in links. Use, eg. listing-contracttype After change go to Settings > Permalinks and click Save changes.','dtdr-lite').'</div>';
			$output .= '</div>';
		$output .= '</div>';

		$output .= '<div class="dtdr-settings-options-holder">';
			$output .= '<div class="dtdr-column dtdr-one-fifth first">';
				$output .= '<label>'.sprintf( esc_html__( '%1$s Amenity Slug','dtdr-lite'), $listing_singular_label ).'</label>';
			$output .= '</div>';
			$output .= '<div class="dtdr-column dtdr-four-fifth">';
	            $dtdr_listings_amenity_slug = dtdr_option('permalink','listing-amenity-slug');
	            $output .= '<input id="listing-amenity-slug" name="dtdr[permalink][listing-amenity-slug]" type="text" value="'.esc_attr( $dtdr_listings_amenity_slug ).'" />';
	            $output .= '<div class="dtdr-note">'.esc_html__('Do not use characters not allowed in links. Use, eg. listing-amenity After change go to Settings > Permalinks and click Save changes.','dtdr-lite').'</div>';
			$output .= '</div>';
		$output .= '</div>';


		$output .= '<div class="dtdr-note">'.esc_html__('Do not use characters not allowed in links. Use, eg. courses After change go to Settings > Permalinks and click Save changes.','dtdr-lite').'</div>';

		$output .= '<div class="dtdr-option-settings-response-holder"></div>';

		$output .= '<a href="#" class="custom-button-style dtdr-save-options-settings" data-settings="permalink">'.esc_html__('Save Settings','dtdr-lite').'</a>';

	$output .= '</form>';

	return $output;

}

echo dtdr_settings_permalink_content();

?>