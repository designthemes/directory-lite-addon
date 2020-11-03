<?php
function dtdr_settings_price_content() {

	$output = '';

	$listing_singular_label = apply_filters( 'listing_label', 'singular' );
	$listing_plural_label = apply_filters( 'listing_label', 'plural' );

	$output .= '<form name="formOptionSettings" class="formOptionSettings" method="post">';

		$output .= '<div class="dtdr-settings-options-holder">';
			$output .= '<div class="dtdr-column dtdr-one-fifth first">';
				$output .= '<label>'.esc_html__('Default Currency Symbol','dtdr-lite').'</label>';
			$output .= '</div>';
			$output .= '<div class="dtdr-column dtdr-four-fifth">';
	            $currency_symbol = dtdr_option('price','currency-symbol');
	            $output .= '<input id="currency-symbol" name="dtdr[price][currency-symbol]" type="text" value="'.esc_attr( $currency_symbol ).'" />';
	            $output .= '<div class="dtdr-note">'.esc_html__('Add currency symbol here. This option will be used for search form - price range shorcode and single page - price shortcode.','dtdr-lite').'</div>';
			$output .= '</div>';
		$output .= '</div>';

		$output .= '<div class="dtdr-settings-options-holder">';
			$output .= '<div class="dtdr-column dtdr-one-fifth first">';
				$output .= '<label>'.esc_html__('Default Currency Symbol - Position','dtdr-lite').'</label>';
			$output .= '</div>';
			$output .= '<div class="dtdr-column dtdr-four-fifth">';

				$currency_symbol_position = dtdr_option('price','currency-symbol-position');
	            $currency_symbol_positions = array ('left' => esc_html__('Left','dtdr-lite'), 'right' => esc_html__('Right','dtdr-lite'), 'left_space' => esc_html__('Left With Space','dtdr-lite'), 'right_space' => esc_html__('Right With Space','dtdr-lite'));

	            $output .= '<select id="currency-symbol-position" name="dtdr[price][currency-symbol-position]" class="dtdr-chosen-select">';
				foreach($currency_symbol_positions as $currency_symbol_position_key => $currency_symbol_position_item) {
					$output .= '<option value="'.esc_attr( $currency_symbol_position_key ).'" '.selected($currency_symbol_position_key, $currency_symbol_position, false ).'>';
						$output .= esc_html( $currency_symbol_position_item );
					$output .= '</option>';
				}
				$output .= '</select>';

	            $output .= '<div class="dtdr-note">'.esc_html__('Add currency symbol position here. This option will be used for search form - price range shorcode and single page - price shortcode.','dtdr-lite').'</div>';

			$output .= '</div>';
		$output .= '</div>';

		$output .= '<div class="dtdr-option-settings-response-holder"></div>';

		$output .= '<a href="#" class="custom-button-style dtdr-save-options-settings" data-settings="price">'.esc_html__('Save Settings','dtdr-lite').'</a>';

	$output .= '</form>';

	return $output;

}

echo dtdr_settings_price_content();
?>