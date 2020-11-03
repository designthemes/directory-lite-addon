<?php

function dtdr_settings_login_content() {

	$seller_singular_label = apply_filters( 'seller_label', 'singular' );
	$incharge_singular_label = apply_filters( 'incharge_label', 'singular' );

	$output = '';

	$output .= '<form name="formOptionSettings" class="formOptionSettings" method="post">';

		$output .= '<div class="dtdr-settings-options-holder">';
			$output .= '<div class="dtdr-column dtdr-one-fifth first">';
				$output .= '<label>'.sprintf( esc_html__( '%1$s Login Redirect Page','dtdr-lite'), $seller_singular_label ).'</label>';
			$output .= '</div>';
			$output .= '<div class="dtdr-column dtdr-four-fifth">';

				$seller_login_redirect_page = dtdr_option('login','seller-login-redirect-page');

				$seller_login_redirectpages = array (
					'homeurl'   => esc_html__('Home','dtdr-lite')
				);
				$seller_login_redirectpages = apply_filters( 'seller_login_redirect_pages', $seller_login_redirectpages );

				$output .= '<select id="seller-login-redirect-page" name="dtdr[login][seller-login-redirect-page]" class="dtdr-chosen-select">';

					if(is_array($seller_login_redirectpages) && !empty($seller_login_redirectpages)) {
						foreach($seller_login_redirectpages as $key => $seller_login_redirectpage) {
							$output .= '<option value="'.esc_attr( $key ).'" '.selected($key, $seller_login_redirect_page, false ).'>';
								$output .= esc_html( $seller_login_redirectpage );
							$output .= '</option>';
						}
					}

				$output .= '</select>';
	            $output .= '<div class="dtdr-note">'.sprintf( esc_html__( 'You can choose %1$s login redirect page. Default is home page.','dtdr-lite'), $seller_singular_label ).'</div>';

			$output .= '</div>';
		$output .= '</div>';

		$output .= '<div class="dtdr-settings-options-holder">';
			$output .= '<div class="dtdr-column dtdr-one-fifth first">';
				$output .= '<label>'.sprintf( esc_html__( '%1$s Login Redirect Page','dtdr-lite'), $incharge_singular_label ).'</label>';
			$output .= '</div>';
			$output .= '<div class="dtdr-column dtdr-four-fifth">';

				$incharge_login_redirect_page = dtdr_option('login','incharge-login-redirect-page');

				$incharge_login_redirectpages = array (
					'homeurl'   => esc_html__('Home','dtdr-lite')
				);
				$incharge_login_redirectpages = apply_filters( 'incharge_login_redirect_pages', $incharge_login_redirectpages );

				$output .= '<select id="incharge-login-redirect-page" name="dtdr[login][incharge-login-redirect-page]" class="dtdr-chosen-select">';

					if(is_array($incharge_login_redirectpages) && !empty($incharge_login_redirectpages)) {
						foreach($incharge_login_redirectpages as $key => $incharge_login_redirectpage) {
							$output .= '<option value="'.esc_attr( $key ).'" '.selected($key, $incharge_login_redirect_page, false ).'>';
								$output .= esc_html( $incharge_login_redirectpage );
							$output .= '</option>';
						}
					}

				$output .= '</select>';
	            $output .= '<div class="dtdr-note">'.sprintf( esc_html__( 'You can choose %1$s login redirect page. Default is home page.','dtdr-lite'), $incharge_singular_label ).'</div>';

			$output .= '</div>';
		$output .= '</div>';

		$output .= '<div class="dtdr-option-settings-response-holder"></div>';

		$output .= '<a href="#" class="custom-button-style dtdr-save-options-settings" data-settings="login">'.esc_html__('Save Settings','dtdr-lite').'</a>';

	$output .= '</form>';

	return $output;

}

echo dtdr_settings_login_content();

?>