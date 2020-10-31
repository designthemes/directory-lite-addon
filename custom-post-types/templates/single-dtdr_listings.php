<?php

// Package expiration check

$author_id = get_post_field( 'post_author', $post->ID );
$user_id = get_current_user_id();

if($author_id != $user_id) {

	$status = get_post_status($post->ID);

	if(!is_user_logged_in()) {

		if($status != 'publish') {

			wp_redirect(home_url());
			exit;

		}

	} else {

		if(!current_user_can('administrator')) {

			if($status != 'publish') {

				wp_redirect(home_url());
				exit;

			}

		}

	}

}

?>

<?php get_header('dtdr'); ?>

	<?php
	/**
	* dtdr_before_main_content hook.
	*/
	do_action( 'dtdr_before_main_content' );
	?>

		<?php
		/**
		* dtdr_before_content hook.
		*/
		do_action( 'dtdr_before_content' );
		?>

			<?php

			if( have_posts() ):
				while( have_posts() ):
				the_post();

					$listing_id = get_the_ID();
					$listing_title = get_the_title();
					$listing_permalink = get_permalink();

					$current_user = wp_get_current_user();
					$user_id = $current_user->ID;

					$author_id = get_the_author_meta('ID');

					dtdr_listing_page_view_counter_overall_update($listing_id, $user_id);

					$dtdr_page_template = get_post_meta($listing_id, 'dtdr_page_template', true);
					$dtdr_page_template = ($dtdr_page_template != '') ? $dtdr_page_template : 'admin-option';

					if($dtdr_page_template == 'admin-option') {
						$dtdr_page_template = dtdr_option('general','single-page-template');
					}

					if($dtdr_page_template == 'custom-template') {
						the_content();
					} else if($dtdr_page_template == 'default-template-1') {
						require_once DTDR_LITE_PLUGIN_PATH . 'custom-post-types/templates/single-core/default-1.php';
					} else {

						if(class_exists( '\Elementor\Plugin' ) && \Elementor\Plugin::$instance->db->is_built_with_elementor($dtdr_page_template)) {

							echo \Elementor\Plugin::$instance->frontend->get_builder_content( $dtdr_page_template );

						} else {

							$single_tpl_content = get_post_field('post_content', $dtdr_page_template);
							echo do_shortcode($single_tpl_content);

						}

					}

				endwhile;
			endif;
			?>

		<?php
		/**
		* dtdr_after_content hook.
		*/
		do_action( 'dtdr_after_content' );
		?>

	<?php
	/**
	* dtdr_after_main_content hook.
	*/
	do_action( 'dtdr_after_main_content' );
	?>

<?php get_footer('dtdr'); ?>