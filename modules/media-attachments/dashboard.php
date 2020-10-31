<?php

// Filter Listing Fields
if(!function_exists('dtdr_add_listing_fields_from_attachments_module')) {
	function dtdr_add_listing_fields_from_attachments_module($output = '', $edit_item_id) {

		$listing_singular_label = apply_filters( 'listing_label', 'singular' );

	    // Media - Attachments
			$output .= '<div class="dtdr-dashbord-section-holder">';

				$output .= '<div class="dtdr-dashbord-section-holder-intro">';
					$output .= '<div class="dtdr-dashbord-section-title">'.esc_html__('Media - Attachments','dtdr-lite').'</div>';
					$output .= '<div class="dtdr-dashbord-section-title-notes">'.sprintf( esc_html__('You can add any number of attachments for your %1$s.','dtdr-lite'), strtolower($listing_singular_label) ).'</div>';
				$output .= '</div>';

				$output .= '<div class="dtdr-dashbord-section-holder-content">';
					$output .= '<div class="dtdr-dashboard-option-item">
									<label for="dtdr_features">'.esc_html__('Add Attachments','dtdr-lite').'</label>
									<div class="dtdr-dashboard-option-item-data">';
										$output .= dtdr_listing_attachments_field($edit_item_id);
						$output .= '</div>';
					$output .= '</div>';
				$output .= '</div>';

			$output .= '</div>';

	    return $output;

	}
	add_filter( 'dtdr_add_listing_fields_from_modules', 'dtdr_add_listing_fields_from_attachments_module', 10, 2 );
}

?>