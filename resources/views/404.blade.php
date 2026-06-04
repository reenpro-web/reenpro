@extends('layouts.app')

@section('content')
<div class="cms-intro cms-intro--404"></div>

<div class="pt-120 pb-200">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-12 col-lg-4 text-center">
        <div class="mb-40">
          {!! wp_get_attachment_image(get_field('404_title_image', 'options'), 'full') !!}
        </div>
        <h3 class="mb-10">{!! get_field('404_text', 'option') !!}</h3>
        <a href="{{ esc_url(home_url('/')) }}" class="not-found-link">
          {!! get_field('404_button', 'option') !!} <i></i>
        </a>
      </div>
    </div>
  </div>
</div>
@php
  $img_desktop = wp_get_attachment_image_url(get_field('404_image', 'options'), 'full');
  $img_mobile  = wp_get_attachment_image_url(get_field('404_image_mobile', 'options') ?: get_field('404_image', 'options'), 'full');
@endphp
<style>
  .cms-intro { background-image: url({{ $img_desktop }}); }
  @@media only screen and (max-width: 768px) { .cms-intro { background-image: url({{ $img_mobile }}); } }
</style>
@endsection
