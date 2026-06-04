{{--
  Template Name: Titulinis puslapis
--}}

@extends('layouts.app')

@section('content')
@while(have_posts()) <?php the_post(); ?>

<div class="home-slider">
  <div class="home-banner">
    @if(have_rows('index_intro_banner'))
      <?php $i = 0; ?>
      @while(have_rows('index_intro_banner')) <?php the_row(); ?>
        <div class="home-intro d-flex bg--{{ $i }}">
          <div class="container mt-auto mb-auto">
            <div class="row align-items-center justify-content-lg-between">
              <div class="col-12 col-md-10 col-lg-8 col-xxl-6">
                @if(get_sub_field('index_intro_heading'))
                  @if($i == 0)
                    <h1 class="home-intro__heading mb-24 h1">{!! get_sub_field('index_intro_heading') !!}</h1>
                  @else
                    <h2 class="home-intro__heading mb-24 h1">{!! get_sub_field('index_intro_heading') !!}</h2>
                  @endif
                @endif
                @if(get_sub_field('index_intro_text'))
                  <div class="home-intro__text c-white mb-30">{!! get_sub_field('index_intro_text') !!}</div>
                @endif
                @if(get_field('get_offer_text', 'options'))
                  <div>
                    @if(get_sub_field('index_intro_cta_url'))
                      <a href="{{ esc_attr(get_sub_field('index_intro_cta_url')) }}" class="button button--wide d-block d-md-inline-block">
                        {!! get_field('get_offer_text', 'options') !!}<i></i>
                      </a>
                    @else
                      <a href="#mainForm" class="button button--wide d-block d-md-inline-block">
                        {!! get_field('get_offer_text', 'options') !!}<i></i>
                      </a>
                    @endif
                  </div>
                @endif
              </div>
              <div class="col-12 col-md-2 col-xl-5"></div>
            </div>
          </div>
        </div>
        <?php $i++; ?>
      @endwhile
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

<div class="home-numbers pt-50 pt-md-120 pb-50 pb-md-160">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-12 col-md-6 col-xl-4 text-center">
        @if(get_field('index_number_heading'))
          <h3 class="home-numbers__heading mb-50">{{ get_field('index_number_heading') }}</h3>
        @endif
      </div>
    </div>
    @if(have_rows('index_numbers'))
      <div class="row align-items-center">
        @while(have_rows('index_numbers')) <?php the_row(); ?>
          <div class="col-12 col-md-6 col-xl-3 text-center text-md-left">
            <div class="home-numbers__item d-flex align-items-center justify-content-center">
              <div class="home-numbers__item-number mr-20">{!! get_sub_field('number') !!}</div>
              <div class="home-numbers__item-text fw-bold">{!! get_sub_field('text') !!}</div>
            </div>
          </div>
        @endwhile
      </div>
    @endif
  </div>
</div>

<div class="home-info">
  <div class="container">
    <div class="row custom-row justify-content-center">
      <div class="col-12 col-xl-10 custom-column">
        @if(have_rows('index_info_cards'))
          <div class="row custom-row home-info__wrapper">
            @while(have_rows('index_info_cards')) <?php the_row(); ?>
              <div class="col-12 col-lg-4 text-center custom-column">
                <div class="home-info__item mb-50 mb-lg-0">
                  <svg class="mb-25 d-none d-lg-inline" xmlns="http://www.w3.org/2000/svg" width="8" height="128.433" viewBox="0 0 8 128.433">
                    <g transform="translate(-493 -1449)">
                      <g transform="translate(493 1449)" fill="#fff" stroke="#12122d" stroke-width="2">
                        <circle cx="4" cy="4" r="4" stroke="none"/><circle cx="4" cy="4" r="3" fill="none"/>
                      </g>
                      <path d="M429.948,1287v120.433" transform="translate(67 170)" fill="none" stroke="#12122d" stroke-width="2"/>
                    </g>
                  </svg>
                  <div class="mb-20">{!! wp_get_attachment_image(get_sub_field('icon'), 'full') !!}</div>
                  <h4 class="mb-20 mb-md-25">{!! get_sub_field('heading') !!}</h4>
                  <div>{!! get_sub_field('text') !!}</div>
                </div>
              </div>
            @endwhile
          </div>
        @endif
      </div>
    </div>
  </div>
</div>

<?php $featured_projects = get_field('index_projects'); ?>
@if($featured_projects)
  <div class="home-projects pt-50 pt-md-120 mb-100 mb-md-160 {{ get_field('display_projects') ? 'd-none' : '' }}">
    <div class="container">
      <div class="row mb-50 mb-md-80">
        <div class="col-12 col-xl-5 offset-xl-2">
          <div class="ml-lg-100">
            @if(get_field('index_projects_heading'))
              <h3 class="projects-list__heading text-center text-lg-left mb-20">{{ get_field('index_projects_heading') }}</h3>
            @endif
            @if(get_field('index_projects_text'))
              <div class="projects-list__text text-center text-lg-left">{!! get_field('index_projects_text') !!}</div>
            @endif
          </div>
        </div>
      </div>
      <?php $projectCounter = 0; ?>
      <div class="projects-cards">
        @foreach($featured_projects as $featured_project)
          <?php $postID = $featured_project->ID; ?>
          <div class="mb-50 mb-md-80 project-item cat-0">
            <div class="row align-items-center">
              <div class="col-12 mb-20 mb-lg-0 {{ $projectCounter % 2 ? 'col-lg-6 order-lg-1' : 'col-lg-6 order-lg-2' }}">
                <div class="projects-card__slider {{ $projectCounter % 2 ? '' : 'projects-card__slider--right' }}">
                  @foreach(get_field('project_gallery', $postID) as $image_id_projects)
                    <div><div class="projects-card__slider-img">{!! wp_get_attachment_image($image_id_projects, 'projects-cards') !!}</div></div>
                  @endforeach
                </div>
              </div>
              <div class="col-12 {{ $projectCounter % 2 ? 'order-lg-2 col-lg-6 col-xl-4' : 'col-lg-5 col-xl-4 order-lg-1 offset-lg-1 offset-xl-2' }}">
                <div class="{{ $projectCounter % 2 ? 'mr-lg-100' : 'ml-lg-100' }}">
                  <h4 class="mb-20 mb-md-10 fs-25 mb-lg-30">{{ get_the_title($postID) }}</h4>
                  @if(get_field('project_desc', $postID))
                    <div class="projects-card__desc mb-30">{!! get_field('project_desc', $postID) !!}</div>
                  @endif
                </div>
              </div>
            </div>
          </div>
          <?php $projectCounter++; ?>
        @endforeach
      </div>
      <?php wp_reset_postdata(); ?>
      @if(get_field('index_projects_button'))
        <div class="text-center">
          <a class="button button--wide d-block d-md-inline-block" href="{{ get_post_type_archive_link('projects') }}">
            {{ get_field('index_projects_button') }} <i></i>
          </a>
        </div>
      @endif
    </div>
  </div>
@endif

@include('partials.about-cards')

<div class="home-donation pt-50 pt-md-120 pb-80 pb-md-140">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-12 col-md-10 col-lg-8 col-xl-6 text-center">
        <h3 class="home-donation__heading c-white">{!! get_field('index_donation_heading') !!}</h3>
        <div class="home-donation__text c-white mb-50">{!! get_field('index_donation_text') !!}</div>
        @if(have_rows('index_donation_buttons'))
          @while(have_rows('index_donation_buttons')) <?php the_row(); ?>
            <?php $linkHomeButtons = get_sub_field('link'); ?>
            <div class="home-donation__link d-md-inline-block">
              <a class="button button--wide d-block" href="{{ $linkHomeButtons['url'] }}" target="{{ $linkHomeButtons['target'] }}">
                {{ $linkHomeButtons['title'] }}<i></i>
              </a>
            </div>
          @endwhile
        @endif
      </div>
    </div>
  </div>
</div>

@include('partials.global-logos')
@include('partials.main-form')
@include('partials.blog-news-section')

@if(have_rows('index_logos'))
  <div class="home-logos pt-50 pb-50 pt-lg-110 pb-lg-110">
    <div class="container">
      <div class="home-logos__slider">
        @while(have_rows('index_logos')) <?php the_row(); ?>
          <div class="pl-10 pr-10 pl-lg-25 pr-lg-25 text-center home-clients__slider-slide">
            {!! wp_get_attachment_image(get_sub_field('logo'), 'home_logos') !!}
          </div>
        @endwhile
      </div>
    </div>
  </div>
@endif

@php
  $banners = get_field('index_intro_banner');
  $infoImgDesktop = wp_get_attachment_image_url(get_field('index_info_image'), 'full');
  $infoImgMobile  = wp_get_attachment_image_url(get_field('index_info_image_mobile') ?: get_field('index_info_image'), 'full');
  $donImgDesktop  = wp_get_attachment_image_url(get_field('index_donation_image'), 'full');
  $donImgMobile   = wp_get_attachment_image_url(get_field('index_donation_image_mobile') ?: get_field('index_donation_image'), 'full');
@endphp
@php
  $css = '<style>';
  if ($banners) {
    $j = 0;
    foreach ($banners as $banner) {
      $d = wp_get_attachment_image_url($banner['index_intro_image'], 'full');
      $m = wp_get_attachment_image_url($banner['index_intro_image_mobile'] ?: $banner['index_intro_image'], 'full');
      $css .= ".bg--{$j}{background-image:url({$d})}";
      $css .= "@media only screen and (max-width:768px){.bg--{$j}{background-image:url({$m})}}";
      $j++;
    }
  }
  $css .= ".home-info{background-image:url({$infoImgDesktop})}";
  $css .= ".home-donation{background-image:url({$donImgDesktop})}";
  $css .= "@media only screen and (max-width:768px){.home-info{background-image:url({$infoImgMobile})}.home-donation{background-image:url({$donImgMobile})}}";
  $css .= '</style>';
  echo $css;
@endphp

@endwhile
@endsection
