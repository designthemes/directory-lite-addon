<?php

if( !class_exists('DTDirectoryLiteCommentsPostType') ) {

	class DTDirectoryLiteCommentsPostType {

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

			add_action ( 'init', array ( $this, 'dtdr_init' ) );
			add_action ( 'admin_init', array ( $this, 'dtdr_admin_init' ) );
		}

		function dtdr_init() {

			$this->createPostType();
			add_action ( 'save_post', array ( $this, 'dtdr_save_post_meta' ) );
		}

		function createPostType() {

			$labels = array (
				'name'               => esc_html__('Comments','dtdr-lite'),
				'all_items'          => esc_html__('All Comments','dtdr-lite'),
				'singular_name'      => esc_html__('Comment','dtdr-lite'),
				'add_new'            => esc_html__('Add New','dtdr-lite'),
				'add_new_item'       => esc_html__('Add New Comment','dtdr-lite'),
				'edit_item'          => esc_html__('Edit Comment','dtdr-lite'),
				'new_item'           => esc_html__('New Comment','dtdr-lite'),
				'view_item'          => esc_html__('View Comment','dtdr-lite'),
				'search_items'       => esc_html__('Search Comments','dtdr-lite'),
				'not_found'          => esc_html__('No Comments found','dtdr-lite'),
				'not_found_in_trash' => esc_html__('No Comments found in Trash','dtdr-lite'),
				'parent_item_colon'  => esc_html__('Parent Comment:','dtdr-lite'),
				'menu_name'          => esc_html__('Comments','dtdr-lite')
			);

			$args = array (
				'labels'              => $labels,
				'hierarchical'        => true,
				'description'         => esc_html__( 'This is custom post type comments','dtdr-lite'),
				'supports'            => array ( 'title' ),
				'public'              => true,
				'show_ui'             => true,
				'show_in_menu'        => 'edit.php?post_type=dtdr_listings',
				'show_in_nav_menus'   => false,
				'publicly_queryable'  => true,
				'exclude_from_search' => false,
				'has_archive'         => true,
				'query_var'           => true,
				'can_export'          => true,
				'capability_type'     => 'post'
			);

			register_post_type ( 'dtdr_comments', $args );

		}

		function dtdr_save_post_meta($post_id) {

			//If calling wp_update_post, unhook this function so it doesn't loop infinitely
			remove_action('save_post', array ( $this, 'dtdr_save_post_meta' ));

			if( key_exists ( '_inline_edit', $_POST )) :
				if ( wp_verify_nonce($_POST['_inline_edit'], 'inlineeditnonce')) return;
			endif;

			if( key_exists( 'dtdr_comments_meta_nonce', $_POST ) ) :
				if ( ! wp_verify_nonce( $_POST['dtdr_comments_meta_nonce'], 'dtdr_comments_nonce') ) return;
			endif;

			if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;

			if (!current_user_can('edit_post', $post_id)) :
				return;
			endif;

			if ( (key_exists('post_type', $_POST)) && ('dtdr_comments' == $_POST['post_type']) ) :

				$dtdr_approved_commenter_id     = sanitize_text_field( $_POST['dtdr_approved_commenter_id'] );
				$dtdr_approved_old_commenter_id = sanitize_text_field( $_POST['dtdr_approved_old_commenter_id'] );

				$dtdr_package_used_listings_updated = sanitize_text_field( $_POST ['dtdr-package-used-listings-updated'] );
				$dtdr_package_used_listings_updated = (isset($dtdr_package_used_listings_updated) && !empty($dtdr_package_used_listings_updated)) ? $dtdr_package_used_listings_updated : array ();

				$dtdr_user_id = sanitize_text_field( $_POST ['dtdr-user-id'] );
				$dtdr_user_id = (isset($dtdr_user_id) && !empty($dtdr_user_id)) ? $dtdr_user_id : array ();

				if( isset( $dtdr_approved_commenter_id ) && $dtdr_approved_commenter_id != '' ) {

					update_post_meta ( $post_id, 'dtdr_approved_commenter_id', $dtdr_approved_commenter_id );
					update_post_meta(sanitize_text_field( $_POST['dtdr_listing_id'] ), 'dtdr_verified_listing', 'true');

					$i = 0;
					if(is_array($dtdr_user_id) && !empty($dtdr_user_id)) {
						foreach($dtdr_user_id as $dtdr_userid) {
							update_user_meta($dtdr_userid, 'dtdr_seller_package_used_listings_count', $dtdr_package_used_listings_updated[$i]);
							$i++;
						}
					}

					$listingPost = array(
						'ID'          => sanitize_text_field( $_POST['dtdr_listing_id'] ),
						'post_author' => $dtdr_approved_commenter_id
					);
					wp_update_post( $listingPost );

				} else {

					delete_post_meta ( $post_id, 'dtdr_approved_commenter_id' );
					delete_post_meta ( sanitize_text_field( $_POST['dtdr_listing_id'] ), 'dtdr_verified_listing' );

					$i = 0;
					if(is_array($dtdr_user_id) && !empty($dtdr_user_id)) {
						foreach($dtdr_user_id as $dtdr_userid) {
							update_user_meta($dtdr_userid, 'dtdr_seller_package_used_listings_count', $dtdr_package_used_listings_updated[$i]);
							$i++;
						}
					}

					$listingPost = array(
						'ID'          => sanitize_text_field( $_POST['dtdr_listing_id'] ),
						'post_author' => 1
					);
					wp_update_post( $listingPost );

				}

			endif;


			// Re-hook this function
			add_action('save_post', array ( $this, 'dtdr_save_post_meta' ));

		}


		function dtdr_admin_init() {
			add_action ( 'add_meta_boxes', array ( $this, 'dtdr_add_comment_default_metabox' ) );
			add_action ( 'dtdr_addorupdate_listing_module', array ( $this, 'dtdr_addorupdate_listing_comments_module' ), 10, 2 );
		}

		function dtdr_add_comment_default_metabox() {
			$listing_singular_label = apply_filters( 'listing_label', 'singular' );
			add_meta_box ( 'dtdr-comment-default-metabox', esc_html__('Comment Options','dtdr-lite'), array ( $this, 'dtdr_comment_default_metabox' ), 'dtdr_comments', 'normal', 'default' );
			add_meta_box ( 'dtdr-listing-verification-metabox', sprintf( esc_html__( '%1$s Verification','dtdr-lite'), $listing_singular_label ), array ( $this, 'dtdr_listing_verification_metabox' ), 'dtdr_listings', 'side', 'default' );
		}

		function dtdr_comment_default_metabox() {
			include_once dtdrCommentsModule()->module_path . 'metabox.php';
		}

		function dtdr_listing_verification_metabox() {
			global $post;
			$listing_id = $post->ID;

			$dtdr_verified_listing = get_post_meta($listing_id, 'dtdr_verified_listing', true);

			$output = '';
			$output .= '<select name="dtdr_verified_listing" class="dtdr-chosen-select">';
				$output .= '<option value="false" '.selected( $dtdr_verified_listing, 'false', false ).'>'.esc_html__('Not Verified','dtdr-lite').'</option>';
				$output .= '<option value="true" '.selected( $dtdr_verified_listing, 'true', false ).'>'.esc_html__('Verified','dtdr-lite').'</option>';
			$output .= '</select>';

			echo $output;

		}

		function dtdr_addorupdate_listing_comments_module($data, $listing_id) {

			extract($data);

			update_post_meta($listing_id, 'dtdr_verified_listing', $dtdr_verified_listing);

		}

	}

	DTDirectoryLiteCommentsPostType::instance();
}