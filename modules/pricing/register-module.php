<?php

if (!class_exists ( 'DTDirectoryLiteRegisterPricingModule' )) {

	class DTDirectoryLiteRegisterPricingModule extends DTDirectoryLiteAddon {

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

			$this->dtdr_define_constants( 'DTDR_PRICING_PLUGIN_PATH', DTDR_LITE_PLUGIN_PATH . 'modules/pricing/' );
			$this->dtdr_define_constants( 'DTDR_PRICING_PLUGIN_URL', DTDR_LITE_PLUGIN_URL . 'modules/pricing/' );

			add_filter ( 'dtdr_woo_purchase_cpt', array ( $this, 'dtdr_woo_purchase_cpt_update' ), 10, 1 );

			add_filter ( 'dtdr_metabox_tabs', array ( $this, 'dtdr_metabox_tabs_tab' ) );
			add_filter ( 'dtdr_settings', array ( $this, 'dtdr_add_settings' ) );

			add_action ( 'wp_enqueue_scripts', array ( $this, 'dtdr_enqueue_scripts' ), 130 );

			add_action ( 'dtdr_addorupdate_listing_module', array ( $this, 'dtdr_addorupdate_listing_pricing_module' ), 10, 2 );

			require_once DTDR_PRICING_PLUGIN_PATH . 'shortcodes.php';
			require_once DTDR_PRICING_PLUGIN_PATH . 'dashboard.php';
			require_once DTDR_PRICING_PLUGIN_PATH . 'utils.php';
			require_once DTDR_PRICING_PLUGIN_PATH . 'utils-woocommerce.php';

		}

		function dtdr_woo_purchase_cpt_update($cpt) {

			array_push($cpt, 'dtdr_listings');

			return $cpt;

		}

		function dtdr_metabox_tabs_tab($tabs) {

			$tabs['price'] = array (
				'label' => esc_html__('Price','dtdr-lite'),
				'icon' => 'far fa-money-bill-alt',
				'path' => DTDR_PRICING_PLUGIN_PATH . 'metabox-tab-price.php'
			);

			return $tabs;

		}

		function dtdr_add_settings($tabs) {

			$tabs['price'] = array (
				'label' => esc_html__('Price','dtdr-lite'),
				'path'  => DTDR_PRICING_PLUGIN_PATH . 'settings.php'
			);

			return $tabs;

		}

		function dtdr_enqueue_scripts() {

			$this->dtdr_register_dependent_files();
			$this->dtdr_enqueue_registered_files();

		}

		function dtdr_register_dependent_files() {

			// CSS
			wp_register_style ( 'dtdr-pricing-frontend', DTDR_PRICING_PLUGIN_URL . 'assets/pricing-frontend.css', array ( 'fontawesome', 'icon-moon', 'material-icon', 'dtdr-base', 'dtdr-common' ) );
			wp_register_style ( 'dtdr-pricing-search', DTDR_PRICING_PLUGIN_URL . 'assets/pricing-search.css', array ( 'dtdr-search-frontend' ) );

			// JS
			wp_register_script ( 'dtdr-pricing-search', DTDR_PRICING_PLUGIN_URL . 'assets/search.js', array ('dtdr-search-frontend'), false, true );

		}

		function dtdr_enqueue_registered_files() {

			wp_enqueue_style ( 'jquery-ui' );
			wp_enqueue_style ( 'dtdr-pricing-frontend' );
			wp_enqueue_style ( 'dtdr-pricing-search' );

			wp_enqueue_script ( 'jquery-ui-slider' );
			wp_enqueue_script ( 'dtdr-pricing-search' );
		}

		function dtdr_addorupdate_listing_pricing_module($data, $listing_id) {

			extract($data);

			update_post_meta($listing_id, 'dtdr_currency_symbol', $dtdr_currency_symbol);
			update_post_meta($listing_id, 'dtdr_currency_symbol_position', $dtdr_currency_symbol_position);
			update_post_meta($listing_id, '_regular_price', $_regular_price);
			update_post_meta($listing_id, '_sale_price', $_sale_price);
			update_post_meta($listing_id, 'dtdr_before_price_label', $dtdr_before_price_label);
			update_post_meta($listing_id, 'dtdr_after_price_label', $dtdr_after_price_label);
		}

	}

}

if( !function_exists('dtdrPricingModule') ) {
	function dtdrPricingModule() {
		return DTDirectoryLiteRegisterPricingModule::instance();
	}
}

dtdrPricingModule();
?>