<?php

// Dashboard Attachments Field
if(!function_exists('dtdr_listing_attachments_field')) {
    function dtdr_listing_attachments_field($item_id) {

        $output = '';

        $output .= '<div class="dtdr-attachments-box-container">';

            $output .= '<div class="dtdr-attachments-box-item-holder">';

                $dtdr_media_attachments_titles = $dtdr_media_attachments_items = '';
                if($item_id > 0) {
                    $dtdr_media_attachments_titles = get_post_meta($item_id, 'dtdr_media_attachments_titles', true);
                    $dtdr_media_attachments_items  = get_post_meta($item_id, 'dtdr_media_attachments_items', true);
                }

                $j = 0;
                if(is_array($dtdr_media_attachments_titles) && !empty($dtdr_media_attachments_titles)) {
                    foreach($dtdr_media_attachments_titles as $dtdr_media_attachments_title) {

                        $attachment_url = wp_get_attachment_url($dtdr_media_attachments_items[$j]);

                        $output .= '<div class="dtdr-attachments-box-item">
                                        <div class="dtdr-column dtdr-one-column first">
                                            <input name="dtdr_media_attachments_titles[]" class="dtdr_media_attachments_titles" type="text" value="'.esc_attr($dtdr_media_attachments_title).'" placeholder="'.esc_html__('Title','dtdr-lite').'" />
                                        </div>
                                        <div class="dtdr-column dtdr-one-column first dtdr-upload-media-items-container">
                                            <input name="dtdr_media_attachments_items_url" type="text" value="'.esc_url($attachment_url).'" placeholder="'.esc_html__('Item','dtdr-lite').'" class="uploadfieldurl" readonly />
                                            <input name="dtdr_media_attachments_items[]" type="hidden" value="'.esc_attr($dtdr_media_attachments_items[$j]).'" placeholder="'.esc_html__('Item','dtdr-lite').'" class="uploadfieldid" readonly />
                                            <input type="button" value="'.esc_html__('Upload','dtdr-lite').'" class="dtdr-upload-media-item-button show-preview" />
                                            <input type="button" value="'.esc_html__('Remove','dtdr-lite').'" class="dtdr-upload-media-item-reset" />
                                        </div>
                                        <div class="dtdr-attachments-box-options">
                                            <span class="dtdr-remove-attachments"><span class="fas fa-times"></span></span>
                                            <span class="dtdr-sort-attachments"><span class="fas fa-arrows-alt"></span></span>
                                        </div>
                                    </div>';
                        $j++;
                    }
                }

            $output .= '</div>';

            $output .= '<a href="#" class="dtdr-add-attachments-box custom-button-style">'.esc_html__('Add Attachment','dtdr-lite').'</a>';

            $output .= '<div class="dtdr-attachments-box-item-toclone hidden">
                            <div class="dtdr-column dtdr-one-column first">
                                <input id="dtdr_media_attachments_titles" type="text" placeholder="'.esc_html__('Title','dtdr-lite').'" />
                            </div>
                            <div class="dtdr-column dtdr-one-column first dtdr-upload-media-items-container">
                                <input name="dtdr_media_attachments_items_url" type="text" placeholder="'.esc_html__('Item','dtdr-lite').'" class="uploadfieldurl" readonly />
                                <input id="dtdr_media_attachments_items" type="hidden" placeholder="'.esc_html__('Item','dtdr-lite').'" class="uploadfieldid" readonly />
                                <input type="button" value="'.esc_html__('Upload','dtdr-lite').'" class="dtdr-upload-media-item-button show-preview" />
                                <input type="button" value="'.esc_html__('Remove','dtdr-lite').'" class="dtdr-upload-media-item-reset" />
                            </div>
                            <div class="dtdr-attachments-box-options">
                                <span class="dtdr-remove-attachments"><span class="fas fa-times"></span></span>
                                <span class="dtdr-sort-attachments"><span class="fas fa-arrows-alt"></span></span>
                            </div>
                        </div>';

        $output .= '</div>';

        return $output;

    }
}

?>