<?php

global $wp_query;
$curauth = $wp_query->get_queried_object();

$user_id = $curauth->ID;

$dtdr_user_status = get_user_meta( $user_id, 'dtdr_user_status', true );
if($dtdr_user_status != 'active') {

    wp_redirect(home_url());
    exit;

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

			$user_meta	= get_userdata($user_id);
			$user_roles	= $user_meta->roles;

			echo '<div class="dtdr-author-details-container">';
				if(in_array('seller', $user_roles)) {
					echo do_shortcode('[dtdr_sellers type="" columns="" include="'.esc_attr($user_id).'" /]');
				} else if(in_array('incharge', $user_roles)) {
					echo do_shortcode('[dtdr_incharges type="" columns="" include="'.esc_attr($user_id).'" /]');
				}
			echo '</div>';


			$seller_singular_label = apply_filters( 'seller_label', 'singular' );
			$incharge_singular_label = apply_filters( 'incharge_label', 'singular' );
			$listing_plural_label = apply_filters( 'listing_label', 'plural' );

			if(in_array('seller', $user_roles)) {

				echo '<div class="dtdr-author-listings-container">';

					echo '<h4>'.sprintf( esc_html__('%1$s %2$s','dtdr-lite'), $seller_singular_label, $listing_plural_label ).'</h4>';

					echo do_shortcode('[dtdr_listings_listing post_per_page="6" columns="3" apply_isotope="true" seller_ids="'.esc_attr($user_id).'" /]');

				echo '</div>';

			} else if(in_array('incharge', $user_roles)) {

				echo '<div class="dtdr-author-listings-container">';

					echo '<h4>'.sprintf( esc_html__('%1$s %2$s','dtdr-lite'), $incharge_singular_label, $listing_plural_label ).'</h4>';

					echo do_shortcode('[dtdr_listings_listing post_per_page="6" columns="3" apply_isotope="true" incharge_ids="'.esc_attr($user_id).'" /]');

				echo '</div>';

			}

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