<?php

/**
 * AJAX handlers.
 */

namespace App;

function fetch_project_items(): void
{
    $category = isset($_GET['category']) ? sanitize_text_field($_GET['category']) : '0';

    $args = [
        'post_type'      => 'projects',
        'post_status'    => 'publish',
        'posts_per_page' => -1,
        'orderby'        => 'date',
        'order'          => 'DESC',
    ];

    if ($category !== '0') {
        $args['tax_query'] = [[
            'taxonomy' => 'projects_category',
            'field'    => 'term_id',
            'terms'    => (int) $category,
        ]];
    }

    $query = new \WP_Query($args);

    if ($query->have_posts()) {
        ob_start();
        $projectCounter = 0;
        while ($query->have_posts()) {
            $query->the_post();
            $hiddenClass = $projectCounter >= 6 ? 'd-none' : '';
            echo '<div class="projects-wrapper mb-50 mb-md-80 project-item cat-0 cat-' . esc_attr($category) . ' ' . esc_attr($hiddenClass) . '">';
            get_template_part('ajax-data/projects-slider', null, ['postNo' => $projectCounter]);
            echo '</div>';
            $projectCounter++;
        }
        wp_reset_postdata();
        echo ob_get_clean();
    } else {
        echo 'No project items found';
    }

    wp_die();
}
add_action('wp_ajax_fetch_project_items', __NAMESPACE__ . '\\fetch_project_items');
add_action('wp_ajax_nopriv_fetch_project_items', __NAMESPACE__ . '\\fetch_project_items');

function load_more_posts_home(): void
{
    $posts_per_load = isset($_POST['posts_per_load']) ? (int) $_POST['posts_per_load'] : 3;
    $offset         = isset($_POST['offset']) ? (int) $_POST['offset'] : 0;
    $max_posts      = isset($_POST['max_posts']) ? (int) $_POST['max_posts'] : 0;

    if ($max_posts > 0 && $offset >= $max_posts) {
        wp_send_json(['success' => false, 'message' => 'Max posts limit reached']);
    }

    $query = new \WP_Query([
        'post_type'      => 'post',
        'posts_per_page' => $posts_per_load,
        'offset'         => $offset,
        'orderby'        => 'date',
        'order'          => 'DESC',
        'post_status'    => 'publish',
    ]);

    if ($query->have_posts()) {
        ob_start();
        while ($query->have_posts()) {
            $query->the_post();
            $external_link = get_post_meta(get_the_ID(), '_external_media_link', true);
            $post_link     = $external_link ? esc_url($external_link) : get_permalink();
            $target        = $external_link ? ' target="_blank" rel="noopener"' : ''; ?>
            <a href="<?php echo $post_link; ?>"<?php echo $target; ?> class="single-post-row col-12 news-post-wrapper text-decoration-none">
                <div class="row post-item border-bottom pb-4 mb-4 align-items-start">
                    <div class="col-md-3 col-12 mb-3 mb-md-0 position-relative">
                        <?php if (has_post_thumbnail()) : ?>
                            <?php the_post_thumbnail('medium', ['class' => 'img-fluid rounded fixed-ratio-image']); ?>
                        <?php endif; ?>
                        <div class="post-image-overlay"></div>
                        <div class="post-tag position-absolute">
                            <?php $tags = get_the_tags(); if ($tags) echo esc_html($tags[0]->name); ?>
                        </div>
                    </div>
                    <div class="col-md-9 col-12">
                        <h5 class="post-title mb-2"><?php the_title(); ?></h5>
                        <p class="post-date text-muted small"><?php echo get_the_date('Y-m-d'); ?></p>
                        <div class="post-excerpt text-truncate-2"><?php echo wp_trim_words(get_the_excerpt(), 50, '...'); ?></div>
                        <span class="news-more-btn btn btn-primary button--purple"><?php _e('Plačiau'); ?></span>
                    </div>
                </div>
            </a>
            <?php
        }
        wp_reset_postdata();
        $content      = ob_get_clean();
        $total_loaded = $offset + $posts_per_load;
        wp_send_json(['success' => true, 'content' => $content, 'reached_max' => $max_posts > 0 && $total_loaded >= $max_posts]);
    } else {
        wp_send_json(['success' => false]);
    }
}
add_action('wp_ajax_load_more_posts_home', __NAMESPACE__ . '\\load_more_posts_home');
add_action('wp_ajax_nopriv_load_more_posts_home', __NAMESPACE__ . '\\load_more_posts_home');

function load_more_posts_single(): void
{
    $posts_per_load  = isset($_POST['posts_per_load']) ? (int) $_POST['posts_per_load'] : 3;
    $offset          = isset($_POST['offset']) ? (int) $_POST['offset'] : 0;
    $max_posts       = isset($_POST['max_posts']) ? (int) $_POST['max_posts'] : 0;
    $current_post_id = isset($_POST['current_post_id']) ? (int) $_POST['current_post_id'] : 0;
    $loaded_posts    = isset($_POST['loaded_posts']) ? array_map('intval', $_POST['loaded_posts']) : [];
    $exclude_posts   = array_merge([$current_post_id], $loaded_posts);

    if ($max_posts > 0 && $offset >= $max_posts) {
        wp_send_json(['success' => false, 'message' => 'Max posts limit reached']);
    }

    $query = new \WP_Query([
        'post_type'      => 'post',
        'posts_per_page' => $posts_per_load,
        'offset'         => $offset,
        'orderby'        => 'date',
        'order'          => 'DESC',
        'post__not_in'   => $exclude_posts,
        'post_status'    => 'publish',
    ]);

    if ($query->have_posts()) {
        ob_start();
        $post_ids = [];
        while ($query->have_posts()) {
            $query->the_post();
            $post_ids[]    = get_the_ID();
            $external_link = get_post_meta(get_the_ID(), '_external_media_link', true);
            $post_link     = $external_link ? esc_url($external_link) : get_permalink();
            $target        = $external_link ? ' target="_blank" rel="noopener"' : ''; ?>
            <a href="<?php echo $post_link; ?>"<?php echo $target; ?> class="other-single-post-row col-12 news-post-wrapper text-decoration-none new-post">
                <div class="row post-item border-bottom pb-4 mb-4 align-items-start">
                    <div class="col-md-3 col-12 mb-3 mb-md-0 position-relative">
                        <?php if (has_post_thumbnail()) : ?>
                            <?php the_post_thumbnail('medium', ['class' => 'img-fluid rounded fixed-ratio-image']); ?>
                        <?php endif; ?>
                        <div class="post-image-overlay"></div>
                        <div class="post-tag position-absolute">
                            <?php $tags = get_the_tags(); if ($tags) echo esc_html($tags[0]->name); ?>
                        </div>
                    </div>
                    <div class="col-md-9 col-12">
                        <h5 class="post-title mb-2"><?php the_title(); ?></h5>
                        <p class="post-date text-muted small"><?php echo get_the_date('Y-m-d'); ?></p>
                        <div class="post-excerpt text-truncate-2"><?php echo wp_trim_words(get_the_excerpt(), 50, '...'); ?></div>
                        <span class="news-more-btn btn btn-primary button--purple"><?php _e('Plačiau'); ?></span>
                    </div>
                </div>
            </a>
            <?php
        }
        wp_reset_postdata();
        $content      = ob_get_clean();
        $total_loaded = $offset + $posts_per_load;
        wp_send_json(['success' => true, 'content' => $content, 'post_ids' => $post_ids, 'reached_max' => $max_posts > 0 && $total_loaded >= $max_posts]);
    } else {
        wp_send_json(['success' => false]);
    }
}
add_action('wp_ajax_load_more_posts_single', __NAMESPACE__ . '\\load_more_posts_single');
add_action('wp_ajax_nopriv_load_more_posts_single', __NAMESPACE__ . '\\load_more_posts_single');
