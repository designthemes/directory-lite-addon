<?php

// Dashboard Media Field
if(!function_exists('dtdr_listing_upload_media_field')) {
    function dtdr_listing_upload_media_field($item_id) {

        $output = '';

        $dtdr_media_images_ids = $dtdr_media_images_titles = array ();
        $dtdr_featured_image_id = -1;
        if($item_id > 0) {
            $dtdr_media_images_ids    = get_post_meta($item_id, 'dtdr_media_images_ids', true);
            $dtdr_media_images_titles = get_post_meta($item_id, 'dtdr_media_images_titles', true);
            $dtdr_featured_image_id   = get_post_thumbnail_id($item_id);
        }

        $output .= '<div class="dtdr-upload-media-items-container">';

            if(is_array($dtdr_media_images_ids) && !empty($dtdr_media_images_ids)) {

                $output .= '<div class="dtdr-upload-media-items-holder">';
                    $output .= '<ul class="dtdr-upload-media-items">';

                        $i = 0;
                        foreach($dtdr_media_images_ids as $dtdr_media_attachments_id) {
                            if($dtdr_media_attachments_id != '') {
                                $dtdr_media_title = '';
                                if(isset($dtdr_media_images_titles[$i])) {
                                    $dtdr_media_title = $dtdr_media_images_titles[$i];
                                }
                                $thumbnail_url = wp_get_attachment_image_src($dtdr_media_attachments_id, 'thumbnail');
                                $featured_item_class = 'far fa-user';
                                if($dtdr_featured_image_id == $dtdr_media_attachments_id) {
                                    $featured_item_class = 'fa fa-user';
                                }
                                $output .= '<li>
                                                <img src="'.esc_url($thumbnail_url[0]).'" title="'.esc_attr__('Media Title','dtdr-lite').'" all="'.esc_attr__('Media Title','dtdr-lite').'" />
                                                <input name="dtdr_media_attachment_ids[]" type="hidden" class="uploadfieldid hidden" readonly value="'.esc_attr( $dtdr_media_attachments_id ).'"/>
                                                <input name="dtdr_media_attachment_titles[]" type="text" class="media-attachment-titles" value="'.esc_attr( $dtdr_media_title ).'"/>
                                                <span class="dtdr-remove-media-item"><span class="fas fa-times"></span></span>
                                                <span class="dtdr-featured-media-item"><span class="'.esc_attr( $featured_item_class ).'"></span></span>
                                            </li>';
                                $i++;
                            }
                        }

                    $output .= '</ul>';
                $output .= '</div>';

            }

            $output .= '<input type="hidden" value="'.esc_attr($dtdr_featured_image_id).'" name="dtdr_featured_image_id" id="dtdr_featured_image_id" />';

            $output .= '<input type="button" value="'.esc_html__('Upload Media','dtdr-lite').'" class="dtdr-upload-media-item-button multiple" />';
            $output .= '<input type="button" value="'.esc_html__('Remove Media','dtdr-lite').'" class="dtdr-upload-media-item-reset" />';

        $output .= '</div>';

        return $output;

    }
}

?>