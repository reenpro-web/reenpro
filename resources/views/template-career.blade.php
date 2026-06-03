{{--
  Template Name: Karjera
--}}

@extends('layouts.app')

@section('content')
@while(have_posts()) <?php the_post(); ?>

<div class="career-intro d-flex mb-60 mb-lg-120">
  <div class="container mt-auto mb-auto">
    <div class="row justify-content-center">
      <div class="col-12 col-md-10 col-xl-5 mb-20 mb-lg-30">
        <h1 class="career-intro__heading c-white h3 mb-30 text-center">{!! get_the_title() !!}</h1>
        @if(get_field('intro_text'))
          <div class="career-intro__text text-center c-white fs-20">{!! get_field('intro_text') !!}</div>
        @endif
      </div>
    </div>
  </div>
</div>

<div class="career-info mb-60 mb-lg-120">
  <div class="container">
    <div class="row">
      <div class="col-12 col-lg-6 order-2 order-lg-1">
        @if(get_field('career_info_img'))
          <div class="mb-20 career-info__img">{!! wp_get_attachment_image(get_field('career_info_img'), 'full') !!}</div>
        @endif
      </div>
      <div class="col-12 col-lg-6 pl-lg-30 pl-xxl-165 order-1 order-lg-2 mb-20 mb-lg-0">
        @if(get_field('career_info_heading'))
          <h3 class="career-info__heading mb-50">{{ get_field('career_info_heading') }}</h3>
        @endif
        @if(get_field('career_info_text'))
          <div class="career-info__text">{!! get_field('career_info_text') !!}</div>
        @endif
      </div>
    </div>
  </div>
</div>

@if(have_rows('jobs'))
  <div class="career">
    <div class="job mb-50 mb-lg-110">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-12 col-lg-10 col-xxl-8 text-center">
            @if(get_field('jobs_heading'))
              <h3 class="career-info__heading mb-50 mb-xl-80">{{ get_field('jobs_heading') }}</h3>
            @endif
            @php($i = 1)
            <div id="job-accordion">
              @while(have_rows('jobs')) <?php the_row(); ?>
                <div class="job-card {{ get_sub_field('display_job') ? 'd-none' : '' }}"
                     itemscope itemprop="mainEntity" itemtype="https://schema.org/Question">
                  <div id="question-{{ $i }}">
                    <div class="job-card__heading fw-bold job-card__heading-icon collapsed"
                         data-toggle="collapse" data-target="#collapse-{{ $i }}"
                         aria-expanded="true" aria-controls="collapse-{{ $i }}" itemprop="name">
                      <div class="d-flex">
                        <div class="flex-grow-0 mr-10 mr-xl-30 job-card__icon">
                          @if(get_field('job_icon')){!! wp_get_attachment_image(get_field('job_icon'), 'full') !!}@endif
                        </div>
                        <div>
                          <div class="mb-10 text-left">{!! get_sub_field('title') !!}</div>
                          <div class="job-card__location text-left">{!! get_sub_field('location') !!}</div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div id="collapse-{{ $i }}" class="collapse" aria-labelledby="question-{{ $i }}"
                       data-parent="#job-accordion" itemscope itemprop="acceptedAnswer" itemtype="https://schema.org/Answer">
                    <div class="job-card__content job-card__content--link text-left" itemprop="text">
                      {!! get_sub_field('desc') !!}
                    </div>
                  </div>
                </div>
                @php($i++)
              @endwhile
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endif

@include('partials.main-form')

@php
  $img_desktop = wp_get_attachment_image_url(get_field('career_image'), 'full');
  $img_mobile  = wp_get_attachment_image_url(get_field('career_image_mobile') ?: get_field('career_image'), 'full');
@endphp
<style>
  .career-intro { background-image: url({{ $img_desktop }}); }
  @@media only screen and (max-width: 768px) { .career-intro { background-image: url({{ $img_mobile }}); } }
</style>

@endwhile
@endsection
