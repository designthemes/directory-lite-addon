<?php

function dtdr_settings_archives_content() {

 	$listing_singular_label = apply_filters( 'listing_label', 'singular' );

	$output = '';

	$output .= '<form name="formOptionSettings" class="formOptionSettings" method="post">';

		$output .= '<div class="dtdr-settings-options-holder">';
			$output .= '<div class="dtdr-column dtdr-one-fifth first">';
				$output .= '<label>'.esc_html__('Types','dtdr-lite').'</label>';
			$output .= '</div>';
			$output .= '<div class="dtdr-column dtdr-four-fifth">';

				$archive_page_type = dtdr_option('archives','archive-page-type');

				$archive_types = array (
					'type1' => esc_html__('Type 1','dtdr-lite'),
					'type2' => esc_html__('Type 2','dtdr-lite'),
					'type3' => esc_html__('Type 3','dtdr-lite'),
				);

				$output .= '<select name="dtdr[archives][archive-page-type]" class="dtdr-chosen-select">';

					if(is_array($archive_types) && !empty($archive_types)) {
						foreach($archive_types as $key => $archive_type) {
							$output .= '<option value="'.esc_attr( $key ).'" '.selected($key, $archive_page_type, false ).'>';
								$output .= esc_html( $archive_type );
							$output .= '</option>';
						}
					}

				$output .= '</select>';

				$output .= '<div class="dtdr-note">'.sprintf( esc_html__('Choose type for your %1$s archive pages.','dtdr-lite'), strtolower($listing_singular_label) ).'</div>';

			$output .= '</div>';
		$output .= '</div>';

		$output .= '<div class="dtdr-settings-options-holder">';
			$output .= '<div class="dtdr-column dtdr-one-fifth first">';
				$output .= '<label>'.esc_html__('Gallery','dtdr-lite').'</label>';
			$output .= '</div>';
			$output .= '<div class="dtdr-column dtdr-four-fifth">';
					$archive_page_gallery = dtdr_option('archives','archive-page-gallery');
					$archive_galleries = array (
						'featured_image' => esc_html__('Featured Image','dtdr-lite'),
					);

				$output .= '<select name="dtdr[archives][archive-page-gallery]" class="dtdr-chosen-select">';

					if(is_array($archive_galleries) && !empty($archive_galleries)) {
						foreach($archive_galleries as $key => $archive_gallery) {
							$output .= '<option value="'.esc_attr( $key ).'" '.selected($key, $archive_page_gallery, false ).'>';
								$output .= esc_html( $archive_gallery );
							$output .= '</option>';
						}
					}

				$output .= '</select>';

				$output .= '<div class="dtdr-note">'.sprintf( esc_html__('Choose gallery type for your %1$s archive pages.','dtdr-lite'), strtolower($listing_singular_label) ).'</div>';

			$output .= '</div>';
		$output .= '</div>';

		$output .= '<div class="dtdr-settings-options-holder">';
			$output .= '<div class="dtdr-column dtdr-one-fifth first">';
				$output .= '<label>'.esc_html__('Columns','dtdr-lite').'</label>';
			$output .= '</div>';
			$output .= '<div class="dtdr-column dtdr-four-fifth">';

				$archive_page_column = dtdr_option('archives','archive-page-column');
				$archive_columns     = array (
					1 => esc_html__('I Column','dtdr-lite'),
					2 => esc_html__('II Columns','dtdr-lite'),
					3 => esc_html__('III Columns','dtdr-lite')
				);

				$output .= '<select name="dtdr[archives][archive-page-column]" class="dtdr-chosen-select">';

					if(is_array($archive_columns) && !empty($archive_columns)) {
						foreach($archive_columns as $key => $archive_column) {
							$output .= '<option value="'.esc_attr( $key ).'" '.selected($key, $archive_page_column, false ).'>';
								$output .= esc_html( $archive_column );
							$output .= '</option>';
						}
					}

				$output .= '</select>';

				$output .= '<div class="dtdr-note">'.sprintf( esc_html__('Choose column for your %1$s archive pages.','dtdr-lite'), strtolower($listing_singular_label) ).'</div>';

			$output .= '</div>';
		$output .= '</div>';

		$output .= '<div class="dtdr-settings-options-holder">';
			$output .= '<div class="dtdr-column dtdr-one-fifth first">';
				$output .= '<label>'.esc_html__( 'Apply Isotope','dtdr-lite').'</label>';
			$output .= '</div>';
			$output .= '<div class="dtdr-column dtdr-four-fifth">';
				$checked = ( 'true' ==  dtdr_option('archives', 'archive-page-apply-isotope') ) ? ' checked="checked"' : '';
				$switchclass = ( 'true' ==  dtdr_option('archives', 'archive-page-apply-isotope') ) ? 'checkbox-switch-on' :'checkbox-switch-off';
				$output .= '<div data-for="archive-page-apply-isotope" class="dtdr-checkbox-switch '.esc_attr( $switchclass ).'"></div>';
				$output .= '<input id="archive-page-apply-isotope" class="hidden" type="checkbox" name="dtdr[archives][archive-page-apply-isotope]" value="true" '.esc_attr( $checked ).' />';
				$output .= '<div class="dtdr-note">'.sprintf( esc_html__('If you like to apply isotope for your %1$s archive pages, check this options.','dtdr-lite'), strtolower($listing_singular_label) ).'</div>';
			$output .= '</div>';
		$output .= '</div>';

		$output .= '<div class="dtdr-settings-options-holder">';
			$output .= '<div class="dtdr-column dtdr-one-fifth first">';
				$output .= '<label>'.esc_html__( 'Excerpt Length','dtdr-lite').'</label>';
			$output .= '</div>';
			$output .= '<div class="dtdr-column dtdr-four-fifth">';
				$archive_page_excerpt_length = dtdr_option('archives','archive-page-excerpt-length');
				$output .= '<input id="archive-page-excerpt-length" name="dtdr[archives][archive-page-excerpt-length]" type="number" value="'.esc_attr( $archive_page_excerpt_length ).'" min="1" max="2000" step="1"  />';
				$output .= '<div class="dtdr-note">'.sprintf( esc_html__('Provide excerpt length for your %1$s archive pages.','dtdr-lite'), strtolower($listing_singular_label) ).'</div>';
			$output .= '</div>';
		$output .= '</div>';

		$output .= '<div class="dtdr-settings-options-holder">';
			$output .= '<div class="dtdr-column dtdr-one-fifth first">';
				$output .= '<label>'.esc_html__('Features Image or Icon','dtdr-lite').'</label>';
			$output .= '</div>';
			$output .= '<div class="dtdr-column dtdr-four-fifth">';
				$archive_page_features_image_or_icon = dtdr_option('archives','archive-page-features-image-or-icon');
				$archive_features_image_or_icons = array (
					''      => esc_html__('None','dtdr-lite'),
					'image' => esc_html__('Image','dtdr-lite'),
					'icon'  => esc_html__('Icon','dtdr-lite')
				);

				$output .= '<select name="dtdr[archives][archive-page-features-image-or-icon]" class="dtdr-chosen-select">';

					if(is_array($archive_features_image_or_icons) && !empty($archive_features_image_or_icons)) {
						foreach($archive_features_image_or_icons as $key => $archive_features_image_or_icon) {
							$output .= '<option value="'.esc_attr( $key ).'" '.selected($key, $archive_page_features_image_or_icon, false ).'>';
								$output .= esc_html( $archive_features_image_or_icon );
							$output .= '</option>';
						}
					}

				$output .= '</select>';

				$output .= '<div class="dtdr-note">'.sprintf( esc_html__('Choose features image or icon to use for your %1$s archive pages. This option won\'t work for "Type 7" & "Type 10".','dtdr-lite'), strtolower($listing_singular_label) ).'</div>';

			$output .= '</div>';
		$output .= '</div>';

		$output .= '<div class="dtdr-settings-options-holder">';
			$output .= '<div class="dtdr-column dtdr-one-fifth first">';
				$output .= '<label>'.esc_html__( 'Features Include','dtdr-lite').'</label>';
			$output .= '</div>';
			$output .= '<div class="dtdr-column dtdr-four-fifth">';
				$archive_page_features_include = dtdr_option('archives','archive-page-features-include');
				$output .= '<input id="archive-page-features-include" name="dtdr[archives][archive-page-features-include]" type="text" value="'.esc_attr( $archive_page_features_include ).'" />';
				$output .= '<div class="dtdr-note">'.esc_html__('Give features id separated by comma. Only 4 maximum number of features allowed. This option won\'t work for "Type 7" & "Type 10".','dtdr-lite').'</div>';
			$output .= '</div>';
		$output .= '</div>';

		$output .= '<div class="dtdr-settings-options-holder">';
			$output .= '<div class="dtdr-column dtdr-one-fifth first">';
				$output .= '<label>'.esc_html__('No. Of Categories to Display','dtdr-lite').'</label>';
			$output .= '</div>';
			$output .= '<div class="dtdr-column dtdr-four-fifth">';

				$archive_page_noofcat = dtdr_option('archives','archive-page-noofcat-to-display');
				$archive_noofcats = array (
					1  => 1,
					2  => 2,
					3  => 3,
					4  => 4
				);

				$output .= '<select name="dtdr[archives][archive-page-noofcat-to-display]" class="dtdr-chosen-select">';

					if(is_array($archive_noofcats) && !empty($archive_noofcats)) {
						foreach($archive_noofcats as $key => $archive_noofcat) {
							$output .= '<option value="'.esc_attr( $key ).'" '.selected($key, $archive_page_noofcat, false ).'>';
								$output .= esc_html( $archive_noofcat );
							$output .= '</option>';
						}
					}

				$output .= '</select>';

				$output .= '<div class="dtdr-note">'.esc_html__( 'Number of categories you like to display on your items.','dtdr-lite').'</div>';

			$output .= '</div>';
		$output .= '</div>';



		$output .= '<div class="dtdr-note">'.esc_html__('This setting is applicable for all archive pages.','dtdr-lite').'</div>';

		$output .= '<div class="dtdr-option-settings-response-holder"></div>';

		$output .= '<a href="#" class="custom-button-style dtdr-save-options-settings" data-settings="archives">'.esc_html__('Save Settings','dtdr-lite').'</a>';

	$output .= '</form>';

	return $output;

}

echo dtdr_settings_archives_content();

?>