<?php

if (!class_exists ( 'DTDirectoryLiteRegisterCommentsModule' )) {

	class DTDirectoryLiteRegisterCommentsModule extends DTDirectoryLiteAddon {

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

			$this->dtdr_define_constants( 'DTDR_COMMENTS_PLUGIN_PATH', DTDR_LITE_PLUGIN_PATH . 'modules/comments/' );
			$this->dtdr_define_constants( 'DTDR_COMMENTS_PLUGIN_URL', DTDR_LITE_PLUGIN_URL . 'modules/comments/' );

			add_action ( 'admin_enqueue_scripts', array ( $this, 'dtdr_admin_enqueue_scripts' ), 120 );
			add_action ( 'wp_enqueue_scripts', array ( $this, 'dtdr_enqueue_scripts' ), 130 );

			require_once DTDR_COMMENTS_PLUGIN_PATH . 'shortcodes.php';
			require_once DTDR_COMMENTS_PLUGIN_PATH . 'utils.php';

		}

		function dtdr_admin_enqueue_scripts() {

			$this->dtdr_register_dependent_files();

			$current_screen = get_current_screen();
			if($current_screen->id == 'comment') {

				// CSS
				wp_enqueue_style ( 'dtdr-comments-backend' );

				// JS
				wp_enqueue_script ( 'dtdr-fields' );

				wp_enqueue_script ( 'dtdr-common' );
				wp_enqueue_script ( 'dtdr-backend' );

				wp_enqueue_script ( 'dtdr-comments-common' );

			}

		}

		function dtdr_enqueue_scripts() {
			$this->dtdr_register_dependent_files();
			$this->dtdr_enqueue_registered_files();
		}

		function dtdr_register_dependent_files() {

			wp_register_style ( 'dtdr-comments-backend', DTDR_COMMENTS_PLUGIN_URL . 'assets/comments-backend.css', array ( 'fontawesome', 'material-icon', 'chosen', 'dtdr-fields', 'dtdr-backend', 'dtdr-common' ) );
			wp_register_style ( 'dtdr-comments-frontend', DTDR_COMMENTS_PLUGIN_URL . 'assets/comments-frontend.css', array ( 'fontawesome', 'icon-moon', 'material-icon', 'dtdr-base', 'dtdr-common', 'dtdr-modules-singlepage' ) );

			wp_register_script ( 'dtdr-comments-common', DTDR_COMMENTS_PLUGIN_URL . 'assets/common.js', array ( 'jquery' ), false, true );
			wp_register_script ( 'dtdr-comments-frontend', DTDR_COMMENTS_PLUGIN_URL . 'assets/frontend.js', array ( 'jquery', 'dtdr-modules-singlepage' ), false, true );

		}

		function dtdr_enqueue_registered_files() {

			wp_enqueue_style ( 'dtdr-comments-frontend' );

			wp_enqueue_script ( 'dtdr-comments-common' );
			wp_enqueue_script ( 'dtdr-comments-frontend' );

		}

	}

}

if( !function_exists('dtdrCommentsModule') ) {
	function dtdrCommentsModule() {
		return DTDirectoryLiteRegisterCommentsModule::instance();
	}
}

dtdrCommentsModule();

?>