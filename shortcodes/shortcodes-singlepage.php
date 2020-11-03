<?php

if( !class_exists('DTDirectoryLiteSinglePageShortcodes') ) {

	class DTDirectoryLiteSinglePageShortcodes {

		/**
		 * Instance variable
		 */
		private static $_instance = null;

		/**
		 * Instance
		 *
		 * Ensures only one instance of the class is loaded or can be loaded.
		 */
		public static function instance() {

			if ( is_null( self::$_instance ) ) {
				self::$_instance = new self();
			}

			return self::$_instance;
		}

		function __construct() {

			add_shortcode ( 'dtdr_sp_featured_image', array ( $this, 'dtdr_sp_featured_image' ) );
			add_shortcode ( 'dtdr_sp_featured_item', array ( $this, 'dtdr_sp_featured_item' ) );
			add_shortcode ( 'dtdr_sp_features', array ( $this, 'dtdr_sp_features' ) );
			add_shortcode ( 'dtdr_sp_contact_details', array ( $this, 'dtdr_sp_contact_details' ) );
			add_shortcode ( 'dtdr_sp_contact_details_request_btn', array ( $this, 'dtdr_sp_contact_details_request_btn' ) );
			add_shortcode ( 'dtdr_sp_social_links', array ( $this, 'dtdr_sp_social_links' ) );
			add_shortcode ( 'dtdr_sp_comments', array ( $this, 'dtdr_sp_comments' ) );
			add_shortcode ( 'dtdr_sp_utils', array ( $this, 'dtdr_sp_utils' ) );
			add_shortcode ( 'dtdr_sp_taxonomy', array ( $this, 'dtdr_sp_taxonomy' ) );
			add_shortcode ( 'dtdr_sp_contact_form', array ( $this, 'dtdr_sp_contact_form' ) );
			add_shortcode ( 'dtdr_sp_post_date', array ( $this, 'dtdr_sp_post_date' ) );
			add_shortcode ( 'dtdr_sp_mls_number', array ( $this, 'dtdr_sp_mls_number' ) );

		}


		function dtdr_shortcodeHelper($content = null) {
			$content = do_shortcode ( shortcode_unautop ( $content ) );
			$content = preg_replace ( '#^<\/p>|^<br \/>|<p>$#', '', $content );
			$content = preg_replace ( '#<br \/>#', '', $content );
			return trim ( $content );
		}

		function dtdr_sp_featured_image( $attrs, $content = null ) {

			$attrs = shortcode_atts ( array (
				'listing_id' => '',
				'image_size' => 'full',
				'with_link'  => '',
				'class'      => '',
			), $attrs, 'dtdr_sp_featured_image' );


			$output = '';

			if($attrs['listing_id'] == '' && is_singular('dtdr_listings')) {
				global $post;
				$attrs['listing_id'] = $post->ID;
			}

			if($attrs['listing_id'] != '') {

				$featured_image_id = get_post_thumbnail_id($attrs['listing_id']);
				$image_details = wp_get_attachment_image_src($featured_image_id, $attrs['image_size']);

				$output .= '<div class="dtdr-listings-feature-image-holder '.esc_attr( $attrs['class'] ).'">';

					if($attrs['with_link'] == 'true') {
						$output .= '<a href="'.esc_url( get_permalink($attrs['listing_id']) ).'">';
					}
						$output .= '<img src="'.esc_url($image_details[0]).'" title="'.esc_attr__('Featured Image','dtdr-lite').'" all="'.esc_attr__('Featured Image','dtdr-lite').'" />';
					if($attrs['with_link'] == 'true') {
						$output .= '</a>';
					}

				$output .= '</div>';

			} else {

				$listing_singular_label = apply_filters( 'listing_label', 'singular' );

				$output .= sprintf( esc_html__('Please provide %1$s id to display corresponding data!','dtdr-lite'), strtolower($listing_singular_label) );

			}

			return $output;

		}

		function dtdr_sp_featured_item( $attrs, $content = null ) {

			$attrs = shortcode_atts ( array (
				'listing_id' => '',
				'type'       => 'type1',
				'class'      => '',
			), $attrs, 'dtdr_sp_featured_item' );

			$output = '';

			if($attrs['listing_id'] == '' && is_singular('dtdr_listings')) {
				global $post;
				$attrs['listing_id'] = $post->ID;
			}

			if($attrs['listing_id'] != '') {

				$dtdr_featured_item = get_post_meta($attrs['listing_id'], 'dtdr_featured_item', true);
				if($dtdr_featured_item == 'true') {

					$output .= '<div class="dtdr-listings-featured-item-container '.esc_attr( $attrs['class'] ).' '.esc_attr( $attrs['type'] ).'">';
						$output .= '<span>'.esc_html__('Featured','dtdr-lite').'</span>';
					$output .= '</div>';

				}

			} else {

				$listing_singular_label = apply_filters( 'listing_label', 'singular' );
				$output .= sprintf( esc_html__('Please provide %1$s id to display corresponding data!','dtdr-lite'), strtolower($listing_singular_label) );

			}

			return $output;

		}

		function dtdr_sp_features( $attrs, $content = null ) {

			$attrs = shortcode_atts ( array (
				'listing_id'             => '',
				'type'                   => 'type1',
				'include'                => '',
				'columns'                => 4,
				'features_image_or_icon' => '',
				'class'                  => '',
			), $attrs, 'dtdr_sp_features' );

			$output = '';

			if($attrs['listing_id'] == '' && is_singular('dtdr_listings')) {
				global $post;
				$attrs['listing_id'] = $post->ID;
			}

			if($attrs['listing_id'] != '') {

				if($attrs['columns'] == 1) {
					$column_class = 'dtdr-column dtdr-one-column';
				} else if($attrs['columns'] == 2) {
					$column_class = 'dtdr-column dtdr-one-half';
				} else if($attrs['columns'] == 3) {
					$column_class = 'dtdr-column dtdr-one-third';
				} else if($attrs['columns'] == 4) {
					$column_class = 'dtdr-column dtdr-one-fourth';
				} else if($attrs['columns'] == -1) {
					if($attrs['type'] == 'listing') {
						$column_class = '';
					} else {
						$column_class = '';
						$attrs['class'] .= ' dtdr-no-column';
					}
				}

				$output .= '<div class="dtdr-listings-features-box-container '.esc_attr( $attrs['type'] ).' '.esc_attr( $attrs['class'] ).'">';

					$dtdr_features_title = $dtdr_features_subtitle = $dtdr_features_value = $dtdr_features_valueunit = $dtdr_features_icon = $dtdr_features_image = '';
					if($attrs['listing_id'] > 0) {
						$dtdr_features_title = get_post_meta($attrs['listing_id'], 'dtdr_features_title', true);
						$dtdr_features_subtitle = get_post_meta($attrs['listing_id'], 'dtdr_features_subtitle', true);
						$dtdr_features_value = get_post_meta($attrs['listing_id'], 'dtdr_features_value', true);
						$dtdr_features_valueunit = get_post_meta($attrs['listing_id'], 'dtdr_features_valueunit', true);
						$dtdr_features_icon = get_post_meta($attrs['listing_id'], 'dtdr_features_icon', true);
						$dtdr_features_image = get_post_meta($attrs['listing_id'], 'dtdr_features_image', true);
					}

					if($attrs['include'] != '') {
						$include_keys = explode(',', $attrs['include']);
					} else {
						if($attrs['type'] == 'listing') {
							$include_keys = array_keys($dtdr_features_title);
							array_splice($include_keys, 4);
						} else {
							$include_keys = array_keys($dtdr_features_title);
						}
					}

					$j = 0; $i = 1;
					if(is_array($dtdr_features_title) && !empty($dtdr_features_title)) {
						foreach($dtdr_features_title as $dtdr_feature_title) {

							if(in_array($j, $include_keys)) {

								if($i == 1 && $attrs['columns'] != -1) { $first_class = 'first';  } else { $first_class = ''; }
								if($i == $attrs['columns']) { $i = 1; } else { $i = $i + 1; }

								$dtdr_features_image_html = $style_attr = '';
								$image_url = wp_get_attachment_image_src($dtdr_features_image[$j], 'full');
								if($image_url != '') {
									$dtdr_features_image_html .= ' <div class="dtdr-listings-features-box-item-img"  style="background-image:url('.esc_url($image_url[0]).');"></div>';
									if($attrs['type'] == 'listing' && $attrs['features_image_or_icon'] == 'image') {
										$style_attr .= 'style="background-image:url('.esc_url($image_url[0]).');"';
									}
								}

								$dtdr_features_icon_html = '';
								if(($attrs['type'] == 'listing' && $attrs['features_image_or_icon'] == 'icon' && isset($dtdr_features_icon[$j]) && !empty($dtdr_features_icon[$j])) || ($attrs['type'] != 'listing' && isset($dtdr_features_icon[$j]) && !empty($dtdr_features_icon[$j]))) {
									$dtdr_features_icon_html .= '<div class="dtdr-listings-features-box-item-icon"><span class="'.esc_attr($dtdr_features_icon[$j]).'"></span></div>';
								}

								$dtdr_features_title_html = '';
								if(isset($dtdr_feature_title) && !empty($dtdr_feature_title)) {
									$dtdr_features_title_html .= '<div class="dtdr-listings-features-box-item-title">'.esc_attr($dtdr_feature_title).'</div>';
								}

								$dtdr_features_subtitle_html = '';
								if(isset($dtdr_features_subtitle[$j]) && !empty($dtdr_features_subtitle[$j])) {
									$dtdr_features_subtitle_html .= '<div class="dtdr-listings-features-box-item-subtitle">'.esc_attr($dtdr_features_subtitle[$j]).'</div>';
								}

								$dtdr_features_value_html = '';
								if(isset($dtdr_features_value[$j]) && !empty($dtdr_features_value[$j])) {
									$dtdr_features_value_html .= '<div class="dtdr-listings-features-box-item-value">';
										$dtdr_features_value_html .= esc_attr($dtdr_features_value[$j]);
										if(isset($dtdr_features_valueunit[$j]) && !empty($dtdr_features_valueunit[$j])) {
											$dtdr_features_value_html .= '<span>'.esc_attr($dtdr_features_valueunit[$j]).'</span>';
										}
									$dtdr_features_value_html .= '</div>';
								}


								$output .= '<div class="dtdr-listings-features-box-item '.esc_attr($column_class).' '.esc_attr($first_class).'" '.$style_attr.'>';

									if($attrs['type'] == 'listing') {
										$output .= $dtdr_features_icon_html;
										$output .= $dtdr_features_title_html;
										$output .= $dtdr_features_value_html;
									} else if($attrs['type'] == 'type1') {
										$output .= $dtdr_features_title_html;
										$output .= $dtdr_features_value_html;
									} else if($attrs['type'] == 'type2') {
										$output .= $dtdr_features_image_html;
										$output .= $dtdr_features_title_html;
										$output .= $dtdr_features_value_html;
									} else if($attrs['type'] == 'type3') {
										$output .= $dtdr_features_icon_html;
										$output .= $dtdr_features_title_html;
										$output .= $dtdr_features_value_html;
									} else if($attrs['type'] == 'type4') {
										$output .= $dtdr_features_title_html;
										$output .= $dtdr_features_value_html;
									} else if($attrs['type'] == 'type5') {
										$output .= $dtdr_features_title_html;
										$output .= $dtdr_features_value_html;
									} else if($attrs['type'] == 'type6') {
										$output .= $dtdr_features_image_html;
										$output .= '<div class="dtdr-listings-features-box-item-details">';
											$output .= $dtdr_features_title_html;
											$output .= $dtdr_features_value_html;
										$output .= '</div>';
									} else if($attrs['type'] == 'type7') {
										$output .= $dtdr_features_title_html;
										$output .= $dtdr_features_value_html;
									}

								$output .= '</div>';

							}

							$j++;

						}
					}

				$output .= '</div>';

			} else {

				$listing_singular_label = apply_filters( 'listing_label', 'singular' );
				$output .= sprintf( esc_html__('Please provide %1$s id to display corresponding data!','dtdr-lite'), strtolower($listing_singular_label) );

			}

			return $output;

		}

		function dtdr_sp_contact_details( $attrs, $content = null ) {

			$attrs = shortcode_atts ( array (
				'listing_id'              => '',
				'type'                    => '',
				'contact_details'         => 'list',
				'include_address'         => '',
				'include_email'           => '',
				'include_phone'           => '',
				'include_mobile'          => '',
				'include_skype'           => '',
				'include_website'         => '',
				'requires_buyer_packages' => '',
				'show_direction_link'     => '',
				'class'                   => '',
			), $attrs, 'dtdr_sp_contact_details' );

			$output = '';

			if($attrs['listing_id'] == '' && is_singular('dtdr_listings')) {
				global $post;
				$attrs['listing_id'] = $post->ID;
			}

			if($attrs['listing_id'] != '') {

				if($attrs['type'] == 'listing') {
					$attrs['type'] = '';
				}

				$current_user = wp_get_current_user();
				$user_id = $current_user->ID;

				$dtdr_buyer_package_listings = get_user_meta($user_id, 'dtdr_buyer_package_listings', true);
				$dtdr_buyer_package_listings = (is_array($dtdr_buyer_package_listings) && !empty($dtdr_buyer_package_listings)) ? $dtdr_buyer_package_listings : array ();
				$dtdr_buyer_package_listings = array_unique($dtdr_buyer_package_listings);


				if(($attrs['requires_buyer_packages'] != 'true') || ($attrs['requires_buyer_packages'] == 'true' && in_array($attrs['listing_id'], $dtdr_buyer_package_listings))) {

					$output .= '<div class="dtdr-listings-contactdetails-container '.esc_attr( $attrs['type'] ).' '.esc_attr( $attrs['class'] ).'">';

						$output .= '<ul class="dtdr-listings-contactdetails-list">';

							$dtdr_modules = dtdirectorylite_instance()->active_modules;
							$dtdr_modules = (is_array($dtdr_modules) && !empty($dtdr_modules)) ? $dtdr_modules : array ();

							if($attrs['include_address'] == 'true' && in_array('location', $dtdr_modules)) {

								$dtdr_latitude  = get_post_meta($attrs['listing_id'], 'dtdr_latitude', true);
								$dtdr_longitude = get_post_meta($attrs['listing_id'], 'dtdr_longitude', true);
								$dtdr_address   = get_post_meta($attrs['listing_id'], 'dtdr_address', true);
								$dtdr_zip       = get_post_meta($attrs['listing_id'], 'dtdr_zip', true);
								$dtdr_country   = get_post_meta($attrs['listing_id'], 'dtdr_country', true);

								$contact_address = $dtdr_address;
								if($dtdr_country != '') {
									$contact_address .= ', '.$dtdr_country;
								}
								if($dtdr_zip != '') {
									$contact_address .= ' '.$dtdr_zip;
								}

								$contact_address = trim($contact_address, ',');

								if($contact_address != '') {
									$output .= '<li><span class="fa fa-map-marker"></span>';
										$output .= '<p>';
											$output .= $contact_address;
											if($attrs['show_direction_link'] == 'true') {
												$output .= '<br><a href="//maps.google.com/maps?daddr='.$dtdr_latitude.','.$dtdr_longitude.'" class="dtdr-listings-address-directions" target="_blank">'.esc_html__('Get Direction','dtdr-lite').'<span class="fa fa-angle-right"></span></a>';
											}
										$output .= '</p>';
									$output .= '</li>';
								}

							}

							if($attrs['contact_details'] == 'author') {

								$author = get_post($attrs['listing_id']);
								$author_id = $author->post_author;

								if($attrs['include_email'] == 'true') {
									$dtdr_email = get_the_author_meta( 'user_email' , $author_id );
									if($dtdr_email != '') {
										$output .= '<li><span class="fa fa-envelope"></span><a href="mailto:'.sanitize_email($dtdr_email).'">'.esc_html($dtdr_email).'</a></li>';
									}
								}

								if($attrs['include_phone'] == 'true') {
									$dtdr_phone = get_the_author_meta( 'dtdr_user_phone' , $author_id );
									if($dtdr_phone != '') {
										$output .= '<li><span class="fa fa-phone"></span><a href="tel:'.esc_attr($dtdr_phone).'" class="phone" data-listingid="'.esc_attr($attrs['listing_id']).'"  data-userid="'.esc_attr($user_id).'" target="_blank">'.esc_html($dtdr_phone).'</a></li>';
									}
								}

								if($attrs['include_mobile'] == 'true') {
									$dtdr_mobile = get_the_author_meta( 'dtdr_user_mobile' , $author_id );
									if($dtdr_mobile != '') {
										$output .= '<li><span class="fa fa-mobile"></span><a href="tel:'.esc_attr($dtdr_mobile).'" class="mobile" data-listingid="'.esc_attr($attrs['listing_id']).'"  data-userid="'.esc_attr($user_id).'" target="_blank">'.esc_html($dtdr_mobile).'</a></li>';
									}
								}

								if($attrs['include_skype'] == 'true') {
									$dtdr_skype = get_the_author_meta( 'dtdr_user_skype' , $author_id );
									if($dtdr_skype != '') {
										$output .= '<li><span class="fab fa-skype"></span>'.esc_html($dtdr_skype).'</li>';
									}
								}

								if($attrs['include_website'] == 'true') {
									$dtdr_website = get_the_author_meta( 'dtdr_user_website' , $author_id );
									if($dtdr_website != '') {
										$output .= '<li><span class="fa fa-globe"></span><a href="'.esc_url($dtdr_website).'" class="web" data-listingid="'.esc_attr($attrs['listing_id']).'"  data-userid="'.esc_attr($user_id).'" target="_blank">'.esc_html($dtdr_website).'</a></li>';
									}
								}

							} else if($attrs['contact_details'] == 'list') {

								if($attrs['include_email'] == 'true') {
									$dtdr_email = get_post_meta($attrs['listing_id'], 'dtdr_email', true);
									if($dtdr_email != '') {
										$output .= '<li><span class="fa fa-envelope"></span><a href="mailto:'.esc_attr($dtdr_email).'">'.esc_attr($dtdr_email).'</a></li>';
									}
								}

								if($attrs['include_phone'] == 'true') {
									$dtdr_phone = get_post_meta($attrs['listing_id'], 'dtdr_phone', true);
									if($dtdr_phone != '') {
										$output .= '<li><span class="fa fa-phone"></span><a href="tel:'.sanitize_email($dtdr_phone).'" class="phone" data-listingid="'.esc_attr($attrs['listing_id']).'"  data-userid="'.esc_attr($user_id).'" target="_blank">'.esc_html($dtdr_phone).'</a></li>';
									}
								}

								if($attrs['include_mobile'] == 'true') {
									$dtdr_mobile = get_post_meta($attrs['listing_id'], 'dtdr_mobile', true);
									if($dtdr_mobile != '') {
										$output .= '<li><span class="fa fa-mobile"></span><a href="tel:'.esc_attr($dtdr_mobile).'" class="mobile" data-listingid="'.esc_attr($attrs['listing_id']).'"  data-userid="'.esc_attr($user_id).'" target="_blank">'.esc_html($dtdr_mobile).'</a></li>';
									}
								}

								if($attrs['include_skype'] == 'true') {
									$dtdr_skype = get_post_meta($attrs['listing_id'], 'dtdr_skype', true);
									if($dtdr_skype != '') {
										$output .= '<li><span class="fab fa-skype"></span>'.esc_html($dtdr_skype).'</li>';
									}
								}

								if($attrs['include_website'] == 'true') {
									$dtdr_website = get_post_meta($attrs['listing_id'], 'dtdr_website', true);
									if($dtdr_website != '') {
										$output .= '<li><span class="fa fa-globe"></span><a href="'.esc_url($dtdr_website).'" class="web" data-listingid="'.esc_attr($attrs['listing_id']).'"  data-userid="'.esc_attr($user_id).'" target="_blank">'.esc_html($dtdr_website).'</a></li>';
									}
								}

							}

						$output .= '</ul>';

					$output .= '</div>';

				}

			} else {

				$listing_singular_label = apply_filters( 'listing_label', 'singular' );

				$output .= sprintf( esc_html__('Please provide %1$s id to display corresponding data!','dtdr-lite'), strtolower($listing_singular_label) );

			}

			return $output;

		}

		function dtdr_sp_contact_details_request_btn( $attrs, $content = null ) {

			$attrs = shortcode_atts ( array (
				'listing_id'   => '',
				'type'         => '',
				'button_label' => '',
				'class'        => '',
			), $attrs, 'dtdr_sp_contact_details_request_btn' );

			$output = '';

			if($attrs['listing_id'] == '' && is_singular('dtdr_listings')) {
				global $post;
				$attrs['listing_id'] = $post->ID;
			}

			if($attrs['listing_id'] != '') {

				$button_label_str = esc_html__('Send Request','dtdr-lite');
				if(isset($attrs['button_label']) && $attrs['button_label'] != '') {
					$button_label_str = esc_html($attrs['button_label']);
				}

				$current_user = wp_get_current_user();
				$user_id = $current_user->ID;

				if($user_id > 0) {

					$dtdr_buyer_package_listings = get_user_meta($user_id, 'dtdr_buyer_package_listings', true);
					$dtdr_buyer_package_listings = (is_array($dtdr_buyer_package_listings) && !empty($dtdr_buyer_package_listings)) ? $dtdr_buyer_package_listings : array ();

					$dtdr_buyer_package_listings = array_unique($dtdr_buyer_package_listings);

					if(!in_array($attrs['listing_id'], $dtdr_buyer_package_listings)) {

						$output .= '<div class="dtdr-listings-contactdetails-request-container '.esc_attr( $attrs['type'] ).' '.esc_attr( $attrs['class'] ).'">';
							$output .= '<a class="dtdr-listings-contactdetails-request-button dtdr-listings-contactdetails-request" data-listingid="'.esc_attr($attrs['listing_id']).'" href="#">'.$button_label_str.'</a>';
						$output .= '</div>';

					}

				} else {

					$output .= '<div class="dtdr-listings-contactdetails-request-container '.esc_attr( $attrs['type'] ).' '.esc_attr( $attrs['class'] ).'">';
						$output .= '<a class="dtdr-listings-contactdetails-request-button dtdr-login-link" data-listingid="'.esc_attr($attrs['listing_id']).'" href="#">'.$button_label_str.'</a>';
					$output .= '</div>';

				}

			} else {

				$listing_singular_label = apply_filters( 'listing_label', 'singular' );

				$output .= sprintf( esc_html__('Please provide %1$s id to display corresponding data!','dtdr-lite'), strtolower($listing_singular_label) );

			}

			return $output;

		}

		function dtdr_sp_social_links( $attrs, $content = null ) {

			$attrs = shortcode_atts ( array (
				'listing_id'   => '',
				'social_links' => 'list',
				'type'         => '',
				'class'        => '',
			), $attrs, 'dtdr_sp_social_links' );

			$output = '';

			if($attrs['listing_id'] == '' && is_singular('dtdr_listings')) {
				global $post;
				$attrs['listing_id'] = $post->ID;
			}

			if($attrs['listing_id'] != '') {

				$output .= '<div class="dtdr-listings-sociallinks-container '.esc_attr( $attrs['type'] ).' '.esc_attr( $attrs['class'] ).'">';

					$output .= '<ul class="dtdr-listings-sociallinks-list">';

						if($attrs['social_links'] == 'seller') {

							$author = get_post($attrs['listing_id']);
							$author_id = $author->post_author;

							$dtdr_social_items = get_the_author_meta('dtdr_user_social_items', $author_id);
							$dtdr_social_items = (isset($dtdr_social_items) && is_array($dtdr_social_items)) ? $dtdr_social_items : array ();

							$dtdr_social_items_value = get_the_author_meta('dtdr_user_social_items_value', $author_id);
							$dtdr_social_items_value = (isset($dtdr_social_items_value) && is_array($dtdr_social_items_value)) ? $dtdr_social_items_value : array ();

						} else {

							$dtdr_social_items = get_post_meta($attrs['listing_id'], 'dtdr_social_items', true);
							$dtdr_social_items = (isset($dtdr_social_items) && is_array($dtdr_social_items)) ? $dtdr_social_items : array ();

							$dtdr_social_items_value = get_post_meta($attrs['listing_id'], 'dtdr_social_items_value', true);
							$dtdr_social_items_value = (isset($dtdr_social_items_value) && is_array($dtdr_social_items_value)) ? $dtdr_social_items_value : array ();

						}


						$i = 0;
						if(is_array($dtdr_social_items) && !empty($dtdr_social_items)) {
							foreach($dtdr_social_items as $dtdr_social_item) {
								$output .= '<li><a href="'.esc_url($dtdr_social_items_value[$i]).'"><span class="fab '.esc_attr($dtdr_social_item).'"></span></a></li>';
								$i++;
							}
						}

					$output .= '</ul>';

				$output .= '</div>';

			} else {

				$listing_singular_label = apply_filters( 'listing_label', 'singular' );

				$output .= sprintf( esc_html__('Please provide %1$s id to display corresponding data!','dtdr-lite'), strtolower($listing_singular_label) );

			}

			return $output;

		}

		function dtdr_sp_comments( $attrs, $content = null ) {

			$attrs = shortcode_atts ( array (
				'class' => '',
			), $attrs, 'dtdr_sp_comments' );

			$output = '';

			ob_start();

				comments_template();
				$comment_list_template = ob_get_contents();

			ob_end_clean();

			$output .= '<div class="dtdr-listings-comment-list-holder '.esc_attr( $attrs['class'] ).'">';
				$output .= $comment_list_template;
			$output .= '</div>';

			return $output;

		}

		function dtdr_sp_utils( $attrs, $content = null ) {

			$attrs = shortcode_atts ( array (
				'listing_id'                    => '',
				'show_title'                    => '',
				'show_address'                  => '',
				'show_contactdetails'           => '',
				'show_contactdetails_onrequest' => '',
				'show_favourite'                => '',
				'show_pageview'                 => '',
				'show_print'                    => '',
				'show_socialshare'              => '',
				'show_averagerating'            => '',
				'show_featured'                 => '',
				'show_categories'               => '',
				'show_cities'                   => '',
				'show_neighborhoods'            => '',
				'show_countystate'              => '',
				'show_contracttype'             => '',
				'show_amenity'                  => '',
				'show_price'                    => '',
				'show_startdate'                => '',
				'show_enddate'                  => '',
				'show_posteddate'               => '',
				'show_mergeddates'              => '',
				'class'                         => '',
			), $attrs, 'dtdr_sp_utils' );

			$output = '';

			if($attrs['listing_id'] == '' && is_singular('dtdr_listings')) {
				global $post;
				$attrs['listing_id'] = $post->ID;
			}

			if($attrs['listing_id'] != '') {

				$output .= '<div class="dtdr-listings-utils-container '.esc_attr( $attrs['class'] ).'">';

					if($attrs['show_title'] == 'true') {

						$output .= '<div class="dtdr-listings-utils-item dtdr-listings-utils-title">';
							$output .= '<h3 class="dtdr-listings-utils-title-item"><a href="'.esc_url( get_permalink($attrs['listing_id']) ).'">'.get_the_title($attrs['listing_id']).'</a></h3>';
						$output .= '</div>';

					}

					if($attrs['show_startdate'] == 'true' || $attrs['show_enddate'] == 'true' || $attrs['show_posteddate'] == 'true' || $attrs['show_mergeddates'] == 'true') {

						$include_startdate = '';
						if($attrs['show_startdate'] == 'true') {
							$include_startdate = 'true';
						}

						$include_enddate = '';
						if($attrs['show_enddate'] == 'true') {
							$include_enddate = 'true';
						}

						$include_postdate = '';
						if($attrs['show_posteddate'] == 'true') {
							$include_postdate = 'true';
						}

						$merge_dates = '';
						if($attrs['show_mergeddates'] == 'true') {
							$merge_dates = 'true';
						}

						$output .= '<div class="dtdr-listings-utils-item dtdr-listings-utils-dates">';
							$output .= do_shortcode('[dtdr_sp_event_dates listing_id="'.esc_attr($attrs['listing_id']).'" include_startdate="'.esc_attr($include_startdate).'" include_enddate="'.esc_attr($include_enddate).'" include_postdate="'.esc_attr($include_postdate).'" merge_dates="'.esc_attr($merge_dates).'" with_icon="true" type="" /]');
						$output .= '</div>';

					}

					if($attrs['show_address'] == 'true' || $attrs['show_contactdetails'] != '') {

						$include_address = '';
						if($attrs['show_address'] == 'true') {
							$include_address = 'true';
						}

						$include_phone = $include_mobile = '';
						if($attrs['show_contactdetails'] != '') {
							$include_phone = 'true';
							$include_mobile = 'true';
						}

						$requires_buyer_packages = '';
						if($attrs['show_contactdetails_onrequest'] == 'true') {
							$requires_buyer_packages = 'true';
						}

						$output .= '<div class="dtdr-listings-utils-item dtdr-listings-utils-contactdetails">';
							$output .= do_shortcode('[dtdr_sp_contact_details listing_id="'.esc_attr($attrs['listing_id']).'" contact_details="'.esc_attr($attrs['show_contactdetails']).'" include_address="'.esc_attr($include_address).'" include_phone="'.esc_attr($include_phone).'" include_mobile="'.esc_attr($include_mobile).'" requires_buyer_packages="'.esc_attr($requires_buyer_packages).'" /]');
						$output .= '</div>';

					}

					if($attrs['show_favourite'] == 'true') {

						$current_user = wp_get_current_user();
						$user_id = $current_user->ID;

						$favourite_items = get_user_meta($user_id, 'favourite_items', true);
						$favourite_items = (is_array($favourite_items) && !empty($favourite_items)) ? $favourite_items : array();

						$favourite_attr = 'data-listingid="'.$attrs['listing_id'].'"';
						if($user_id > 0) {
							if(in_array($attrs['listing_id'], $favourite_items)) {
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

						$output .= '<div class="dtdr-listings-utils-item dtdr-listings-utils-favourite">';
							$output .= '<a class="dtdr-listings-utils-favourite-item '.esc_attr( $favourite_class ).'" '.$favourite_attr.'><span class="'.$favourite_icon_class.'"></span></a>';
						$output .= '</div>';

					}

					if($attrs['show_pageview'] == 'true') {

						$total_views = get_post_meta($attrs['listing_id'], 'dtdr_total_views', true);
						$total_views = ($total_views != '') ? $total_views : 0;

						$output .= '<div class="dtdr-listings-utils-item dtdr-listings-utils-pageview">';
							$output .= '<a class="dtdr-listings-utils-pageview-item"><span class="fa fa-eye-slash"></span>'.esc_html($total_views).'</a>';
						$output .= '</div>';

					}

					if($attrs['show_print'] == 'true') {

						$output .= '<div class="dtdr-listings-utils-item dtdr-listings-utils-print">';
							$output .= '<a class="dtdr-listings-utils-print-item"><span class="fa fa-print"></span></a>';
						$output .= '</div>';

					}

					if($attrs['show_socialshare'] == 'true') {

						$output .= '<div class="dtdr-listings-utils-item dtdr-listings-utils-socialshare">';
							$output .= do_shortcode('[dtdr_sp_social_share listing_id="'.esc_attr($attrs['listing_id']).'" show_facebook="true" show_delicious="true" show_digg="true" show_stumbleupon="true" show_twitter="true" show_googleplus="true" show_linkedin="true" show_pinterest="true" /]');
						$output .= '</div>';

					}

					if($attrs['show_averagerating'] == 'true') {

						$output .= '<div class="dtdr-listings-utils-item dtdr-listings-utils-averagerating">';
							$output .= do_shortcode('[dtdr_sp_average_rating listing_id="'.esc_attr($attrs['listing_id']).'" display="both" type="" /]');
						$output .= '</div>';

					}

					if($attrs['show_featured'] == 'true') {

						$output .= '<div class="dtdr-listings-utils-item dtdr-listings-utils-featured-item">';
							$output .= do_shortcode('[dtdr_sp_featured_item listing_id="'.esc_attr($attrs['listing_id']).'" type="" /]');
						$output .= '</div>';

					}

					if($attrs['show_categories'] == 'true') {

						$output .= '<div class="dtdr-listings-utils-item dtdr-listings-utils-categories">';
							$output .= do_shortcode('[dtdr_sp_taxonomy listing_id="'.esc_attr($attrs['listing_id']).'" taxonomy="dtdr_listings_category" type="utils" /]');
						$output .= '</div>';

					}

					if($attrs['show_cities'] == 'true') {

						$output .= '<div class="dtdr-listings-utils-item dtdr-listings-utils-cities">';
							$output .= do_shortcode('[dtdr_sp_taxonomy listing_id="'.esc_attr($attrs['listing_id']).'" taxonomy="dtdr_listings_city" type="utils" /]');
						$output .= '</div>';

					}

					if($attrs['show_neighborhoods'] == 'true') {

						$output .= '<div class="dtdr-listings-utils-item dtdr-listings-utils-neighborhoods">';
							$output .= do_shortcode('[dtdr_sp_taxonomy listing_id="'.esc_attr($attrs['listing_id']).'" taxonomy="dtdr_listings_neighborhood" type="utils" /]');
						$output .= '</div>';

					}

					if($attrs['show_countystate'] == 'true') {

						$output .= '<div class="dtdr-listings-utils-item dtdr-listings-utils-countystate">';
							$output .= do_shortcode('[dtdr_sp_taxonomy listing_id="'.esc_attr($attrs['listing_id']).'" taxonomy="dtdr_listings_countystate" type="utils" /]');
						$output .= '</div>';

					}

					if($attrs['show_contracttype'] == 'true') {

						$output .= '<div class="dtdr-listings-utils-item dtdr-listings-utils-contracttype">';
							$output .= do_shortcode('[dtdr_sp_taxonomy listing_id="'.esc_attr($attrs['listing_id']).'" taxonomy="dtdr_listings_ctype" type="utils" /]');
						$output .= '</div>';

					}

					if($attrs['show_amenity'] == 'true') {

						$output .= '<div class="dtdr-listings-utils-item dtdr-listings-utils-contracttype">';
							$output .= do_shortcode('[dtdr_sp_taxonomy listing_id="'.esc_attr($attrs['listing_id']).'" taxonomy="dtdr_listings_amenity" type="utils" /]');
						$output .= '</div>';

					}

					if($attrs['show_price'] == 'true' && shortcode_exists('dtdr_sp_price')) {

						$output .= '<div class="dtdr-listings-utils-item dtdr-listings-utils-price">';
							$output .= do_shortcode('[dtdr_sp_price listing_id="'.esc_attr($attrs['listing_id']).'" type="" /]');
						$output .= '</div>';

					}

				$output .= '</div>';

			} else {

				$listing_singular_label = apply_filters( 'listing_label', 'singular' );

				$output .= sprintf( esc_html__('Please provide %1$s id to display corresponding data!','dtdr-lite'), strtolower($listing_singular_label) );

			}

			return $output;

		}

		function dtdr_sp_taxonomy( $attrs, $content = null ) {

			$attrs = shortcode_atts ( array (
				'listing_id' => '',
				'taxonomy'   => 'dtdr_listings_category',
				'type'       => '',
				'splice'     => '',
				'class'      => '',
			), $attrs, 'dtdr_sp_taxonomy' );

			$output = '';

			if($attrs['listing_id'] == '' && is_singular('dtdr_listings')) {
				global $post;
				$attrs['listing_id'] = $post->ID;
			}

			if($attrs['listing_id'] != '') {

				$listing_singular_label = apply_filters( 'listing_label', 'singular' );

				$listing_taxonomies = wp_get_post_terms($attrs['listing_id'], $attrs['taxonomy'], array ('orderby' => 'parent'));
				if(isset($attrs['splice']) && $attrs['splice'] != '') {
					array_splice($listing_taxonomies, $attrs['splice']);
				}

				if(!empty($listing_taxonomies)) {

					$output .= '<div class="dtdr-listings-taxonomy-container '.$attrs['type'].' '.$attrs['class'].'">';

						$output .= '<ul class="dtdr-listings-taxonomy-list">';

							foreach($listing_taxonomies as $listing_taxonomy) {

								if(isset($listing_taxonomy->term_id)) {

									$icon_image_url   = get_term_meta($listing_taxonomy->term_id, 'dtdr-taxonomy-icon-image-url', true);
									$icon             = get_term_meta($listing_taxonomy->term_id, 'dtdr-taxonomy-icon', true);

									$icon_color       = get_term_meta($listing_taxonomy->term_id, 'dtdr-taxonomy-icon-color', true);
									$background_color = get_term_meta($listing_taxonomy->term_id, 'dtdr-taxonomy-background-color', true);
									$text_color       = get_term_meta($listing_taxonomy->term_id, 'dtdr-taxonomy-text-color', true);

									$tax_bg_color     = isset($background_color) ? 'style="background-color:'.$background_color.';"': '';
									$tax_text_color   = isset($text_color) ? 'style="color:'.$text_color.';"': '';
									$tax_icon_color   = isset($icon_color) ? 'style="color:'.$icon_color.';"': '';
									$tax_bg_text_color = '';
									if((isset($background_color) && !empty($background_color)) || (isset($text_color) && !empty($text_color))) {
										$tax_bg_text_color .= 'style="';
										if(isset($background_color) && !empty($background_color)) {
											$tax_bg_text_color .= 'background-color:'.$background_color.';';
										}
										if(isset($text_color) && !empty($text_color)) {
											$tax_bg_text_color .= 'color:'.$text_color.';';
										}
										$tax_bg_text_color .= '"';
									}

									if($attrs['type'] == 'type1') {

										$output .= '<li>';
											$output .= '<a href="'.get_term_link($listing_taxonomy->term_id).'" '.$tax_bg_color.'>';
												$output .= '<span>'.esc_html($listing_taxonomy->name).'</span>';
											$output .= '</a>';
										$output .= '</li>';

									} else if($attrs['type'] == 'type2') {

										$output .= '<li>';
											$output .= '<a href="'.get_term_link($listing_taxonomy->term_id).'" '.$tax_bg_color.'>';
												if($icon != '') {
													$output .= '<span class="'.esc_attr( $icon ).'"></span>';
												}
												$output .= '<span>'.esc_html($listing_taxonomy->name).'</span>';
											$output .= '</a>';
										$output .= '</li>';

									} else if($attrs['type'] == 'type3') {

										$output .= '<li>';
											$output .= '<a href="'.esc_url( get_term_link($listing_taxonomy->term_id) ).'">';
												if($icon_image_url != '') {
													$output .= '<span class="dtdr-listings-taxonomy-image" '.$tax_bg_color.'><img src="'.esc_url( $icon_image_url ).'" alt="'.sprintf( esc_html__('%1$s Taxonomy Image','dtdr-lite'), $listing_singular_label ).'" title="'.sprintf( esc_attr__('%1$s Taxonomy Image','dtdr-lite'), $listing_singular_label ).'" /></span>';
												}
												$output .= '<span>'.esc_html($listing_taxonomy->name).'</span>';
											$output .= '</a>';
										$output .= '</li>';

									} else if($attrs['type'] == 'type4') {

										$output .= '<li>';
											$output .= '<a href="'.esc_url( get_term_link($listing_taxonomy->term_id) ).'" '.$tax_bg_color.'>';
												if($icon != '') {
													$output .= '<span class="'.esc_attr( $icon ).'"></span>';
												}
												$output .= '<span>'.esc_html($listing_taxonomy->name).'</span>';
											$output .= '</a>';
										$output .= '</li>';

									} else if($attrs['type'] == 'type5') {

										$output .= '<li>';
											$output .= '<a href="'.esc_url( get_term_link($listing_taxonomy->term_id) ).'" '.$tax_bg_color.'>';
												if($icon_image_url != '') {
													$output .= '<span class="dtdr-listings-taxonomy-image"><img src="'.esc_url( $icon_image_url ).'" alt="'.sprintf( esc_html__('%1$s Taxonomy Image','dtdr-lite'), $listing_singular_label ).'" title="'.sprintf( esc_html__('%1$s Taxonomy Image','dtdr-lite'), $listing_singular_label ).'" /></span>';
												}
												$output .= '<span>'.esc_html($listing_taxonomy->name).'</span>';
											$output .= '</a>';
										$output .= '</li>';

									} else if($attrs['type'] == 'type6') {

										$output .= '<li>';
											$output .= '<a href="'.esc_url( get_term_link($listing_taxonomy->term_id) ).'">';
												$output .= '<span '.$tax_text_color.'>'.esc_html($listing_taxonomy->name).'</span>';
											$output .= '</a>';
										$output .= '</li>';

									} else if($attrs['type'] == 'type7') {

										$output .= '<li>';
											$output .= '<a href="'.esc_url( get_term_link($listing_taxonomy->term_id) ).'" '.$tax_bg_color.'>';
												$output .= '<span>'.esc_html($listing_taxonomy->name).'</span>';
											$output .= '</a>';
										$output .= '</li>';

									} else if($attrs['type'] == 'type8') {

										$output .= '<li>';
											$output .= '<a href="'.esc_url( get_term_link($listing_taxonomy->term_id) ).'" '.$tax_bg_color.'>';
												$output .= '<span>'.esc_html($listing_taxonomy->name).'</span>';
											$output .= '</a>';
										$output .= '</li>';

									} else if($attrs['type'] == 'utils') {

										$output .= '<li>';
											$output .= '<a href="'.esc_url( get_term_link($listing_taxonomy->term_id) ).'">';
												if($icon != '') {
													$output .= '<span class="'.esc_attr( $icon ).'"></span>';
												}
												$output .= '<span class="dtdr-listings-taxonomy-name">'.esc_html($listing_taxonomy->name).'</span>';
											$output .= '</a>';
										$output .= '</li>';

									}

								}

							}

						$output .= '</ul>';

					$output .= '</div>';

				}

			} else {

				$listing_singular_label = apply_filters( 'listing_label', 'singular' );

				$output .= sprintf( esc_html__('Please provide %1$s id to display corresponding data!','dtdr-lite'), strtolower($listing_singular_label) );

			}

			return $output;

		}

		function dtdr_sp_contact_form( $attrs, $content = null ) {

			$attrs = shortcode_atts ( array (
				'listing_id' => '',
				'textarea_placeholder' => '',
				'submit_label' => '',
				'contact_point' => '',
				'include_admin' => '',
				'class' => '',
			), $attrs, 'dtdr_sp_contact_form' );

			$output = '';

			if($attrs['listing_id'] == '' && is_singular('dtdr_listings')) {
				global $post;
				$attrs['listing_id'] = $post->ID;
			}

			if($attrs['listing_id'] != '') {

				$output .= '<div class="dtdr-listings-contactform-container '.$attrs['class'].'">';

					$output .= '<form method="post" class="dtdr-listings-contactform" name="dtdr-listings-contactform">';

						$current_user = wp_get_current_user();
						$user_id = $current_user->ID;

						if(!is_user_logged_in()) {

							$output .= '<div class="dtdr-column dtdr-one-column first">
											<input class="dtdr-contactform-name" name="dtdr_contactform_name" type="text" placeholder="'.esc_attr__('Name','dtdr-lite').'" required />
											<span></span>
										</div>';

							$output .= '<div class="dtdr-listings-contactform-item">';

								$output .= '<div class="dtdr-column dtdr-one-column first">
												<input class="dtdr-contactform-email" name="dtdr_contactform_email" type="text" placeholder="'.esc_attr__('Email','dtdr-lite').'" required />
												<span></span>
											</div>';

								$output .= '<div class="dtdr-column dtdr-one-column first">
												<input class="dtdr-contactform-phone" name="dtdr_contactform_phone" type="text" placeholder="'.esc_attr__('Phone','dtdr-lite').'" required />
												<span></span>
											</div>';

							$output .= '</div>';

						}

						if($attrs['textarea_placeholder'] != '') {
							$listing_title = get_the_title($attrs['listing_id']);
							$textarea_placeholder = str_replace('{{title}}', $listing_title, $attrs['textarea_placeholder']);
						} else {
							$textarea_placeholder = esc_html__('Message','dtdr-lite');
						}

						if($attrs['submit_label'] != '') {
							$submit_label = $attrs['submit_label'];
						} else {
							$submit_label = esc_html__('Submit','dtdr-lite');
						}

						$output .= '<div class="dtdr-column dtdr-one-column first">
										<textarea class="dtdr-contactform-message" name="dtdr_contactform_message" rows="5" placeholder="'.esc_attr($textarea_placeholder).'"></textarea>
										<span></span>
									</div>';

						$output .= '<input class="dtdr-contactform-listingid" name="dtdr_contactform_listingid" type="hidden" value="'.esc_attr($attrs['listing_id']).'" />';
						$output .= '<input class="dtdr-contactform-userid" name="dtdr_contactform_userid" type="hidden" value="'.esc_attr($user_id).'" />';
						$output .= '<input class="dtdr-contactform-contactpoint" name="dtdr_contactform_contactpoint" type="hidden" value="'.esc_attr($attrs['contact_point']).'" />';
						$output .= '<input class="dtdr-contactform-includeadmin" name="dtdr_contactform_includeadmin" type="hidden" value="'.esc_attr($attrs['include_admin']).'" />';
						$output .= '<input class="dtdr-contactform-nonce" name="dtdr_contactform_nonce" type="hidden" value="'.wp_create_nonce('contact_listing_'.$attrs['listing_id']).'" />';

						$output .= '<div class="dtdr-contactform-notification-box"></div>';

						$output .= '<a class="dtdr-contactform-submit-button">'.esc_html__($submit_label).'</a>';

					$output .= '</form>';

				$output .= '</div>';

			} else {

				$listing_singular_label = apply_filters( 'listing_label', 'singular' );

				$output .= sprintf( esc_html__('Please provide %1$s id to display corresponding data!','dtdr-lite'), strtolower($listing_singular_label) );

			}

			return $output;

		}

		function dtdr_sp_post_date( $attrs, $content = null ) {

			$attrs = shortcode_atts ( array (
				'listing_id'       => '',
				'type'             => 'type1',
				'include_posttime' => '',
				'with_label'       => '',
				'with_icon'        => '',
				'class'            => ''
			), $attrs, 'dtdr_sp_post_date' );

			$output = '';

			if($attrs['listing_id'] == '' && is_singular('dtdr_listings')) {
				global $post;
				$attrs['listing_id'] = $post->ID;
			}

			if($attrs['listing_id'] != '') {

				if($attrs['type'] == 'listing') {
					$attrs['type'] = '';
				}

				$output .= '<div class="dtdr-listings-post-dates-container '.esc_attr( $attrs['type'] ).' '.esc_attr( $attrs['class'] ).'">';

					$dtdr_post_date = get_the_date( get_option('date_format'), $attrs['listing_id'] );

					if($dtdr_post_date != '') {

						$output .= '<div class="dtdr-listings-post-date-container">';

							if($attrs['with_icon'] == 'true') {
								$output .= '<span class="dtdr-listings-post-date-icon"></span>';
							}

							if($attrs['with_label'] == 'true') {
								$output .= '<label class="dtdr-listings-post-date-label">'.esc_html__('Posted On: ','dtdr-lite').'</label>';
							}

							$output .= '<div class="dtdr-listings-post-datetime-holder">';

								$output .= '<div class="dtdr-listings-post-date-holder">';
									$output .= $dtdr_post_date;
								$output .= '</div>';

								if($attrs['include_posttime'] == 'true') {

									$output .= '<div class="dtdr-listings-post-time-holder">';

										$dtdr_24_hour_format = get_post_meta($attrs['listing_id'], 'dtdr_24_hour_format', true);

										if($dtdr_24_hour_format == 'true') {
											$output .= get_the_time( 'G:i', $attrs['listing_id'] );
										} else {
											$output .= get_the_time( 'g:i A', $attrs['listing_id'] );
										}

									$output .= '</div>';

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

		function dtdr_sp_mls_number( $attrs, $content = null ) {

			$attrs = shortcode_atts ( array (
				'listing_id' => '',
				'type'       => 'type1',
				'with_label' => '',
				'class'      => '',
			), $attrs, 'dtdr_sp_mls_number' );

			$output = '';

			if($attrs['listing_id'] == '' && is_singular('dtdr_listings')) {
				global $post;
				$attrs['listing_id'] = $post->ID;
			}

			if($attrs['listing_id'] != '') {

				$dtdr_mls_number = get_post_meta($attrs['listing_id'], 'dtdr_mls_number', true);
				if($dtdr_mls_number != '') {

					if($attrs['type'] == 'listing') {
						$attrs['type'] = '';
					}

					$output .= '<div class="dtdr-listings-mls-number-container '.esc_attr( $attrs['type'] ).' '.esc_attr( $attrs['class'] ).'">';
						if($attrs['with_label'] == 'true') {
							$output .= '<label class="dtdr-listings-mls-number-label">'.esc_html__('MLS Number: ','dtdr-lite').'</label>';
						}
						$output .= '<span>'.esc_html($dtdr_mls_number).'</span>';
					$output .= '</div>';

				}
			} else {

				$listing_singular_label = apply_filters( 'listing_label', 'singular' );
				$output .= sprintf( esc_html__('Please provide %1$s id to display corresponding data!','dtdr-lite'), strtolower($listing_singular_label) );
			}

			return $output;
		}
	}

	DTDirectoryLiteSinglePageShortcodes::instance();
}?>