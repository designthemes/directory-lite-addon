<?php

// Dashboard Features Field
function dtdr_listing_features_field($item_id) {

	$output = '';

    $output .= '<div class="dtdr-features-box-container">';

    	$output .= '<div class="dtdr-features-box-item-holder">';

			$dtdr_features_title = $dtdr_features_subtitle = $dtdr_features_value = $dtdr_features_valueunit = $dtdr_features_icon = $dtdr_features_image = '';
			if($item_id > 0) {
				$dtdr_features_title = get_post_meta($item_id, 'dtdr_features_title', true);
				$dtdr_features_subtitle = get_post_meta($item_id, 'dtdr_features_subtitle', true);
				$dtdr_features_value = get_post_meta($item_id, 'dtdr_features_value', true);
				$dtdr_features_valueunit = get_post_meta($item_id, 'dtdr_features_valueunit', true);
				$dtdr_features_icon = get_post_meta($item_id, 'dtdr_features_icon', true);
				$dtdr_features_image = get_post_meta($item_id, 'dtdr_features_image', true);
			}

			$j = 0;
			if(is_array($dtdr_features_title) && !empty($dtdr_features_title)) {
				foreach($dtdr_features_title as $dtdr_feature_title) {
					$image_url = wp_get_attachment_image_src($dtdr_features_image[$j], 'full');
					$image_url = isset($image_url[0]) ? $image_url[0] : '';

					$output .= '<div class="dtdr-features-box-item">
									<div class="dtdr-column dtdr-one-half first">
										<input name="dtdr_tab_id" class="dtdr_tab_id" type="text" value="'.esc_attr($j).'" readonly />
									</div>
									<div class="dtdr-column dtdr-one-half">
										<input name="dtdr_features_title[]" type="text" value="'.esc_attr($dtdr_feature_title).'" placeholder="'.esc_attr__('Title','dtdr-lite').'" />
									</div>
									<div class="dtdr-column dtdr-one-half first">
										<input name="dtdr_features_subtitle[]" type="text" value="'.esc_attr($dtdr_features_subtitle[$j]).'" placeholder="'.esc_attr__('Sub Title','dtdr-lite').'" />
									</div>
									<div class="dtdr-column dtdr-one-half">
										<input name="dtdr_features_value[]" type="text" value="'.esc_attr($dtdr_features_value[$j]).'" placeholder="'.esc_attr__('Value','dtdr-lite').'" />
									</div>
									<div class="dtdr-column dtdr-one-half first">
										<input name="dtdr_features_valueunit[]" type="text" value="'.esc_attr($dtdr_features_valueunit[$j]).'" placeholder="'.esc_attr__('Value Unit','dtdr-lite').'" />
									</div>
									<div class="dtdr-column dtdr-one-half">
										<input name="dtdr_features_icon[]" type="text" value="'.esc_attr($dtdr_features_icon[$j]).'" placeholder="'.esc_attr__('Icon','dtdr-lite').'" />
									</div>
									<div class="dtdr-column dtdr-one-column first dtdr-upload-media-items-container">
										<input name="dtdr_features_image_url" type="text" value="'.esc_url($image_url).'" placeholder="'.esc_attr__('Image','dtdr-lite').'" class="uploadfieldurl" readonly />
										<input name="dtdr_features_image[]" type="hidden" value="'.esc_attr($dtdr_features_image[$j]).'" placeholder="'.esc_attr__('Image','dtdr-lite').'" class="uploadfieldid" readonly />
						                <input type="button" value="'.esc_attr__('Upload','dtdr-lite').'" class="dtdr-upload-media-item-button show-preview" />
						                <input type="button" value="'.esc_attr__('Remove','dtdr-lite').'" class="dtdr-upload-media-item-reset" />
						                '.dtdr_adminpanel_image_preview($image_url).'
									</div>
									<div class="dtdr-features-box-options">
										<span class="dtdr-remove-features"><span class="fas fa-times"></span></span>
					                    <span class="dtdr-sort-features"><span class="fas fa-arrows-alt"></span></span>
									</div>
								</div>';
					$j++;
				}
			}

		$output .= '</div>';

		$output .= '<a href="#" class="dtdr-add-features-box custom-button-style">'.esc_html__('Add Feature','dtdr-lite').'</a>';

		$output .= '<div class="dtdr-features-box-item-toclone hidden">
						<div class="dtdr-column dtdr-one-half first">
							<input name="dtdr_tab_id" id="dtdr_tab_id" type="text" value="" readonly/>
						</div>
						<div class="dtdr-column dtdr-one-half">
							<input id="dtdr_features_title" type="text" placeholder="'.esc_attr__('Title','dtdr-lite').'" />
						</div>
						<div class="dtdr-column dtdr-one-half first">
							<input id="dtdr_features_subtitle" type="text" placeholder="'.esc_attr__('Sub Title','dtdr-lite').'" />
						</div>
						<div class="dtdr-column dtdr-one-half">
							<input id="dtdr_features_value" type="text" placeholder="'.esc_attr__('Value','dtdr-lite').'" />
						</div>
						<div class="dtdr-column dtdr-one-half first">
							<input id="dtdr_features_valueunit" type="text" placeholder="'.esc_attr__('Value Unit','dtdr-lite').'" />
						</div>
						<div class="dtdr-column dtdr-one-half">
							<input id="dtdr_features_icon" type="text" placeholder="'.esc_attr__('Icon','dtdr-lite').'" />
						</div>
						<div class="dtdr-column dtdr-one-column first dtdr-upload-media-items-container">
							<input name="dtdr_features_image_url" type="text" placeholder="'.esc_attr__('Image','dtdr-lite').'" class="uploadfieldurl" readonly />
							<input id="dtdr_features_image" type="hidden" placeholder="'.esc_attr__('Image','dtdr-lite').'" class="uploadfieldid" readonly />
			                <input type="button" value="'.esc_attr__('Upload','dtdr-lite').'" class="dtdr-upload-media-item-button show-preview" />
			                <input type="button" value="'.esc_attr__('Remove','dtdr-lite').'" class="dtdr-upload-media-item-reset" />
			                '.dtdr_adminpanel_image_preview('').'
						</div>
						<div class="dtdr-features-box-options">
							<span class="dtdr-remove-features"><span class="fas fa-times"></span></span>
		                    <span class="dtdr-sort-features"><span class="fas fa-arrows-alt"></span></span>
						</div>
					</div>';

    $output .= '</div>';

    return $output;

}

// Dashboard User Profile Picture Field
function dtdr_user_profile_picture_field($user_id) {

	$output = '';

	$dtdr_user_profile_image_url = get_the_author_meta( 'dtdr_user_profile_image_url' , $user_id );
	$dtdr_user_profile_image     = get_the_author_meta( 'dtdr_user_profile_image' , $user_id );

	$output .= '<div class="dtdr-upload-media-items-container">
					'.dtdr_adminpanel_image_holder($dtdr_user_profile_image_url).'
					<input name="dtdr_user_profile_image_url" type="text" value="'.esc_attr( $dtdr_user_profile_image_url ).'" placeholder="'.esc_attr__('Image','dtdr-lite').'" class="uploadfieldurl" readonly />
					<input name="dtdr_user_profile_image" value="'.esc_attr( $dtdr_user_profile_image ).'" type="hidden" placeholder="'.esc_attr__('Image','dtdr-lite').'" class="uploadfieldid" readonly />
	                <input type="button" value="'.esc_attr__('Upload','dtdr-lite').'" class="dtdr-upload-media-item-button show-image-holder" />
	                <input type="button" value="'.esc_attr__('Remove','dtdr-lite').'" class="dtdr-upload-media-item-reset" />
				</div>';

	return $output;

}

// Dashboard Social Details Field
function dtdr_social_details_field($item_id, $item_type) {

	$output = '';

	$sociables = array('fa-dribbble' => 'Dribble', 'fa-flickr' => 'Flickr', 'fa-github' => 'GitHub', 'fa-pinterest' => 'Pinterest', 'fa-stack-overflow' => 'Stack Overflow', 'fa-twitter' => 'Twitter', 'fa-youtube' => 'YouTube', 'fa-android' => 'Android', 'fa-dropbox' => 'Dropbox', 'fa-instagram' => 'Instagram', 'fa-facebook' => 'Facebook', 'fa-google-plus' => 'Google Plus', 'fa-linkedin' => 'LinkedIn', 'fa-skype' => 'Skype', 'fa-tumblr' => 'Tumblr', 'fa-vimeo-square' => 'Vimeo');

	$output .= '<div class="dtdr-social-item-details-container">';

			if($item_type == 'user') {
				$dtdr_social_items = get_the_author_meta('dtdr_user_social_items', $item_id);
				$dtdr_social_items = (isset($dtdr_social_items) && is_array($dtdr_social_items)) ? $dtdr_social_items : array ();
			} else {
				$dtdr_social_items = get_post_meta($item_id, 'dtdr_social_items', true);
				$dtdr_social_items = (isset($dtdr_social_items) && is_array($dtdr_social_items)) ? $dtdr_social_items : array ();
			}

			if($item_type == 'user') {
				$dtdr_social_items_value = get_the_author_meta('dtdr_user_social_items_value', $item_id);
				$dtdr_social_items_value = (isset($dtdr_social_items_value) && is_array($dtdr_social_items_value)) ? $dtdr_social_items_value : array ();
			} else {
				$dtdr_social_items_value = get_post_meta($item_id, 'dtdr_social_items_value', true);
				$dtdr_social_items_value = (isset($dtdr_social_items_value) && is_array($dtdr_social_items_value)) ? $dtdr_social_items_value : array ();
			}

			$i = 0;
			foreach($dtdr_social_items as $dtdr_social_item) {

			    $output .=  '<div class="dtdr-social-item-section">';

					$output .=  '<select class="dtdr-social-item-list dtdr-social-chosen-select" name="dtdr_social_items[]">';
						foreach ( $sociables as $sociable_key => $sociable_value ) :
							$s = ($sociable_key == $dtdr_social_item) ? 'selected="selected"' : '';
							$v = ucwords ( $sociable_value );
							$output .=  '<option value="'.esc_attr( $sociable_key ).'" '.esc_attr( $s ).'>'.esc_html( $v ).'</option>';
						endforeach;
					$output .=  '</select>';

			        $output .=  '<input class="large" type="text" placeholder="'.esc_attr__('Social Link','dtdr-lite').'" name="dtdr_social_items_value[]" value="'.$dtdr_social_items_value[$i].'" />';

					$output .=  '<div class="dtdr-social-item-section-options">
						<span class="dtdr-remove-social-item"><span class="fas fa-times"></span></span>
						<span class="dtdr-sort-features"><span class="fas fa-arrows-alt"></span></span>
					</div>';

			    $output .=  '</div>';

			    $i++;

			}

	$output .=  '</div>';

    $output .=  '<a href="#" class="dtdr-add-social-details custom-button-style">'.esc_html__('Add Social Item','dtdr-lite').'</a>';

    $output .=  '<div id="dtdr-social-details-section-to-clone" class="hidden">';

		$output .=  '<select class="dtdr-social-item-list">';
			foreach ( $sociables as $key => $value ) :
				$v = ucwords ( $value );
				$output .=  '<option value="'.esc_attr__( $key ).'">'.esc_html( $v ).'</option>';
			endforeach;
		$output .=  '</select>';

        $output .=  '<input class="large" type="text" placeholder="'.esc_attr__('Social Link','dtdr-lite').'" />';

		$output .=  '<div class="dtdr-social-item-section-options">
						<span class="dtdr-remove-social-item"><span class="fas fa-times"></span></span>
	                    <span class="dtdr-sort-features"><span class="fas fa-arrows-alt"></span></span>
					</div>';

    $output .=  '</div>';

    return $output;

}

// Dashboard Upload Map Marker
function dtdr_upload_promoflash_image($item_id) {

	$output = '';

	$dtdr_map_image = get_post_meta($item_id, 'dtdr_map_image', true);

	$image_url = wp_get_attachment_image_src($dtdr_map_image, 'full');
	$map_image = isset($image_url[0]) ? $image_url[0] : '';

	if($map_image != '') {
		$output .= '<div class="dtdr-upload-media-items-container">
						'.dtdr_adminpanel_image_holder($map_image).'
						<input name="dtdr_promoflash_url" type="text" value="'.esc_attr__( $map_image ).'" placeholder="'.esc_attr__('Image','dtdr-lite').'" class="uploadfieldurl" readonly />
						<input name="dtdr_map_image" value="'.$dtdr_map_image.'" type="hidden" placeholder="'.esc_attr__('Image','dtdr-lite').'" class="uploadfieldid" readonly />
						<input type="button" value="'.esc_attr__('Upload','dtdr-lite').'" class="dtdr-upload-media-item-button show-image-holder" />
						<input type="button" value="'.esc_attr__('Remove','dtdr-lite').'" class="dtdr-upload-media-item-reset" />
					</div>';
	}

	return $output;

}

// Incharge filed
function dtdr_listing_incharge_field($item_id, $user_type) {

	$output = '';

	$dtdr_incharges = get_post_meta($item_id, 'dtdr_incharges', true);
	$dtdr_incharges = (is_array($dtdr_incharges) && !empty($dtdr_incharges)) ? $dtdr_incharges : array ();

	$output .= '<div class="dtdr-incharge-module-container">';

        $output .= '<select name="dtdr_incharges[]" class="dtdr-chosen-select" data-placeholder="'.esc_attr__('None','dtdr-lite').'" multiple="multiple">';

        	if($user_type == 'admin') {
				$incharges = get_users ( array ('role' => 'incharge') );
			} else {
				$current_user_id = get_current_user_id();
				$incharges = get_users ( array ('role' => 'incharge', 'meta_key' => 'user_seller', 'meta_value' => $current_user_id) );
			}


			if(is_array($incharges) && !empty($incharges)) {
				foreach ( $incharges as $incharge ) {
					setup_postdata( $incharge );

					$incharge_id = $incharge->data->ID;

                	$selected_attribute = '';
                	if(in_array($incharge_id, $dtdr_incharges)) {
                		$selected_attribute = 'selected="selected"';
                	}

					$output .= '<option value="'.esc_attr($incharge_id).'" '.$selected_attribute.'>'.esc_html(get_the_author_meta('display_name', $incharge_id)).'</option>';

				}

			}

        $output .= '</select>';

	$output .= '</div>';


	return $output;

}

// Page Template Field
function dtdr_listing_page_template_field($item_id, $admin = false) {

	$listing_singular_label = apply_filters( 'listing_label', 'singular' );

	$output = '';

	$output .= '<div class="dtdr-page-template-module-container">';

		$dtdr_page_template = get_post_meta($item_id, 'dtdr_page_template', true);
		$dtdr_page_template = ($dtdr_page_template != '') ? $dtdr_page_template : 'admin-option';

		$tpl_args = array (
			'post_type'        => 'page',
			'meta_key'         => '_wp_page_template',
			'meta_value'       => 'tpl-single-listing.php',
			'suppress_filters' => 0
		);
		$single_tpl_posts = get_posts($tpl_args);

		$output .= '<select name="dtdr_page_template" class="dtdr-chosen-select">';

			$output .= '<option value="admin-option" '.selected('admin-option', $dtdr_page_template, false ).'>'.esc_html__('Admin Option','dtdr-lite').'</option>';
			$output .= '<option value="custom-template" '.selected('custom-template', $dtdr_page_template, false ).'>'.esc_html__('Custom Template','dtdr-lite').'</option>';
			$output .= '<option value="default-template-1" '.selected('default-template-1', $dtdr_page_template, false ).'>'.esc_html__('Default Template 1','dtdr-lite').'</option>';

			if(is_array($single_tpl_posts) && !empty($single_tpl_posts)) {
				foreach($single_tpl_posts as $single_tpl_post) {
					$output .= '<option value="'.esc_attr( $single_tpl_post->ID ).'" '.selected($single_tpl_post->ID, $dtdr_page_template, false ).'>';
						$output .= esc_html( $single_tpl_post->post_title );
					$output .= '</option>';
				}
			}

		$output .= '</select>';

		if($admin) {
			$output .= '<div class="dtdr-note">'.sprintf( esc_html__('If you like to build your %1$s single page by your own choose "Custom Template" else choose one of the predefined templates created using "Directory Single Page Template".','dtdr-lite'), $listing_singular_label ).'</div>';
		} else {
			$output .= '<div class="dtdr-note">'.sprintf( esc_html__('If you like to build your %1$s single page by your own choose "Custom Template" else choose one of the predefined templates created using "Directory Single Page Template". Get Admin support to build your "Custom Template"','dtdr-lite'), $listing_singular_label ).'</div>';
		}

	$output .= '</div>';


	return $output;

}
?>