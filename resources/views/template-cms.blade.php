{{--
  Template Name: CMS puslapis
--}}

@extends('layouts.app')

@section('content')
@while(have_posts()) <?php the_post(); ?>

<div class="cms-intro d-flex">
  <div class="container mt-auto mb-auto">
    <div class="row">
      <div class="col-12">
        <div class="h3 mb-0 c-white text-center cms-intro__heading">{!! get_the_title() !!}</div>
      </div>
    </div>
  </div>
</div>

<div class="pt-50 pt-md-120 pb-50 pb-md-150">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-12 col-md-10 col-lg-8">
        <div class="mb-40">{!! get_the_content() !!}</div>
      </div>
    </div>
  </div>
</div>

@php
  $img_desktop = wp_get_attachment_image_url(get_field('cms_img', 'options'), 'full');
  $img_mobile  = wp_get_attachment_image_url(get_field('cms_img_mobile', 'options') ?: get_field('cms_img', 'options'), 'full');
@endphp
<style>
  .cms-intro { background-image: url({{ $img_desktop }}); }
  @@media only screen and (max-width: 768px) { .cms-intro { background-image: url({{ $img_mobile }}); } }
</style>

@endwhile
@endsection
