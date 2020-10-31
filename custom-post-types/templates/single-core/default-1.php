<?php
$listing_id = get_the_ID();
?>

<div class="dtdr-single-header-area">
    <div class="dtdr-column dtdr-one-half first dtdr-image-area">
        <?php echo do_shortcode('[dtdr_sp_media_images show_image_description="true" include_featured_image="true" carousel_slidesperview="1" carousel_loopmode="false" carousel_mousewheelcontrol="false" carousel_verticaldirection="false" carousel_arrowpagination="true" listing_id="'.$listing_id.'"]'); ?>
    </div>
    <div class="dtdr-column dtdr-one-half dtdr-content-area">

        <div class="dtdr-column dtdr-one-column first">
            <?php echo do_shortcode('[dtdr_sp_utils show_title="true" listing_id="'.$listing_id.'"]'); ?>
            <?php echo do_shortcode('[dtdr_sp_contact_details type="type1" include_address="true" show_direction_link="false" listing_id="'.$listing_id.'"]'); ?>
            <span class="dtdr-empty-space-10"> </span>
        </div>
        <div class="dtdr-column dtdr-one-column first">
            <?php echo do_shortcode('[dtdr_sp_average_rating listing_id="'.$listing_id.'" type="type2"]'); ?>
            <span class="dtdr-empty-space-25"> </span>
            <p><?php echo get_the_excerpt($listing_id); ?></p>
            <span class="dtdr-empty-space-15"> </span>
        </div>
        <div class="dtdr-column dtdr-one-column first">
            <?php echo do_shortcode('[dtdr_sp_utils show_favourite="true" show_socialshare="true" show_print="true" listing_id="'.$listing_id.'"]'); ?>
            <?php echo do_shortcode('[dtdr_sp_price type="type1" listing_id="'.$listing_id.'"]'); ?>
            <span class="dtdr-empty-space-25"> </span>
            <?php echo do_shortcode('[dtdr_sp_add_to_cart listing_id="'.$listing_id.'"]'); ?>
            <span class="dtdr-empty-space-25"> </span>
        </div>    
    </div>
</div>
<div class="dtdr-column dtdr-one-column first">
    <?php echo get_the_content(); ?>
</div>
<span class="dtdr-empty-space-35"> </span>
<div class="dtdr-column dtdr-one-column first">
    <?php echo do_shortcode('[dtdr_sp_featured_comments enable_title="true" enable_rating="true" enable_media="true" listing_id="'.$listing_id.'"]'); ?>
</div>