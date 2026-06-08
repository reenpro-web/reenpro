<?php

namespace App;

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
