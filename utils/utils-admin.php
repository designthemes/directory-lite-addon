<?php

if( !function_exists( 'dtdr_adminpanel_image_preview' ) ){
	function dtdr_adminpanel_image_preview($src) {

		$default = DTDR_LITE_PLUGIN_URL.'assets/images/backend/no-image.jpg';
		$src = !empty($src) ? $src : $default;
		
		$output = '';

		$output .= '<div class="dtdr-image-preview-holder">';
			$output .= '<a href="#" class="dtdr-image-preview" onclick="return false;">';
				$output .= '<img src="'.DTDR_LITE_PLUGIN_URL.'assets/images/backend/image-preview.png" alt="'.esc_html__('Image Preview','dtdr-lite').'" title="'.esc_html__('Image Preview','dtdr-lite').'" />';
				$output .= '<div class="dtdr-image-preview-tooltip">';
					$output .= '<img src="'.$src.'" data-default="'.$default.'"  alt="'.esc_html__('Image Preview Tooltip','dtdr-lite').'" title="'.esc_html__('Image Preview Tooltip','dtdr-lite').'" />';
				$output .= '</div>';
			$output .= '</a>';
		$output .= '</div>';

		return $output;

	}
}

if( !function_exists( 'dtdr_adminpanel_image_holder' ) ){
	function dtdr_adminpanel_image_holder($src) {

		$default = DTDR_LITE_PLUGIN_URL.'assets/images/backend/no-image.jpg';
		$src = !empty($src) ? $src : $default;
		
		$output = '';

		$output .= '<div class="dtdr-image-holder">
						<img src="'.$src.'" data-default="'.$default.'"  alt="'.esc_html__('Image Preview','dtdr-lite').'" title="'.esc_html__('Image Preview','dtdr-lite').'" />
					</div>';

		return $output;

	}
}
?>