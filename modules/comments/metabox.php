<?php
global $post;
$comment_id = $post->ID;
echo '<input type="hidden" name="dtdr_comments_meta_nonce" value="'.wp_create_nonce('dtdr_comments_nonce').'" />';

$listing_singular_label = apply_filters( 'listing_label', 'singular' );

$listing_id  = get_post_meta($comment_id, 'dtdr_listing_id', true);
$author_id   = get_post_field( 'post_author', $listing_id );
$author_name = get_the_author_meta( 'display_name', $author_id );

$dtdr_approved_commenter_id = get_post_meta($comment_id, 'dtdr_approved_commenter_id', true);

$dtdr_commenters = get_post_meta($comment_id, 'dtdr_commenters', true);


$requires_package = esc_html__('No','dtdr-lite');
if(dtdr_option('comments','comment-requires-package') == 'true') {
    $requires_package = esc_html__('Yes','dtdr-lite');
}
?>

<div class="dtdr-custom-box">

    <div class="dtdr-column dtdr-one-third first">
        <label><?php echo esc_html($listing_singular_label); ?></label>
    </div>
    <div class="dtdr-column dtdr-two-third">
        <strong><?php echo get_the_title($listing_id); ?></strong>
    </div>

</div>

<div class="dtdr-custom-box">

    <div class="dtdr-column dtdr-one-third first">
        <label><?php echo esc_html__('Current Author','dtdr-lite'); ?></label>
    </div>
    <div class="dtdr-column dtdr-two-third">
        <strong><?php echo esc_html($author_name); ?></strong>
    </div>

</div>

<div class="dtdr-custom-box">

    <div class="dtdr-column dtdr-one-third first">
        <label><?php echo esc_html__('Requires Active Package','dtdr-lite'); ?></label>
    </div>
    <div class="dtdr-column dtdr-two-third">
        <strong><?php echo esc_html($requires_package); ?></strong>
    </div>

</div>

<div class="dtdr-custom-box">

    <div class="dtdr-column dtdr-one-column first">

        <label><?php echo esc_html__('Commenter Details','dtdr-lite'); ?></label>

        <?php echo "<br><br>"; ?>

        <?php
        echo '<input class="dtdr_approved_commenter_id" name="dtdr_approved_commenter_id" type="hidden" value="'.esc_attr($dtdr_approved_commenter_id).'" />';
        echo '<input class="dtdr_approved_old_commenter_id" name="dtdr_approved_old_commenter_id" type="hidden" value="'.esc_attr($dtdr_approved_commenter_id).'" />';
        echo '<input class="dtdr_listing_id" name="dtdr_listing_id" type="hidden" value="'.esc_attr($listing_id).'" />';
        ?>

        <table border="0" cellpadding="0" cellspacing="0" class="dtdr-custom-table">
            <thead>
                <tr>
                    <th><?php echo esc_html__('#','dtdr-lite'); ?></th>
                    <th><?php echo esc_html__('User','dtdr-lite'); ?></th>
                    <th><?php echo esc_html__('Email','dtdr-lite'); ?></th>
                    <th><?php echo esc_html__('Contact Details','dtdr-lite'); ?></th>
                    <th><?php echo esc_html__('Message','dtdr-lite'); ?></th>
                    <th><?php echo esc_html__('Package Details','dtdr-lite'); ?></th>
                    <th><?php echo esc_html__('Approve','dtdr-lite'); ?></th>
                </tr>
            </thead>
            <tbody class="dtdr-custom-table-content">
                <?php
                if(is_array($dtdr_commenters) && !empty($dtdr_commenters)) {
                    $i = 1;
                    foreach($dtdr_commenters as $dtdr_commenter) {

                        $dtdr_seller_active_package_id = get_user_meta($dtdr_commenter['user_id'], 'dtdr_seller_active_package_id', true);
                        $dtdr_seller_active_package_id = (isset($dtdr_seller_active_package_id) && !empty($dtdr_seller_active_package_id)) ? $dtdr_seller_active_package_id : -1;

                        $comment_requires_package = false;
                        if(dtdr_option('comments','comment-requires-package') == 'true') {
                            $comment_requires_package = true;
                        }

                        $package_required_n_active = false;
                        if($comment_requires_package && dtdr_check_user_seller_package_is_active($dtdr_commenter['user_id'], $dtdr_seller_active_package_id)) {

                            $dtdr_seller_package_listings_count = get_user_meta($dtdr_commenter['user_id'], 'dtdr_seller_package_listings_count', true);
                            $dtdr_seller_package_listings_count = (isset($dtdr_seller_package_listings_count) && !empty($dtdr_seller_package_listings_count)) ? $dtdr_seller_package_listings_count : 0;

                            $dtdr_seller_package_used_listings_count = get_user_meta($dtdr_commenter['user_id'], 'dtdr_seller_package_used_listings_count', true);
                            $dtdr_seller_package_used_listings_count = (isset($dtdr_seller_package_used_listings_count) && !empty($dtdr_seller_package_used_listings_count)) ? $dtdr_seller_package_used_listings_count : 0;

                            if($dtdr_seller_package_listings_count == -1) {
                                $dtdr_seller_package_listings_count   = esc_html__('Unlimited','dtdr-lite');
                                $dtdr_seller_remaining_listings_count = esc_html__('Unlimited','dtdr-lite');
                                $package_required_n_active = true;
                            } else {
                                $dtdr_seller_remaining_listings_count = ($dtdr_seller_package_listings_count - $dtdr_seller_package_used_listings_count);
                            }

                            if($dtdr_seller_remaining_listings_count > 0) {
                                $package_required_n_active = true;
                            }

                        }

                        $checkbox_attr = 'data-radioswitch="dtdr-custom-table"';

                        $package_not_required = false;
                        if(!$comment_requires_package) {
                            $package_not_required = true;
                        }

                        ?>
                        <tr>
                            <td><?php echo esc_html($i); ?></td>
                            <td><?php echo sprintf(esc_html__('%1$s ( ID - %2$s )','dtdr-lite'), $dtdr_commenter['commenter_name'], '<a href="'.get_edit_user_link($dtdr_commenter['user_id']).'">'.$dtdr_commenter['user_id'].'</a>'); ?></td>
                            <td><?php echo esc_html($dtdr_commenter['commenter_email']); ?></td>
                            <td><?php echo sprintf(esc_html__('Phone - %1$s %2$s Mobile - %3$s','dtdr-lite'), $dtdr_commenter['commenter_phone'], "<br>", $dtdr_commenter['commenter_mobile']); ?></td>
                            <td><?php echo esc_html($dtdr_commenter['commenter_message']); ?></td>
                            <td>
                                <?php
                                if($comment_requires_package) {
                                    if($package_required_n_active) {
                                        echo esc_html__('Status','dtdr-lite').' : <strong>'.esc_html__('Active','dtdr-lite').'</strong>';
                                        echo "<br>";
                                        echo esc_html__('Package','dtdr-lite').' : <strong>'.get_the_title($dtdr_seller_active_package_id).'</strong>';
                                        echo "<br>";
                                        echo esc_html__('Remaining Listings','dtdr-lite').' : <strong class="dtdr-remaining-listings-label">'.$dtdr_seller_remaining_listings_count.'</strong>';
                                        echo '<input class="dtdr-package-listings" name="dtdr-package-listings[]" type="hidden" value="'.esc_attr($dtdr_seller_package_listings_count).'" />';
                                        echo '<input class="dtdr-package-used-listings" name="dtdr-package-used-listings[]" type="hidden" value="'.esc_attr($dtdr_seller_package_used_listings_count).'" />';
                                        echo '<input class="dtdr-package-used-listings-updated" name="dtdr-package-used-listings-updated[]" type="hidden" value="'.esc_attr($dtdr_seller_package_used_listings_count).'" />';
                                        echo '<input class="dtdr-user-id" name="dtdr-user-id[]" type="hidden" value="'.esc_attr($dtdr_commenter['user_id']).'" />';
                                    } else {
                                        echo '<strong>'.esc_html__('No Active Package Found!','dtdr-lite').'</strong>';
                                    }
                                }
                                ?>
                            </td>
                            <td>
                                <?php
                                if($package_required_n_active || $package_not_required) {
                                    $checked = ( $dtdr_commenter['user_id'] ==  $dtdr_approved_commenter_id ) ? ' checked="checked"' : '';
                                    $switchclass = ( $dtdr_commenter['user_id'] ==  $dtdr_approved_commenter_id ) ? 'radio-switch-on' :'radio-switch-off';
                                    echo '<div data-for="approve-comment-'.$dtdr_commenter['user_id'].'" class="dtdr-radio-switch '.$switchclass.'" '.$checkbox_attr.'></div>';
                                    echo '<input id="approve-comment-'.$dtdr_commenter['user_id'].'" class="dtdr-radio-switch-field hidden" type="checkbox" name="dtdr-approve-commenter" value="'.$dtdr_commenter['user_id'].'" '.$checked.' />';
                                }
                                ?>
                            </td>
                        </tr>
                        <?php
                        $i++;
                    }
                }
                ?>
            </tbody>
        </table>

    </div>

</div>