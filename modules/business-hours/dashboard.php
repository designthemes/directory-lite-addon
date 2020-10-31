<?php

// Filter Listing Fields
if(!function_exists('dtdr_add_listing_fields_from_businesshours_module')) {
	function dtdr_add_listing_fields_from_businesshours_module($output = '', $edit_item_id) {

		$listing_singular_label = apply_filters( 'listing_label', 'singular' );

		// Business Hours
			$output .= '<div class="dtdr-dashbord-section-holder">';

				$output .= '<div class="dtdr-dashbord-section-holder-intro">';
					$output .= '<div class="dtdr-dashbord-section-title">'.esc_html__('Business Hours','dtdr-lite').'</div>';
					$output .= '<div class="dtdr-dashbord-section-title-notes">'.sprintf( esc_html__('Add business hours for your %1$s.','dtdr-lite'), strtolower($listing_singular_label) ).'</div>';
				$output .= '</div>';

				$output .= '<div class="dtdr-dashbord-section-holder-content">';
					$output .= '<div class="dtdr-dashboard-option-item">
									   <label for="dtdr_business_hours">'.esc_html__('Add Business Hours','dtdr-lite').'</label>
									   <div class="dtdr-dashboard-option-item-data">';
										$output .= dtdr_listing_business_hours_field($edit_item_id, 'frontend');
						$output .= '</div>';
					$output .= '</div>';
				$output .= '</div>';

			$output .= '</div>';

	    return $output;

	}
	add_filter( 'dtdr_add_listing_fields_from_modules', 'dtdr_add_listing_fields_from_businesshours_module', 10, 2 );
}

?>