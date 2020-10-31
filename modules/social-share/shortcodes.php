<?php

if(!function_exists('dtdr_sp_social_share')) {
	function dtdr_sp_social_share( $attrs, $content = null ) {

		$attrs = shortcode_atts ( array (

					'listing_id'       => '',
					'type'             => 'type1',
					'show_facebook'    => '',
					'show_delicious'   => '',
					'show_digg'        => '',
					'show_stumbleupon' => '',
					'show_twitter'     => '',
					'show_googleplus'  => '',
					'show_linkedin'    => '',
					'show_pinterest'   => '',
					'class'            => '',

				), $attrs, 'dtdr_sp_social_share' );

		$output = '';

		if($attrs['listing_id'] == '' && is_singular('dtdr_listings')) {
			global $post;
			$attrs['listing_id'] = $post->ID;
		}

		if($attrs['listing_id'] != '') {

			if($attrs['show_facebook'] == 'true' || $attrs['show_delicious'] == 'true' || $attrs['show_digg'] == 'true' || $attrs['show_stumbleupon'] == 'true' || $attrs['show_twitter'] == 'true' || $attrs['show_googleplus'] == 'true' || $attrs['show_linkedin'] == 'true' || $attrs['show_pinterest'] == 'true') {

				$output .= '<div class="dtdr-listings-social-share-container '.$attrs['type'].' '.$attrs['class'].'">';

					$output .= '<a class="dtdr-listings-social-share-item-icon"><span class="fas fa-share-alt"></span></a>';

					$output .= '<ul class="dtdr-listings-social-share-list">';

						$sstitle = get_the_title($attrs['listing_id']);
						$ssurl = get_permalink($attrs['listing_id']);

						if($attrs['show_facebook'] == 'true') {
							$output .= '<li> <a href="//www.facebook.com/sharer.php?u='.$ssurl.'&amp;t='.urlencode($sstitle).'" title="facebook" target="_blank"> <span class="fab fa-facebook"></span>  </a> </li>';
						}
						if($attrs['show_delicious'] == 'true') {
							$output .= '<li> <a href="//del.icio.us/post?url='.$ssurl.'&amp;title='.urlencode($sstitle).'" title="delicious" target="_blank"> <span class="fab fa-delicious"></span>  </a> </li>';
						}
						if($attrs['show_digg'] == 'true') {
							$output .= '<li> <a href="//digg.com/submit?phase=2&amp;url='.$ssurl.'&amp;title='.urlencode($sstitle).'" title="digg" target="_blank"> <span class="fab fa-digg"></span>  </a> </li>';
						}
						if($attrs['show_stumbleupon'] == 'true') {
							$output .= '<li> <a href="//www.stumbleupon.com/submit?url='.$ssurl.'&amp;title='.urlencode($sstitle).'" title="stumbleupon" target="_blank"> <span class="fab fa-stumbleupon"></span>  </a> </li>';
						}
						if($attrs['show_twitter'] == 'true') {
							$output .= '<li> <a href="//twitter.com/home/?status='.$ssurl.':'.urlencode($sstitle).'" title="twitter" target="_blank"> <span class="fab fa-twitter"></span>  </a> </li>';
						}
						if($attrs['show_googleplus'] == 'true') {
							$output .= '<li> <a href="//plus.google.com/share?url='.$ssurl.'" title="googleplus" target="_blank" onclick="javascript:window.open(this.href,\"\",\"menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600\");return false;"> <span class="fab fa-google-plus"></span>  </a> </li>';
						}
						if($attrs['show_linkedin'] == 'true') {
							$output .= '<li> <a href="//www.linkedin.com/shareArticle?mini=true&amp;title='.urlencode($sstitle).'&amp;url='.$ssurl.'" title="linkedin" target="_blank"> <span class="fab fa-linkedin"></span>  </a> </li>';
						}
						if($attrs['show_pinterest'] == 'true') {

							$featured_image_id = get_post_thumbnail_id($attrs['listing_id']);
							$media = '';
							if($featured_image_id > 0) {
								$image_details = wp_get_attachment_image_src($featured_image_id, 'full');
								$media = $image_details[0];
							}

							$output .= '<li> <a href="//pinterest.com/pin/create/button/?url='.$ssurl.'&amp;media='.$media.'" title="pinterest" target="_blank"> <span class="fab fa-pinterest"></span>  </a> </li>';

						}

					$output .= '</ul>';

				$output .= '</div>';

				wp_enqueue_style ( 'dtdr-social-share-frontend' );

				wp_enqueue_script ( 'dtdr-social-share-frontend' );

			}

		} else {

			$listing_singular_label = apply_filters( 'listing_label', 'singular' );

			$output .= sprintf( esc_html__('Please provide %1$s id to display corresponding data!','dtdr-lite'), strtolower($listing_singular_label) );

		}

		return $output;

	}
	add_shortcode ( 'dtdr_sp_social_share', 'dtdr_sp_social_share' );
}

?>