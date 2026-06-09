<?php

/**
 * Theme filters.
 */

namespace App;

/**
 * Add "… Continued" to the excerpt.
 *
 * @return string
 */
add_filter('excerpt_more', function () {
    return sprintf(' &hellip; <a href="%s">%s</a>', get_permalink(), __('Continued', 'sage'));
});

/**
 * Pages with hero intros use a transparent header at the top.
 */
add_filter('body_class', function (array $classes): array {
    if (theme_has_hero_header()) {
        $classes[] = 'has-hero-header';
    }

    return $classes;
});

/**
 * Remap page templates to Sage 11 Blade equivalents.
 * Runs after Acorn's template_include (priority 100).
 */
add_filter('template_include', function ($template) {
    if (! is_page()) {
        return $template;
    }

    // Front page always uses titulinis regardless of stored template slug.
    if (is_front_page()) {
        app()['sage.view'] = 'template-titulinis';

        return $template;
    }

    $slug = get_page_template_slug();

    if ($slug === 'index.php') {
        app()['sage.view'] = 'template-titulinis';

        return $template;
    }

    $view = theme_blade_view_for_page_template($slug);

    if ($view) {
        app()['sage.view'] = $view;
    }

    return $template;
}, 200);

/**
 * Append ACF image to nav menu item title when set.
 */
add_filter('wp_nav_menu_objects', function ($items, $args) {
    foreach ($items as $item) {
        $img = get_field('menu_img', $item);
        if ($img) {
            $item->title = '<img src="' . esc_url($img) . '" alt="' . esc_attr($item->title) . '" /><span>' . $item->title . '</span>';
        }
    }
    return $items;
}, 10, 2);

/**
 * Local-only: disable CF7 spam checks so test submissions go through.
 */
add_filter('wpcf7_spam', function ($is_spam) {
    if (theme_is_local_host()) {
        return false;
    }
    return $is_spam;
}, 99);

/**
 * Local-only: route WP mail through LocalWP Mailpit.
 *
 * Guarded by the strict host check so it can NEVER run on production. If it did,
 * it would force all mail through 127.0.0.1:10006 and every send would time out.
 */
add_action('phpmailer_init', function ($phpmailer) {
    if (! theme_is_local_host()) {
        return;
    }
    $phpmailer->isSMTP();
    $phpmailer->Host       = '127.0.0.1';
    $phpmailer->Port       = 10006;
    $phpmailer->SMTPAuth   = false;
    $phpmailer->SMTPSecure = '';
    $phpmailer->SMTPAutoTLS = false;
}, 20);

/**
 * Log mail failures for CF7 debugging (local + production).
 */
add_action('wp_mail_failed', function ($wp_error) {
    if (! is_wp_error($wp_error)) {
        return;
    }

    $prefix = theme_is_local_host() ? '[local wp_mail_failed]' : '[wp_mail_failed]';
    error_log($prefix . ' ' . $wp_error->get_error_message());

    $data = $wp_error->get_error_data();
    if (! empty($data)) {
        error_log($prefix . ' data] ' . wp_json_encode($data));
    }
}, 20);

/**
 * Local-only: fix @localhost recipient addresses for Mailpit.
 */
add_filter('wpcf7_mail_components', function ($components) {
    if (! theme_is_local_host()) {
        return $components;
    }
    if (! empty($components['recipient'])) {
        $components['recipient'] = str_replace('@localhost', '@localhost.localdomain', $components['recipient']);
    }
    return $components;
}, 20);

/**
 * Local-only: fix donation CPT permalink rewrite for LocalWP.
 */
add_filter('register_post_type_args', function ($args, $post_type) {
    if ($post_type !== 'donation') {
        return $args;
    }
    if (! theme_is_local_host()) {
        return $args;
    }
    $args['publicly_queryable'] = true;
    $args['rewrite'] = [
        'slug'       => 'parama',
        'with_front' => false,
        'feeds'      => false,
        'pages'      => false,
    ];
    return $args;
}, 20, 2);
