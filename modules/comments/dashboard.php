<?php

// Filter Dashboard Modules
if(!function_exists('dtdr_update_comments_dashboard_modules')) {
	function dtdr_update_comments_dashboard_modules($modules) {

	    $modules['comments'] = array (
			'slug'          => 'comments',
			'label'         => esc_html__('Comments','dtdr-lite'),
			'icon'          => 'fas fa-shield-alt',
			'callback'      => 'dtdr_dashboard_comments_page_content',
			'callback_args' => ''
		);

	    return $modules;

	}
	add_filter( 'dashboard_modules', 'dtdr_update_comments_dashboard_modules', 10, 1 );
}

// Filter Seller Modules
if(!function_exists('dashboard_update_comments_seller_modules')) {
	function dashboard_update_comments_seller_modules($modules) {

	    array_push($modules, 'comments');

	    return $modules;

	}
	add_filter( 'dashboard_seller_modules', 'dashboard_update_comments_seller_modules', 10, 1 );
}


// Dashboard Content
if(!function_exists('dtdr_dashboard_comments_page_content')) {
	function dtdr_dashboard_comments_page_content() {

		$listing_plural_label = apply_filters( 'listing_label', 'plural' );

		$seller_id = get_current_user_id();

		$user_commented_posts =  array ();

		$comment_prev_args = array (
			'posts_per_page' => -1,
			'post_type'      => 'dtdr_comments',
			'fields'		 => 'ids'
		);
		$commented_post_ids = get_posts($comment_prev_args);

		if(is_array($commented_post_ids) && !empty($commented_post_ids)) {
			foreach($commented_post_ids as $commented_post_id) {

				$dtdr_commenter_ids = get_post_meta($commented_post_id, 'dtdr_commenter_ids', true);
				$dtdr_commenter_ids = (isset($dtdr_commenter_ids) && !empty($dtdr_commenter_ids)) ? $dtdr_commenter_ids : array ();

				if(in_array($seller_id, $dtdr_commenter_ids)) {
					array_push($user_commented_posts, $commented_post_id);
				}

			}
		}

		// User Commented Posts

		$output = '';

		$output .= '<div class="dtdr-dashbord-section-holder">';

			$output .= '<div class="dtdr-dashbord-section-holder-intro">';
				$output .= '<div class="dtdr-dashbord-section-title">'.esc_html__('Your Comments','dtdr-lite').'</div>';
				$output .= '<div class="dtdr-dashbord-section-title-notes">'.sprintf( esc_html__('%1$s commented by you and its status.','dtdr-lite'), $listing_plural_label).'</div>';
			$output .= '</div>';

			$output .= '<div class="dtdr-dashbord-section-holder-content">';

				$output .= '<table class="dtdr-user-commented-posts-table">
								<thead>
									<tr>
										<th class="dtdr-comment-listing">'.sprintf( esc_html__( '%1$s','dtdr-lite'), $listing_plural_label ).'</th>
										<th class="dtdr-comment-details">'.esc_html__('Your Verification Details','dtdr-lite').'</th>
										<th class="dtdr-comment-status">'.esc_html__('Status','dtdr-lite').'</th>
										<th class="dtdr-comment-status">'.esc_html__('Approved To','dtdr-lite').'</th>
									</tr>
								</thead>
								<tbody>';

				if(is_array($user_commented_posts) && !empty($user_commented_posts)) {
					foreach($user_commented_posts as $user_commented_post) {

						$verification_details = '';
						$dtdr_commenters = get_post_meta($user_commented_post, 'dtdr_commenters', true);
						$dtdr_commenters = (isset($dtdr_commenters) && !empty($dtdr_commenters)) ? $dtdr_commenters : array ();
						if(is_array($dtdr_commenters) && !empty($dtdr_commenters)) {
							foreach($dtdr_commenters as $dtdr_commenter) {
								if($seller_id == $dtdr_commenter['user_id']) {
									$verification_details = $dtdr_commenter['commenter_message'];
								}
							}
						}

						$comment_status = '';
						$dtdr_approved_commenter_id = get_post_meta($user_commented_post, 'dtdr_approved_commenter_id', true);
						if($dtdr_approved_commenter_id != '') {
							$comment_status = esc_html__('Verified & Approved','dtdr-lite');
						} else {
							$comment_status = esc_html__('Pending','dtdr-lite');
						}

						$approved_to = get_the_author_meta( 'display_name', $dtdr_approved_commenter_id );
						if($dtdr_approved_commenter_id == $seller_id) {
							$approved_to = '<span class="dtdr-comment-approved-indication">'.esc_html__('You','dtdr-lite').'</span>';
						}

						$output .= '<tr>';
							$output .= '<td class="dtdr-comment-listing"><a href="'.get_permalink($user_commented_post).'" title="'.get_the_title($user_commented_post).'">'.get_the_title($user_commented_post).'</a></td>';
							$output .= '<td class="dtdr-comment-details">'.esc_html($verification_details).'</td>';
							$output .= '<td class="dtdr-comment-status">'.esc_html($comment_status).'</td>';
							$output .= '<td class="dtdr-comment-approved-to">'.$approved_to.'</td>';
						$output .= '</tr>';

					}
				} else {
					$output .= '<tr>';
						$output .= '<td colspan="4">'.esc_html__('No Records Found!','dtdr-lite').'</td>';
					$output .= '</tr>';
				}

				$output .= '</tbody>
						</table>';

			$output .= '</div>';

		$output .= '</div>';


	    return $output;

	}
}


?>