<div class="dtdr-custom-box">

    <label><?php echo esc_html__('Features','dtdr-lite'); ?></label>
    <?php
    echo dtdr_listing_features_field($list_id);
    ?>
    <div class="dtdr-note">
        <?php
        echo '<strong>'.esc_html__('Note:','dtdr-lite').'</strong>'."<br>";
        echo '<ul>';
            echo '<li>'.esc_html__('Use icon or image don\'t use both.','dtdr-lite').'</li>';
            echo '<li>'.esc_html__('First field with numeric value is the tab id of this features item, which can be used in search form.','dtdr-lite').'</li>';
            echo '<li>'.sprintf( esc_html__('Don\'t change the order of items for other %1$s.','dtdr-lite'), strtolower($listing_plural_label) ).'</li>';
            echo '<li>'.sprintf( esc_html__('If anyone of the %1$s doesn\'t have any particular item add that with empty value, so that features search field will work correctly.','dtdr-lite'), strtolower($listing_plural_label) ).'</li>';
        echo '</ul>';
        ?>
    </div>

</div>