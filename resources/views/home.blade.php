@extends('layouts.app')

@section('content')
@php
  $posts_page_id = get_option('page_for_posts');
  $news_background_image = get_field('news_background_image', $posts_page_id);
  $news_under_heading_text = get_field('news_under_heading_text', $posts_page_id);
  $news_heading = get_field('news_heading', $posts_page_id);
@endphp

<div class="news-intro mb-120"
     style="background-image: url('{{ esc_url($news_background_image) }}'); background-size: cover; background-position: center;">
  <div class="container">
    <div class="row justify-content-center align-items-center">
      <div class="col-12 col-md-10 col-xl-5 mb-20 mb-lg-30 text-center">
        @if($news_heading)
          <h1 class="news-heading c-white mb-30 text-center">{{ esc_html($news_heading) }}</h1>
        @endif
        @if($news_under_heading_text)
          <div class="news-under-heading-text c-white">{!! wp_kses_post($news_under_heading_text) !!}</div>
        @endif
      </div>
    </div>
  </div>
</div>

<div class="container mb-80">
  <div id="news-list-container">
    @if(have_posts())
      @while(have_posts()) <?php the_post(); ?>
        @php
          $external_link = get_post_meta(get_the_ID(), '_external_media_link', true);
          $post_link = $external_link ? esc_url($external_link) : get_permalink();
          $target = $external_link ? ' target="_blank" rel="noopener"' : '';
        @endphp
        <a href="{{ $post_link }}"{!! $target !!} class="single-post-row col-12 news-post-wrapper text-decoration-none">
          <div class="row post-item border-bottom pb-4 mb-4 align-items-start">
            <div class="col-md-3 col-12 mb-3 mb-md-0 position-relative">
              @if(has_post_thumbnail())
                {!! get_the_post_thumbnail(get_the_ID(), 'medium', ['class' => 'img-fluid rounded fixed-ratio-image']) !!}
              @endif
              <div class="post-image-overlay"></div>
              <div class="post-tag position-absolute">
                <?php $tags = get_the_tags(); ?>
                @if($tags){{ esc_html($tags[0]->name) }}@endif
              </div>
            </div>
            <div class="col-md-9 col-12">
              <h5 class="post-title mb-2">{!! get_the_title() !!}</h5>
              <p class="post-date text-muted small">{{ get_the_date('Y-m-d') }}</p>
              <div class="post-excerpt text-truncate-2">{{ wp_trim_words(get_the_excerpt(), 50, '...') }}</div>
              <span class="news-more-btn btn btn-primary button--purple">{{ __('Plačiau') }}</span>
            </div>
          </div>
        </a>
      @endwhile
      <?php wp_reset_postdata(); ?>
    @else
      <div class="col-12"><p>{{ __('Šiuo metu naujienų nėra.', 'textdomain') }}</p></div>
    @endif
  </div>
</div>
@endsection
