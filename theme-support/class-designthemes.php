<?php

if ( ! class_exists( 'DTDirectoryLiteDesignThemes' ) ) {

	class DTDirectoryLiteDesignThemes {

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

			add_filter( '_theme_name_header_footer_default_cpt',  array ( $this, 'dtdr_dt_header_footer_default_cpt' ) );

			add_action( 'dtdr_before_main_content',  array ( $this, 'dtdr_dt_before_main_content' ), 10 );
			add_action( 'dtdr_after_main_content',  array ( $this, 'dtdr_dt_after_main_content' ), 10 );

			add_action( 'dtdr_before_content',  array ( $this, 'dtdr_dt_before_content' ), 10 );
			add_action( 'dtdr_after_content',  array ( $this, 'dtdr_dt_after_content' ), 10 );

			add_filter( 'cs_metabox_options',  array ( $this, 'dtdr_cs_metabox_options'), 1 );

		}

		function dtdr_dt_header_footer_default_cpt( $custom_posts ) {

			$custom_posts[] = 'dtdr_listings';
			$custom_posts[] = 'dtdr_packages';

			return $custom_posts;

		}

		function dtdr_dt_before_main_content() {

			if (is_singular( 'dtdr_listings' ) || is_singular( 'dtdr_packages' )) {

				global $post;
				$post_id = $post->ID;

			    $settings = get_post_meta($post_id, 'dtdr_default_settings', true);
			    $settings = is_array ( $settings ) ?  array_filter( $settings )  :  array ();

			    $global_breadcrumb = _theme_name_get_option( 'show-breadcrumb' );

			    $header_class = '';
			    if( !empty( $global_breadcrumb ) ) {
			        if( isset( $settings['enable-sub-title'] ) && $settings['enable-sub-title'] ) {
			            $header_class = isset( $settings['breadcrumb_position'] ) ? $settings['breadcrumb_position'] : '';
					}
				}

				?>

				<div id="header-wrapper" class="<?php echo esc_attr($header_class); ?>">

					<header id="header">
						<div class="container">
							<?php do_action( '_theme_name_header' ); ?>
					    </div>
					</header>

				    <?php
			        if( !empty( $global_breadcrumb ) ) {

						if(empty($settings)) { $settings['enable-sub-title'] = true; }

			            if(isset($settings['enable-sub-title']) && $settings['enable-sub-title']) {

			                $bstyle = _theme_name_get_option( 'breadcrumb-style', 'default' );

			                $breadcrumbs = array ();

			                if( $post->post_parent ) {

			                    $parent_id  = $post->post_parent;
			                    $parents =  array ();

			                    while( $parent_id ) {
			                        $page = get_page( $parent_id );
			                        $parents[] = '<a href="' . esc_url( get_permalink( $page->ID ) ). '">' . esc_html( get_the_title( $page->ID ) ) . '</a>';
			                        $parent_id  = $page->post_parent;
			                    }

			                    $parents = array_reverse( $parents );
			                    $breadcrumbs = array_merge_recursive($breadcrumbs, $parents);

			                }

			                if(is_singular( 'dtdr_listings' )) {
			                	$listing_plural_label = apply_filters( 'listing_label', 'plural' );
			                	$breadcrumbs[] = '<a href="'.esc_url(get_post_type_archive_link('dtdr_listings')).'">'.esc_html( $listing_plural_label ).'</a>';
			                }

			                $breadcrumbs[] = the_title( '<span class="current">', '</span>', false );
			                $bcsettings = isset( $settings['breadcrumb_background'] ) ? $settings['breadcrumb_background'] :  array ();
			                $style = _theme_name_breadcrumb_css($bcsettings);

			                _theme_name_breadcrumb_output ( the_title( '<h1>', '</h1>',false ), $breadcrumbs, $bstyle, $style );

			            }
			        }
				    ?>
				</div>

				<?php

			}

			if(is_post_type_archive('dtdr_listings') || is_tax('dtdr_listings_category') || is_tax('dtdr_listings_city') || is_tax('dtdr_listings_neighborhood') || is_tax('dtdr_listings_countystate') || is_tax('dtdr_listings_ctype') || is_tax('dtdr_listings_amenity') || is_post_type_archive('dtdr_packages') || is_author()) {

				$global_breadcrumb = _theme_name_get_option( 'show-breadcrumb' );
				$header_class	   = _theme_name_get_option( 'breadcrumb-position' );
				?>

				<div id="header-wrapper" class="<?php echo esc_attr($header_class); ?>">

					<header id="header">
						<div class="container">
							<?php do_action( '_theme_name_header' ); ?>
					    </div>
					</header>

				    <?php
				    if( !empty( $global_breadcrumb ) ) {

				    	$bstyle = _theme_name_get_option( 'breadcrumb-style', 'default' );
				    	$style = _theme_name_breadcrumb_css();

				        $title = '<h1>'.get_the_archive_title().'</h1>';
				        $breadcrumbs =  array ();

				        if ( is_category() ) {
				            $breadcrumbs[] = '<a href="'. esc_url( get_category_link( get_query_var('cat') ) ).'">' . single_cat_title('', false) . '</a>';
				        } elseif ( is_tag() ) {
				            $breadcrumbs[] = '<a href="'. esc_url( get_tag_link( get_query_var('tag_id') ) ).'">' . single_tag_title('', false) . '</a>';
				        } elseif( is_author() ) {

				        	$author_id = get_queried_object_id();
				            $breadcrumbs[] = '<a href="'.esc_url( get_the_author_meta( 'user_url', $author_id ) ).'">' . get_the_author_meta('display_name', $author_id) . '</a>';
				            $title = '<h1>'.get_the_author_meta('display_name', $author_id).'</h1>';

				        } elseif( is_day() || is_time() ){
				            $breadcrumbs[] = '<a href="'. esc_url( get_year_link( get_the_time('Y') ) ). '">'. get_the_time('Y') .'</a>';
				            $breadcrumbs[] = '<a href="'. esc_url( get_month_link( get_the_time('Y'), get_the_time('m') ) ).'">'. get_the_time('F') .'</a>';
				            $breadcrumbs[] = '<a href="'. esc_url( get_day_link( get_the_time('Y'), get_the_time('m'), get_the_time('d') ) ).'">'. get_the_time('d') .'</a>';
				        } elseif( is_month() ){
				            $breadcrumbs[] = '<a href="'. esc_url( get_year_link( get_the_time('Y') ) ). '">' . get_the_time('Y') . '</a>';
				            $breadcrumbs[] = '<a href="'. esc_url( get_month_link( get_the_time('Y'), get_the_time('m') ) ).'">'. get_the_time('F') .'</a>';
				        } elseif( is_year() ){
				            $breadcrumbs[] = '<a href="'. esc_url( get_year_link( get_the_time('Y') ) ).'">'. get_the_time('Y') .'</a>';
				        }

				        _theme_name_breadcrumb_output ( $title, $breadcrumbs, $bstyle, $style );

				    }
				    ?>

				</div>

				<?php

			}

			if(is_page_template( 'tpl-dashboard.php' ) || is_page_template( 'tpl-single-listing.php' )) {
				?>

				<div id="header-wrapper">

					<header id="header">
						<div class="container">
							<?php do_action( '_theme_name_header' ); ?>
					    </div>
					</header>

				</div>

				<?php
			}

		}

		function dtdr_dt_after_main_content() {

		}

		function dtdr_dt_before_content() {

			if (is_singular( 'dtdr_listings' ) || is_singular( 'dtdr_packages' ) || is_post_type_archive('dtdr_listings') || is_tax('dtdr_listings_category') || is_tax('dtdr_listings_city') || is_tax('dtdr_listings_neighborhood') || is_tax('dtdr_listings_countystate') || is_tax('dtdr_listings_ctype') || is_tax('dtdr_listings_amenity') || is_post_type_archive('dtdr_packages') || is_author() || is_page_template( 'tpl-single-listing.php' )) {

				echo '<div id="main">';
						echo '<div class="container">';
							echo '<section id="primary" class="content-full-width">';

			}

			if(is_page_template( 'tpl-dashboard.php' )) {

				echo '<div id="main">';
						echo '<div class="dtdr-dashboard-container">';
							echo '<section id="primary" class="content-full-width">';

			}

			if(!is_author()) {
				global $post;
				echo '<article id="post-'.$post->ID.'" class="'.implode(' ', get_post_class()).'">';
			}

		}

		function dtdr_dt_after_content() {

			if(!is_author()) {
				echo '</article>';
			}

			if (is_singular( 'dtdr_listings' ) || is_singular( 'dtdr_packages' ) || is_post_type_archive('dtdr_listings') || is_tax('dtdr_listings_category') || is_tax('dtdr_listings_city') || is_tax('dtdr_listings_neighborhood') || is_tax('dtdr_listings_countystate') || is_tax('dtdr_listings_ctype') || is_tax('dtdr_listings_amenity') || is_post_type_archive('dtdr_packages') || is_author() || is_page_template( 'tpl-single-listing.php' )) {

						echo '</section>';
					echo '</div>';
				echo '</div>';

		    }

		}

		function dtdr_cs_metabox_options( $options ) {

			$meta_breadcrumb_section = array (
				'name'  => 'breadcrumb_section',
				'title' => esc_html__('Breadcrumb', '_text_domain'),
				'icon'  => 'fa fa-arrows-h',
				'fields' =>   array (
					 array (
						'id'      => 'enable-sub-title',
						'type'    => 'switcher',
						'title'   => esc_html__('Show Breadcrumb', '_text_domain' ),
						'default' => true
					),
					 array (
						'id'                 => 'breadcrumb_position',
						'type'               => 'select',
						'title'              => esc_html__('Position', '_text_domain' ),
						'options'            =>  array (
							'header-top-absolute' => esc_html__('Behind the Header','_text_domain'),
							'header-top-relative' => esc_html__('Default','_text_domain'),
						),
						'default'            => 'header-top-relative',
						'dependency'         =>  array ( 'enable-sub-title', '==', 'true' ),
					),
					 array (
						'id'         => 'breadcrumb_background',
						'type'       => 'background',
						'title'      => esc_html__('Background', '_text_domain' ),
						'dependency' =>  array ( 'enable-sub-title', '==', 'true' ),
					),
				)
			);

			$options[] = array (
				'id'        => 'dtdr_default_settings',
				'title'     => esc_html__('Page Settings','dtdr-lite'),
				'post_type' => array ( 'dtdr_listings', 'dtdr_packages' ),
				'context'   => 'normal',
				'priority'  => 'high',
				'sections'  => array (
					$meta_breadcrumb_section
				)
			);

			return $options;

		}

	}

	DTDirectoryLiteDesignThemes::instance();

}

?>