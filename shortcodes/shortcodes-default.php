<?php
if( !class_exists('DTDirectoryLiteShortcodes') ) {

	class DTDirectoryLiteShortcodes {

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

			add_shortcode ( 'dtdr_login_logout_links', array ( $this, 'dtdr_login_logout_links' ) );
			add_shortcode ( 'dtdr_listings_listing', array ( $this, 'dtdr_listings_listing' ) );
			add_shortcode ( 'dtdr_listings_taxonomy', array ( $this, 'dtdr_listings_taxonomy' ) );

		}

		function dtdr_shortcodeHelper($content = null) {
			$content = do_shortcode ( shortcode_unautop ( $content ) );
			$content = preg_replace ( '#^<\/p>|^<br \/>|<p>$#', '', $content );
			$content = preg_replace ( '#<br \/>#', '', $content );
			return trim ( $content );
		}

		function dtdr_login_logout_links( $attrs, $content = null ) {

			$attrs = shortcode_atts ( array (
					'class' => '',
				), $attrs, 'dtdr_login_logout_links' );

			$output = '';

			if(is_user_logged_in()) {

				$current_user = wp_get_current_user();
				$user_info = get_userdata($current_user->ID);

				if(function_exists('dtdr_get_login_redirect_url')) {
					$redirect_link = dtdr_get_login_redirect_url($user_info);
				} else {
					$redirect_link = home_url();
				}

				$output .= '<ul class="dtdr-custom-login '.esc_attr($attrs['class']).'">';
					$output .= '<li><a href="'.esc_url( $redirect_link ).'">'.get_avatar( $current_user->ID, 150).'<span>'.'&nbsp;'.esc_html( $current_user->display_name ).' </span></a></li>';
					$output .= '<li><a href="'.wp_logout_url(home_url('/')).'" title="'.esc_html__('Logout','dtdr-lite').'">'.esc_html__('Logout','dtdr-lite').'</a></li>';
				$output .= '</ul>';

			} else {

				$output .= '<ul class="dtdr-custom-login '.esc_attr($attrs['class']).'">';
					$output .= '<li><a href="#" title="'.esc_html__('Login','dtdr-lite').'" class="dtdr-login-link" onclick="return false">'.esc_html__('Login','dtdr-lite').'</a></li>';
					$output .= '<li><a href="'.esc_url( wp_registration_url() ).'" title="'.esc_attr__('Register','dtdr-lite').'">'.esc_html__('Register','dtdr-lite').'</a></li>';

				$output .= '</ul>';

				$output .= dtdr_generate_loader_html(false);

			}

			return $output;

		}

		function dtdr_listings_listing($attrs, $content = null) {

			$attrs = shortcode_atts ( array (
				'type'                       => 'type1',
				'gallery'                    => 'featured_image',
				'post_per_page'              => -1,
				'columns'                    => 1,
				'apply_isotope'              => 'true',
				'isotope_filter'             => '',
				'apply_child_of'             => 'false',
				'featured_items'             => '',
				'features_image_or_icon'     => '',
				'features_include'           => '',
				'no_of_cat_to_display'       => 2,
				'excerpt_length'             => 20,
				'apply_equal_height'         => 'false',
				'apply_custom_height'        => 'false',
				'height'                     => '',
				'vc_height'                  => '',
				'sidebar_widget'             => 'false',

				'list_item_ids'              => '',
				'category_ids'               => '',
				'cities_ids'                 => '',
				'neighborhoods_ids'          => '',
				'countiesstates_ids'         => '',
				'contracttypes_ids'          => '',
				'tag_ids'                    => '',
				'country_id'                 => '',
				'seller_ids'                 => '',
				'incharge_ids'               => '',

				'enable_carousel'            => '',
				'carousel_effect'            => '',
				'carousel_autoplay'          => 0,
				'carousel_slidesperview'     => 2,
				'carousel_loopmode'          => '',
				'carousel_mousewheelcontrol' => '',
				'carousel_bulletpagination'  => 'true',
				'carousel_arrowpagination'   => '',
				'carousel_spacebetween'      => 30,

				'class'                      => '',

			), $attrs, 'dtdr_listings_listing' );


			if($attrs['enable_carousel'] == 'true') {
				$attrs['columns'] = $attrs['carousel_slidesperview'];
			}

			$data_attributes = array ();
			array_push($data_attributes, 'data-type="'.esc_attr($attrs['type']).'"');
			array_push($data_attributes, 'data-gallery="'.esc_attr($attrs['gallery']).'"');
			array_push($data_attributes, 'data-postperpage="'.esc_attr($attrs['post_per_page']).'"');
			array_push($data_attributes, 'data-columns="'.esc_attr($attrs['columns']).'"');
			array_push($data_attributes, 'data-applyisotope="'.esc_attr($attrs['apply_isotope']).'"');
			array_push($data_attributes, 'data-isotopefilter="'.esc_attr($attrs['isotope_filter']).'"');
			array_push($data_attributes, 'data-applychildof="'.esc_attr($attrs['apply_child_of']).'"');
			array_push($data_attributes, 'data-featureditems="'.esc_attr($attrs['featured_items']).'"');
			array_push($data_attributes, 'data-featuresimageoricon="'.esc_attr($attrs['features_image_or_icon']).'"');
			array_push($data_attributes, 'data-featuresinclude="'.esc_attr($attrs['features_include']).'"');
			array_push($data_attributes, 'data-noofcattodisplay="'.esc_attr($attrs['no_of_cat_to_display']).'"');
			array_push($data_attributes, 'data-excerptlength="'.esc_attr($attrs['excerpt_length']).'"');
			array_push($data_attributes, 'data-applyequalheight="'.esc_attr($attrs['apply_equal_height']).'"');

			// Custom attributes update from modules
			$dtdr_listing_custom_options = apply_filters('dtdr_listings_listing_data_attrs_from_modules', '', $attrs);
			array_push($data_attributes, 'data-customoptions="'.esc_attr($dtdr_listing_custom_options).'"');


			// Script to run for author single pages
			$dtdr_asp_user_id = get_query_var('dtdr_asp_user_id');
			if(isset($dtdr_asp_user_id) && !empty($dtdr_asp_user_id)) {

				$dtdr_asp_user_roles = get_query_var('dtdr_asp_user_roles');
				if(in_array('seller', $dtdr_asp_user_roles)) {
					$attrs['seller_ids'] = $dtdr_asp_user_id;
				}
				if(in_array('incharge', $dtdr_asp_user_roles)) {
					$attrs['incharge_ids'] = $dtdr_asp_user_id;
				}

			}

			array_push($data_attributes, 'data-listitemids="'.esc_attr($attrs['list_item_ids']).'"');
			array_push($data_attributes, 'data-categoryids="'.esc_attr($attrs['category_ids']).'"');
			array_push($data_attributes, 'data-citiesids="'.esc_attr($attrs['cities_ids']).'"');
			array_push($data_attributes, 'data-neighborhoodsids="'.esc_attr($attrs['neighborhoods_ids']).'"');
			array_push($data_attributes, 'data-countiesstatesids="'.esc_attr($attrs['countiesstates_ids']).'"');
			array_push($data_attributes, 'data-contracttypesids="'.esc_attr($attrs['contracttypes_ids']).'"');
			array_push($data_attributes, 'data-tagids="'.esc_attr($attrs['tag_ids']).'"');
			array_push($data_attributes, 'data-countryid="'.esc_attr($attrs['country_id']).'"');
			array_push($data_attributes, 'data-sellerids="'.esc_attr($attrs['seller_ids']).'"');
			array_push($data_attributes, 'data-inchargeids="'.esc_attr($attrs['incharge_ids']).'"');

			if(!empty($data_attributes)) {
				$data_attributes_string = implode(' ', $data_attributes);
			}

			$listing_carousel_attributes = array ();
			$listing_carousel_attributes_string = '';
			$swipper_container_class = '';

			if($attrs['enable_carousel'] == 'true') {

				if(($attrs['type'] == 'type3' || $attrs['type'] == 'type5' || $attrs['type'] == 'type7' || $attrs['type'] == 'type9' || $attrs['sidebar_widget'] == 'true') && $attrs['carousel_slidesperview'] > 1) {
					$attrs['carousel_slidesperview'] = 1;
				}

				array_push($listing_carousel_attributes, 'data-enablecarousel="true"');
				array_push($listing_carousel_attributes, 'data-carouseleffect="'.esc_attr($attrs['carousel_effect']).'"');
				array_push($listing_carousel_attributes, 'data-carouselautoplay="'.esc_attr($attrs['carousel_autoplay']).'"');
				array_push($listing_carousel_attributes, 'data-carouselslidesperview="'.esc_attr($attrs['carousel_slidesperview']).'"');
				array_push($listing_carousel_attributes, 'data-carouselloopmode="'.esc_attr($attrs['carousel_loopmode']).'"');
				array_push($listing_carousel_attributes, 'data-carouselmousewheelcontrol="'.esc_attr($attrs['carousel_mousewheelcontrol']).'"');
				array_push($listing_carousel_attributes, 'data-carouselbulletpagination="'.esc_attr($attrs['carousel_bulletpagination']).'"');
				array_push($listing_carousel_attributes, 'data-carouselarrowpagination="'.esc_attr($attrs['carousel_arrowpagination']).'"');
				array_push($listing_carousel_attributes, 'data-carouselspacebetween="'.esc_attr($attrs['carousel_spacebetween']).'"');

				if(!empty($listing_carousel_attributes)) {
					$listing_carousel_attributes_string = implode(' ', $listing_carousel_attributes);
				}

			}

			if($attrs['sidebar_widget'] == 'true') {
				$attrs['class'] .= " dtdr-listings-sidebar-widget";
			}

			if($attrs['apply_custom_height'] == 'true') {
				$attrs['class'] .= " dtdr-content-scroll";
			}

			$height_attr = '';
			if($attrs['vc_height'] != '') {
				$height_attr = 'style="height:'.esc_attr( $attrs['vc_height'] ).'px;"';
			}

			$output = '';
			$output .= '<div class="dtdr-listing-output-data-container dtdr-direct-list-items dtdr-listing-no-map '.esc_attr( $attrs['class'] ).'" '.$listing_carousel_attributes_string.' '.$height_attr.'>';

				$output .= '<div class="dtdr-listing-output-data-holder" '.$data_attributes_string.'></div>';

				if($attrs['enable_carousel'] == 'true') {

					if($attrs['carousel_bulletpagination'] == 'true' || $attrs['carousel_arrowpagination'] == 'true') {
						$output .= '<div class="dtdr-swiper-pagination-holder">';

							if($attrs['carousel_bulletpagination'] == 'true') {
								$output .= '<div class="dtdr-swiper-bullet-pagination"></div>';
							}

							if($attrs['carousel_arrowpagination'] == 'true') {
								$output .= '<div class="dtdr-swiper-arrow-pagination">';
									$output .= '<a href="#" class="dtdr-swiper-arrow-prev">'.esc_html__('Prev','dtdr-lite').'</a>';
									$output .= '<a href="#" class="dtdr-swiper-arrow-next">'.esc_html__('Next','dtdr-lite').'</a>';
								$output .= '</div>';
							}

						$output .= '</div>';
					}

				}

				$output .= dtdr_generate_loader_html(false);

			$output .= '</div>';

			return $output;

		}

		function dtdr_listings_taxonomy($attrs, $content = null) {

			$attrs = shortcode_atts ( array (
				'taxonomy'                => 'dtdr_listings_category',
				'type'                    => 'type1',
				'media_type'              => 'image',
				'columns'                 => '',
				'include'                 => '',
				'show_parent_items_alone' => 'false',
				'child_of'                => '',
				'class'                   => '',
			), $attrs, 'dtdr_listings_taxonomy' );

			$output = '';

			$listing_singular_label = apply_filters( 'listing_label', 'singular' );
			$listing_plural_label   = apply_filters( 'listing_label', 'plural' );

			$column_class = '';
			if($attrs['columns'] == 1) {
				$column_class = 'dtdr-column dtdr-one-column';
			} else if($attrs['columns'] == 2) {
				$column_class = 'dtdr-column dtdr-one-half';
			} else if($attrs['columns'] == 3) {
				$column_class = 'dtdr-column dtdr-one-third';
			}

			$cat_args = array (
				'taxonomy'   => $attrs['taxonomy'],
				'hide_empty' => 1
			);

			if($attrs['include'] != '') {
				$cat_args['include'] = $attrs['include'];
			}
			if($attrs['show_parent_items_alone'] == 'true') {
				$cat_args['parent'] = 0;
			} else if($attrs['child_of'] != '') {
				$cat_args['child_of'] = $attrs['child_of'];
			}

			$categories = get_categories($cat_args);

			if( is_array($categories) && !empty($categories) ) {

				$i = 1;
				foreach( $categories as $category ) {

					if($i == 1) { $first_class = 'first';  } else { $first_class = ''; }
					if($i == $attrs['columns']) { $i = 1; } else { $i = $i + 1; }

					$image_url        = get_term_meta($category->term_id, 'dtdr-taxonomy-image-url', true);
					$icon_image_url   = get_term_meta($category->term_id, 'dtdr-taxonomy-icon-image-url', true);
					$icon             = get_term_meta($category->term_id, 'dtdr-taxonomy-icon', true);
					$icon_color       = get_term_meta($category->term_id, 'dtdr-taxonomy-icon-color', true);
					$background_color = get_term_meta($category->term_id, 'dtdr-taxonomy-background-color', true);

					$icon_style = 'style="';
						if($icon_color != '') {
							$icon_style .= 'color:'.$icon_color.'; ';
						}
					$icon_style .= '"';

					$background_style = 'style="';
						if($background_color != '') {
							$background_style .= 'background-color:'.$background_color.'; ';
						}
					$background_style .= '"';

					$background_icon_style = 'style="';
						if($background_color != '') {
							$background_icon_style .= 'background-color:'.$background_color.'; ';
						}
						if($icon_color != '') {
							$background_icon_style .= 'color:'.$icon_color.'; ';
						}
					$background_icon_style .= '"';

					// Category Starting Price
					$starting_price_html = '';
					if(function_exists('dtdr_generate_price_html') && ($attrs['type'] == 'type4' || $attrs['type'] == 'type7')) {

						$listing_args = array (
							'posts_per_page' => -1,
							'post_type'      => 'dtdr_listings',
							'meta_query'     => array (),
							'tax_query'      => array (),
							'post_status'    => 'publish'
						);

						$listing_args['tax_query'][] = array (
							'taxonomy' => 'dtdr_listings_category',
							'field'    => 'id',
							'terms'    => $category,
							'operator' => 'IN'
						);

						$listing_args['orderby']  = 'meta_value_num';
						$listing_args['order']    = 'ASC';
						$listing_args['meta_key'] = '_sale_price';
						$listing_args['fields']   = 'ids';

						$listings_ids = get_posts($listing_args);
						$cat_listings_id = isset($listings_ids[0]) ? $listings_ids[0] : -1;

						if($cat_listings_id > 0) {

							$price_label = dtdr_generate_price_html($cat_listings_id);

							if(isset($price_label['sale_price']) && !empty($price_label['sale_price'])) {
								$_sale_price_label_html = '<div class="dtdr-listing-taxonomy-starting-price-html">'.esc_html( $price_label['sale_price'] ).'</div>';
								$starting_price_html .= '<div class="dtdr-listing-taxonomy-starting-price">';
									$starting_price_html .= sprintf(esc_html__('Starts from %1$s','dtdr-lite'), $_sale_price_label_html);
								$starting_price_html .= '</div>';
							}

						}

					}

					if($attrs['type'] == 'type1') {

						$output .= '<div class="dtdr-listing-taxonomy-item type1 '.esc_attr( $column_class ).' '.esc_attr( $first_class ).' '.esc_attr( $attrs['class'] ).'">';
							$output .= '<div class="dtdr-listing-taxonomy-icon-image">';
								if($attrs['media_type'] == 'icon') {
									$output .= '<span class="'.esc_attr( $icon ).'" '.$icon_style.'></span>';
								} else if($attrs['media_type'] == 'icon_image') {
									$output .= '<img src="'.esc_url( $icon_image_url ).'" alt="'.sprintf( esc_html__('%1$s Taxonomy Icon Image','dtdr-lite'), $listing_singular_label ).'" title="'.sprintf( esc_html__('%1$s Taxonomy Icon Image','dtdr-lite'), $listing_singular_label ).'" />';
								} else {
									$output .= '<img src="'.esc_url( $image_url ).'" alt="'.sprintf( esc_html__('%1$s Taxonomy Image','dtdr-lite'), $listing_singular_label ).'" title="'.sprintf( esc_html__('%1$s Taxonomy Image','dtdr-lite'), $listing_singular_label ).'" />';
								}
							$output .= '</div>';
							$output .= '<div class="dtdr-listing-taxonomy-meta-data">';
								$output .= '<h3><a href="'.esc_url( get_term_link($category->term_id) ).'">'.esc_html($category->cat_name).'</a></h3>';
								$output .= '<div class="dtdr-category-total-items"><span>'.esc_html( $category->count ).'</span> '.sprintf( esc_html__('%1$s','dtdr-lite'), $listing_plural_label ).'</div>';
							$output .= '</div>';
						$output .= '</div>';

					}

					if($attrs['type'] == 'type2') {

						$output .= '<div class="dtdr-listing-taxonomy-item type2 '.esc_attr( $column_class ).' '.esc_attr( $first_class ).' '.esc_attr( $attrs['class'] ).'" >';
							$output .= '<div class="dtdr-listing-taxonomy-icon-image">';
								if($attrs['media_type'] == 'icon') {
									$output .= '<span class="'.esc_attr( $icon ).'"></span>';
								} else if($attrs['media_type'] == 'icon_image') {
									$output .= '<img src="'.esc_url( $icon_image_url ).'" alt="'.sprintf( esc_attr__('%1$s Taxonomy Icon Image','dtdr-lite'), $listing_singular_label ).'" title="'.sprintf( esc_attr__('%1$s Taxonomy Icon Image','dtdr-lite'), $listing_singular_label ).'" />';
								} else {
									$output .= '<img src="'.esc_url( $image_url ).'" alt="'.sprintf( esc_attr__('%1$s Taxonomy Image','dtdr-lite'), $listing_singular_label ).'" title="'.sprintf( esc_attr__('%1$s Taxonomy Image','dtdr-lite'), $listing_singular_label ).'" />';
								}
							$output .= '</div>';
							$output .= '<div class="dtdr-listing-taxonomy-meta-data">';
								$output .= '<h3><a href="'.esc_url( get_term_link($category->term_id) ).'">'.esc_html($category->cat_name).'</a></h3>';
								$output .= '<div class="dtdr-category-total-items"><span>'.esc_attr( $category->count ).'</span> '.sprintf( esc_html__('%1$s','dtdr-lite'), $listing_plural_label ).'</div>';
							$output .= '</div>';
						$output .= '</div>';

					}

					if($attrs['type'] == 'type3') {

						$output .= '<div class="dtdr-listing-taxonomy-item type3 '.esc_attr( $column_class ).' '.esc_attr( $first_class ).' '.esc_attr( $attrs['class'] ).'">';
							$output .= '<div class="dtdr-listing-taxonomy-icon-image">';
								if($attrs['media_type'] == 'icon') {
									$output .= '<span class="'.esc_attr( $icon ).'" '.$icon_style.'></span>';
								} else if($attrs['media_type'] == 'icon_image') {
									$output .= '<img src="'.esc_url( $icon_image_url ).'" alt="'.sprintf( esc_attr__('%1$s Taxonomy Icon Image','dtdr-lite'), $listing_singular_label ).'" title="'.sprintf( esc_attr__('%1$s Taxonomy Icon Image','dtdr-lite'), $listing_singular_label ).'" />';
								} else {
									$output .= '<img src="'.esc_url( $image_url ).'" alt="'.sprintf( esc_attr__('%1$s Taxonomy Image','dtdr-lite'), $listing_singular_label ).'" title="'.sprintf( esc_attr__('%1$s Taxonomy Image','dtdr-lite'), $listing_singular_label ).'" />';
								}
							$output .= '</div>';
							$output .= '<div class="dtdr-listing-taxonomy-meta-data">';
								$output .= '<h3><a href="'.esc_url( get_term_link($category->term_id) ).'">'.esc_html($category->cat_name).'</a></h3>';
								$output .= '<div class="dtdr-category-total-items"><span>'.esc_html( $category->count ).'</span> '.sprintf( esc_html__('%1$s','dtdr-lite'), $listing_plural_label ).'</div>';
							$output .= '</div>';
						$output .= '</div>';

					}

					if($attrs['type'] == 'type4') {

						$output .= '<div class="dtdr-listing-taxonomy-item type4 '.esc_attr( $column_class ).' '.esc_attr( $first_class ).' '.esc_attr( $attrs['class'] ).'">';
							$output .= '<div class="dtdr-listing-taxonomy-icon-image">';
								if($attrs['media_type'] == 'icon') {
									$output .= '<span class="'.esc_attr( $icon ).'" '.$icon_style.'></span>';
								} else if($attrs['media_type'] == 'icon_image') {
									$output .= '<img src="'.esc_url( $icon_image_url ).'" alt="'.sprintf( esc_attr__('%1$s Taxonomy Icon Image','dtdr-lite'), $listing_singular_label ).'" title="'.sprintf( esc_attr__('%1$s Taxonomy Icon Image','dtdr-lite'), $listing_singular_label ).'" />';
								} else {
									$output .= '<img src="'.esc_url( $image_url ).'" alt="'.sprintf( esc_attr__('%1$s Taxonomy Image','dtdr-lite'), $listing_singular_label ).'" title="'.sprintf( esc_attr__('%1$s Taxonomy Image','dtdr-lite'), $listing_singular_label ).'" />';
								}
							$output .= '</div>';
							$output .= '<div class="dtdr-listing-taxonomy-meta-data">';
								$output .= '<h3><a href="'.esc_url( get_term_link($category->term_id) ).'">'.esc_html($category->cat_name).'</a></h3>';
								$output .= '<div class="dtdr-category-total-items"><span>'.esc_html( $category->count ).'</span> '.sprintf( esc_html__('%1$s','dtdr-lite'), $listing_plural_label ).'</div>';
							$output .= '</div>';
							$output .= $starting_price_html;
						$output .= '</div>';

					}

					if($attrs['type'] == 'type5') {

						$output .= '<div class="dtdr-listing-taxonomy-item type5 '.esc_attr( $column_class ).' '.esc_attr( $first_class ).' '.esc_attr( $attrs['class'] ).'">';
							$output .= '<div class="dtdr-listing-taxonomy-icon-image">';
								$output .= '<img src="'.esc_url( $image_url ).'" alt="'.sprintf( esc_attr__('%1$s Taxonomy Image','dtdr-lite'), $listing_singular_label ).'" title="'.sprintf( esc_attr__('%1$s Taxonomy Image','dtdr-lite'), $listing_singular_label ).'" />';
							$output .= '</div>';
							$output .= '<div class="dtdr-listing-taxonomy-meta-data">';
								$output .= '<h3><a href="'.esc_url( get_term_link($category->term_id) ).'">'.esc_html($category->cat_name).'</a></h3>';
								$output .= '<div class="dtdr-category-total-items" '.$background_style.'><a href="'.esc_url( get_term_link($category->term_id) ).'"><span>'.$category->count.'</span> '.sprintf( esc_html__('%1$s','dtdr-lite'), $listing_plural_label ).'</a></div>';
							$output .= '</div>';
						$output .= '</div>';

					}

					if($attrs['type'] == 'type6') {

						$output .= '<div class="dtdr-listing-taxonomy-item type6 '.esc_attr( $column_class ).' '.esc_attr( $first_class ).' '.esc_attr( $attrs['class'] ).'">';
							$output .= '<div class="dtdr-listing-taxonomy-icon-image">';
								$output .= '<img src="'.esc_url( $image_url ).'" alt="'.sprintf( esc_html__('%1$s Taxonomy Image','dtdr-lite'), $listing_singular_label ).'" title="'.sprintf( esc_html__('%1$s Taxonomy Image','dtdr-lite'), $listing_singular_label ).'" />';
							$output .= '</div>';
							$output .= '<div class="dtdr-listing-taxonomy-meta-data">';
								$output .= '<span class="'.esc_attr( $icon ).'" '.$background_style.'></span>';
								$output .= '<h3><a href="'.esc_url( get_term_link($category->term_id) ).'">'.esc_html($category->cat_name).'</a></h3>';
								$output .= '<div class="dtdr-category-total-items"><a href="'.esc_url( get_term_link($category->term_id) ).'"><span>'.esc_html( $category->count ).'</span> '.sprintf( esc_html__('%1$s','dtdr-lite'), $listing_plural_label ).'</a></div>';
							$output .= '</div>';
						$output .= '</div>';

					}

					if($attrs['type'] == 'type7') {

						$output .= '<div class="dtdr-listing-taxonomy-item type7 '.esc_attr( $column_class ).' '.esc_attr( $first_class ).' '.esc_attr( $attrs['class'] ).'">';
							$output .= '<div class="dtdr-listing-taxonomy-icon-image">';
								$output .= '<img src="'.esc_url( $image_url ).'" alt="'.sprintf( esc_html__('%1$s Taxonomy Image','dtdr-lite'), $listing_singular_label ).'" title="'.sprintf( esc_html__('%1$s Taxonomy Image','dtdr-lite'), $listing_singular_label ).'" />';
								$output .= '<span class="'.esc_attr( $icon ).'" '.$background_style.'></span>';
							$output .= '</div>';
							$output .= '<div class="dtdr-listing-taxonomy-meta-data">';
								$output .= '<h3><a href="'.esc_url( get_term_link($category->term_id) ).'">'.esc_html($category->cat_name).'</a></h3>';
								$output .= '<div class="dtdr-category-total-items" '.$background_style.'><a href="'.esc_url( get_term_link($category->term_id) ).'"><span>'.$category->count.'</span> '.sprintf( esc_html__('%1$s','dtdr-lite'), $listing_plural_label ).'</a></div>';
							$output .= '</div>';
							$output .= $starting_price_html;
						$output .= '</div>';

					}

				}

			}

			return $output;

		}

	}

	DTDirectoryLiteShortcodes::instance();

}

?>