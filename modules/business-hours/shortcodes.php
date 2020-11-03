<?php

// Single Page - Opening Hours
if(!function_exists('dtdr_sp_opening_hours')) {
	function dtdr_sp_opening_hours( $attrs, $content = null ) {

		$attrs = shortcode_atts ( array (

			'listing_id' => '',
			'show_current_time' => '',
			'class' => '',

		), $attrs, 'dtdr_sp_opening_hours' );


		$output = '';

		if($attrs['listing_id'] == '' && is_singular('dtdr_listings')) {
			global $post;
			$attrs['listing_id'] = $post->ID;
		}

		if($attrs['listing_id'] != '') {

			$dtdr_business_hours  = get_post_meta($attrs['listing_id'], 'dtdr_business_hours', true);
			$dtdr_business_hours_24hour_format  = get_post_meta($attrs['listing_id'], 'dtdr_business_hours_24hour_format', true);

			$weekdays = array (
						'sunday' => esc_html__('Sunday','dtdr-lite'),
						'monday' => esc_html__('Monday','dtdr-lite'),
						'tuesday' => esc_html__('Tuesday','dtdr-lite'),
						'wednesday' => esc_html__('Wednesday','dtdr-lite'),
						'thursday' => esc_html__('Thursday','dtdr-lite'),
						'friday' => esc_html__('Friday','dtdr-lite'),
						'saturday' => esc_html__('Saturday','dtdr-lite'),
					);

			$output .= '<div class="dtdr-listings-business-hours-container '.$attrs['class'].'">';

				$weekday_content = $open_hour_status = '';

				$weekday_content .= '<ul class="dtdr-listings-business-hours-list">';

					foreach($weekdays as $weekday_key => $weekday_value) {

						$time_label = '';
						if($dtdr_business_hours[$weekday_key]['start_time'][0] == '' || $dtdr_business_hours[$weekday_key]['end_time'][0] == '') {

							$time_label .= '<span class="dtdr-business-hours-off">'.esc_html__('OFF','dtdr-lite').'</span>';

						} else {

							if($dtdr_business_hours_24hour_format == 'true') {
								$time_label .= '<div class="dtdr-business-hours-time">';
									$time_label .= '<span class="dtdr-business-hours-starttime">'.esc_html( $dtdr_business_hours[$weekday_key]['start_time'][0] ).'</span>';
									$time_label .= '<span class="dtdr-business-hours-separator"> - </span>';
									$time_label .= '<span class="dtdr-business-hours-endtime">'.esc_html( $dtdr_business_hours[$weekday_key]['end_time'][0] ).'</span>';
								$time_label .= '</div>';
							} else {
								$time_label .= '<div class="dtdr-business-hours-time">';
									$time_label .= '<span class="dtdr-business-hours-starttime">'.esc_html( date('g:i A', strtotime($dtdr_business_hours[$weekday_key]['start_time'][0])) ).'</span>';
									$time_label .= '<span class="dtdr-business-hours-separator"> - </span>';
									$time_label .= '<span class="dtdr-business-hours-endtime">'.esc_html( date('g:i A', strtotime($dtdr_business_hours[$weekday_key]['end_time'][0])) ).'</span>';
								$time_label .= '</div>';
							}

							if ((date('l') == ucfirst($weekday_key))) {

								$start_time = strtotime($dtdr_business_hours[$weekday_key]['start_time'][0]);
								$end_time = strtotime($dtdr_business_hours[$weekday_key]['end_time'][0]);

								$current_timestamp = current_time( 'timestamp' );

								$open_hour_status .= '<div class="dtdr-listings-business-hours-status">';
									if (($current_timestamp > $start_time) && ($current_timestamp < $end_time)) {
										$open_hour_status .= '<span class="dtdr-open-hours-status dtdr-open">'.esc_html__('Open','dtdr-lite').'</span>';
									} else {
										$open_hour_status .= '<span class="dtdr-open-hours-status dtdr-closed">'.esc_html__('Closed','dtdr-lite').'</span>';
									}
									$open_hour_status .= $time_label;
								$open_hour_status .= '</div>';

							}

						}

						$weekday_content .= '<li>';
							$weekday_content .= '<span class="dtdr-business-hours-label">'.$weekday_value.'</span>';
							$weekday_content .= $time_label;
						$weekday_content .= '</li>';

					}

				$weekday_content .= '</ul>';

				$output .= $open_hour_status;
				$output .= $weekday_content;

				if($attrs['show_current_time'] == 'true') {
					$output .= '<div class="dtdr-listings-business-hours-currenttime">'.current_time( get_option('date_format').' '.get_option('time_format') ).' <span>'.esc_html__('local time','dtdr-lite').'</span></div>';
				}

			$output .= '</div>';

		} else {

			$listing_singular_label = apply_filters( 'listing_label', 'singular' );

			$output .= sprintf( esc_html__('Please provide %1$s id to display corresponding data!','dtdr-lite'), strtolower($listing_singular_label) );

		}

		return $output;

	}
	add_shortcode ( 'dtdr_sp_opening_hours', 'dtdr_sp_opening_hours' );
}

// Single Page - Opening Hours Status
if(!function_exists('dtdr_sp_opening_hours_status')) {
	function dtdr_sp_opening_hours_status( $attrs, $content = null ) {

		$attrs = shortcode_atts ( array (

					'listing_id' => '',
					'type'       => 'type1',
					'class'      => '',

				), $attrs, 'dtdr_sp_opening_hours_status' );


		$output = '';

		if($attrs['listing_id'] == '' && is_singular('dtdr_listings')) {
			global $post;
			$attrs['listing_id'] = $post->ID;
		}

		if($attrs['listing_id'] != '') {

			$dtdr_business_hours  = get_post_meta($attrs['listing_id'], 'dtdr_business_hours', true);

			if(isset($dtdr_business_hours[strtolower(date('l'))]['start_time'][0]) && isset($dtdr_business_hours[strtolower(date('l'))]['start_time'][0])) {

				$start_time = strtotime($dtdr_business_hours[strtolower(date('l'))]['start_time'][0]);
				$end_time = strtotime($dtdr_business_hours[strtolower(date('l'))]['end_time'][0]);

				$current_timestamp = current_time( 'timestamp' );

				$output .= '<div class="dtdr-listings-business-hours-status-container '.esc_attr( $attrs['type'] ).' '.esc_attr( $attrs['class'] ).'">';

				if($attrs['type'] == 'type5') {

					if (($current_timestamp > $start_time) && ($current_timestamp < $end_time)) {
						$output .= '<span class="dtdr-open-hours-status dtdr-open"></span>';
					} else {
						$output .= '<span class="dtdr-open-hours-status dtdr-closed"></span>';
					}

				} else {

					if (($current_timestamp > $start_time) && ($current_timestamp < $end_time)) {
						$output .= '<span class="dtdr-open-hours-status dtdr-open">'.esc_html__('Open','dtdr-lite').'</span>';
					} else {
						$output .= '<span class="dtdr-open-hours-status dtdr-closed">'.esc_html__('Closed','dtdr-lite').'</span>';
					}

				}

				$output .= '</div>';

			}

		} else {

			$listing_singular_label = apply_filters( 'listing_label', 'singular' );

			$output .= sprintf( esc_html__('Please provide %1$s id to display corresponding data!','dtdr-lite'), strtolower($listing_singular_label) );

		}

		return $output;

	}
	add_shortcode ( 'dtdr_sp_opening_hours_status', 'dtdr_sp_opening_hours_status' );
}

// Search - Open Now Field
if(!function_exists('dtdr_sf_open_now_field')) {
	function dtdr_sf_open_now_field( $attrs, $content = null ) {

		$attrs = shortcode_atts ( array (

					'ajax_load' => '',
					'class' => '',

				), $attrs, 'dtdr_sf_open_now_field' );


		$output = '';

		$output .= '<div class="dtdr-sf-fields-holder dtdr-sf-others-field-holder dtdr-sf-opennow-field-holder '.$attrs['class'].'">';

			$additional_class = '';
			if($attrs['ajax_load'] == 'true') {
				$additional_class = 'dtdr-with-ajax-load';
			}

			$output .= '<div class="dtdr-sf-others-list '.esc_attr($additional_class).'">';
				$output .= '<div class="dtdr-sf-others-list-item" data-itemvalue="opennow">'.esc_html__('Open Now','dtdr-lite').'</div>';
			$output .= '</div>';

		$output .= '</div>';

		return $output;

	}
	add_shortcode ( 'dtdr_sf_open_now_field', 'dtdr_sf_open_now_field' );
}

?>