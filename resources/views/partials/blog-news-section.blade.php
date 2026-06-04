@php
  $news_query = new WP_Query(['post_type' => 'post', 'posts_per_page' => 3, 'orderby' => 'date', 'order' => 'DESC']);
@endphp
@if($news_query->have_posts())
  <div class="blog-news-section pt-80 pt-md-120 pb-60 pb-md-100">
    <div class="container container--no-right">
      <div class="blog-news__top-row-container justify-content-between align-items-center mb-80">
        <div class="blog-news__heading-container">
          <h3 class="blog-news__heading h3">{!! get_field('main-page-news-title', 9) !!}</h3>
        </div>
        <div class="blog-news__more-button-container">
          <a href="{{ home_url('/naujienos/') }}" class="blog-news__button btn button--purple">
            {!! get_field('main-page-all-news-cta', 9) !!}
          </a>
        </div>
      </div>
      <div class="row">
        @while($news_query->have_posts()) <?php $news_query->the_post(); ?>
          <div class="col-12 col-md-4 blog-news__col_container mb-40 mb-md-0">
            <a href="{{ get_permalink() }}" class="blog-news__item blog-news__link">
              <div class="blog-news__image-wrapper">
                @if(has_post_thumbnail())
                  {!! get_the_post_thumbnail(get_the_ID(), 'full', ['class' => 'img-fluid blog-news__image']) !!}
                  <div class="post-image-overlay"></div>
                @endif
                <div class="post-tag position-absolute top-0 start-0 text-white px-2 py-1 small">
                  <?php $tags = get_the_tags(); ?>
                  @if($tags){{ esc_html($tags[0]->name) }}@endif
                </div>
              </div>
              <h5 class="blog-news__title">{!! get_the_title() !!}</h5>
              <div class="blog-news__excerpt post-excerpt text-truncate-2">
                {{ wp_trim_words(get_the_excerpt(), 26, '...') }}
              </div>
            </a>
          </div>
        @endwhile
      </div>
    </div>
  </div>
  <?php wp_reset_postdata(); ?>
@endif
