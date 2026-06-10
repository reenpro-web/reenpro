{{--
  Template Name: Titulinis puslapis
--}}

@extends('layouts.app')

@section('content')
@while(have_posts()) <?php the_post(); ?>

@php
  // ── HERO ──────────────────────────────────────────────────
  $heroSlides  = get_field('home_hero_slides') ?: [];
  $heroBtnText = \App\theme_hero_button_text();

  // ── SERVICES ──────────────────────────────────────────────
  $servLabel   = get_field('home_services_label');
  $servHeading = get_field('home_services_heading');
  $servSubtext = get_field('home_services_subtext');
  $servItems   = get_field('home_services_items') ?: [];
  $servTop     = array_slice($servItems, 0, 2);
  $servBottom  = array_slice($servItems, 2);

  // ── STATS ─────────────────────────────────────────────────
  $statsItems = get_field('home_stats_items') ?: [];

  // ── ENERGY / VIDEO ────────────────────────────────────────
  $energyLabel   = get_field('home_energy_label');
  $energyHeading = get_field('home_energy_heading');
  $energyDesc    = get_field('home_energy_description');
  $energyBullets = get_field('home_energy_bullets') ?: [];
  $energyYtUrl   = get_field('home_energy_youtube_url');
  $energyThumb   = get_field('home_energy_thumbnail');
  $energyPartner = get_field('home_energy_partner_logo');
  $energyPartnerText = get_field('home_energy_partner_text');
  $energyYtId    = null;
  if ($energyYtUrl) {
      preg_match('/(?:youtube\.com\/(?:watch\?.*v=|embed\/|v\/)|youtu\.be\/)([a-zA-Z0-9_-]{11})/', $energyYtUrl, $ytMatch);
      $energyYtId = $ytMatch[1] ?? null;
  }
  if (! $energyThumb && $energyYtId) {
      $energyThumb = 'https://img.youtube.com/vi/' . $energyYtId . '/maxresdefault.jpg';
  }

  // ── COMPENSATION ──────────────────────────────────────────
  $compLabel   = get_field('home_comp_label');
  $compHeading = get_field('home_comp_heading');
  $compSubtext = get_field('home_comp_subtext');
  $compCards   = [
    [
      'image' => get_field('home_comp_card1_image'),
      'badge' => get_field('home_comp_card1_badge'),
      'title' => get_field('home_comp_card1_title'),
      'desc'  => get_field('home_comp_card1_desc'),
      'url'   => get_field('home_comp_card1_url'),
    ],
    [
      'image' => get_field('home_comp_card2_image'),
      'badge' => get_field('home_comp_card2_badge'),
      'title' => get_field('home_comp_card2_title'),
      'desc'  => get_field('home_comp_card2_desc'),
      'url'   => get_field('home_comp_card2_url'),
    ],
  ];

  // ── CLIENTS ───────────────────────────────────────────────
  $clientsHeading = get_field('home_clients_heading');
  $clientsSubtext = get_field('home_clients_subtext');
  $clientsLogos   = get_field('home_clients_logos') ?: [];

  // ── NEWS ──────────────────────────────────────────────────
  $newsQuery = new WP_Query([
    'post_type'      => 'post',
    'post_status'    => 'publish',
    'posts_per_page' => 3,
    'orderby'        => 'date',
    'order'          => 'DESC',
  ]);

  // ── PARTNER LOGOS ─────────────────────────────────────────
  $partnerLogos = get_field('home_partners_logos') ?: [];
@endphp


{{-- ═══════════════════════════════════════════════════════
     1. HERO CAROUSEL
═══════════════════════════════════════════════════════ --}}
<div class="home-slider">
  <div class="home-banner">
    @if($heroSlides)
      <?php $i = 0; ?>
      @foreach($heroSlides as $slide)
        <div class="home-intro d-flex bg--{{ $i }}">
          <div class="container mt-auto mb-auto">
            <div class="row align-items-center justify-content-lg-between">
              <div class="col-12 col-md-10 col-lg-8 col-xxl-6">
                @if(!empty($slide['hero_slide_heading']))
                  @if($i === 1)
                    <h1 class="home-intro__heading mb-24 h1">{!! $slide['hero_slide_heading'] !!}</h1>
                  @else
                    <h2 class="home-intro__heading mb-24 h1">{!! $slide['hero_slide_heading'] !!}</h2>
                  @endif
                @endif
                @if(!empty($slide['hero_slide_text']))
                  <div class="home-intro__text c-white mb-30">{!! $slide['hero_slide_text'] !!}</div>
                @endif
                <div>
                  <a href="{{ esc_attr($slide['hero_slide_cta_url'] ?: '#mainForm') }}"
                     class="button button--wide d-block d-md-inline-block">
                    {{ $heroBtnText }}<i></i>
                  </a>
                </div>
              </div>
            </div>
          </div>
        </div>
        <?php $i++; ?>
      @endforeach
    @endif
  </div>
  <div class="home-slider__dots">
    <div class="container">
      <div class="row">
        <div class="col-12 col-md-10 col-xl-7"></div>
        <div class="col-12 col-md-2 col-xl-5 text-right">
          <div class="slick-slide__nav"></div>
        </div>
      </div>
    </div>
  </div>
</div>

@php
  $heroCss = '<style>';
  foreach ($heroSlides as $j => $slide) {
      $imgD = wp_get_attachment_image_url($slide['hero_slide_image'], 'full');
      $imgM = wp_get_attachment_image_url(
          !empty($slide['hero_slide_image_mobile']) ? $slide['hero_slide_image_mobile'] : $slide['hero_slide_image'],
          'full'
      );
      if ($imgD) {
          $heroCss .= ".bg--{$j}{background-image:url({$imgD})}";
          $heroCss .= "@media only screen and (max-width:768px){.bg--{$j}{background-image:url({$imgM})}}";
      }
  }
  $heroCss .= '</style>';
  echo $heroCss;
@endphp


{{-- ═══════════════════════════════════════════════════════
     2. INŽINERINĖS PASLAUGOS
═══════════════════════════════════════════════════════ --}}
@if($servItems)
<section class="t-services">
  <div class="container">
    <div class="t-services__header">
      @if($servLabel)
        <div class="t-label">{{ $servLabel }}</div>
      @endif
      @if($servHeading)
        <h2 class="t-services__heading">{!! $servHeading !!}</h2>
      @endif
      @if($servSubtext)
        <p class="t-services__subtext">{{ $servSubtext }}</p>
      @endif
    </div>
    <div class="t-services__grid">
      @if($servTop)
        <div class="t-services__row t-services__row--top">
          @foreach($servTop as $svc)
            <div class="t-services__card {{ !empty($svc['service_featured']) ? 't-services__card--featured' : '' }}">
              @if(!empty($svc['service_icon']))
                <div class="t-services__card-icon">{!! wp_get_attachment_image($svc['service_icon'], 'full') !!}</div>
              @endif
              <h3 class="t-services__card-title">{{ $svc['service_title'] }}</h3>
              @if(!empty($svc['service_description']))
                <p class="t-services__card-desc">{{ $svc['service_description'] }}</p>
              @endif
              @if(!empty($svc['service_link']))
                <a href="{{ esc_url($svc['service_link']) }}" class="t-services__card-link">
                  Plačiau <span>&#8594;</span>
                </a>
              @endif
            </div>
          @endforeach
        </div>
      @endif
      @if($servBottom)
        <div class="t-services__row t-services__row--bottom">
          @foreach($servBottom as $svc)
            <div class="t-services__card {{ !empty($svc['service_featured']) ? 't-services__card--featured' : '' }}">
              @if(!empty($svc['service_icon']))
                <div class="t-services__card-icon">{!! wp_get_attachment_image($svc['service_icon'], 'full') !!}</div>
              @endif
              <h3 class="t-services__card-title">{{ $svc['service_title'] }}</h3>
              @if(!empty($svc['service_description']))
                <p class="t-services__card-desc">{{ $svc['service_description'] }}</p>
              @endif
              @if(!empty($svc['service_link']))
                <a href="{{ esc_url($svc['service_link']) }}" class="t-services__card-link">
                  Plačiau <span>&#8594;</span>
                </a>
              @endif
            </div>
          @endforeach
        </div>
      @endif
    </div>
  </div>
</section>
@endif


{{-- ═══════════════════════════════════════════════════════
     3. STATISTIKA
═══════════════════════════════════════════════════════ --}}
@if($statsItems)
<section class="t-stats">
  <div class="container">
    <div class="t-stats__grid">
      @foreach($statsItems as $stat)
        <div class="t-stats__item">
          @if(!empty($stat['stat_label']))
            <div class="t-stats__label">{{ $stat['stat_label'] }}</div>
          @endif
          <div class="t-stats__number">{{ $stat['stat_number'] }}</div>
          @if(!empty($stat['stat_description']))
            <p class="t-stats__desc">{{ $stat['stat_description'] }}</p>
          @endif
        </div>
      @endforeach
    </div>
  </div>
</section>
@endif


{{-- ═══════════════════════════════════════════════════════
     4. ENERGIJOS KAUPIKLIS (VIDEO)
═══════════════════════════════════════════════════════ --}}
@if($energyHeading)
<section class="t-energy">
  <div class="container">
    <div class="t-energy__intro">
      @if($energyLabel)
        <div class="t-label t-label--center">{{ $energyLabel }}</div>
      @endif
      <h2 class="t-energy__heading">{!! $energyHeading !!}</h2>
    </div>
    <div class="t-energy__body">
      <div class="t-energy__left">
        @if($energyDesc)
          <p class="t-energy__desc">{{ $energyDesc }}</p>
        @endif
        @if($energyBullets)
          <ul class="t-energy__bullets">
            @foreach($energyBullets as $bullet)
              <li class="t-energy__bullet">{{ $bullet['energy_bullet_text'] }}</li>
            @endforeach
          </ul>
        @endif
        <hr class="t-energy__divider">
        @if($energyPartner || $energyPartnerText)
          <div class="t-energy__partner-block">
            @if($energyPartner)
              <div class="t-energy__partner">{!! wp_get_attachment_image($energyPartner, 'full') !!}</div>
            @endif
            @if($energyPartnerText)
              <div class="t-energy__partner-quote">
                <p>{{ $energyPartnerText }}</p>
              </div>
            @endif
          </div>
        @endif
      </div>
      <div class="t-energy__right">
        @if($energyThumb)
          <div class="t-energy__video-wrapper" data-video-id="{{ $energyYtId }}">
            <img src="{{ esc_url($energyThumb) }}" alt="{{ esc_attr($energyHeading) }}" class="t-energy__video-thumb">
            @if($energyYtId)
              <button class="t-energy__play-btn" aria-label="Paleisti vaizdo įrašą">
                <svg viewBox="0 0 80 80" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <circle cx="40" cy="40" r="40" fill="rgba(255,255,255,0.9)"/>
                  <polygon points="32,22 62,40 32,58" fill="#480892"/>
                </svg>
              </button>
            @endif
          </div>
        @endif
      </div>
    </div>
  </div>
</section>
@endif


{{-- ═══════════════════════════════════════════════════════
     5. VALSTYBĖS KOMPENSACIJA
═══════════════════════════════════════════════════════ --}}
@if($compHeading)
<section class="t-comp">
  <div class="container">
    <div class="t-comp__header">
      @if($compLabel)
        <div class="t-label">{{ $compLabel }}</div>
      @endif
      <h2 class="t-comp__heading">{!! $compHeading !!}</h2>
      @if($compSubtext)
        <p class="t-comp__subtext">{{ $compSubtext }}</p>
      @endif
    </div>
    <div class="t-comp__cards">
      @foreach($compCards as $card)
        @if(!empty($card['title']))
          <div class="t-comp__card">
            <div class="t-comp__card-img-wrap">
              @if(!empty($card['image']))
                <img src="{{ esc_url($card['image']) }}" alt="{{ esc_attr($card['title']) }}" class="t-comp__card-img">
              @endif
              @if(!empty($card['badge']))
                <div class="t-comp__card-badge">{{ $card['badge'] }}</div>
              @endif
            </div>
            <div class="t-comp__card-body">
              <h3 class="t-comp__card-title">{{ $card['title'] }}</h3>
              @if(!empty($card['desc']))
                <p class="t-comp__card-desc">{{ $card['desc'] }}</p>
              @endif
              @if(!empty($card['url']))
                <a href="{{ esc_url($card['url']) }}" class="t-comp__card-btn">
                  Sužinoti daugiau <i class="t-comp__card-btn-arrow"></i>
                </a>
              @endif
            </div>
          </div>
        @endif
      @endforeach
    </div>
  </div>
</section>
@endif


{{-- ═══════════════════════════════════════════════════════
     6. MUMIS PASITIKI
═══════════════════════════════════════════════════════ --}}
@if($clientsLogos)
<section class="t-clients">
  <div class="container">
    @if($clientsHeading)
      <h2 class="t-clients__heading">{{ $clientsHeading }}</h2>
    @endif
    @if($clientsSubtext)
      <p class="t-clients__subtext">{{ $clientsSubtext }}</p>
    @endif
    <div class="t-clients__logos">
      <div class="t-clients__logos-track">
        @foreach([1, 2] as $set)
          <div class="t-clients__logos-set" @if($set === 2) aria-hidden="true" @endif>
            @foreach($clientsLogos as $logo)
              @if(!empty($logo['client_logo']))
                <div class="t-clients__logo">{!! wp_get_attachment_image($logo['client_logo'], 'full') !!}</div>
              @endif
            @endforeach
          </div>
        @endforeach
      </div>
    </div>
  </div>
</section>
@endif


{{-- ═══════════════════════════════════════════════════════
     7. GAUTI PASIŪLYMĄ (FORMA)
═══════════════════════════════════════════════════════ --}}
@include('partials.main-form')


{{-- ═══════════════════════════════════════════════════════
     8. NAUJIENOS + PARTNERIŲ LOGOTIPAI
═══════════════════════════════════════════════════════ --}}
<section class="t-news">
  <div class="container">
    <div class="t-news__header">
      <h2 class="t-news__heading">Naujienos</h2>
      <a href="{{ get_permalink(get_option('page_for_posts')) ?: '/naujienos/' }}" class="t-news__all-link">
        Visos naujienos
      </a>
    </div>

    @if($newsQuery->have_posts())
      <div class="t-news__grid">
        @while($newsQuery->have_posts()) <?php $newsQuery->the_post(); ?>
          @php
            $newsTags     = get_the_tags();
            $newsTag      = $newsTags ? $newsTags[0]->name : '';
            $extLink      = get_post_meta(get_the_ID(), '_external_media_link', true);
            $newsUrl      = $extLink ?: get_permalink();
          @endphp
          <a href="{{ esc_url($newsUrl) }}"
             class="t-news__card"
             {{ $extLink ? 'target="_blank" rel="noopener noreferrer"' : '' }}>
            @if($newsTag)
              <div class="t-news__card-tag">{{ $newsTag }}</div>
            @endif
            <div class="t-news__card-img-wrap">
              {!! get_the_post_thumbnail(null, 'blog_card') !!}
              <div class="post-image-overlay"></div>
            </div>
            <div class="t-news__card-body">
              <h3 class="t-news__card-title">{!! \App\theme_esc_text(get_the_title()) !!}</h3>
              <p class="t-news__card-excerpt">{!! wp_trim_words(get_the_excerpt(), 20, '...') !!}</p>
            </div>
          </a>
        @endwhile
        <?php wp_reset_postdata(); ?>
      </div>
    @endif

    @if($partnerLogos)
      <div class="t-partners">
        @foreach($partnerLogos as $pl)
          @if(!empty($pl['partner_logo']))
            <div class="t-partners__logo">{!! wp_get_attachment_image($pl['partner_logo'], 'full') !!}</div>
          @endif
        @endforeach
      </div>
    @endif
  </div>
</section>

@endwhile
@endsection
