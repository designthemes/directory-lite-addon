<?php

if (!class_exists ( 'DTDirectoryLiteRegisterMediaAttachmentsModule' )) {

	class DTDirectoryLiteRegisterMediaAttachmentsModule extends DTDirectoryLiteAddon {

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

			$this->dtdr_define_constants( 'DTDR_MATTACHMENTS_PLUGIN_PATH', DTDR_LITE_PLUGIN_PATH . 'modules/media-attachments/' );
			$this->dtdr_define_constants( 'DTDR_MATTACHMENTS_PLUGIN_URL', DTDR_LITE_PLUGIN_URL . 'modules/media-attachments/' );

			add_filter ( 'dtdr_metabox_tabs', array ( $this, 'dtdr_metabox_tabs_tab' ) );

			add_action ( 'admin_enqueue_scripts', array ( $this, 'dtdr_admin_enqueue_scripts' ), 120 );
			add_action ( 'wp_enqueue_scripts', array ( $this, 'dtdr_enqueue_scripts' ), 130 );

			add_action ( 'dtdr_addorupdate_listing_module', array ( $this, 'dtdr_addorupdate_listing_mediaattachments_module' ), 10, 2 );

			require_once DTDR_MATTACHMENTS_PLUGIN_PATH . 'utils.php';
			require_once DTDR_MATTACHMENTS_PLUGIN_PATH . 'shortcodes.php';
			require_once DTDR_MATTACHMENTS_PLUGIN_PATH . 'dashboard.php';

		}

		function dtdr_metabox_tabs_tab($tabs) {

			$tabs['media-attachments'] = array (
				'label' => esc_html__('Media - Attachments','dtdr-lite'),
				'icon'  => 'fas fa-camera-retro',
				'path'  => DTDR_MATTACHMENTS_PLUGIN_PATH . 'metabox-tab-listing.php'
			);

			return $tabs;

		}

		function dtdr_admin_enqueue_scripts() {

			$this->dtdr_register_dependent_files();

			$current_screen = get_current_screen();
			if($current_screen->id == 'dtdr_listings') {
				wp_enqueue_style ( 'dtdr-media-attachments-fields' );
				wp_enqueue_script ( 'dtdr-media-attachments-fields' );
			}

		}

		function dtdr_enqueue_scripts() {

			$this->dtdr_register_dependent_files();
			$this->dtdr_enqueue_registered_files();

			if(is_page_template('tpl-dashboard.php')) {
				wp_enqueue_media();
				wp_enqueue_script ( 'dtdr-media-attachments-fields' );
			}

		}

		function dtdr_register_dependent_files() {

			wp_register_style ( 'dtdr-media-attachments-frontend', DTDR_MATTACHMENTS_PLUGIN_URL . 'assets/media-attachments-frontend.css', array ( 'fontawesome', 'icon-moon', 'material-icon', 'dtdr-base', 'dtdr-common', 'swiper' ) );
			wp_register_script ( 'dtdr-media-attachments-fields', DTDR_MATTACHMENTS_PLUGIN_URL . 'assets/fields.js', array ('jquery', 'dtdr-fields'), false, true );

		}

		function dtdr_enqueue_registered_files() {

			wp_enqueue_style ( 'dtdr-media-attachments-frontend' );

		}

		function dtdr_addorupdate_listing_mediaattachments_module($data, $listing_id) {

			extract($data);

			update_post_meta($listing_id, 'dtdr_media_attachments_titles', $dtdr_media_attachments_titles);
			update_post_meta($listing_id, 'dtdr_media_attachments_items', $dtdr_media_attachments_items);

		}

	}

}

if( !function_exists('dtdrMediaAttachmentsModule') ) {
	function dtdrMediaAttachmentsModule() {
		return DTDirectoryLiteRegisterMediaAttachmentsModule::instance();
	}
}

dtdrMediaAttachmentsModule();

?>