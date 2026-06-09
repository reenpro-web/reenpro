<?php

namespace App;

/**
 * Strict local-environment check.
 *
 * Only true when the site is actually served from a localhost host. This is the
 * only place Mailpit/LocalWP services exist, so any local-only hooks (e.g.
 * redirecting mail to 127.0.0.1) must rely on this and never on
 * wp_get_environment_type(), which can be misconfigured on production and would
 * otherwise hijack live mail to a non-existent local SMTP server.
 */
function theme_is_local_host(): bool
{
    $host = wp_parse_url(home_url('/'), PHP_URL_HOST);

    return in_array($host, ['localhost', '127.0.0.1', '::1'], true)
        || (is_string($host) && str_ends_with($host, '.local'));
}

/**
 * Whether the current view should use a transparent header over a hero section.
 */
function theme_has_hero_header(): bool
{
    if (is_front_page() || is_404()) {
        return true;
    }

    if (is_singular(['product', 'donation', 'post'])) {
        return true;
    }

    if (is_post_type_archive('projects') || is_tax(['projects_category', 'installation_category'])) {
        return true;
    }

    if (! is_page()) {
        return false;
    }

    $hero_templates = [
        'template-cms.php',
        'template-contacts.php',
        'template-about.php',
        'template-career.php',
        'template-paslaugos.php',
        'paslaugos.php',
        'template-docks.php',
        'template-irangos-kategorija.php',
        'irangos-kategorija.php',
        'template-support.php',
        'template-custom.php',
    ];

    return in_array(get_page_template_slug(), $hero_templates, true);
}

/**
 * Return a page-level ACF value, falling back to global options and then a default.
 */
function theme_field_or_option(
    string $field,
    ?int $post_id = null,
    ?string $option_field = null,
    mixed $default = null
): mixed {
    $post_id = $post_id ?: (int) get_queried_object_id();
    $value   = get_field($field, $post_id);

    if (theme_field_has_value($value)) {
        return $value;
    }

    $option_field = $option_field ?: $field;
    $value        = get_field($option_field, 'options');

    if (theme_field_has_value($value)) {
        return $value;
    }

    return $default;
}

/**
 * Hero CTA label: page override, then header button title, then global intro button text.
 */
function theme_hero_button_text(?int $post_id = null): string
{
    $post_id = $post_id ?: (int) get_queried_object_id();
    $value   = get_field('home_hero_button_text', $post_id);

    if (theme_field_has_value($value)) {
        return (string) $value;
    }

    $header_button = get_field('header_form_button', 'options');
    if (is_array($header_button) && ! empty($header_button['title'])) {
        return (string) $header_button['title'];
    }

    $offer_text = get_field('get_offer_text', 'options');

    return theme_field_has_value($offer_text) ? (string) $offer_text : 'Konsultacija';
}

/**
 * Escape plain text that may already contain WordPress HTML entities.
 *
 * WP stores titles and menu labels with entities (e.g. &#8211;, &#038;). Blade's
 * {{ }} double-escapes the ampersand in those entities, showing literal codes.
 */
function theme_esc_text(string $text): string
{
    return esc_html(wp_specialchars_decode($text, ENT_QUOTES));
}

function theme_field_has_value(mixed $value): bool
{
    if ($value === null || $value === false) {
        return false;
    }

    if (is_string($value)) {
        return trim($value) !== '';
    }

    if (is_array($value)) {
        return ! empty($value);
    }

    return true;
}

/**
 * Resolve a WordPress page template slug to a Sage Blade view name.
 */
function theme_blade_view_for_page_template(string $slug): ?string
{
    if ($slug === '' || $slug === 'default') {
        return null;
    }

    $base = str_ends_with($slug, '.php') ? substr($slug, 0, -4) : $slug;

    $candidates = array_unique([
        $base,
        "template-{$base}",
        str_starts_with($base, 'template-') ? $base : null,
    ]);

    foreach (array_filter($candidates) as $view) {
        if (view()->exists($view)) {
            return $view;
        }
    }

    return null;
}
