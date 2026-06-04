{{--
  Template Name: Įrangos kategorija
--}}

@extends('layouts.app')

@section('content')
@while(have_posts()) <?php the_post(); ?>

@php
  $iranga_background_image = get_field('iranga_background_image');
  $iranga_description = get_field('iranga_description');
  $iranga_heading = get_field('iranga_heading');
@endphp

<div class="iranga-intro mb-120"
     style="background-image: url('{{ esc_url($iranga_background_image) }}'); background-size: cover; background-position: center;">
  <div class="container">
    <div class="row justify-content-center align-items-center">
      <div class="col-12 col-md-10 col-xl-5 mb-20 mb-lg-30 text-center">
        @if($iranga_heading)
          <h1 class="iranga-heading c-white mb-30 text-center">{{ esc_html($iranga_heading) }}</h1>
        @endif
        @if($iranga_description)
          <div class="iranga-description c-white">{!! wp_kses_post($iranga_description) !!}</div>
        @endif
      </div>
    </div>
  </div>
</div>

@if(have_rows('iranga_repeater'))
  <div class="iranga-list py-5 mb-120">
    <div class="container">
      <div class="row">
        @while(have_rows('iranga_repeater')) <?php the_row(); ?>
          @php
            $image       = get_sub_field('iranga_image');
            $title       = get_sub_field('iranga_title');
            $description = get_sub_field('iranga_description');
            $url         = get_sub_field('iranga_url');
          @endphp
          <div class="col-12 col-md-6 col-lg-4 mb-4">
            @if($url)<a href="{{ esc_url($url) }}" class="iranga-card d-block h-100 text-decoration-none">@endif
            <div class="iranga-image-card shadow-sm">
              @if($image)<img src="{{ esc_url($image) }}" class="iranga-image">@endif
              <div class="iranga-card-body">
                @if($title)<h5 class="iranga-card-title">{{ esc_html($title) }}</h5>@endif
                @if($description)<p class="iranga-card-text">{!! wp_kses_post(wp_trim_words($description, 20, '…')) !!}</p>@endif
                <span class="iranga-more-btn btn btn-primary">{{ __('Plačiau') }}</span>
              </div>
            </div>
            @if($url)</a>@endif
          </div>
        @endwhile
      </div>
    </div>
  </div>
@endif

@endwhile
@endsection
