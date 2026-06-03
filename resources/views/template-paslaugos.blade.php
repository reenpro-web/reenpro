{{--
  Template Name: Paslaugos
--}}

@extends('layouts.app')

@section('content')
@while(have_posts()) @php(the_post())

@php
  $paslaugos_background_image = get_field('paslaugos_background_image');
  $paslaugos_description = get_field('paslaugos_description');
  $paslaugos_heading = get_field('paslaugos_heading');
@endphp

<div class="paslaugos-intro mb-120"
     style="background-image: url('{{ esc_url($paslaugos_background_image) }}'); background-size: cover; background-position: center;">
  <div class="container">
    <div class="row justify-content-center align-items-center">
      <div class="col-12 col-md-10 col-xl-5 mb-20 mb-lg-30 text-center">
        @if($paslaugos_heading)
          <h1 class="paslaugos-heading c-white mb-30 text-center">{{ esc_html($paslaugos_heading) }}</h1>
        @endif
        @if($paslaugos_description)
          <div class="paslaugos-description c-white">{!! wp_kses_post($paslaugos_description) !!}</div>
        @endif
      </div>
    </div>
  </div>
</div>

@if(have_rows('paslaugos_repeater'))
  <div class="paslaugos-list py-5 mb-120">
    <div class="container">
      <div class="row">
        @while(have_rows('paslaugos_repeater')) @php(the_row())
          @php
            $image       = get_sub_field('paslauga_image');
            $title       = get_sub_field('paslauga_title');
            $description = get_sub_field('paslauga_description');
            $url         = get_sub_field('paslauga_url');
          @endphp
          <div class="col-12 col-md-6 col-lg-4 mb-4">
            @if($url)<a href="{{ esc_url($url) }}" class="paslauga-card d-block h-100 text-decoration-none">@endif
            <div class="paslauga-image-card shadow-sm">
              @if($image)<img src="{{ esc_url($image) }}" class="paslauga-image">@endif
              <div class="paslauga-card-body">
                @if($title)<h5 class="paslauga-card-title">{{ esc_html($title) }}</h5>@endif
                @if($description)<p class="paslauga-card-text">{!! wp_kses_post(wp_trim_words($description, 20, '…')) !!}</p>@endif
                <span class="paslauga-more-btn btn btn-primary">{{ __('Plačiau') }}</span>
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
