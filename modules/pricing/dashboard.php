<?php

// Filter Listing Fields
if(!function_exists('dtdr_add_listing_fields_from_pricing_modules')) {
	function dtdr_add_listing_fields_from_pricing_modules($output = '', $edit_item_id) {

		$listing_singular_label = apply_filters( 'listing_label', 'singular' );


		$dtdr_currency_symbol = $dtdr_currency_symbol_position = $_regular_price = $_sale_price = $dtdr_before_price_label = $dtdr_after_price_label = '';

		if($edit_item_id > 0) {

			$dtdr_currency_symbol             = get_post_meta($edit_item_id, 'dtdr_currency_symbol', true);
			$dtdr_currency_symbol_position    = get_post_meta($edit_item_id, 'dtdr_currency_symbol_position', true);
			$_regular_price                   = get_post_meta($edit_item_id, '_regular_price', true);
			$_sale_price                      = get_post_meta($edit_item_id, '_sale_price', true);
			$dtdr_before_price_label          = get_post_meta($edit_item_id, 'dtdr_before_price_label', true);
			$dtdr_after_price_label           = get_post_meta($edit_item_id, 'dtdr_after_price_label', true);

		}

		// Price
		$output .= '<div class="dtdr-dashbord-section-holder">';

			$output .= '<div class="dtdr-dashbord-section-holder-intro">';
				$output .= '<div class="dtdr-dashbord-section-title">'.esc_html__('Price','dtdr-lite').'</div>';
				$output .= '<div class="dtdr-dashbord-section-title-notes">'.sprintf( esc_html__('If you wish you can add price details for your %1$s.','dtdr-lite'), strtolower($listing_singular_label) ).'</div>';
			$output .= '</div>';

			$output .= '<div class="dtdr-dashbord-section-holder-content">';

				$output .= '<input type="hidden" name="dtdr_woocommerce_meta_nonce" value="'.wp_create_nonce('dtdr_woocommerce_nonce').'" />';

				$output .= '<div class="dtdr-column dtdr-one-half first">';
					$output .= '<div class="dtdr-dashboard-option-item">
										<label for="dtdr_currency_symbol">'.esc_html__('Currency Symbol','dtdr-lite').'</label>
										<div class="dtdr-dashboard-option-item-data">
											<input type="text" value="'.esc_attr($dtdr_currency_symbol).'" name="dtdr_currency_symbol" />
										</div>
								</div>';
				$output .= '</div>';

				$output .= '<div class="dtdr-column dtdr-one-half">';
					$output .= '<div class="dtdr-dashboard-option-item">
										<label for="dtdr_currency_symbol_position">'.esc_html__('Currency Symbol Position','dtdr-lite').'</label>
										<div class="dtdr-dashboard-option-item-data">';

											$currency_symbol_positions = array ('left' => esc_html__('Left','dtdr-lite'), 'right' => esc_html__('Right','dtdr-lite'), 'left_space' => esc_html__('Left With Space','dtdr-lite'), 'right_space' => esc_html__('Right With Space','dtdr-lite'));

											$output .= '<select name="dtdr_currency_symbol_position" class="dtdr-chosen-select">';
												if(count($currency_symbol_positions) > 0) {
													foreach($currency_symbol_positions as $currency_symbol_position_key => $currency_symbol_position_item) {
														$output .= '<option value="'.esc_attr($currency_symbol_position_key).'" '.selected($currency_symbol_position_key, $dtdr_currency_symbol_position, false ).'>'.esc_html($currency_symbol_position_item).'</option>';
													}
												}
											$output .= '</select>';

						$output .= '</div>
								</div>';
				$output .= '</div>';

				$output .= '<div class="dtdr-column dtdr-one-half first">';
					$output .= '<div class="dtdr-dashboard-option-item">
										<label for="_regular_price">'.esc_html__('Regular Price','dtdr-lite').'</label>
										<div class="dtdr-dashboard-option-item-data">
											<input type="text" value="'.esc_attr($_regular_price).'" name="_regular_price" />
										</div>
								</div>';
				$output .= '</div>';

				$output .= '<div class="dtdr-column dtdr-one-half">';
					$output .= '<div class="dtdr-dashboard-option-item">
										<label for="_sale_price">'.esc_html__('Sale Price','dtdr-lite').'</label>
										<div class="dtdr-dashboard-option-item-data">
											<input type="text" value="'.esc_attr($_sale_price).'" name="_sale_price" />
										</div>
								</div>';
				$output .= '</div>';

				$output .= '<div class="dtdr-column dtdr-one-half first">';
					$output .= '<div class="dtdr-dashboard-option-item">
										<label for="dtdr_before_price_label">'.esc_html__('Before Price Label','dtdr-lite').'</label>
										<div class="dtdr-dashboard-option-item-data">
											<input type="text" value="'.esc_attr($dtdr_before_price_label).'" name="dtdr_before_price_label" />
										</div>
								</div>';
				$output .= '</div>';

				$output .= '<div class="dtdr-column dtdr-one-half">';
					$output .= '<div class="dtdr-dashboard-option-item">
										<label for="dtdr_after_price_label">'.esc_html__('After Price Label','dtdr-lite').'</label>
										<div class="dtdr-dashboard-option-item-data">
											<input type="text" value="'.esc_attr($dtdr_after_price_label).'" name="dtdr_after_price_label" />
										</div>
								</div>';
				$output .= '</div>';

			$output .= '</div>';

		$output .= '</div>';

	    return $output;

	}
	add_filter( 'dtdr_add_listing_fields_from_modules', 'dtdr_add_listing_fields_from_pricing_modules', 10, 2 );
}

?>