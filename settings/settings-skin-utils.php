<?php

function dtdr_settings_skin_content() {

	$output = '';

	$skin_settings = get_option('dtdr-skin-settings');

	$primary_color = ( isset($skin_settings['primary-color']) && '' !=  $skin_settings['primary-color'] ) ? $skin_settings['primary-color'] : '#1e306e';
	$secondary_color = ( isset($skin_settings['secondary-color']) && '' !=  $skin_settings['secondary-color'] ) ? $skin_settings['secondary-color'] : '#2fa5fb';
	$tertiary_color = ( isset($skin_settings['tertiary-color']) && '' !=  $skin_settings['tertiary-color'] ) ? $skin_settings['tertiary-color'] : '#d2edf8';

	$primary_alternate_color = ( isset($skin_settings['primary-alternate-color']) && '' !=  $skin_settings['primary-alternate-color'] ) ? $skin_settings['primary-alternate-color'] : '';
	$secondary_alternate_color = ( isset($skin_settings['secondary-alternate-color']) && '' !=  $skin_settings['secondary-alternate-color'] ) ? $skin_settings['secondary-alternate-color'] : '';
	$tertiary_alternate_color = ( isset($skin_settings['tertiary-alternate-color']) && '' !=  $skin_settings['tertiary-alternate-color'] ) ? $skin_settings['tertiary-alternate-color'] : '';


	$output .= '<form name="formSkinSettings" class="formSkinSettings" method="post">';

		$output .= '<div class="dtdr-note">'.esc_html__('Following colors will be used as default colors for "DesignThemes Directory Addon".','dtdr-lite').'</div>';

		$output .= '<div class="dtdr-column dtdr-one-third first">';
			$output .= '<div class="dtdr-settings-options-holder">';
				$output .= '<div class="dtdr-column dtdr-one-fifth first">';
					$output .= '<label>'.esc_html__( 'Primary Color','dtdr-lite').'</label>';
				$output .= '</div>';
				$output .= '<div class="dtdr-column dtdr-four-fifth">';
		            $output .= '<input name="dtdr-skin-settings[primary-color]" class="dtdr-color-field color-picker" data-alpha="true" type="text" value="'.$primary_color.'" />';
		            $output .= '<div class="dtdr-note">'.esc_html__('Choose primary color module skin.','dtdr-lite').'</div>';
				$output .= '</div>';
			$output .= '</div>';
		$output .= '</div>';

		$output .= '<div class="dtdr-column dtdr-one-third">';
			$output .= '<div class="dtdr-settings-options-holder">';
				$output .= '<div class="dtdr-column dtdr-one-fifth first">';
					$output .= '<label>'.esc_html__( 'Secondary Color','dtdr-lite').'</label>';
				$output .= '</div>';
				$output .= '<div class="dtdr-column dtdr-four-fifth">';
		            $output .= '<input name="dtdr-skin-settings[secondary-color]" class="dtdr-color-field color-picker" data-alpha="true" type="text" value="'.$secondary_color.'" />';
		            $output .= '<div class="dtdr-note">'.esc_html__('Choose secondary color module skin.','dtdr-lite').'</div>';
				$output .= '</div>';
			$output .= '</div>';
		$output .= '</div>';

		$output .= '<div class="dtdr-column dtdr-one-third">';
			$output .= '<div class="dtdr-settings-options-holder">';
				$output .= '<div class="dtdr-column dtdr-one-fifth first">';
					$output .= '<label>'.esc_html__( 'Tertiary Color','dtdr-lite').'</label>';
				$output .= '</div>';
				$output .= '<div class="dtdr-column dtdr-four-fifth">';
		            $output .= '<input name="dtdr-skin-settings[tertiary-color]" class="dtdr-color-field color-picker" data-alpha="true" type="text" value="'.$tertiary_color.'" />';
		            $output .= '<div class="dtdr-note">'.esc_html__('Choose tertiary color module skin.','dtdr-lite').'</div>';
				$output .= '</div>';
			$output .= '</div>';
		$output .= '</div>';

		$output .= '<div class="dtdr-hr-invisible"></div>';

/* 		$output .= '<div class="dtdr-column dtdr-one-third first">';
			$output .= '<div class="dtdr-settings-options-holder">';
				$output .= '<div class="dtdr-column dtdr-one-fifth first">';
					$output .= '<label>'.esc_html__( 'Primary Color - Alternate','dtdr-lite').'</label>';
				$output .= '</div>';
				$output .= '<div class="dtdr-column dtdr-four-fifth">';
		            $output .= '<input name="dtdr-skin-settings[primary-alternate-color]" class="dtdr-color-field color-picker" data-alpha="true" type="text" value="'.$primary_alternate_color.'" />';
		            $output .= '<div class="dtdr-note">'.esc_html__('Choose primary alternate color module skin.','dtdr-lite').'</div>';
				$output .= '</div>';
			$output .= '</div>';
		$output .= '</div>';

		$output .= '<div class="dtdr-column dtdr-one-third">';
			$output .= '<div class="dtdr-settings-options-holder">';
				$output .= '<div class="dtdr-column dtdr-one-fifth first">';
					$output .= '<label>'.esc_html__( 'Secondary Color - Alternate','dtdr-lite').'</label>';
				$output .= '</div>';
				$output .= '<div class="dtdr-column dtdr-four-fifth">';
		            $output .= '<input name="dtdr-skin-settings[secondary-alternate-color]" class="dtdr-color-field color-picker" data-alpha="true" type="text" value="'.$secondary_alternate_color.'" />';
		            $output .= '<div class="dtdr-note">'.esc_html__('Choose secondary alternate color module skin.','dtdr-lite').'</div>';
				$output .= '</div>';
			$output .= '</div>';
		$output .= '</div>';

		$output .= '<div class="dtdr-column dtdr-one-third">';
			$output .= '<div class="dtdr-settings-options-holder">';
				$output .= '<div class="dtdr-column dtdr-one-fifth first">';
					$output .= '<label>'.esc_html__( 'Tertiary Color - Alternate','dtdr-lite').'</label>';
				$output .= '</div>';
				$output .= '<div class="dtdr-column dtdr-four-fifth">';
		            $output .= '<input name="dtdr-skin-settings[tertiary-alternate-color]" class="dtdr-color-field color-picker" data-alpha="true" type="text" value="'.$tertiary_alternate_color.'" />';
		            $output .= '<div class="dtdr-note">'.esc_html__('Choose tertiary alternate color module skin.','dtdr-lite').'</div>';
				$output .= '</div>';
			$output .= '</div>';
		$output .= '</div>';

		$output .= '<div class="dtdr-hr-invisible"></div>'; */

		$output .= '<div class="dtdr-skin-settings-response-holder"></div>';

		$output .= '<a href="#" class="custom-button-style dtdr-save-skin-settings">'.esc_html__('Save Settings','dtdr-lite').'</a>';

	$output .= '</form>';

    echo $output;

}

echo dtdr_settings_skin_content();

?>