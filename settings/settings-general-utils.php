<?php

function dtdr_settings_general_content() {

	$output = '';

	$seller_singular_label = apply_filters( 'seller_label', 'singular' );
	$seller_plural_label   = apply_filters( 'seller_label', 'plural' );

	$listing_singular_label  = apply_filters( 'listing_label', 'singular' );
	$incharge_singular_label = apply_filters( 'incharge_label', 'singular' );

	$output .= '<form name="formOptionSettings" class="formOptionSettings" method="post">';

		$output .= '<div class="dtdr-settings-options-holder">';
			$output .= '<div class="dtdr-column dtdr-one-fifth first">';
				$output .= '<label>'.esc_html__( 'Container Width','dtdr-lite').'</label>';
			$output .= '</div>';
			$output .= '<div class="dtdr-column dtdr-four-fifth">';
				$container_width = dtdr_option('general','container-width');
				$output .= '<input id="container-width" name="dtdr[general][container-width]" type="number" value="'.esc_attr( $container_width ).'" min="1" max="2000" step="1"  />';
				$output .= '<div class="dtdr-note">'.esc_html__('Provide container width in "px" here','dtdr-lite').'</div>';
			$output .= '</div>';
		$output .= '</div>';

		$output .= '<div class="dtdr-settings-options-holder">';
			$output .= '<div class="dtdr-column dtdr-one-fifth first">';
				$output .= '<label>'.sprintf(esc_html__('%1$s Single Page Template','dtdr-lite'), $listing_singular_label).'</label>';
			$output .= '</div>';
			$output .= '<div class="dtdr-column dtdr-four-fifth">';

				$single_page_template = dtdr_option('general','single-page-template');
				$tpl_args = array (
					'post_type'        => 'page',
					'meta_key'         => '_wp_page_template',
					'meta_value'       => 'tpl-single-listing.php',
					'suppress_filters' => 0
				);
				$single_tpl_posts = get_posts($tpl_args);

				$output .= '<select name="dtdr[general][single-page-template]" class="dtdr-chosen-select">';

					$output .= '<option value="custom-template" '.selected('custom-template', $single_page_template, false ).'>'.esc_html__('Custom Template','dtdr-lite').'</option>';
					$output .= '<option value="default-template-1" '.selected('default-template-1', $single_page_template, false ).'>'.esc_html__('Default Template 1','dtdr-lite').'</option>';

					if(is_array($single_tpl_posts) && !empty($single_tpl_posts)) {
						foreach($single_tpl_posts as $single_tpl_post) {
							$output .= '<option value="'.esc_attr( $single_tpl_post->ID ).'" '.selected($single_tpl_post->ID, $single_page_template, false ).'>';
								$output .= esc_html( $single_tpl_post->post_title );
							$output .= '</option>';
						}
					}
				$output .= '</select>';

				$output .= '<div class="dtdr-note">'.sprintf( esc_html__('If you like to build your %1$s single page by your own choose "Custom Template" else choose one of the predefined templates created using "Directory Single Page Template".','dtdr-lite'), $listing_singular_label ).'</div>';

			$output .= '</div>';
		$output .= '</div>';

		$output .= '<div class="dtdr-settings-options-holder">';
			$output .= '<div class="dtdr-column dtdr-one-fifth first">';
				$output .= '<label>'.esc_html__( 'MLS Number - Prefix','dtdr-lite').'</label>';
			$output .= '</div>';
			$output .= '<div class="dtdr-column dtdr-four-fifth">';
	            $mls_number_prefix = dtdr_option('general','mls-number-prefix');
	            $output .= '<input id="mls-number-prefix" name="dtdr[general][mls-number-prefix]" type="text" value="'.esc_attr( $mls_number_prefix ).'" maxlength="4" style="text-transform:uppercase" />';
	            $output .= '<div class="dtdr-note">'.esc_html__('If you wish you can add prefix for your MLS number.','dtdr-lite').'</div>';
			$output .= '</div>';
		$output .= '</div>';

		$output .= '<div class="dtdr-settings-options-holder">';
			$output .= '<div class="dtdr-column dtdr-one-fifth first">';
				$output .= '<label>'.esc_html__( 'MLS Number - Total Digits','dtdr-lite').'</label>';
			$output .= '</div>';
			$output .= '<div class="dtdr-column dtdr-four-fifth">';
	            $mls_number_digits = dtdr_option('general','mls-number-digits');
	            $output .= '<input id="mls-number-digits" name="dtdr[general][mls-number-digits]" type="number" value="'.esc_attr( $mls_number_digits ).'" min="1" max="8" step="1"  />';
	            $output .= '<div class="dtdr-note">'.esc_html__('If you wish you can add digits for your MLS number. Max value : 8','dtdr-lite').'</div>';
			$output .= '</div>';
		$output .= '</div>';

		$output .= '<div class="dtdr-settings-options-holder">';
			$output .= '<div class="dtdr-column dtdr-one-fifth first">';
				$output .= '<label>'.esc_html__( 'Backend - Post Per Page','dtdr-lite').'</label>';
			$output .= '</div>';
			$output .= '<div class="dtdr-column dtdr-four-fifth">';
	            $backend_postperpage = dtdr_option('general','backend-postperpage');
	            $output .= '<input id="backend-postperpage" name="dtdr[general][backend-postperpage]" type="number" value="'.esc_attr( $backend_postperpage ).'" />';
	            $output .= '<div class="dtdr-note">'.esc_html__('Number of items to show in backend content listing, ex. statistics,..','dtdr-lite').'</div>';
			$output .= '</div>';
		$output .= '</div>';

		$output .= '<div class="dtdr-settings-options-holder">';
			$output .= '<div class="dtdr-column dtdr-one-fifth first">';
				$output .= '<label>'.esc_html__( 'Frontend - Post Per Page','dtdr-lite').'</label>';
			$output .= '</div>';
			$output .= '<div class="dtdr-column dtdr-four-fifth">';
	            $frontend_postperpage = dtdr_option('general','frontend-postperpage');
	            $output .= '<input id="frontend-postperpage" name="dtdr[general][frontend-postperpage]" type="number" value="'.esc_attr( $frontend_postperpage ).'" />';
	            $output .= '<div class="dtdr-note">'.esc_html__('Number of items to show in frontend content listing, ex. dashboard,..','dtdr-lite').'</div>';
			$output .= '</div>';
		$output .= '</div>';

		$output .= '<div class="dtdr-settings-options-holder">';
			$output .= '<div class="dtdr-column dtdr-one-fifth first">';
				$output .= '<label>'.esc_html__( 'Purchase Package Shortcode','dtdr-lite').'</label>';
			$output .= '</div>';
			$output .= '<div class="dtdr-column dtdr-four-fifth">';
				$seller_purchase_package_shortcode = dtdr_option('general','seller-purchase-package-shortcode');
				$seller_purchase_package_shortcode = stripslashes($seller_purchase_package_shortcode);
	            $output .= '<textarea id="seller-plural-label" name="dtdr[general][seller-purchase-package-shortcode]">'.apply_filters( 'seller_purchase_package_shortcode', $seller_purchase_package_shortcode ).'</textarea>';
	            $output .= '<div class="dtdr-note">';
	            	$output .= '<p>'.esc_html__('Add purchase packaged shortcode which will be displayed in seller add listing dashboard page.','dtdr-lite').'</p>';
					$output .= '<p><strong>'.esc_html__('Shortcode - [dtdr_packages_listing type="type1" post_per_page="3" columns="3" apply_isotope="false" package_type="all" package_item_ids="" excerpt_length="20" show_featured_image="true" apply_equal_height="false" enable_carousel="false" carousel_effect="" carousel_autoplay="" carousel_slidesperview="2" carousel_loopmode="false" carousel_mousewheelcontrol="false" carousel_bulletpagination="true" carousel_arrowpagination="" carousel_spacebetween="20" class="" /].','dtdr-lite').'</strong></p>';
	            $output .= '</div>';
			$output .= '</div>';
		$output .= '</div>';

		$output .= '<div class="dtdr-settings-options-holder">';
			$output .= '<div class="dtdr-column dtdr-one-fifth first">';
				$output .= '<label>'.esc_html__( 'Restrict Page View Counter Over User IP','dtdr-lite').'</label>';
			$output .= '</div>';
			$output .= '<div class="dtdr-column dtdr-four-fifth">';
                $checked = ( 'true' ==  dtdr_option('general', 'restrict-counter-overuserip') ) ? ' checked="checked"' : '';
                $switchclass = ( 'true' ==  dtdr_option('general', 'restrict-counter-overuserip') ) ? 'checkbox-switch-on' :'checkbox-switch-off';
	            $output .= '<div data-for="restrict-counter-overuserip" class="dtdr-checkbox-switch '.esc_attr( $switchclass ).'"></div>';
	            $output .= '<input id="restrict-counter-overuserip" class="hidden" type="checkbox" name="dtdr[general][restrict-counter-overuserip]" value="true" '.$checked.' />';
	            $output .= '<div class="dtdr-note">'.esc_html__( 'YES! to restrict page view counter over user ip address. Second entry from same ip address will be restricted.','dtdr-lite').'</div>';
			$output .= '</div>';
		$output .= '</div>';

		$output .= '<div class="dtdr-settings-options-holder">';
			$output .= '<div class="dtdr-column dtdr-one-fifth first">';
				$output .= '<label>'.sprintf(esc_html__('Enable Email - %1$s','dtdr-lite'), $seller_singular_label).'</label>';
			$output .= '</div>';
			$output .= '<div class="dtdr-column dtdr-four-fifth">';
                $checked = ( 'true' ==  dtdr_option('general', 'enable-email-seller') ) ? ' checked="checked"' : '';
                $switchclass = ( 'true' ==  dtdr_option('general', 'enable-email-seller') ) ? 'checkbox-switch-on' :'checkbox-switch-off';
	            $output .= '<div data-for="enable-email-seller" class="dtdr-checkbox-switch '.esc_attr( $switchclass ).'"></div>';
	            $output .= '<input id="enable-email-seller" class="hidden" type="checkbox" name="dtdr[general][enable-email-seller]" value="true" '.esc_attr( $checked ).' />';
	            $output .= '<div class="dtdr-note">'.sprintf(esc_html__('Choose "Yes" to allow %1$s to receive email when %2$s create %3$s.','dtdr-lite'), $seller_singular_label, $incharge_singular_label, $listing_singular_label).'</div>';
			$output .= '</div>';
		$output .= '</div>';

		$output .= '<div class="dtdr-settings-options-holder">';
			$output .= '<div class="dtdr-column dtdr-one-fifth first">';
				$output .= '<label>'.esc_html__('Enable Email - Admin','dtdr-lite').'</label>';
			$output .= '</div>';
			$output .= '<div class="dtdr-column dtdr-four-fifth">';
                $checked = ( 'true' ==  dtdr_option('general', 'enable-email-admin') ) ? ' checked="checked"' : '';
                $switchclass = ( 'true' ==  dtdr_option('general', 'enable-email-admin') ) ? 'checkbox-switch-on' :'checkbox-switch-off';
	            $output .= '<div data-for="enable-email-admin" class="dtdr-checkbox-switch '.esc_attr( $switchclass ).'"></div>';
	            $output .= '<input id="enable-email-admin" class="hidden" type="checkbox" name="dtdr[general][enable-email-admin]" value="true" '.esc_attr( $checked ).' />';
	            $output .= '<div class="dtdr-note">'.sprintf(esc_html__('Choose "Yes" to allow Admin to receive email when %1$s and Incharge create %2$s.','dtdr-lite'), $seller_singular_label, $listing_singular_label).'</div>';
			$output .= '</div>';
		$output .= '</div>';

		$output .= '<div class="dtdr-settings-options-holder">';
			$output .= '<div class="dtdr-column dtdr-one-fifth first">';
				$output .= '<label>'.sprintf(esc_html__('Should admin approve %1$s ?','dtdr-lite'), $listing_singular_label).'</label>';
			$output .= '</div>';
			$output .= '<div class="dtdr-column dtdr-four-fifth">';
                $checked = ( 'true' ==  dtdr_option('general', 'should-admin-approve-listings') ) ? ' checked="checked"' : '';
                $switchclass = ( 'true' ==  dtdr_option('general', 'should-admin-approve-listings') ) ? 'checkbox-switch-on' :'checkbox-switch-off';
	            $output .= '<div data-for="should-admin-approve-listings" class="dtdr-checkbox-switch '.esc_attr( $switchclass ).'"></div>';
	            $output .= '<input id="should-admin-approve-listings" class="hidden" type="checkbox" name="dtdr[general][should-admin-approve-listings]" value="true" '.$checked.' />';
	            $output .= '<div class="dtdr-note">'.sprintf(esc_html__('Choose "Yes" if admin have to approve each %1$s submitted in frontend manually.','dtdr-lite'), $listing_singular_label).'</div>';
			$output .= '</div>';
		$output .= '</div>';

		$output .= '<div class="dtdr-settings-options-holder">';
			$output .= '<div class="dtdr-column dtdr-one-fifth first">';
				$output .= '<label>'.sprintf(esc_html__('Should admin approve %1$s ?','dtdr-lite'), $incharge_singular_label).'</label>';
			$output .= '</div>';
			$output .= '<div class="dtdr-column dtdr-four-fifth">';
                $checked = ( 'true' ==  dtdr_option('general', 'should-admin-approve-incharges') ) ? ' checked="checked"' : '';
                $switchclass = ( 'true' ==  dtdr_option('general', 'should-admin-approve-incharges') ) ? 'checkbox-switch-on' :'checkbox-switch-off';
	            $output .= '<div data-for="should-admin-approve-incharges" class="dtdr-checkbox-switch '.esc_attr( $switchclass ).'"></div>';
	            $output .= '<input id="should-admin-approve-incharges" class="hidden" type="checkbox" name="dtdr[general][should-admin-approve-incharges]" value="true" '.esc_attr( $checked ).' />';
	            $output .= '<div class="dtdr-note">'.sprintf(esc_html__('Choose "Yes" if admin have to approve each %1$s submitted by %2$s.','dtdr-lite'), $incharge_singular_label, $seller_singular_label).'</div>';
			$output .= '</div>';
		$output .= '</div>';

		$output .= '<div class="dtdr-settings-options-holder">';
			$output .= '<div class="dtdr-column dtdr-one-fifth first">';
				$output .= '<label>'.sprintf(esc_html__('Allow "%1$s" to "Add %2$s"','dtdr-lite'), $incharge_singular_label, $listing_singular_label).'</label>';
			$output .= '</div>';
			$output .= '<div class="dtdr-column dtdr-four-fifth">';
                $checked = ( 'true' ==  dtdr_option('general', 'allow-incharge-add-listing') ) ? ' checked="checked"' : '';
                $switchclass = ( 'true' ==  dtdr_option('general', 'allow-incharge-add-listing') ) ? 'checkbox-switch-on' :'checkbox-switch-off';
	            $output .= '<div data-for="allow-incharge-add-listing" class="dtdr-checkbox-switch '.esc_attr( $switchclass ).'"></div>';
	            $output .= '<input id="allow-incharge-add-listing" class="hidden" type="checkbox" name="dtdr[general][allow-incharge-add-listing]" value="true" '.esc_attr( $checked ).' />';
	            $output .= '<div class="dtdr-note">'.sprintf(esc_html__('Choose "Yes" to allow %1$s to add %2$s.','dtdr-lite'), $incharge_singular_label, $seller_singular_label).'</div>';
			$output .= '</div>';
		$output .= '</div>';

		$output .= '<div class="dtdr-option-settings-response-holder"></div>';

		$output .= '<a href="#" class="custom-button-style dtdr-save-options-settings" data-settings="general">'.esc_html__('Save Settings','dtdr-lite').'</a>';

	$output .= '</form>';

	return $output;

}

echo dtdr_settings_general_content();

?>