<?php

function dtdr_settings_label_content() {

	$output = '';

	$listing_singular_label = apply_filters( 'listing_label', 'singular' );
	$listing_plural_label = apply_filters( 'listing_label', 'plural' );

	$contracttype_singular_label = apply_filters( 'contracttype_label', 'singular' );
	$contracttype_plural_label = apply_filters( 'contracttype_label', 'plural' );

	$amenity_singular_label = apply_filters( 'amenity_label', 'singular' );
	$amenity_plural_label = apply_filters( 'amenity_label', 'plural' );

	$seller_singular_label = apply_filters( 'seller_label', 'singular' );
	$seller_plural_label = apply_filters( 'seller_label', 'plural' );

	$incharge_singular_label = apply_filters( 'incharge_label', 'singular' );
	$incharge_plural_label = apply_filters( 'incharge_label', 'plural' );

	$output .= '<form name="formOptionSettings" class="formOptionSettings" method="post">';	

		$output .= '<div class="dtdr-settings-options-holder">';
			$output .= '<div class="dtdr-column dtdr-one-fifth first">';
				$output .= '<label>'.sprintf( esc_html__( '%1$s Singular Label','dtdr-lite'), $listing_singular_label ).'</label>';
			$output .= '</div>';
			$output .= '<div class="dtdr-column dtdr-four-fifth">';
	            $output .= '<input id="listing-singular-label" name="dtdr[label][listing-singular-label]" type="text" value="'.$listing_singular_label.'" />';
	            $output .= '<div class="dtdr-note">'.esc_html__('You can replace the "Listing" label as per your requirement.','dtdr-lite').'</div>';
			$output .= '</div>';
		$output .= '</div>';

		$output .= '<div class="dtdr-settings-options-holder">';
			$output .= '<div class="dtdr-column dtdr-one-fifth first">';
				$output .= '<label>'.sprintf( esc_html__( '%1$s Plural Label','dtdr-lite'), $listing_plural_label ).'</label>';
			$output .= '</div>';
			$output .= '<div class="dtdr-column dtdr-four-fifth">';
	            $output .= '<input id="listing-plural-label" name="dtdr[label][listing-plural-label]" type="text" value="'.$listing_plural_label.'" />';
	            $output .= '<div class="dtdr-note">'.esc_html__('You can replace the "Listings" label as per your requirement.','dtdr-lite').'</div>';
			$output .= '</div>';
		$output .= '</div>';

		$output .= '<div class="dtdr-settings-options-holder">';
			$output .= '<div class="dtdr-column dtdr-one-fifth first">';
				$output .= '<label>'.sprintf( esc_html__( '%1$s Singular Label','dtdr-lite'), $contracttype_singular_label ).'</label>';
			$output .= '</div>';
			$output .= '<div class="dtdr-column dtdr-four-fifth">';
	            $output .= '<input id="contracttype-singular-label" name="dtdr[label][contracttype-singular-label]" type="text" value="'.$contracttype_singular_label.'" />';
	            $output .= '<div class="dtdr-note">'.esc_html__('You can replace the "Contract Type" label as per your requirement.','dtdr-lite').'</div>';
			$output .= '</div>';
		$output .= '</div>';

		$output .= '<div class="dtdr-settings-options-holder">';
			$output .= '<div class="dtdr-column dtdr-one-fifth first">';
				$output .= '<label>'.sprintf( esc_html__( '%1$s Plural Label','dtdr-lite'), $contracttype_plural_label ).'</label>';
			$output .= '</div>';
			$output .= '<div class="dtdr-column dtdr-four-fifth">';
	            $output .= '<input id="contracttype-plural-label" name="dtdr[label][contracttype-plural-label]" type="text" value="'.$contracttype_plural_label.'" />';
	            $output .= '<div class="dtdr-note">'.esc_html__('You can replace the "Contract Types" label as per your requirement.','dtdr-lite').'</div>';
			$output .= '</div>';
		$output .= '</div>';

		$output .= '<div class="dtdr-settings-options-holder">';
			$output .= '<div class="dtdr-column dtdr-one-fifth first">';
				$output .= '<label>'.sprintf( esc_html__( '%1$s Singular Label','dtdr-lite'), $amenity_singular_label ).'</label>';
			$output .= '</div>';
			$output .= '<div class="dtdr-column dtdr-four-fifth">';
	            $output .= '<input id="amenity-singular-label" name="dtdr[label][amenity-singular-label]" type="text" value="'.$amenity_singular_label.'" />';
	            $output .= '<div class="dtdr-note">'.esc_html__('You can replace the "Amenity" label as per your requirement.','dtdr-lite').'</div>';
			$output .= '</div>';
		$output .= '</div>';

		$output .= '<div class="dtdr-settings-options-holder">';
			$output .= '<div class="dtdr-column dtdr-one-fifth first">';
				$output .= '<label>'.sprintf( esc_html__( '%1$s Plural Label','dtdr-lite'), $amenity_plural_label ).'</label>';
			$output .= '</div>';
			$output .= '<div class="dtdr-column dtdr-four-fifth">';
	            $output .= '<input id="amenity-plural-label" name="dtdr[label][amenity-plural-label]" type="text" value="'.$amenity_plural_label.'" />';
	            $output .= '<div class="dtdr-note">'.esc_html__('You can replace the "Amenities" label as per your requirement.','dtdr-lite').'</div>';
			$output .= '</div>';
		$output .= '</div>';

		$output .= '<div class="dtdr-settings-options-holder">';
			$output .= '<div class="dtdr-column dtdr-one-fifth first">';
				$output .= '<label>'.sprintf( esc_html__( '%1$s Singular Label','dtdr-lite'), $seller_singular_label ).'</label>';
			$output .= '</div>';
			$output .= '<div class="dtdr-column dtdr-four-fifth">';
	            $output .= '<input id="seller-singular-label" name="dtdr[label][seller-singular-label]" type="text" value="'.$seller_singular_label.'" />';
	            $output .= '<div class="dtdr-note">'.esc_html__('You can replace the "Seller" label as per your requirement.','dtdr-lite').'</div>';
			$output .= '</div>';
		$output .= '</div>';

		$output .= '<div class="dtdr-settings-options-holder">';
			$output .= '<div class="dtdr-column dtdr-one-fifth first">';
				$output .= '<label>'.sprintf( esc_html__( '%1$s Plural Label','dtdr-lite'), $seller_plural_label ).'</label>';
			$output .= '</div>';
			$output .= '<div class="dtdr-column dtdr-four-fifth">';
	            $output .= '<input id="seller-plural-label" name="dtdr[label][seller-plural-label]" type="text" value="'.$seller_plural_label.'" />';
	         $output .= '<div class="dtdr-note">'.esc_html__('You can replace the "Sellers" label as per your requirement.','dtdr-lite').'</div>';
			$output .= '</div>';
		$output .= '</div>';

		$output .= '<div class="dtdr-settings-options-holder">';
			$output .= '<div class="dtdr-column dtdr-one-fifth first">';
				$output .= '<label>'.sprintf( esc_html__( '%1$s Singular Label','dtdr-lite'), $incharge_singular_label ).'</label>';
			$output .= '</div>';
			$output .= '<div class="dtdr-column dtdr-four-fifth">';
	            $output .= '<input id="incharge-singular-label" name="dtdr[label][incharge-singular-label]" type="text" value="'.$incharge_singular_label.'" />';
	            $output .= '<div class="dtdr-note">'.esc_html__('You can replace the "Incharge" label as per your requirement.','dtdr-lite').'</div>';
			$output .= '</div>';
		$output .= '</div>';

		$output .= '<div class="dtdr-settings-options-holder">';
			$output .= '<div class="dtdr-column dtdr-one-fifth first">';
				$output .= '<label>'.sprintf( esc_html__( '%1$s Plural Label','dtdr-lite'), $incharge_plural_label ).'</label>';
			$output .= '</div>';
			$output .= '<div class="dtdr-column dtdr-four-fifth">';
	            $output .= '<input id="incharge-plural-label" name="dtdr[label][incharge-plural-label]" type="text" value="'.$incharge_plural_label.'" />';
	         $output .= '<div class="dtdr-note">'.esc_html__('You can replace the "Incharges" label as per your requirement.','dtdr-lite').'</div>';
			$output .= '</div>';
		$output .= '</div>';

		$output .= '<div class="dtdr-option-settings-response-holder"></div>';

		$output .= '<a href="#" class="custom-button-style dtdr-save-options-settings" data-settings="label">'.esc_html__('Save Settings','dtdr-lite').'</a>';

	$output .= '</form>';

	return $output;

}

echo dtdr_settings_label_content();

?>