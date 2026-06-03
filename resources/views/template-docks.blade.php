{{--
  Template Name: Įkrovimo stotelės
--}}

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
  $carArgs  = ['post_type' => 'cars', 'post_status' => 'publish', 'posts_per_page' => -1];
  $loop     = new WP_Query($carArgs);
  $carTerms = get_terms(['taxonomy' => 'car_category', 'hide_empty' => true]);
@endphp

<div class="auto-intro mb-120"
     style="background-image: url({{ wp_get_attachment_image_url(get_field('dock_intro_img'), 'full') }});">
  <div class="container">
    <div class="row align-items-center justify-content-lg-between">
      <div class="col-12 col-md-10 col-xl-5">
        <h1 class="auto-intro__heading c-white mb-40 h2">{!! get_the_title() !!}</h1>
        @if(get_field('dock_intro_text'))
          <div class="auto-intro__text c-white mb-40">{!! get_field('dock_intro_text') !!}</div>
        @endif
        @if(get_field('get_offer_text', 'options'))
          <div><div class="button button--wide getMainOffer">{!! get_field('get_offer_text', 'options') !!} <i></i></div></div>
        @endif
      </div>
    </div>
  </div>
</div>

<div class="container mb-120">
  <div class="row justify-content-center">
    <div class="col-12 col-md-10 col-lg-10">
      <div class="auto-calculator">
        <div class="row">
          <div class="col-12 col-md-6">
            @if(get_field('calculator_heading'))
              <h2 class="mb-30 h3">{!! get_field('calculator_heading') !!}</h2>
            @endif
            <div class="row mb-30">
              <div class="col-6">
                <div class="contact-form__column">
                  <select id="hiddenMainTaxSelect">
                    <option value="">Automobilio gamintojas</option>
                    @foreach($carTerms as $term)
                      <option value="{{ $term->name }}" data-id="{{ $term->term_id }}">{{ $term->name }}</option>
                    @endforeach
                  </select>
                </div>
              </div>
              <div class="col-6">
                @if($loop->have_posts())
                  <div class="contact-form__column">
                    <select id="hiddenMainPostSelect">
                      <option value="">Automobilio modelis</option>
                      @while($loop->have_posts()) <?php ->the_post(); ?>
                        @php($terms = get_the_terms(get_the_ID(), 'car_category'))
                        <option value="{{ get_the_title() }}" id="{{ get_the_ID() }}"
                                data-id="@foreach($terms as $term){{ $term->term_id }}@endforeach">
                          {{ get_field('car_title', get_the_ID()) ?: get_the_title() }}
                        </option>
                      @endwhile
                      @php(wp_reset_postdata())
                    </select>
                  </div>
                @endif
              </div>
            </div>
            <div class="button w-100" id="calcCar">{!! get_field('calculator_button') !!} <i></i></div>
          </div>
          <div class="col-12 col-md-6 col-lg-5 offset-lg-1">
            {!! wp_get_attachment_image(get_field('calculator_img'), 'calc-img') !!}
          </div>
        </div>

        <div class="row d-none mt-100" id="calcData">
          @if(get_field('calculator_data_heading'))
            <div class="col-12 text-center"><h4 class="mb-30">{!! get_field('calculator_data_heading') !!}</h4></div>
          @endif
          @php($loop->rewind_posts())
          @if($loop->have_posts())
            @while($loop->have_posts()) <?php ->the_post(); ?>
              @php($terms = get_the_terms(get_the_ID(), 'car_category'))
              <div class="col-12">
                <div class="row d-none selected-car" id="{{ get_the_ID() }}">
                  <div class="col-12 col-md-4 col-lg-5">
                    <h3 class="mb-0">@foreach($terms as $term){{ $term->name }}@endforeach</h3>
                    <h3 class="mb-0">{{ get_the_title() }}</h3>
                  </div>
                  <div class="col-12 col-md-8 col-lg-7">
                    @if(get_field('battery', get_the_ID()) || get_field('charging_speed', get_the_ID()) || get_field('charging_time', get_the_ID()))
                      <div class="row">
                        @if(get_field('battery', get_the_ID()))
                          <div class="col-4">
                            <div class="mb-10 car-data__icon d-flex">{!! $batteryIcon !!}</div>
                            <div>{{ $batteryTitle }}</div>
                            <div class="fs-20 fw-bold">{{ get_field('battery', get_the_ID()) }}&nbsp;kWh</div>
                          </div>
                        @endif
                        @if(get_field('charging_speed', get_the_ID()))
                          <div class="col-4">
                            <div class="mb-10 car-data__icon d-flex">{!! $batterySpeedIcon !!}</div>
                            <div>{{ $batterySpeedTitle }}</div>
                            <div class="fs-20 fw-bold">{{ get_field('charging_speed', get_the_ID()) }}&nbsp;kW / AC</div>
                          </div>
                        @endif
                        @if(get_field('charging_time', get_the_ID()))
                          <div class="col-4">
                            <div class="mb-10 car-data__icon d-flex">{!! $batteryTimeIcon !!}</div>
                            <div>{{ $batteryTimeTitle }}</div>
                            <div class="fs-20 fw-bold">{{ get_field('charging_time', get_the_ID()) }}&nbsp;min.</div>
                          </div>
                        @endif
                      </div>
                    @else
                      <div class="row"><div class="col-12"><div class="fs-20">Duomenų apie šį modelį nepateikta.</div></div></div>
                    @endif
                  </div>
                  @if(get_field('get_offer_text', 'options'))
                    <div class="col-12 text-center mt-40">
                      <div class="button button--wide getMainOffer">{!! get_field('get_offer_text', 'options') !!} <i></i></div>
                    </div>
                  @endif
                </div>
              </div>
            @endwhile
            @php(wp_reset_postdata())
          @endif
        </div>
      </div>
    </div>
  </div>
</div>

@if(have_rows('docks'))
  <div class="auto-docks mb-120">
    <div class="container">
      <div class="row justify-content-center">
        @if(get_field('heading_docks'))
          <div class="col-12 text-center"><h2 class="auto-docks__heading mb-85">{{ get_field('heading_docks') }}</h2></div>
        @endif
      </div>
      <div class="row justify-content-center">
        <div class="col-12 col-lg-10">
          <div class="row custom-row auto-docks__wrapper justify-content-center">
            @while(have_rows('docks')) <?php the_row(); ?>
              <div class="col-12 col-md-6 col-lg-4 custom-column mb-30">
                <div class="auto-docks__item h-100">
                  <div class="auto-docks__item-img text-center">{!! wp_get_attachment_image(get_sub_field('img'), 'docks-cards') !!}</div>
                  <div class="p-30">
                    <h3 class="mb-30 text-center">{!! get_sub_field('title') !!}</h3>
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
  <div class="auto-choose bg-purple pt-120 pb-120">
    <div class="container">
      <div class="row">
        @if(get_field('choose_title'))
          <div class="col-12 text-center"><h2 class="auto-choose__heading mb-80 c-white h3">{{ get_field('choose_title') }}</h2></div>
        @endif
        @while(have_rows('choose_reenpro')) <?php the_row(); ?>
          <div class="col-12 col-md-6 col-lg-3 mb-30">
            <div class="auto-choose__item h-100">
              <div class="auto-choose__item-img text-center">{!! wp_get_attachment_image(get_sub_field('icon'), 'full') !!}</div>
              <div class="pt-20 c-white">
                <h3 class="mb-30 text-center c-white h4">{!! get_sub_field('title') !!}</h3>
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
  <div class="auto-donation pt-120 pb-120">
    <div class="container">
      <div class="row justify-content-center">
        @if(get_field('donation_title'))
          <div class="col-12 col-md-10 col-lg-8 text-center">
            <h2 class="auto-donation__heading mb-80 h3">{{ get_field('donation_title') }}</h2>
            <div class="mb-80">{!! get_field('donation_text') !!}</div>
          </div>
        @endif
      </div>
      @php($donationCounter = 0)
      @while(have_rows('donation_blocks')) <?php the_row(); ?>
        <div class="row align-items-center mb-80">
          <div class="col-12 mb-30 mb-lg-0 {{ $donationCounter % 2 ? 'col-lg-6 order-lg-2' : 'col-lg-6 order-lg-1' }}">
            <div class="auto-donation__img">{!! wp_get_attachment_image(get_sub_field('img'), 'docks-donation') !!}</div>
          </div>
          <div class="col-12 text-center mb-30 mb-lg-0 {{ $donationCounter % 2 ? 'col-lg-6 col-xl-5 offset-xl-1 pr-lg-65 pl-lg-0' : 'col-lg-6 col-xl-5 order-lg-2 pl-lg-65 pr-lg-0' }}">
            <div>
              <div class="auto-donation__icon mb-20">{!! wp_get_attachment_image(get_sub_field('icon'), 'full') !!}</div>
              <div class="auto-donation__wrapper {{ $donationCounter % 2 ? 'auto-donation__wrapper--right' : '' }}">
                <h3 class="auto-donation__heading mb-0 {{ $donationCounter % 2 ? 'auto-donation__heading--right' : '' }}">{!! get_sub_field('title') !!}</h3>
                <span class="auto-donation__heading-icon {{ $donationCounter % 2 ? 'auto-donation__heading-icon--right' : '' }}"><span class="dot"></span></span>
              </div>
              <div class="text-center mt-20">{!! get_sub_field('text') !!}</div>
            </div>
          </div>
        </div>
        @php($donationCounter++)
      @endwhile
      @if(get_field('get_offer_text', 'options'))
        <div class="text-center"><div class="button button--wide getMainOffer">{!! get_field('get_offer_text', 'options') !!} <i></i></div></div>
      @endif
    </div>
  </div>
@endif

<div class="auto-financing bg-purple mb-120">
  <div class="row align-items-start align-items-lg-center">
    <div class="col-12 col-lg-6 mb-30 mb-md-0 pl-0 pr-0">
      @if(get_field('financing_img'))<div class="auto-financing__img">{!! wp_get_attachment_image(get_field('financing_img'), 'full') !!}</div>@endif
    </div>
    <div class="col-12 col-lg-6 col-xl-5 offset-xl-1">
      <div class="auto-financing__wrapper pl-15 pr-15 pl-lg-0 pr-lg-20 pt-30 pt-lg-0 pb-30 pb-lg-0">
        @if(get_field('financing_title'))<h2 class="auto-financing__heading mb-45 c-white h3">{{ get_field('financing_title') }}</h2>@endif
        @if(get_field('financing_blocks'))<div class="auto-financing__text c-white">{!! get_field('financing_blocks') !!}</div>@endif
      </div>
    </div>
  </div>
</div>

<div class="donation-process mt-120 mb-170">
  <div class="container">
    <div class="row justify-content-center mb-80">
      @if(get_field('process_heading'))
        <div class="col-12 col-md-10 col-lg-8 col-xl-5 text-center">
          <h2 class="donation-conditions__heading mb-20 h3">{{ get_field('process_heading') }}</h2>
          @if(get_field('process_text'))<div>{!! get_field('process_text') !!}</div>@endif
        </div>
      @endif
    </div>
    <div class="row justify-content-center">
      <div class="col-12 col-lg-10 col-xl-9">
        @if(have_rows('process_steps'))
          @php($i = 1)
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
              @php($i++)
            @endwhile
          </div>
        @endif
        @if(get_field('get_offer_text', 'options'))
          <div class="text-center"><div class="button button--wide getMainOffer">{!! get_field('get_offer_text', 'options') !!} <i></i></div></div>
        @endif
      </div>
    </div>
  </div>
</div>

@include('partials.projects-small-cards', ['descDisplay' => 'd-none'])
@include('partials.auto-form')
@include('partials.faq')

@endwhile
@endsection
