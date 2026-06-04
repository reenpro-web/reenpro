<?php

/**
 * Admin customizations.
 */

namespace App;

/**
 * Rename the Posts menu item to "Naujienos" (Lithuanian).
 */
add_action('admin_menu', function () {
    global $menu, $submenu;
    $menu[5][0] = 'Naujienos';
    if (isset($submenu['edit.php'])) {
        $submenu['edit.php'][5][0]  = 'Visos naujienos';
        $submenu['edit.php'][10][0] = 'Pridėti naują';
        if (isset($submenu['edit.php'][15])) {
            $submenu['edit.php'][15][0] = 'Kategorijos';
        }
        if (isset($submenu['edit.php'][16])) {
            $submenu['edit.php'][16][0] = 'Tagai';
        }
    }
});

/**
 * External link meta box - marks a post as an external media link.
 */
add_action('add_meta_boxes', function () {
    add_meta_box(
        'external_media_link_metabox',
        'Nuoroda į išorinį žiniasklaidos puslapį (Įdėjus nuorodą, šis įrašas taps išoriniu)',
        function ($post) {
            $value = get_post_meta($post->ID, '_external_media_link', true);
            wp_nonce_field('external_link_nonce_action', 'external_link_nonce'); ?>
            <input type="text" id="external_media_link" name="external_media_link"
                   value="<?php echo esc_attr($value); ?>" style="width:100%;">
            <?php
        },
        'post',
        'normal',
        'high'
    );
});

add_action('save_post', function ($post_id) {
    if (! isset($_POST['external_link_nonce']) || ! wp_verify_nonce($_POST['external_link_nonce'], 'external_link_nonce_action')) {
        return;
    }
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    if (! current_user_can('edit_post', $post_id)) {
        return;
    }
    if (isset($_POST['external_media_link'])) {
        update_post_meta($post_id, '_external_media_link', sanitize_text_field($_POST['external_media_link']));
    }
});

/**
 * Redirect single post to external link if set.
 */
add_action('template_redirect', function () {
    if (is_single() && get_post_type() === 'post') {
        $link = get_post_meta(get_the_ID(), '_external_media_link', true);
        if (! empty($link)) {
            wp_redirect(esc_url($link), 301);
            exit;
        }
    }
});

/**
 * Auto-assign tags based on whether the post has an external link.
 */
add_action('save_post', function ($post_id) {
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    if (! current_user_can('edit_post', $post_id)) {
        return;
    }

    $external_link = get_post_meta($post_id, '_external_media_link', true);
    $current_tags  = wp_get_post_tags($post_id, ['fields' => 'slugs']);

    if (! empty($external_link)) {
        if (in_array('musu-naujienos', $current_tags, true)) {
            wp_remove_object_terms($post_id, 'musu-naujienos', 'post_tag');
        }
        wp_set_post_tags($post_id, 'ziniasklaidoje', true);
    } else {
        if (in_array('ziniasklaidoje', $current_tags, true)) {
            wp_remove_object_terms($post_id, 'ziniasklaidoje', 'post_tag');
        }
        wp_set_post_tags($post_id, 'musu-naujienos', true);
    }
});
