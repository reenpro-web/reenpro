{{--
  Template Name: Apie mus
--}}

@extends('layouts.app')

@section('content')
@while(have_posts()) <?php the_post(); ?>

<div class="about-intro d-flex">
  <div class="container mt-auto mb-auto">
    <div class="row justify-content-center">
      <div class="col-12 col-md-10 col-xl-6 text-center">
        <h1 class="about-intro__heading c-white h3 mb-40 mb-md-30">{!! get_the_title() !!}</h1>
        @if(get_field('about_intro_text'))
          <div class="about-intro__text fs-md-20 c-white">{!! get_field('about_intro_text') !!}</div>
        @endif
      </div>
    </div>
  </div>
</div>

@if(have_rows('about_info_slider'))
  <div class="about-info pt-50 pt-md-120 pb-100 pb-md-160">
    <div class="container">
      <div class="row">
        <div class="col-12 col-md-6 col-lg-5 offset-lg-1">
          @if(get_field('about_info_heading'))
            <h3 class="about-info__heading mb-50">{{ get_field('about_info_heading') }}</h3>
          @endif
        </div>
      </div>
      <div class="row">
        <div class="col-12 col-md-6 col-lg-5 offset-lg-1 mb-20 mb-md-0">
          @if(get_field('about_info_text'))
            <div class="about-info__text">{!! get_field('about_info_text') !!}</div>
          @endif
        </div>
        <div class="col-12 col-md-6 col-lg-5 col-xl-4 offset-lg-1">
          <div class="about-info__slider">
            @while(have_rows('about_info_slider')) <?php the_row(); ?>
              <div class="mb-30 mb-lg-50">
                <div class="d-flex justify-content-between align-items-center mb-15">
                  <div class="about-info__slider-heading mr-20 mr-md-0">{!! get_sub_field('heading') !!}</div>
                  <div class="about-info__slider-text">{!! get_sub_field('text') !!}</div>
                </div>
                <div class="about-info__slider-item">
                  <span style="background-color: {{ get_sub_field('color') }}; width: {{ get_sub_field('number') }}%;"></span>
                </div>
              </div>
            @endwhile
          </div>
        </div>
      </div>
    </div>
  </div>
@endif

@include('partials.about-cards')

<?php $featured_projects = get_field('about_projects'); ?>
@if($featured_projects)
  <div class="home-projects pt-50 pt-md-120 mb-100 mb-md-160 {{ get_field('display_projects') ? 'd-none' : '' }}">
    <div class="container">
      <div class="row mb-50 mb-md-80">
        <div class="col-12 col-xl-5 offset-xl-2">
          <div class="ml-lg-100">
            @if(get_field('about_projects_heading'))
              <h3 class="projects-list__heading text-center text-lg-left mb-20">{{ get_field('about_projects_heading') }}</h3>
            @endif
            @if(get_field('about_projects_text'))
              <div class="projects-list__text text-center text-lg-left">{!! get_field('about_projects_text') !!}</div>
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
                  <h4 class="mb-20 mb-md-10 fs-25 mb-lg-30">{!! \App\theme_esc_text(get_the_title($postID)) !!}</h4>
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
      @if(get_field('about_projects_button'))
        <div class="text-center">
          <a class="button button--wide d-block d-md-inline-block" href="{{ get_post_type_archive_link('projects') }}">
            {{ get_field('about_projects_button') }} <i></i>
          </a>
        </div>
      @endif
    </div>
  </div>
@endif

@include('partials.global-logos')
@include('partials.main-form')

@php
  $img_desktop = wp_get_attachment_image_url(get_field('about_intro_img'), 'full');
  $img_mobile  = wp_get_attachment_image_url(get_field('about_intro_img_mobile') ?: get_field('about_intro_img'), 'full');
@endphp
<style>
  .about-intro { background-image: url({{ $img_desktop }}); }
  @@media only screen and (max-width: 768px) { .about-intro { background-image: url({{ $img_mobile }}); } }
</style>

@endwhile
@endsection
