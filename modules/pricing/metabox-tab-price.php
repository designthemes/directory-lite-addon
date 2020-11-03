<?php
echo '<input type="hidden" name="dtdr_woocommerce_meta_nonce" value="'.wp_create_nonce('dtdr_woocommerce_nonce').'" />';
?>

<div class="dtdr-custom-box">
    <label><?php echo esc_html__('Currency Symbol','dtdr-lite'); ?></label>
    <?php $dtdr_currency_symbol = get_post_meta($list_id, 'dtdr_currency_symbol', true); ?>
    <input name="dtdr_currency_symbol" type="text" value="<?php echo esc_attr( $dtdr_currency_symbol );?>" />
    <div class="dtdr-note"><?php echo esc_html__('Add currency symbol here.','dtdr-lite'); ?> </div>
</div>

<div class="dtdr-custom-box">
    <label><?php echo esc_html__('Currency Symbol - Position','dtdr-lite'); ?></label>
    <?php
    $dtdr_currency_symbol_position = get_post_meta($list_id, 'dtdr_currency_symbol_position', true);
    $dtdr_currency_symbol_position = ($dtdr_currency_symbol_position != '') ? $dtdr_currency_symbol_position : 'left';
    $currency_symbol_positions = array ('' => esc_html__('Default','dtdr-lite'), 'left' => esc_html__('Left','dtdr-lite'), 'right' => esc_html__('Right','dtdr-lite'), 'left_space' => esc_html__('Left With Space','dtdr-lite'), 'right_space' => esc_html__('Right With Space','dtdr-lite'));
    ?>
    <select name="dtdr_currency_symbol_position" class="dtdr-chosen-select">
        <?php
        foreach($currency_symbol_positions as $currency_symbol_position_key => $currency_symbol_position_item) {
            echo '<option value="'.esc_attr( $currency_symbol_position_key ).'" '.selected($currency_symbol_position_key, $dtdr_currency_symbol_position, false ).'>';
                echo esc_html( $currency_symbol_position_item );
            echo '</option>';
        }
        ?>
    </select>
    <div class="dtdr-note"><?php echo esc_html__('Add currency symbol position here.','dtdr-lite'); ?> </div>
</div>

<div class="dtdr-custom-box">
    <label><?php echo esc_html__('Regular Price','dtdr-lite');?></label>
    <?php $_regular_price = get_post_meta($list_id, '_regular_price', true); ?>
    <input name="_regular_price" id="_regular_price" type="text" value="<?php echo esc_attr( $_regular_price );?>" />
    <div class="dtdr-note"><?php echo sprintf( esc_html__('Add regular price for your %1$s here. Avoid comma while adding price.','dtdr-lite'), strtolower($listing_singular_label) ); ?> </div>
</div>

<div class="dtdr-custom-box">
    <label><?php echo esc_html__('Sale Price','dtdr-lite'); ?></label>
    <?php $_sale_price = get_post_meta($list_id, '_sale_price', true); ?>
    <input name="_sale_price" id="_sale_price" type="text" value="<?php echo esc_attr( $_sale_price );?>" />
    <div class="dtdr-note"><?php echo sprintf( esc_html__('Add sale price for your %1$s here. Avoid comma while adding price.','dtdr-lite'), strtolower($listing_singular_label) ); ?> </div>
</div>

<div class="dtdr-custom-box">
    <label><?php echo esc_html__('Before Price Label','dtdr-lite'); ?></label>
    <?php $dtdr_before_price_label = get_post_meta($list_id, 'dtdr_before_price_label', true); ?>
    <input name="dtdr_before_price_label" type="text" value="<?php echo esc_attr( $dtdr_before_price_label );?>" />
    <div class="dtdr-note"><?php echo esc_html__('If needed you can add before price label here.','dtdr-lite'); ?> </div>
</div>

<div class="dtdr-custom-box">
    <label><?php echo esc_html__('After Price Label','dtdr-lite'); ?></label>
    <?php $dtdr_after_price_label = get_post_meta($list_id, 'dtdr_after_price_label', true); ?>
    <input name="dtdr_after_price_label" type="text" value="<?php echo esc_attr( $dtdr_after_price_label );?>" />
    <div class="dtdr-note"><?php echo esc_html__('If needed you can add after price label here.','dtdr-lite'); ?> </div>
</div>