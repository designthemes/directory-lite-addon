<?php

// Search Listing - Default Content
if(!function_exists('dtdr_search_listings_content')) {
	function dtdr_search_listings_content() {
		$output = '';

		$output .= '<div class="dtdr-search-container dtdr-search-listings-container">';
			$seller_singular_label = apply_filters( 'seller_label', 'singular' );
			$output .= '<span>'.sprintf( esc_html__('%1$s','dtdr-lite'), $seller_singular_label ).'</span>';
			$output .= '<select class="dtdr-search-listings-seller dtdr-chosen-select" name="dtdr-search-listings-seller" data-placeholder="'.sprintf( esc_attr__('Choose %1$s ...','dtdr-lite'), $seller_singular_label ).'" class="dtdr-chosen-select">';
				$output .= '<option value="-1">'.esc_html__('All','dtdr-lite').'</option>';
				$sellers = get_users ( array ('role' => 'seller') );
				if ( count( $sellers ) > 0 ) {
					foreach ($sellers as $seller) {
						$seller_id = $seller->data->ID;
						$output .= '<option value="' . esc_attr( $seller_id ) . '">' . esc_html( $seller->data->display_name ) . '</option>';
					}
				}
			$output .= '</select>';
			$output .= '<div class="dtdr-hr-invisible"></div>';
			$output .= dtdr_generate_loader_html(true);
			$output .= '<div class="dtdr-search-listings-data-container"></div>';
		$output .= '</div>';

		echo $output;
	}
}

// Search Listing - Ajax Call
if(!function_exists('dtdr_search_sellerwise_listings')) {
	function dtdr_search_sellerwise_listings() {

		// Pagination script Start
		$current_page = isset($_REQUEST['current_page']) ? sanitize_text_field($_REQUEST['current_page']) : 1;
		$offset = isset($_REQUEST['offset']) ? sanitize_text_field($_REQUEST['offset']) : 0;
		$backend_postperpage = dtdr_option('general','backend-postperpage');
		$post_per_page = isset($_REQUEST['post_per_page']) ? sanitize_text_field($_REQUEST['post_per_page']) : $backend_postperpage;

		// Pagination script End
		$seller_id = isset($_REQUEST['seller_id']) ? sanitize_text_field($_REQUEST['seller_id']) : -1;

		$listing_plural_label = apply_filters( 'listing_label', 'plural' );

		$args = array (
			'post_type'      => 'dtdr_listings',
			'offset'         => $offset,
			'paged'          => $current_page,
			'posts_per_page' => $post_per_page,
		);

		if($seller_id > 0) {
			$author_ids       = array ($seller_id);
			$seller_incharges = get_users ( array ('role' => 'incharge', 'meta_key' => 'user_seller', 'meta_value' => $seller_id, 'fields' => 'ID') );
			$author_ids       = array_merge($author_ids, $seller_incharges);

			$args['author__in'] = $author_ids;
		}

		$output = '';

		$output .= '<div class="dtdr-column dtdr-one-half first">';
			$output .= '<div class="dtdr-custom-table-wrapper">';
				$output .= '<table border="0" cellpadding="0" cellspacing="0" class="dtdr-custom-table">
								<thead>
									<tr>
										<th>'.esc_html__('#','dtdr-lite').'</th>
										<th>'.esc_html($listing_plural_label).'</th>
										<th>'.esc_html__('Added By','dtdr-lite').'</th>
										<th>'.esc_html__('Total Views','dtdr-lite').'</th>
										<th>'.esc_html__('Average Ratings','dtdr-lite').'</th>
									</tr>
								</thead>
								<tbody class="dtdr-custom-table-content">';

									$listings_query = new WP_Query( $args );

									if ( $listings_query->have_posts() ) :

										$i = 1;
										while ( $listings_query->have_posts() ) :
											$listings_query->the_post();

											$listing_id = get_the_ID();

											$total_views = get_post_meta($listing_id, 'dtdr_total_views', true);
											$total_views = (isset($total_views) && $total_views != '') ? $total_views : 0;

											$average_ratings = get_post_meta($listing_id, 'dtdr_average_ratings', true);
											$average_ratings = (isset($average_ratings) && $average_ratings != '') ? $average_ratings : 0;

											$author_id = get_post_field( 'post_author', $listing_id );

											$current_user = get_userdata($author_id);
											$user_roles = (array) $current_user->roles;

											$output .= '<tr>
															<td>'.esc_html( $i ).'</td>
															<td>'.esc_html( get_the_title($listing_id) ).'</td>
															<td>'.get_the_author_meta( 'display_name' , $author_id ).' ( '.implode(', ', $user_roles).' ) '.'</td>
															<td>'.esc_html($total_views).'</td>
															<td>'.esc_html($average_ratings).'</td>
														</tr>';

											$i++;

										endwhile;
										wp_reset_postdata();

									else:

										$output .= '<tr>
											<td colspan="5">'.esc_html__('No Records Found!','dtdr-lite').'</td>
										</tr>';
									endif;

				$output .= '</tbody></table>';
			$output .= '</div>';

			$output .= '<div class="dtdr-search-listings-count">'.sprintf( esc_html__( 'Total %1$s','dtdr-lite'), $listing_plural_label ).'<span>'.$listings_query->found_posts.'</span></div>';


			// Pagination script Start
			$max_num_pages = $listings_query->max_num_pages;

			$item_ids['seller_id'] = $seller_id;
			$item_ids['post_per_page'] = $post_per_page;

			$output .= dtdr_ajax_pagination($max_num_pages, $current_page, 'dtdr_search_sellerwise_listings', 'dtdr-search-listings-data-container', $item_ids);
			// Pagination script End

		$output .= '</div>';
		$output .= '<div class="dtdr-column dtdr-one-half">';
			$output .= '<div class="dtdr-search-listings-inner-data-container"></div>';
		$output .= '</div>';

		echo $output;

		wp_die();

	}
	add_action( 'wp_ajax_dtdr_search_sellerwise_listings', 'dtdr_search_sellerwise_listings' );
	add_action( 'wp_ajax_nopriv_dtdr_search_sellerwise_listings', 'dtdr_search_sellerwise_listings' );
}

// Search Sellers - Default Content
if(!function_exists('dtdr_search_sellers_content')) {
	function dtdr_search_sellers_content() {

		$output = '';
		$output .= '<div class="dtdr-search-container dtdr-search-sellers-container">';
			$output .= dtdr_generate_loader_html(true);
			$output .= '<div class="dtdr-search-sellers-data-container"></div>';
		$output .= '</div>';

		echo $output;
	}
}

// Search Sellers - Ajax Call
if(!function_exists('dtdr_search_sellers')) {
	function dtdr_search_sellers() {

		// Pagination script Start
		$ajax_call           = (isset($_REQUEST['ajax_call']) && $_REQUEST['ajax_call'] == true) ? true : false;
		$current_page        = isset($_REQUEST['current_page']) ? sanitize_text_field($_REQUEST['current_page']) : 1;
		$offset              = isset($_REQUEST['offset']) ? sanitize_text_field($_REQUEST['offset']) : 0;
		$backend_postperpage = dtdr_option('general','backend-postperpage');
		$post_per_page       = isset($_REQUEST['post_per_page']) ? sanitize_text_field($_REQUEST['post_per_page']) : $backend_postperpage;

		// Pagination script End
		$listing_plural_label  = apply_filters( 'listing_label', 'plural' );
		$seller_plural_label   = apply_filters( 'seller_label', 'plural' );
		$seller_singular_label = apply_filters( 'seller_label', 'singular' );
		$incharge_plural_label = apply_filters( 'incharge_label', 'plural' );

		$output = '';

		$output .= '<div class="dtdr-column dtdr-two-third first">';

			$output .= '<div class="dtdr-custom-table-wrapper">';
				$output .= '<table border="0" cellpadding="0" cellspacing="0" class="dtdr-custom-table">
								<thead>
									<tr>
										<th>'.esc_html__('#','dtdr-lite').'</th>
										<th>'.esc_html($seller_plural_label).'</th>
										<th>'.sprintf( esc_html__( '%1$s Status','dtdr-lite'), $seller_singular_label ).'</th>
										<th>'.esc_html__('Package Status','dtdr-lite').'</th>
										<th>'.esc_html__('Active Package','dtdr-lite').'</th>
										<th>'.esc_html__('Purchased Date','dtdr-lite').'</th>
										<th>'.esc_html__('Expiry Date','dtdr-lite').'</th>
										<th>'.sprintf( esc_html__( 'Total %1$s','dtdr-lite'), $incharge_plural_label ).'</th>
										<th>'.sprintf( esc_html__( 'Total %1$s','dtdr-lite'), $listing_plural_label ).'</th>
									</tr>
								</thead>
								<tbody class="dtdr-custom-table-content">';

									$sellers = get_users ( array (
										'role' => 'seller',
										'offset' => $offset,
										'paged' => $current_page,
										'number' => $post_per_page,
									) );

									$i = 1;
									foreach ( $sellers as $seller ) {
										setup_postdata( $seller );

										$seller_id = $seller->data->ID;

										$dtdr_user_status = get_the_author_meta('dtdr_user_status', $seller_id);
										$dtdr_user_status = (isset($dtdr_user_status) && $dtdr_user_status != '') ? $dtdr_user_status : 'disabled';
										if ( $dtdr_user_status == 'disabled' ) {
											$dtdr_user_status_html = esc_html__( 'Disabled','dtdr-lite');
										} else if ( $dtdr_user_status == 'active' ) {
											$dtdr_user_status_html = esc_html__( 'Active','dtdr-lite');
										} else if ( $dtdr_user_status == 'waitingforapproval' ) {
											$dtdr_user_status_html = esc_html__( 'Waiting For Approval','dtdr-lite');
										}

										// Package Status
										$dtdr_seller_active_package_id = get_user_meta($seller_id, 'dtdr_seller_active_package_id', true);

										$package_status = $dtdr_seller_active_package_purchased_date = $dtdr_seller_active_package_expiry_date = $active_package_title = '-';
										if(dtdr_check_user_seller_package_is_active($seller_id, $dtdr_seller_active_package_id)) {

											$dtdr_seller_active_package_purchased_date = get_user_meta($seller_id, 'dtdr_seller_active_package_purchased_date', true);
											$dtdr_seller_active_package_purchased_date = ($dtdr_seller_active_package_purchased_date != '') ? date(get_option('date_format'), (int)$dtdr_seller_active_package_purchased_date) : '-';

											$dtdr_seller_active_package_expiry_date    = get_user_meta($seller_id, 'dtdr_seller_active_package_expiry_date', true);
											if($dtdr_seller_active_package_expiry_date == 'LT') {
												$dtdr_seller_active_package_expiry_date = esc_html__('Lifetime','dtdr-lite');
											} else if($dtdr_seller_active_package_expiry_date != '') {
												$dtdr_seller_active_package_expiry_date = date(get_option('date_format'), (int)$dtdr_seller_active_package_expiry_date);
											} else {
												$dtdr_seller_active_package_expiry_date = '-';
											}

											$active_package_title = ($dtdr_seller_active_package_id != '') ? get_the_title($dtdr_seller_active_package_id) : '-';

											$package_status = esc_html__('Active','dtdr-lite');

										}

										// Incharges
										$author_ids = array ($seller_id);
										$seller_incharges = get_users ( array ('role' => 'incharge', 'meta_key' => 'user_seller', 'meta_value' => $seller_id, 'fields' => 'ID') );
										$author_ids = array_merge($author_ids, $seller_incharges);

										// Listings
										$post_cnt = 0;
										foreach($author_ids as $author_id) {

											$total_post_args = array (
												'posts_per_page' => -1,
												'post_type'=> 'dtdr_listings',
												'author'=> $author_id,
												'post_status' => array ( 'any' )
											);

											$total_post_listings = get_posts( $total_post_args );
											wp_reset_postdata();
											$listings_post_count = count($total_post_listings);

											$post_cnt = $post_cnt + $listings_post_count;
										}

										$output .= '<tr>
														<td>'.esc_html( $i ).'</td>
														<td>'.get_the_author_meta('display_name', $seller_id).'</td>
														<td>'.esc_html( $dtdr_user_status_html ).'</td>
														<td>'.esc_html( $package_status ).'</td>
														<td>'.esc_html( $active_package_title ).'</td>
														<td>'.esc_html( $dtdr_seller_active_package_purchased_date ).'</td>
														<td>'.esc_html( $dtdr_seller_active_package_expiry_date ).'</td>
														<td>';

															$output .= count($seller_incharges);
															if($seller_incharges > 0) {
																$output .= '<a href="#" class="custom-button-style dtdr-search-seller-incharges" data-sellerid="'.esc_html($seller_id).'">'.esc_html__('View Details','dtdr-lite').'</a>';
															}

														$output .= '</td><td>';

															$output .= $post_cnt;
															if($post_cnt > 0) {
																$output .='<a href="#" class="custom-button-style dtdr-search-seller-listings" data-sellerid="'.esc_html($seller_id).'">'.esc_html__('View Details','dtdr-lite').'</a>';
															}

											$output .= '</td>';
										$output .= '</tr>';

										$i++;

									}

				$output .= '</tbody></table>';
			$output .= '</div>';


			// Pagination script Start
			$total_users_args = array (
				'role' => 'seller',
			);

			$total_users = get_users( $total_users_args );

			$total_users_count = count($total_users);
			$max_num_pages = ceil($total_users_count / $post_per_page);


			$item_ids['post_per_page'] = $post_per_page;

			$output .= dtdr_ajax_pagination($max_num_pages, $current_page, 'dtdr_search_sellers', 'dtdr-search-sellers-data-container', $item_ids);
			// Pagination script End

		$output .= '</div>';
		$output .= '<div class="dtdr-column dtdr-one-third">';

			$output .= '<div class="dtdr-search-sellers-inner-data-container"></div>';

		$output .= '</div>';

		echo $output;

		wp_die();

	}
	add_action( 'wp_ajax_dtdr_search_sellers', 'dtdr_search_sellers' );
	add_action( 'wp_ajax_nopriv_dtdr_search_sellers', 'dtdr_search_sellers' );
}

// Search Sellers - Incharges
if(!function_exists('dtdr_search_seller_incharges')) {
	function dtdr_search_seller_incharges() {

		$seller_id = isset($_REQUEST['seller_id']) ? sanitize_text_field($_REQUEST['seller_id']) : -1;
		$seller_incharges = get_users ( array ('role' => 'incharge', 'meta_key' => 'user_seller', 'meta_value' => $seller_id, 'fields' => 'ID') );

		$listing_plural_label = apply_filters( 'listing_label', 'plural' );
		$incharge_singular_label = apply_filters( 'incharge_label', 'singular' );
		$incharge_plural_label = apply_filters( 'incharge_label', 'plural' );

		$output = '';

		$output .= '<div class="dtdr-custom-table-wrapper">';

			$output .= '<table border="0" cellpadding="0" cellspacing="0" class="dtdr-custom-table">
							<thead>
								<tr>
									<th>'.esc_html__('#','dtdr-lite').'</th>
									<th>'.sprintf( esc_html__( '%1$s','dtdr-lite'), $incharge_plural_label ).'</th>
									<th>'.sprintf( esc_html__( '%1$s Status','dtdr-lite'), $incharge_singular_label ).'</th>
									<th>'.sprintf( esc_html__( 'Total %1$s','dtdr-lite'), $listing_plural_label ).'</th>
									<th>'.sprintf( esc_html__( 'Total %1$s Published','dtdr-lite'), $listing_plural_label ).'</th>
								</tr>
							</thead>
							<tbody class="dtdr-custom-table-content">';

								$incharges = get_users ( array (
									'role' => 'incharge',
									'include' => $seller_incharges,
								) );

								$i = 1;
								foreach ( $incharges as $incharge ) {
									setup_postdata( $incharge );

									$incharge_id = $incharge->data->ID;

									$dtdr_user_status = get_the_author_meta('dtdr_user_status', $incharge_id);
									$dtdr_user_status = (isset($dtdr_user_status) && $dtdr_user_status != '') ? $dtdr_user_status : 'disabled';
									if ( $dtdr_user_status == 'disabled' ) {
										$dtdr_user_status_html = esc_html__( 'Disabled','dtdr-lite');
									} else if ( $dtdr_user_status == 'active' ) {
										$dtdr_user_status_html = esc_html__( 'Active','dtdr-lite');
									} else if ( $dtdr_user_status == 'waitingforapproval' ) {
										$dtdr_user_status_html = esc_html__( 'Waiting For Approval','dtdr-lite');
									}

									$total_post_args = array (
										'posts_per_page' => -1,
										'post_type'=> 'dtdr_listings',
										'author'=> $incharge_id,
										'post_status' => array ( 'any' )
									);

									$total_post_listings = get_posts( $total_post_args );
									wp_reset_postdata();
									$listings_post_count = count($total_post_listings);

									$output .= '<tr>
													<td>'.$i.'</td>
													<td>'.get_the_author_meta('display_name', $incharge_id).'</td>
													<td>'.esc_html( $dtdr_user_status_html ).'</td>
													<td>'.esc_html($listings_post_count).'</td>
													<td>'.count_user_posts($incharge_id , 'dtdr_listings').'</td>
												</tr>';

									$i++;

								}

			$output .= '</tbody></table>';

		$output .= '</div>';

		echo $output;

		wp_die();

	}
	add_action( 'wp_ajax_dtdr_search_seller_incharges', 'dtdr_search_seller_incharges' );
	add_action( 'wp_ajax_nopriv_dtdr_search_seller_incharges', 'dtdr_search_seller_incharges' );
}

// Search Sellers - Listings
if(!function_exists('dtdr_search_seller_listings')) {
	function dtdr_search_seller_listings() {

		$seller_id = isset($_REQUEST['seller_id']) ? sanitize_text_field($_REQUEST['seller_id']) : -1;

		$author_ids = array ($seller_id);
		$seller_incharges = get_users ( array ('role' => 'incharge', 'meta_key' => 'user_seller', 'meta_value' => $seller_id, 'fields' => 'ID') );
		$author_ids = array_merge($author_ids, $seller_incharges);

		$listing_plural_label = apply_filters( 'listing_label', 'plural' );

		$output = '';

		$output .= '<div class="dtdr-custom-table-wrapper">';
			$output .= '<table border="0" cellpadding="0" cellspacing="0" class="dtdr-custom-table">
							<thead>
								<tr>
									<th>'.esc_html__('#','dtdr-lite').'</th>
									<th>'.esc_html($listing_plural_label).'</th>
									<th>'.esc_html__('Status','dtdr-lite').'</th>
									<th>'.esc_html__('Added By','dtdr-lite').'</th>
								</tr>
							</thead>
							<tbody class="dtdr-custom-table-content">';

								$args = array (
									'post_type' => 'dtdr_listings',
									'author__in' => $author_ids
								);

								$seller_listings_query = new WP_Query( $args );

								if ( $seller_listings_query->have_posts() ) :

									$i = 1;
									while ( $seller_listings_query->have_posts() ) :
										$seller_listings_query->the_post();

										$listing_id = get_the_ID();
										$author_id = get_post_field( 'post_author', $listing_id );

										$current_user = get_userdata($author_id);
										$user_roles = (array) $current_user->roles;

										$status = get_post_status($listing_id);

										$listing_status = '';
										if($status == 'expired') {
											$listing_status = esc_html__('Expired','dtdr-lite');
										} else if($status == 'waitingforapproval') {
											$listing_status = esc_html__('Waiting For Approval','dtdr-lite');
										} else if($status == 'pending') {
											$listing_status = esc_html__('Pending','dtdr-lite');
										} else if($status == 'publish') {
											$listing_status = esc_html__('Published','dtdr-lite');
										}

										$output .= '<tr>
														<td>'.esc_html( $i ).'</td>
														<td>'.get_the_title($listing_id).'</td>
														<td>'.esc_html($listing_status).'</td>
														<td>'.get_the_author_meta( 'display_name' , $author_id ).' ( '.implode(', ', $user_roles).' ) '.'</td>
													</tr>';

										$i++;

									endwhile;
									wp_reset_postdata();

								endif;


		$output .= '</tbody></table>';

		echo $output;

		wp_die();

	}
	add_action( 'wp_ajax_dtdr_search_seller_listings', 'dtdr_search_seller_listings' );
	add_action( 'wp_ajax_nopriv_dtdr_search_seller_listings', 'dtdr_search_seller_listings' );
}

// Search Packages - Default Content
if(!function_exists('dtdr_search_packages_content')) {
	function dtdr_search_packages_content() {

		$output = '';
		$output .= '<div class="dtdr-search-container dtdr-search-packages-container">';
			$output .= dtdr_generate_loader_html(true);
			$output .= '<div class="dtdr-search-packages-data-container"></div>';
		$output .= '</div>';

		echo $output;

	}
}

// Search Packages - Ajax Call
if(!function_exists('dtdr_search_packages')) {
	function dtdr_search_packages() {

		// Pagination script Start
		$ajax_call           = (isset($_REQUEST['ajax_call']) && $_REQUEST['ajax_call'] == true) ? true : false;
		$current_page        = isset($_REQUEST['current_page']) ? sanitize_text_field($_REQUEST['current_page']) : 1;
		$offset              = isset($_REQUEST['offset']) ? sanitize_text_field($_REQUEST['offset']) : 0;
		$backend_postperpage = dtdr_option('general','backend-postperpage');
		$post_per_page       = isset($_REQUEST['post_per_page']) ? sanitize_text_field($_REQUEST['post_per_page']) : $backend_postperpage;

		// Pagination script End
		$listing_plural_label = apply_filters( 'listing_label', 'plural' );
		$seller_plural_label  = apply_filters( 'seller_label', 'plural' );

		$output = '';

		$output .= '<div class="dtdr-custom-table-wrapper">';
			$output .= '<table border="0" cellpadding="0" cellspacing="0" class="dtdr-custom-table">
							<thead>
								<tr>
									<th>'.esc_html__('#','dtdr-lite').'</th>
									<th>'.esc_html__('Packages','dtdr-lite').'</th>
									<th>'.esc_html__('Total Purchases','dtdr-lite').'</th>
								</tr>
							</thead>
							<tbody class="dtdr-custom-table-content">';

								$args = array (
									'post_type'      => 'dtdr_packages',
									'offset'         => $offset,
									'paged'          => $current_page,
									'posts_per_page' => $post_per_page,
								);

								$packages_query = new WP_Query( $args );

								if ( $packages_query->have_posts() ) :

									$i = 1;
									while ( $packages_query->have_posts() ) :
										$packages_query->the_post();

										$package_id = get_the_ID();

										$purchased_users = get_post_meta($package_id, 'purchased_users', true);
										$purchased_users = (is_array($purchased_users) && !empty($purchased_users)) ? $purchased_users : array ();

										$output .= '<tr>
														<td>'.esc_html( $i ).'</td>
														<td>'.get_the_title($package_id).'</td>
														<td>';

															$output .= count($purchased_users);
															if(count($purchased_users) > 0) {
																$output .='<a href="#" class="custom-button-style dtdr-search-package-purchases" data-packageid="'.esc_html($package_id).'">'.esc_html__('View Details','dtdr-lite').'</a>';
															}

											$output .= '</td>';
										$output .= '</tr>';

										$i++;

									endwhile;
									wp_reset_postdata();

								else:

									$output .= '<tr>
													<td colspan="4">'.esc_html__('No Records Found!','dtdr-lite').'</td>
												</tr>';

								endif;

			$output .= '</tbody></table>';

			$output .= '<div class="dtdr-search-packages-count">'.esc_html__( 'Total Packages','dtdr-lite').'<span>'.$packages_query->found_posts.'</span></div>';

			// Pagination script Start
			$max_num_pages = $packages_query->max_num_pages;

			$item_ids['post_per_page'] = $post_per_page;

			$output .= dtdr_ajax_pagination($max_num_pages, $current_page, 'dtdr_search_packages', 'dtdr-search-packages-data-container', $item_ids);
			// Pagination script End

		$output .= '</div>';

		$output .= '<div class="dtdr-search-packages-inner-data-container"></div>';


		echo $output;

		wp_die();

	}
	add_action( 'wp_ajax_dtdr_search_packages', 'dtdr_search_packages' );
	add_action( 'wp_ajax_nopriv_dtdr_search_packages', 'dtdr_search_packages' );
}

// Search Packages - Purchased Users
if(!function_exists('dtdr_search_packages_purchases_user_details')) {
	function dtdr_search_packages_purchases_user_details() {

		$package_id = isset($_REQUEST['package_id']) ? sanitize_text_field($_REQUEST['package_id']) : -1;

		$listing_plural_label = apply_filters( 'listing_label', 'plural' );
		$seller_singular_label = apply_filters( 'seller_label', 'singular' );

		$output = '';

		$output .= '<div class="dtdr-custom-table-wrapper">';
			$output .= '<table border="0" cellpadding="0" cellspacing="0" class="dtdr-custom-table">
							<thead>
								<tr>
									<th>'.esc_html__('#','dtdr-lite').'</th>
									<th>'.sprintf( esc_html__('%1$s','dtdr-lite'), $seller_singular_label ).'</th>
									<th>'.esc_html__('Status','dtdr-lite').'</th>
								</tr>
							</thead>
							<tbody class="dtdr-custom-table-content">';

								if($package_id > 0) {

									$purchased_users = get_post_meta($package_id, 'purchased_users', true);

									if(is_array($purchased_users) && !empty($purchased_users)) {

										$i = 1;

										foreach($purchased_users as $purchased_user_key => $purchased_user) {

											$package_status = esc_html__('Expired','dtdr-lite');
											if(dtdr_check_user_seller_package_is_active($purchased_user_key, $package_id)) {
												$package_status = esc_html__('Active','dtdr-lite');
											}

											$output .= '<tr>
															<td>'.esc_html( $i ).'</td>
															<td>'.get_the_author_meta('display_name', $purchased_user_key).'</td>
															<td>'.esc_html( $package_status ).'</td>
														</tr>';

											$i++;

										}

									}

								}

			$output .= '</tbody></table>';
		$output .= '</div>';

		echo $output;

		wp_die();

	}
	add_action( 'wp_ajax_dtdr_search_packages_purchases_user_details', 'dtdr_search_packages_purchases_user_details' );
	add_action( 'wp_ajax_nopriv_dtdr_search_packages_purchases_user_details', 'dtdr_search_packages_purchases_user_details' );
}

?>