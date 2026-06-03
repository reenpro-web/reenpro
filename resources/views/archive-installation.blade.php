@extends('layouts.app')

@section('content')

<?php $redirect_url = get_field('product_link_category', 'options'); ?>
@if($redirect_url)
  <script>window.location.href = '{{ $redirect_url }}';</script>
@else

<div class="products-intro d-flex">
  <div class="container mb-auto mt-auto">
    <div class="row justify-content-center">
      <div class="col-12 col-md-10 col-lg-8 text-center">
        @if(get_field('products_intro_heading', 'options'))
          <h1 class="products-intro__heading c-white h3 mb-30">{!! get_field('products_intro_heading', 'options') !!}</h1>
        @endif
        @if(get_field('products_intro_text', 'options'))
          <div class="products-intro__text fs-20 c-white">{!! get_field('products_intro_text', 'options') !!}</div>
        @endif
      </div>
    </div>
  </div>
</div>

<div class="products-list bg-purple pt-120 pb-155">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-12 mb-30 mb-lg-60">
        <div class="row justify-content-center">
          <div class="col-12 col-md-10 col-lg-8 col-xl-7 offset-lg-1 offset-xl-2 text-md-center products-titles">
            @php
              $productsLoop    = new WP_Query(['post_type' => 'products', 'post_status' => 'publish', 'posts_per_page' => -1]);
              $productCounter  = 0;
            @endphp
            <div id="installationCategories">
              @while($productsLoop->have_posts()) <?php $productsLoop->the_post(); ?>
                <div class="mb-20 text-md-center d-inline-block">
                  <div class="products-title c-white {{ $productCounter === 0 ? 'active' : '' }}" data-index="{{ $productCounter }}">
                    {{ get_the_title() }}
                  </div>
                </div>
                <?php $productCounter++; ?>
              @endwhile
            </div>
            <?php wp_reset_postdata(); ?>
          </div>
          <div class="col-12 col-lg-3 text-right">
            <div class="products-slider__arrows"></div>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-12 col-lg-10 offset-lg-1">
        <div id="productSlide" class="products-slider">
          @php
            $installLoop    = new WP_Query(['post_type' => 'installation', 'post_status' => 'publish', 'posts_per_page' => -1]);
            $productCounter = 0;
          @endphp
          @while($installLoop->have_posts()) <?php $installLoop->the_post(); ?>
            <div>
              <div class="row mb-20">
                <div class="col-12 col-lg-6 mb-50 mb-lg-0 c-white product-galleries">
                  <div id="products-gallery" class="products-gallery">
                    @foreach(get_field('product_gallery') as $image_id)
                      <div class="image"><div class="products-gallery__img">{!! wp_get_attachment_image($image_id, 'gallery_img') !!}</div></div>
                    @endforeach
                  </div>
                </div>
                <div class="col-12 col-lg-6 col-xl-5">
                  <h3 class="c-white mb-50">{{ get_the_title() }}</h3>
                  @if(have_rows('product_spec'))
                    <div class="row mb-20">
                      @while(have_rows('product_spec')) <?php the_row(); ?>
                        <div class="col-12 col-md-6 c-white">
                          <div class="products-item__spec mb-30">{!! get_sub_field('text') !!}</div>
                        </div>
                      @endwhile
                    </div>
                  @endif
                  @if(get_field('product_file'))
                    <div class="products-item__button d-block d-lg-inline-block text-center">
                      <a class="w-100" target="_blank" download href="{{ get_field('product_file') }}">
                        <i></i> Dokumentacija <span></span>
                      </a>
                    </div>
                  @endif
                </div>
                @if(get_field('products_slider_heading', 'options'))
                  <div class="col-12 col-xl-11 offset-xl-1 mt-50 mt-lg-80 c-white">{!! get_field('product_desc') !!}</div>
                @endif
              </div>
            </div>
            <?php $productCounter++; ?>
          @endwhile
          <?php wp_reset_postdata(); ?>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="products-warranty mb-120 mt-50 mt-lg-120">
  <div class="row">
    <div class="col-12 col-lg-6 mb-50 mb-md-0 pl-0 pr-0">
      <div class="products-warranty__img">{!! wp_get_attachment_image(get_field('warranty_img', 'options'), 'full') !!}</div>
    </div>
    <div class="col-12 col-lg-6 col-xl-5 offset-xl-1">
      <div class="products-warranty__wrapper pl-15 pr-15 pl-lg-0 pr-lg-20 pt-30 pt-lg-0 pb-30 pb-lg-0">
        @if(get_field('warranty_heading', 'options'))
          <h2 class="auto-financing__heading mb-45">{{ get_field('warranty_heading', 'options') }}</h2>
        @endif
        @if(get_field('warranty_text', 'options'))
          <div class="products-warranty__text mb-45">{!! get_field('warranty_text', 'options') !!}</div>
        @endif
        @if(have_rows('warranty_list', 'options'))
          <div class="products-warranty__list">
            <?php $i = 1; ?>
            @while(have_rows('warranty_list', 'options')) <?php the_row(); ?>
              <div class="mb-30 products-warranty__list-item">
                <span class="products-warranty__list-item--number">{{ $i }}</span>
                <h3 class="mb-15 fw-bold">{!! get_sub_field('heading', 'options') !!}</h3>
                <div>{!! get_sub_field('text', 'options') !!}</div>
              </div>
              <?php $i++; ?>
            @endwhile
          </div>
        @endif
      </div>
    </div>
  </div>
</div>

<div class="products-production pt-50 pt-lg-120 pb-120 pb-lg-155"
     style="background-image: url({{ wp_get_attachment_image_url(get_field('production_img', 'options'), 'full') }});">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-12 col-lg-10 col-xl-8 text-center">
        @if(get_field('production_heading', 'options'))
          <h2 class="products-production__heading h3 mb-50 mb-lg-80">{{ get_field('production_heading', 'options') }}</h2>
        @endif
        @if(get_field('production_text', 'options'))
          <div class="products-production__text mb-80">{!! get_field('production_text', 'options') !!}</div>
        @endif
      </div>
      <div class="col-12 col-xl-10 text-center">
        @if(have_rows('production_list', 'options'))
          <div class="row custom-row products-production__wrapper">
            @while(have_rows('production_list', 'options')) <?php the_row(); ?>
              <div class="col-12 col-lg-4 mb-50 mb-lg-0 text-center custom-column">
                <div class="products-production__item">
                  <div class="mb-20">{!! wp_get_attachment_image(get_sub_field('icon'), 'full') !!}</div>
                  <h3 class="mb-20">{!! get_sub_field('heading') !!}</h3>
                  <div>{!! get_sub_field('text') !!}</div>
                </div>
              </div>
            @endwhile
          </div>
        @endif
      </div>
    </div>
  </div>
</div>

@include('partials.main-form')

@php
  $img_desktop = wp_get_attachment_image_url(get_field('products_intro_img', 'options'), 'full');
  $img_mobile  = wp_get_attachment_image_url(get_field('products_intro_img_mobile', 'options') ?: get_field('products_intro_img', 'options'), 'full');
@endphp
<style>
  .products-intro { background-image: url({{ $img_desktop }}); }
  @@media only screen and (max-width: 768px) { .products-intro { background-image: url({{ $img_mobile }}); } }
</style>

@endif
@endsection
