<?php

function dtdr_settings_comments_content() {

	$output = '';

	$listing_singular_label = apply_filters( 'listing_label', 'singular' );
	$listing_plural_label   = apply_filters( 'listing_label', 'plural' );

	$output .= '<form name="formOptionSettings" class="formOptionSettings" method="post">';

		$output .= '<div class="dtdr-settings-options-holder">';
			$output .= '<div class="dtdr-column dtdr-one-fifth first">';
				$output .= '<label>'.esc_html__( 'Comment Requires Active Package','dtdr-lite') .'</label>';
			$output .= '</div>';
			$output .= '<div class="dtdr-column dtdr-four-fifth">';
				$checked = ( 'true' ==  dtdr_option('comments','comment-requires-package') ) ? ' checked="checked"' : '';
				$switchclass = ( 'true' ==  dtdr_option('comments','comment-requires-package') ) ? 'checkbox-switch-on' :'checkbox-switch-off';
				$output .= '<div data-for="comment-requires-package" class="dtdr-checkbox-switch '.esc_attr( $switchclass ).'"></div>';
				$output .= '<input id="comment-requires-package" class="hidden" type="checkbox" name="dtdr[comments][comment-requires-package]" value="true" '.esc_attr( $checked ).' />';
			$output .= '</div>';
		$output .= '</div>';

		$output .= '<div class="dtdr-option-settings-response-holder"></div>';

		$output .= '<a href="#" class="custom-button-style dtdr-save-options-settings" data-settings="comments">'.esc_html__('Save Settings','dtdr-lite').'</a>';

	$output .= '</form>';

	return $output;

}

echo dtdr_settings_comments_content();
?>