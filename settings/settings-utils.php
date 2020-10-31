<?php

// Save General Options
add_action( 'wp_ajax_dtdr_save_options_settings', 'dtdr_save_options_settings' );
add_action( 'wp_ajax_nopriv_dtdr_save_options_settings', 'dtdr_save_options_settings' );
function dtdr_save_options_settings() {

	$dtdr_settings_options = $_REQUEST;

	$settings = $dtdr_settings_options['settings'];

	$dtdr_settings = get_option('dtdr-settings');

	$dtdr_settings[$settings] = $dtdr_settings_options['dtdr'][$settings];
	$dtdr_settings['plugin-status'] = 'activated';

	if (get_option('dtdr-settings') != $dtdr_settings) {
		if (update_option('dtdr-settings', $dtdr_settings)) {
			echo esc_html__('Options have been updated successfully!','dtdr-lite');
		}
	} else {
		echo esc_html__('No changes done!','dtdr-lite');
	}

	die();

}

// Save Skin Settings
add_action( 'wp_ajax_dtdr_save_skin_settings', 'dtdr_save_skin_settings' );
add_action( 'wp_ajax_nopriv_dtdr_save_skin_settings', 'dtdr_save_skin_settings' );
function dtdr_save_skin_settings() {

	$dtdr_skin_settings = $_REQUEST['dtdr-skin-settings'];

	update_option('dtdr-skin-settings', $dtdr_skin_settings);

	echo esc_html__('"Skin" settings have been updated successfully!','dtdr-lite');

	die();

}

// Import Settings
add_action( 'wp_ajax_dtdr_process_imported_file', 'dtdr_process_imported_file' );
add_action( 'wp_ajax_nopriv_dtdr_process_imported_file', 'dtdr_process_imported_file' );
function dtdr_process_imported_file() {

	require_once DTDR_LITE_PLUGIN_PATH . 'settings/simplexlsx.class.php';

	if( $xlsx = SimpleXLSX::parse( DTDR_LITE_PLUGIN_PATH . 'import/listings.xlsx' ) ) {

		$xlsx_rows = $xlsx->rows();

		$i = 0;
		foreach($xlsx_rows as $xlsx_row) {

			if($i > 0) {

				// Extract datas

				$title                    = $xlsx_row[0];
				$mls_num                  = $xlsx_row[1];
				$incharge_ids             = $xlsx_row[2];
				$currency_symbol          = $xlsx_row[3];
				$currency_symbol_position = $xlsx_row[4];
				$regular_place            = $xlsx_row[5];
				$sale_price               = $xlsx_row[6];
				$before_price_label       = $xlsx_row[7];
				$after_price_label        = $xlsx_row[8];
				$map_image                = $xlsx_row[9];
				$address                  = $xlsx_row[10];
				$zip                      = $xlsx_row[11];
				$country                  = $xlsx_row[12];
				$latitude                 = $xlsx_row[13];
				$longitude                = $xlsx_row[14];
				$media_gallery            = $xlsx_row[15];
				$media_video              = $xlsx_row[16];
				$media_attachments        = $xlsx_row[17];
				$virtual_tour             = $xlsx_row[18];
				$features                 = $xlsx_row[19];
				$floor_plans              = $xlsx_row[20];

				$start_date               = $xlsx_row[21];
				$end_date                 = $xlsx_row[22];
				$start_time               = $xlsx_row[23];
				$end_time                 = $xlsx_row[24];
				$t4hr_format              = $xlsx_row[25];

				$business_hours           = $xlsx_row[26];
				$business_hours_format    = $xlsx_row[27];

				$email                    = $xlsx_row[28];
				$phone                    = $xlsx_row[29];
				$mobile                   = $xlsx_row[30];
				$skype                    = $xlsx_row[31];
				$website                  = $xlsx_row[32];
				$social_details           = $xlsx_row[33];
				$featured_image           = $xlsx_row[34];
				$categories               = $xlsx_row[35];
				$cities                   = $xlsx_row[36];
				$neighborhoods            = $xlsx_row[37];
				$counties_states          = $xlsx_row[38];
				$contract_types           = $xlsx_row[39];
				$amenities                = $xlsx_row[40];


				if($incharge_ids != '') {
					$incharge_ids = explode(',', $incharge_ids);
				}

				if($media_gallery != '') {
					$media_gallery = explode(',', $media_gallery);
				}

				// Media Attachments
				$attachment_titles = $attachment_items = array ();
				if($media_attachments != '') {
					$media_attachments = explode('|', $media_attachments);
					foreach($media_attachments as $media_attachment) {
						$mediaattachment = explode('+', $media_attachment);
						array_push($attachment_titles, $mediaattachment[0]);
						array_push($attachment_items, $mediaattachment[1]);
					}
				}

				// Features
				$features_title = $features_subtitle = $features_value = $features_valueunit = $features_icon = $features_image = $features_default_item = array ();
				if($features != '') {
					$features = explode('|', $features);
					foreach($features as $feature) {
						$feature_item = explode('+', $feature);
						array_push($features_title, $feature_item[0]);
						array_push($features_subtitle, $feature_item[1]);
						array_push($features_value, $feature_item[2]);
						array_push($features_valueunit, $feature_item[3]);
						array_push($features_icon, $feature_item[4]);
						array_push($features_image, $feature_item[5]);
						array_push($features_default_item, $feature_item[6]);
					}
				}

				// Floor Plan
				$floorplans_title = $floorplans_description = $floorplans_image = $floorplans_size = $floorplans_rooms = $floorplans_baths = $floorplans_price = array ();
				if($floor_plans != '') {
					$floor_plans = explode('|', $floor_plans);
					foreach($floor_plans as $floor_plan) {
						$floor_plan_item = explode('+', $floor_plan);
						array_push($floorplans_title, $floor_plan_item[0]);
						array_push($floorplans_description, $floor_plan_item[1]);
						array_push($floorplans_image, $floor_plan_item[2]);
						array_push($floorplans_size, $floor_plan_item[3]);
						array_push($floorplans_rooms, $floor_plan_item[4]);
						array_push($floorplans_baths, $floor_plan_item[5]);
						array_push($floorplans_price, $floor_plan_item[6]);
					}
				}

				// Business Hours
				$business_hours_customized = array ();
				if($business_hours != '') {
					$business_hours = explode('|', $business_hours);
					foreach($business_hours as $business_hour) {

						$business_hour_item = explode('+', $business_hour);
						if(in_array($business_hour_item[0], array ('sunday','monday','tuesday','wednesday','thursday','friday','saturday'))) {
							$business_hours_customized[$business_hour_item[0]]['start_time'] = $business_hour_item[1];
							$business_hours_customized[$business_hour_item[0]]['end_time']   = $business_hour_item[2];
						}

					}
				}

				// Social Details
				$social_items = $social_values = array ();
				if($social_details != '') {
					$social_details = explode('|', $social_details);
					foreach($social_details as $social_detail) {
						$socialdetail = explode('+', $social_detail);
						array_push($social_items, $socialdetail[0]);
						array_push($social_values, $socialdetail[1]);
					}
				}

				// Categories
				if($categories != '') {
					$categories = explode(',', $categories);
				}

				// Cities
				if($cities != '') {
					$cities = explode(',', $cities);
				}

				// Neighborhoods
				if($neighborhoods != '') {
					$neighborhoods = explode(',', $neighborhoods);
				}

				// Counties / States
				if($counties_states != '') {
					$counties_states = explode(',', $counties_states);
				}

				// Contract Types
				if($contract_types != '') {
					$contract_types = explode(',', $contract_types);
				}

				// Amenities
				if($amenities != '') {
					$amenities = explode(',', $amenities);
				}


				// Inser Post

				$listings_post = array (
					'post_title'   => $title,
					'post_status'  => 'publish',
					'post_type'    => 'dtdr_listings',
				);
				$listing_id = wp_insert_post($listings_post);


				if(isset($listing_id) && $listing_id > 0) {

					// MLS Number

					if($mls_num != '') {
						update_post_meta ( $listing_id, 'dtdr_mls_number', dtdr_wp_kses($mls_num) );
					}

					// Incharges

					if(!empty($incharge_ids)) {
						update_post_meta ( $listing_id, 'dtdr_incharges', dtdr_wp_kses($incharge_ids) );
					}

					//Features

					if(!empty($features_title)) {
						update_post_meta ( $listing_id, 'dtdr_features_title', dtdr_wp_kses($features_title) );
					}

					if(!empty($features_subtitle)) {
						update_post_meta ( $listing_id, 'dtdr_features_subtitle', dtdr_wp_kses($features_subtitle) );
					}

					if(!empty($features_value)) {
						update_post_meta ( $listing_id, 'dtdr_features_value', dtdr_wp_kses($features_value) );
					}

					if(!empty($features_valueunit)) {
						update_post_meta ( $listing_id, 'dtdr_features_valueunit', dtdr_wp_kses($features_valueunit) );
					}

					if(!empty($features_icon)) {
						update_post_meta ( $listing_id, 'dtdr_features_icon', dtdr_wp_kses($features_icon) );
					}

					if(!empty($features_image)) {
						update_post_meta ( $listing_id, 'dtdr_features_image', dtdr_wp_kses($features_image) );
					}

					// Event

					if(!empty($start_date)) {
						update_post_meta ( $listing_id, 'dtdr_start_date', dtdr_wp_kses($start_date) );
						$dtdr_start_date_compare_format = date('Ymd', strtotime($start_date));
						update_post_meta ( $listing_id, 'dtdr_start_date_compare_format', dtdr_wp_kses($dtdr_start_date_compare_format) );
					}

					if(!empty($end_date)) {
						update_post_meta ( $listing_id, 'dtdr_end_date', dtdr_wp_kses($end_date) );
					}

					if(!empty($start_time)) {
						update_post_meta ( $listing_id, 'dtdr_start_time', dtdr_wp_kses($start_time) );
					}

					if(!empty($end_time)) {
						update_post_meta ( $listing_id, 'dtdr_end_time', dtdr_wp_kses($end_time) );
					}

					if($t4hr_format || $t4hr_format == 'true') {
						update_post_meta ( $listing_id, 'dtdr_24_hour_format', 'true' );
					}

					// Business Hours

					if(!empty($business_hours_customized)) {
						update_post_meta ( $listing_id, 'dtdr_business_hours', dtdr_wp_kses($business_hours_customized) );
					}

					if($business_hours_format || $business_hours_format == 'true') {
						update_post_meta ( $listing_id, 'dtdr_business_hours_24hour_format', dtdr_wp_kses($business_hours_format) );
					}

					// Email

					if($email != '') {
						update_post_meta ( $listing_id, 'dtdr_email', dtdr_wp_kses($email) );
					}

					// Phone

					if($phone != '') {
						update_post_meta ( $listing_id, 'dtdr_phone', dtdr_wp_kses($phone) );
					}

					// Mobile

					if($mobile != '') {
						update_post_meta ( $listing_id, 'dtdr_mobile', dtdr_wp_kses($mobile) );
					}

					// Skype

					if($skype != '') {
						update_post_meta ( $listing_id, 'dtdr_skype', dtdr_wp_kses($skype) );
					}

					// Website

					if($website != '') {
						update_post_meta ( $listing_id, 'dtdr_website', dtdr_wp_kses($website) );
					}

					// Social Details

					if(!empty($social_items)) {
						update_post_meta ( $listing_id, 'dtdr_social_items', dtdr_wp_kses($social_items) );
					}

					if(!empty($social_values)) {
						update_post_meta ( $listing_id, 'dtdr_social_items_value', dtdr_wp_kses($social_values) );
					}

					// Featured Image

					if($featured_image != '') {
						set_post_thumbnail ( $listing_id, $featured_image );
					}

					// Categories

					if(!empty($categories)) {
						$categories = array_map( 'intval', $categories );
						$categories = array_unique( $categories );
						wp_set_object_terms ( $listing_id, $categories, 'dtdr_listings_category' );
					}

					// Cities

					if(!empty($cities)) {
						$cities = array_map( 'intval', $cities );
						$cities = array_unique( $cities );
					}

					// Neighborhood

					if(!empty($neighborhoods)) {
						$neighborhoods = array_map( 'intval', $neighborhoods );
						$neighborhoods = array_unique( $neighborhoods );
					}

					// Counties / States

					if(!empty($counties_states)) {
						$counties_states = array_map( 'intval', $counties_states );
						$counties_states = array_unique( $counties_states );
					}

					// Contract Types

					if(!empty($contract_types)) {
						$contract_types = array_map( 'intval', $contract_types );
						$contract_types = array_unique( $contract_types );
						wp_set_object_terms ( $listing_id, $contract_types, 'dtdr_listings_ctype' );
					}

					// Amenities

					if(!empty($amenities)) {
						$amenities = array_map( 'intval', $amenities );
						$amenities = array_unique( $amenities );
						wp_set_object_terms ( $listing_id, $amenities, 'dtdr_listings_amenity' );
					}


					// Add or Update listing from modules
					$content = array (
						'dtdr_media_images_ids'         => $media_gallery,
						'dtdr_media_video'              => $media_video,

						'dtdr_media_attachments_titles' => $attachment_titles,
						'dtdr_media_attachments_items'  => $attachment_items,

						'dtdr_floorplan_title'          => $floorplans_title,
						'dtdr_floorplan_description'    => $floorplans_description,
						'dtdr_floorplan_image'          => $floorplans_image,
						'dtdr_floorplan_size'           => $floorplans_size,
						'dtdr_floorplan_rooms'          => $floorplans_rooms,
						'dtdr_floorplan_baths'          => $floorplans_baths,
						'dtdr_floorplan_price'          => $floorplans_price,

						'dtdr_start_date'               => $start_date,
						'dtdr_end_date'                 => $end_date,
						'dtdr_start_time'               => $start_time,
						'dtdr_end_time'                 => $end_time,
						'dtdr_24_hour_format'           => $t4hr_format,

						'dtdr_map_image'                => $map_image,
						'dtdr_address'                  => $address,
						'dtdr_zip'                      => $zip,
						'dtdr_country'                  => $country,
						'dtdr_latitude'                 => $latitude,
						'dtdr_longitude'                => $longitude,
						'dtdr_virtual_tour'             => $virtual_tour,

						'dtdr_city'                     => $cities,
						'dtdr_neighborhood'             => $neighborhoods,
						'dtdr_countystate'              => $counties_states,

						'dtdr_currency_symbol'          => $currency_symbol,
						'dtdr_currency_symbol_position' => $currency_symbol_position,
						'_regular_price'                => $regular_place,
						'_sale_price'                   => $sale_price,
						'dtdr_before_price_label'       => $before_price_label,
						'dtdr_after_price_label'        => $after_price_label
					);
					do_action('dtdr_addorupdate_listing_module', $content, $listing_id);

				}

			}

			$i++;

		}

		echo '<div class="dtdr-note"><strong>'.esc_html__('Data imported successfully!', 'dt_themes').'</strong></div>';

	} else {

		echo SimpleXLSX::parse_error();

	}

	die();

}


// Listing Label
if(!function_exists('dtdr_get_listing_label')) {
	function dtdr_get_listing_label($label_type) {

	    if($label_type == 'singular') {
	    	$label = dtdr_option('label', 'listing-singular-label');
	    }

	    if($label_type == 'plural') {
	    	$label = dtdr_option('label', 'listing-plural-label');
	    }


	    return $label;

	}
	add_filter( 'listing_label', 'dtdr_get_listing_label', 10, 1 );
}

// Contract Type Label
if(!function_exists('dtdr_get_contracttype_label')) {
	function dtdr_get_contracttype_label($label_type) {

	    if($label_type == 'singular') {
	    	$label = dtdr_option('label','contracttype-singular-label');
	    }

	    if($label_type == 'plural') {
	    	$label = dtdr_option('label','contracttype-plural-label');
	    }

	    return $label;

	}
	add_filter( 'contracttype_label', 'dtdr_get_contracttype_label', 10, 1 );
}

// Amenity Label
if(!function_exists('dtdr_get_amenity_label')) {
	function dtdr_get_amenity_label($label_type) {

	    if($label_type == 'singular') {
	    	$label = dtdr_option('label','amenity-singular-label');
	    }

	    if($label_type == 'plural') {
	    	$label = dtdr_option('label','amenity-plural-label');
	    }

	    return $label;

	}
	add_filter( 'amenity_label', 'dtdr_get_amenity_label', 10, 1 );
}

// Seller Label
if(!function_exists('dtdr_get_seller_label')) {
	function dtdr_get_seller_label($label_type) {

	    if($label_type == 'singular') {
	    	$label = dtdr_option('label','seller-singular-label');
	    }

	    if($label_type == 'plural') {
	    	$label = dtdr_option('label','seller-plural-label');
	    }

	    return $label;

	}
	add_filter( 'seller_label', 'dtdr_get_seller_label', 10, 1 );
}

// Incharge Label
if(!function_exists('dtdr_get_incharge_label')) {
	function dtdr_get_incharge_label($label_type) {

	    if($label_type == 'singular') {
	    	$label = dtdr_option('label','incharge-singular-label');
	    }

	    if($label_type == 'plural') {
	    	$label = dtdr_option('label','incharge-plural-label');
	    }

	    return $label;

	}
	add_filter( 'incharge_label', 'dtdr_get_incharge_label', 10, 1 );
}

?>