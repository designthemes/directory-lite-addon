<?php

if (!class_exists ( 'DTDirectoryLiteRegisterSearchModule' )) {

	class DTDirectoryLiteRegisterSearchModule extends DTDirectoryLiteAddon {

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

			$this->dtdr_define_constants( 'DTDR_SEARCH_PLUGIN_PATH', DTDR_LITE_PLUGIN_PATH . 'modules/search/' );
			$this->dtdr_define_constants( 'DTDR_SEARCH_PLUGIN_URL', DTDR_LITE_PLUGIN_URL . 'modules/search/' );

			$this->dtdr_define_constants( 'DTDR_PB_MODULE_SEARCHFORM_TITLE', sprintf( esc_html__('%1$s - Search Form','dtdr-lite'), DTDR_LITE_PLUGIN_NAME ) );

			add_action ( 'wp_enqueue_scripts', array ( $this, 'dtdr_enqueue_scripts' ), 130 );

			require_once DTDR_SEARCH_PLUGIN_PATH . 'shortcodes.php';

		}

		function dtdr_enqueue_scripts() {

			$this->dtdr_register_dependent_files();
			$this->dtdr_enqueue_registered_files();

		}

		function dtdr_register_dependent_files() {

			wp_register_style ( 'dtdr-search-frontend', DTDR_SEARCH_PLUGIN_URL . 'assets/search-frontend.css', array ( 'fontawesome', 'icon-moon', 'material-icon', 'dtdr-base', 'dtdr-common', 'dtdr-fields' ) );
			wp_register_script ( 'dtdr-search-frontend', DTDR_SEARCH_PLUGIN_URL . 'assets/frontend.js', array ('jquery', 'dtdr-frontend'), false, true );

		}

		function dtdr_enqueue_registered_files() {

			wp_enqueue_style ( 'jquery-ui' );
			wp_enqueue_style ( 'chosen' );
			wp_enqueue_style ( 'dtdr-search-frontend' );

			wp_enqueue_script ( 'jquery-ui-slider' );
			wp_enqueue_script ( 'chosen' );
			wp_enqueue_script ( 'jquery-ui-datepicker' );
			wp_enqueue_script ( 'dtdr-search-frontend' );
		}

	}

}

if( !function_exists('dtdrSearchModule') ) {
	function dtdrSearchModule() {
		return DTDirectoryLiteRegisterSearchModule::instance();
	}
}

dtdrSearchModule();

?>