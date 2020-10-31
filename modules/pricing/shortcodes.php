<?php

// Single Page - Price
if(!function_exists('dtdr_sp_price')) {
	function dtdr_sp_price( $attrs, $content = null ) {

		$attrs = shortcode_atts ( array (

					'listing_id' => '',
					'type'       => 'type1',
					'class'      => '',

				), $attrs, 'dtdr_sp_price' );

		$output = '';

		if($attrs['listing_id'] == '' && is_singular('dtdr_listings')) {
			global $post;
			$attrs['listing_id'] = $post->ID;
		}

		if($attrs['listing_id'] != '') {

			$dtdr_before_price_label = get_post_meta($attrs['listing_id'], 'dtdr_before_price_label', true);
			$dtdr_after_price_label = get_post_meta($attrs['listing_id'], 'dtdr_after_price_label', true);

			$price_label = dtdr_generate_price_html($attrs['listing_id']);

			if((isset($price_label['regular_price']) && !empty($price_label['regular_price'])) || (isset($price_label['sale_price']) && !empty($price_label['sale_price']))) {

				if($attrs['type'] == 'listing') {
					$attrs['type'] = '';
				}

				$output .= '<div class="dtdr-listings-price-container '.$attrs['type'].' '.$attrs['class'].'">';

					$output .= '<div class="dtdr-listings-price-label-holder">';
						if($dtdr_before_price_label != '') {
							$output .= '<span class="dtdr-price-before-label">'.$dtdr_before_price_label.'</span>';
						}
						$output .= '<div class="dtdr-listings-price-item">';
							$output .= $price_label['regular_price'];
							$output .= $price_label['sale_price'];
						$output .= '</div>';
						if($dtdr_after_price_label != '') {
							$output .= '<span class="dtdr-price-after-label">'.$dtdr_after_price_label.'</span>';
						}
					$output .= '</div>';

				$output .= '</div>';

			}

		} else {

			$listing_singular_label = apply_filters( 'listing_label', 'singular' );

			$output .= sprintf( esc_html__('Please provide %1$s id to display corresponding data!','dtdr-lite'), strtolower($listing_singular_label) );

		}

		return $output;

	}
	add_shortcode ( 'dtdr_sp_price', 'dtdr_sp_price' );
}

// Single Page - Add to Cart
if(!function_exists('dtdr_sp_add_to_cart')) {
	function dtdr_sp_add_to_cart( $attrs, $content = null ) {

		$attrs = shortcode_atts ( array (

					'listing_id' => '',
					'class'      => '',

				), $attrs, 'dtdr_sp_add_to_cart' );

		$output = '';

		if($attrs['listing_id'] == '' && is_singular('dtdr_listings')) {
			global $post;
			$attrs['listing_id'] = $post->ID;
		}

		if($attrs['listing_id'] != '') {

			if ( class_exists( 'WooCommerce' ) ) {

				$dtdr_before_price_label = get_post_meta($attrs['listing_id'], 'dtdr_before_price_label', true);
				$dtdr_after_price_label = get_post_meta($attrs['listing_id'], 'dtdr_after_price_label', true);

				$price_label = dtdr_generate_price_html($attrs['listing_id']);

				if((isset($price_label['regular_price']) && !empty($price_label['regular_price'])) || (isset($price_label['sale_price']) && !empty($price_label['sale_price']))) {

					$current_user = wp_get_current_user();
					$user_id = $current_user->ID;

					$purchased_listings = get_user_meta($user_id, 'purchased_listings', true);
					$purchased_listings = (is_array($purchased_listings) && !empty($purchased_listings)) ? $purchased_listings : array();

					$output .= '<div class="dtdr-listings-addtocart-container '.$attrs['class'].'">';

						$product = dtdr_get_product_object($attrs['listing_id']);

						if(array_key_exists($attrs['listing_id'], $purchased_listings)) {

							$output .= '<span class="dtdr-purchased">
											'.esc_html__('Purchased','dtdr-lite').
										'</span>';

						} else if(dtdr_check_item_is_in_cart($attrs['listing_id'])) {

							$output .= '<div class="dtdr-proceed-button">';
								$output .= '<a href="'.wc_get_cart_url().'" target="_self" class="custom-button-style dtdr-cart-link"><span class="fa fa-cart-plus"></span>'.esc_html__('View Cart','dtdr-lite').'</a>';
							$output .= '</div>';

						} else {

							$output .= '<div class="dtdr-proceed-button">';
								$output .= '<a href="'. apply_filters( 'add_to_cart_url', esc_url( $product->add_to_cart_url() ) ) .'" rel="nofollow" data-product_id="'.esc_attr($product->get_id()).'" class="custom-button-style add_to_cart_button ajax_add_to_cart product_type_'.esc_attr($product->get_type()).'"><span class="fa fa-shopping-cart"></span>'.esc_html__('Add to Cart','dtdr-lite').'</a>';
							$output .= '</div>';

						}

					$output .= '</div>';

				}

			} else {
				$output .= esc_html__('Please make sure "WooCommerce" plugin is installed and activated!','dtdr-lite');
			}

		} else {

			$listing_singular_label = apply_filters( 'listing_label', 'singular' );

			$output .= sprintf( esc_html__('Please provide %1$s id to display corresponding data!','dtdr-lite'), strtolower($listing_singular_label) );

		}

		return $output;

	}
	add_shortcode ( 'dtdr_sp_add_to_cart', 'dtdr_sp_add_to_cart' );
}

// Search - Price
if(!function_exists('dtdr_sf_price_range_field')) {
	function dtdr_sf_price_range_field( $attrs, $content = null ) {

		$attrs = shortcode_atts ( array (

					'min_price' => 1,
					'max_price' => 100,
					'ajax_load' => '',
					'class' => '',

				), $attrs, 'dtdr_sf_price_range_field' );


		$output = '';

		$output .= '<div class="dtdr-sf-fields-holder dtdr-sf-pricerange-field-holder '.$attrs['class'].'">';

			$additional_class = '';
			if($attrs['ajax_load'] == 'true') {
				$additional_class = 'dtdr-with-ajax-load';
			}

			$currency_symbol = dtdr_option('price','currency-symbol');
			$currency_symbol_position = dtdr_option('price','currency-symbol-position');

			$dtdr_sf_pricerange_start = $attrs['min_price'];
			if(isset($_REQUEST['dtdr_sf_pricerange_start']) && $_REQUEST['dtdr_sf_pricerange_start'] != '') {
				$dtdr_sf_pricerange_start = $_REQUEST['dtdr_sf_pricerange_start'];
			}

			$dtdr_sf_pricerange_end = $attrs['max_price'];
			if(isset($_REQUEST['dtdr_sf_pricerange_end']) && $_REQUEST['dtdr_sf_pricerange_end'] != '') {
				$dtdr_sf_pricerange_end = $_REQUEST['dtdr_sf_pricerange_end'];
			}

			if($currency_symbol_position == 'left') {

				$dtdr_sf_pricerange_start_value = $currency_symbol.$dtdr_sf_pricerange_start;
				$dtdr_sf_pricerange_end_value = $currency_symbol.$dtdr_sf_pricerange_end;

				$dtdr_sf_min_price = $currency_symbol.$attrs['min_price'];
				$dtdr_sf_max_price = $currency_symbol.$attrs['max_price'];

			} else if($currency_symbol_position == 'right') {

				$dtdr_sf_pricerange_start_value = $dtdr_sf_pricerange_start.$currency_symbol;
				$dtdr_sf_pricerange_end_value = $dtdr_sf_pricerange_end.$currency_symbol;

				$dtdr_sf_min_price = $attrs['min_price'].$currency_symbol;
				$dtdr_sf_max_price = $attrs['max_price'].$currency_symbol;

			} else if($currency_symbol_position == 'left_space') {

				$dtdr_sf_pricerange_start_value = $currency_symbol.' '.$dtdr_sf_pricerange_start;
				$dtdr_sf_pricerange_end_value = $currency_symbol.' '.$dtdr_sf_pricerange_end;

				$dtdr_sf_min_price = $currency_symbol.' '.$attrs['min_price'];
				$dtdr_sf_max_price = $currency_symbol.' '.$attrs['max_price'];

			} else if($currency_symbol_position == 'right_space') {

				$dtdr_sf_pricerange_start_value = $dtdr_sf_pricerange_start.' '.$currency_symbol;
				$dtdr_sf_pricerange_end_value = $dtdr_sf_pricerange_end.' '.$currency_symbol;

				$dtdr_sf_min_price = $attrs['min_price'].' '.$currency_symbol;
				$dtdr_sf_max_price = $attrs['max_price'].' '.$currency_symbol;

			}

			$output .= '<div class="dtdr-sf-pricerange-slider '.esc_attr($additional_class).'" data-min="'.esc_attr($attrs['min_price']).'" data-max="'.esc_attr($attrs['max_price']).'" data-updated-min="'.esc_attr($dtdr_sf_pricerange_start).'" data-updated-max="'.esc_attr($dtdr_sf_pricerange_end).'" data-currencysymbol="'.esc_attr($currency_symbol).'" data-currencysymbolposition="'.esc_attr($currency_symbol_position).'">';
				$output .= '<div class="dtdr-sf-pricerange-slider-start-handle">'.$dtdr_sf_pricerange_start_value.'</div>';
				$output .= '<div class="dtdr-sf-pricerange-slider-end-handle">'.$dtdr_sf_pricerange_end_value.'</div>';
				$output .= '<div class="dtdr-sf-pricerange-slider-ranges">';
					$output .= '<div class="dtdr-sf-pricerange-slider-range-min-holder">';
						$output .= '<label>'.esc_html__('Min','dtdr-lite').'</label>';
						$output .= '<div class="dtdr-sf-pricerange-slider-range-min">'.$dtdr_sf_min_price.'</div>';
					$output .= '</div>';
					$output .= '<div class="dtdr-sf-pricerange-slider-range-max-holder">';
						$output .= '<label>'.esc_html__('Max','dtdr-lite').'</label>';
						$output .= '<div class="dtdr-sf-pricerange-slider-range-max">'.$dtdr_sf_max_price.'</div>';
					$output .= '</div>';
				$output .= '</div>';
			$output .= '</div>';

			$output .= '<input name="dtdr_sf_pricerange_start" class="dtdr-sf-field dtdr-sf-pricerange-start" type="hidden" value="'.esc_attr($dtdr_sf_pricerange_start).'" />';
			$output .= '<input name="dtdr_sf_pricerange_end" class="dtdr-sf-field dtdr-sf-pricerange-end" type="hidden" value="'.esc_attr($dtdr_sf_pricerange_end).'" />';

		$output .= '</div>';

		return $output;

	}
	add_shortcode ( 'dtdr_sf_price_range_field', 'dtdr_sf_price_range_field' );
}

// Modifying Listing Query Arguments - For Search Price
if(!function_exists('dtdr_modify_listings_args_from_pricing_module')) {
	function dtdr_modify_listings_args_from_pricing_module($args, $custom_options) {

		$pricerange_start = $custom_options['pricerange_start'];
		$pricerange_end   = $custom_options['pricerange_end'];

		if($pricerange_start != '' && $pricerange_end != '') {
			$args['meta_query'][] = array (
										'key'     => '_sale_price',
										'value'   => array( $pricerange_start, $pricerange_end ),
										'type'    => 'numeric',
										'compare' => 'BETWEEN',
									);
		}

		return $args;

	}
	add_filter( 'dtdr_modify_listings_args_from_modules', 'dtdr_modify_listings_args_from_pricing_module', 10, 2 );
}

?>