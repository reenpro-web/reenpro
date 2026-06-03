<?php

/**
 * Theme setup.
 */

namespace App;

use Illuminate\Support\Facades\Vite;

/**
 * Inject styles into the block editor.
 *
 * @return array
 */
add_filter('block_editor_settings_all', function ($settings) {
    $style = Vite::asset('resources/css/editor.css');

    $settings['styles'][] = [
        'css' => "@import url('{$style}')",
    ];

    return $settings;
});

/**
 * Inject scripts into the block editor.
 *
 * @return void
 */
add_action('admin_head', function () {
    if (! get_current_screen()?->is_block_editor()) {
        return;
    }

    if (! Vite::isRunningHot()) {
        $dependencies = json_decode(Vite::content('editor.deps.json'));

        foreach ($dependencies as $dependency) {
            if (! wp_script_is($dependency)) {
                wp_enqueue_script($dependency);
            }
        }
    }
    echo Vite::withEntryPoints([
        'resources/js/editor.js',
    ])->toHtml();
});

add_filter('should_load_separate_core_block_assets', '__return_false');

/**
 * Register the initial theme setup.
 *
 * @return void
 */
add_action('after_setup_theme', function () {
    /**
     * Disable full-site editing support.
     *
     * @link https://wptavern.com/gutenberg-10-5-embeds-pdfs-adds-verse-block-color-options-and-introduces-new-patterns
     */
    remove_theme_support('block-templates');

    /**
     * Register the navigation menus.
     *
     * @link https://developer.wordpress.org/reference/functions/register_nav_menus/
     */
    register_nav_menus([
        'primary_navigation' => __('Primary Navigation', 'sage'),
        'footer_1'           => __('CMS Menu', 'sage'),
        'footer_2'           => __('CMS Menu 2', 'sage'),
    ]);

    /**
     * Disable the default block patterns.
     *
     * @link https://developer.wordpress.org/block-editor/developers/themes/theme-support/#disabling-the-default-block-patterns
     */
    remove_theme_support('core-block-patterns');

    /**
     * Enable plugins to manage the document title.
     *
     * @link https://developer.wordpress.org/reference/functions/add_theme_support/#title-tag
     */
    add_theme_support('title-tag');

    /**
     * Enable post thumbnail support.
     *
     * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
     */
    add_theme_support('post-thumbnails');

    /**
     * Enable responsive embed support.
     *
     * @link https://developer.wordpress.org/block-editor/how-to-guides/themes/theme-support/#responsive-embedded-content
     */
    add_theme_support('responsive-embeds');

    /**
     * Enable HTML5 markup support.
     *
     * @link https://developer.wordpress.org/reference/functions/add_theme_support/#html5
     */
    add_theme_support('html5', [
        'caption',
        'comment-form',
        'comment-list',
        'gallery',
        'search-form',
        'script',
        'style',
    ]);

    /**
     * Enable selective refresh for widgets in customizer.
     *
     * @link https://developer.wordpress.org/reference/functions/add_theme_support/#customize-selective-refresh-widgets
     */
    add_theme_support('customize-selective-refresh-widgets');
}, 20);

/**
 * Custom image sizes.
 */
add_action('after_setup_theme', function () {
    add_image_size('blog_card', 410, 242, true);
    add_image_size('home_logos', 338, 82, true);
    add_image_size('about-cards-new', 540, 960, true);
    add_image_size('projects-cards', 768, 400, true);
    add_image_size('projects-cards-mobile', 329, 329, true);
    add_image_size('projects-cards-small', 369, 299, true);
    add_image_size('docks-cards', 369, 396, true);
    add_image_size('docks-donation', 768, 362, true);
    add_image_size('calc-img', 468, 264, true);
    add_image_size('gallery_img', 635, 500, true);
});

/**
 * ACF options pages.
 */
add_action('acf/init', function () {
    if (! function_exists('acf_add_options_page')) {
        return;
    }

    acf_add_options_page([
        'page_title' => 'Global Options',
        'menu_title' => 'Global Options',
        'menu_slug'  => 'global-options',
        'capability' => 'edit_posts',
        'redirect'   => false,
    ]);

    foreach ([
        ['Global Options', 'global-options'],
        ['Header',         'global-options-header'],
        ['Footer',         'global-options-footer'],
        ['Įranga',         'global-options-products'],
    ] as [$title, $slug]) {
        if ($slug === 'global-options') {
            continue;
        }
        acf_add_options_sub_page([
            'page_title'  => $title,
            'menu_title'  => $title,
            'menu_slug'   => $slug,
            'parent_slug' => 'global-options',
            'capability'  => 'edit_posts',
        ]);
    }
});

/**
 * Enqueue theme scripts and CDN dependencies.
 */
add_action('wp_enqueue_scripts', function () {
    wp_enqueue_script(
        'bootstrap-js',
        'https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js',
        ['jquery'],
        '4.6.2',
        true
    );
    wp_enqueue_script(
        'select2-js',
        'https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js',
        ['jquery'],
        '4.0.13',
        true
    );
    wp_enqueue_script(
        'headroom-js',
        'https://cdn.jsdelivr.net/npm/headroom.js@0.12.0/dist/headroom.min.js',
        [],
        '0.12.0',
        true
    );
    wp_enqueue_script(
        'slick-js',
        'https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js',
        ['jquery'],
        '1.8.1',
        true
    );
    wp_add_inline_script(
        'jquery',
        'var ajax_params = ' . wp_json_encode(['ajax_url' => admin_url('admin-ajax.php')]) . ';',
        'after'
    );
}, 5);

/**
 * Admin login logo.
 */
add_action('login_enqueue_scripts', function () { ?>
    <style>
        #login h1 a, .login h1 a {
            background-size: 100%;
            width: 100%;
            background-image: url("<?php echo esc_url(get_stylesheet_directory_uri()); ?>/resources/images/logo-color.svg");
        }
    </style>
<?php });

add_filter('login_headerurl', fn() => home_url());

/**
 * Register the theme sidebars.
 *
 * @return void
 */
add_action('widgets_init', function () {
    $config = [
        'before_widget' => '<section class="widget %1$s %2$s">',
        'after_widget' => '</section>',
        'before_title' => '<h3>',
        'after_title' => '</h3>',
    ];

    register_sidebar([
        'name' => __('Primary', 'sage'),
        'id' => 'sidebar-primary',
    ] + $config);

    register_sidebar([
        'name' => __('Footer', 'sage'),
        'id' => 'sidebar-footer',
    ] + $config);
});
