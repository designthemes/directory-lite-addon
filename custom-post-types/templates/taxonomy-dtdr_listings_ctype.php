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

            $queried_object_id = get_queried_object_id();
            $posts_per_page    = get_option('posts_per_page');

            $archive_page_type                   = !empty( dtdr_option('archives','archive-page-type') ) ? dtdr_option('archives','archive-page-type') : 'type1';
            $archive_page_gallery                = !empty( dtdr_option('archives','archive-page-gallery') ) ? dtdr_option('archives','archive-page-gallery') : 'featured_image';
            $archive_page_column                 = dtdr_option('archives','archive-page-column');
            $archive_page_apply_isotope          = dtdr_option('archives','archive-page-apply-isotope');
            $archive_page_excerpt_length         = dtdr_option('archives','archive-page-excerpt-length');
            $archive_page_features_image_or_icon = dtdr_option('archives','archive-page-features-image-or-icon');
            $archive_page_features_include       = dtdr_option('archives','archive-page-features-include');
            $archive_page_noofcat_to_display     = dtdr_option('archives','archive-page-noofcat-to-display');

            echo do_shortcode('[dtdr_listings_listing type="'.$archive_page_type.'" gallery="'.$archive_page_gallery.'" post_per_page="'.$posts_per_page.'" columns="'.$archive_page_column.'" apply_isotope="'.$archive_page_apply_isotope.'" excerpt_length="'.$archive_page_excerpt_length.'" features_image_or_icon="'.$archive_page_features_image_or_icon.'" features_include="'.$archive_page_features_include.'" no_of_cat_to_display="'.$archive_page_noofcat_to_display.'" contracttypes_ids="'.$queried_object_id.'" enable_carousel="false"]');

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