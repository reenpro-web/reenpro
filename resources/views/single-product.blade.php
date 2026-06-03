@extends('layouts.app')

@section('content')
@while(have_posts()) <?php the_post(); ?>

@php
  $batteryTitle      = get_field('battery_title') ?: '';
  $batteryIcon       = get_field('battery_icon') ? wp_get_attachment_image(get_field('battery_icon'), 'full') : '';
  $batterySpeedTitle = get_field('charging_speed_heading') ?: '';
  $batterySpeedIcon  = get_field('battery_speed_icon') ? wp_get_attachment_image(get_field('battery_speed_icon'), 'full') : '';
  $batteryTimeTitle  = get_field('charging_time_heading') ?: '';
  $batteryTimeIcon   = get_field('battery_time_icon') ? wp_get_attachment_image(get_field('battery_time_icon'), 'full') : '';
  $carLoop  = new WP_Query(['post_type' => 'cars', 'post_status' => 'publish', 'posts_per_page' => -1]);
  $carTerms = get_terms(['taxonomy' => 'car_category', 'hide_empty' => true]);
@endphp

<div class="auto-intro mb-50 mb-md-120 d-flex">
  <div class="container mt-auto mb-auto">
    <div class="row align-items-center justify-content-lg-between">
      <div class="col-12 col-md-10 col-xl-5">
        <h1 class="auto-intro__heading c-white mb-40 h2">{!! get_the_title() !!}</h1>
        @if(get_field('dock_intro_text'))
          <div class="auto-intro__text fs-15 c-white mb-40">{!! get_field('dock_intro_text') !!}</div>
        @endif
        @if(get_field('get_offer_text', 'options'))
          <div><div class="button button--wide getMainOffer d-block d-md-inline-block">{!! get_field('get_offer_text', 'options') !!} <i></i></div></div>
        @endif
      </div>
    </div>
  </div>
</div>

@if(!get_field('display_calculator'))
  <div class="container mb-50 mb-md-120">
    <div class="row justify-content-center">
      <div class="col-12 col-md-10 col-lg-10">
        <div class="auto-calculator">
          <div class="row">
            <div class="col-12 col-md-6 order-2 order-md-1">
              @if(get_field('calculator_heading'))
                <h3 class="mb-20 mb-md-30">{!! get_field('calculator_heading') !!}</h3>
              @endif
              <div class="row mb-20 mb-md-30">
                <div class="col-12 col-md-6 mb-20 mb-md-0">
                  <div class="contact-form__column">
                    <select id="hiddenMainTaxSelect">
                      <option value=""></option>
                      @foreach($carTerms as $term)
                        <option value="{{ $term->name }}" data-id="{{ $term->term_id }}">{{ $term->name }}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
                <div class="col-12 col-md-6">
                  @if($carLoop->have_posts())
                    <div class="contact-form__column">
                      <select id="hiddenMainPostSelect">
                        <option value=""></option>
                        @while($carLoop->have_posts()) <?php $carLoop->the_post(); ?>
                          <?php $terms = get_the_terms(get_the_ID(), 'car_category'); ?>
                          <option value="{{ get_the_title() }}" id="{{ get_the_ID() }}"
                                  data-id="@foreach($terms as $term){{ $term->term_id }}@endforeach">
                            {{ get_field('car_title', get_the_ID()) ?: get_the_title() }}
                          </option>
                        @endwhile
                        <?php wp_reset_postdata(); ?>
                      </select>
                    </div>
                  @endif
                </div>
              </div>
              <div id="calcError" class="c-red hide mt-5 mb-10 fs-12">Pasirinkite automobilį</div>
              <div class="button w-100" id="calcCar">{!! get_field('calculator_button') !!} <i></i></div>
            </div>
            <div class="col-12 col-md-6 col-lg-5 offset-lg-1 order-1 order-md-2 mb-10 mb-md-0">
              {!! wp_get_attachment_image(get_field('calculator_img'), 'calc-img') !!}
            </div>
          </div>

          <div class="row d-none mt-50 mt-md-100" id="calcData">
            @if(get_field('calculator_data_heading'))
              <div class="col-12 text-center"><h4 class="mb-30">{!! get_field('calculator_data_heading') !!}</h4></div>
            @endif
            <?php $carLoop->rewind_posts(); ?>
            @while($carLoop->have_posts()) <?php $carLoop->the_post(); ?>
              <?php $terms = get_the_terms(get_the_ID(), 'car_category'); ?>
              <div class="col-12">
                <div class="row d-none selected-car" id="{{ get_the_ID() }}">
                  <div class="col-12 col-md-4 col-lg-5 text-center text-md-left mb-20 mb-md-0">
                    <h3 class="mb-0">@foreach($terms as $term){{ $term->name }}@endforeach</h3>
                    <h3 class="mb-0">{{ get_the_title() }}</h3>
                  </div>
                  <div class="col-12 col-md-8 col-lg-7">
                    @if(get_field('battery', get_the_ID()) || get_field('charging_speed', get_the_ID()))
                      <div class="row">
                        @if(get_field('battery', get_the_ID()))
                          <div class="col-4">
                            <div class="mb-10 car-data__icon d-flex">{!! $batteryIcon !!}</div>
                            <div>{{ $batteryTitle }}</div>
                            <div class="fs-md-20 fw-bold">{{ get_field('battery', get_the_ID()) }}</div>
                          </div>
                        @endif
                        @if(get_field('charging_speed', get_the_ID()))
                          <div class="col-4">
                            <div class="mb-10 car-data__icon d-flex">{!! $batterySpeedIcon !!}</div>
                            <div>{{ $batterySpeedTitle }}</div>
                            <div class="fs-md-20 fw-bold">{{ get_field('charging_speed', get_the_ID()) }}</div>
                          </div>
                        @endif
                        @if(get_field('charging_time', get_the_ID()))
                          <div class="col-4">
                            <div class="mb-10 car-data__icon d-flex">{!! $batteryTimeIcon !!}</div>
                            <div>{{ $batteryTimeTitle }}</div>
                            <div class="fs-md-20 fw-bold">{{ get_field('charging_time', get_the_ID()) }}</div>
                          </div>
                        @endif
                      </div>
                    @else
                      <div class="row"><div class="col-12"><div class="fs-20">Duomenų apie šį modelį nepateikta.</div></div></div>
                    @endif
                  </div>
                  @if(get_field('get_offer_text', 'options'))
                    <div class="col-12 text-center mt-40 mb-10 mb-md-0">
                      <div class="button button--wide getMainOffer d-block d-md-inline-block">{!! get_field('get_offer_text', 'options') !!} <i></i></div>
                    </div>
                  @endif
                </div>
              </div>
            @endwhile
            <?php wp_reset_postdata(); ?>
          </div>
        </div>
      </div>
    </div>
  </div>
@endif

@if(have_rows('docks'))
  <div class="auto-docks mb-100 mb-md-120">
    <div class="container">
      <div class="row justify-content-center">
        @if(get_field('heading_docks'))
          <div class="col-12 text-center"><h3 class="auto-docks__heading mb-50 mb-md-85">{{ get_field('heading_docks') }}</h3></div>
        @endif
      </div>
      <div class="row justify-content-center">
        <div class="col-12 col-lg-10">
          <div class="row custom-row auto-docks__wrapper justify-content-center">
            @while(have_rows('docks')) <?php the_row(); ?>
              <div class="col-12 col-md-6 col-lg-4 custom-column mb-30">
                <div class="auto-docks__item h-100">
                  <div class="auto-docks__item-img text-center">{!! wp_get_attachment_image(get_sub_field('img'), 'docks-cards') !!}</div>
                  <div class="p-25 p-md-30">
                    <h4 class="mb-25 mb-md-30 text-center">{!! get_sub_field('title') !!}</h4>
                    <div>{!! get_sub_field('desc') !!}</div>
                  </div>
                </div>
              </div>
            @endwhile
          </div>
        </div>
      </div>
    </div>
  </div>
@endif

@if(have_rows('choose_reenpro'))
  <div class="auto-choose bg-purple pt-50 pt-md-120 pb-50 pb-md-120">
    <div class="container">
      <div class="row">
        @if(get_field('choose_title'))
          <div class="col-12 text-center"><h2 class="auto-choose__heading mb-50 mb-md-80 c-white h3">{{ get_field('choose_title') }}</h2></div>
        @endif
        @while(have_rows('choose_reenpro')) <?php the_row(); ?>
          <div class="col-12 col-md-6 col-lg-3 mb-50 mb-md-30">
            <div class="auto-choose__item h-100">
              <div class="auto-choose__item-img text-center">{!! wp_get_attachment_image(get_sub_field('icon'), 'full') !!}</div>
              <div class="pt-20 c-white">
                <h3 class="mb-20 mb-md-30 text-center c-white h4">{!! get_sub_field('title') !!}</h3>
                <div class="text-center">{!! get_sub_field('text') !!}</div>
              </div>
            </div>
          </div>
        @endwhile
      </div>
    </div>
  </div>
@endif

@if(have_rows('donation_blocks'))
  <div class="auto-donation pt-50 pt-md-120 pb-120">
    <div class="container">
      <div class="row justify-content-center">
        @if(get_field('donation_title'))
          <div class="col-12 col-md-10 col-lg-8 text-center">
            <h2 class="auto-donation__heading mb-50 mb-md-80 h3">{{ get_field('donation_title') }}</h2>
            <div class="mb-50 mb-md-80">{!! get_field('donation_text') !!}</div>
          </div>
        @endif
      </div>
    </div>
    <div class="container container--no-padding">
      <?php $donationCounter = 0; ?>
      @while(have_rows('donation_blocks')) <?php the_row(); ?>
        <div class="row align-items-center mb-50 mb-md-80">
          <div class="col-12 mb-30 mb-lg-0 {{ $donationCounter % 2 ? 'col-lg-6 order-lg-2' : 'col-lg-6 order-lg-1' }}">
            <div class="auto-donation__img">{!! wp_get_attachment_image(get_sub_field('img'), 'docks-donation') !!}</div>
          </div>
          <div class="col-12 pl-30 pr-30 pr-md-15 pl-md-15 text-center mb-30 mb-lg-0 {{ $donationCounter % 2 ? 'col-lg-6 col-xl-5 offset-xl-1 pr-lg-65 pl-lg-0' : 'col-lg-6 col-xl-5 order-lg-2 pl-lg-65 pr-lg-0' }}">
            <div>
              <div class="auto-donation__icon mb-20">{!! wp_get_attachment_image(get_sub_field('icon'), 'full') !!}</div>
              <div class="auto-donation__wrapper {{ $donationCounter % 2 ? 'auto-donation__wrapper--right' : '' }}">
                <h3 class="auto-donation__heading mb-0 h4 {{ $donationCounter % 2 ? 'auto-donation__heading--right' : '' }}">{!! get_sub_field('title') !!}</h3>
                <span class="auto-donation__heading-icon {{ $donationCounter % 2 ? 'auto-donation__heading-icon--right' : '' }}"><span class="dot"></span></span>
              </div>
              <div class="text-center mt-20">{!! get_sub_field('text') !!}</div>
            </div>
          </div>
        </div>
        <?php $donationCounter++; ?>
      @endwhile
    </div>
    <div class="container">
      @if(get_field('get_offer_text', 'options'))
        <div class="text-center"><div class="button button--wide getMainOffer d-block d-md-inline-block">{!! get_field('get_offer_text', 'options') !!} <i></i></div></div>
      @endif
    </div>
  </div>
@endif

<div class="auto-financing bg-purple mb-md-120">
  <div class="row align-items-start align-items-lg-center">
    <div class="col-12 col-lg-6 mb-30 mb-md-0 pl-0 pr-0">
      @if(get_field('financing_img'))<div class="auto-financing__img">{!! wp_get_attachment_image(get_field('financing_img'), 'full') !!}</div>@endif
    </div>
    <div class="col-12 col-lg-6 col-xl-5 offset-xl-1">
      <div class="auto-financing__wrapper pl-15 pr-15 pl-lg-0 pr-lg-20 pt-30 pt-lg-0 pb-30 pb-lg-20 pt-lg-20">
        @if(get_field('financing_title'))<h2 class="auto-financing__heading mb-45 c-white h3">{{ get_field('financing_title') }}</h2>@endif
        @if(get_field('financing_blocks'))<div class="auto-financing__text c-white">{!! get_field('financing_blocks') !!}</div>@endif
      </div>
    </div>
  </div>
</div>

@if(have_rows('process_steps'))
  <div class="donation-process mt-50 mt-md-120 mb-60 mb-md-170">
    <div class="container">
      <div class="row justify-content-center mb-50 mb-md-80">
        @if(get_field('process_heading'))
          <div class="col-12 col-md-10 col-lg-8 col-xl-5 text-center">
            <h2 class="donation-conditions__heading mb-20 h3">{{ get_field('process_heading') }}</h2>
            @if(get_field('process_text'))<div>{!! get_field('process_text') !!}</div>@endif
          </div>
        @endif
      </div>
      <div class="row justify-content-center">
        <div class="col-12 col-lg-10 col-xl-9">
          <?php $i = 1; ?>
          <div class="donation-process__wrapper">
            <div class="donation-process__items d-flex align-items-center mb-100">
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
                <?php $i++; ?>
              @endwhile
            </div>
          </div>
          @if(get_field('get_offer_text', 'options'))
            <div class="text-center mt-20 mt-lg-0">
              <div class="button button--wide getMainOffer d-block d-md-inline-block">{!! get_field('get_offer_text', 'options') !!} <i></i></div>
            </div>
          @endif
        </div>
      </div>
    </div>
  </div>
@endif

<div class="{{ get_field('display_cards') ? 'd-none' : '' }}">
  @include('partials.projects-small-cards', ['descDisplay' => 'd-none'])
</div>

@include('partials.global-logos')

<?php $postSelectForm = get_field('select_form'); ?>
@if(get_the_ID() == 2930)
  @include('partials.bess-form')
@elseif($postSelectForm == 'car')
  @include('partials.auto-form')
@elseif($postSelectForm == 'sun')
  @include('partials.main-form')
@endif

@include('partials.faq')

@php
  $img_desktop = wp_get_attachment_image_url(get_field('dock_intro_img'), 'full');
  $img_mobile  = wp_get_attachment_image_url(get_field('dock_intro_img_mobile') ?: get_field('dock_intro_img'), 'full');
@endphp
<style>
  .auto-intro { background-image: url({{ $img_desktop }}); }
  @@media only screen and (max-width: 768px) { .auto-intro { background-image: url({{ $img_mobile }}); } }
</style>

@endwhile
@endsection
