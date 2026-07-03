@php
  $term = is_tax('installation_category') ? get_queried_object() : null;

  $introHeading = \App\theme_field_or_term_option('products_intro_heading', $term);
  $introText = \App\theme_field_or_term_option('products_intro_text', $term);

  $introImgDesktop = \App\theme_field_or_term_option('products_intro_img', $term);
  $introImgMobile = \App\theme_field_or_term_option('products_intro_img_mobile', $term);
  if (! \App\theme_field_has_value($introImgMobile)) {
      $introImgMobile = $introImgDesktop;
  }

  $warrantyImg = \App\theme_field_or_term_option('warranty_img', $term);
  $warrantyHeading = \App\theme_field_or_term_option('warranty_heading', $term);
  $warrantyText = \App\theme_field_or_term_option('warranty_text', $term);
  $warrantyList = \App\theme_field_or_term_option('warranty_list', $term) ?: [];

  $productionImgDesktop = \App\theme_field_or_term_option('production_img', $term);
  $productionImgMobile = \App\theme_field_or_term_option('production_img_mobile', $term);
  if (! \App\theme_field_has_value($productionImgMobile)) {
      $productionImgMobile = $productionImgDesktop;
  }
  $productionHeading = \App\theme_field_or_term_option('production_heading', $term);
  $productionText = \App\theme_field_or_term_option('production_text', $term);
  $productionList = \App\theme_field_or_term_option('production_list', $term) ?: [];

  $showWarranty = \App\theme_field_has_value($warrantyImg)
      || \App\theme_field_has_value($warrantyHeading)
      || \App\theme_field_has_value($warrantyText)
      || ! empty($warrantyList);

  $showProduction = \App\theme_field_has_value($productionImgDesktop)
      || \App\theme_field_has_value($productionHeading)
      || \App\theme_field_has_value($productionText)
      || ! empty($productionList);

  $installArgs = [
      'post_type'      => 'installation',
      'post_status'    => 'publish',
      'posts_per_page' => -1,
  ];

  if ($term) {
      $installArgs['tax_query'] = [[
          'taxonomy' => 'installation_category',
          'field'    => 'term_id',
          'terms'    => $term->term_id,
      ]];
  }

  $installLoop = new WP_Query($installArgs);

  $tabArgs = $term
      ? $installArgs
      : [
          'post_type'      => 'products',
          'post_status'    => 'publish',
          'posts_per_page' => -1,
      ];

  $tabLoop = new WP_Query($tabArgs);
@endphp

<div class="products-intro d-flex">
  <div class="container mb-auto mt-auto">
    <div class="row justify-content-center">
      <div class="col-12 col-md-10 col-lg-8 text-center">
        @if($introHeading)
          <h1 class="products-intro__heading c-white h3 mb-30">{!! $introHeading !!}</h1>
        @endif
        @if($introText)
          <div class="products-intro__text fs-20 c-white">{!! $introText !!}</div>
        @endif
      </div>
    </div>
  </div>
</div>

<div class="products-list bg-purple pt-120 pb-155">
  <div class="container">
    @if($term)
      <div class="row justify-content-center">
        <div class="col-12 text-center">
          <h2 class="c-white h3 mb-50 mb-lg-80">{{ $term->name }}</h2>
        </div>
      </div>
    @endif
    <div class="row justify-content-center">
      <div class="col-12 mb-30 mb-lg-60">
        <div class="row justify-content-center">
          <div class="col-12 col-md-10 col-lg-8 col-xl-7 offset-lg-1 offset-xl-2 text-md-center products-titles">
            @php $productCounter = 0; @endphp
            <div id="installationCategories">
              @while($tabLoop->have_posts()) <?php $tabLoop->the_post(); ?>
                <div class="mb-20 text-md-center d-inline-block">
                  <div class="products-title c-white {{ $productCounter === 0 ? 'active' : '' }}" data-index="{{ $productCounter }}">
                    {!! \App\theme_esc_text(get_the_title()) !!}
                  </div>
                </div>
                @php $productCounter++; @endphp
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
          @while($installLoop->have_posts()) <?php $installLoop->the_post(); ?>
            <div>
              <div class="row mb-20">
                <div class="col-12 col-lg-6 mb-50 mb-lg-0 c-white product-galleries">
                  <div id="products-gallery" class="products-gallery">
                    @foreach(get_field('product_gallery') ?: [] as $image_id)
                      <div class="image"><div class="products-gallery__img">{!! wp_get_attachment_image($image_id, 'gallery_img') !!}</div></div>
                    @endforeach
                  </div>
                </div>
                <div class="col-12 col-lg-6 col-xl-5">
                  <h3 class="c-white mb-50">{!! \App\theme_esc_text(get_the_title()) !!}</h3>
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
          @endwhile
          <?php wp_reset_postdata(); ?>
        </div>
      </div>
    </div>
  </div>
</div>

@if($showWarranty)
  <div class="products-warranty mb-120 mt-50 mt-lg-120">
    <div class="row">
      <div class="col-12 col-lg-6 mb-50 mb-md-0 pl-0 pr-0">
        @if($warrantyImg)
          <div class="products-warranty__img">{!! wp_get_attachment_image($warrantyImg, 'full') !!}</div>
        @endif
      </div>
      <div class="col-12 col-lg-6 col-xl-5 offset-xl-1">
        <div class="products-warranty__wrapper pl-15 pr-15 pl-lg-0 pr-lg-20 pt-30 pt-lg-0 pb-30 pb-lg-0">
          @if($warrantyHeading)
            <h2 class="auto-financing__heading mb-45">{{ $warrantyHeading }}</h2>
          @endif
          @if($warrantyText)
            <div class="products-warranty__text mb-45">{!! $warrantyText !!}</div>
          @endif
          @if(! empty($warrantyList))
            <div class="products-warranty__list">
              @foreach($warrantyList as $i => $item)
                <div class="mb-30 products-warranty__list-item">
                  <span class="products-warranty__list-item--number">{{ $i + 1 }}</span>
                  <h3 class="mb-15 fw-bold">{!! $item['heading'] ?? '' !!}</h3>
                  <div>{!! $item['text'] ?? '' !!}</div>
                </div>
              @endforeach
            </div>
          @endif
        </div>
      </div>
    </div>
  </div>
@endif

@if($showProduction)
  <div class="products-production pt-50 pt-lg-120 pb-120 pb-lg-155">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-12 col-lg-10 col-xl-8 text-center">
          @if($productionHeading)
            <h2 class="products-production__heading h3 mb-50 mb-lg-80">{{ $productionHeading }}</h2>
          @endif
          @if($productionText)
            <div class="products-production__text mb-80">{!! $productionText !!}</div>
          @endif
        </div>
        @if(! empty($productionList))
          <div class="col-12 col-xl-10 text-center">
            <div class="row custom-row products-production__wrapper">
              @foreach($productionList as $item)
                <div class="col-12 col-lg-4 mb-50 mb-lg-0 text-center custom-column">
                  <div class="products-production__item">
                    @if(! empty($item['icon']))
                      <div class="mb-20">{!! wp_get_attachment_image($item['icon'], 'full') !!}</div>
                    @endif
                    <h3 class="mb-20">{!! $item['heading'] ?? '' !!}</h3>
                    <div>{!! $item['text'] ?? '' !!}</div>
                  </div>
                </div>
              @endforeach
            </div>
          </div>
        @endif
      </div>
    </div>
  </div>
@endif

@if($term && $term->slug === 'elektromobiliu-ikrovimo-stoteles')
  @include('partials.auto-form')
@elseif($term && $term->slug === 'baterijos-kaupikliai')
  @include('partials.bess-form')
@else
  @include('partials.main-form')
@endif

<style>
  .products-intro { background-image: url({{ wp_get_attachment_image_url($introImgDesktop, 'full') }}); }
  .products-production { background-image: url({{ wp_get_attachment_image_url($productionImgDesktop, 'full') }}); }
  @@media only screen and (max-width: 768px) {
    .products-intro { background-image: url({{ wp_get_attachment_image_url($introImgMobile, 'full') }}); }
    .products-production { background-image: url({{ wp_get_attachment_image_url($productionImgMobile, 'full') }}); }
  }
</style>
