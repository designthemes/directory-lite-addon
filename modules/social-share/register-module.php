<?php

if (!class_exists ( 'DTDirectoryLiteRegisterSocialShareModule' )) {

	class DTDirectoryLiteRegisterSocialShareModule extends DTDirectoryLiteAddon {

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

			$this->dtdr_define_constants( 'DTDR_SOCIALSHARE_PLUGIN_PATH', DTDR_LITE_PLUGIN_PATH . 'modules/social-share/' );
			$this->dtdr_define_constants( 'DTDR_SOCIALSHARE_PLUGIN_URL', DTDR_LITE_PLUGIN_URL . 'modules/social-share/' );

			add_action ( 'wp_enqueue_scripts', array ( $this, 'dtdr_enqueue_scripts' ), 130 );

			require_once DTDR_SOCIALSHARE_PLUGIN_PATH . 'shortcodes.php';

		}

		function dtdr_enqueue_scripts() {
			$this->dtdr_register_dependent_files();
			$this->dtdr_enqueue_registered_files();
		}

		function dtdr_register_dependent_files() {

			wp_register_style ( 'dtdr-social-share-frontend', DTDR_SOCIALSHARE_PLUGIN_URL . 'assets/social-share-frontend.css', array ( 'fontawesome', 'icon-moon', 'material-icon', 'dtdr-base', 'dtdr-common' ) );

			wp_register_script ( 'dtdr-social-share-frontend', DTDR_SOCIALSHARE_PLUGIN_URL . 'assets/frontend.js', array ('jquery', 'dtdr-common'), false, true );

		}

		function dtdr_enqueue_registered_files() {

			wp_enqueue_style ( 'dtdr-social-share-frontend' );

			wp_enqueue_script ( 'dtdr-social-share-frontend' );

		}

	}

}

if( !function_exists('dtdrSocialShareModule') ) {
	function dtdrSocialShareModule() {
		return DTDirectoryLiteRegisterSocialShareModule::instance();
	}
}

dtdrSocialShareModule();

?>