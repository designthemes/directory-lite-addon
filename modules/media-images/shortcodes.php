<?php

// Single Page - Media Images
if(!function_exists('dtdr_sp_media_images')) {
	function dtdr_sp_media_images( $attrs, $content = null ) {

		$attrs = shortcode_atts ( array (

					'listing_id'                    => '',
					'image_size'                    => 'full',
					'show_image_description'        => 'false',
					'include_featured_image'        => 'false',
					'class'                         => '',

					'carousel_effect'               => '',
					'carousel_autoplay'             => '',
					'carousel_slidesperview'        => 1,
					'carousel_loopmode'             => '',
					'carousel_mousewheelcontrol'    => '',
					'carousel_verticaldirection'    => '',
					'carousel_paginationtype'       => '',
					'carousel_numberofthumbnails'   => 3,
					'carousel_arrowpagination'      => '',
					'carousel_arrowpagination_type' => 'type1',
					'carousel_spacebetween' => ''

				), $attrs, 'dtdr_sp_media_images' );


		$output = '';

		if($attrs['listing_id'] == '' && is_singular('dtdr_listings')) {
			global $post;
			$attrs['listing_id'] = $post->ID;
		}

		if($attrs['listing_id'] != '') {

			$dtdr_media_images_ids    = get_post_meta($attrs['listing_id'], 'dtdr_media_images_ids', true);
			$dtdr_media_images_titles = get_post_meta($attrs['listing_id'], 'dtdr_media_images_titles', true);
			$dtdr_featured_image_id   = get_post_thumbnail_id($attrs['listing_id']);
			$dtdr_featured_image_id   = ($dtdr_featured_image_id != '') ? $dtdr_featured_image_id : -1;
			$uniqid = uniqid();

			$add_class = '';
			if($attrs['carousel_verticaldirection'] == 'true') {
				$add_class = 'dtdr-listings-vertical-thumb';
			}

			$media_carousel_attributes = array ();

			array_push($media_carousel_attributes, 'data-enablecarousel="true"');
			array_push($media_carousel_attributes, 'data-carouseleffect="'.$attrs['carousel_effect'].'"');
			array_push($media_carousel_attributes, 'data-carouselautoplay="'.$attrs['carousel_autoplay'].'"');
			array_push($media_carousel_attributes, 'data-carouselslidesperview="'.$attrs['carousel_slidesperview'].'"');
			array_push($media_carousel_attributes, 'data-carouselloopmode="'.$attrs['carousel_loopmode'].'"');
			array_push($media_carousel_attributes, 'data-carouselmousewheelcontrol="'.$attrs['carousel_mousewheelcontrol'].'"');
			array_push($media_carousel_attributes, 'data-carouselverticaldirection="'.$attrs['carousel_verticaldirection'].'"');
			array_push($media_carousel_attributes, 'data-carouselpaginationtype="'.$attrs['carousel_paginationtype'].'"');
			array_push($media_carousel_attributes, 'data-carouselnumberofthumbnails="'.$attrs['carousel_numberofthumbnails'].'"');
			array_push($media_carousel_attributes, 'data-carouselarrowpagination="'.$attrs['carousel_arrowpagination'].'"');
			array_push($media_carousel_attributes, 'data-carouselspacebetween="'.$attrs['carousel_spacebetween'].'"');
			array_push($media_carousel_attributes, 'data-carouselnoofimages="'.count($dtdr_media_images_ids).'"');

			if(!empty($media_carousel_attributes)) {
				$media_carousel_attributes_string = implode(' ', $media_carousel_attributes);
			}

			$output .= '<div class="dtdr-listings-image-gallery-holder '.$attrs['class'].' '.$add_class.'">';

				// Gallery Images
				$output .= '<div class="dtdr-listings-image-gallery-container swiper-container" '.$media_carousel_attributes_string.'>';
					$output .= '<div class="dtdr-listings-image-gallery swiper-wrapper">';

									if($attrs['include_featured_image'] == 'true') {
										$featured_image_id = get_post_thumbnail_id($attrs['listing_id']);
										if($featured_image_id > 0) {
											$image_details = wp_get_attachment_image_src($featured_image_id, $attrs['image_size']);
											$output .= '<div class="swiper-slide" data-hash="slide-'.$uniqid.$uniqid.'"><img src="'.esc_url($image_details[0]).'" title="'.esc_html__('Featured Image','dtdr-lite').'" alt="'.esc_html__('Featured Image','dtdr-lite').'" /></div>';
										}
									}

									if(is_array($dtdr_media_images_ids) && !empty($dtdr_media_images_ids)) {
										$i = 0;
										foreach($dtdr_media_images_ids as $dtdr_media_images_id) {
											if($dtdr_media_images_id != $dtdr_featured_image_id) {
												$dtdr_media_title = '';
												if(isset($dtdr_media_images_titles[$i])) {
													$dtdr_media_title = $dtdr_media_images_titles[$i];
												}
												$image_details = wp_get_attachment_image_src($dtdr_media_images_id, 'full');
												$output .= '<div class="swiper-slide" data-hash="slide-'.$uniqid.$i.'"><img src="'.($image_details[0]).'" alt="'.esc_html__('Gallery Image','dtdr-lite').'" />';
													if($attrs['show_image_description'] == 'true') {
														$output .= '<div class="dtdr-listings-image-gallery-title">'.$dtdr_media_title.'</div>';
													}
												$output .= '</div>';
												$i++;
											}
										}
									}

					$output .= '</div>';

					if($attrs['carousel_paginationtype'] != '' || $attrs['carousel_arrowpagination'] == 'true') {

						$output .= '<div class="dtdr-listings-swiper-pagination-holder">';

							if($attrs['carousel_paginationtype'] == 'bullets') {
								$output .= '<div class="dtdr-swiper-bullet-pagination"></div>';
							}

							if($attrs['carousel_paginationtype'] == 'progressbar') {
								$output .= '<div class="dtdr-swiper-progress-pagination"></div>';
							}

							if($attrs['carousel_paginationtype'] == 'scrollbar') {
								$output .= '<div class="dtdr-swiper-scrollbar"></div>';
							}

							if($attrs['carousel_paginationtype'] == 'fraction') {
								$output .= '<div class="dtdr-swiper-fraction-pagination"></div>';
							}

							if($attrs['carousel_arrowpagination'] == 'true') {
								$output .= '<div class="dtdr-swiper-arrow-pagination '.$attrs['carousel_arrowpagination_type'].'">';
									$output .= '<a href="#" class="dtdr-swiper-arrow-prev">'.esc_html__('Prev','dtdr-lite').'</a>';
									$output .= '<a href="#" class="dtdr-swiper-arrow-next">'.esc_html__('Next','dtdr-lite').'</a>';
								$output .= '</div>';
							}

						$output .= '</div>';

					}

				$output .= '</div>';

				if($attrs['carousel_paginationtype'] == 'thumbnail') {

					// Gallery Thumb
					$output .= '<div class="dtdr-listings-image-gallery-thumb-container swiper-container">';
						$output .= '<div class="dtdr-listings-image-gallery-thumb swiper-wrapper">';

										if($attrs['include_featured_image'] == 'true') {
											$featured_image_id = get_post_thumbnail_id($attrs['listing_id']);
											$image_details = wp_get_attachment_image_src($featured_image_id, $attrs['image_size']);

											$output .= '<div class="swiper-slide"><img src="'.esc_url($image_details[0]).'" title="'.esc_html__('Gallery Thumb','dtdr-lite').'" alt="'.esc_html__('Gallery Thumb','dtdr-lite').'" /></div>';
										}

										if(is_array($dtdr_media_images_ids) && !empty($dtdr_media_images_ids)) {
											$i = 0;
											foreach($dtdr_media_images_ids as $dtdr_media_attachments_id) {
												if(($dtdr_media_attachments_id != $dtdr_featured_image_id) || ($attrs['include_featured_image'] && $dtdr_media_attachments_id == $dtdr_featured_image_id)) {
													$dtdr_media_title = '';
													if(isset($dtdr_media_images_titles[$i])) {
														$dtdr_media_title = $dtdr_media_images_titles[$i];
													}
													$image_details = wp_get_attachment_image_src($dtdr_media_attachments_id, $attrs['image_size']);
													$output .= '<div class="swiper-slide"><img src="'.esc_url($image_details[0]).'" alt="'.esc_html__('Gallery Thumb','dtdr-lite').'" /></div>';
													$i++;
												}
											}
										}

						$output .= '</div>';
					$output .= '</div>';

				}

			$output .= '</div>';

		} else {

			$listing_singular_label = apply_filters( 'listing_label', 'singular' );

			$output .= sprintf( esc_html__('Please provide %1$s id to display corresponding data!','dtdr-lite'), strtolower($listing_singular_label) );

		}

		return $output;

	}
	add_shortcode ( 'dtdr_sp_media_images', 'dtdr_sp_media_images' );
}

?>