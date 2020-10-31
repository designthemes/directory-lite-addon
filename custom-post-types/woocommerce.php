<?php

if(!class_exists('DTDirectoryLiteWooCommerce')) {

	class DTDirectoryLiteWooCommerce {

		// Custom post types for woocommerce functionality
		private $cpt = array ('dtdr_packages');

		private static $saved_meta_boxes = false;

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

			// Customizing data store
			add_filter( 'woocommerce_data_stores', array( $this, 'dtdr_woocommerce_data_stores' ) );
			require_once DTDR_LITE_PLUGIN_PATH . 'custom-post-types/class/class.WooCommerce_Product_Data_Store.php';


			// To generate woocommerce screen ids
			add_action ( 'woocommerce_screen_ids', array ( $this, 'dtdr_woo_get_screen_ids' ) );

			// To custom post type data to 'product'
			add_action ( 'woocommerce_product_object', array ( $this, 'dtdr_woo_generate_product_object' ) );


			add_action ( 'woocommerce_add_cart_item_data', array( $this, 'dtdr_add_productid_to_cart_item' ), 10, 2 );
			add_action ( 'woocommerce_add_order_item_meta', array( $this, 'dtdr_add_productid_to_order_item_data' ), 50, 2 );


			// To save WooCommerce price
			add_action ( 'save_post', array ( $this, 'dtdr_woo_save_post_meta' ), 1, 2 );
			add_action ( 'pre_post_update', array ( $this, 'dtdr_woo_save_post_meta' ), 1, 2 );

		}

		function dtdr_woocommerce_data_stores ( $stores ) {

			$stores['product'] = 'DT_Product_Data_Store_CPT';
			return $stores;

		}

		function dtdr_woo_get_screen_ids( $screen_ids = array() ) {

			foreach($this->cpt as $cpt_item) {
				$screen_ids[] = $cpt_item;
				$screen_ids[] = 'edit-'.$cpt_item;
			}

			return $screen_ids;

		}

		function dtdr_woo_generate_product_object( $the_product ) {

			$the_product->cpt_post_type = $the_product->post_type;
			$the_product->post_type = 'product';

			return $the_product;

		}

		function dtdr_add_productid_to_cart_item( $cart_item_meta, $product_id ) {

			if( !in_array( get_post_type( $product_id ), $this->cpt) ) {
				return $cart_item_meta;
			}

			$cart_item_meta['product_id'] = $product_id;

			return $cart_item_meta;

		}

		function dtdr_add_productid_to_order_item_data( $item_id, $values ) {

			wc_add_order_item_meta($item_id, 'dtdr_item_id', $values['product_id'] );

		}

		function dtdr_woo_save_post_meta( $post_id, $post ) {

			if ( empty( $post_id ) || empty( $post ) || self::$saved_meta_boxes ) {
				return;
			}

			if ( defined( 'DOING_AUTOSAVE' ) || is_int( wp_is_post_revision( $post ) ) || is_int( wp_is_post_autosave( $post ) ) ) {
				return;
			}

			if ( empty( $_POST['dtdr_woocommerce_meta_nonce'] ) || ! wp_verify_nonce( $_POST['dtdr_woocommerce_meta_nonce'], 'dtdr_woocommerce_nonce' ) ) {
				return;
			}

			if ( empty( $_POST['post_ID'] ) || $_POST['post_ID'] != $post_id ) {
				return;
			}

			if ( ! current_user_can( 'edit_post', $post_id ) ) {
				return;
			}

			self::$saved_meta_boxes = true;

			if ( in_array( $post['post_type'], $this->cpt ) ) {

				do_action( 'woocommerce_process_product_meta', $post_id, $post );

			}

		}

	}

	DTDirectoryLiteWooCommerce::instance();

}
?>