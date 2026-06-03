@extends('layouts.app')

@section('content')
@while(have_posts()) <?php the_post(); ?>

@php($post_featured_image = has_post_thumbnail() ? get_the_post_thumbnail_url(get_the_ID(), 'full') : '')

<article @php(post_class())>
  <header>
    <div class="single-post-intro"
         style="background-image: url('{{ esc_url($post_featured_image) }}');
                {{ $post_featured_image ? 'background-size: cover; background-position: center;' : '' }}">
      <div id="single-post-intro-container" class="container">
        <div>
          @php($tags = get_the_tags())
          @if($tags)
            <div class="single-post-tag position-absolute top-0 start-0 text-white px-2 py-1 small">{{ esc_html($tags[0]->name) }}</div>
          @endif
          <h1 class="single-post-heading c-white w-100">{{ get_the_title() }}</h1>
          <p class="single-post-date small c-white">{{ get_the_date('Y-m-d') }}</p>
          @if(has_excerpt())
            <div class="single-post-excerpt c-white">{{ get_the_excerpt() }}</div>
          @endif
        </div>
      </div>
    </div>
  </header>

  <div id="the-content-container" class="container entry-content single-post-content pt-75 pb-80 pb-md-120">
    @php
      $content = apply_filters('the_content', get_the_content());
      libxml_use_internal_errors(true);
      $dom = new DOMDocument();
      $dom->loadHTML('<?xml encoding="utf-8" ?>' . $content);
      libxml_clear_errors();
      $xpath    = new DOMXPath($dom);
      $headings = $xpath->query('//h2 | //h3 | //h4 | //h5 | //h6');
      if ($headings->length > 0) {
        echo '<h2 class="single-blog-post-table-heading">Turinys</h2>';
        echo '<div class="single-post-table-of-contents"><ul class="toc-list">';
        $used_ids = [];
        foreach ($headings as $heading) {
          $title = trim($heading->textContent);
          if (empty($title)) continue;
          $id = $heading->getAttribute('id') ?: sanitize_title($title);
          $orig = $id; $i = 1;
          while (in_array($id, $used_ids, true)) { $id = $orig . '-' . $i++; }
          $heading->setAttribute('id', $id);
          $used_ids[] = $id;
          echo '<li class="toc-item toc-' . esc_attr($heading->nodeName) . '"><a href="#' . esc_attr($id) . '">' . esc_html($title) . '</a></li>';
        }
        echo '</ul></div>';
      }
      $body = $dom->getElementsByTagName('body')->item(0);
      $out  = '';
      foreach ($body->childNodes as $child) $out .= $dom->saveHTML($child);
      echo $out;
    @endphp
  </div>

  <script>
  document.addEventListener("DOMContentLoaded", function() {
    document.querySelectorAll('.single-post-table-of-contents a').forEach(function(link) {
      link.addEventListener('click', function(e) {
        e.preventDefault();
        var target = document.getElementById(this.getAttribute('href').substring(1));
        if (target) window.scrollTo({top: target.getBoundingClientRect().top + window.pageYOffset - 110, behavior: 'smooth'});
      });
    });
  });
  </script>

  @include('partials.main-form')

  <footer id="single-post-footer-container" class="container single-post-footer pb-80 pb-md-120">
    <h3 class="mb-md-80 mb-40 h3">Kitos naujienos</h3>
    <div id="other-news-container" class="row gy-4" data-current-post-id="{{ get_the_ID() }}">
      @php($other_query = new WP_Query(['post_type' => 'post', 'posts_per_page' => 3, 'post__not_in' => [get_the_ID()], 'orderby' => 'date', 'order' => 'DESC']))
      @while($other_query->have_posts()) <?php $other_query->the_post(); ?>
        @php
          $external_link = get_post_meta(get_the_ID(), '_external_media_link', true);
          $post_link     = $external_link ? esc_url($external_link) : get_permalink();
          $target        = $external_link ? ' target="_blank" rel="noopener"' : '';
        @endphp
        <a href="{{ $post_link }}"{!! $target !!} class="col-12 news-post-wrapper text-decoration-none" data-post-id="{{ get_the_ID() }}">
          <div class="row post-item border-bottom pb-4 mb-4 align-items-start">
            <div class="col-md-3 col-12 mb-3 mb-md-0 position-relative">
              @if(has_post_thumbnail()){!! get_the_post_thumbnail(get_the_ID(), 'medium', ['class' => 'img-fluid rounded fixed-ratio-image']) !!}@endif
              <div class="post-image-overlay"></div>
              <div class="post-tag position-absolute top-0 start-0 text-white px-2 py-1 small">
                @php($tags = get_the_tags()) @if($tags){{ esc_html($tags[0]->name) }}@endif
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
      @php(wp_reset_postdata())
    </div>
  </footer>
</article>

@endwhile
@endsection
