<?php

if (!class_exists ( 'DTDirectoryLiteRegisterBusinessHoursModule' )) {

	class DTDirectoryLiteRegisterBusinessHoursModule extends DTDirectoryLiteAddon {

		private $module_name;
		private $module_url;

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

			$this->dtdr_define_constants( 'DTDR_BHOURS_PLUGIN_PATH', DTDR_LITE_PLUGIN_PATH . 'modules/business-hours/' );
			$this->dtdr_define_constants( 'DTDR_BHOURS_PLUGIN_URL', DTDR_LITE_PLUGIN_URL . 'modules/business-hours/' );

			add_filter ( 'dtdr_metabox_tabs', array ( $this, 'dtdr_metabox_tabs_tab' ) );

			add_action ( 'admin_enqueue_scripts', array ( $this, 'dtdr_admin_enqueue_scripts' ), 120 );
			add_action ( 'wp_enqueue_scripts', array ( $this, 'dtdr_enqueue_scripts' ), 130 );

			add_action ( 'dtdr_addorupdate_listing_module', array ( $this, 'dtdr_addorupdate_listing_businesshours_module' ), 10, 2 );

			require_once DTDR_BHOURS_PLUGIN_PATH . 'shortcodes.php';
			require_once DTDR_BHOURS_PLUGIN_PATH . 'utils.php';
			require_once DTDR_BHOURS_PLUGIN_PATH . 'dashboard.php';

		}

		function dtdr_metabox_tabs_tab($tabs) {

			$tabs['business-hours'] = array (
				'label' => esc_html__('Business Hours','dtdr-lite'),
				'icon' => 'fas fa-clock',
				'path' => DTDR_BHOURS_PLUGIN_PATH . 'metabox-tab-listing.php'
			);

			return $tabs;

		}

		function dtdr_admin_enqueue_scripts() {

			$this->dtdr_register_dependent_files();

			$current_screen = get_current_screen();
			if($current_screen->id == 'dtdr_listings') {
				wp_enqueue_style ( 'dtdr-business-hours-fields' );
			}

		}

		function dtdr_enqueue_scripts() {

			$this->dtdr_register_dependent_files();
			$this->dtdr_enqueue_registered_files();

			if(is_page_template('tpl-dashboard.php')) {
				wp_enqueue_style ( 'dtdr-business-hours-fields' );
			}

		}

		function dtdr_register_dependent_files() {

			wp_register_style ( 'dtdr-business-hours-fields', DTDR_BHOURS_PLUGIN_URL . 'assets/business-hours-fields.css', array ( 'dtdr-fields' ) );
			wp_register_style ( 'dtdr-business-hours-frontend', DTDR_BHOURS_PLUGIN_URL . 'assets/business-hours-frontend.css', array ( 'fontawesome', 'icon-moon', 'material-icon', 'dtdr-base', 'dtdr-common', 'swiper' ) );

		}

		function dtdr_enqueue_registered_files() {

			wp_enqueue_style ( 'dtdr-business-hours-frontend' );

		}

		function dtdr_addorupdate_listing_businesshours_module($data, $listing_id) {

			extract($data);

			update_post_meta($listing_id, 'dtdr_business_hours', $dtdr_business_hours);
			update_post_meta($listing_id, 'dtdr_business_hours_24hour_format', $dtdr_business_hours_24hour_format);

		}

	}

}

if( !function_exists('dtdrBusinessHoursModule') ) {
	function dtdrBusinessHoursModule() {
		return DTDirectoryLiteRegisterBusinessHoursModule::instance();
	}
}

dtdrBusinessHoursModule();

?>