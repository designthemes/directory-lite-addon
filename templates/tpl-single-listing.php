<?php
/*
 * Template Name: Directory Listings Single Page Template
 */
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

					the_content();

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