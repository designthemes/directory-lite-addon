<?php
/**
 * Plugin Name: DT Directory Lite Addon
 * Description: A simple wordpress plugin designed to implements <strong>Directory addon features of DesignThemes</strong>
 * Version: 1.0
 * Author: the DesignThemes team
 * Author URI: https://profiles.wordpress.org/designthemes/
 * License: GPL3 or later
 * License URI: https://www.gnu.org/licenses/gpl-3.0.en.html
 * Text Domain: dtdr-lite
 */

if (! class_exists ( 'DTDirectoryLiteAddon' )) {

	class DTDirectoryLiteAddon {

		/**
		 * Instance variable
		 */
		private static $_instance = null;

		/**
		 * Active Modules
		 */
		public $active_modules = array ();

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

		/**
		 * Constructor
		 */
		function __construct() {

			$this->dtdr_setup_constants();
			$this->dtdr_action_hooks();
			$this->dtdr_includes();
			$this->dtdr_load_modules();

			// Theme Support
			$this->dtdr_theme_support_includes();

		}

		/**
		 * Define constant if not already set.
		 */
		public function dtdr_define_constants( $name, $value ) {
			if ( ! defined( $name ) ) {
				define( $name, $value );
			}
		}

		/**
		 * Configure Constants
		 */
		public function dtdr_setup_constants() {

			$this->dtdr_define_constants( 'DTDR_LITE_PLUGIN_PATH', trailingslashit( plugin_dir_path( __FILE__ ) ) );
			$this->dtdr_define_constants( 'DTDR_LITE_PLUGIN_URL', trailingslashit( plugin_dir_url( __FILE__ ) ) );

			$this->dtdr_define_constants( 'DTDR_LITE_PLUGIN_NAME', esc_html__('DesignThemes Directory Lite Addon','dtdr-lite') );
			$this->dtdr_define_constants( 'DTDR_LITE_PLUGIN_MODULE_PATH', DTDR_LITE_PLUGIN_PATH.'modules' );

			$this->dtdr_define_constants( 'DTDR_PB_MODULE_DEFAULT_TITLE', sprintf( esc_html__('%1$s - Default','dtdr-lite'), DTDR_LITE_PLUGIN_NAME ) );
			$this->dtdr_define_constants( 'DTDR_PB_MODULE_SINGLEPAGE_TITLE', sprintf( esc_html__('%1$s - Single Page','dtdr-lite'), DTDR_LITE_PLUGIN_NAME ) );

		}

		/**
		 * Action Hooks
		 */
		public function dtdr_action_hooks() {

			add_action ( 'init', array ( $this, 'dtdr_init' ) );
			add_action ( 'plugins_loaded', array( $this, 'dtdr_plugins_loaded' ) );
			add_filter ( 'theme_page_templates', array ( $this, 'dtdr_add_new_page_template' ) );
			add_filter ( 'template_include', array ( $this, 'dtdr_view_project_template' ) );

			add_action ( 'admin_menu', array ( $this, 'dtdr_configure_admin_menu_first_set' ), 10 );
			add_action ( 'admin_menu', array ( $this, 'dtdr_configure_admin_menu_second_set' ), 30 );
			add_action ( 'parent_file', array ( $this, 'dtdr_change_active_menu' ) );
		}

		/**
		 * On Init
		 */
		function dtdr_init() {

			load_plugin_textdomain ( 'dtdr-lite', false, dirname ( plugin_basename ( __FILE__ ) ) . '/languages/' );

			// Register Dependent Styles & Scripts
				require_once DTDR_LITE_PLUGIN_PATH . 'script-and-styles.php';

			// WooCommerce Payment Functionality
				if ( class_exists( 'WooCommerce' ) ) {
					require_once DTDR_LITE_PLUGIN_PATH . 'woocommerce/woocommerce.php';
				}

		}

		/**
		 * Plugins Load
		 */
		function dtdr_plugins_loaded() {

			// Page Builders
				if( class_exists( 'Vc_Manager' ) || did_action( 'elementor/loaded' ) ) {

					// Scan and Include all available page builders
					if(is_dir(DTDR_LITE_PLUGIN_PATH . 'page-builders')) {

						$dtdr_page_builders = scandir(DTDR_LITE_PLUGIN_PATH . 'page-builders');
						$dtdr_page_builders = array_diff($dtdr_page_builders, array('..', '.'));

						if( class_exists( 'Vc_Manager' ) && in_array( 'visual-composer', $dtdr_page_builders ) ) {
							require_once  DTDR_LITE_PLUGIN_PATH . 'page-builders/visual-composer/register-visual-composer.php';
						}

						if ( did_action( 'elementor/loaded' ) && in_array( 'elementor', $dtdr_page_builders ) ) {
							require_once DTDR_LITE_PLUGIN_PATH . 'page-builders/elementor/register-elementor.php';
						}

					}

				} else {
					add_action ('admin_notices', array( $this, 'dtdr_pb_plugin_notice' ) );
					return;
				}

		}

		function dtdr_pb_plugin_notice() {

			echo '<div class="updated notice is-dismissible">';
				echo '<p>';
					echo sprintf(esc_html__('%1$s requires %2$s or %3$s plugin to be installed and activated on your site','dtdr-lite'), '<strong>'.esc_html( DTDR_LITE_PLUGIN_NAME ).'</strong>', '<strong><a href="https://codecanyon.net/item/visual-composer-page-builder-for-wordpress/242431" target="_blank">'.esc_html__('Visual Composer','dtdr-lite').'</a></strong>', '<strong><a href="https://wordpress.org/plugins/elementor/" target="_blank">'.esc_html__('Elementor Page Builder','dtdr-lite').'</a></strong>' );
				echo '</p>';
				echo '<button type="button" class="notice-dismiss">';
					echo '<span class="screen-reader-text">'.esc_html__('Dismiss this notice.','dtdr-lite').'</span>';
				echo '</button>';
			echo '</div>';

		}


		/**
		 * Add Custom Templates to page template array
		 */
		function dtdr_add_new_page_template( $templates ) {

			$templates = array_merge (
				$templates,
				array (
					'tpl-single-listing.php'  => esc_html__('Directory Listings Single Page Template','dtdr-lite'),
				)
			);

			return $templates;

		}

		/**
		 * Include Custom Templates page from plugin
		 */
		function dtdr_view_project_template( $template ) {

			if( is_singular('page') ) {

				global $post;
				$id = $post->ID;
				$file = get_post_meta( $post->ID, '_wp_page_template', true );

				if( 'tpl-single-listing.php' == $file ) {
					if( ! file_exists( get_stylesheet_directory() . '/tpl-single-listing.php' ) ) {
						$template = DTDR_LITE_PLUGIN_PATH . 'templates/tpl-single-listing.php';
					}
				}

			}

			return $template;

		}

		/**
		 * Configure admin menu - First Set
		 */
		function dtdr_configure_admin_menu_first_set() {

			$listing_singular_label = apply_filters( 'listing_label', 'singular' );
			$listing_plural_label   = apply_filters( 'listing_label', 'plural' );
			$category_title         = sprintf( esc_html__('%1$s Category','dtdr-lite'), $listing_singular_label );

			add_menu_page( sprintf( esc_html__('Directory %1$s','dtdr-lite'), $listing_plural_label ), esc_html__('Directory','dtdr-lite'), 'edit_posts', 'edit.php?post_type=dtdr_listings', '', 'dashicons-index-card', 6 );
			add_submenu_page( 'edit.php?post_type=dtdr_listings', $category_title, $category_title, 'edit_posts', 'edit-tags.php?taxonomy=dtdr_listings_category&post_type=dtdr_listings' );
		}

		/**
		 * Configure admin menu - Second Set
		 */
		function dtdr_configure_admin_menu_second_set() {

			$listing_singular_label = apply_filters( 'listing_label', 'singular' );
			$amenity_singular_label = apply_filters( 'amenity_label', 'singular' );
			$contracttype_singular_label = apply_filters( 'contracttype_label', 'singular' );

			$category_title = sprintf( esc_html__('%1$s Category','dtdr-lite'), $listing_singular_label );
			$amenity_title = sprintf( esc_html__('%1$s %2$s','dtdr-lite'), $listing_singular_label, $amenity_singular_label );
			$contracttype_title = sprintf( esc_html__('%1$s %2$s','dtdr-lite'), $listing_singular_label, $contracttype_singular_label );

			add_submenu_page( 'edit.php?post_type=dtdr_listings', $contracttype_title, $contracttype_title, 'edit_posts', 'edit-tags.php?taxonomy=dtdr_listings_ctype&post_type=dtdr_listings' );
			add_submenu_page( 'edit.php?post_type=dtdr_listings', $amenity_title, $amenity_title, 'edit_posts', 'edit-tags.php?taxonomy=dtdr_listings_amenity&post_type=dtdr_listings' );
			add_submenu_page( 'edit.php?post_type=dtdr_listings', 'Settings', 'Settings', 'edit_posts', 'dtdr-settings-options', 'dtdr_settings_options' );
		}

		/**
		 * Update admin menu
		 */
		function dtdr_change_active_menu($parent_file) {

			global $submenu_file, $current_screen;
			$taxonomy = $current_screen->taxonomy;
			if ($taxonomy == 'dtdr_listings_category') {
				$submenu_file = 'edit-tags.php?taxonomy=dtdr_listings_category&post_type=dtdr_listings';
				$parent_file = 'edit.php?post_type=dtdr_listings';
			} else if ($taxonomy == 'dtdr_listings_ctype') {
				$submenu_file = 'edit-tags.php?taxonomy=dtdr_listings_ctype&post_type=dtdr_listings';
				$parent_file = 'edit.php?post_type=dtdr_listings';
			} else if ($taxonomy == 'dtdr_listings_amenity') {
				$submenu_file = 'edit-tags.php?taxonomy=dtdr_listings_amenity&post_type=dtdr_listings';
				$parent_file = 'edit.php?post_type=dtdr_listings';
			}
			return $parent_file;

		}

		/**
		 * Action Hooks
		 */
		public function dtdr_includes() {

			// Register Custom Post Types
			require_once DTDR_LITE_PLUGIN_PATH . 'custom-post-types/register-post-types.php';

			// Register Shortcodes
			require_once DTDR_LITE_PLUGIN_PATH . 'shortcodes/shortcodes-default.php';
			require_once DTDR_LITE_PLUGIN_PATH . 'shortcodes/shortcodes-singlepage.php';

			// Util files
			require_once DTDR_LITE_PLUGIN_PATH . 'utils/utils-admin.php';
			require_once DTDR_LITE_PLUGIN_PATH . 'utils/utils.php';
			require_once DTDR_LITE_PLUGIN_PATH . 'utils/utils-comment.php';
			require_once DTDR_LITE_PLUGIN_PATH . 'utils/utils-listings.php';
			require_once DTDR_LITE_PLUGIN_PATH . 'utils/utils-login-form.php';
			require_once DTDR_LITE_PLUGIN_PATH . 'utils/utils-events.php';
			require_once DTDR_LITE_PLUGIN_PATH . 'utils/utils-fields.php';

			// Settings
			require_once DTDR_LITE_PLUGIN_PATH . 'settings/settings.php';

		}

		/**
		 * Scan & Include Active Modules
		 */
		function dtdr_load_modules() {

			if(is_dir(DTDR_LITE_PLUGIN_MODULE_PATH)) {
				$dtdr_modules = scandir(DTDR_LITE_PLUGIN_MODULE_PATH);
				$dtdr_modules = array_diff($dtdr_modules, array('..', '.'));
				if(is_array($dtdr_modules) && !empty($dtdr_modules)) {
					rsort($dtdr_modules); // To extend search module class in elementor
					$this->active_modules = $dtdr_modules;
					foreach($dtdr_modules as $dtdr_module) {
						$module_path = DTDR_LITE_PLUGIN_MODULE_PATH . '/'.$dtdr_module.'/register-module.php';
						if(file_exists($module_path)) {
							require_once $module_path;
						}
					}
				}
			}

		}

		/**
		 * Theme support files include
		 */
		function dtdr_theme_support_includes() {
			switch ( get_template() ) {
				case 'elementor-fw':
					include_once DTDR_LITE_PLUGIN_PATH . 'theme-support/class-designthemes.php';
				break;
				case 'houzy':
					include_once DTDR_LITE_PLUGIN_PATH . 'theme-support/class-designthemes-houzy.php';
				break;
				default:
					include_once DTDR_LITE_PLUGIN_PATH . 'theme-support/class-default.php';
				break;
			}
		}

	}

}


if( !function_exists('dtdirectorylite_instance') ) {
	function dtdirectorylite_instance() {
		return DTDirectoryLiteAddon::instance();
	}
}

dtdirectorylite_instance();