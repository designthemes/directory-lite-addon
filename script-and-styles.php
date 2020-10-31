<?php

if( !class_exists('DTDirectoryLiteDependentFiles') ) {

	class DTDirectoryLiteDependentFiles {

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

			add_action ( 'admin_enqueue_scripts', array ( $this, 'dtdr_admin_enqueue_scripts' ), 100 );
			add_action ( 'wp_enqueue_scripts', array ( $this, 'dtdr_enqueue_dependent_files' ), 120 );
			add_action ( 'wp_enqueue_scripts', array ( $this, 'dtdr_dequeue_files' ), 999 );

			require_once DTDR_LITE_PLUGIN_PATH . 'assets/css/skin.php';

		}

		/**
		 * Admin enqueue scripts
		 */
		function dtdr_admin_enqueue_scripts() {

			$current_screen = get_current_screen();

			wp_register_style ( 'jquery-ui', DTDR_LITE_PLUGIN_URL . 'assets/css/jquery-ui.min.css' );
			wp_register_style ( 'fontawesome', DTDR_LITE_PLUGIN_URL . 'assets/css/all.min.css' );
			wp_register_style ( 'material-icon', DTDR_LITE_PLUGIN_URL . 'assets/css/material-design-iconic-font.min.css' );
			wp_register_style ( 'chosen', DTDR_LITE_PLUGIN_URL . 'assets/css/chosen.css' );
			wp_register_style ( 'dtdr-fields', DTDR_LITE_PLUGIN_URL . 'assets/css/fields.css' );
			wp_register_style ( 'dtdr-backend', DTDR_LITE_PLUGIN_URL . 'assets/css/backend.css' );
			wp_register_style ( 'dtdr-common', DTDR_LITE_PLUGIN_URL . 'assets/css/common.css' );

			wp_register_script ( 'wp-color-picker-alpha', DTDR_LITE_PLUGIN_URL . 'assets/js/wp-color-picker-alpha.min.js', array (), false, true );
			wp_register_script ( 'chosen', DTDR_LITE_PLUGIN_URL . 'assets/js/chosen.jquery.min.js', array ('jquery'), false, true );
			wp_register_script ( 'dtdr-tabs', DTDR_LITE_PLUGIN_URL . 'assets/js/jquery.tabs.min.js', array (), false, true );
			wp_register_script ( 'dtdr-fields', DTDR_LITE_PLUGIN_URL . 'assets/js/fields.js', array ('jquery'), false, true );

			wp_register_script ( 'dtdr-common', DTDR_LITE_PLUGIN_URL . 'assets/js/common.js', array (), false, true );
			wp_localize_script ( 'dtdr-common', 'dtdrcommonobject', array (
					'ajaxurl'  => admin_url('admin-ajax.php'),
					'noResult' => esc_html__('No Results Found!','dtdr-lite')
				));

			wp_register_script ( 'dtdr-backend', DTDR_LITE_PLUGIN_URL . 'assets/js/backend.js', array (), false, true );
			wp_localize_script ( 'dtdr-backend', 'dtdrbackendobject', array (
					'ajaxurl'        => admin_url('admin-ajax.php'),
					'locationAlert1' => esc_html__('To get GPS location please fill address.','dtdr-lite'),
					'locationAlert2' => esc_html__('Please add latitude and longitude','dtdr-lite'),
					'confirmImport'  => esc_html__('Confirm to import listings','dtdr-lite')
				));


			// For Taxonomies & Settings

			if(in_array($current_screen->id, array ('edit-dtdr_listings_category', 'edit-dtdr_listings_ctype', 'edit-dtdr_listings_amenity', 'directory_page_dtdr-settings-options'))) {

				// CSS

				wp_enqueue_style ( 'wp-color-picker' );
				wp_enqueue_style ( 'dtdr-fields' );

				wp_enqueue_style ( 'dtdr-backend' );
				wp_enqueue_style ( 'dtdr-common' );


				// JS

				wp_enqueue_script ( 'wp-color-picker' );
				wp_enqueue_script ( 'wp-color-picker-alpha' );
				wp_enqueue_script ( 'dtdr-fields' );

				wp_enqueue_script ( 'dtdr-common' );
				wp_enqueue_script ( 'dtdr-backend' );


			}

			// For Listings

			if($current_screen->id == 'dtdr_listings') {

				// CSS

				wp_enqueue_style ( 'fontawesome' );
				wp_enqueue_style ( 'chosen' );
				wp_enqueue_style ( 'dtdr-fields' );

				wp_enqueue_style ( 'dtdr-backend' );
				wp_enqueue_style ( 'dtdr-common' );


				// JS

				wp_enqueue_script ( 'chosen' );
				wp_enqueue_script ( 'dtdr-tabs' );
				wp_enqueue_script ( 'dtdr-fields' );

				wp_enqueue_script ( 'dtdr-common' );
				wp_enqueue_script ( 'dtdr-backend' );

			}

			//wp_enqueue_media ();

		}

		/**
		 * Frontend - Register CSS Files
		 */
		function dtdr_enqueue_dependent_files() {

			$this->dtdr_register_css_files();
			$this->dtdr_register_js_files();
			$this->dtdr_register_custom_options();
			$this->dtdr_enqueue_registered_files();


			// CSS

				if(is_rtl() || (isset($_REQUEST['rtl']) && $_REQUEST['rtl'] == 'yes')) {
					wp_enqueue_style ( 'dtdr-rtl' );
				}

				if (is_plugin_active('responsive-mortgage-calculator/responsive-mortgage-calculator.php') || is_plugin_active_for_network('responsive-mortgage-calculator/responsive-mortgage-calculator.php')) {
					wp_enqueue_style ( 'dtdr-rmc' );
				}

		}

		/**
		 * Frontend - Register CSS Files
		 */
		function dtdr_register_css_files() {

			wp_register_style ( 'jquery-ui', DTDR_LITE_PLUGIN_URL . 'assets/css/jquery-ui.min.css' );
			wp_register_style ( 'fontawesome', DTDR_LITE_PLUGIN_URL . 'assets/css/all.min.css' );
			//wp_register_style ( 'icon-moon', DTDR_LITE_PLUGIN_URL . 'assets/css/icon-moon.css' );
			wp_register_style ( 'icon-moon', '' );
			wp_register_style ( 'material-icon', DTDR_LITE_PLUGIN_URL . 'assets/css/material-design-iconic-font.min.css' );
			wp_register_style ( 'chosen', DTDR_LITE_PLUGIN_URL . 'assets/css/chosen.css' );
			wp_register_style ( 'swiper', DTDR_LITE_PLUGIN_URL . 'assets/css/swiper.min.css' );
			wp_register_style ( 'prettyPhoto', DTDR_LITE_PLUGIN_URL . 'assets/css/prettyPhoto.css' );
			wp_register_style ( 'dtdr-common', DTDR_LITE_PLUGIN_URL . 'assets/css/common.css' );
			wp_register_style ( 'dtdr-base', DTDR_LITE_PLUGIN_URL . 'assets/css/base.css' );
			wp_register_style ( 'dtdr-fields', DTDR_LITE_PLUGIN_URL . 'assets/css/fields.css' );

			wp_register_style ( 'dtdr-modules-listing', DTDR_LITE_PLUGIN_URL . 'assets/css/modules-listing.css', array ( 'fontawesome', 'icon-moon', 'material-icon', 'dtdr-base', 'dtdr-common' ) );
			wp_register_style ( 'dtdr-modules-default', DTDR_LITE_PLUGIN_URL . 'assets/css/modules-default.css', array ( 'fontawesome', 'icon-moon', 'material-icon', 'dtdr-base', 'dtdr-common' ) );
			wp_register_style ( 'dtdr-modules-singlepage', DTDR_LITE_PLUGIN_URL . 'assets/css/modules-singlepage.css', array ( 'fontawesome', 'icon-moon', 'material-icon', 'dtdr-base', 'dtdr-common' )  );
			wp_register_style ( 'dtdr-rtl', DTDR_LITE_PLUGIN_URL . 'assets/css/rtl.css' );
			wp_register_style ( 'dtdr-rmc', DTDR_LITE_PLUGIN_URL . 'assets/css/rmc.css' );

		}

		/**
		 * Frontend - Register JS Files
		 */
		function dtdr_register_js_files() {

			wp_register_script ( 'chosen', DTDR_LITE_PLUGIN_URL . 'assets/js/chosen.jquery.min.js', array ('jquery'), false, true );
			wp_register_script ( 'swiper', DTDR_LITE_PLUGIN_URL . 'assets/js/swiper.min.js', array ('jquery'), false, true );
			wp_register_script ( 'prettyPhoto', DTDR_LITE_PLUGIN_URL . 'assets/js/jquery.prettyPhoto.min.js', array ('jquery'), false, true);
			wp_register_script ( 'isotope', DTDR_LITE_PLUGIN_URL . 'assets/js/isotope.pkgd.min.js', array ('jquery'), false, true);
			wp_register_script ( 'matchheight', DTDR_LITE_PLUGIN_URL . 'assets/js/matchHeight.js', array(), false, true);

			wp_register_script ( 'dtdr-fields', DTDR_LITE_PLUGIN_URL . 'assets/js/fields.js', array ('jquery', 'jquery-ui-sortable'), false, true );

			wp_register_script ( 'dtdr-common', DTDR_LITE_PLUGIN_URL . 'assets/js/common.js', array ('jquery'), false, true );
			wp_localize_script ( 'dtdr-common', 'dtdrcommonobject', array (
				'ajaxurl' => admin_url('admin-ajax.php'),
				'noResult' => esc_html__('No Results Found!','dtdr-lite'),
			));

			$listing_singular_label = apply_filters( 'listing_label', 'singular' );
			$incharge_singular_label = apply_filters( 'incharge_label', 'singular' );

			$elementor_preview_mode = false;

			include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
			if (is_plugin_active('elementor/elementor.php') || is_plugin_active_for_network('elementor/elementor.php')) {  // Elementor Plugin

				if ( \Elementor\Plugin::$instance->preview->is_preview_mode() ) {
					$elementor_preview_mode = true;
				}

			}


			$skin_settings = get_option('dtdr-skin-settings');
			$primary_color = ( isset($skin_settings['primary-color']) && '' !=  $skin_settings['primary-color'] ) ? $skin_settings['primary-color'] : '#1e306e';
			$secondary_color = ( isset($skin_settings['secondary-color']) && '' !=  $skin_settings['secondary-color'] ) ? $skin_settings['secondary-color'] : '#2fa5fb';
			$tertiary_color = ( isset($skin_settings['tertiary-color']) && '' !=  $skin_settings['tertiary-color'] ) ? $skin_settings['tertiary-color'] : '#d2edf8';


			wp_register_script ( 'dtdr-frontend', DTDR_LITE_PLUGIN_URL . 'assets/js/frontend.js', array ('jquery', 'dtdr-common'), false, true );
			wp_localize_script ( 'dtdr-frontend', 'dtdrfrontendobject', array (
				'pluginFolderPath'                 => plugins_url().'/',
				'pluginPath'                       => DTDR_LITE_PLUGIN_URL,
				'ajaxurl'                          => admin_url('admin-ajax.php'),
				'purchased'                        => '<p>'.esc_html__('Purchased','dtdr-lite').'</p>',
				'somethingWentWrong'               => '<p>'.esc_html__('Something Went Wrong','dtdr-lite').'</p>',
				'addListingSuccess'                => '<p>'.sprintf( esc_html__('Successfully posted your %1$s','dtdr-lite'), strtolower($listing_singular_label) ).'</p>',
				'updateProfileSuccess'             => '<p>'.esc_html__('Your profile have been updated successfully.','dtdr-lite').'</p>',
				'updateProfilePwdSuccess'          => '<p>'.esc_html__('Password updated successfully.','dtdr-lite').'</p>
				<p>'.esc_html__('You will be logged out, please loggin again.','dtdr-lite').'</p>',
				'updateInchargeSuccess'            => '<p>'.sprintf( esc_html__('%1$s updated successfully.','dtdr-lite'), $incharge_singular_label ).'</p>',
				'naviagtorAlert'                   => esc_html__('Geolocation is not supported by this browser.','dtdr-lite'),
				'outputDivAlert'                   => esc_html__('Please make sure you have added output shortcode.','dtdr-lite'),
				'confirmRemoveIncharge'            => sprintf( esc_html__('Are you sure, you wish to delete this %1$s ?','dtdr-lite'), strtolower($incharge_singular_label) ),
				'confirmRemoveListing'             => sprintf( esc_html__('Are you sure, you wish to delete this %1$s ?','dtdr-lite'), strtolower($listing_singular_label) ),
				'confirmRemoveFavouriteListing'    => sprintf( esc_html__('Are you sure, you wish to remove this %1$s from your favourites ?','dtdr-lite'), strtolower($listing_singular_label) ),
				'printerTitle'                     => sprintf( esc_html__('%1$s Printer','dtdr-lite'), $listing_singular_label ),
				'inchargeStatusActive'             => esc_html__('Active','dtdr-lite'),
				'inchargeStatusDisable'            => esc_html__('Disabled','dtdr-lite'),
				'inchargeStatusWaitingForApproval' => esc_html__('Waiting For Approval','dtdr-lite'),
				'listingWaitingForApproval'        => esc_html__('Waiting For Approval','dtdr-lite'),
				'listingPending'                   => esc_html__('Pending','dtdr-lite'),
				'listingPublish'                   => esc_html__('Publish','dtdr-lite'),
				'listingTooltipSubmitForApproval'  => esc_html__('Submit For Approval','dtdr-lite'),
				'listingTooltipRevokeSubmission'   => esc_html__('Revoke Submission For Approval','dtdr-lite'),
				'adDurationWarning'                => esc_html__('Please provide duration for your ad','dtdr-lite'),
				'adPricingWarning'                 => esc_html__('Please choose any of the pricing available for your ad','dtdr-lite'),
				'elementorPreviewMode'             => esc_js($elementor_preview_mode),
				'primaryColor'                     => $primary_color,
				'secondaryColor'                   => $secondary_color,
				'tertiaryColor'                    => $tertiary_color,
			));

			wp_register_script ( 'dtdr-modules-singlepage', DTDR_LITE_PLUGIN_URL . 'assets/js/single-page.js', array ('jquery', 'dtdr-frontend'), false, true );

		}

		/**
		 * Frontend - Enqueue Registered Files
		 */
		function dtdr_enqueue_registered_files() {

			// CSS

				wp_enqueue_style ( 'swiper' );
				wp_enqueue_style ( 'dtdr-modules-listing' );
				wp_enqueue_style ( 'dtdr-modules-default' );

			// JS

				wp_enqueue_script ( 'swiper' );
				wp_enqueue_script ( 'isotope' );
				wp_enqueue_script ( 'matchheight' );
				wp_enqueue_script ( 'dtdr-frontend' );

			// Modulewise

				if (is_singular( 'dtdr_listings' )|| is_page_template( 'tpl-single-listing.php' )) {

					wp_enqueue_style ( 'dtdr-modules-singlepage' );

					wp_enqueue_script ( 'dtdr-modules-singlepage' );

				}

		}

		/**
		 * Register Custom Options
		 */
		function dtdr_register_custom_options() {

			if (is_singular( 'dtdr_listings' ) || is_singular( 'dtdr_packages' ) || is_post_type_archive('dtdr_listings') || is_tax('dtdr_listings_category') || is_tax('dtdr_listings_city') || is_tax('dtdr_listings_neighborhood') || is_tax('dtdr_listings_countystate') || is_tax('dtdr_listings_ctype') || is_tax('dtdr_listings_amenity') || is_post_type_archive('dtdr_packages') || is_author() || is_page_template( 'tpl-single-listing.php' ) || is_page_template( 'tpl-dashboard.php' )) {

				$css = '';

				$container_width = dtdr_option('general','container-width');
				if(isset($container_width) && !empty($container_width)) {
					$css = '.dtdr-container { max-width:'.$container_width.'px; }';
				}

				if($css != '') {
					wp_register_style( 'dtdr-custom-options', false );
					wp_enqueue_style( 'dtdr-custom-options' );
					wp_add_inline_style( 'dtdr-custom-options', $css );
				}

			}

		}

		/**
		 * Dequeue Files
		 */
		function dtdr_dequeue_files() {
			if(is_singular( 'post' )) {
				global $wp_styles;
				unset($wp_styles->registered['dtdr-fields']);
			}
		}

	}

}

if( !function_exists('dtdr_dependent_files_instance') ) {
	function dtdr_dependent_files_instance() {
		return DTDirectoryLiteDependentFiles::instance();
	}
}

dtdr_dependent_files_instance();

?>