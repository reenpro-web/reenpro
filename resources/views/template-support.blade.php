{{--
  Template Name: Parama
--}}

@extends('layouts.app')

@section('content')
@while(have_posts()) <?php the_post(); ?>

<div class="donation-banner">
  <div class="donation-intro"
       style="background-image: url({{ wp_get_attachment_image_url(get_field('donation_intro_image'), 'full') }});">
    <div class="container">
      <div class="row align-items-center justify-content-lg-between">
        <div class="col-12 col-md-10 col-xl-6">
          @if(get_field('donation_intro_heading'))
            <h1 class="donation-intro__heading c-white mb-40 h2">{!! get_field('donation_intro_heading') !!}</h1>
          @endif
          @if(get_field('donation_intro_text'))
            <div class="donation-intro__text c-white mb-40">{!! get_field('donation_intro_text') !!}</div>
          @endif
          @if(get_field('get_offer_text', 'options'))
            <div><div class="button button--wide getMainOffer">{!! get_field('get_offer_text', 'options') !!} <i></i></div></div>
          @endif
        </div>
      </div>
    </div>
  </div>
</div>

<div class="donation-info">
  <div class="container">
    <div class="row custom-row justify-content-center">
      <div class="col-12 col-xl-10 custom-column mb-60">
        @if(have_rows('donation_form_cards'))
          <div class="row custom-row home-info__wrapper">
            @while(have_rows('donation_form_cards')) <?php the_row(); ?>
              <div class="col-12 col-lg-4 text-center custom-column">
                <div class="home-info__item">
                  <svg class="mb-20" xmlns="http://www.w3.org/2000/svg" width="8" height="128.433" viewBox="0 0 8 128.433">
                    <g transform="translate(-493 -790)"><g transform="translate(493 790)" fill="none" stroke="#12122d" stroke-width="2"><circle cx="4" cy="4" r="4" stroke="none"/><circle cx="4" cy="4" r="3" fill="none"/></g><path d="M429.948,1287v120.433" transform="translate(67 -489)" fill="none" stroke="#12122d" stroke-width="2"/></g>
                  </svg>
                  <div class="mb-20">{!! wp_get_attachment_image(get_sub_field('icon'), 'full') !!}</div>
                  <h3 class="mb-20">{!! get_sub_field('title') !!}</h3>
                  <div>{!! get_sub_field('text') !!}</div>
                </div>
              </div>
            @endwhile
          </div>
        @endif
      </div>
      <?php $link = get_field('donation_form_button'); ?>
      @if($link)
        <div class="col-12 text-center">
          <div>
            <a class="button button--wide" href="{{ $link['url'] }}" target="{{ $link['target'] ?: '_self' }}">
              {{ $link['title'] }} <i></i>
            </a>
          </div>
        </div>
      @endif
    </div>
  </div>
</div>

<div class="donation-conditions"
     style="background-image: url({{ wp_get_attachment_image_url(get_field('donation_conditions_img'), 'full') }});">
  <div class="container">
    <div class="row custom-row donation-conditions__wrapper">
      @if(get_field('donation_conditions_heading'))
        <div class="col-12 text-center">
          <h3 class="donation-conditions__heading mb-85">{{ get_field('donation_conditions_heading') }}</h3>
        </div>
      @endif
      <?php $i = 1; ?>
      @if(have_rows('donation_conditions_cards'))
        @while(have_rows('donation_conditions_cards')) <?php the_row(); ?>
          <div class="col-12 col-lg-3 text-center">
            <div class="donation-conditions__item">
              <div class="donation-conditions__item-number mb-20">{{ $i }}</div>
              <h3 class="mb-20">{!! get_sub_field('title') !!}</h3>
              <div>{!! get_sub_field('text') !!}</div>
            </div>
          </div>
          <?php $i++; ?>
        @endwhile
      @endif
    </div>
  </div>
</div>

<div class="donation-process mt-120 mb-150">
  <div class="container">
    <div class="row justify-content-center mb-80">
      @if(get_field('process_heading'))
        <div class="col-12 col-md-10 col-lg-8 col-xl-6 text-center">
          <h3 class="donation-conditions__heading mb-20">{{ get_field('process_heading') }}</h3>
          @if(get_field('process_text'))<div>{!! get_field('process_text') !!}</div>@endif
        </div>
      @endif
    </div>
    <div class="row justify-content-center">
      <div class="col-12">
        @if(have_rows('process_steps'))
          <?php $i = 1; ?>
          <div class="donation-process__items d-flex align-items-center mb-100">
            @while(have_rows('process_steps')) <?php the_row(); ?>
              <div class="indicator-line {{ $i === 1 ? 'd-none' : '' }}"></div>
              <div class="donation-process__item">
                <div class="text-center">
                  <div class="donation-process__item-icon">
                    <div>{!! wp_get_attachment_image(get_sub_field('icon'), 'full') !!}</div>
                    <div class="donation-process__item-text">{!! get_sub_field('title') !!}</div>
                  </div>
                </div>
              </div>
              <?php $i++; ?>
            @endwhile
          </div>
        @endif
        @if(get_field('get_offer_text', 'options'))
          <div class="text-center">
            <div class="button button--wide getMainOffer">{!! get_field('get_offer_text', 'options') !!} <i></i></div>
          </div>
        @endif
      </div>
    </div>
  </div>
</div>

@include('partials.projects-small-cards')
@include('partials.main-form')
@include('partials.faq')

@endwhile
@endsection
