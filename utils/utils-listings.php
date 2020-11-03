<?php

// Frontend Listing - Search Filter

add_action( 'wp_ajax_dtdr_generate_load_search_data_ouput', 'dtdr_generate_load_search_data_ouput' );
add_action( 'wp_ajax_nopriv_dtdr_generate_load_search_data_ouput', 'dtdr_generate_load_search_data_ouput' );
function dtdr_generate_load_search_data_ouput() {

	// Pagination script Start
	$current_page = isset($_REQUEST['current_page']) ? sanitize_text_field($_REQUEST['current_page']) : 1;
	$offset = isset($_REQUEST['offset']) ? sanitize_text_field($_REQUEST['offset']) : 0;
	$post_per_page =  isset($_REQUEST['post_per_page']) ? sanitize_text_field($_REQUEST['post_per_page']) : -1;
	// Pagination script End


	// Default options
	$type = (isset($_REQUEST['type']) && $_REQUEST['type'] != '') ? sanitize_text_field($_REQUEST['type']) : 'type1';
	$gallery = (isset($_REQUEST['gallery']) && $_REQUEST['gallery'] != '') ? sanitize_text_field($_REQUEST['gallery']) : 'featured_image';
	$columns =  isset($_REQUEST['columns']) ? sanitize_text_field($_REQUEST['columns']) : 1;

	// Location options
	$user_latitude = sanitize_text_field($_REQUEST['user_latitude']);
	$user_longitude = sanitize_text_field($_REQUEST['user_longitude']);

	// Radius options
	$use_radius = sanitize_text_field($_REQUEST['use_radius']);
	$radius = sanitize_text_field($_REQUEST['radius']);
	$radius_unit = sanitize_text_field($_REQUEST['radius_unit']);

	// Carousel
	$enable_carousel = (isset($_REQUEST['enable_carousel']) && $_REQUEST['enable_carousel'] == 'true') ? true: false;

	// Featured Items
	$featured_items = (isset($_REQUEST['featured_items']) && $_REQUEST['featured_items'] == 'true') ? true: false;

	// Ad Items
	$ad_items = (isset($_REQUEST['ad_items']) && $_REQUEST['ad_items'] != '') ? sanitize_text_field($_REQUEST['ad_items']) : '';

	// Ad Location
	$ad_location = (isset($_REQUEST['ad_location']) && $_REQUEST['ad_location'] != '') ? sanitize_text_field($_REQUEST['ad_location']) : '';

	// Single Post Id
	$single_post_id = (isset($_REQUEST['single_post_id']) && $_REQUEST['single_post_id'] != '') ? sanitize_text_field($_REQUEST['single_post_id']) : '';

	// Excerpt Length
	$excerpt_length = (isset($_REQUEST['excerpt_length']) && !empty($_REQUEST['excerpt_length'])) ? sanitize_text_field($_REQUEST['excerpt_length']) : 20;

	// Features Image or Icon
	$features_image_or_icon = (isset($_REQUEST['features_image_or_icon']) && !empty($_REQUEST['features_image_or_icon'])) ? sanitize_text_field($_REQUEST['features_image_or_icon']) :'';

	// Features Count
	$features_include = (isset($_REQUEST['features_include']) && !empty($_REQUEST['features_include'])) ? sanitize_text_field($_REQUEST['features_include']) : '';

	// Custom Options
	$custom_options = json_decode(stripslashes(sanitize_text_field($_REQUEST['custom_options'])), true);

	// Updating Custom Options with Price fields
	$pricerange_start = isset($_REQUEST['pricerange_start']) ? sanitize_text_field($_REQUEST['pricerange_start']) : '';
	$pricerange_end = isset($_REQUEST['pricerange_end']) ? sanitize_text_field($_REQUEST['pricerange_end']) : '';

	$custom_options['pricerange_start'] = $pricerange_start;
	$custom_options['pricerange_end']   = $pricerange_end;


	// Query to retrieve data based on filter options

	$args = array (
		'posts_per_page' => -1,
		'post_type'      => 'dtdr_listings',
		'meta_query'     => array (),
		'tax_query'      => array (),
		'post_status'    => 'publish'
	);

	// Keyword Filter
	$keyword = isset($_REQUEST['keyword']) ? sanitize_text_field($_REQUEST['keyword']) : '';
	if($keyword != '') {
		$args['s'] = $keyword;
	}

	// List Item Ids
	$list_items = isset($_REQUEST['list_items']) ? dtdr_sanitize_fields($_REQUEST['list_items']) : '';
	if(!empty($list_items)) {
		$args['post__in'] = $list_items;
	}

	// Category Filter
	$categories = isset($_REQUEST['categories']) ? dtdr_sanitize_fields($_REQUEST['categories']) : '';
	if(!empty($categories)) {
		$args['tax_query'][] = array (
			'taxonomy' => 'dtdr_listings_category',
			'field'    => 'id',
			'terms'    => $categories,
			'operator' => 'IN'
		);
	}

	// Tags Filter
	$tags = isset($_REQUEST['tags']) ? dtdr_sanitize_fields($_REQUEST['tags']) : '';
	if(!empty($tags)) {
		$args['tax_query'][] = array (
			'taxonomy' => 'dtdr_listings_amenity',
			'field'    => 'id',
			'terms'    => $tags,
			'operator' => 'IN'
		);
	}

	// Cities Filter
	$cities = isset($_REQUEST['cities']) ? dtdr_sanitize_fields($_REQUEST['cities']) : '';
	if(!empty($cities)) {
		$args['tax_query'][] = array (
			'taxonomy' => 'dtdr_listings_city',
			'field'    => 'id',
			'terms'    => $cities,
			'operator' => 'IN'
		);
	}

	// Neighborhood Filter
	$neighborhood = isset($_REQUEST['neighborhood']) ? dtdr_sanitize_fields($_REQUEST['neighborhood']) : '';
	if(!empty($neighborhood)) {
		$args['tax_query'][] = array (
			'taxonomy' => 'dtdr_listings_neighborhood',
			'field'    => 'id',
			'terms'    => $neighborhood,
			'operator' => 'IN'
		);
	}

	// Counties / States Filter
	$countystate = isset($_REQUEST['countystate']) ? dtdr_sanitize_fields($_REQUEST['countystate']) : '';
	if(!empty($countystate)) {
		$args['tax_query'][] = array (
			'taxonomy' => 'dtdr_listings_countystate',
			'field' => 'id',
			'terms' => $countystate,
			'operator' => 'IN'
		);
	}

	// Countries
	$countries = isset($_REQUEST['countries']) ? dtdr_sanitize_fields($_REQUEST['countries']) : '';
	if(!empty($countries)) {
		$args['meta_query'][] = array (
			'key'     => 'dtdr_country',
			'value'   => $countries,
			'compare' => 'IN'
		);
	}

	// Contract Types
	$ctype = isset($_REQUEST['ctype']) ? dtdr_sanitize_fields($_REQUEST['ctype']) : '';
	if(!empty($ctype)) {
		$args['tax_query'][] = array (
			'taxonomy' => 'dtdr_listings_ctype',
			'field'    => 'id',
			'terms'    => $ctype,
			'operator' => 'IN'
		);
	}

	// Start Date
	$startdate = isset($_REQUEST['startdate']) ? sanitize_text_field($_REQUEST['startdate']) : '';
	if($startdate != '') {
		$date_to_compare = date('Ymd', strtotime($startdate));
		$args['meta_query'][] = array (
			'key'     => 'dtdr_start_date_compare_format',
			'value'   => $date_to_compare,
			'compare' => '>=',
		);
	}

	// Features
	$use_features_query   = '';
	$features_compare_id  = 0;
	$features_start       = 20;
	$features_end         = 60;
	$features_query       = isset($_REQUEST['features_query']) ? dtdr_sanitize_fields($_REQUEST['features_query']) : array ();
	$features_total_query = isset($_REQUEST['features_total_query']) ? sanitize_text_field($_REQUEST['features_total_query']) : 0;
	if(is_array($features_query) && !empty($features_query)) {
		$use_features_query = 'true';
	}


	// Sellers
	$sellers = isset($_REQUEST['sellers']) ? dtdr_sanitize_fields($_REQUEST['sellers']) : array ();
	if(!empty($sellers)) {

		// Includes all sellers incharges post
		foreach($sellers as $seller) {
			$seller_incharges = get_users ( array ('role' => 'incharge', 'meta_key' => 'user_seller', 'meta_value' => $seller, 'fields' => 'ID') );
			$sellers = array_merge($sellers, $seller_incharges);
		}

	}

	// Incharges
	$incharges = isset($_REQUEST['incharges']) ? dtdr_sanitize_fields($_REQUEST['incharges']) : array ();

	$authors_in = array ();
	if(!empty($sellers) && !empty($incharges)) {
		$authors_in = array_merge($sellers, $incharges);
	} else if(!empty($sellers)) {
		$authors_in = $sellers;
	} else if(!empty($incharges)) {

		$incharge_arg = array ();
		foreach($incharges as $incharge) {
			$incharge_arg[] = array (
				'key'     => 'dtdr_incharges',
				'value'   => $incharge,
				'compare' => 'LIKE'
			);
		}

		if(count($incharges) > 1) {
			$incharge_cond_arg = array (
				'relation' => 'OR'
			);
			$incharge_final_arg = array_merge($incharge_cond_arg, $incharge_arg);
			$args['meta_query'][] = $incharge_final_arg;
		} else {
			$args['meta_query'][] = $incharge_arg;
		}

	}

	if(!empty($authors_in)) {
		$args['author__in'] = $authors_in;
	}


	// Order By
	$orderby = isset($_REQUEST['orderby']) ? sanitize_text_field($_REQUEST['orderby']) : '';
	if($orderby == 'alphabetical') {

		$args['orderby'] = 'title';
		$args['order'] = 'ASC';

	} else if($orderby == 'highest-rated') {

		$args['orderby'] = 'meta_value_num';
		$args['meta_key'] = 'dtdr_average_ratings';

	} else if($orderby == 'most-reviewed') {

		$args['orderby'] = 'comment_count';

	} else if($orderby == 'most-viewed') {

		$args['orderby'] = 'meta_value_num';
		$args['meta_key'] = 'dtdr_total_views';

	}

	// Featured Items
	if($featured_items) {
		$args['meta_query'][] = array (
			'key'     => 'dtdr_featured_item',
			'value'   => 'true',
			'compare' => '=',
		);
	}

	// MLS Number Filter
	$mls_number = isset($_REQUEST['mls_number']) ? sanitize_text_field($_REQUEST['mls_number']) : '';
	if($mls_number != '') {
		$args['meta_query'][] = array (
			'key'     => 'dtdr_mls_number',
			'value'   => $mls_number,
			'compare' => 'LIKE',
		);
	}

	// To modify arguments from modules
	$args = apply_filters('dtdr_modify_listings_args_from_modules', $args, $custom_options);

	// Others
	$use_opennow_query = '';
	$others = (isset($_REQUEST['others']) && !empty($_REQUEST['others'])) ? dtdr_sanitize_fields($_REQUEST['others']) : array ();
	if(in_array ('opennow', $others)) {
		$use_opennow_query = 'true';
	}


	// Configure settings

	$filtered_item_ids = array ();

	$listings_filtered_query = new WP_Query( $args );

	if ( $listings_filtered_query->have_posts() ) :

		$i = 1;
		while ( $listings_filtered_query->have_posts() ) :
			$listings_filtered_query->the_post();

			$listing_id = get_the_ID();

			// Filtering listings

				$dtdr_latitude = get_post_meta($listing_id, 'dtdr_latitude', true);
				$dtdr_longitude = get_post_meta($listing_id, 'dtdr_longitude', true);

				$radius_filter_enabled   = $radius_filter = false;
				$features_filter_enabled = $features_filter = false;
				$opennow_filter_enabled  = $opennow_filter = false;


			// Radius Filter

				if($use_radius == 'true') {

					$radius_calculated = dtdr_calculate_distance_between_location($user_latitude, $user_longitude, $dtdr_latitude, $dtdr_longitude, $radius_unit);

					if($radius_calculated > -1 && $radius_calculated < $radius) {
						$radius_filter = true;
					}

					$radius_filter_enabled = true;

				}


			// Features Filter

				if($use_features_query == 'true') {

					$filtered_featured_custom_item_ids  = array ();

					foreach($features_query as $feature_query_key => $feature_query) {

						$dtdr_features_value = get_post_meta($listing_id, 'dtdr_features_value', true);
						$item_feature_value = isset($dtdr_features_value[$feature_query_key]) ? $dtdr_features_value[$feature_query_key] : -1;

						if($feature_query['field_type'] == 'range') {

							if($item_feature_value >= $feature_query['start'] && $item_feature_value <= $feature_query['end']) {
								array_push($filtered_featured_custom_item_ids, $listing_id);
							}

						} else if($feature_query['field_type'] == 'dropdown' || $feature_query['field_type'] == 'list') {

							if(isset($feature_query['item_values']) && in_array($item_feature_value, $feature_query['item_values'])) {
								array_push($filtered_featured_custom_item_ids, $listing_id);
							}

						}

					}

					if($features_total_query == count($filtered_featured_custom_item_ids)) {
						$features_filter = true;
					}

					$features_filter_enabled = true;

				}

			// Open Now Filter

				if($use_opennow_query == 'true') {

					$dtdr_business_hours  = get_post_meta($listing_id, 'dtdr_business_hours', true);

					$start_time = $dtdr_business_hours[strtolower(date('l'))]['start_time'][0];
					$end_time = $dtdr_business_hours[strtolower(date('l'))]['end_time'][0];

					if(isset($start_time) && !empty($start_time)) {

						$start_time = strtotime($start_time);
						$end_time = strtotime($end_time);

						$current_timestamp = current_time( 'timestamp' );

						if (($current_timestamp > $start_time) && ($current_timestamp < $end_time)) {
							$opennow_filter = true;
						}

					}

					$opennow_filter_enabled = true;

				}

			// Filter Combination

				if($radius_filter_enabled || $features_filter_enabled || $opennow_filter_enabled) {

					if(($radius_filter_enabled && $features_filter_enabled && $opennow_filter_enabled) && ($radius_filter && $features_filter && $opennow_filter)) {

						array_push($filtered_item_ids, $listing_id);

					} else if(($radius_filter_enabled && !$features_filter_enabled && !$opennow_filter_enabled) && ($radius_filter)) {

						array_push($filtered_item_ids, $listing_id);

					} else if((!$radius_filter_enabled && $features_filter_enabled && !$opennow_filter_enabled) && ($features_filter)) {

						array_push($filtered_item_ids, $listing_id);

					} else if((!$radius_filter_enabled && !$features_filter_enabled && $opennow_filter_enabled) && ($opennow_filter)) {

						array_push($filtered_item_ids, $listing_id);

					} else if(($radius_filter_enabled && $features_filter_enabled && !$opennow_filter_enabled) && ($radius_filter && $features_filter)) {

						array_push($filtered_item_ids, $listing_id);

					} else if(($radius_filter_enabled && !$features_filter_enabled && $opennow_filter_enabled) && ($radius_filter && $opennow_filter)) {

						array_push($filtered_item_ids, $listing_id);

					} else if((!$radius_filter_enabled && $features_filter_enabled && $opennow_filter_enabled) && ($features_filter && $opennow_filter)) {

						array_push($filtered_item_ids, $listing_id);

					}

				} else  {

					array_push($filtered_item_ids, $listing_id);

				}

		endwhile;
		wp_reset_postdata();

	endif;

	// Data Output

	$load_data = (isset($_REQUEST['load_data']) && $_REQUEST['load_data'] == 'true') ? 'true' : '';
	$load_map = (isset($_REQUEST['load_map']) && $_REQUEST['load_map'] == 'true') ? 'true' : '';

	if($load_data == 'true') {

		$apply_isotope = (isset($_REQUEST['apply_isotope']) && $_REQUEST['apply_isotope'] == 'true') ? 'true' : '';
		$isotope_filter = '';
		if($apply_isotope == 'true') {
			$isotope_filter = (isset($_REQUEST['isotope_filter']) && $_REQUEST['isotope_filter'] != '') ? sanitize_text_field($_REQUEST['isotope_filter']) : '';
		}

		$data_result = dtdr_generate_listing_output_loop($filtered_item_ids, $_REQUEST);

	} else if($load_map == 'true') {

		$paginated_item_ids = array ();

		if(!empty($filtered_item_ids)) {

			$args = array (
				'offset'         => $offset,
				'paged'          => $current_page ,
				'posts_per_page' => $post_per_page,
				'post__in'       => $filtered_item_ids,
				'post_type'      => 'dtdr_listings',
				'orderby'        => 'post__in',
				'post_status'    => 'publish'
			);

			$listings_paginated_query = new WP_Query( $args );

			if ( $listings_paginated_query->have_posts() ) :

				$i = 1;
				while ( $listings_paginated_query->have_posts() ) :
					$listings_paginated_query->the_post();

					$listing_id = get_the_ID();

					array_push($paginated_item_ids, $listing_id);

				endwhile;
				wp_reset_postdata();

			endif;

		}

    	$data_result = array (
			'data' => '',
			'dataids' => $paginated_item_ids
		);
	}


    // Print Output
    echo json_encode(array(
		'data' => $data_result['data'],
		'dataids' => $data_result['dataids']
	));

	die();

}

// Frontend Listing - Loop

function dtdr_generate_listing_output_loop($filtered_item_ids, $output_options) {
	// Options
	extract($output_options);

	$enable_carousel = $output_options['enable_carousel'];

	// Query to retrieve data based on pagination
	$paginated_item_ids = array ();
	$content = '';

	if(!empty($filtered_item_ids)) {

		if($columns == 6) {
			$column_class = array ( 'dtdr-column', 'dtdr-one-sixth' );
		} else if($columns == 5) {
			$column_class = array ( 'dtdr-column', 'dtdr-one-fifth' );
		} else if($columns == 4) {
			$column_class = array ( 'dtdr-column', 'dtdr-one-fourth' );
		} else if($columns == 3) {
			$column_class = array ( 'dtdr-column', 'dtdr-one-third' );
		} else if($columns == 2) {
			$column_class = array ( 'dtdr-column', 'dtdr-one-half' );
		} else {
			$column_class = array ( 'dtdr-column', 'dtdr-one-column' );
		}


		$args = array (
			'offset'         => $offset,
			'paged'          => $current_page,
			'posts_per_page' => $post_per_page,
			'post__in'       => $filtered_item_ids,
			'post_type'      => 'dtdr_listings',
			'orderby'        => 'post__in',
			'post_status'    => 'publish'
		);

		$output_options['column_class'] = $column_class;
		if($enable_carousel) {
			$output_options['carousel_class'] = 'swiper-slide';
		} else {
			$output_options['carousel_class'] = '';
		}

		$listings_paginated_query = new WP_Query( $args );

		if ( $listings_paginated_query->have_posts() ) :

			if($apply_isotope == 'true') {
				$content .= '<div class="grid-sizer '.implode(' ', $column_class).'"></div>';
			}

			$i = 1;
			while ( $listings_paginated_query->have_posts() ) :
				$listings_paginated_query->the_post();

				$listing_id = get_the_ID();
				$listing_title = get_the_title();
				$listing_permalink = get_permalink();

				$output_options['listing_id'] = $listing_id;
				$output_options['listing_title'] = $listing_title;
				$output_options['listing_permalink'] = $listing_permalink;


				if($i == 1) { $first_class = 'first';  } else { $first_class = ''; }
				if($i == $columns) { $i = 1; } else { $i = $i + 1; }

				$output_options['first_class'] = $first_class;

				$content .= dtdr_generate_listing_item_html($output_options);

				array_push($paginated_item_ids, $listing_id);

			endwhile;
			wp_reset_postdata();

		else :

			$content .= esc_html__('No records found!','dtdr-lite');

		endif;

		$total_count = $listings_paginated_query->found_posts;

	} else {
		$total_count = 0;
	}


	// Building output html

	$output = '';

	$swiper_wrapper_class = $swiper_container_class = '';
	if($enable_carousel) {
		$swiper_wrapper_class = 'swiper-wrapper';
		$swiper_container_class = 'swiper-container';
	}

	$isotope_class = '';
	if($apply_isotope == 'true') {
		$isotope_class = 'dtdr-listings-item-apply-isotope';
	}

	$output .= '<div class="dtdr-listings-container '.esc_attr($swiper_container_class).' '.esc_attr($isotope_class).'">';

		if($apply_isotope == 'true' && $isotope_filter != '') {

			$apply_child_of = (isset($_REQUEST['apply_child_of']) && $_REQUEST['apply_child_of'] == 'true') ? true : false;

			$filter_items = array ();

			if($isotope_filter == 'category') {

				$tax_args = array ('taxonomy' => 'dtdr_listings_category', 'hide_empty' => 1);

				if(is_array($categories) && !empty($categories)) {
					if($apply_child_of && count($categories) == 1) {
						$tax_args['child_of'] = $categories[0];
					} else {
						$tax_args['include'] = $categories;
					}
				} else {
					$tax_args['parent'] = 0;
				}

				$filter_items = get_categories($tax_args);

			}

			if($isotope_filter == 'contracttype') {

				$tax_args = array ('taxonomy' => 'dtdr_listings_ctype', 'hide_empty' => 1);

				if(is_array($ctype) && !empty($ctype)) {
					if($apply_child_of && count($ctype) == 1) {
						$tax_args['child_of'] = $ctype[0];
					} else {
						$tax_args['include'] = $ctype;
					}
				} else {
					$tax_args['parent'] = 0;
				}

				$filter_items = get_categories($tax_args);

			}

			if(is_array($filter_items) && !empty($filter_items)) {
		        $output .= '<div class="dtdr-listings-item-isotope-filter">';
			        $output .= '<a href="#" class="active-sort" data-filter=".all-sort">'.esc_html__('All','dtdr-lite').'</a>';
            		foreach( $filter_items as $filter_item ) {
                		$output .= '<a href="#" data-filter=".'.esc_attr($filter_item->category_nicename).'-sort">'.esc_html($filter_item->cat_name).'</a>';
                	}
		        $output .= '</div>';
			}

		}

		if($content != '') {

			$output .= '<div class="dtdr-listings-item-container '.esc_attr($swiper_wrapper_class).'">';

				$output .= $content;

			$output .= '</div>';

			if(!$enable_carousel) {

				// Pagination script Start
				$max_num_pages = $listings_paginated_query->max_num_pages;

				$output_options['loader']         = 'true';
				$output_options['loader_parent']  = '.dtdr-listing-output-data-container';

				$output .= dtdr_listing_ajax_pagination($max_num_pages, $current_page, 'dtdr_generate_load_search_data_ouput', 'dtdr-listing-output-data-holder', $output_options);
				// Pagination script End

			}

		} else {

			$output .= '<div class="dtdr-info-box">'.esc_html__('No records found!','dtdr-lite').'</div>';

		}

	$output .= '</div>';


    $output = array (
		'data' => $output,
		'dataids' => $paginated_item_ids
	);

	return $output;

}

// Frontend Listing - Generate Html

function dtdr_generate_listing_item_html($data_listing_attributes) {

	$output = '';

	extract($data_listing_attributes);


	$item_classes = array ('dtdr-listings-item-wrapper');
	array_push($item_classes, $carousel_class);

	if($first_class != '') {
		array_push($column_class, $first_class);
	}

	if($apply_isotope == 'true' && $isotope_filter != '') {

		array_push($column_class, 'all-sort');
		if($isotope_filter == 'category') {
			$tax_items = get_the_terms( $listing_id, 'dtdr_listings_category' );
		} else if($isotope_filter == 'contracttype') {
			$tax_items = get_the_terms( $listing_id, 'dtdr_listings_ctype' );
		}

		if(is_object($tax_items) || is_array($tax_items)) {
			foreach ($tax_items as $tax_item) {
				array_push($column_class, $tax_item->slug.'-sort');
			}
		}

	}

	if($type == 'type9') {
		array_push($item_classes, 'type3 dtdr-list');
	} else if($type == 'type10') {
		array_push($item_classes, 'type5 dtdr-widget-stlye');
	} else {
		array_push($item_classes, $type);
	}

	// Custom HTML update from modules
	$dtdr_listing_custom_html = apply_filters('dtdr_listing_custom_html_from_modules', '', $listing_id);

	// Featured Item Label
	$dtdr_featured_item_html = '';
	$dtdr_featured_item = get_post_meta($listing_id, 'dtdr_featured_item', true);
	if($dtdr_featured_item == 'true') {
		$dtdr_featured_item_html .= '<div class="dtdr-listings-featured-item-container">';
			$dtdr_featured_item_html .= '<a href="'.esc_url( get_permalink($listing_id) ).'">';
				$dtdr_featured_item_html .= '<span>'.esc_html__('Featured','dtdr-lite').'</span>';
			$dtdr_featured_item_html .= '</a>';
		$dtdr_featured_item_html .= '</div>';
	}

	// Excerpt
	$custom_excerpt = dtdr_custom_excerpt($excerpt_length, $listing_id);

	if($apply_isotope == 'true') {
		$output .= '<div class="'.esc_attr( implode(' ', $column_class) ).'">';
			$output .= '<div class="'.esc_attr( implode(' ', get_post_class($item_classes, $listing_id)) ).'">';
	} else {
		$item_classes = array_merge($item_classes, $column_class);
		$output .= '<div class="'.esc_attr( implode(' ', get_post_class($item_classes, $listing_id)) ).'">';
	}

		if($type == 'type1') {

			$output .= '<div class="dtdr-listings-item-top-section">';

				$output .= $dtdr_listing_custom_html;
				$output .= $dtdr_featured_item_html;

				$dtdr_media_images_ids = get_post_meta($listing_id, 'dtdr_media_images_ids', true);
				$gallery_images = (is_array($dtdr_media_images_ids) && !empty($dtdr_media_images_ids)) ? count($dtdr_media_images_ids) : 0;

				$total_images_cnt = $featured_image_cnt = 0;

				$featured_image_id = get_post_thumbnail_id($listing_id);
				if($featured_image_id > 0) {
					$featured_image_cnt = 1;
				}

				if($gallery == 'featured_image') {

					$output .= '<div class="dtdr-listings-item-image-gallery">';
						$output .= do_shortcode('[dtdr_sp_featured_image listing_id="'.esc_attr($listing_id).'" image_size="full" /]');
					$output .= '</div>';

					$total_images_cnt = $featured_image_cnt;

				} else if($gallery == 'image_gallery') {

					$output .= '<div class="dtdr-listings-item-image-gallery">';
						$output .= do_shortcode('[dtdr_sp_media_images listing_id="'.esc_attr($listing_id).'" image_size="full" include_featured_image="false" carousel_paginationtype="" carousel_arrowpagination="true" carousel_loopmode="false" /]');
					$output .= '</div>';

					$total_images_cnt = $gallery_images;

				} else if($gallery == 'gallery_with_featured') {

					$output .= '<div class="dtdr-listings-item-image-gallery">';
						$output .= do_shortcode('[dtdr_sp_media_images listing_id="'.esc_attr($listing_id).'" image_size="full" include_featured_image="true" carousel_loopmode="false" carousel_paginationtype="" carousel_arrowpagination="true" /]');
					$output .= '</div>';

					$total_images_cnt = $gallery_images + $featured_image_cnt;

				}

				$output .= '<div class="dtdr-listings-item-top-section-content">';

					$output .= do_shortcode('[dtdr_sp_taxonomy listing_id="'.esc_attr($listing_id).'" taxonomy="dtdr_listings_category" type="type1" splice="'.esc_attr($no_of_cat_to_display).'" /]');

					$output .= '<div class="dtdr-listings-utils-item-holder">';
						$output .= dtdr_favourite_marker_html($listing_id);
						$output .= '<div class="dtdr-listings-utils-item dtdr-listings-utils-totalimages">';
							$output .= '<div class="dtdr-listings-utils-totalimages-item"><a href="'.esc_url( get_permalink($listing_id) ).'"><span class="far fa-images"></span><p>'.esc_html($total_images_cnt).'</p></a></div>';
						$output .= '</div>';
					$output .= '</div>';

				$output .= '</div>';

			$output .= '</div>';

			$output .= '<div class="dtdr-listings-item-bottom-section">';

				$output .= '<div class="dtdr-listings-item-bottom-section-content">';

					$output .= '<div class="dtdr-listings-item-bottom-left-content">';

						$output .= '<div class="dtdr-listings-item-title">';
							$output .= '<a href="'.esc_url( get_permalink($listing_id) ).'">'.esc_html( get_the_title($listing_id) ).'</a>';
						$output .= '</div>';

						if(shortcode_exists('dtdr_sp_price')) {
							$output .= do_shortcode('[dtdr_sp_price listing_id="'.esc_attr($listing_id).'" type="listing" /]');
						}

					$output .= '</div>';

					$output .= '<div class="dtdr-listings-item-bottom-right-content">';

						$output .= do_shortcode('[dtdr_sp_features listing_id="'.esc_attr($listing_id).'" columns="-1" include="'.esc_attr($features_include).'" type="listing" features_image_or_icon="'.esc_attr($features_image_or_icon).'" /]');

					$output .= '</div>';

					$output .= do_shortcode('[dtdr_sp_contact_details listing_id="'.esc_attr($listing_id).'" include_address="true" type="listing" /]');

					if($custom_excerpt != '') {
						$output .= '<div class="dtdr-listings-excerpt">';

							$output .= '<p>';

								if( get_post_meta($listing_id, 'dtdr_excerpt_title', true) != '' ) {
									$output .= '<span>'.get_post_meta($listing_id, 'dtdr_excerpt_title', true).'</span>';
								}

								$output .= $custom_excerpt;

							$output .= '</p>';

						$output .= '</div>';
					}

					$output .= '<a class="custom-button-style dtdr-listing-view-details" href="'.esc_url( get_permalink($listing_id) ).'">'.esc_html__('View Details','dtdr-lite').'</a>';

				$output .= '</div>';

			$output .= '</div>';

		} else if($type == 'type2') {

			$output .= '<div class="dtdr-listings-item-top-section">';

				$output .= $dtdr_listing_custom_html;
				$output .= $dtdr_featured_item_html;

				if($gallery == 'featured_image') {

					$output .= '<div class="dtdr-listings-item-image-gallery">';
						$output .= do_shortcode('[dtdr_sp_featured_image listing_id="'.esc_attr($listing_id).'" image_size="full" with_link="true" /]');
					$output .= '</div>';

				} else if($gallery == 'image_gallery') {

					$output .= '<div class="dtdr-listings-item-image-gallery">';
						$output .= do_shortcode('[dtdr_sp_media_images listing_id="'.esc_attr($listing_id).'" image_size="full" include_featured_image="false" carousel_paginationtype="" carousel_arrowpagination="true" carousel_loopmode="false" /]');
					$output .= '</div>';

				} else if($gallery == 'gallery_with_featured') {

					$output .= '<div class="dtdr-listings-item-image-gallery">';
						$output .= do_shortcode('[dtdr_sp_media_images listing_id="'.esc_attr($listing_id).'" image_size="full" include_featured_image="true" carousel_loopmode="false" carousel_paginationtype="" carousel_arrowpagination="true" /]');
					$output .= '</div>';

				}

				$output .= do_shortcode('[dtdr_sp_taxonomy listing_id="'.esc_attr($listing_id).'" taxonomy="dtdr_listings_category" type="type2" splice="'.esc_attr($no_of_cat_to_display).'" /]');

			$output .= '</div>';

			$output .= '<div class="dtdr-listings-item-bottom-section">';

				$output .= '<div class="dtdr-listings-item-bottom-section-content">';

					$output .= '<div class="dtdr-listings-item-title">';
						$output .= '<a href="'.esc_url( get_permalink($listing_id) ).'">'.esc_html( get_the_title($listing_id) ).'</a>';
					$output .= '</div>';

					$output .= do_shortcode('[dtdr_sp_contact_details listing_id="'.esc_attr($listing_id).'" include_address="true" type="listing" /]');

					$output .= do_shortcode('[dtdr_sp_features listing_id="'.esc_attr($listing_id).'" columns="-1" include="'.esc_attr($features_include).'" type="listing" features_image_or_icon="'.esc_attr($features_image_or_icon).'" /]');

					if($custom_excerpt != '') {
						$output .= '<div class="dtdr-listings-excerpt">';

							$output .= '<p>';

								if( get_post_meta($listing_id, 'dtdr_excerpt_title', true) != '' ) {
									$output .= '<span>'.get_post_meta($listing_id, 'dtdr_excerpt_title', true).'</span>';
								}

								$output .= $custom_excerpt;

							$output .= '</p>';
						$output .= '</div>';
					}

					$output .= '<div class="dtdr-listings-item-bottom-pricing-holder">';

						if(shortcode_exists('dtdr_sp_price')) {
							$output .= do_shortcode('[dtdr_sp_price listing_id="'.esc_attr($listing_id).'" type="listing" /]');
						}

						$output .= '<a class="custom-button-style dtdr-listing-view-details" href="'.esc_url( get_permalink($listing_id) ).'">'.esc_html__('View Details','dtdr-lite').'</a>';

					$output .= '</div>';

				$output .= '</div>';

			$output .= '</div>';

		} else if($type == 'type3') {

			$output .= '<div class="dtdr-listings-item-top-section">';

				$output .= $dtdr_listing_custom_html;
				$output .= $dtdr_featured_item_html;

				if($gallery == 'featured_image') {

					$output .= '<div class="dtdr-listings-item-image-gallery">';
						$output .= do_shortcode('[dtdr_sp_featured_image listing_id="'.esc_attr($listing_id).'" image_size="full" with_link="true" /]');
					$output .= '</div>';

				} else if($gallery == 'image_gallery') {

					$output .= '<div class="dtdr-listings-item-image-gallery">';
						$output .= do_shortcode('[dtdr_sp_media_images listing_id="'.esc_attr($listing_id).'" image_size="full" include_featured_image="false" carousel_paginationtype="" carousel_arrowpagination="true" carousel_loopmode="false" /]');
					$output .= '</div>';

				} else if($gallery == 'gallery_with_featured') {

					$output .= '<div class="dtdr-listings-item-image-gallery">';
						$output .= do_shortcode('[dtdr_sp_media_images listing_id="'.esc_attr($listing_id).'" image_size="full" include_featured_image="true" carousel_loopmode="false" carousel_paginationtype="" carousel_arrowpagination="true" /]');
					$output .= '</div>';

				}

			$output .= '</div>';

			$output .= '<div class="dtdr-listings-item-bottom-section">';

				$output .= '<div class="dtdr-listings-item-bottom-section-content">';

				$output .= do_shortcode('[dtdr_sp_taxonomy listing_id="'.esc_attr($listing_id).'" taxonomy="dtdr_listings_category" type="type3" splice="'.esc_attr($no_of_cat_to_display).'" /]');

					$output .= '<div class="dtdr-listings-item-title">';
						$output .= '<a href="'.esc_url( get_permalink($listing_id) ).'">'.esc_html( get_the_title($listing_id) ).'</a>';
					$output .= '</div>';

					if(shortcode_exists('dtdr_sp_price')) {
						$output .= '<div class="dtdr-listings-item-bottom-pricing-holder">';
							$output .= do_shortcode('[dtdr_sp_price listing_id="'.esc_attr($listing_id).'" type="listing" /]');
						$output .= '</div>';
					}

					$output .= do_shortcode('[dtdr_sp_contact_details listing_id="'.esc_attr($listing_id).'" include_address="true" type="listing" /]');

					if($custom_excerpt != '') {
						$output .= '<div class="dtdr-listings-excerpt">';

							$output .= '<p>';

								if( get_post_meta($listing_id, 'dtdr_excerpt_title', true) != '' ) {
									$output .= '<span>'.esc_html( get_post_meta($listing_id, 'dtdr_excerpt_title', true) ).'</span>';
								}

								$output .= $custom_excerpt;

							$output .= '</p>';
						$output .= '</div>';
					}

					$output .= do_shortcode('[dtdr_sp_features listing_id="'.esc_attr($listing_id).'" columns="-1" include="'.esc_attr($features_include).'" type="listing" features_image_or_icon="'.esc_attr($features_image_or_icon).'" /]');

					$output .= '<a class="custom-button-style dtdr-listing-view-details" href="'.esc_url( get_permalink($listing_id) ).'">'.esc_html__('View Details','dtdr-lite').'</a>';

				$output .= '</div>';

			$output .= '</div>';

		} else if($type == 'type4') {

			$output .= '<div class="dtdr-listings-item-top-section">';

				$output .= $dtdr_listing_custom_html;
				$output .= $dtdr_featured_item_html;

				$dtdr_media_images_ids = get_post_meta($listing_id, 'dtdr_media_images_ids', true);
				$gallery_images = (is_array($dtdr_media_images_ids) && !empty($dtdr_media_images_ids)) ? count($dtdr_media_images_ids) : 0;

				$total_images_cnt = $featured_image_cnt = 0;

				$featured_image_id = get_post_thumbnail_id($listing_id);
				if($featured_image_id > 0) {
					$featured_image_cnt = 1;
				}

				if($gallery == 'featured_image') {

					$output .= '<div class="dtdr-listings-item-image-gallery">';
						$output .= do_shortcode('[dtdr_sp_featured_image listing_id="'.esc_attr($listing_id).'" image_size="full" /]');
					$output .= '</div>';

					$total_images_cnt = $featured_image_cnt;

				} else if($gallery == 'image_gallery') {

					$output .= '<div class="dtdr-listings-item-image-gallery">';
						$output .= do_shortcode('[dtdr_sp_media_images listing_id="'.esc_attr($listing_id).'" image_size="full" include_featured_image="false" carousel_paginationtype="" carousel_arrowpagination="true" carousel_loopmode="false" /]');
					$output .= '</div>';

					$total_images_cnt = $gallery_images;

				} else if($gallery == 'gallery_with_featured') {

					$output .= '<div class="dtdr-listings-item-image-gallery">';
						$output .= do_shortcode('[dtdr_sp_media_images listing_id="'.esc_attr($listing_id).'" image_size="full" include_featured_image="true" carousel_loopmode="false" carousel_paginationtype="" carousel_arrowpagination="true" /]');
					$output .= '</div>';

					$total_images_cnt = $gallery_images + $featured_image_cnt;

				}

				$output .= '<div class="dtdr-listings-item-top-section-content">';

				$output .= do_shortcode('[dtdr_sp_taxonomy listing_id="'.esc_attr($listing_id).'" taxonomy="dtdr_listings_category" type="type4" splice="'.esc_attr($no_of_cat_to_display).'" /]');

					$output .= '<div class="dtdr-listings-utils-item-holder">';
						$output .= dtdr_favourite_marker_html($listing_id);
						$output .= '<div class="dtdr-listings-utils-item dtdr-listings-utils-totalimages">';
							$output .= '<div class="dtdr-listings-utils-totalimages-item"><a href="'.esc_url( get_permalink($listing_id) ).'"><span class="far fa-images"></span><p>'.esc_html($total_images_cnt).'</p></a></div>';
						$output .= '</div>';
					$output .= '</div>';

				$output .= '</div>';

			$output .= '</div>';

			$output .= '<div class="dtdr-listings-item-bottom-section">';

				$output .= '<div class="dtdr-listings-item-bottom-section-content">';

					$output .= '<div class="dtdr-listings-item-title">';
						$output .= '<a href="'.esc_url( get_permalink($listing_id) ).'">'.esc_html( get_the_title($listing_id) ).'</a>';
					$output .= '</div>';

					$output .= do_shortcode('[dtdr_sp_contact_details listing_id="'.esc_attr($listing_id).'" include_address="true" type="listing" /]');

					if($custom_excerpt != '') {
						$output .= '<div class="dtdr-listings-excerpt">';

							$output .= '<p>';

								if( get_post_meta($listing_id, 'dtdr_excerpt_title', true) != '' ) {
									$output .= '<span>'.esc_html( get_post_meta($listing_id, 'dtdr_excerpt_title', true) ).'</span>';
								}

								$output .= $custom_excerpt;

							$output .= '</p>';
						$output .= '</div>';
					}

					$output .= do_shortcode('[dtdr_sp_features listing_id="'.esc_attr($listing_id).'" columns="-1" include="'.esc_attr($features_include).'" type="listing" features_image_or_icon="'.esc_attr($features_image_or_icon).'" /]');

				$output .= '</div>';

				$output .= '<div class="dtdr-listings-item-bottom-pricing-holder">';

					if(shortcode_exists('dtdr_sp_price')) {
						$output .= do_shortcode('[dtdr_sp_price listing_id="'.esc_attr($listing_id).'" type="listing" /]');
					}

					$output .= '<a class="custom-button-style dtdr-listing-view-details" href="'.esc_url( get_permalink($listing_id) ).'">'.esc_html__('View Details','dtdr-lite').'</a>';

				$output .= '</div>';

			$output .= '</div>';

		} else if($type == 'type5') {

			$output .= '<div class="dtdr-listings-item-top-section">';

				$output .= $dtdr_listing_custom_html;
				$output .= $dtdr_featured_item_html;

				$dtdr_media_images_ids = get_post_meta($listing_id, 'dtdr_media_images_ids', true);
				$gallery_images = (is_array($dtdr_media_images_ids) && !empty($dtdr_media_images_ids)) ? count($dtdr_media_images_ids) : 0;

				$total_images_cnt = $featured_image_cnt = 0;

				$featured_image_id = get_post_thumbnail_id($listing_id);
				if($featured_image_id > 0) {
					$featured_image_cnt = 1;
				}

				if($gallery == 'featured_image') {

					$output .= '<div class="dtdr-listings-item-image-gallery">';
						$output .= do_shortcode('[dtdr_sp_featured_image listing_id="'.esc_attr($listing_id).'" image_size="full" with_link="true" /]');
					$output .= '</div>';

					$total_images_cnt = $featured_image_cnt;

				} else if($gallery == 'image_gallery') {

					$output .= '<div class="dtdr-listings-item-image-gallery">';
						$output .= do_shortcode('[dtdr_sp_media_images listing_id="'.esc_attr($listing_id).'" image_size="full" include_featured_image="false" carousel_paginationtype="" carousel_arrowpagination="true" carousel_loopmode="false" /]');
					$output .= '</div>';

					$total_images_cnt = $gallery_images;

				} else if($gallery == 'gallery_with_featured') {

					$output .= '<div class="dtdr-listings-item-image-gallery">';
						$output .= do_shortcode('[dtdr_sp_media_images listing_id="'.esc_attr($listing_id).'" image_size="full" include_featured_image="true" carousel_loopmode="false" carousel_paginationtype="" carousel_arrowpagination="true" /]');
					$output .= '</div>';

					$total_images_cnt = $gallery_images + $featured_image_cnt;

				}

				$output .= do_shortcode('[dtdr_sp_taxonomy listing_id="'.esc_attr($listing_id).'" taxonomy="dtdr_listings_category" type="type5" splice="'.esc_attr($no_of_cat_to_display).'" /]');

			$output .= '</div>';

			$output .= '<div class="dtdr-listings-item-bottom-section">';

				$output .= '<div class="dtdr-listings-item-bottom-section-content">';

					$output .= '<div class="dtdr-listings-item-bottom-left-content">';

						$output .= '<div class="dtdr-listings-item-title">';
							$output .= '<a href="'.esc_url( get_permalink($listing_id) ).'">'.esc_html( get_the_title($listing_id) ).'</a>';
						$output .= '</div>';

						if(shortcode_exists('dtdr_sp_price')) {
							$output .= '<div class="dtdr-listings-item-bottom-pricing-holder">';
								$output .= do_shortcode('[dtdr_sp_price listing_id="'.esc_attr($listing_id).'" type="listing" /]');
							$output .= '</div>';
						}

					$output .= '</div>';

					$output .= '<div class="dtdr-listings-item-bottom-right-content">';

						$output .= '<div class="dtdr-listings-utils-item-holder">';
							$output .= dtdr_favourite_marker_html($listing_id);
							$output .= '<div class="dtdr-listings-utils-item dtdr-listings-utils-totalimages">';
								$output .= '<div class="dtdr-listings-utils-totalimages-item"><a href="'.esc_url( get_permalink($listing_id) ).'"><span class="far fa-images"></span><p>'.esc_html($total_images_cnt).'</p></a></div>';
							$output .= '</div>';
						$output .= '</div>';

					$output .= '</div>';

				$output .= '</div>';

				$output .= do_shortcode('[dtdr_sp_contact_details listing_id="'.esc_attr($listing_id).'" include_address="true" type="listing" /]');

				if($custom_excerpt != '') {
					$output .= '<div class="dtdr-listings-excerpt">';

						$output .= '<p>';

							if( get_post_meta($listing_id, 'dtdr_excerpt_title', true) != '' ) {
								$output .= '<span>'.esc_html( get_post_meta($listing_id, 'dtdr_excerpt_title', true) ).'</span>';
							}

							$output .= $custom_excerpt;

						$output .= '</p>';
					$output .= '</div>';
				}

				$output .= do_shortcode('[dtdr_sp_features listing_id="'.esc_attr($listing_id).'" columns="-1" include="'.esc_attr($features_include).'" type="listing" features_image_or_icon="'.esc_attr($features_image_or_icon).'" /]');

				$dtdr_latitude  = get_post_meta($listing_id, 'dtdr_latitude', true);
				$dtdr_longitude = get_post_meta($listing_id, 'dtdr_longitude', true);

				$output .= '<a href="//maps.google.com/maps?daddr='.$dtdr_latitude.','.$dtdr_longitude.'" class="custom-button-style  dtdr-listings-address-directions" target="_blank">'.esc_html__('View on Map','dtdr-lite').'</a>';

			$output .= '</div>';

		} else if($type == 'type6') {

			$output .= '<div class="dtdr-listings-item-top-section">';

				$output .= $dtdr_listing_custom_html;
				$output .= $dtdr_featured_item_html;

				if($gallery == 'featured_image') {

					$output .= '<div class="dtdr-listings-item-image-gallery">';
						$output .= do_shortcode('[dtdr_sp_featured_image listing_id="'.esc_attr($listing_id).'" image_size="full" /]');
					$output .= '</div>';

				} else if($gallery == 'image_gallery') {

					$output .= '<div class="dtdr-listings-item-image-gallery">';
						$output .= do_shortcode('[dtdr_sp_media_images listing_id="'.esc_attr($listing_id).'" image_size="full" include_featured_image="false" carousel_paginationtype="" carousel_arrowpagination="true" carousel_loopmode="false" /]');
					$output .= '</div>';

				} else if($gallery == 'gallery_with_featured') {

					$output .= '<div class="dtdr-listings-item-image-gallery">';
						$output .= do_shortcode('[dtdr_sp_media_images listing_id="'.esc_attr($listing_id).'" image_size="full" include_featured_image="true" carousel_loopmode="false" carousel_paginationtype="" carousel_arrowpagination="true" /]');
					$output .= '</div>';

				}

			$output .= '</div>';

			$output .= '<div class="dtdr-listings-item-bottom-section">';

			$output .= do_shortcode('[dtdr_sp_taxonomy listing_id="'.esc_attr($listing_id).'" taxonomy="dtdr_listings_category" type="type6" splice="'.esc_attr($no_of_cat_to_display).'" /]');

				$output .= '<div class="dtdr-listings-item-bottom-section-content">';

					$output .= '<div class="dtdr-listings-item-bottom-left-content">';

						$output .= '<div class="dtdr-listings-item-title">';
							$output .= '<a href="'.esc_url( get_permalink($listing_id) ).'">'.esc_html( get_the_title($listing_id) ).'</a>';
						$output .= '</div>';

						if(shortcode_exists('dtdr_sp_price')) {
							$output .= '<div class="dtdr-listings-item-bottom-pricing-holder">';
								$output .= do_shortcode('[dtdr_sp_price listing_id="'.esc_attr($listing_id).'" type="listing" /]');
							$output .= '</div>';
						}

					$output .= '</div>';

					$output .= '<div class="dtdr-listings-item-bottom-right-content">';

						$output .= do_shortcode('[dtdr_sp_features listing_id="'.esc_attr($listing_id).'" columns="-1" include="'.esc_attr($features_include).'" type="listing" features_image_or_icon="'.esc_attr($features_image_or_icon).'" /]');

					$output .= '</div>';

				$output .= '</div>';

				$output .= '<div class="dtdr-listings-utils-item-holder">';
					$output .= dtdr_favourite_marker_html($listing_id);
				$output .= '</div>';

			$output .= '</div>';

		} else if($type == 'type7') {

			$output .= '<div class="dtdr-listings-item-top-section">';

				$output .= $dtdr_listing_custom_html;
				$output .= $dtdr_featured_item_html;

				$dtdr_media_images_ids = get_post_meta($listing_id, 'dtdr_media_images_ids', true);
				$gallery_images = (is_array($dtdr_media_images_ids) && !empty($dtdr_media_images_ids)) ? count($dtdr_media_images_ids) : 0;

				$total_images_cnt = $featured_image_cnt = 0;

				$featured_image_id = get_post_thumbnail_id($listing_id);
				if($featured_image_id > 0) {
					$featured_image_cnt = 1;
				}

				if($gallery == 'featured_image') {

					$output .= '<div class="dtdr-listings-item-image-gallery">';
						$output .= do_shortcode('[dtdr_sp_featured_image listing_id="'.esc_attr($listing_id).'" image_size="full" with_link="true" /]');
					$output .= '</div>';

					$total_images_cnt = $featured_image_cnt;

				} else if($gallery == 'image_gallery') {

					$output .= '<div class="dtdr-listings-item-image-gallery">';
						$output .= do_shortcode('[dtdr_sp_media_images listing_id="'.esc_attr($listing_id).'" image_size="full" include_featured_image="false" carousel_paginationtype="" carousel_arrowpagination="true" carousel_loopmode="false" /]');
					$output .= '</div>';

					$total_images_cnt = $gallery_images;

				} else if($gallery == 'gallery_with_featured') {

					$output .= '<div class="dtdr-listings-item-image-gallery">';
						$output .= do_shortcode('[dtdr_sp_media_images listing_id="'.esc_attr($listing_id).'" image_size="full" include_featured_image="true" carousel_loopmode="false" carousel_paginationtype="" carousel_arrowpagination="true" /]');
					$output .= '</div>';

					$total_images_cnt = $gallery_images + $featured_image_cnt;

				}

			$output .= '</div>';

			$output .= '<div class="dtdr-listings-item-bottom-section">';

				$output .= '<div class="dtdr-listings-item-title">';
					$output .= '<a href="'.esc_url( get_permalink($listing_id) ).'">'.esc_html( get_the_title($listing_id) ).'</a>';
					$output .= do_shortcode('[dtdr_sp_taxonomy listing_id="'.esc_attr($listing_id).'" taxonomy="dtdr_listings_category" type="type7" splice="'.esc_attr($no_of_cat_to_display).'" /]');
				$output .= '</div>';

				if(shortcode_exists('dtdr_sp_price')) {
					$output .= '<div class="dtdr-listings-item-bottom-pricing-holder">';
						$output .= do_shortcode('[dtdr_sp_price listing_id="'.esc_attr($listing_id).'" type="listing" /]');
					$output .= '</div>';
				}

				if($custom_excerpt != '') {
					$output .= '<div class="dtdr-listings-excerpt">';

						$output .= '<p>';

							$e_title = 	get_post_meta($listing_id, 'dtdr_excerpt_title', true);

							if(  $e_title != '' ) {
								$output .= '<span>'.esc_html( $e_title ).'</span>';
							}

							$output .= $custom_excerpt;

						$output .= '</p>';
					$output .= '</div>';
				}

				$output .= do_shortcode('[dtdr_sp_contact_details listing_id="'.esc_attr($listing_id).'" include_address="true" type="listing" /]');

				$output .= '<div class="dtdr-listings-item-bottom-section-content">';

					$output .= '<div class="dtdr-listings-item-bottom-left-content">';
						$output .= do_shortcode('[dtdr_sp_post_date listing_id="'.esc_attr($listing_id).'" with_label="true" type="listing" /]');
						$output .= do_shortcode('[dtdr_sp_mls_number listing_id="'.esc_attr($listing_id).'" with_label="true" type="listing" /]');
					$output .= '</div>';

					$output .= '<div class="dtdr-listings-item-bottom-right-content">';

						$output .= '<div class="dtdr-listings-utils-item-holder">';
							$output .= dtdr_favourite_marker_html($listing_id);
							$output .= '<div class="dtdr-listings-utils-item dtdr-listings-utils-totalimages">';
								$output .= '<div class="dtdr-listings-utils-totalimages-item"><a href="'.esc_url( get_permalink($listing_id) ).'"><span class="far fa-images"></span><p>'.esc_html($total_images_cnt).'</p></a></div>';
							$output .= '</div>';
						$output .= '</div>';

					$output .= '</div>';

				$output .= '</div>';

			$output .= '</div>';

		} else if($type == 'type8') {

			$output .= '<div class="dtdr-listings-item-top-section">';

				$output .= $dtdr_listing_custom_html;
				$output .= $dtdr_featured_item_html;

				if($gallery == 'featured_image') {

					$output .= '<div class="dtdr-listings-item-image-gallery">';
						$output .= do_shortcode('[dtdr_sp_featured_image listing_id="'.esc_attr($listing_id).'" image_size="full" /]');
					$output .= '</div>';

				} else if($gallery == 'image_gallery') {

					$output .= '<div class="dtdr-listings-item-image-gallery">';
						$output .= do_shortcode('[dtdr_sp_media_images listing_id="'.esc_attr($listing_id).'" image_size="full" include_featured_image="false" carousel_paginationtype="" carousel_arrowpagination="true" carousel_loopmode="false" /]');
					$output .= '</div>';

				} else if($gallery == 'gallery_with_featured') {

					$output .= '<div class="dtdr-listings-item-image-gallery">';
						$output .= do_shortcode('[dtdr_sp_media_images listing_id="'.esc_attr($listing_id).'" image_size="full" include_featured_image="true" carousel_loopmode="false" carousel_paginationtype="" carousel_arrowpagination="true" /]');
					$output .= '</div>';

				}

				$output .= do_shortcode('[dtdr_sp_features listing_id="'.esc_attr($listing_id).'" columns="-1" include="'.esc_attr($features_include).'" type="listing" features_image_or_icon="'.esc_attr($features_image_or_icon).'" /]');

			$output .= '</div>';

			$output .= '<div class="dtdr-listings-item-bottom-section">';

				$output .= '<div class="dtdr-listings-item-bottom-section-content">';

				$output .= do_shortcode('[dtdr_sp_taxonomy listing_id="'.esc_attr($listing_id).'" taxonomy="dtdr_listings_category" type="type8" splice="'.esc_attr($no_of_cat_to_display).'" /]');

					$output .= '<div class="dtdr-listings-item-title">';
						$output .= '<a href="'.esc_url( get_permalink($listing_id) ).'">'.esc_html( get_the_title($listing_id) ).'</a>';
					$output .= '</div>';

					if(shortcode_exists('dtdr_sp_price')) {
						$output .= '<div class="dtdr-listings-item-bottom-pricing-holder">';
							$output .= do_shortcode('[dtdr_sp_price listing_id="'.esc_attr($listing_id).'" type="listing" /]');
						$output .= '</div>';
					}

					if($custom_excerpt != '') {
						$output .= '<div class="dtdr-listings-excerpt">';

							$output .= '<p>';

								$dtdr_excerpt_title = get_post_meta($listing_id, 'dtdr_excerpt_title', true);

								if( $dtdr_excerpt_title != '' ) {
									$output .= '<span>'.esc_html( $dtdr_excerpt_title ).'</span>';
								}

								$output .= $custom_excerpt;

							$output .= '</p>';
						$output .= '</div>';
					}

					$output .= do_shortcode('[dtdr_sp_contact_details listing_id="'.esc_attr($listing_id).'" include_address="true" type="listing" /]');

				$output .= '</div>';

			$output .= '</div>';

		} else if($type == 'type9') {

			$output .= '<div class="dtdr-listings-item-top-section">';

				$output .= $dtdr_listing_custom_html;
				$output .= $dtdr_featured_item_html;

				if($gallery == 'featured_image') {

					$output .= '<div class="dtdr-listings-item-image-gallery">';
						$output .= do_shortcode('[dtdr_sp_featured_image listing_id="'.esc_attr($listing_id).'" image_size="full" with_link="true" /]');
					$output .= '</div>';

				} else if($gallery == 'image_gallery') {

					$output .= '<div class="dtdr-listings-item-image-gallery">';
						$output .= do_shortcode('[dtdr_sp_media_images listing_id="'.esc_attr($listing_id).'" image_size="full" include_featured_image="false" carousel_paginationtype="" carousel_arrowpagination="true" carousel_loopmode="false" /]');
					$output .= '</div>';

				} else if($gallery == 'gallery_with_featured') {

					$output .= '<div class="dtdr-listings-item-image-gallery">';
						$output .= do_shortcode('[dtdr_sp_media_images listing_id="'.esc_attr($listing_id).'" image_size="full" include_featured_image="true" carousel_loopmode="false" carousel_paginationtype="" carousel_arrowpagination="true" /]');
					$output .= '</div>';

				}

			$output .= '</div>';

			$output .= '<div class="dtdr-listings-item-bottom-section">';

				$output .= '<div class="dtdr-listings-item-bottom-section-content">';

				$output .= do_shortcode('[dtdr_sp_taxonomy listing_id="'.esc_attr($listing_id).'" taxonomy="dtdr_listings_category" type="type3" splice="'.esc_attr($no_of_cat_to_display).'" /]');

					$output .= '<div class="dtdr-listings-item-title">';
						$output .= '<a href="'.esc_url( get_permalink($listing_id) ).'">'. esc_html( get_the_title($listing_id) ).'</a>';
					$output .= '</div>';

					if(shortcode_exists('dtdr_sp_price')) {
						$output .= '<div class="dtdr-listings-item-bottom-pricing-holder">';
							$output .= do_shortcode('[dtdr_sp_price listing_id="'.esc_attr($listing_id).'" type="listing" /]');
						$output .= '</div>';
					}

					$output .= do_shortcode('[dtdr_sp_contact_details listing_id="'.esc_attr($listing_id).'" include_address="true" type="listing" /]');

					if($custom_excerpt != '') {
						$output .= '<div class="dtdr-listings-excerpt">';

							$output .= '<p>';

								$dtdr_excerpt_title = get_post_meta($listing_id, 'dtdr_excerpt_title', true);

								if(  $dtdr_excerpt_title != '' ) {
									$output .= '<span>'.$dtdr_excerpt_title.'</span>';
								}

								$output .= $custom_excerpt;

							$output .= '</p>';
						$output .= '</div>';
					}

					$output .= do_shortcode('[dtdr_sp_features listing_id="'.esc_attr($listing_id).'" columns="-1" include="'.esc_attr($features_include).'" type="listing" features_image_or_icon="'.esc_attr($features_image_or_icon).'" /]');

					$output .= '<a class="custom-button-style dtdr-listing-view-details" href="'.esc_url( get_permalink($listing_id) ).'">'.esc_html__('View Details','dtdr-lite').'</a>';

				$output .= '</div>';

			$output .= '</div>';

		} else if($type == 'type10') {

			$output .= '<div class="dtdr-listings-item-top-section">';

				$output .= $dtdr_listing_custom_html;
				$output .= $dtdr_featured_item_html;

				$dtdr_media_images_ids = get_post_meta($listing_id, 'dtdr_media_images_ids', true);
				$gallery_images = (is_array($dtdr_media_images_ids) && !empty($dtdr_media_images_ids)) ? count($dtdr_media_images_ids) : 0;

				$total_images_cnt = $featured_image_cnt = 0;

				$featured_image_id = get_post_thumbnail_id($listing_id);
				if($featured_image_id > 0) {
					$featured_image_cnt = 1;
				}

				if($gallery == 'featured_image') {

					$output .= '<div class="dtdr-listings-item-image-gallery">';
						$output .= do_shortcode('[dtdr_sp_featured_image listing_id="'.esc_attr($listing_id).'" image_size="full" with_link="true" /]');
					$output .= '</div>';

					$total_images_cnt = $featured_image_cnt;

				} else if($gallery == 'image_gallery') {

					$output .= '<div class="dtdr-listings-item-image-gallery">';
						$output .= do_shortcode('[dtdr_sp_media_images listing_id="'.esc_attr($listing_id).'" image_size="full" include_featured_image="false" carousel_paginationtype="" carousel_arrowpagination="true" carousel_loopmode="false" /]');
					$output .= '</div>';

					$total_images_cnt = $gallery_images;

				} else if($gallery == 'gallery_with_featured') {

					$output .= '<div class="dtdr-listings-item-image-gallery">';
						$output .= do_shortcode('[dtdr_sp_media_images listing_id="'.esc_attr($listing_id).'" image_size="full" include_featured_image="true" carousel_loopmode="false" carousel_paginationtype="" carousel_arrowpagination="true" /]');
					$output .= '</div>';

					$total_images_cnt = $gallery_images + $featured_image_cnt;

				}

			$output .= '</div>';

			$output .= '<div class="dtdr-listings-item-bottom-section">';

				$output .= '<div class="dtdr-listings-item-bottom-section-content">';

					$output .= '<div class="dtdr-listings-item-bottom-left-content">';

						$output .= '<div class="dtdr-listings-item-title">';
							$output .= '<a href="'.esc_url( get_permalink($listing_id) ).'">'.esc_html( get_the_title($listing_id) ).'</a>';
						$output .= '</div>';

					$output .= '</div>';

				$output .= '</div>';

				$output .= do_shortcode('[dtdr_sp_contact_details listing_id="'.esc_attr($listing_id).'" include_address="true" type="listing" /]');

				if($custom_excerpt != '') {
					$output .= '<div class="dtdr-listings-excerpt">';

						$output .= '<p>';

							$dtdr_excerpt_title = get_post_meta($listing_id, 'dtdr_excerpt_title', true);

							if(  $dtdr_excerpt_title != '' ) {
								$output .= '<span>'.esc_html( $dtdr_excerpt_title ).'</span>';
							}

							$output .= $custom_excerpt;

						$output .= '</p>';
					$output .= '</div>';
				}

			$output .= '</div>';

		}

	if($apply_isotope == 'true') {
			$output .= '</div>';
		$output .= '</div>';
	} else {
		$output .= '</div>';
	}

	return $output;

}

// Favourite marker html

function dtdr_favourite_marker_html($listing_id) {

	$favourite_marker = '';

	$current_user = wp_get_current_user();
	$user_id = $current_user->ID;

	$favourite_items = get_user_meta($user_id, 'favourite_items', true);
	$favourite_items = (is_array($favourite_items) && !empty($favourite_items)) ? $favourite_items : array();

	$favourite_attr = 'data-listingid="'.$listing_id.'"';
	if($user_id > 0) {
		if(in_array($listing_id, $favourite_items)) {
			$favourite_class = 'removefavourite';
			$favourite_icon_class = 'fa fa-heart';
		} else {
			$favourite_class = 'addtofavourite';
			$favourite_icon_class = 'far fa-heart';
		}
		$favourite_attr .= ' data-userid="'.$user_id.'"';
	} else {
		$favourite_class = 'dtdr-login-link';
		$favourite_attr = '';
		$favourite_icon_class = 'far fa-heart';
	}

	$favourite_marker .= '<div class="dtdr-listings-utils-item dtdr-listings-utils-favourite">';
		$favourite_marker .= '<a class="dtdr-listings-utils-favourite-item '.esc_attr( $favourite_class ).'" '.$favourite_attr.'><span class="'.esc_attr( $favourite_icon_class ).'"></span></a>';
	$favourite_marker .= '</div>';

	return $favourite_marker;

}


// Ajax Pagination

function dtdr_listing_ajax_pagination($max_num_pages, $current_page, $function_call, $output_div, $item_ids) {

	$output = '';

	if($max_num_pages > 1) {

		unset($item_ids['_wpnonce']);
		unset($item_ids['column_class']);
		unset($item_ids['carousel_class']);
		unset($item_ids['offset']);
		unset($item_ids['current_page']);
		unset($item_ids['function_call']);
		unset($item_ids['output_div']);
		unset($item_ids['woocommerce-login-nonce']);
		unset($item_ids['woocommerce-reset-password-nonce']);

		$listing_options = json_encode($item_ids);

		$output .= '<div class="dtdr-pagination dtdr-listing-pagination dtdr-ajax-pagination"  data-functioncall="'.esc_attr( $function_call ).'" data-outputdiv="'.esc_attr( $output_div ).'" data-listing-options="'.esc_js($listing_options).'">';

			if($current_page > 1) {
				$output .= '<div class="prev-post"><a href="#" data-currentpage="'.esc_attr( $current_page ).'"><span class="fa fa-caret-left"></span>&nbsp;'.esc_html__('Prev','dtdr-lite').'</a></div>';
			}

			$output .= paginate_links ( array (
				'base' 		 => '#',
				'format' 		 => '',
				'current' 	 => $current_page,
				'type'     	 => 'list',
				'end_size'     => 2,
				'mid_size'     => 3,
				'prev_next'    => false,
				'total' 		 => $max_num_pages
			) );

			if ($current_page < $max_num_pages) {
				$output .= '<div class="next-post"><a href="#" data-currentpage="'.esc_attr( $current_page ).'">'.esc_html__('Next','dtdr-lite').'&nbsp;<span class="fa fa-caret-right"></span></a></div>';
			}

		$output .= '</div>';

    }

    return $output;

}


// Listing item favourite marker

add_action( 'wp_ajax_dtdr_listing_favourite_marker', 'dtdr_listing_favourite_marker' );
add_action( 'wp_ajax_nopriv_dtdr_listing_favourite_marker', 'dtdr_listing_favourite_marker' );
function dtdr_listing_favourite_marker() {

	$listing_id = isset($_REQUEST['listing_id']) ? sanitize_text_field($_REQUEST['listing_id']) : -1;
	$user_id = isset($_REQUEST['user_id']) ? sanitize_text_field($_REQUEST['user_id']) : -1;

	if($listing_id > 0 && $user_id > 0) {

		$favourite_items = get_user_meta($user_id, 'favourite_items', true);
		$favourite_items = (is_array($favourite_items) && !empty($favourite_items)) ? $favourite_items : array();

		if(in_array($listing_id, $favourite_items)) {
			unset($favourite_items[array_search($listing_id, $favourite_items)]);
		} else {
			array_push($favourite_items, $listing_id);
		}

		update_user_meta($user_id, 'favourite_items', $favourite_items);

	}

	die();

}

// Listing Page View Counter

function dtdr_listing_page_view_counter_overall_update($listing_id, $user_id) {

	$restrict_counter_overuserip = dtdr_option('general', 'restrict-counter-overuserip');

	// Update views if not restricted over ip
	if($restrict_counter_overuserip != 'true') {
		dtdr_listing_page_view_counter_update($listing_id, $user_id);
	}


    // Update views over over user ip and date
    $user_ip = $_SERVER['REMOTE_ADDR'];

	$dtdr_user_ips = get_post_meta($listing_id, 'dtdr_user_ips', true);
	$dtdr_user_ips = (is_array($dtdr_user_ips) && !empty($dtdr_user_ips)) ? $dtdr_user_ips : array ();

	if(!in_array($user_ip, $dtdr_user_ips)) {

		array_push($dtdr_user_ips, $user_ip);
		update_post_meta($listing_id, 'dtdr_user_ips', $dtdr_user_ips);

		if($restrict_counter_overuserip == 'true') {
		    dtdr_listing_page_view_counter_update($listing_id, $user_id);
		}

	}

}

function dtdr_listing_page_view_counter_update($listing_id, $user_id) {


	// Total views update
    $total_views = get_post_meta($listing_id, 'dtdr_total_views', true);
    $total_views = ($total_views != '') ? $total_views : 0;

	$total_views++;

	update_post_meta($listing_id, 'dtdr_total_views', $total_views);

	// Datewise view
    $today = current_time('d-m-Y');

    $dtdr_detailed_views =  get_post_meta($listing_id, 'dtdr_detailed_views', true);
    $dtdr_detailed_views = (is_array($dtdr_detailed_views) && !empty($dtdr_detailed_views)) ? $dtdr_detailed_views : array ();

    if(empty($dtdr_detailed_views)) {

        $dtdr_detailed_views[$today] = 1;

    } else {

        if(!isset($dtdr_detailed_views[$today])) {
            $dtdr_detailed_views[$today] = 1;
        } else {
            $dtdr_detailed_views[$today] = intval($dtdr_detailed_views[$today])+1;
        }

    }

    update_post_meta($listing_id, 'dtdr_detailed_views', $dtdr_detailed_views);

}


// Listing item contact form

add_action( 'wp_ajax_dtdr_process_listing_contactform', 'dtdr_process_listing_contactform' );
add_action( 'wp_ajax_nopriv_dtdr_process_listing_contactform', 'dtdr_process_listing_contactform' );
function dtdr_process_listing_contactform() {

	$dtdr_contactform_nonce = $_POST['dtdr_contactform_nonce'];
	$listing_id             = isset($_REQUEST['dtdr_contactform_listingid']) ? sanitize_text_field($_REQUEST['dtdr_contactform_listingid'])      : -1;
	$user_id                = isset($_REQUEST['dtdr_contactform_userid']) ? sanitize_text_field($_REQUEST['dtdr_contactform_userid'])            : -1;
	$contact_point          = isset($_REQUEST['dtdr_contactform_contactpoint']) ? sanitize_text_field($_REQUEST['dtdr_contactform_contactpoint']) : '';
	$include_admin          = isset($_REQUEST['dtdr_contactform_includeadmin']) ? sanitize_text_field($_REQUEST['dtdr_contactform_includeadmin']) : '';

	$errors = false;
	$error_msg = $error_msg1 = array ();
	$flag = 0;

    if(!wp_verify_nonce( $dtdr_contactform_nonce, 'contact_listing_'.$listing_id)) {
    	$errors = true;
    	array_push($error_msg, esc_html__('Unverified Nonce!','dtdr-lite'));
    }

	if($user_id > 0) {

		$contactform_name  = get_the_author_meta( 'display_name' , $user_id );
		$contactform_email = get_the_author_meta( 'user_email' , $user_id );
		$contactform_phone = '';

	} else {

		$contactform_name = sanitize_text_field($_REQUEST['dtdr_contactform_name']);
		if(empty($contactform_name)) {
			$errors = true; $flag = 1;
			array_push($error_msg, esc_html__('Name','dtdr-lite'));
		}

		$contactform_email = sanitize_email($_REQUEST['dtdr_contactform_email']);
		if(empty($contactform_email)) {
			$errors = true; $flag = 1;
			array_push($error_msg, esc_html__('Email','dtdr-lite'));
		} else if (!filter_var($contactform_email, FILTER_VALIDATE_EMAIL)) {
			$errors = true;
			array_push($error_msg1, esc_html__('Email field is not valid!','dtdr-lite'));
		}

		$contactform_phone = sanitize_text_field($_REQUEST['dtdr_contactform_phone']);
		if(empty($contactform_phone)) {
			$errors = true; $flag = 1;
			array_push($error_msg, esc_html__('Phone','dtdr-lite'));
		} else {
			$contactform_phone = str_replace(array('-','(',')', ' ', '+'), '', $contactform_phone);
			if(is_numeric($contactform_phone) === FALSE) {
				$errors = true;
				array_push($error_msg1, esc_html__('Phone field is not valid!','dtdr-lite'));
			}
		}

	}

    $contactform_message = wp_kses_post($_REQUEST['dtdr_contactform_message']);
    if(empty($contactform_message)) {
     	$errors = true; $flag = 1;
    	array_push($error_msg, esc_html__('Message','dtdr-lite'));
    }

    // Retrieving target emails

    $target_emails = array ();

    if($contact_point == 'author-email') {

        $listing_post = get_post($listing_id);
        $author_id = $listing_post->post_author;

        $dtdr_author_email = get_the_author_meta( 'user_email' , $author_id );
        if($dtdr_author_email != '') {
            array_push($target_emails, $dtdr_author_email);
        }

    } else if($contact_point == 'incharge-email') {

		$dtdr_incharges = get_post_meta($listing_id, 'dtdr_incharges', true);
		$dtdr_incharges = (is_array($dtdr_incharges) && !empty($dtdr_incharges)) ? $dtdr_incharges : array ();

		if(is_array($dtdr_incharges) && !empty($dtdr_incharges)) {
			foreach($dtdr_incharges as $incharge_id) {
				$dtdr_incharge_email = get_the_author_meta( 'user_email' , $incharge_id );
				if($dtdr_incharge_email != '') {
					array_push($target_emails, $dtdr_incharge_email);
				}
			}
		}

    } else {

    	$dtdr_listing_email = get_post_meta($listing_id, 'dtdr_email', true);
    	if($dtdr_listing_email != '') {
	    	array_push($target_emails, $dtdr_listing_email);
		}

    }

    if($include_admin == 'true') {
    	$admin_email = get_option('admin_email');
    	array_push($target_emails, $admin_email);
    }

	if(empty($target_emails)) {
     	$errors = true;
    	array_push($error_msg1, esc_html__('No contact emails found, contact administrator!','dtdr-lite'));
	}


    // Throw error message
    if($errors) {

    	$error_content = '<div class="dtdr-contactform-errorlist">';
    	$error_content .= implode(' / ', $error_msg);
	    if( $flag ){
	    	$error_content .= esc_html__(' fields are Empty!','dtdr-lite');
	    }

	    if( !empty($error_msg1) ){
	    	array_walk($error_msg1, function(&$value, &$key) {
   				$value = '<span>'.$value.'</span>';
			});
			$error_content .= implode('', $error_msg1);
	    }

    	$error_content .= '</div>';

        echo json_encode(array(
            'success' => false,
            'message' => $error_content
        ));
        wp_die();

    }


	// Leads Data Update

	if($contact_point == 'author-email' && $dtdr_author_email != '') {

		// Update Leads Count

		$leads_count = get_user_meta($author_id, 'dtdr_leads_count', true);
		$leads_count = isset($leads_count) ? ((int)$leads_count + 1) : 1;
		update_user_meta($author_id, 'dtdr_leads_count', $leads_count);


		// Update Leads Message

		$leadDate = date(get_option('date_format').' '.get_option('time_format'));

		$leadData['user_id']       = $user_id;
		$leadData['name'] 		   = $contactform_name;
		$leadData['phone']         = $contactform_phone;
		$leadData['extras']        = $newFormData;

		$leadConversation['leadData']['message'] = $contactform_message;
		$leadConversation['leadData']['date']    = $leadDate;
		$leadConversation['status']              = 'unread';


		$dtdr_lead_messages = get_user_meta($author_id, 'dtdr_lead_messages', true);

		if(!empty($dtdr_lead_messages)) {

			if (array_key_exists($listing_id, $dtdr_lead_messages)) { // If message already exists

				$existing_lead_messages = $dtdr_lead_messages[$listing_id];

				if(array_key_exists($contactform_email, $existing_lead_messages)) {

					$prevConversation = $dtdr_lead_messages[$listing_id][$contactform_email]['leads']['conversation'];
					array_push($prevConversation, $leadConversation);

					$dtdr_lead_messages[$listing_id][$contactform_email]['leads'] = $leadData;
					$dtdr_lead_messages[$listing_id][$contactform_email]['leads']['conversation'] = $prevConversation;
				} else {

					$dtdr_lead_messages[$listing_id][$contactform_email]['leads'] = $leadData;
					$dtdr_lead_messages[$listing_id][$contactform_email]['leads']['conversation'][0] = $leadConversation;
				}

			} else {

				$dtdr_lead_messages[$listing_id][$contactform_email]['leads'] = $leadData;
				$dtdr_lead_messages[$listing_id][$contactform_email]['leads']['conversation'][0] = $leadConversation;
			}

		} else { // For first message

			$dtdr_lead_messages = array ();
			$dtdr_lead_messages[$listing_id][$contactform_email]['leads'] = $leadData;
			$dtdr_lead_messages[$listing_id][$contactform_email]['leads']['conversation'][0] = $leadConversation;
		}

		update_user_meta($author_id, 'dtdr_lead_messages', $dtdr_lead_messages);


		// Update Recent Activities

		$recentActivitiesData['type']          = 'contact';
		$recentActivitiesData['date']          = date(get_option('date_format').' '.get_option('time_format'));
		$recentActivitiesData['user_id']       = $user_id;
		$recentActivitiesData['name'] 		   = $contactform_name;
		$recentActivitiesData['phone']         = $contactform_phone;
		$recentActivitiesData['email']         = $contactform_email;
		$recentActivitiesData['listing_id']    = $listing_id;

		$dtdr_recent_activities = get_user_meta($author_id, 'dtdr_recent_activities', true);
		$dtdr_recent_activities = (is_array($dtdr_recent_activities) && !empty($dtdr_recent_activities)) ? $dtdr_recent_activities : array ();

		if(!empty($dtdr_recent_activities)) {

			if(count($dtdr_recent_activities) >= 20) {
				$dtdr_recent_activities = array_slice($dtdr_recent_activities, 0, 20);
				array_unshift($dtdr_recent_activities, $recentActivitiesData);
			} else {
				array_unshift($dtdr_recent_activities, $recentActivitiesData);
			}

		} else {

			array_unshift($dtdr_recent_activities, $recentActivitiesData);

		}

		update_user_meta($author_id, 'dtdr_recent_activities', $dtdr_recent_activities);

	}



    // Composing mail

    $dtdr_subject = sprintf(esc_html__('New message from %1$s - %2$s','dtdr-lite'), $contactform_name, get_bloginfo('name'));

    $dtdr_body = esc_html__('You have received a message from: ','dtdr-lite') . $contactform_name . " <br/>";
    $dtdr_body .= esc_html__('Phone Number : ','dtdr-lite') . $contactform_phone . " <br/><br/>";
    $dtdr_body .= wpautop( $contactform_message ) . " <br/>";
    $dtdr_body .= sprintf(esc_html__( 'You can contact %1$s via email %2$s','dtdr-lite'), $contactform_name, $contactform_email);

    $dtdr_header = 'Content-type: text/html; charset=utf-8' . "\r\n";
    $dtdr_header .= 'From: ' . $contactform_name . " <" . $contactform_email . "> \r\n";

    if (wp_mail($target_emails, $dtdr_subject, $dtdr_body, $dtdr_header)) {

        echo json_encode(array (
            'success' => true,
            'message' => esc_html__('Message Sent Successfully!','dtdr-lite')
		));

		wp_die();

    } else {
        echo json_encode(array (
                'success' => false,
                'message' => esc_html__('Something went wrong!. Please check your settings!.','dtdr-lite')
            )
        );
        wp_die();
    }

	wp_die();

}

// Contact details request process

add_action( 'wp_ajax_dtdr_listing_contactdetails_request', 'dtdr_listing_contactdetails_request' );
add_action( 'wp_ajax_nopriv_dtdr_listing_contactdetails_request', 'dtdr_listing_contactdetails_request' );
function dtdr_listing_contactdetails_request() {


    $listing_id = isset($_REQUEST['listing_id']) ? sanitize_text_field($_REQUEST['listing_id']) : -1;

    $errors = false;
    $error_msg = array ();

    if($listing_id > 0) {

        $listing_singular_label = apply_filters( 'listing_label', 'singular' );

        $current_user = wp_get_current_user();
        $user_id = $current_user->ID;

        if(function_exists('dtdr_check_user_buyer_package_is_active') && dtdr_check_user_buyer_package_is_active($user_id, -1)) {

            $dtdr_buyer_package_listings = get_user_meta($user_id, 'dtdr_buyer_package_listings', true);
            $dtdr_buyer_package_listings = (is_array($dtdr_buyer_package_listings) && !empty($dtdr_buyer_package_listings)) ? $dtdr_buyer_package_listings : array ();
            $dtdr_buyer_package_listings = array_unique($dtdr_buyer_package_listings);


            $dtdr_buyer_active_package_id = get_user_meta($user_id, 'dtdr_buyer_active_package_id', true);
            $dtdr_buyer_active_package_id = (isset($dtdr_buyer_active_package_id) && !empty($dtdr_buyer_active_package_id)) ? $dtdr_buyer_active_package_id : -1;


            // Available counts
            $dtdr_buyer_package_listings_count = get_user_meta($user_id, 'dtdr_buyer_package_listings_count', true);
            $dtdr_buyer_package_listings_count = (isset($dtdr_buyer_package_listings_count) && !empty($dtdr_buyer_package_listings_count)) ? $dtdr_buyer_package_listings_count : 0;


            // Used counts
            $dtdr_buyer_package_used_listings_count = get_user_meta($user_id, 'dtdr_buyer_package_used_listings_count', true);
            $dtdr_buyer_package_used_listings_count = (isset($dtdr_buyer_package_used_listings_count) && !empty($dtdr_buyer_package_used_listings_count)) ? $dtdr_buyer_package_used_listings_count : 0;


            // Remaining counts
            $dtdr_buyer_allow_listings = false;
            if($dtdr_buyer_package_listings_count == -1) {
                $dtdr_buyer_allow_listings = true;
            } else {
                $dtdr_buyer_remaining_listings_count = ($dtdr_buyer_package_listings_count - $dtdr_buyer_package_used_listings_count);
            }

            if(!in_array($listing_id, $dtdr_buyer_package_listings)) {

                if($dtdr_buyer_remaining_listings_count > 0 || $dtdr_buyer_allow_listings) {

                    array_push($dtdr_buyer_package_listings, $listing_id);
                    update_user_meta($user_id, 'dtdr_buyer_package_listings', $dtdr_buyer_package_listings);

                    $dtdr_buyer_package_used_listings_count = get_user_meta($user_id, 'dtdr_buyer_package_used_listings_count', true);
                    $dtdr_buyer_package_used_listings_count++;
                    update_user_meta($user_id, 'dtdr_buyer_package_used_listings_count', $dtdr_buyer_package_used_listings_count);

                    echo json_encode(array(
                        'success' => true
                    ));
                    wp_die();

                } else {

                    echo json_encode(array (
                            'success' => false,
                            'message' => sprintf(esc_html__('Your subscribtion limit have been reached, please check your dashboard.','dtdr-lite'), strtolower($listing_singular_label))
                        )
                    );
                    wp_die();

                }

            } else {

                echo json_encode(array (
                        'success' => false,
                        'message' => sprintf(esc_html__('You have already subscribed this %1$s.','dtdr-lite'), strtolower($listing_singular_label))
                    )
                );
                wp_die();

            }

        } else {

            echo json_encode(array (
                    'success' => false,
                    'message' => sprintf(esc_html__('You don\'t have any active package to send request.','dtdr-lite'), strtolower($listing_singular_label))
                )
            );
            wp_die();
        }

    }

    wp_die();

}

// Activity Tracker - Website Visit
add_action( 'wp_ajax_dtdr_listing_activity_tracker_contactdetails', 'dtdr_listing_activity_tracker_contactdetails' );
add_action( 'wp_ajax_nopriv_dtdr_listing_activity_tracker_contactdetails', 'dtdr_listing_activity_tracker_contactdetails' );
function dtdr_listing_activity_tracker_contactdetails() {

	$activity_type = isset($_REQUEST['activity_type']) ? sanitize_text_field($_REQUEST['activity_type']) : '';
	$listing_id    = isset($_REQUEST['listing_id']) ? sanitize_text_field($_REQUEST['listing_id']) : -1;
	$user_id       = (isset($_REQUEST['user_id']) && $_REQUEST['user_id'] > 0) ? sanitize_text_field($_REQUEST['user_id']) : -1;
	$country       = isset($_REQUEST['country']) ? sanitize_text_field($_REQUEST['country']) : '';
	$city          = isset($_REQUEST['city']) ? sanitize_text_field($_REQUEST['city']) : '';
	$zip           = isset($_REQUEST['zip']) ? sanitize_text_field($_REQUEST['zip']) : '';

	$listing_post = get_post($listing_id);
	$author_id = $listing_post->post_author;

	if($author_id > 0 && $listing_id > 0 && $activity_type != '') {

		// Update Leads Count

		$leads_count = get_user_meta($author_id, 'dtdr_leads_count', true);
		$leads_count = isset($leads_count) ? ((int)$leads_count + 1) : 1;
		update_user_meta($author_id, 'dtdr_leads_count', $leads_count);


		// Update Recent Activities

		$recentActivitiesData['type']       = $activity_type;
		$recentActivitiesData['date']       = date(get_option('date_format').' '.get_option('time_format'));
		$recentActivitiesData['user_id']    = $user_id;
		$recentActivitiesData['country'] 	= $country;
		$recentActivitiesData['city']       = $city;
		$recentActivitiesData['zip']        = $zip;
		$recentActivitiesData['listing_id'] = $listing_id;

		$dtdr_recent_activities = get_user_meta($author_id, 'dtdr_recent_activities', true);
		$dtdr_recent_activities = (is_array($dtdr_recent_activities) && !empty($dtdr_recent_activities)) ? $dtdr_recent_activities : array ();

		if(!empty($dtdr_recent_activities)) {

			if(count($dtdr_recent_activities) >= 20) {
				$dtdr_recent_activities = array_slice($dtdr_recent_activities, 0, 20);
				array_unshift($dtdr_recent_activities, $recentActivitiesData);
			} else {
				array_unshift($dtdr_recent_activities, $recentActivitiesData);
			}

		} else {

			array_unshift($dtdr_recent_activities, $recentActivitiesData);

		}

		update_user_meta($author_id, 'dtdr_recent_activities', $dtdr_recent_activities);

	}

	wp_die();
}?>