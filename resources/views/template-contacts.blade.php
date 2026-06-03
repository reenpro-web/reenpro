{{--
  Template Name: Kontaktai
--}}

@extends('layouts.app')

@section('content')
@while(have_posts()) @php(the_post())

<div class="contacts-intro d-flex">
  <div class="container mt-auto mb-auto">
    <div class="row justify-content-center">
      <div class="col-12 col-md-10 col-xl-7 mb-20 mb-lg-30">
        <h1 class="contacts-intro__heading c-white h3 mb-30 text-center">{!! get_the_title() !!}</h1>
        @if(have_rows('global_contacts', 'options'))
          <div class="d-flex flex-column flex-lg-row justify-content-center no-gutters align-items-lg-center">
            @while(have_rows('global_contacts', 'options')) @php(the_row())
              <div class="flex-grow-0 mb-20 mb-lg-0 d-flex justify-content-center">
                <div class="contacts-info__details contacts-info__details--{{ get_sub_field('info_type')['value'] }}">
                  {!! get_sub_field('info', 'options') !!}
                </div>
              </div>
            @endwhile
          </div>
        @endif
      </div>
      <div class="col-12 col-md-10 col-xl-6 text-lg-center">
        @if(have_rows('company_info'))
          <div class="contacts-company text-center">
            @while(have_rows('company_info')) @php(the_row())
              <div class="contacts-company__item">
                {!! get_sub_field('title') !!}<span>&nbsp;{!! get_sub_field('info') !!}</span>
              </div>
            @endwhile
          </div>
        @endif
      </div>
    </div>
  </div>
</div>

@if(have_rows('contacts_cards'))
  <div class="contacts-cards mt-50 mt-md-120 mb-60 mb-lg-50">
    <div class="container">
      <div class="row">
        @if(get_field('contacts_cards_heading'))
          <div class="col-12 text-center">
            <h3 class="contacts-cards__heading mb-50 mb-md-85">{{ get_field('contacts_cards_heading') }}</h3>
          </div>
        @endif
      </div>
      <div class="row justify-content-center">
        <div class="col-12 col-lg-11 text-center">
          <div class="row custom-row justify-content-center">
            @while(have_rows('contacts_cards')) @php(the_row())
              <div class="col-12 col-md-6 col-lg-4 custom-column mb-30 mb-lg-100">
                <div class="contacts-card h-100">
                  <div class="d-flex flex-column h-100">
                    @if(get_sub_field('name'))<h4 class="contacts-card__name mb-30">{!! get_sub_field('name') !!}</h4>@endif
                    @if(get_sub_field('status') || get_sub_field('job_field'))
                      <div class="mb-20">
                        @if(get_sub_field('status'))<div class="contacts-card__status">{!! get_sub_field('status') !!}</div>@endif
                        @if(get_sub_field('job_field'))<div class="contacts-card__job">{!! get_sub_field('job_field') !!}</div>@endif
                      </div>
                    @endif
                    <div class="mt-auto">
                      @if(get_sub_field('tel'))<div class="contacts-card__tel mb-20"><a href="tel:{{ get_sub_field('tel') }}">{{ get_sub_field('tel') }}</a></div><br>@endif
                      @if(get_sub_field('email'))<div class="contacts-card__mail"><a href="mailto:{{ get_sub_field('email') }}"> {{ get_sub_field('email') }}</a></div><br>@endif
                      @php($contactButton = get_sub_field('link'))
                      @if($contactButton)
                        <div class="mb-20">
                          <a class="w-100 button button--wide" href="{{ $contactButton['url'] }}" target="{{ $contactButton['target'] }}">
                            {{ $contactButton['title'] }}<i></i>
                          </a>
                        </div>
                      @endif
                    </div>
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

@include('partials.main-form')

@php
  $img_desktop = wp_get_attachment_image_url(get_field('contacts_image'), 'full');
  $img_mobile  = wp_get_attachment_image_url(get_field('contacts_image_mobile') ?: get_field('contacts_image'), 'full');
@endphp
<style>
  .contacts-intro { background-image: url({{ $img_desktop }}); }
  @media only screen and (max-width: 768px) { .contacts-intro { background-image: url({{ $img_mobile }}); } }
</style>

@endwhile
@endsection
