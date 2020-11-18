<?php

// Single Page - Media Attachments
if(!function_exists('dtdr_sp_media_attachments')) {
	function dtdr_sp_media_attachments( $attrs, $content = null ) {

		$attrs = shortcode_atts ( array (
			'listing_id' => '',
			'type'       => '',
			'class'      => '',
		), $attrs, 'dtdr_sp_media_attachments' );

		$output = '';

		if($attrs['listing_id'] == '' && is_singular('dtdr_listings')) {
			global $post;
			$attrs['listing_id'] = $post->ID;
		}

		if($attrs['listing_id'] != '') {

			$output .= '<div class="dtdr-listings-attachment-holder '.esc_attr( $attrs['type'] ).' '.esc_attr( $attrs['class'] ).'">';

				$dtdr_media_attachments_titles = $dtdr_media_attachments_items = '';
				if($attrs['listing_id'] > 0) {

					$dtdr_media_attachments_titles = get_post_meta($attrs['listing_id'], 'dtdr_media_attachments_titles', true);
					$dtdr_media_attachments_items  = get_post_meta($attrs['listing_id'], 'dtdr_media_attachments_items', true);
				}

				$j = 0;
				if(is_array($dtdr_media_attachments_titles) && !empty($dtdr_media_attachments_titles)) {
					foreach($dtdr_media_attachments_titles as $dtdr_attachment_title) {

						$attachment_url = wp_get_attachment_url($dtdr_media_attachments_items[$j]);
						$attachment_ext = wp_check_filetype(wp_basename($attachment_url));

						$ext_class = 'fas fa-file-alt';

						if( $attachment_ext['ext'] == 'pdf' ) {
							$ext_class = 'fal fa-file-pdf';
						} else if( $attachment_ext['ext'] == 'doc' ||$attachment_ext['ext'] == 'docx') {
							$ext_class = 'fal fa-file-word';
						} else if( $attachment_ext['ext'] == 'xls' || $attachment_ext['ext'] == 'xlsx' ) {
							$ext_class = 'fal fa-file-spreadsheet';
						} else if( $attachment_ext['ext'] == 'csv' ) {
							$ext_class = 'fal fa-file-csv';
						} else if( $attachment_ext['ext'] == 'txt' || $attachment_ext['ext'] == 'rtf' ) {
							$ext_class = 'fal fa-file-alt';
						} else if( $attachment_ext['ext'] == 'html' ) {
							$ext_class = 'fal fa-file-code';
						} else if( $attachment_ext['ext'] == 'zip' ) {
							$ext_class = 'fal fa-file-archive';
						} else if( $attachment_ext['ext'] == 'mp3' ) {
							$ext_class = 'fal fa-file-audio';
						} else if( $attachment_ext['ext'] == 'wma' ) {
							$ext_class = 'fal fa-file-music';
						} else if( $attachment_ext['ext'] == 'jpg' || $attachment_ext['ext'] == 'jpeg' || $attachment_ext['ext'] == 'png' || $attachment_ext['ext'] == 'gif' ) {
							$ext_class = 'fal fa-file-image';
						}

						$output .= '<div class="dtdr-listings-attachment-box-item">';
							if($attrs['type'] != 'type5') {
								$output .= '<span class="'.esc_attr($ext_class).'"></span>';
							}
							$output .= '<a href="'.esc_url($attachment_url).'" target="_blank">';
								if($attrs['type'] == 'type5') {
									$output .= '<span class="'.esc_attr($ext_class).'"></span>';
								}
								$output .= esc_attr($dtdr_attachment_title);
							$output .= '</a>';
						$output .= '</div>';

						$j++;

					}
				}

			$output .= '</div>';

		}

		return $output;

	}
	add_shortcode ( 'dtdr_sp_media_attachments', 'dtdr_sp_media_attachments' );
}

?>