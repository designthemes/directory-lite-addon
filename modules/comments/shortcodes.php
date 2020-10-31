<?php

// Single Page - Featured Comments
if(!function_exists('dtdr_sp_featured_comments')) {
	function dtdr_sp_featured_comments($attrs, $content = null) {

		$attrs = shortcode_atts ( array (

			'enable_title'  => 'false',
			'enable_rating' => 'false',
			'enable_media'  => 'false',
			'class'         => '',

		), $attrs, 'dtdr_sp_featured_comments' );

		$output = '';

		set_query_var('dtdr_sp_comments_title', $attrs['enable_title']);
		set_query_var('dtdr_sp_comments_rating', $attrs['enable_rating']);
		set_query_var('dtdr_sp_comments_media', $attrs['enable_media']);

		ob_start();

			comments_template();
			$comment_list_template = ob_get_contents();

		ob_end_clean();

		$output .= '<div class="dtdr-listings-comment-list-holder '.$attrs['class'].'">';
			$output .= $comment_list_template;
		$output .= '</div>';

		return $output;

	}
	add_shortcode ( 'dtdr_sp_featured_comments', 'dtdr_sp_featured_comments' );
}

// Single Page - Average Rating
if(!function_exists('dtdr_sp_average_rating')) {
	function dtdr_sp_average_rating( $attrs, $content = null ) {

		$attrs = shortcode_atts ( array (

					'listing_id' => '',
					'display'    => 'both',
					'type'       => 'type1',
					'class'      => '',

				), $attrs, 'dtdr_sp_average_rating' );

		$output = '';

		if($attrs['listing_id'] == '' && is_singular('dtdr_listings')) {
			global $post;
			$attrs['listing_id'] = $post->ID;
		}

		if($attrs['listing_id'] != '') {

			$output .= '<div class="dtdr-listings-average-rating-container '.$attrs['type'].' '.$attrs['class'].'">';

				$dtdr_average_ratings = get_post_meta($attrs['listing_id'], 'dtdr_average_ratings', true);
				$dtdr_average_ratings = round($dtdr_average_ratings, 2);
				if($dtdr_average_ratings == '') {
					$dtdr_average_ratings = 0;
				}

				$dtdr_rating_display_html = '';
				if($attrs['display'] == 'star-rating' || $attrs['display'] == 'both') {
					$dtdr_rating_display_html .= '<div class="dtdr-listings-average-rating-holder">';
						$dtdr_rating_display_html .= dtdr_comment_rating_display($dtdr_average_ratings);
					$dtdr_rating_display_html .= '</div>';
				}

				$dtdr_average_ratings_html = $dtdr_average_ratings_type2_html = '';
				if($attrs['display'] == 'overall-rating' || $attrs['display'] == 'both') {
					$dtdr_average_ratings_html .= '<div class="dtdr-listings-average-rating-overall"><span>'.$dtdr_average_ratings.'</span>/<span>5</span></div>';
					$dtdr_average_ratings_type2_html .= '<div class="dtdr-listings-average-rating-overall"><span>'.$dtdr_average_ratings.'</span></div>';
				}

				$comments = get_approved_comments( $attrs['listing_id'] );
				$total_comments = count($comments);

				$dtdr_reviews_count_html = '<div class="dtdr-listings-average-rating-reviews-count">'.sprintf(esc_html__('%1$s reviews','dtdr-lite'), $total_comments).'</div>';

				if($attrs['type'] == 'type1') {
					$output .= $dtdr_rating_display_html;
					$output .= $dtdr_average_ratings_html;
				} else if($attrs['type'] == 'type2') {
					$output .= $dtdr_average_ratings_html;
					$output .= $dtdr_rating_display_html;
					$output .= $dtdr_reviews_count_html;
				} else if($attrs['type'] == 'type3') {
					$output .= $dtdr_average_ratings_type2_html;
					$output .= $dtdr_rating_display_html;
					$output .= $dtdr_reviews_count_html;
				} else {
					$output .= $dtdr_average_ratings_type2_html;
					$output .= $dtdr_rating_display_html;
				}


			$output .= '</div>';

		} else {

			$listing_singular_label = apply_filters( 'listing_label', 'singular' );

			$output .= sprintf( esc_html__('Please provide %1$s id to display corresponding data!','dtdr-lite'), strtolower($listing_singular_label) );

		}

		return $output;

	}
	add_shortcode ( 'dtdr_sp_average_rating', 'dtdr_sp_average_rating' );
}
?>