<div class="dtdr-custom-box">

    <label><?php echo esc_html__('Page Template','dtdr-lite'); ?></label>
    <?php echo dtdr_listing_page_template_field($list_id, true); ?>

</div>

<div class="dtdr-custom-box">

    <label><?php echo esc_html__('MLS Number','dtdr-lite'); ?></label>
    <?php $dtdr_mls_number = get_post_meta($list_id, 'dtdr_mls_number', true); ?>
    <input name="dtdr_mls_number" type="text" value="<?php echo esc_attr( $dtdr_mls_number );?>" class="dtdr-mls-number" style="text-transform:uppercase" />
    <input type="button" value="<?php echo esc_attr__('Generate','dtdr-lite'); ?>" class="dtdr-generate-mls-number" />
    <div class="dtdr-note"><?php echo sprintf( esc_html__('Add MLS number for your %1$s here.','dtdr-lite'), strtolower($listing_singular_label) ); ?> </div>

</div>

<div class="dtdr-custom-box">

    <label><?php echo sprintf( esc_html__( '%1$s','dtdr-lite'), $incharge_singular_label ); ?></label>
    <?php echo dtdr_listing_incharge_field($list_id, 'admin'); ?>
    <div class="dtdr-note"><?php echo sprintf( esc_html__('If you like to add %1$s for this %2$s, you can choose here.','dtdr-lite'), strtolower($incharge_singular_label), strtolower($listing_singular_label) ); ?> </div>

</div>

<?php
if((int)$author_id == (int)$user_id) {
    ?>
    <div class="dtdr-custom-box">
        <label><?php echo esc_html__('Featured Item','dtdr-lite'); ?></label>
        <?php
        $dtdr_featured_item = get_post_meta($list_id, 'dtdr_featured_item', true);
        $switchclass = ($dtdr_featured_item == 'true') ? 'checkbox-switch-on' : 'checkbox-switch-off';
        $checked = ($dtdr_featured_item == 'true') ? ' checked="checked"' : '';
        ?>
        <div data-for="dtdr_featured_item" class="dtdr-checkbox-switch <?php echo esc_attr( $switchclass );?>"></div>
        <input id="dtdr_featured_item" class="hidden" type="checkbox" name="dtdr_featured_item" value="true" <?php echo esc_attr( $checked );?> />
        <div class="dtdr-note"> <?php echo esc_html__('If you like to set this item as featured, choose "Yes"','dtdr-lite'); ?> </div>
    </div>
    <?php
}
?>

<div class="dtdr-custom-box">

    <label><?php echo esc_html__('Excerpt Title','dtdr-lite'); ?></label>
    <?php $dtdr_excerpt_title = get_post_meta($list_id, 'dtdr_excerpt_title', true); ?>
    <input name="dtdr_excerpt_title" type="text" value="<?php echo esc_attr( $dtdr_excerpt_title );?>" class="dtdr-except-title" />    
    <div class="dtdr-note"><?php echo sprintf( esc_html__('Add Excerpt title for your %1$s here.','dtdr-lite'), strtolower($listing_singular_label) ); ?> </div>

</div>