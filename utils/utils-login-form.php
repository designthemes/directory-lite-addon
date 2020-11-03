<?php
// Login form
if(!function_exists('dtdr_login_form')) {
	function dtdr_login_form() {

		$redirect_url = (isset($_REQUEST['redirect_url']) && $_REQUEST['redirect_url'] != '') ? sanitize_text_field($_REQUEST['redirect_url']) : home_url('/');

		$output = '<div class="dtdr-login-form-container">';

			$output .= '<div class="dtdr-login-form">';

				$output .= '<div class="dtdr-login-form-holder">';

					$output .= '<div class="dtdr-title dtdr-login-title"><h2><span>'.esc_html__('Welcome!','dtdr-lite').'<strong>'.esc_html__('Login','dtdr-lite').'</strong></span></h2></div>';
					$output .= wp_login_form(array ('redirect' => $redirect_url, 'echo' => false));
		    		$output .= '<p class="tpl-forget-pwd"><a href="'.wp_lostpassword_url( get_permalink() ).'">'.esc_html__('Forgot password ?','dtdr-lite').'</a></p>';

				$output .= '</div>';

				$social_logins_module = apply_filters('dtdr_social_logins_module', array ());
				if(!empty($social_logins_module)) {
					$output .= $social_logins_module;
				}

			$output .= '</div>';

		$output .= '</div>';

		$output .= '<div class="dtdr-login-form-overlay"></div>';

		return $output;
	}
}

if(!function_exists('dtdr_show_login_form_popup')) {
	function dtdr_show_login_form_popup() {

		echo dtdr_login_form();

		die();
	}
	add_action( 'wp_ajax_dtdr_show_login_form_popup', 'dtdr_show_login_form_popup' );
	add_action( 'wp_ajax_nopriv_dtdr_show_login_form_popup', 'dtdr_show_login_form_popup' );
}?>