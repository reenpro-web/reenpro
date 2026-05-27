<?php
/**
 * Template Part: Blog News Section
 * Description: Displays the three newest blog posts in a grid layout.
 */
$news_query = new WP_Query( array(
    'post_type'      => 'post',
    'posts_per_page' => 3,
    'orderby'        => 'date',
    'order'          => 'DESC',
) );

if ( $news_query->have_posts() ) : ?>
  <div class="blog-news-section pt-80 pt-md-120 pb-60 pb-md-100">
    <div class="container container--no-right">
 	  <div class="blog-news__top-row-container justify-content-between align-items-center mb-80">
        <div class="blog-news__heading-container">
          <h3 class="blog-news__heading h3"><?php echo get_field('main-page-news-title', 9); ?></h3>
        </div>
        <div class="blog-news__more-button-container">
          <a href="https://reenpro.lt/naujienos/" class="blog-news__button btn button--purple">
            <?php echo get_field('main-page-all-news-cta', 9); ?>
          </a>
        </div>
      </div>
      <div class="row">
        <?php while ( $news_query->have_posts() ) : $news_query->the_post(); ?>
          <div class="col-12 col-md-4 blog-news__col_container mb-40 mb-md-0">
            <a href="<?php the_permalink(); ?>" class="blog-news__item blog-news__link">
              <div class="blog-news__image-wrapper">
                <?php if ( has_post_thumbnail() ) : ?>
                  <?php 
                    the_post_thumbnail( 'full', [ 'class' => 'img-fluid blog-news__image' ] ); 
                  ?>
                  <div class="post-image-overlay" bis_skin_checked="1"></div>
                <?php endif; ?>
                <div class="post-tag position-absolute top-0 start-0 text-white px-2 py-1 small">
                  <?php 
                    $tags = get_the_tags();
                    if ( $tags ) {
                      echo esc_html( $tags[0]->name );
                    }
                  ?>
                </div>
              </div>
              <h5 class="blog-news__title"><?php the_title(); ?></h5>
              <div class="blog-news__excerpt post-excerpt text-truncate-2">
                <?php echo wp_trim_words(get_the_excerpt(), 26, '...'); ?>
              </div>
            </a>
          </div>
        <?php endwhile; ?>
      </div>
    </div>
  </div>
<?php endif; wp_reset_postdata(); ?>
