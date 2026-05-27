<?php
$posts_page_id = get_option('page_for_posts');

$news_background_image = get_field('news_background_image', $posts_page_id); 
$news_under_heading_text = get_field('news_under_heading_text', $posts_page_id);
$news_heading = get_field('news_heading', $posts_page_id);
?>

<div class="news-intro mb-120"
     style="background-image: url('<?php echo esc_url($news_background_image); ?>'); background-size: cover; background-position: center;">
  <div class="container">
    <div class="row justify-content-center align-items-center">
      <div class="col-12 col-md-10 col-xl-5 mb-20 mb-lg-30 text-center">
        <?php if ($news_heading): ?>
            <h1 class="news-heading c-white mb-30 text-center">
                <?php echo esc_html($news_heading); ?>
            </h1>
        <?php endif; ?>
        <?php if ($news_under_heading_text): ?>
            <div class="news-under-heading-text c-white">
                <?php echo wp_kses_post($news_under_heading_text); ?>
            </div>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>

<!-- Posts Section -->
<div class="container mb-80">
  <div class="row gy-4">
    <?php if (have_posts()) : while (have_posts()) : the_post(); 
        $external_link = get_post_meta(get_the_ID(), '_external_media_link', true);
        $post_link = $external_link ? esc_url($external_link) : get_permalink();
        $target = $external_link ? ' target="_blank" rel="noopener"' : '';
    ?>
      <a href="<?php echo $post_link; ?>"<?php echo $target; ?> class="single-post-row col-12 news-post-wrapper text-decoration-none">
        <div class="row post-item border-bottom pb-4 mb-4 align-items-start">
          <!-- Image Section -->
          <div class="col-md-3 col-12 mb-3 mb-md-0 position-relative">
            <?php if (has_post_thumbnail()) : ?>
                <?php the_post_thumbnail('medium', ['class' => 'img-fluid rounded fixed-ratio-image']); ?>
            <?php endif; ?>
			<div class = "post-image-overlay"></div>
            <!-- Tag -->
            <div class="post-tag position-absolute top-0 start-0 text-white px-2 py-1 small">
              <?php 
                $tags = get_the_tags();
                if ($tags) {
                    echo esc_html($tags[0]->name);
                }
              ?>
            </div>
          </div>

          <!-- Content Section -->
          <div class="col-md-9 col-12">
            <!-- Title -->
            <h5 class="post-title mb-2">
                <?php the_title(); ?>
            </h5>
            <!-- Date -->
            <p class="post-date text-muted small">
              <?php echo get_the_date('Y-m-d'); ?>
            </p>
            <!-- Excerpt -->
            <div class="post-excerpt text-truncate-2">
              <?php echo wp_trim_words(get_the_excerpt(), 50, '...'); ?>
            </div>
            <!-- Button -->
            <span class="news-more-btn btn btn-primary button--purple">
              <?php _e('Plačiau'); ?>
            </span>
          </div>
        </div>
      </a>
    <?php endwhile; wp_reset_postdata(); else: ?>
      <div class="col-12">
        <p><?php _e('Šiuo metu naujienų nėra.', 'textdomain'); ?></p>
      </div>
    <?php endif; ?>
  </div>
</div>