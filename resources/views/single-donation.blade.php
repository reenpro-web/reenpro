@extends('layouts.app')

@section('content')
@while(have_posts()) <?php the_post(); ?>

<div class="donation-banner">
  <div class="donation-intro d-flex">
    <div class="container mt-auto mb-auto">
      <div class="row align-items-center justify-content-lg-between">
        <div class="col-12 col-md-10 col-xl-6">
          <h1 class="donation-intro__heading c-white mb-40 h2">{!! get_the_title() !!}</h1>
          @if(get_field('donation_intro_text'))
            <div class="donation-intro__text c-white mb-40">{!! get_field('donation_intro_text') !!}</div>
          @endif
          @if(get_field('get_offer_text', 'options'))
            <div><div class="button button--wide getMainOffer d-block d-md-inline-block">{!! get_field('get_offer_text', 'options') !!} <i></i></div></div>
          @endif
        </div>
      </div>
    </div>
  </div>
</div>

@if(have_rows('donation_form_cards'))
  <div class="donation-info">
    <div class="container">
      <div class="row custom-row justify-content-center">
        <div class="col-12 col-xl-10 custom-column mb-60">
          <div class="row custom-row home-info__wrapper">
            @while(have_rows('donation_form_cards')) <?php the_row(); ?>
              <div class="col-12 col-lg-4 text-center custom-column mb-20 mb-lg-0">
                <div class="home-info__item">
                  <svg class="mb-20 d-none d-md-inline" xmlns="http://www.w3.org/2000/svg" width="8" height="128.433" viewBox="0 0 8 128.433"><g transform="translate(-493 -790)"><g transform="translate(493 790)" fill="none" stroke="#12122d" stroke-width="2"><circle cx="4" cy="4" r="4" stroke="none"/><circle cx="4" cy="4" r="3" fill="none"/></g><path d="M429.948,1287v120.433" transform="translate(67 -489)" fill="none" stroke="#12122d" stroke-width="2"/></g></svg>
                  <div class="mb-20">{!! wp_get_attachment_image(get_sub_field('icon'), 'full') !!}</div>
                  <h2 class="mb-20 h4">{!! get_sub_field('title') !!}</h2>
                  <div>{!! get_sub_field('text') !!}</div>
                </div>
              </div>
            @endwhile
          </div>
        </div>
        @php($link = get_field('donation_form_button'))
        @if($link)
          <div class="col-12 text-center">
            <div>
              <a class="button button--wide d-block d-md-inline-block" href="{{ $link['url'] }}" target="{{ $link['target'] ?: '_self' }}">
                {{ $link['title'] }} <i></i>
              </a>
            </div>
          </div>
        @endif
      </div>
    </div>
  </div>
@endif

@if(have_rows('donation_conditions_cards'))
  <div class="donation-conditions">
    <div class="container">
      <div class="row custom-row donation-conditions__wrapper justify-content-center">
        @if(get_field('donation_conditions_heading'))
          <div class="col-12 text-center">
            <h3 class="donation-conditions__heading mb-50 mb-md-85">{{ get_field('donation_conditions_heading') }}</h3>
          </div>
        @endif
        @php($i = 1)
        @while(have_rows('donation_conditions_cards')) <?php the_row(); ?>
          <div class="col-12 col-lg-3 text-center mb-30 mb-lg-30">
            <div class="donation-conditions__item">
              <div class="donation-conditions__item-number mb-20">{{ $i }}</div>
              <h4 class="mb-20">{!! get_sub_field('title') !!}</h4>
              <div class="fs-15 fs-md-16">{!! get_sub_field('text') !!}</div>
            </div>
          </div>
          @php($i++)
        @endwhile
      </div>
    </div>
  </div>
@endif

@if(have_rows('process_steps'))
  <div class="donation-process mt-50 mt-md-120 mb-100 mb-md-150">
    <div class="container">
      <div class="row justify-content-center mb-50 mb-md-80">
        @if(get_field('process_heading'))
          <div class="col-12 col-md-10 col-lg-8 col-xl-6 text-center">
            <h3 class="donation-conditions__heading mb-20">{{ get_field('process_heading') }}</h3>
            @if(get_field('process_text'))<div>{!! get_field('process_text') !!}</div>@endif
          </div>
        @endif
      </div>
      <div class="row justify-content-center">
        <div class="col-12">
          <div class="donation-process__wrapper">
            <div class="donation-process__items d-flex align-items-center mb-100">
              @php($i = 1)
              @while(have_rows('process_steps')) <?php the_row(); ?>
                <div class="indicator-line flex-shrink-0 {{ $i === 1 ? 'd-none' : '' }}"></div>
                <div class="donation-process__item flex-shrink-0">
                  <div class="text-center">
                    <div class="donation-process__item-icon">
                      <div>{!! wp_get_attachment_image(get_sub_field('icon'), 'full') !!}</div>
                      <div class="donation-process__item-text">{!! get_sub_field('title') !!}</div>
                    </div>
                  </div>
                </div>
                @php($i++)
              @endwhile
            </div>
          </div>
        </div>
      </div>
      @if(get_field('get_offer_text', 'options'))
        <div class="row justify-content-center mt-20 mt-lg-0">
          <div class="col-12">
            <div class="text-center">
              <div class="button button--wide getMainOffer d-block d-md-inline-block">{!! get_field('get_offer_text', 'options') !!} <i></i></div>
            </div>
          </div>
        </div>
      @endif
    </div>
  </div>
@endif

@include('partials.projects-small-cards')

@if(get_the_ID() == 866)
  @include('partials.auto-form')
@elseif(get_the_ID() == 2418)
  @include('partials.bess-form')
@else
  @include('partials.main-form')
@endif

@include('partials.faq')

@php
  $img_desktop = wp_get_attachment_image_url(get_field('donation_intro_image'), 'full');
  $img_mobile  = wp_get_attachment_image_url(get_field('donation_intro_image_mobile') ?: get_field('donation_intro_image'), 'full');
  $cond_desktop = wp_get_attachment_image_url(get_field('donation_conditions_img'), 'full');
  $cond_mobile  = wp_get_attachment_image_url(get_field('donation_conditions_img_mobile') ?: get_field('donation_conditions_img'), 'full');
@endphp
<style>
  .donation-intro { background-image: url({{ $img_desktop }}); }
  .donation-conditions { background-image: url({{ $cond_desktop }}); }
  @@media only screen and (max-width: 768px) {
    .donation-intro { background-image: url({{ $img_mobile }}); }
    .donation-conditions { background-image: url({{ $cond_mobile }}); }
  }
</style>

@endwhile
@endsection
