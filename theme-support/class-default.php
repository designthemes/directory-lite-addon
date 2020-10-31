<?php

if ( ! class_exists( 'DTDirectoryLiteDefault' ) ) {

	class DTDirectoryLiteDefault {

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

			add_action( 'dtdr_before_main_content', array( $this, 'dtdrr_df_before_main_content' ), 10 );
			add_action( 'dtdr_after_main_content', array( $this, 'dtdrr_df_after_main_content' ), 10 );

			add_action( 'dtdr_before_content', array( $this, 'dtdrr_df_before_content' ), 10 );
			add_action( 'dtdr_after_content', array( $this, 'dtdrr_df_after_content' ), 10 );


		}

		function dtdrr_df_before_main_content() {

		}

		function dtdrr_df_after_main_content() {

		}

		function dtdrr_df_before_content() {

			if (is_singular( 'dtdr_listings' ) || is_singular( 'dtdr_packages' ) || is_post_type_archive('dtdr_listings') || is_tax('dtdr_listings_category') || is_tax('dtdr_listings_city') || is_tax('dtdr_listings_neighborhood') || is_tax('dtdr_listings_countystate') || is_tax('dtdr_listings_ctype') || is_tax('dtdr_listings_amenity') || is_post_type_archive('dtdr_packages') || is_author() || is_page_template( 'tpl-single-listing.php' ) || is_page_template( 'tpl-single-incharge.php' ) || is_page_template( 'tpl-single-seller.php' )) {

				echo '<div id="main">';
					echo '<div class="dtdr-container">';

			}

			if(is_page_template( 'tpl-dashboard.php' )) {

				echo '<div id="main">';
					echo '<div class="dtdr-dashboard-container">';

			}

			if(!is_author()) {
				global $post;
				echo '<article id="post-'.$post->ID.'" class="'.implode(' ', get_post_class()).'">';
			}

		}

		function dtdrr_df_after_content() {

			if(!is_author()) {
				echo '</article>';
			}

			if (is_singular( 'dtdr_listings' ) || is_singular( 'dtdr_packages' ) || is_post_type_archive('dtdr_listings') || is_tax('dtdr_listings_category') || is_tax('dtdr_listings_city') || is_tax('dtdr_listings_neighborhood') || is_tax('dtdr_listings_countystate') || is_tax('dtdr_listings_ctype') || is_tax('dtdr_listings_amenity') || is_post_type_archive('dtdr_packages') || is_author() || is_page_template( 'tpl-single-listing.php' ) || is_page_template( 'tpl-single-incharge.php' ) || is_page_template( 'tpl-single-seller.php' )) {

					echo '</div>';
				echo '</div>';

			}

		}

	}

	DTDirectoryLiteDefault::instance();

}

?>