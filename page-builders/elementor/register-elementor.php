<?php

namespace DTElementor\widgets;

if (! class_exists ( 'DTDirectoryLiteElementor' )) {

	class DTDirectoryLiteElementor {

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

		/**
		 * Constructor
		 */
		function __construct() {

			add_action( 'elementor/elements/categories_registered', array( $this, 'dtdr_register_category' ) );

			add_action( 'elementor/widgets/widgets_registered', array( $this, 'dtdr_register_widgets' ) );

			add_action( 'elementor/frontend/after_register_styles', array( $this, 'dtdr_register_widget_styles' ) );
			add_action( 'elementor/frontend/after_register_scripts', array( $this, 'dtdr_register_widget_scripts' ) );

			add_action( 'elementor/preview/enqueue_styles', array( $this, 'dtdr_preview_styles') );

		}

		/**
		 * Register category
		 * Add plugin category in elementor
		 */
		public function dtdr_register_category( $elements_manager ) {

			$elements_manager->add_category(
				'dtdr-default-widgets',array(
					'title' => DTDR_PB_MODULE_DEFAULT_TITLE,
					'icon'  => 'font'
				)
			);

			$elements_manager->add_category(
				'dtdr-singlepage-widgets',array(
					'title' => DTDR_PB_MODULE_SINGLEPAGE_TITLE,
					'icon'  => 'font'
				)
			);

			$dtdr_modules = dtdirectorylite_instance()->active_modules;
			if(is_array($dtdr_modules) && !empty($dtdr_modules)) {
				if(in_array('search', $dtdr_modules)) {
					$elements_manager->add_category(
						'dtdr-searchform-widgets',array(
							'title' => DTDR_PB_MODULE_SEARCHFORM_TITLE,
							'icon'  => 'font'
						)
					);
				}
			}

		}

		/**
		 * Parse Attributes
		 * Parse shortcode attributes
		 */
		public function dtdr_parse_shortcode_attrs( $attrs ) {

			$keys_to_filter = array ( 'animation_duration', 'hide_desktop', 'hide_tablet', 'hide_mobile' );

			$attrs_str = '';
			if(is_array($attrs) && !empty($attrs)) {
				foreach($attrs as $attr_key => $attr) {
					$first_character = substr($attr_key, 0, 1);
					if($first_character != '_' && !in_array($attr_key, $keys_to_filter)) {
						$attrs_str .= $attr_key.'="'.$attr.'" ';
					}
				}
			}

			return $attrs_str;

		}

		/**
		 * Register widgets
		 */
		public function dtdr_register_widgets( $widgets_manager ) {

			$elementor_modules_path = DTDR_LITE_PLUGIN_PATH . 'page-builders/elementor/widgets/';

			# Default Modules

				require $elementor_modules_path . 'default/class-login-logout-links.php';
				$widgets_manager->register_widget_type( new DTDirectoryLiteDfLoginLogoutLinks() );

				require $elementor_modules_path . 'default/class-listings-listing.php';
				$widgets_manager->register_widget_type( new DTDirectoryLiteDfListingsListing() );

				require $elementor_modules_path . 'default/class-listings-taxonomy.php';
				$widgets_manager->register_widget_type( new DTDirectoryLiteDfListingsTaxonomy() );

			# Listing Single Page Modules

				require $elementor_modules_path . 'single-page/featured-image.php';
				$widgets_manager->register_widget_type( new DTDirectoryLiteSpFeaturedImage() );

				require $elementor_modules_path . 'single-page/featured-item.php';
				$widgets_manager->register_widget_type( new DTDirectoryLiteSpFeaturedItem() );

				require $elementor_modules_path . 'single-page/features.php';
				$widgets_manager->register_widget_type( new DTDirectoryLiteSpFeatures() );

				require $elementor_modules_path . 'single-page/contact-details.php';
				$widgets_manager->register_widget_type( new DTDirectoryLiteSpContactDetails() );

				require $elementor_modules_path . 'single-page/contact-details-request.php';
				$widgets_manager->register_widget_type( new DTDirectoryLiteSpContactDetailsRequest() );

				require $elementor_modules_path . 'single-page/social-links.php';
				$widgets_manager->register_widget_type( new DTDirectoryLiteSpSocialLinks() );

				require $elementor_modules_path . 'single-page/comments.php';
				$widgets_manager->register_widget_type( new DTDirectoryLiteSpComments() );

				require $elementor_modules_path . 'single-page/utils.php';
				$widgets_manager->register_widget_type( new DTDirectoryLiteSpUtils() );

				require $elementor_modules_path . 'single-page/taxonomy.php';
				$widgets_manager->register_widget_type( new DTDirectoryLiteSpTaxonomy() );

				require $elementor_modules_path . 'single-page/contact-form.php';
				$widgets_manager->register_widget_type( new DTDirectoryLiteSpContactForm() );

				require $elementor_modules_path . 'single-page/post-date.php';
				$widgets_manager->register_widget_type( new DTDirectoryLiteSpPostDate() );

				require $elementor_modules_path . 'single-page/mls-number.php';
				$widgets_manager->register_widget_type( new DTDirectoryLiteSpMlsNumber() );


			# Load Modules Elementor widgets

				$dtdr_modules = dtdirectorylite_instance()->active_modules;
				if(is_array($dtdr_modules) && !empty($dtdr_modules)) {
					$search_module_exists = false;
					if(in_array('search', $dtdr_modules)) {
						$search_module_exists = true;
					}
					foreach($dtdr_modules as $dtdr_module) {

						$module_epb_path = DTDR_LITE_PLUGIN_MODULE_PATH . '/'.$dtdr_module.'/page-builders/elementor/';
						$pb_files = glob($module_epb_path.'*.php');

						if(is_array($pb_files) && !empty($pb_files)) {
							foreach($pb_files as $pb_file) {

								$file_base_name = basename($pb_file, '.php');
								$file_base_name = explode('-', $file_base_name);

								if(($file_base_name[0] == 'sf' && $search_module_exists) || ($file_base_name[0] != 'sf')) {

									require $pb_file;

									$class_name = implode('', array_map("ucfirst", $file_base_name));
									$class_name =  'DTElementor\Widgets\DTDirectoryLite'.$class_name;

									$widgets_manager->register_widget_type( new $class_name() );

								}

							}
						}

					}
				}


		}

		/**
		 * Register widgets styles
		 */
		public function dtdr_register_widget_styles() {

			dtdr_dependent_files_instance()->dtdr_register_css_files();

		}


		/**
		 * Register widgets scripts
		 */
		public function dtdr_register_widget_scripts() {

			dtdr_dependent_files_instance()->dtdr_register_js_files();

			# Load Modules Dependent Scripts

				$dtdr_modules = dtdirectorylite_instance()->active_modules;
				if(is_array($dtdr_modules) && !empty($dtdr_modules)) {
					foreach($dtdr_modules as $dtdr_module) {
						$dtdr_module = explode('-', $dtdr_module);
						$dtdr_module = implode('', array_map("ucfirst", $dtdr_module));
						$moduleInstance = 'dtdr'.$dtdr_module.'Module';
						if(method_exists($moduleInstance(), 'dtdr_register_dependent_files')) {
							$moduleInstance()->dtdr_register_dependent_files();
						}
					}
				}

		}


		/**
		 * Editor Preview Style
		 */
		public function dtdr_preview_styles() {
		}


	}

}


if( !function_exists('dtdirectorylite_elementor_instance') ) {
	function dtdirectorylite_elementor_instance() {
		return DTDirectoryLiteElementor::instance();
	}
}

dtdirectorylite_elementor_instance();
?>