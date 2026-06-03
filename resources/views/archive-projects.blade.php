@extends('layouts.app')

@section('content')

<div class="projects-intro d-flex">
  <div class="container mt-auto mb-auto">
    <div class="row justify-content-center">
      <div class="col-12 col-md-10 col-lg-7 col-xl-5 text-center">
        @if(get_field('projects_intro_heading', 'options'))
          <h1 class="projects-intro__heading c-white h3 mb-40 mb-md-30">{!! get_field('projects_intro_heading', 'options') !!}</h1>
        @endif
        @if(get_field('projects_intro_text', 'options'))
          <div class="projects-intro__text fs-md-20 c-white">{!! get_field('projects_intro_text', 'options') !!}</div>
        @endif
      </div>
    </div>
  </div>
</div>

<div class="projects-list pt-50 pt-md-120 mb-150">
  <div class="container">
    <div class="row justify-content-center mb-60 mb-md-90">
      <div class="col-12 col-md-10 col-lg-7 col-xl-5 text-center">
        @if(get_field('projects_about_heading', 'options'))
          <h3 class="projects-list__heading mb-20">{!! get_field('projects_about_heading', 'options') !!}</h3>
        @endif
        @if(get_field('projects_about_text', 'options'))
          <div class="projects-list__text">{!! get_field('projects_about_text', 'options') !!}</div>
        @endif
      </div>
    </div>
  </div>
  <div class="container container--no-right">
    <div class="row justify-content-center mb-40">
      <div class="col-12 col-lg-10 col-xl-7 text-center projects-categories">
        <?php $terms = get_terms(['taxonomy' => 'projects_category', 'hide_empty' => true]); ?>
        <div class="mb-20 mb-lg-40 d-flex flex-wrap flex-xl-nowrap justify-content-center align-items-center" id="categoriesButtons">
          <div class="d-inline-block mr-md-10 ml-md-10 text-center">
            <div class="projects-category active" data-cat="0" data-slide="0">Visi projektai</div>
          </div>
          @foreach($terms as $index => $term)
            <div class="d-inline-block mr-md-10 ml-md-10 text-center">
              <div class="projects-category" data-cat="{{ $term->term_id }}" data-slug="{{ $term->slug }}" data-slide="{{ $index + 1 }}">
                {{ $term->name }}
              </div>
            </div>
          @endforeach
        </div>
      </div>
    </div>
  </div>
  <div class="container">
    @include('partials.projects-cards')
  </div>
</div>

@include('partials.main-form')

@php
  $img_desktop = wp_get_attachment_image_url(get_field('projects_intro_img', 'options'), 'full');
  $img_mobile  = wp_get_attachment_image_url(get_field('projects_intro_img_mobile', 'options') ?: get_field('projects_intro_img', 'options'), 'full');
@endphp
<style>
  .projects-intro { background-image: url({{ $img_desktop }}); }
  @@media only screen and (max-width: 768px) { .projects-intro { background-image: url({{ $img_mobile }}); } }
</style>

@endsection
