<?php

if( !class_exists('DTDirectoryLiteListingsPostType') ) {

	class DTDirectoryLiteListingsPostType {

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
			add_action ( 'admin_notices', array ( $this, 'dtdr_save_post_admin_notices') );
			add_action ( 'admin_footer-post.php', array ( $this, 'dtdr_update_post_status_edit_screen' ) );
			add_action ( 'admin_footer-edit.php', array ( $this, 'dtdr_update_post_status_list_screen' ) );
			add_filter ( 'display_post_states', array ( $this, 'dtdr_display_status_label' ) );

			add_action ( 'admin_init', array ( $this, 'dtdr_admin_init' ) );
			add_filter ( 'template_include', array ( $this, 'dtdr_template_include'  ) );

		}

		function dtdr_init() {

			$this->createPostType();
			add_action ( 'save_post', array ( $this, 'dtdr_save_post_meta' ) );

			/* Taxomony custom fields */
			require_once DTDR_LITE_PLUGIN_PATH . 'custom-post-types/taxonomy-custom-fields.php';

			// Register expired post status

			register_post_status( 'expired', array (
				'label'                     => _x( 'Expired', 'Post status','dtdr-lite'),
				'public'                    => true,
				'exclude_from_search'       => false,
				'show_in_admin_all_list'    => true,
				'show_in_admin_status_list' => true,
				'label_count'               => _n_noop( 'Expired <span class="count">(%s)</span>', 'Expired <span class="count">(%s)</span>','dtdr-lite'),
			) );

			// Register waiting for approval post status

			register_post_status( 'waitingforapproval', array (
				'label'                     => _x( 'Waiting For Approval', 'Post status','dtdr-lite'),
				'public'                    => true,
				'exclude_from_search'       => false,
				'show_in_admin_all_list'    => true,
				'show_in_admin_status_list' => true,
				'label_count'               => _n_noop( 'Waiting For Approval <span class="count">(%s)</span>', 'Waiting For Approval <span class="count">(%s)</span>','dtdr-lite'),
			) );

		}

		function dtdr_save_post_admin_notices() {

			if(get_option('dtdr_savepost_adminnotices')) {

				$class = 'notice notice-error';
				$message = get_option('dtdr_savepost_adminnotices');

				printf( '<div class="%1$s"><p>%2$s</p></div>', esc_attr( $class ), esc_html( $message ) );

				delete_option('dtdr_savepost_adminnotices');

			}

		}

		function dtdr_update_post_status_edit_screen() {

			global $post;

			$complete = '';
			$label = '';

			if($post->post_type == 'dtdr_listings') {

				if($post->post_status == 'expired') {

					$complete = ' selected="selected"';
					$label = esc_html__('Expired','dtdr-lite');

					echo '
						<script>
						jQuery(document).ready(function($) {
							$("select#post_status").append(\'<option value="expired" '.$complete.'>'.esc_html__('Expired','dtdr-lite').'</option>\');
							$(".misc-pub-section #post-status-display").html(\''.$label.'\');
						});
						</script>
						';

				} else if($post->post_status == 'waitingforapproval') {

					$complete = ' selected="selected"';
					$label = esc_html__('Waiting For Approval','dtdr-lite');

					echo '
						<script>
						jQuery(document).ready(function($) {
							$("select#post_status").append(\'<option value="waitingforapproval" '.$complete.'>'.esc_html__('Waiting For Approval','dtdr-lite').'</option>\');
							$(".misc-pub-section #post-status-display").html(\''.$label.'\');
						});
						</script>
						';

				} else {

					echo '
						<script>
						jQuery(document).ready(function($) {
							$("select#post_status").append(\'<option value="expired">'.esc_html__('Expired','dtdr-lite').'</option>\');
							$("select#post_status").append(\'<option value="waitingforapproval">'.esc_html__('Waiting For Approval','dtdr-lite').'</option>\');
						});
						</script>
						';

				}

			}

		}

		function dtdr_update_post_status_list_screen() {

			global $post;

			$complete = '';
			$label = '';

			if(isset($post)) {

				if($post->post_type == 'dtdr_listings') {

					if($post->post_status == 'expired') {

						echo '
							<script>
							jQuery(document).ready(function($) {
								$("select[name=\"_status\"]").append(\'<option value="expired">'.esc_html__('Expired','dtdr-lite').'</option>\');
							});
							</script>
							';

					} else if($post->post_status == 'waitingforapproval') {

						echo '
							<script>
							jQuery(document).ready(function($) {
								$("select[name=\"_status\"]").append(\'<option value="waitingforapproval">'.esc_html__('Waiting For Approval','dtdr-lite').'</option>\');
							});
							</script>
							';

					} else {

						echo '
							<script>
							jQuery(document).ready(function($) {
								$("select[name=\"_status\"]").append(\'<option value="expired">'.esc_html__('Expired','dtdr-lite').'</option>\');
								$("select[name=\"_status\"]").append(\'<option value="waitingforapproval">'.esc_html__('Waiting For Approval','dtdr-lite').'</option>\');
							});
							</script>
							';

					}

				}

			}

		}

		function dtdr_display_status_label( $statuses ) {

			global $post;

			if(isset($post) && !empty($post)) {
				if( $post->post_status == 'expired' ) {
					return array ('Expired');
				} else if( $post->post_status == 'waitingforapproval' ) {
					return array ('Waiting For Approval');
				}
			}

			return $statuses;

		}

		function createPostType() {

			$listing_slug = trim(dtdr_option('permalink', 'listing-slug'));
			$listing_category_slug = trim(dtdr_option('permalink','listing-category-slug'));
			$listing_contracttype_slug = trim(dtdr_option('permalink','listing-contracttype-slug'));
			$listing_amenity_slug = trim(dtdr_option('permalink','listing-amenity-slug'));

			$listing_singular_label = apply_filters( 'listing_label', 'singular' );
			$listing_plural_label = apply_filters( 'listing_label', 'plural' );

			$amenity_singular_label = apply_filters( 'amenity_label', 'singular' );
			$amenity_plural_label = apply_filters( 'amenity_label', 'plural' );

			$contracttype_singular_label = apply_filters( 'contracttype_label', 'singular' );
			$contracttype_plural_label = apply_filters( 'contracttype_label', 'plural' );

			$labels = array (
					'name' => sprintf( esc_html__('%1$s','dtdr-lite'), $listing_plural_label ),
					'all_items' => sprintf( esc_html__('All %1$s','dtdr-lite'), $listing_plural_label ),
					'singular_name' => sprintf( esc_html__('%1$s','dtdr-lite'), $listing_singular_label ),
					'add_new' => esc_html__( 'Add New','dtdr-lite'),
					'add_new_item' => sprintf( esc_html__('Add New %1$s','dtdr-lite'), $listing_singular_label ),
					'edit_item' => sprintf( esc_html__('Edit %1$s','dtdr-lite'), $listing_singular_label ),
					'new_item' => sprintf( esc_html__('New %1$s','dtdr-lite'), $listing_singular_label ),
					'view_item' => sprintf( esc_html__('View %1$s','dtdr-lite'), $listing_singular_label ),
					'search_items' => sprintf( esc_html__('Search %1$s','dtdr-lite'), $listing_plural_label ),
					'not_found' => sprintf( esc_html__('No %1$s found','dtdr-lite'), $listing_plural_label ),
					'not_found_in_trash' => sprintf( esc_html__('No %1$s found in Trash','dtdr-lite'), $listing_plural_label ),
					'parent_item_colon' => sprintf( esc_html__('Parent %1$s:','dtdr-lite'), $listing_singular_label ),
					'menu_name' => sprintf( esc_html__('%1$s','dtdr-lite'), $listing_plural_label ),
			);

			$args = array (
					'labels' => $labels,
					'hierarchical' => false,
					'description' => sprintf( esc_html__('This is custom post type %1$s','dtdr-lite'), strtolower($listing_plural_label) ),
					'supports' => array (
						'title',
						'editor',
						'excerpt',
						'author',
						'comments',
						'page-attributes',
						'thumbnail',
						'revisions'
					),

					'public' => true,
					'show_ui' => true,
					'show_in_menu' => 'edit.php?post_type=dtdr_listings',
					'show_in_nav_menus' => true,
					'publicly_queryable' => true,
					'exclude_from_search' => false,
					'has_archive' => true,
					'query_var' => true,
					'can_export' => true,
					'rewrite' => array ( 'slug' => $listing_slug, 'hierarchical' => true, 'with_front' => false ),
					'capability_type' => 'post',
					'map_meta_cap'        => true,
					'capabilities'        => array (

						// meta caps (don't assign these to roles)
						'edit_post'              => 'edit_dtdr_listing',
						'read_post'              => 'read_dtdr_listing',
						'delete_post'            => 'delete_dtdr_listing',

						// primitive/meta caps
						'create_posts'           => 'create_dtdr_listings',

						// primitive caps used outside of map_meta_cap()
						'edit_posts'             => 'edit_dtdr_listings',
						'edit_others_posts'      => 'edit_others_dtdr_listings',
						'publish_post'           => 'publish_dtdr_listings',
						'read_private_posts'     => 'read_private_dtdr_listings',

						// primitive caps used inside of map_meta_cap()
						'read'                   => 'read',
						'delete_posts'           => 'delete_dtdr_listings',
						'delete_private_posts'   => 'delete_private_dtdr_listings',
						'delete_published_posts' => 'delete_published_dtdr_listings',
						'delete_others_posts'    => 'delete_others_dtdr_listings',
						'edit_private_posts'     => 'edit_private_dtdr_listings',
						'edit_published_posts'   => 'edit_published_dtdr_listings'
					)

			);

			register_post_type ( 'dtdr_listings', $args );


			register_taxonomy ( 'dtdr_listings_category', array (
						'dtdr_listings'
				), array (
						'hierarchical' => true,
						'labels' => array(
							'name' 					=> sprintf( esc_html__('%1$s Categories','dtdr-lite'), $listing_singular_label ),
							'singular_name' 		=> sprintf( esc_html__('%1$s Category','dtdr-lite'), $listing_singular_label ),
							'search_items'			=> sprintf( esc_html__('Search %1$s Categories','dtdr-lite'), $listing_singular_label ),
							'popular_items'			=> sprintf( esc_html__('Popular %1$s Categories','dtdr-lite'), $listing_singular_label ),
							'all_items'				=> sprintf( esc_html__('All %1$s Categories','dtdr-lite'), $listing_singular_label ),
							'parent_item'			=> sprintf( esc_html__('Parent %1$s Category','dtdr-lite'), $listing_singular_label ),
							'parent_item_colon'		=> sprintf( esc_html__('Parent %1$s Category','dtdr-lite'), $listing_singular_label ),
							'edit_item'				=> sprintf( esc_html__('Edit %1$s Category','dtdr-lite'), $listing_singular_label ),
							'update_item'			=> sprintf( esc_html__('Update %1$s Category','dtdr-lite'), $listing_singular_label ),
							'add_new_item'			=> sprintf( esc_html__('Add New %1$s Category','dtdr-lite'), $listing_singular_label ),
							'new_item_name'			=> sprintf( esc_html__('New %1$s Category','dtdr-lite'), $listing_singular_label ),
							'add_or_remove_items'	=> sprintf( esc_html__('Add or remove','dtdr-lite'), $listing_singular_label ),
							'choose_from_most_used'	=> sprintf( esc_html__('Choose from most used','dtdr-lite'), $listing_singular_label ),
							'menu_name'				=> sprintf( esc_html__('%1$s Categories','dtdr-lite'), $listing_singular_label ),
						),
						'show_admin_column' => true,
						'rewrite' => array( 'slug' => $listing_category_slug, 'hierarchical' => true, 'with_front' => false ),
						'query_var' => true
				)
			);

			register_taxonomy ( 'dtdr_listings_ctype', array (
						'dtdr_listings'
				), array (
						'hierarchical' => true,
						'labels' => array(
							'name' 					=> sprintf( esc_html__('%1$s %2$s','dtdr-lite'), $listing_singular_label, $contracttype_plural_label ),
							'singular_name' 		=> sprintf( esc_html__('%1$s %2$s','dtdr-lite'), $listing_singular_label, $contracttype_singular_label ),
							'search_items'			=> sprintf( esc_html__('Search %1$s %2$s','dtdr-lite'), $listing_singular_label, $contracttype_plural_label ),
							'popular_items'			=> sprintf( esc_html__('Popular %1$s %2$s','dtdr-lite'), $listing_singular_label, $contracttype_plural_label ),
							'all_items'				=> sprintf( esc_html__('All %1$s %2$s','dtdr-lite'), $listing_singular_label, $contracttype_plural_label ),
							'parent_item'			=> sprintf( esc_html__('Parent %1$s %2$s','dtdr-lite'), $listing_singular_label, $contracttype_singular_label ),
							'parent_item_colon'		=> sprintf( esc_html__('Parent %1$s %2$s','dtdr-lite'), $listing_singular_label, $contracttype_singular_label ),
							'edit_item'				=> sprintf( esc_html__('Edit %1$s %2$s','dtdr-lite'), $listing_singular_label, $contracttype_singular_label ),
							'update_item'			=> sprintf( esc_html__('Update %1$s %2$s','dtdr-lite'), $listing_singular_label, $contracttype_singular_label ),
							'add_new_item'			=> sprintf( esc_html__('Add New %1$s %2$s','dtdr-lite'), $listing_singular_label, $contracttype_singular_label ),
							'new_item_name'			=> sprintf( esc_html__('New %1$s %2$s','dtdr-lite'), $listing_singular_label, $contracttype_singular_label ),
							'add_or_remove_items'	=> sprintf( esc_html__('Add or remove','dtdr-lite'), $listing_singular_label, $contracttype_singular_label ),
							'choose_from_most_used'	=> sprintf( esc_html__('Choose from most used','dtdr-lite'), $listing_singular_label, $contracttype_singular_label ),
							'menu_name'				=> sprintf( esc_html__('%1$s %2$s','dtdr-lite'), $listing_singular_label, $contracttype_plural_label ),
						),
						'show_admin_column' => true,
						'rewrite' => array( 'slug' => $listing_contracttype_slug, 'hierarchical' => true, 'with_front' => false ),
						'query_var' => true
				)
			);

			register_taxonomy ( 'dtdr_listings_amenity', array (
						'dtdr_listings'
				), array (
						'hierarchical' => false,
						'labels' => array(
							'name' 					=> sprintf( esc_html__('%1$s %2$s','dtdr-lite'), $listing_singular_label, $amenity_plural_label ),
							'singular_name' 		=> sprintf( esc_html__('%1$s %2$s','dtdr-lite'), $listing_singular_label, $amenity_singular_label ),
							'search_items'			=> sprintf( esc_html__('Search %1$s %2$s','dtdr-lite'), $listing_singular_label, $amenity_plural_label ),
							'popular_items'			=> sprintf( esc_html__('Popular %1$s %2$s','dtdr-lite'), $listing_singular_label, $amenity_plural_label ),
							'all_items'				=> sprintf( esc_html__('All %1$s %2$s','dtdr-lite'), $listing_singular_label, $amenity_plural_label ),
							'parent_item'			=> sprintf( esc_html__('Parent %1$s %2$s','dtdr-lite'), $listing_singular_label, $amenity_singular_label ),
							'parent_item_colon'		=> sprintf( esc_html__('Parent %1$s %2$s','dtdr-lite'), $listing_singular_label, $amenity_singular_label ),
							'edit_item'				=> sprintf( esc_html__('Edit %1$s %2$s','dtdr-lite'), $listing_singular_label, $amenity_singular_label ),
							'update_item'			=> sprintf( esc_html__('Update %1$s %2$s','dtdr-lite'), $listing_singular_label, $amenity_singular_label ),
							'add_new_item'			=> sprintf( esc_html__('Add New %1$s %2$s','dtdr-lite'), $listing_singular_label, $amenity_singular_label ),
							'new_item_name'			=> sprintf( esc_html__('New %1$s %2$s','dtdr-lite'), $listing_singular_label, $amenity_singular_label ),
							'add_or_remove_items'	=> sprintf( esc_html__('Add or remove','dtdr-lite'), $listing_singular_label, $amenity_singular_label ),
							'choose_from_most_used'	=> sprintf( esc_html__('Choose from most used','dtdr-lite'), $listing_singular_label, $amenity_singular_label ),
							'menu_name'				=> sprintf( esc_html__('%1$s %2$s','dtdr-lite'), $listing_singular_label, $amenity_plural_label ),
						),
						'show_admin_column' => true,
						'rewrite' => array( 'slug' => $listing_amenity_slug, 'hierarchical' => true, 'with_front' => false ),
						'query_var' => true
				)
			);

		}

		function dtdr_save_post_meta($post_id) {

			if( key_exists ( '_inline_edit', $_POST )) :
				if ( wp_verify_nonce($_POST['_inline_edit'], 'inlineeditnonce')) return;
			endif;

			if( key_exists( 'dtdr_listings_meta_nonce',$_POST ) ) :
				if ( ! wp_verify_nonce( $_POST['dtdr_listings_meta_nonce'], 'dtdr_listings_nonce' ) ) return;
			endif;

			if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;

			if (!current_user_can('edit_post', $post_id)) :
				return;
			endif;

			if ( (key_exists('post_type', $_POST)) && ('dtdr_listings' == $_POST['post_type']) ) :

				if( isset( $_POST ['dtdr_mls_number'] ) && $_POST ['dtdr_mls_number'] != '') {

					$args = array (
								'posts_per_page' => -1,
								'post_type'      => 'dtdr_listings',
								'meta_query'     => array (),
								'post_status'    => array ( 'any' ),
								'post__not_in'   => array ($post_id)
							);

					$args['meta_query'][] = array (
												'key'     => 'dtdr_mls_number',
												'value'   => $_POST ['dtdr_mls_number'],
												'compare' => 'LIKE',
											);

					$listings_query = new WP_Query( $args );
					$post_count = $listings_query->found_posts;
					wp_reset_postdata();

					if($post_count > 0) {
						add_option( 'dtdr_savepost_adminnotices', esc_html__('MLS Number you have provided is not unique, please try with unique number.','dtdr-lite') );
						return;
					}

				}


				$author_id = get_post_field( 'post_author', $post_id );
				$user_id = get_current_user_id();

				// General

				if( isset( $_POST ['dtdr_page_template'] ) && $_POST ['dtdr_page_template'] != '') {
					update_post_meta ( $post_id, 'dtdr_page_template', sanitize_text_field ( $_POST ['dtdr_page_template'] ) );
				} else {
					delete_post_meta ( $post_id, 'dtdr_page_template' );
				}

				if( isset( $_POST ['dtdr_mls_number'] ) && $_POST ['dtdr_mls_number'] != '') {
					update_post_meta ( $post_id, 'dtdr_mls_number', sanitize_text_field ( $_POST ['dtdr_mls_number'] ) );
				} else {
					delete_post_meta ( $post_id, 'dtdr_mls_number' );
				}

				if( isset( $_POST ['dtdr_incharges'] ) && $_POST ['dtdr_incharges'] != '') {
					update_post_meta ( $post_id, 'dtdr_incharges', sanitize_text_field( $_POST ['dtdr_incharges'] ) );
				} else {
					delete_post_meta ( $post_id, 'dtdr_incharges' );
				}

				if((int)$author_id == (int)$user_id) {

					if( isset( $_POST ['dtdr_featured_item'] ) && $_POST ['dtdr_featured_item'] != '') {
						update_post_meta ( $post_id, 'dtdr_featured_item', sanitize_key ( $_POST ['dtdr_featured_item'] ) );
					} else {
						delete_post_meta ( $post_id, 'dtdr_featured_item' );
					}

				}

				if( isset( $_POST ['dtdr_excerpt_title'] ) && $_POST ['dtdr_excerpt_title'] != '') {
					update_post_meta ( $post_id, 'dtdr_excerpt_title', sanitize_text_field ( $_POST ['dtdr_excerpt_title'] ) );
				} else {
					delete_post_meta ( $post_id, 'dtdr_excerpt_title' );
				}

				// Features

				if( isset( $_POST ['dtdr_features_title'] ) && $_POST ['dtdr_features_title'] != '') {
					update_post_meta ( $post_id, 'dtdr_features_title', sanitize_text_field( $_POST ['dtdr_features_title'] ) );
				} else {
					delete_post_meta ( $post_id, 'dtdr_features_title' );
				}

				if( isset( $_POST ['dtdr_features_subtitle'] ) && $_POST ['dtdr_features_subtitle'] != '') {
					update_post_meta ( $post_id, 'dtdr_features_subtitle', sanitize_text_field( $_POST ['dtdr_features_subtitle'] ) );
				} else {
					delete_post_meta ( $post_id, 'dtdr_features_subtitle' );
				}

				if( isset( $_POST ['dtdr_features_value'] ) && $_POST ['dtdr_features_value'] != '') {
					update_post_meta ( $post_id, 'dtdr_features_value', sanitize_text_field( $_POST ['dtdr_features_value'] ) );
				} else {
					delete_post_meta ( $post_id, 'dtdr_features_value' );
				}

				if( isset( $_POST ['dtdr_features_valueunit'] ) && $_POST ['dtdr_features_valueunit'] != '') {
					update_post_meta ( $post_id, 'dtdr_features_valueunit', sanitize_text_field( $_POST ['dtdr_features_valueunit'] ) );
				} else {
					delete_post_meta ( $post_id, 'dtdr_features_valueunit' );
				}

				if( isset( $_POST ['dtdr_features_icon'] ) && $_POST ['dtdr_features_icon'] != '') {
					update_post_meta ( $post_id, 'dtdr_features_icon', sanitize_text_field( $_POST ['dtdr_features_icon'] ) );
				} else {
					delete_post_meta ( $post_id, 'dtdr_features_icon' );
				}

				if( isset( $_POST ['dtdr_features_image'] ) && $_POST ['dtdr_features_image'] != '') {
					update_post_meta ( $post_id, 'dtdr_features_image', sanitize_text_field( $_POST ['dtdr_features_image'] ) );
				} else {
					delete_post_meta ( $post_id, 'dtdr_features_image' );
				}


				// Contact Information

				if( isset( $_POST ['dtdr_email'] ) && $_POST ['dtdr_email'] != '') {
					update_post_meta ( $post_id, 'dtdr_email', sanitize_email( $_POST ['dtdr_email'] ) );
				} else {
					delete_post_meta ( $post_id, 'dtdr_email' );
				}

				if( isset( $_POST ['dtdr_phone'] ) && $_POST ['dtdr_phone'] != '') {
					update_post_meta ( $post_id, 'dtdr_phone', sanitize_text_field( $_POST ['dtdr_phone'] ) );
				} else {
					delete_post_meta ( $post_id, 'dtdr_phone' );
				}

				if( isset( $_POST ['dtdr_mobile'] ) && $_POST ['dtdr_mobile'] != '') {
					update_post_meta ( $post_id, 'dtdr_mobile', sanitize_text_field( $_POST ['dtdr_mobile'] ) );
				} else {
					delete_post_meta ( $post_id, 'dtdr_mobile' );
				}

				if( isset( $_POST ['dtdr_skype'] ) && $_POST ['dtdr_skype'] != '') {
					update_post_meta ( $post_id, 'dtdr_skype', sanitize_text_field( $_POST ['dtdr_skype'] ) );
				} else {
					delete_post_meta ( $post_id, 'dtdr_skype' );
				}

				if( isset( $_POST ['dtdr_website'] ) && $_POST ['dtdr_website'] != '') {
					update_post_meta ( $post_id, 'dtdr_website', sanitize_text_field( $_POST ['dtdr_website'] ) );
				} else {
					delete_post_meta ( $post_id, 'dtdr_website' );
				}

				if( isset( $_POST ['dtdr_social_items'] ) && $_POST ['dtdr_social_items'] != '') {
					update_post_meta ( $post_id, 'dtdr_social_items', sanitize_text_field( $_POST ['dtdr_social_items'] ) );
				} else {
					delete_post_meta ( $post_id, 'dtdr_social_items' );
				}

				if( isset( $_POST ['dtdr_social_items_value'] ) && $_POST ['dtdr_social_items_value'] != '') {
					update_post_meta ( $post_id, 'dtdr_social_items_value', sanitize_text_field( $_POST ['dtdr_social_items_value'] ) );
				} else {
					delete_post_meta ( $post_id, 'dtdr_social_items_value' );
				}

				// Add or Update listing from modules
				do_action('dtdr_addorupdate_listing_module', $_POST, $post_id);

			endif;

		}

		function dtdr_admin_init() {

			add_action ( 'add_meta_boxes', array ( $this, 'dtdr_add_listing_default_metabox' ) );
			add_filter ( 'manage_dtdr_listings_posts_columns', array ( $this, 'set_custom_edit_dtdr_listings_columns' ) );
			add_action ( 'manage_dtdr_listings_posts_custom_column', array ( $this, 'custom_dtdr_listings_column' ), 10, 2 );

		}

		function dtdr_add_listing_default_metabox() {
			$listing_singular_label = apply_filters( 'listing_label', 'singular' );
			add_meta_box ( 'dtdr-listing-default-metabox', sprintf( esc_html__( '%1$s Options','dtdr-lite'), $listing_singular_label ), array ( $this, 'dtdr_listing_default_metabox' ), 'dtdr_listings', 'normal', 'default' );
		}

		function dtdr_listing_default_metabox() {
			include_once DTDR_LITE_PLUGIN_PATH . 'custom-post-types/metaboxes/listing-default-metabox.php';
		}

		function set_custom_edit_dtdr_listings_columns($columns) {

			$newcolumns = array (
				'cb' => '<input type="checkbox" />',
				'dtdr_listings_thumb' => esc_html__('Image','dtdr-lite'),
				'title' => esc_html__('Title','dtdr-lite'),
				'author' => esc_html__('Author','dtdr-lite'),
				'status' => esc_html__('Status','dtdr-lite')
			);

			$columns = array_merge ( $newcolumns, $columns );

			return $columns;

		}

		function custom_dtdr_listings_column($columns, $id) {

			global $post;

			switch ($columns) {

				case 'dtdr_listings_thumb':
					$image = wp_get_attachment_image(get_post_thumbnail_id($id), array(75,75));
					if(!empty($image)) {
						echo $image;
					} else {
						echo '<img src="http'.dtdr_ssl().'://placehold.it/75x75" alt="'.$id.'" />';
					}
				break;

				case 'status':

					$author_id = get_the_author_meta('ID');

					$current_user = get_userdata($author_id);

					$seller_id = -1;
					$process_seller = false;

					if(in_array('seller', (array) $current_user->roles)) {

						$seller_id = $author_id;
						$process_seller = true;

					} else if(in_array('incharge', (array) $current_user->roles)) {

						$incharge_id = $author_id;

						$user_seller = get_user_meta( $author_id, 'user_seller', true );
						if($user_seller != '' && $user_seller > 0) {

							$seller_id = $user_seller;
							$process_seller = true;

						}

					}

					if($process_seller) {
						if(function_exists('dtdr_check_user_seller_package_is_active') && dtdr_check_user_seller_package_is_active($seller_id, -1)) {
							echo esc_html__('Active','dtdr-lite');
						} else {
							if(isset($post) && !empty($post)) {
								if( $post->post_status == 'expired' ) {
									echo esc_html__('Expired','dtdr-lite');
								} else if( $post->post_status == 'waitingforapproval' ) {
									echo esc_html__('Waiting For Approval','dtdr-lite');
								}
							}
						}
					}

				break;

			}

		}

		function dtdr_template_include($template) {

			if (is_singular( 'dtdr_listings' )) {
				$template = DTDR_LITE_PLUGIN_PATH . 'custom-post-types/templates/single-dtdr_listings.php';
			} elseif (is_tax ( 'dtdr_listings_category' )) {
				$template = DTDR_LITE_PLUGIN_PATH . 'custom-post-types/templates/taxonomy-dtdr_listings_category.php';
			} elseif (is_tax ( 'dtdr_listings_ctype' )) {
				$template = DTDR_LITE_PLUGIN_PATH . 'custom-post-types/templates/taxonomy-dtdr_listings_ctype.php';
			} elseif (is_tax ( 'dtdr_listings_amenity' )) {
				$template = DTDR_LITE_PLUGIN_PATH . 'custom-post-types/templates/taxonomy-dtdr_listings_amenity.php';
			} elseif (is_post_type_archive('dtdr_listings')) {
				$template = DTDR_LITE_PLUGIN_PATH . 'custom-post-types/templates/archive-dtdr_listings.php';
			}

			return $template;

		}

	}

	DTDirectoryLiteListingsPostType::instance();

}
?>