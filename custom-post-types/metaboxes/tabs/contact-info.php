<div class="dtdr-custom-box">

    <label><?php echo esc_html__('Email','dtdr-lite'); ?></label>
    <?php $dtdr_email = get_post_meta($list_id, 'dtdr_email', true); ?>
    <input name="dtdr_email" type="text" value="<?php echo $dtdr_email;?>" />
    <div class="dtdr-note"><?php echo sprintf( esc_html__('Add contact email for your %1$s here.','dtdr-lite'), strtolower($listing_singular_label) ); ?> </div>

</div>

<div class="dtdr-custom-box">

    <label><?php echo esc_html__('Phone','dtdr-lite'); ?></label>
    <?php $dtdr_phone = get_post_meta($list_id, 'dtdr_phone', true); ?>
    <input name="dtdr_phone" type="text" value="<?php echo $dtdr_phone;?>" />
    <div class="dtdr-note"><?php echo sprintf( esc_html__('Add contact phone number for your %1$s here.','dtdr-lite'), strtolower($listing_singular_label) ); ?> </div>

</div>

<div class="dtdr-custom-box">

    <label><?php echo esc_html__('Mobile','dtdr-lite'); ?></label>
    <?php $dtdr_mobile = get_post_meta($list_id, 'dtdr_mobile', true); ?>
    <input name="dtdr_mobile" type="text" value="<?php echo $dtdr_mobile;?>" />
    <div class="dtdr-note"><?php echo sprintf( esc_html__('Add contact mobile number for your %1$s here.','dtdr-lite'), strtolower($listing_singular_label) ); ?> </div>

</div>

<div class="dtdr-custom-box">

    <label><?php echo esc_html__('Skype','dtdr-lite'); ?></label>
    <?php $dtdr_skype = get_post_meta($list_id, 'dtdr_skype', true); ?>
    <input name="dtdr_skype" type="text" value="<?php echo $dtdr_skype;?>" />
    <div class="dtdr-note"><?php echo sprintf( esc_html__('Add contact skype id for your %1$s here.','dtdr-lite'), strtolower($listing_singular_label) ); ?> </div>

</div>

<div class="dtdr-custom-box">

    <label><?php echo esc_html__('Website','dtdr-lite'); ?></label>
    <?php $dtdr_website = get_post_meta($list_id, 'dtdr_website', true); ?>
    <input name="dtdr_website" type="text" value="<?php echo $dtdr_website;?>" />
    <div class="dtdr-note"><?php echo sprintf( esc_html__('Add website address for your %1$s here.','dtdr-lite'), strtolower($listing_singular_label) ); ?> </div>

</div>

<div class="dtdr-custom-box">

    <label><?php echo esc_html__('Social Details','dtdr-lite'); ?></label>
    <?php echo dtdr_social_details_field($list_id, 'list'); ?>

</div>